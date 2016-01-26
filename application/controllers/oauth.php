<?php defined("BASEPATH") or exit("No direct script access allowed");
/**
 * Through customer authorizes to us, we will get user info and token info
 *
 * @author jake
 * @since 2014-07-30
 */

class Oauth extends Pinet_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->helper('url_helper');
        $this->load->spark('oauth2/0.4.0');
        $this->config->load('oauth2');
    }

    public function session($provider)
    {
        $this->load->library('session');
        $className = 'OAuth2_Provider_'.ucfirst($provider);
        $this->load->library(strtolower($className));
        $providerClass = new $className();
        $allowedProviders = $this->config->item('oauth2');
        $providerClass->config($allowedProviders[$provider]);
        $site_url = $this->config->item('oauth_site');
        if ( ! $this->input->get('code'))
        {
            // By sending no options it'll come back here
            $url = $providerClass->authorize(array('redirect_uri'=>$site_url . (index_page() ? index_page() . '/' : '') . 'oauth/session/' . $providerClass->name));
            redirect($url);
        }
        else
        {
            try
            {
                // Have a go at creating an access token from the code
                $token = $providerClass->access($_GET['code'],array('redirect_uri'=>$site_url . (index_page() ? index_page() . '/' : '') . 'oauth/session/' . $providerClass->name));
                // Use this object to try and get some user details (username, full name, etc)
                $user = $providerClass->get_user_info($token);
                $this->load->model('sns_account_model');
                $result = $this->sns_account_model->saveUserToken($user, $providerClass->name);
                if($result){
                    switch($result){
                        case 'NON_DIRECT':
                            if(!!$this->session->userdata('sns_settings_url'))
                                redirect($this->session->userdata('sns_settings_url'), 'refresh');
                            break;
                        default:
                            $this->sns_account_model->snsLogin($user->openid, $providerClass->name);
                            $url = 'http://' . $this->session->userdata('gateway_ip') . ':' . $this->session->userdata('gateway_port') . '/pinet/auth?token=' . $result;
                            if($this->session->userdata('url')){
                                $url .= '&url=' . $this->session->userdata('url');
                            }
                            redirect($url, 'refresh');
                            break;
                    }
                }else{
                    $this->log();
                    redirect();
                }
            } catch (OAuth2_Exception $e)
            {
                show_error('That didnt work: '.$e);
            }
        }
    }

    public function loop(){
        $this->load->helper('common');
        $this->load->model(array('sns_operation_queue_model', 'sns_operation_configuration_model'));
        $retry = $this->config->item('retry_count');
        $master = $this->sns_operation_configuration_model->getMasterInfo();
        $queue = $this->sns_operation_queue_model->getActiveQueue();
        $done = array();
        $error = array();
        $failed = array();
        $provider = '';
        $provider_class = null;
        foreach($queue as $row){
            if($row['provider'] != $provider){
                $provider = $row['provider'];
                $class_name = 'OAuth2_Provider_'.ucfirst($row['provider']);
                $this->load->library(strtolower($class_name));
                $provider_class = new $class_name();
                $allowedProviders = $this->config->item('oauth2');
                $provider_class->config($allowedProviders[$provider]);
            }
            $master_info = $master[$row['config_id']];
            $info = array(
                'type' => $master_info['type'],
                'access_token' => $row['token'],
                'openid' => $row['uid'],//customer
                'uid' => $master_info['uid'],//gateway master
                'screen_name' => $master_info['nickname'],
                'content' => $master_info['content'],
                'poi_id' => $master_info['poi_id'],
                'latitude' => $master_info['latitude'],
                'longitude' => $master_info['longitude']
            );
            $result = $this->operation($provider_class, $info);
            if($result){
                $done[] = $row['id'];
            }else{
                if((int)$row['retry'] >= $retry - 1){
                    $failed[] = $row['id'];
                }else{
                    $error[] = $row['id'];
                }
            }
        }
        if($done)
            $this->sns_operation_queue_model->updateStatus($done, SNS_Operation_Queue_Model::STATUS_DONE);
        if($error)
            $this->sns_operation_queue_model->updateStatus($error, SNS_Operation_Queue_Model::STATUS_ERROR);
        if($failed)
            $this->sns_operation_queue_model->updateStatus($failed, SNS_Operation_Queue_Model::STATUS_FAILED);
    }

    private function operation($provider_class, $info){
        $result = TRUE;
        switch($info['type']){
            case SNS_Operation_Configuration_Model::NONE:
                break;
            case SNS_Operation_Configuration_Model::FOLLOW:
                $result = $provider_class->follow($info);
                break;
            case SNS_Operation_Configuration_Model::TWEET:
                $result = $provider_class->message($info);
                break;
            case SNS_Operation_Configuration_Model::CHECKIN:
                $result = $provider_class->check_in($info);
                break;
        }
        return $result;
    }
}

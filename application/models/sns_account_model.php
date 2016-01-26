<?php defined('BASEPATH') or exit('No direct script access allowed');

class SNS_Account_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('sns_accounts');
        $this->load->model(array('user_model', 'gateway_model', 'device_model', 'group_model', 'token_model', 'sns_operation_queue_model', 'sns_operation_configuration_model'));
        $this->load->library('session');
	}

    /**
     * After user uses Oauth to login, save user's device, sns account and token information
     * @param $oResponse    Oauth response data
     * @param $sProvider    kind of Oauth
     * @return bool
     * @author jake
     * @since 2014-07-31
     */
    private function _saveUserToken($oResponse, $sProvider, $serial, $mac, $user_id){
        $CI = & get_instance();
        $oSnsAccount = copy_new($oResponse, $sProvider . '_Provider');
        if(!$oSnsAccount->checkResponse($oResponse)){
            $CI->log('Error return: '.json_encode($oResponse));
            return $this->_return_key(FALSE);
        }
        $oGateway = $this->gateway_model->getBySerial($serial);
        $master = $user_id ? true : false;
        if(!$oGateway){
            $CI->log('Missing Gateway: '.$serial);
            return $this->_return_key($master);
        }
        $aResponse = get_object_vars($oResponse);
        $device = $this->device_model->getByMac($mac);
        $info= array();
        if($device){
            $info['device_id'] = $device->id;
            $oSnsAccount = $this->getBySnsAccount($aResponse['openid'] , $sProvider);
            if($oSnsAccount)
                $info['sns_account_id'] = $oSnsAccount->id;
            else{
                $info = $this->addNewSnsAccount($oResponse, $serial, $mac, $sProvider, $master, $device->owner_id);
            }
        }else{
            $info = $this->addNewSnsAccount($oResponse, $serial, $mac, $sProvider, $master, $user_id);
        }
        $datetime = new DateTime();
        $data = array(
            'serial' => $serial,
            'mac' => $mac,
            'timestamp' => $datetime->format('Y-m-d H:i:s'));
        $token = $this->token_model->tokenString($data);
        $sns_token_id = $this->myinsert('sns_tokens', array(
            'sns_account_id'=>$info['sns_account_id'],
            'device_id'=>$info['device_id'],
            'gateway_id'=>$oGateway->id,
            'token'=>$aResponse['access_token'],
            'expires'=>$aResponse['expires'],
            'refresh_token'=>isset($aResponse['refresh_token']) ? $aResponse['refresh_token'] : ''
        ));
        $token_id = $this->myinsert('tokens', array(
            'device_id' => $info['device_id'],
            'gateway_id' => $oGateway->id,
            'ip' => ip2long($_SERVER['REMOTE_ADDR']),
            'token' => $token,
            'timestamp' => $datetime->format('Y-m-d H:i:s')
        ));
        $record_id = $this->myinsert('sns_login_records', array(
            'snsaccount_id' => $info['sns_account_id'],
            'gateway_id' => $oGateway->id,
            'device_id' => $info['device_id'],
            'function' => 'login',
            'effect' => 1
        ));
        if($master && $user_id){
            $this->sns_operation_configuration_model->getOrCreate(array(
                'platform'=>$sProvider,
                'user_id'=>$user_id,
                'status'=>1
            ));
        }
        if($sns_token_id && $token_id && $record_id){
            if(!$master){
                $CI->log('Add new queue from ' . $sProvider . ' for '.$sns_token_id);
                $this->sns_operation_queue_model->saveRecord($sns_token_id, $sProvider, $serial);
            }
            return $this->_return_key($master, $token);
        }
        return $this->_return_key($master);
    }

    public function saveUserToken($oResponse, $sProvider){
        $serial = $this->session->userdata('serial');
        $mac = $this->session->userdata('serial');
        $user_id = $this->user_model->getLoginUserID();
        $result = '';
        if($user_id && !($serial&&$mac)){
            $gateways = $this->gateway_model->getGateways($user_id);
            foreach($gateways as $gateway){
                $result = $this->_saveUserToken($oResponse,$sProvider, $gateway->serial, $gateway->mac, $user_id);
            }
        }else{
            $result = $this->_saveUserToken($oResponse,$sProvider, $serial, $mac, $user_id);
        }
        return $result;
    }

    private function _return_key($master, $token=''){
        if($master)
            return 'NON_DIRECT';
        else
            return $token;
    }

    /**
     * Search supported SNS Account if exist, return object, otherwise null
     * @param $sSnsAccount
     * @param $sProvider
     * @return object
     * @author jake
     * @since 2014-07-31
     */
    public function getBySnsAccount($sSnsAccount, $sProvider){
        $this->result_mode = 'object';
        return $this->get(array('uid'=>$sSnsAccount, 'provider'=>$sProvider));
    }

    /**
     * While customer uses SNS Account to login with gateway at first time
     * @param $oResponse    Oauth response data
     * @param $serial       gateway's serial number
     * @param $sProvider    kind of Oauth
     * @return array
     * @author jake
     * @since 2014-07-31
     */
    public function addNewSnsAccount($oResponse, $serial, $mac, $sProvider, $master=FALSE, $user_id=''){
        $CI = & get_instance();
        $info = array();
        $group = $this->group_model->getUserGroup();
        $group_id = $group->id;
        $oSnsAccount = copy_new($oResponse, $sProvider . '_Provider');
        $aResponse = get_object_vars($oResponse);
        $aSnsAccount = $oSnsAccount->convertToBasic($aResponse, $oResponse);
        $user_info = array(
            'email_address' => $aSnsAccount['uid'] . '@pinet.co',
            'password' => 'password',
            'username' => substr($aSnsAccount['uid'], 0, 20),
            'user_type' => -1,
            'group_id' => $group_id,
            'name' => $aSnsAccount['nickname'],
            'mobile' => '',
            'sex' => $aSnsAccount['gender'],
            'contact_name' => $aSnsAccount['nickname'],
            'contact_country' => '',
            'contact_province' => isset($oResponse->province)?$oResponse->province:'',
            'contact_city' => isset($oResponse->city)?$oResponse->city:'',
            'contact_street' => '',
            'contact_postalcode' => '',
            'contact_profile' => ''
        );
        if(!$master)
            $user_id = $this->user_model->register($user_info);
        if($master && !$user_id){
            $user_id = $this->user_model->getUserByName($this->session->userdata('email_address'));
        }
        $CI->log('Add new account from '.$sProvider. ' for '.$user_id);
        $aSnsAccount['user_id'] = $user_id;
        $info['sns_account_id'] = $this->insert($aSnsAccount);
        $device = $this->device_model->getByMac($mac);
        if($device){
            $device->owner_id = $user_id;
            $this->device_model->update($device->id, obj2array($device));
            $info['device_id'] = $device->id;
        }else{
            $device = $this->device_model->getOrCreate($serial, $user_id, $mac);
            $info['device_id'] = $device->id;
        }
        return $info;
    }

    public function getIdByDeviceId($device_id){
        $this->db->select('sns_accounts.id');
        $this->db->from('devices');
        $this->db->join('sns_accounts', 'sns_accounts.user_id=devices.owner_id', 'inner');
        $this->db->where('devices.id', $device_id);
        $data = $this->db->get()->row();
        if($data)
            return $data->id;
        else
            return 0;
    }

    public function snsLogin($uid, $sProvider){
        $sns_account = $this->getBySnsAccount($uid, $sProvider);
        if($sns_account){
            $user = $this->user_model->load($sns_account->user_id);
            if($user)
                $this->user_model->login($user->email_address, $user->password);
        }
    }
}


class Qq_Provider{
    public function convertToBasic($aSnsAccount, $oResponse){
        $aSnsAccount['uid'] = $aSnsAccount['openid'];
        $aSnsAccount['gender'] = $aSnsAccount['gender'] == '男' ? 'm' : 'f';
        $aSnsAccount['profile_image_url'] = $aSnsAccount['figureurl_qq_1'];
        $aSnsAccount['json_response'] = json_encode($oResponse);
        return $aSnsAccount;
    }

    public function checkResponse($oResponse){
        return $oResponse->ret == 0;
    }
}

class Wechat_Provider{
    public function convertToBasic($aSnsAccount, $oResponse){
        $aSnsAccount['uid'] = $aSnsAccount['openid'];
        switch($aSnsAccount['sex']){
            case 0:
                $aSnsAccount['gender'] = 'n';
                break;
            case 1:
                $aSnsAccount['gender'] = 'm';
                break;
            case 2:
                $aSnsAccount['gender'] = 'f';
                break;
        }
        $aSnsAccount['profile_image_url'] = $aSnsAccount['headimgurl'];
        $aSnsAccount['json_response'] = json_encode($oResponse);
        return $aSnsAccount;
    }

    public function checkResponse($oResponse){
        return !isset($oResponse->errcode);
    }
}

class Weibo_Provider{
    public function convertToBasic($aSnsAccount, $oResponse){
        unset($aSnsAccount['id']);//remove, if not, it will insert to sns_account
        $aSnsAccount['uid'] = $aSnsAccount['openid'];
        $aSnsAccount['nickname'] = $aSnsAccount['screen_name'];
        $aSnsAccount['json_response'] = json_encode($oResponse);
        return $aSnsAccount;
    }

    public function checkResponse($oResponse){
        return !isset($oResponse->error_code);
    }
}

class Yixin_Provider{
    public function convertToBasic($aSnsAccount, $oResponse){
        $aSnsAccount['uid'] = $aSnsAccount['openid'];
        switch($aSnsAccount['sex']){
            case 1:
                $aSnsAccount['gender'] = 'm';
                break;
            case 2:
                $aSnsAccount['gender'] = 'f';
                break;
            case 0:
            default:
                $aSnsAccount['gender'] = 'n';
                break;
        }
        $aSnsAccount['json_response'] = json_encode($oResponse);
        return $aSnsAccount;
    }

    public function checkResponse($oResponse){
        return !isset($oResponse->errcode) || $oResponse->subscribe;
    }
}

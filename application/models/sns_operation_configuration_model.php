<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SNS_Operation_Configuration_Model extends Pinet_Model {
    const NONE=0;
    const FOLLOW=1;
    const TWEET=2;
    const CHECKIN=3;

    public function __construct() {
        parent::__construct('sns_operation_configurations');
    }

    public function getOrCreate($data) {
        $this->result_mode='object';
        $sns_config = $this->get(array(
            'platform'=>$data['platform'],
            'user_id'=>$data['user_id']
        ));
        if($sns_config)
            return $sns_config;

        $id = $this->insert($data);
        return $this->load($id);
    }

    public function getMasterInfo(){
        $this->db->select('soc.*,sa.uid,sa.nickname,g.longitude,g.latitude');
        $this->db->from('sns_operation_configurations as soc');
        $this->db->join('sns_accounts sa', 'sa.user_id=soc.user_id and sa.provider=soc.platform', 'inner');
        $this->db->join('gateways g', 'g.owner_id=soc.user_id', 'inner');
        $data = $this->db->get()->result_array();
        $info = array();
        foreach($data as $row){
            $info[$row['id']] = $row;
        }
        return $info;
    }

    public function getSnsSettings($user_id, $provider = ''){
        $this->db->select('soc.id, sa.uid,soc.type,soc.poi_id,soc.status,soc.content,sa.provider');
        $this->db->from('sns_operation_configurations as soc');
        $this->db->join('sns_accounts sa', 'sa.user_id=soc.user_id and sa.provider=soc.platform', 'inner');
        $this->db->where('soc.user_id', $user_id);
        if($provider)
            $this->db->where('sa.provider', $provider);
        return $this->db->get()->result();
    }

    public function showSnsSettings($user_id){
        $info = new stdClass();
        $info->weibo_status=0;
        $info->wechat_status=0;
        $info->qq_status=0;
        $info->yixin_status=0;
        $info->weibo_snsuid='';
        $info->qq_snsuid='';
        $data = $this->getSnsSettings($user_id);
        foreach($data as $config){
            $info->{$config->provider.'_snsuid'} = $config->uid;
            if($config->content){
                $content = unserialize($config->content);
                $info->{$config->provider.'_message_content'} = $content['text'];
                if(isset($content['img']))
                    $info->{$config->provider.'_message_image'} = $content['img']['path'];
            }
            switch($config->type){
                case '2':
                    $info->{$config->provider.'_message'} = $config->type;
                    break;
                case '3':
                    $info->{$config->provider.'_checkin'} = $config->type;
                    break;
            }
            $info->{$config->provider.'_status'} = $config->status;
        }
        $data = $this->getNoOauthSns($user_id);
        foreach($data as $config){
            $info->{$config->platform.'_status'} = $config->status;
        }
        return $info;
    }

    public function updateSnsSettings($user_id, $data){
        $settings = $this->getSnsSettings($user_id, $data['oauth_type']);
        if(count($settings)){
            $setting = $settings[0];
            $id = $setting->id;
            $setting = obj2array($setting);
            $setting['type'] = $data['status'];
            if($data['poi_id'])
                $setting['poi_id']=$data['poi_id'];
            if($data['status']>=1)
                $data['status']=1;
            $setting['status'] = $data['status'];
            $sns_config['text'] = $data[$data['oauth_type'].'_message_content'];
            if(isset($data[$data['oauth_type'].'_picture'])){
                $path = 'static/uploads/'.$data[$data['oauth_type'].'_picture'];
                $file = pathinfo($path);
                $name = $file['filename'];
                $ext = $file['extension'];
                $sns_config['img'] = array(
                    'path'=>$path,
                    'name'=>$name.'.'.$ext,
                    'mime'=>'image/'.$ext
                );
            }
            $setting['content']=serialize($sns_config);
            return $this->update($id, $setting);
        }
        return 0;
    }

    public function saveNoOauthSns($user_id, $provider, $status){
        $this->result_mode='object';
        $sns_config = $this->get(array(
            'user_id'=>$user_id,
            'platform'=>$provider
        ));
        if($sns_config){
            return $this->update($sns_config->id, array('status'=>$status));
        }
        return $this->insert(array(
            'platform'=>$provider,
            'user_id'=>$user_id,
            'type'=>'0',
            'status'=>$status
        ));
    }

    public function getNoOauthSns($user_id){
        $this->result_mode='object';
        return $this->get_all('user_id', $user_id);
    }

    public function saveSnsSettings($user_id, $data){
        if(in_array($data['oauth_type'], array('qq','weibo'))){
            return $this->updateSnsSettings($user_id, $data);
        }elseif(in_array($data['oauth_type'], array('wechat','yixin'))){
            return $this->saveNoOauthSns($user_id, $data['oauth_type'], $data['status']);
        }
    }
}
<?php defined('BASEPATH') or exit('No direct script access allowed');

class Portal_Page_Model extends Pinet_Model{
	public function __construct(){
		parent::__construct('portal_pages');
	}

    public function getPortalSettings($user_id){
        $this->result_mode='object';
        $settings = $this->get('user_id', $user_id);
        if($settings)
            return unserialize($settings->page_settings);
        return array();
    }

    public function addPortalSettings($user_id, $values){
        $data = array(
            'company'=>$values['company'],
            'contents'=>$values['contents'],
            'introduction'=>$values['introduction'],
            'activities'=>$this->_buildActivities($values),
            'login_wechat'=> $values['login_wechat'],
            'login_weibo'=> $values['login_weibo'],
            'login_qq'=> $values['login_qq'],
            'login_yixin'=> $values['login_yixin']
        );
        if($values['logo'])
            $data['logo']=$values['logo'];
        if($values['photo'])
            $data['photo']=$values['photo'];
        else
            unset($values['photo']);
        $data = array_merge($values, $data);
        $this->result_mode='object';
        $settings = $this->get('user_id', $user_id);
        if($settings){
            return $this->update($settings->id, array('page_settings'=>serialize(array_merge(unserialize($settings->page_settings), $data))));
        }
        return $this->insert(array(
            'user_id'=>$user_id,
            'page_settings'=>serialize($data)
        ));
    }

    private function _buildActivities($values){
        $activities=array();
        for($i=1;$i<6;$i++){
            if($values['photo'.$i]){
                $data = array(
                    'photo'=>$values['photo'.$i],
                    'title'=>$values['title'.$i],
                    'contents'=>$values['contents'.$i]
                );
                $activities[] = $data;
            }
        }
        return $activities;
    }
}
<?php defined("BASEPATH") or exit("No direct script access allowed");

class IBox extends Pinet_Controller {

    public $title = 'iBox Status';
    public $messages = 'iBox Status';

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        $this->load->library(array('datatable', 'navigation', 'session'));
        $this->load->model(array('gateway_model', 'device_model', 'group_user_model', 'operation_model', 'blacklist_model', 'user_model', 'group_model'));
        $this->default_model = array('index'=>$this->gateway_model, 'ibox_realtime_status'=>$this->gateway_model, 'user'=>$this->user_model);
        $this->jquery_ui();
        $this->jquery_pinet();
    }

	public function index_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if($this->group_user_model->isPartner($user_id)){
            $user_condition = ' g.owner_id in (select partner_user_id from $$partner_users as pu where pu.user_id='.$user_id.')';
        }elseif(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " u.id='".$user_id."' ";
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        if($user_condition){
            $pagination->customized_query->query .= ' and '.$user_condition;
            $pagination->customized_query->dbtotal_count_query .= ' and '.$user_condition;
            $pagination->customized_query->total_count_query .= ' and '.$user_condition;
        }
        if($search_condition){
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
        }
		return $pagination;
	}

    public function index() {
        $this->ibox_realtime_status();
    }

    public function ibox_realtime_status_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " u.id='".$user_id."' ";
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        if($user_condition){
            $pagination->customized_query->query .= ' and '.$user_condition;
            $pagination->customized_query->dbtotal_count_query .= ' and '.$user_condition;
            $pagination->customized_query->total_count_query .= ' and '.$user_condition;
        }
        if($search_condition){
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
        }
        return $pagination;
    }

    public function ibox_realtime_status(){
        if(!isset($_POST['__nouse__'])){
            if($this->_operation(explode(',', $this->input->post('ids')), $this->input->post('operation_type'))){
                $this->addAlert(array(
                    'type' => 'info',
                    'message' => lang('Operate successfully!')
                ));
            }
        }
        $user_id = $this->user_model->getLoginUserID();
        $is_admin = $this->group_user_model->isAdmin($user_id);
        $this->init_responsive();
        $this->less('ibox/ibox_realtime_status_css');
        $this->render('ibox/ibox_realtime_status', array('is_admin'=>$is_admin));
    }

    public function user_datatable_customize($pagination) {
        $search_condition='';
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        $args = get_controller_args();
        if(count($args)){
            $pagination->customized_query->query .= " and d.gateway_id='".$args[0]."'";
            $pagination->customized_query->dbtotal_count_query .= " and d.gateway_id='".$args[0]."'";
            $pagination->customized_query->total_count_query .= " and d.gateway_id='".$args[0]."'";
        }
        if($search_condition){
            $pagination->customized_query->query .= " and (".$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= " and (".$search_condition.")";
            $pagination->customized_query->total_count_query .= " and (".$search_condition.")";
        }
        ci_log('The pagination is ', $pagination);
        return $pagination;
    }

    public function user_form(){
        $args = get_controller_args();
        if(count($args)){
            $this->blacklist_model->add2Bakcklist($args[0], explode(',', $this->input->post('ids')));
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Add the user to blacklist successfully!')
            ));
        }
        $this->init_responsive();
        $this->less('ibox/user_css');
        $this->render('ibox/user');
    }

    public function user(){
        $this->init_responsive();
        $this->less('ibox/user_css');
        $this->render('ibox/user');
    }

    public function register(){
        $gateway_info = $this->input->post();
        if($this->user_model->isLoggedIn()){
            $gateway_info['owner_id'] = $this->user_model->getLoginUserID();
            $this->gateway_model->register($gateway_info);
            redirect(site_url('account/index'));
        }else{
            $gateway_id = $this->gateway_model->register($gateway_info);
            $this->session->set_userdata('gateway_id', $gateway_id);
            redirect(site_url('account/login'));
        }
    }

    private function _operation($ids, $type){
        switch(strtoupper($type)){
            case 'ACTIVE':
                return $this->gateway_model->operateStatus($ids);
                break;
            case 'INACTIVE':
                return $this->gateway_model->operateStatus($ids, 'INACTIVE');
                break;
            case 'UPDATE':
                return $this->operation_model->addOperation($ids, array('operation'=> 'update'));
                break;
            case 'RESTART':
                return $this->operation_model->addOperation($ids, array('operation'=> 'restart'));
                break;
        }
    }
}

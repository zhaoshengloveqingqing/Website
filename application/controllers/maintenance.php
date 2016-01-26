<?php defined("BASEPATH") or exit("No direct script access allowed");

class Maintenance extends Pinet_Controller {

    public $title = 'iBox Maintenance';
    public $messages = 'iBox Maintenance';

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('user_model');
        $this->load->library(array('datatable', 'listview', 'navigation'));
        $this->load->model(array('gateway_model', 'user_model', 'group_user_model', 'config_model', 'operation_model', 'crontab_model', 'syslog_model'));
        $this->default_model = array('index'=>$this->user_model, 'ibox_app'=>$this->config_model, 'ibox_update'=>$this->gateway_model, 'task_scheduler'=>$this->crontab_model, 'ibox_activation'=>$this->user_model);
        $this->jquery_ui();
        $this->jquery_pinet();
    }

    public function index_datatable_customize($pagination) {
        $search_condition='';
        $user_condition='';
        $user_id = $this->user_model->getLoginUserID();
        if($this->group_user_model->isPartner($user_id)){
            $user_condition = ' and g.owner_id in (select partner_user_id from $$partner_users as pu where pu.user_id='.$user_id.')';
        }elseif(!$this->group_user_model->isAdmin($user_id))
            $user_condition = " and g.owner_id='".$user_id."' ";
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        if($user_condition){
            $pagination->customized_query->query .= $user_condition;
            $pagination->customized_query->dbtotal_count_query .= $user_condition;
            $pagination->customized_query->total_count_query .= $user_condition;
        }
        if($search_condition){
            $pagination->customized_query->query .= " and (".$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= " and (".$search_condition.")";
            $pagination->customized_query->total_count_query .= " and (".$search_condition.")";
        }
        return $pagination;
    }

    public function index_form() {
        if($this->_operation(explode(',', $this->input->post('ids')), $this->input->post('operation_type'))){
            if(strtoupper($this->input->post('operation_type')) == 'LOG')
                return;
            $this->addAlert(array(
                'type' => 'info',
                'message' => lang('Operate successfully!')
            ));
        }
        $this->init_responsive();
        $this->less('maintenance/index_css');
        $this->render('maintenance/index');
    }

    public function index() {
        $this->init_responsive();
        $this->less('maintenance/index_css');
        $this->render('maintenance/index');
    }

    public function ibox_app_datatable_customize($pagination) {
        $search_condition='';
        $gateway_id=0;
        $args = get_controller_args();
        if(count($args))
            $gateway_id = $args[0];
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        $pagination->customized_query->query .= " and c.gateway_id='".$gateway_id."' ";
        $pagination->customized_query->dbtotal_count_query .= " and c.gateway_id='".$gateway_id."' ";
        $pagination->customized_query->total_count_query .= " and c.gateway_id='".$gateway_id."' ";
        if($search_condition){
            $pagination->customized_query->query .= " and (".$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= " and (".$search_condition.")";
            $pagination->customized_query->total_count_query .= " and (".$search_condition.")";
        }
        return $pagination;
    }

    public function ibox_app($gateway_id){
        $this->init_responsive();
        $this->load->library(array('listview'));
        $this->jquery_listview();
        $this->less('maintenance/ibox_app_css');
        $this->render('maintenance/ibox_app', array('maintenance_menus' => $this->_build_menu($gateway_id)));
    }

    public function task_scheduler($gateway_id){
        $this->init_responsive();
        $this->jquery_listview();
        $this->less('maintenance/task_scheduler_css');
        $this->render('maintenance/task_scheduler', array('maintenance_menus' => $this->_build_menu($gateway_id), 'new_task_url'=>site_url('maintenance/new_scheduler/'.$gateway_id)));
    }

    public function new_scheduler_form($gateway_id){
        $this->crontab_model->addCrontab($gateway_id, $this->input->post());
        $this->addAlert(array(
            'type' => 'info',
            'message' => lang('Add successfully!')
        ));
        redirect(site_url('maintenance/task_scheduler/'.$gateway_id));
    }

    public function new_scheduler($gateway_id){
        $url = 'maintenance/task_scheduler/'.$gateway_id;
        $this->init_responsive();
        $this->jquery_listview();
        $this->less('maintenance/new_scheduler_css');
        $this->render('maintenance/new_scheduler', array('maintenance_menus' => $this->_build_menu($gateway_id), 'goback_url'=>site_url($url)));
    }

    public function show_log($gateway_id){
        $this->init_responsive();
        $this->less('maintenance/show_log_css');
        $this->render('maintenance/show_log', array('logs'=>$this->syslog_model->getLogs($gateway_id)));
    }

    private function _operation($ids, $type){
        switch(strtoupper($type)){
            case 'UPDATE':
                return $this->operation_model->addOperation($ids, array('operation'=> 'update'));
                break;
            case 'RESTART':
                return $this->operation_model->addOperation($ids, array('operation'=> 'restart'));
                break;
            case 'LOG':
                $logs = $this->syslog_model->getLogs($ids);
                Header("Content-type: application/octet-stream");
                Header("Accept-Ranges: bytes");
                Header("Accept-Length: ".strlen($logs));
                Header("Content-Disposition: attachment; filename=ibox.log");
                echo $logs;
                return true;
                break;
        }
    }

    private function _build_menu($gateway_id){
        return array(
            'ibox_app' => copy_new(array(
                'controller' => 'Maintenance',
                'method' => 'ibox_app',
                'args' => $gateway_id,
                'label' => lang('iBox App Settings')
            ), 'Action'),
            'task_scheduler' => copy_new(array(
                'controller' => 'Maintenance',
                'method' => 'task_scheduler',
                'args' => $gateway_id,
                'label' => lang('Task Scheduler')
            ), 'Action')
        );
    }
}

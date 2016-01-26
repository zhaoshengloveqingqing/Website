<?php defined("BASEPATH") or exit("No direct script access allowed");

class Admin extends Pinet_Controller {

	public $title = 'System Management';
    public $messages = 'System Management';

    public function __construct() {
        parent::__construct();
        $this->load->library(array('datatable', 'navigation'));
        $this->load->model(array('config_model', 'gateway_model', 'device_model'));
        $this->default_model = array('index'=>$this->device_model,'user'=>$this->device_model,'ibox'=>$this->gateway_model);
        $this->jquery_ui();
        $this->jquery_pinet();        
    }

    public function index_datatable_customize($pagination) {
        $search_condition='';
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        if($search_condition){
            $pagination->customized_query->query .= ' where ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' where ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' where ('.$search_condition.")";
        }
        return $pagination;
    }

    public function index() {
    	$this->user();
    }

    public function user_datatable_customize($pagination) {
        $search_condition='';
        foreach($pagination->where as $column=>$search){
            if($search_condition)
                $search_condition .= ' or '.$column." like '%".$search."%'";
            else
                $search_condition .= $column." like '%".$search."%'";
        }
        if($search_condition){
            $pagination->customized_query->query .= ' where ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' where ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' where ('.$search_condition.")";
        }
        return $pagination;
    }

    public function user(){    	
        $this->init_responsive();
        $this->less('admin/user_css');
        $this->render('admin/user');
    }

    public function ibox(){
        $this->init_responsive();
        $this->less('admin/ibox_css');
        $this->render('admin/ibox');
    }

	public function login() {
		$this->init_responsive();
		$this->jqBootstrapValidation();		
		$this->less('admin/login');
		$this->render('admin/login');
	}

}
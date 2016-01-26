<?php defined("BASEPATH") or exit("No direct script access allowed");

class Network extends Pinet_Controller {

    public $title = 'System Management';
    public $messages = 'System Management';

    public function __construct() {
        parent::__construct();
        $this->load->library(array('datatable', 'navigation'));
        $this->load->model(array('config_model', 'gateway_model'));
        $this->default_model = array('index'=>$this->gateway_model);
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
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
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
            $pagination->customized_query->query .= ' and ('.$search_condition.")";
            $pagination->customized_query->dbtotal_count_query .= ' and ('.$search_condition.")";
            $pagination->customized_query->total_count_query .= ' and ('.$search_condition.")";
        }
        return $pagination;
    }

    public function user(){    	
        $this->init_responsive();
        $this->less('system/user_css');
        $this->render('system/user');
    }

    public function ibox(){
	$this->init_responsive();
	$this->less('system/ibox_css');
	$this->render('system/ibox');
    }
}
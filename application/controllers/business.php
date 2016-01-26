<?php defined("BASEPATH") or exit("No direct script access allowed");

class Business extends Pinet_Controller {

    public $title = 'Business Management';
    public $messages = 'Business Management';

    public function __construct() {
        parent::__construct();
        $this->load->library(array('report', 'navigation', 'session'));
        $this->load->model(array('gateway_model', 'user_model'));
        $this->init_responsive();
        $this->jquery_ui();
        $this->datepicker();
        $this->highcharts();
        $this->jquery_pinet();
        $js = <<<EOT
var clock; 

function showReport(mode){
    clearTimeout(clock);
    if(mode)
            $('.form-horizontal').find("input[name=mode]").val(mode);
    clock = setTimeout(function(){
      $('.form-horizontal').submit();
    }, 300);
}

$(function(){
    var datepicker = $('#datepicker').datepicker({
        language: "zh-CN",
        format: "yyyy-mm-dd"
    });
    datepicker.on('changeDate', function(){
        showReport("");
    });

    $("#month-btn").on("click", function(){
      showReport("month");
    });  

    $("#week-btn").on("click", function(){
      showReport("week");
    });

    $("#day-btn").on("click", function(){
      showReport("day");
    });                     
})
EOT;
        $this->initJs($js);
    }

    public function index(){
        $this->ibox_status_summary();
    }

    public function ibox_status_summary(){
        $begin = null;
        $end = null;
        $mode = 'day';
        $beginTime = new DateTime();
        $beginTime->sub(DateInterval::createFromDateString('1 month'));
        $endTime = new DateTime();
        if(!isset($_POST['__nouse__'])){
            $begin = $this->input->post('begin');
            $end = $this->input->post('end');
            $mode = $this->input->post('mode');
            switch($mode){
                case 'month':
                    $this->setState('month', 'status');
                    break;
                case 'week':
                    $this->setState('week', 'status');
                    break;
            }
            $beginTime = parse_datetime($begin, $beginTime);
            $endTime = parse_datetime($end, $endTime);
        }
        $heart_beat_rate = get_ci_config('heart_beat_rate');
        $diff = ($endTime->getTimestamp()-$beginTime->getTimestamp())/60/$heart_beat_rate;
        $user_id = $this->user_model->getLoginUserID();
        $this->jquery_mousewheel();
        $this->less('business/ibox_status_summary_css');
        $this->render('business/ibox_status_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode), 'args'=>array($user_id), 'online_args'=>array($heart_beat_rate, $diff, $user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    public function ibox_login_summary_form(){
        $user_id = $this->user_model->getLoginUserID();
        $begin = $this->input->post('begin');
        $end = $this->input->post('end');
        $mode = $this->input->post('mode');
        switch($mode){
            case 'month':
                $this->setState('month', 'login');
                break;
            case 'week':
                $this->setState('week', 'login');
                break;
        }
        $this->jquery_mousewheel();
        $this->less('business/ibox_login_summary_css');
        $this->render('business/ibox_login_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode),'args'=>array($user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    public function ibox_login_summary(){
        $begin = null;
        $end = null;
        $mode = 'day';
        $user_id = $this->user_model->getLoginUserID();
        $this->jquery_mousewheel();
        $this->less('business/ibox_login_summary_css');
        $this->render('business/ibox_login_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode),'args'=>array($user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    public function visitor_loyalties_summary_form(){
        $user_id = $this->user_model->getLoginUserID();
        $begin = $this->input->post('begin');
        $end = $this->input->post('end');
        $mode = $this->input->post('mode');
        switch($mode){
            case 'month':
                $this->setState('month', 'visitor');
                break;
            case 'week':
                $this->setState('week', 'visitor');
                break;
        }
        $this->jquery_mousewheel();
        $this->less('business/visitor_loyalties_summary_css');
        $this->render('business/visitor_loyalties_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode),'args'=>array($user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    public function visitor_loyalties_summary(){
        $begin = null;
        $end = null;
        $mode = 'day';
        $user_id = $this->user_model->getLoginUserID();
        $this->jquery_mousewheel();
        $this->less('business/visitor_loyalties_summary_css');
        $this->render('business/visitor_loyalties_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode),'args'=>array($user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    public function repeating_visitors_summary_form(){
        $user_id = $this->user_model->getLoginUserID();
        $begin = $this->input->post('begin');
        $end = $this->input->post('end');
        $mode = $this->input->post('mode');
        switch($mode){
            case 'month':
                $this->setState('month', 'repeating');
                break;
            case 'week':
                $this->setState('week', 'repeating');
                break;
        }
        $this->jquery_mousewheel();
        $this->less('business/repeating_visitors_summary_css');
        $this->render('business/repeating_visitors_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode),'args'=>array($user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    public function repeating_visitors_summary(){
        $begin = null;
        $end = null;
        $mode = 'day';
        $user_id = $this->user_model->getLoginUserID();
        $this->jquery_mousewheel();
        $this->less('business/repeating_visitors_summary_css');
        $this->render('business/repeating_visitors_summary', array('form_data'=> $this->_buildSearches($begin, $end, $mode),'args'=>array($user_id), 'begin'=>$begin, 'end'=>$end, 'mode'=>$mode));
    }

    private function _buildSearches($begin, $end, $mode){
        $searches = new stdClass();
        $searches->begin = $begin;
        $searches->end = $end;
        $searches->mode = $mode;
        return $searches;
    }
}

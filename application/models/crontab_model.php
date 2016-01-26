<?php defined('BASEPATH') or exit('No direct script access allowed');

class Crontab_Model extends Pinet_Model{
	public function __construct(){
		parent::__construct('crontabs');
	}

    public function addCrontab($gateway_id, $values){
        if(($values['month'] || $values['day'] || $values['hour'] || $values['minute'] || $values['interval']) && $values['task']){
            if(strlen(trim($values['interval']))>0)
                $values['interval'] = substr(trim($values['interval']),1);
            if(!$values['month'])
                $values['month'] = '*';
            if(!$values['day'])
                $values['day'] = '*';
            if(!$values['hour'])
                $values['hour'] = '*';
            if(!$values['minute'])
                $values['minute'] = '*';
            if(!$values['interval'])
                $values['interval'] = '*';
            $this->insert(array(
                'gateway_id'=>$gateway_id,
                'month'=>$values['month'],
                'day'=>$values['day'],
                'hour'=>$values['hour'],
                'minute'=>$values['minute'],
                'week'=>$values['interval'],
                'task'=>$values['task'],
                'status'=>'ON'
            ));
            $this->config_model->changeItem($gateway_id, 'crontabs', $this->_buildCrontab($gateway_id));
        }
    }

    public function switchCrontab($id, $status){
        $this->update($id, array('status'=>$status));
    }

    public function deleteCrontab($ids){
        $this->delete('id', $ids);
    }

    private function _buildCrontab($gateway_id){
        $this->result_mode='object';
        $crontabs = $this->get_all('gateway_id', $gateway_id);
        $crontab_job = '';
        foreach($crontabs as $crontab){
            $crontab_job .= $crontab->minute.' '.$crontab->hour.' '.$crontab->day.' '.$crontab->month.' '.$crontab->week.' '.$crontab->task.PHP_EOL;
        }
        return $crontab_job;
    }
}
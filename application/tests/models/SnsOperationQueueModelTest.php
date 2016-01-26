<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SnsOperationQueueModelTest extends Pinet_PHPUnit_Framework_TestCase {
    var $provider = 'qq';
    var $serial = '36bd44c6-c39e-11e3-8fe6-001f16ffb1bf';
    public function doSetUp() {
        $this->CI->load->model(array('sns_operation_queue_model', 'gateway_model', 'sns_account_model', 'sns_token_model', 'sns_operation_configuration_model'));
        $this->CI->gateway_model->insert(array(
            'serial'=> $this->serial,
            'owner_id'=> 1
        ));
    }

    public function doTearDown() {
        $this->CI->sns_operation_queue_model->clear();
        $this->CI->gateway_model->clear();
        $this->CI->sns_operation_configuration_model->clear();
        $this->CI->sns_token_model->clear();
        $this->CI->sns_account_model->clear();
    }

    public function testGetActiveQueue(){
        $sns_account_id = $this->CI->sns_account_model->insert(array(
            'provider' => $this->provider
        ));
        $sns_token_id = $this->CI->sns_token_model->insert(array(
            'sns_account_id' => $sns_account_id,
            'token' => $this->serial
        ));
        $this->CI->sns_operation_queue_model->insert(array(
            'sns_token_id' => $sns_token_id,
            'status' => 'New'
        ));
        $queue = $this->CI->sns_operation_queue_model->getActiveQueue();
        $this->assertTrue(count($queue) > 0);
    }

    public function testUpdateStatus(){
        $this->CI->sns_operation_queue_model->insert(array(
            'id' => 1,
            'status' => 'New'
        ));
        $result = $this->CI->sns_operation_queue_model->updateStatus(array(1), SNS_Operation_Queue_Model::STATUS_DONE);
        $this->assertTrue($result>0);
    }

    public function testSaveRecord(){
        $this->CI->sns_operation_configuration_model->insert(array(
            'platform'=> $this->provider,
            'user_id'=> 1
        ));
        $result = $this->CI->sns_operation_queue_model->saveRecord(111, $this->provider, $this->serial);
        $this->assertTrue($result > 0);
    }
}
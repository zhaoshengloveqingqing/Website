<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SnsOperationConfigurationModelTest extends Pinet_PHPUnit_Framework_TestCase {
    public function doSetUp() {
        $this->CI->load->model(array('sns_operation_configuration_model'));
        $this->library('test_data');
    }

    public function doTearDown() {
        $this->CI->sns_operation_configuration_model->clear();
        $this->CI->test_data->reset();
    }

    public function testGetOrCreate(){
        $data = $this->CI->sns_operation_configuration_model->getOrCreate(array(
            'platform'=>'qq',
            'user_id'=>'1000',
            'type'=>'2',
            'status'=>'1'
        ));
        $this->assertTrue(isset($data->id));
        $last = $this->CI->sns_operation_configuration_model->getOrCreate(array(
            'platform'=>'qq',
            'user_id'=>'1000',
            'type'=>'2',
            'status'=>'1'
        ));
        $this->assertEquals($data->id,$last->id);
    }

    public function testGetMasterInfo(){
        $this->assertTrue(count($this->CI->sns_operation_configuration_model->getMasterInfo())==0);
        $this->CI->test_data->addSnsOperationConfiguration();
        $this->assertTrue(count($this->CI->sns_operation_configuration_model->getMasterInfo())>0);
    }

    public function testGetSnsSettings(){
        $this->CI->test_data->addSnsOperationConfiguration();
        $this->assertTrue(count($this->CI->sns_operation_configuration_model->getSnsSettings($this->CI->test_data->the_user->id))>0);
        $this->assertTrue(count($this->CI->sns_operation_configuration_model->getSnsSettings($this->CI->test_data->the_user->id, 'qq'))>0);
        $this->assertTrue(count($this->CI->sns_operation_configuration_model->getSnsSettings($this->CI->test_data->the_user->id,'weibo'))==0);
    }

    public function testShowSnsSettings(){
        $this->CI->test_data->addSnsOperationConfiguration();
        $info = $this->CI->sns_operation_configuration_model->showSnsSettings($this->CI->test_data->the_user->id);
        $this->assertTrue($info->qq_status==1);
        $this->assertTrue($info->qq_snsuid!='');
        $this->assertFalse($info->weibo_status==1);
        $this->assertFalse($info->weibo_snsuid!='');
    }

    public function testUpdateSnsSettings(){
        $this->CI->test_data->addSnsOperationConfiguration();
        $data = array(
            'status'=>'3',
            'oauth_type'=>'qq',
            'poi_id'=>'B2094650D164A6FC4899',
            'qq_message_content'=>'test'
        );
        $this->CI->sns_operation_configuration_model->updateSnsSettings($this->CI->test_data->the_user->id, $data);
        $info = $this->CI->sns_operation_configuration_model->showSnsSettings($this->CI->test_data->the_user->id);
        $this->assertTrue(isset($info->qq_message_content));
        $this->assertTrue(isset($info->qq_checkin));
    }

    public function testSaveNoOauthSns(){
        $id = $this->CI->sns_operation_configuration_model->saveNoOauthSns('1000', 'qq', '1');
        $save = $this->CI->sns_operation_configuration_model->load($id);
        $this->CI->sns_operation_configuration_model->saveNoOauthSns('1000', 'qq', '0');
        $last = $this->CI->sns_operation_configuration_model->load($id);
        $this->assertTrue($save->status!=$last->status);
        $this->assertEquals($save->status, 1);
        $this->assertEquals(0, $last->status);
    }
}
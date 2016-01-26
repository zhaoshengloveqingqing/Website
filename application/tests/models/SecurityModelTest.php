<?php defined('BASEPATH') or exit('No direct script access allowed');

class SecurityModelTest extends Pinet_PHPUnit_Framework_TestCase {

    var $user_id = 1000000;
    var $t_type1 = 'action';
    var $t_type2 = 'view';
    var $c_controller1 = 'test_controller1';
    var $c_controller2 = 'test_controller2';
    var $c_method1 = 'test_method1';
    var $c_method2 = 'test_method2';

    public function doSetUp() {
        $this->model(array('security_model', 'user_model', 'group_model'));
		$this->library('test_data');
        $this->CI->user_model->insert(array(
            'id'=>$this->user_id
        ));
    }

    public function doTearDown() {
		$this->test_data->reset();
        $this->user_model->clear();
		$this->group_model->clear();
        $this->CI->security_model->myclear('security_subjects');
        $this->CI->security_model->myclear('security_targets');
        $this->CI->security_model->myclear('security_configurations');
    }

    public function testAddTarget(){
        $target = array(
            'type' => $this->t_type1,
            'operation' => 'allow',
            'tag' => ''
        );
        $subject = array(
            'user_id' => $this->user_id,
            'group_id' => 0
        );
        $config = array(
            'type' => $this->t_type1,
            'controller' => $this->c_controller1,
            'method' => $this->c_method1,
            'tag' => ''
        );
        $target_id = $this->CI->security_model->addTarget($target, $subject, $config);
        $this->assertTrue($target_id>0);
        $subject_id = $this->CI->security_model->getOrCreateSubject($this->user_id)->id;
        $config = $this->CI->security_model->getConfigs($this->t_type1, $this->c_controller1);
        $config_id = $config[0]['id'];
        $target = array(
            'type' => $this->t_type2,
            'subject_id' => $subject_id,
            'config_id' => $config_id,
            'operation' => 'allow',
            'tag' => ''
        );
        $target_id = $this->CI->security_model->addTarget($target);
        $this->assertTrue($target_id>0);
    }

    public function testGetOrCreateSubject(){
        $this->CI->security_subject_model->clear();
        $subject_id = $this->CI->security_model->getOrCreateSubject($this->user_id)->id;
        $this->assertTrue($subject_id>0);
    }

    public function testAddConfig(){
        $config = array(
            'type' => $this->t_type1,
            'controller' => $this->c_controller1,
            'method' => $this->c_method1,
            'tag' => ''
        );
        $config_id = $this->CI->security_model->addConfig($config);
        $this->assertTrue($config_id>0);
        $config = array(
            'type' => $this->t_type2,
            'controller' => $this->c_controller2,
            'method' => $this->c_method2,
            'tag' => ''
        );
        $config_id = $this->CI->security_model->addConfig($config);
        $this->assertTrue($config_id>0);
    }

    public function testGetConfigs(){
        $configs = $this->CI->security_model->getConfigs($this->t_type1, $this->c_method1);
        $this->assertNotNull($configs);
        $configs = $this->CI->security_model->getConfigs($this->t_type2, $this->c_method2);
        $this->assertNotNull($configs);
    }
}

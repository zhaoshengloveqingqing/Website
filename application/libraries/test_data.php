<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * This is the core testing data support class for do the url testing,
 * it will provide many fake data for url testing to complete.
 *
 * @author Jack
 * @date Jul 17, 2014
 *
 */
class Test_Data {
	private $CI;
	public $the_user;
	public $the_gateway;
	public $another_gateway;
	public $the_action;
	public $the_subaction;
	public $the_action_group = 'main_navigation';
	public $the_sec_config;
	public $the_sec_target;
	public $the_sec_subject;
    public $the_user_password = 1;
    public $the_device;
    public $the_token;
    public $the_token_value = 'test_token';
    public $the_sns_account;
    public $the_config;
    public $the_config_change;


	public function __construct() {
		$this->CI = &get_instance();

		// Loading the model and helpers
		$this->CI->load->model(array('gateway_model', 'user_model'
			, 'device_model', 'heartbeat_model', 'group_model', 'action_model', 'sns_account_model', 
			'security_configuration_model', 'security_subject_model',
			'security_target_model', 'token_model', 'config_model', 'configchange_model', 'account_model', 'device_network_counter_model',
            'group_user_model', 'sns_operation_configuration_model', 'sns_login_record_model', 'blacklist_model', 'partner_user_model',
            'heartbeat_model'));
		$this->CI->load->helper('test');

		ci_log('Going to reset all the databases');
		// Clear the dirty datas
		$this->reset();
	}

	public function addHeartBeats() {
		$this->addTheUser();
		$this->addTheGateway();
		$this->CI->heartbeat_model->insert(array(
			'gateway_id' => $this->the_gateway->id,
			'sys_uptime' => 1000,
			'sys_load' => 20
		));
	}

	public function addSecConfig() {
		$config = $this->CI->security_configuration_model->insert(array(
			'type' => 'action',
			'controller' => get_class($this->CI),
			'method' => 'index'
		));
		$this->the_sec_config = $this->CI->security_configuration_model->load($config);
		return $this->the_sec_config;
	}

	public function addSecTarget() {
		$this->addSecConfig();
		$t = $this->CI->security_target_model->insert(array(
			'type' => 'action',
			'subject_id' => $this->CI->security_subject_model->getUserSubject()->id,
			'config_id' => $this->the_sec_config->id,
			'operation' => 'allow'
		));
		$this->the_sec_target = $this->CI->security_target_model->load($t);
		return $this->the_sec_target;
	}

    public function addSnsAccount(){
        $this->registerUser();
        $data = array(
            'user_id' => $this->the_user->id,
            'provider' => 'qq',
            'uid' => '1234567890',
            'nickname' => 'test'
        );
        $data['id'] = $this->CI->sns_account_model->insert($data);
        return $data;
    }

	public function registerUser() {
		$post = array(
			'email_address'=>fake_email(),
			'password'=>$this->the_user_password,
			'username'=>'andy',
			'name'=>fake_name()->simple_name,
			'mobile'=>13260795910,
			'sex'=>0,
			'contact_name'=>'pinet',
			'contact_country'=>'china',
			'contact_province'=>'jiasu',
			'contact_city'=>'suzhou',
			'contact_street'=>'xinghu',
			'contact_postalcode'=>203902,
			'contact_profile'=>'',
			'group_id'=>2,
            'user_type'=>'0'
		);		
		$this->the_user = $this->CI->user_model->register($post);
		$this->the_user = $this->CI->user_model->load($this->the_user);
	}

	public function addAction() {
		$aid = $this->CI->action_model->insert(array(
			'id' => 1000,
			'controller' => 'Welcome',
			'method' => 'main',
			'name' => 'welcome',
			'group' => $this->the_action_group,
			'fields' => '{"nick":"Jack", "age": 33}'
		));
		$this->the_action = $this->CI->action_model->load($aid);
		$aid = $this->CI->action_model->insert(array(
			'id' => 1001,
			'controller' => 'Welcome',
			'method' => 'index',
			'name' => 'welcome.index',
			'group' => 'welcome',
			'fields' => '{"nick":"Jack", "age": 33}'
		));
		$this->the_subaction = $this->CI->action_model->load($aid);
	}

	public function addAdminGroup() {
		$this->admin_group = $this->CI->group_model->getAdminGroup();
	}

	public function addPartnerGroup() {
		$this->partner_group = $this->CI->group_model->getPartnerGroup();
	}

	public function addTheDevice() {
		$did = $this->CI->device_model->insert(fake_device(
			$this->the_user->id,
			$this->the_gateway->id
		));
		$this->the_device = $this->CI->device_model->load($did);
	}

	public function addUserInsane() {
		$this->addAdminGroup();
		$this->addPartnerGroup();
		$count = rand(20, 100);
		for($i = 0; $i < $count; $i++) {
			$uid = $this->CI->user_model->insert(fake_user(1000 + $i));
			$this->CI->user_model->addUserToGroup($uid, choice(array($this->admin_group->id, $this->partner_group->id)));
		}
	}

	public function addTheUser() {
		$uid = $this->CI->user_model->insert(fake_user());
		$this->the_user = $this->CI->user_model->load($uid);
		return $this->the_user;
	}

	public function addTheGateway() {
		$gid = $this->CI->gateway_model->insert(fake_gateway($this->the_user->id, null, 1000));
		$this->the_gateway = $this->CI->gateway_model->load($gid);
		return $this->the_gateway;
	}

	public function addAnotherGateway() {
		$gid = $this->CI->gateway_model->insert(fake_gateway($this->the_user->id,null, 1001));
		$this->the_gateway = $this->CI->gateway_model->load($gid);
		return $this->the_gateway;
	}

    public function addToken(){
        $this->addSnsAccount();
        $this->addTheGateway();
        $this->addTheDevice();
        $this->the_token = $this->CI->token_model->insert(array(
            'device_id' => $this->the_device->id,
            'gateway_id' => $this->the_gateway->id,
            'token' => $this->the_token_value
        ));
        $this->the_token = $this->CI->token_model->load($this->the_token);
        return $this->the_token;
    }

    public function addConfig(){
        $this->addTheGateway();
        $this->the_config = $this->CI->config_model->insert(array(
            'gateway_id' => $this->the_gateway->id,
            'item' => 'item_test',
            'value' => 'value_test'
        ));
        $this->the_config = $this->CI->config_model->load($this->the_config);
    }

    public function addTheAccount(){
        $this->CI->account_model->insert(array(
            'name' => $this->the_user->username
        ));
    }

    public function addTheDNC(){
        $this->CI->device_network_counter_model->insert(array(
            'device_id' => $this->the_device->id,
            'gateway_id' => $this->the_gateway->id,
            'sns_account_id' => $this->the_sns_account_id,
            'incoming' => 777,
            'outgoing' => 999
        ));
    }

    public function addTheGroupUser(){
        $this->CI->group_user_model->insert(array(
            'group_id' => $this->partner_group->id,
            'user_id' => $this->the_user->id
        ));
    }

    public function addTheHeartBeat(){
        $this->CI->heartbeat_model->insert(array(
            'gateway_id' => $this->admin_group->id,
            'sys_uptime' => 1234,
            'sys_load' => 34,
            'sys_memfree' => 334455,
            'sys_memory' => 2097152,
            'firmware_version' => 1,
            'sys_version' => 1
        ));
    }

    public function addFakeUser($id) {
        $uid = $this->CI->user_model->insert(fake_user($id));
        $this->the_user = $this->CI->user_model->load($uid);
        return $this->the_user;
    }

    public function addFakeGateway($id) {
        $gid = $this->CI->gateway_model->insert(fake_gateway($this->the_user->id, null, $id));
        $this->the_gateway = $this->CI->gateway_model->load($gid);
        return $this->the_gateway;
    }

    private function _addWholeData($admin=false, $id){
        if($admin !== true){
            $this->addFakeUser($id);
            $this->CI->partner_user_model->insert(array(
                'partner_user_id' => $this->the_user->id,
                'user_id' => $admin
            ));
        }
        $this->addTheGroupUser();
        $this->CI->account_model->insert(array(
            'user_id' => $this->the_user->id,
            'name' => $this->the_user->username,
            'birthday' => '1988-08-08'
        ));
        $this->addFakeGateway($id);
        $this->addTheDevice();
        $this->the_sns_account_id = $this->CI->sns_account_model->insert(array(
            'user_id' => $this->the_user->id,
            'provider' => 'qq'
        ));
        $this->addTheDNC();
        $this->CI->sns_operation_configuration_model->insert(array(
            'platform' => 'qq',
            'user_id' => $this->the_user->id,
            'type' => 2
        ));
        for($i=0; $i<20; $i++){
            $datetime = new DateTime();
            $datetime->sub(DateInterval::createFromDateString(humanize($i, 'day')));
            $this->CI->sns_login_record_model->insert(array(
                'snsaccount_id' => $this->the_sns_account_id,
                'gateway_id' => $this->the_gateway->id,
                'device_id' => $this->the_device->id,
                'function' => 'login',
                'effect' => '1',
                'timestamp' => $datetime->format('Y-m-d H:i:s')
            ));
            $this->CI->heartbeat_model->insert(array(
                'gateway_id' => $this->the_gateway->id,
                'sys_uptime' => rand(50, 5000),
                'sys_load' => rand(0, 100),
                'sys_memfree' => rand(5000, 1000000),
                'timestamp' => $datetime->format('Y-m-d H:i:s')
            ));
        }
    }

    public function addWholeData(){
        $this->addAdminGroup();
        $this->addPartnerGroup();
        $uid = $this->CI->user_model->insert(fake_user(1000, 'mina_eastoft'));
        $this->the_user = $this->CI->user_model->load($uid);
        $admin_user = $this->the_user->id;
        for($i=0; $i<20; $i++){
            $this->_addWholeData(($i===0 ? true: $admin_user), $admin_user+$i);
        }
    }

    public function addSnsOperationConfiguration(){
        $this->addSnsAccount();
        $this->addTheGateway();
        $this->operation_configuration = $this->CI->sns_operation_configuration_model->insert(array(
            'platform'=>'qq',
            'user_id'=>$this->the_user->id,
            'type'=>'2',
            'status'=>'1'
        ));
        $this->operation_configuration = $this->CI->sns_operation_configuration_model->load($this->operation_configuration);
        return $this->operation_configuration;
    }

	public function reset() {
		$this->CI->user_model->myclear('groups_users');
		$this->CI->device_model->clear();
		$this->CI->gateway_model->clear();		
		$this->CI->user_model->clear();
		$this->CI->group_model->clear();
		$this->CI->action_model->clear();
		$this->CI->sns_account_model->clear();
		$this->CI->security_subject_model->clear();
		$this->CI->security_target_model->clear();
		$this->CI->security_configuration_model->clear();
		$this->CI->token_model->clear();
		ci_log('Going to reset heart beats');
		$this->CI->heartbeat_model->clear();
	}
}

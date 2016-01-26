<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migration_All_Api extends MY_Migration {

	private function addConfigs() {
		$this->add_table(
			'configs',
			array(
				'gateway_id' => $this->int(),
				'item' => $this->varchar(),
				'value' => $this->text()
			),
			'gateway_id'
		);
	}

	private function addConfigChanges() {
		$this->add_table(
			'config_changes',
			array(
				'gateway_id' => $this->int(),
				'config_id' => $this->int(),
				'new_value' => $this->text(),
				'old_value' => $this->text(),
				'timestamp' => $this->timestamp(),
				'applied' => $this->bool(),
				'version' => $this->int(1)
			),
			array('gateway_id', 'config_id', 'timestamp')
		);
	}

	private function addOperations() {
		$this->add_table(
			'operations',
			array(
				'gateway_id' => $this->int(),
				'operation' => $this->varchar(),
				'timestamp' => $this->timestamp(),
				'applied' => $this->bool(),
			),
			array('gateway_id', 'operation', 'timestamp')
		);
	}

	private function addHeartBeats() {
		$this->add_table(
			'heart_beats',
			array(
				'gateway_id' => $this->int(),
				'sys_uptime' => $this->decimal(array(18,2), false),
				'sys_load' => $this->decimal(array(5,2), false),
				'sys_memfree' => $this->int(),
				'sys_memory' => $this->int(2097152),//2G
				'firmware_version' => $this->varchar(5),
				'sys_version' => $this->varchar(5),
				'timestamp' => $this->timestamp()
			),
			array(
				'gateway_id', 'sys_version', 'timestamp'
			)
		);
	}

	private function addTokens() {
		$this->add_table(
			'tokens',
			array(
				'device_id' => $this->int(),
				'gateway_id' => $this->int(),
				'ip' => $this->int(),
				'token' => $this->varchar(50),
				'status' => $this->varchar(8, FALSE, TRUE, 'ENABLE'),
				'timestamp' => $this->timestamp()
			),
			array('device_id', 'gateway_id', 'ip', 'status', 'timestamp')
		);
	}
	
	private function addDevices() {
		$this->add_table(
				'devices',
				array(
						'owner_id' => $this->int(),
						'gateway_id' => $this->int(),
						'mac' => $this->varchar(17),
						'os'=>$this->varchar(16),
						'os_version'=>$this->varchar(16),
						'browser'=>$this->varchar(16),
						'browser_version'=>$this->varchar(16),
						'uagent'=>$this->varchar(255)
				),
				array('owner_id', 'gateway_id', 'mac', 'os', 'os_version', 'browser', 'browser_version')
		);
	}	
	
	private function addSnsaccounts() {
		$this->add_table(
				'sns_accounts',
				array(
						'user_id' => $this->int(),
						'provider' => $this->varchar(8),
						'uid' => $this->varchar(32),
						'nickname' => $this->varchar(200),
						'gender' => $this->varchar(1),
						'province' => $this->varchar(100),
						'city' => $this->varchar(100),
						'profile_image_url' => $this->varchar(200),
						'json_response' => $this->text(),
						'timestamp' => $this->timestamp()
				),
				array('user_id', 'provider', 'uid', 'timestamp')
		);
	}

	private function addLoginrequests() {
		$this->add_table(
				'login_requests',
				array(
						'user_id' => $this->int(),
						'gateway_id' => $this->int(),
						'device_id' => $this->int(),
						'status' => $this->tint(),						
						'timestamp' => $this->timestamp()
				),
				array('user_id', 'gateway_id', 'device_id', 'status','timestamp')
		);
	}

	private function addSnsloginrecords() {
		$this->add_table(
				'sns_login_records',
				array(
						'snsaccount_id' => $this->int(),
						'gateway_id' => $this->int(),
						'device_id' => $this->int(),
						'function' => $this->varchar(64,false,false),
						'effect' => $this->int(1),
                        'timestamp' => $this->timestamp()
				),
				array('snsaccount_id', 'gateway_id', 'device_id', 'timestamp')
		);
	}

	private function addTickets() {
		$this->add_table(
				'tickets',
				array(
						'name' => $this->varchar(30),
				),
				'name'
		);
	}	

    public function addSnstokens(){
        $this->add_table(
            'sns_tokens',
            array(
                'sns_account_id' => $this->int(),
                'device_id' => $this->int(),
                'gateway_id' => $this->int(),
                'token' => $this->varchar(512),
                'expires' => $this->int(),
                'refresh_token' => $this->varchar(32),
                'status' => $this->varchar(8, FALSE, TRUE, 'ENABLE'),
                'timestamp' => $this->timestamp()
            ),
            array('device_id', 'gateway_id', 'status', 'timestamp')
        );
    }

    public function addDeviceNetworkCounters(){
        $this->add_table(
            'device_network_counters',
            array(
                'device_id' => $this->int(),
                'gateway_id' => $this->int(),
                'sns_account_id' => $this->int(),
                'token' => $this->varchar(32),
                'incoming' => $this->int(),
                'outgoing' => $this->int(),
                'timestamp' => $this->timestamp()
            ),
            array('device_id', 'gateway_id', 'sns_account_id', 'timestamp')
        );
    }

    public function addSnsOperationConfigurations(){
        $this->add_table(
            'sns_operation_configurations',
            array(
                'platform' => $this->varchar(8),
                'user_id' => $this->int(),
                'type' => $this->tint(),//null 0, follow 1, tweet 2, check in 3
                'content' => $this->text(),
                'status' => $this->tint(),//1,0
                'poi_id' => $this->varchar(32)
            ),
            array('platform', 'user_id', 'type', 'status')
        );
    }

    public function addSnsOperationQueues(){
        $this->add_table(
            'sns_operation_queues',
            array(
                'config_id' => $this->int(),
                'sns_token_id' => $this->int(),
                'status' => $this->varchar(8),//New, Done, Error, Failed
                'retry' => $this->tint(),
                'create_time' => $this->timestamp(),
                'finish_time' => $this->timestamp(TRUE, FALSE)
            ),
            array('config_id', 'sns_token_id', 'status', 'create_time', 'finish_time')
        );
    }

    public function addCustomerRequest(){
        $this->add_table(
            'customer_requests',
            array(
                'name' => $this->varchar(100),
                'email_address' => $this->varchar(100),
                'contact_number' => $this->varchar(20),
                'company_name' => $this->varchar(100),
                'company_address' => $this->varchar(200),
                'industry_type' => $this->varchar(100),
                'request_time' => $this->timestamp()
            ),
            array('request_time')
        );
    }

    public function addBlacklist(){
        $this->add_table(
            'blacklists',
            array(
                'gateway_id' => $this->int(),
                'type' => $this->varchar(8),
                'status' => $this->varchar(8),
                'sns_account_id' => $this->int(),
                'device_id' => $this->int(),
                'deadline_time' => $this->datetime(),
                'create_time' => $this->timestamp()
            ),
            array('sns_account_id', 'gateway_id', 'device_id', 'type', 'status', 'deadline_time', 'create_time')
        );
    }

    public function addPartnerUser(){
        $this->add_table(
            'partner_users',
            array(
                'partner_user_id' => $this->int(),
                'user_id' => $this->int()
            ),
            array('partner_user_id', 'user_id')
        );
    }

    public function addFirewall(){
        $this->add_table(
            'firewalls',
            array(
                'user_id' => $this->int(),
                'protocol' => $this->varchar(8),
                'action' => $this->varchar(8),
                'ip_host' => $this->varchar(50),
                'port' => $this->varchar(8),
                'description' => $this->text(),
                'create_time' => $this->timestamp()
            ),
            array('user_id', 'create_time')
        );
    }

    public function addCrontab(){
        $this->add_table(
            'crontabs',
            array(
                'gateway_id' => $this->int(),
                'month' => $this->varchar(2, false, false, '*'),
                'day' => $this->varchar(2, false, false, '*'),
                'hour' => $this->varchar(2, false, false, '*'),
                'minute' => $this->varchar(2, false, false, '*'),
                'week' => $this->varchar(20, false, false, '*'),
                'task' => $this->text(),
                'status' => $this->varchar(8, false, false, 'ON'),
                'create_time' => $this->timestamp()
            ),
            array('gateway_id', 'status', 'create_time')
        );
    }

    public function addPortalPage(){
        $this->add_table(
            'portal_pages',
            array(
                'user_id' => $this->int(),
                'page_settings' => $this->text(),
                'create_time' => $this->timestamp()
            ),
            array('user_id', 'create_time')
        );
    }

    public function addSyslog(){
        $this->add_table(
            'syslogs',
            array(
                'serial' => $this->varchar(36),
                'timestamp' => $this->timestamp(),
                'priority' => $this->varchar(16),
                'facility' => $this->varchar(16),
                'content' => $this->text()
            ),
            array('serial')
        );
    }

	public function up() {
		$this->addConfigs();
		$this->addConfigChanges();
		$this->addOperations();
		$this->addHeartBeats();
		$this->addTokens();
		$this->addDevices();
		$this->addSnsloginrecords();
		$this->addSnsaccounts();
        $this->addSnstokens();
		$this->addLoginrequests();
		$this->addTickets();
        $this->addDeviceNetworkCounters();
        $this->addSnsOperationConfigurations();
        $this->addSnsOperationQueues();
        $this->addCustomerRequest();
        $this->addBlacklist();
        $this->addPartnerUser();
        $this->addFirewall();
        $this->addCrontab();
        $this->addPortalPage();
        $this->addSyslog();
	}

	public function down() {
		$this->drop_table('heart_beats');
		$this->drop_table('sns_login_records');
		$this->drop_table('login_requests');
		$this->drop_table('sns_accounts');
		$this->drop_table('sns_tokens');
		$this->drop_table('devices');
		$this->drop_table('tokens');
		$this->drop_table('operations');
		$this->drop_table('config_changes');
		$this->drop_table('configs');
		$this->drop_table('tickets');
		$this->drop_table('device_network_counters');
		$this->drop_table('sns_operation_configurations');
		$this->drop_table('sns_operation_queues');
		$this->drop_table('customer_requests');
		$this->drop_table('blacklists');
		$this->drop_table('partner_users');
		$this->drop_table('firewalls');
		$this->drop_table('crontabs');
		$this->drop_table('portal_pages');
		$this->drop_table('syslogs');
	}
}

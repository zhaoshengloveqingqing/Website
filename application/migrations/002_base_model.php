<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migration_Base_Model extends MY_Migration {
	private function addLangTable() {
		$this->add_table(
			'languages',
			array(
				'line' => $this->varchar(255),
				'lang' => $this->varchar(8),
				'value' => $this->text()
			),
			array('line', 'lang')
		);
	}

	private function addSessionTable() {
		$this->add_table(
			'ci_sessions',
			array(
				'session_id' => $this->varchar(40, true, false, '0'),
				'ip_address' => $this->varchar(45, false, false, 0),
				'user_agent' => $this->varchar(120, false, false),
				'last_activity' => $this->int(),
				'user_data' => $this->text(false),
			),
			array('last_activity')
		);
	}

	private function addGateways(){
		$this->add_table(
				'gateways',
				array(
					'serial' => $this->varchar(36,true,false),
					'name' => $this->varchar(128),
					'mac' => $this->varchar(18),
					'ip' => $this->int(),
					'address' => $this->varchar(1024),
					'deadline' => $this->datetime(),
					'district' => $this->varchar(255),
					'city' => $this->varchar(255),
					'state' => $this->varchar(255),
					'country' => $this->varchar(255),
					'longitude' => $this->decimal(array(18,6)),
					'latitude' => $this->decimal(array(18,6)),
					'hostname' => $this->varchar(255),
					'owner_id' => $this->int(),
					'gateway_port' => $this->int(),
					'zip_code' => $this->varchar(20),
					'notes' => $this->text(),
					'redirect_url' => $this->varchar(1024),
					'status' => $this->varchar(8, FALSE, FALSE, 'ACTIVE')
				),
				array('serial', 'mac', 'name', 'status')
		);
	}
	
	public function up() {
		$this->addGateways();
		$this->addSessionTable();
		$this->addLangTable();
	}

	public function down() {
		$this->drop_table('gateways');
		$this->drop_table('ci_sessions');
		$this->drop_table('languages');
	}
}

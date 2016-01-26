<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Audit extends MY_Migration {
	private function addAudits() {
		$this->add_table(
			'audits',
			array(
				'controller' => $this->varchar(32),
				'method' => $this->varchar(32),
				'user_id' => $this->int(),
				'session' => $this->text(),
				'args' => $this->text(),
				'timestamp' => $this->timestamp(), 
			),
			array(
				'controller','method','timestamp','user_id'
			)
		);
	}

	public function up() {
		$this->addAudits();
	}

	public function down() {
		$this->drop_table('audits');
	}
}

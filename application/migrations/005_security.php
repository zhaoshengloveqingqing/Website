<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Security extends MY_Migration {
	private function addActions() {
		$this->add_table(
			'actions',
			array(
				'controller' => $this->varchar(32),
				'method' => $this->varchar(32, false, true),
				'group' => $this->varchar(32, false, true, 'main_navigation'),
				'logo' => $this->varchar(128),
				'name' => $this->varchar(128),
				'label' => $this->varchar(128),
				'args' => $this->varchar(128),
				'fields' => $this->text(),
			),
			array('controller', 'method', 'group')
		);
	}

    private function addSecurityTargets() {
        $this->add_table(
            'security_targets',
            array(
                'type' => $this->varchar(16),
                'subject_id' => $this->int(),
                'config_id' => $this->int(),
                'operation' => $this->varchar(8, FALSE, FALSE, 'deny'),
                'tag' => $this->text()
            ),
            array(
                'subject_id', 'config_id'
            )
        );
    }

    private function addSecuritySubjects() {
        $this->add_table(
            'security_subjects',
            array(
                'user_id' => $this->int(0, 11, false),
                'group_id' => $this->int(0, 11, false)
            ),
            array(
                'user_id', 'group_id'
            )
        );
    }

    private function addSecurityConfigurations() {
        $this->add_table(
            'security_configurations',
            array(
                'type' => $this->varchar(16),
                'controller' => $this->varchar(30),
                'method' => $this->varchar(100),
                'tag' => $this->text()
            ),
            array(
                'type', 'controller'
            )
        );
    }

	public function up() {
		$this->addActions();
        $this->addSecurityTargets();
        $this->addSecuritySubjects();
        $this->addSecurityConfigurations();
	}

	public function down() {
		$this->drop_table('actions');
        $this->drop_table('security_targets');
        $this->drop_table('security_subjects');
        $this->drop_table('security_configurations');
	}
}

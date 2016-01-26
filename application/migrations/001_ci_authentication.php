<?php defined("BASEPATH") or exit("No direct script access allowed");

class Migration_CI_Authentication extends MY_Migration {
	
	private function addGroups(){
		$this->add_table(
				'groups',
				array(
					'group_name' =>$this->varchar(50,true),
					'group_desc' =>$this->varchar(1024)
				),
				'group_name'
		);		
	}
	
	private function addUsers(){
		$this->add_table(
				'users',
				array(
					'email_address' => $this->varchar(100,true),
					'username' => $this->varchar(20, true),					
					'password' =>$this->varchar(50),
					'confirm_string' => $this->varchar(100),
					'status' => $this->varchar(50),
                    'user_type' => $this->tint(),
                    'timestamp' => $this->timestamp()
				),
            array('email_address', 'username', 'timestamp')
		);
	}

	private function addAccounts() {
		$this->add_table(
				'accounts',
				array(
					'user_id' => $this->int(),
					'name' => $this->varchar(20),
					'first_name' => $this->varchar(20),
					'last_name' => $this->varchar(20),
					'mobile' => $this->varchar(11),
					'sex' => $this->varchar(1,false,false,'n'),
					'birthday' => $this->date(), //date
					'contact_name' => $this->varchar(50),
					'contact_company' => $this->varchar(100),
					'contact_country' => $this->varchar(10),
					'contact_province' => $this->varchar(10),
					'contact_city' => $this->varchar(30),
					'contact_street' => $this->varchar(300),					
					'contact_postalcode' => $this->varchar(6),
					'contact_profile' => $this->varchar(500),
					'type' => $this->varchar(20),
					'profile_image_path' => $this->varchar(200),
					'meta' => $this->text()
				),
				'user_id'
		);
	}

	public function addGroupToUser() {
		$this->add_table(
				'groups_users',
				array(
					'group_id'=>$this->int(),
					'user_id'=>$this->int()
				),
				array('group_id','user_id')
		);
	}
	
	public function up() {
		$this->addGroups();
		$this->addUsers();
		$this->addAccounts();
		$this->addGroupToUser();
	}

	public function down() {
		$this->drop_table('groups_users');
		$this->drop_table('accounts');
		$this->drop_table('users');
		$this->drop_table('groups');		
	}
}


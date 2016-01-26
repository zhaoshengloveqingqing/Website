<?php defined('BASEPATH') or exit('No direct script access allowed');

class GroupModelTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->model('group_model');		
	}

	public function doTearDown() {
		$this->CI->group_model->clear();
	}

	public function testGetGroupID() {
		$this->group_model->getUserGroup();
		$id = $this->group_model->getGroupID('user');
		$this->assertEquals($id, 1);
	}

    public function testGetOrCreate(){
        $group = $this->group_model->getOrCreate('test_jake');
        $group_last = $this->group_model->getOrCreate('test_jake', 10000);
        $this->assertEquals($group->id, $group_last->id);
    }

    public function testGetGroup(){
        $group = $this->group_model->getOrCreate('test_jake');
        $group_last = $this->group_model->getGroup('test_jake');
        $this->assertEquals($group, $group_last);
    }

    public function testAddGroup(){
        $groups = array('test1', 'test2', 'test3');
        $group = 'test4';
        $this->group_model->addGroup($groups);
        $this->assertEquals(count($this->group_model->get_all()), count($groups));
        $this->group_model->addGroup($group);
        $this->assertEquals(count($this->group_model->get_all()), count($groups)+1);
    }
}

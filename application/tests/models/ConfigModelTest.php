<?php defined('BASEPATH') or exit('No direct script access allowed');

class ConfigModelTest extends Pinet_PHPUnit_Framework_TestCase {

	var $the_id = 1000;
	var $the_gateway = 1000;
	var $the_item = 'test.item';
	var $the_value = 1;

	public function doSetUp() {
		$this->CI->load->model('config_model');
        $this->library('test_data');
		$this->CI->config_model->clear();
		$this->CI->config_model->insert(array(
			'id' => $this->the_id,
			'gateway_id' => $this->the_gateway,
			'item' => $this->the_item,
			'value' => $this->the_value
		));
	}
	
	public function doTearDown() {
        $this->CI->test_data->reset();
		$this->CI->config_model->clear();
		$this->CI->configchange_model->clear();
	}

	public function testGetOrCreate() {
        $config = $this->CI->config_model->getOrCreate($this->the_gateway,
            $this->the_item, $this->the_value);
        $this->assertEquals(intval($config->id), $this->the_id);

		$config_last = $this->CI->config_model->getOrCreate($this->the_gateway,
            $this->the_item, $this->the_value);
        $this->assertEquals($config, $config_last);
	}

	public function fakeConfig($id) {
		$this->CI->config_model->insert(array('id' => $id, 
			'gateway_id' => choice(array(100,1000,10000))));
	}

	public function testDbPagination() {
		$this->CI->config_model->clear();
		$p = new PaginationSupport();
		$p->length = 9;
		for($i = 0; $i < 50; $i++) {
			$this->fakeConfig($i);
		}
		//$p->items = $dbret;
		//print_r($p);
		$paret = $this->CI->config_model->pagination($p);
		$this->assertEquals($paret->total, 50);
		$this->assertEquals($paret->totalCount(), 6);
		$p2 = new PaginationSupport();		
		$p2->where = array('gateway_id'=>1000);
		$this->CI->config_model->pagination($p2);	
		$this->assertTrue($p2->total < 50);
		//$this->assertEquals($paret2->total, 1);			
	}

    public function testChangeItem(){
        $this->CI->test_data->addConfig();
        $this->assertEquals(count($this->CI->config_model->myget_all('config_changes')), 0);
        $this->CI->config_model->changeItem($this->CI->test_data->the_gateway->id, 'item_test', 'new_value');
        $config_change = $this->CI->config_model->myget_all('config_changes');
        $config_change = $config_change[0];
        $this->assertEquals($config_change->new_value, 'new_value');
        $this->assertEquals($config_change->old_value, 'value_test');
    }
}

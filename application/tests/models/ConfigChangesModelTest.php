<?php defined('BASEPATH') or exit('No direct script access allowed');

class ConfigChangesModelTest extends Pinet_PHPUnit_Framework_TestCase {
	private $the_change_id = 1000;
	private $the_config_id = 1000;
	private $the_gateway_id = 1000;
	private $the_old_value = 1;
	private $the_new_value = 1;
	
	public function doSetUp() {
		$this->CI->load->model('configchange_model');
		// Clear all the changes
		$this->CI->configchange_model->clear();
		// Insert one not applied change
		$this->CI->configchange_model->insert(array(
			'id' => $this->the_change_id,
			'gateway_id' => $this->the_gateway_id,
			'config_id' => $this->the_config_id,
			'old_value' => $this->the_old_value,
			'new_value' => $this->the_new_value
		));
	}

	public function doTearDown() {
        $this->CI->test_data->reset();
		// Clear all the changes
		$this->CI->configchange_model->clear();
	}

	public function testGetUnApplied() {
		$this->assertEquals(count($this->CI->configchange_model->getUnApplied($this->the_gateway_id,
			$this->the_config_id)), 1);
		$change = $this->CI->configchange_model->updateOrCreate($this->the_gateway_id, $this->the_config_id,
			$this->the_new_value, $this->the_old_value);
		$this->assertEquals($change->id, $this->the_change_id);
	}

    public function testGetAllUnApplied(){
        for($i=0; $i<5; $i++){
            $this->CI->configchange_model->insert(array(
                'gateway_id' => $this->the_gateway_id,
                'applied' => FALSE
            ));
        }
        $changes = $this->CI->configchange_model->getAllUnApplied($this->the_gateway_id);
        $this->assertTrue(count($changes)>1);
    }

    public function testApply(){
        $change = $this->CI->configchange_model->get(array('id'=>$this->the_change_id));
        $this->assertTrue($change['applied']==0);
        $this->CI->configchange_model->apply($this->the_change_id);
        $change = $this->CI->configchange_model->get(array('id'=>$this->the_change_id));
        $this->assertTrue($change['applied']==1);
    }

    public function testUpdateOrCreate(){
        $change = $this->CI->configchange_model->updateOrCreate(
            $this->the_gateway_id,
            $this->the_config_id,
            $this->the_old_value,
            $this->the_new_value
        );

        $change_again = $this->CI->configchange_model->updateOrCreate(
            $this->the_gateway_id,
            $this->the_config_id,
            $this->the_old_value,
            $this->the_new_value
        );
        $this->assertEquals($change->id, $change_again->id);
    }

    public function testGetLastVersion(){
        $this->assertEquals($this->CI->configchange_model->getLastVersion(1,2), 1);
        $this->CI->test_data->addConfig();
        $this->CI->config_model->changeItem($this->CI->test_data->the_gateway->id, 'item_test', 'new_value');
        $this->assertEquals($this->CI->configchange_model->getLastVersion($this->CI->test_data->the_gateway->id,$this->CI->test_data->the_config->id), 1);
    }
}

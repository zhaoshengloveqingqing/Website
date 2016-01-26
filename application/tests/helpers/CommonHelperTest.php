<?php defined('BASEPATH') or exit('No direct script access allowed');

class DummyExample {
	private $you_can_not_see_me;
	public $name;
	public $age;
	public $just_test;

	public function __construct($text = '') {
		$this->you_can_not_see_me = $text;
	}

	public function text() {
		return $this->you_can_not_see_me;
	}
}

class CommonHelperTest extends Pinet_PHPUnit_Framework_TestCase {

	public function doSetUp() {
		$this->helper('common');
		$this->model('config_model');
	}

	public function testRollover() {
		print_r(rollover(array(
			array('11', '21', '31', '41'), array('12','22', '32', '42')
		)));
	}

	public function testTokenizeTime() {
		$begin = new DateTime('yesterday');
		$end = new DateTime('today');
		$arr = tokenize_time($begin, $end, 'hour');
		$this->assertEquals(count($arr), 25);

		$begin = new DateTime('yesterday');
		$end = new DateTime('3 days');
		$arr = tokenize_time($begin, $end, 'day');
		$this->assertEquals(count($arr), 6);

		$arr = tokenize_time('yesterday');
		$this->assertEquals(count($arr), 3);

		$begin = new DateTime('today');
		$end = new DateTime('today');
		$arr = tokenize_time($begin, $end, 'day');
		print_r($arr);
	}

	public function testMakeClasses() {
		print_r(make_classes('a', 'b', array('c', 'd')));
		$this->assertEquals(make_classes('a', 'b', array('c', 'd')), array('a','b','c','d'));

		print_r(make_classes('a', 'b', array('c', '', 'd')));
		$this->assertEquals(make_classes('a', 'b', array('c', 'd')), array('a','b','c','d'));
	}

	public function testCombineAndUniqueArrays() {
		$this->assertEquals(combine_and_unique_arrays(array('1', '2'), array('2', '3'), array('3','4')), 
			array('1','2','3','4'));
	}

	public function testIsRegex() {
		$this->assertTrue(!!is_regex('/asdf/'));
		$this->assertTrue(!is_regex('asdf'));
	}

	public function testInsertAt() {
		$dummy = new DummyExample('test');
		$this->assertEquals(insert_at(array(1,2,3), 0, 0), array(0,1,2,3));
		$this->assertEquals(insert_at(array(1,2,3), 4, 3), array(1,2,3,4));
		$this->assertEquals(insert_at(array(1,2,3), $dummy, 3), array(1,2,3,$dummy));
	}

	public function testJS() {
		$the_count = count($this->CI->jsFiles); 
		$this->assertFalse($this->CI->jquery());
		$this->CI->jquery('1.7.1');
		$this->CI->js('bootstrap',null,-1,'/static/bootstrap/');
	}

	public function testCopyObject() {
		$obj = array('name' => 'Jack', 'age' => 30, 'just.test' => 1);
		$dummy = copy_object($obj, new DummyExample());
		$this->assertEquals($obj['name'], $dummy->name);
		$dummy = copy_new($obj, 'DummyExample');
		$this->assertEquals($obj['name'], $dummy->name);
		$this->assertEquals($obj['just.test'], $dummy->just_test);
	}

	public function testCss() {
		$the_count = count($this->CI->cssFiles);				
		$this->CI->css('test');
		$this->assertEquals(count($this->CI->cssFiles), $the_count + 1);
		$this->assertFalse($this->CI->css('test'));
		$this->CI->css('test',2.0);
		$this->CI->css('bootstrap',null,-1,'/static/bootstrap/');
		print_r($this->CI->cssFiles);
	}

	public function testCombineArrays() {
		$a = array(1);
		$b = array(2);

		$this->assertEquals(combine_arrays(), array());
		$this->assertEquals(combine_arrays($a), $a);
		$this->assertEquals(combine_arrays($a,$b), array(1,2));
	}

	public function testModel() {
		$this->assertNotNull($this->model('config_model'));
		$this->assertNotNull($this->config_model);
		$this->assertNotNull($this->model('configchange_model', 'cc'));
		$this->assertNotNull($this->cc);
	}

	public function testMultipleModel() {
		$this->assertNotNull($this->model(array('config_model', 'configchange_model')));
		$this->assertNotNull($this->config_model);
		$this->assertNotNull($this->configchange_model);
	}

	public function testUAParser() {
		$this->helper('uagent');
		$agent = fake_uagent();
		$result = parse_uagent($agent);
		$this->assertNotNull($result->os);
		$this->assertNotNull($result->device);
		$this->assertNotNull($result->ua);
		print_r($result);
	}

	public function testObj2Array() {
		$the_text = 'Jack';
		$example = new DummyExample($the_text);
		$arr = obj2array($example);
		$this->assertEquals($arr['you_can_not_see_me'], $the_text);
	}

	public function testControllerSmarty() {
		$CI = &get_instance();
		$this->assertNotNull($CI->smarty);
	}

	public function testGetControllerMeta() {
		$meta = get_controller_meta();
		$this->assertEquals($meta->controller, 'Welcome');
		$this->assertEquals($meta->method, 'index');
	}

	public function testPagination() {
		$p = new PaginationSupport();
		$p->total = $this->CI->config->item('pagination_length') * 2 + 1;
		$this->assertEquals($p->length, $this->CI->config->item('pagination_length'));
		$json = $p->toJson();

		$p2 = PaginationSupport::fromJson($json);
		$this->assertEquals($p2->total, $p->total);
		$this->assertEquals($p2->totalCount(), 3);
		$this->assertEquals($p2->current(), 1);
		$p2->offset = $p2->length + 1;
		$this->assertEquals($p2->current(), 2);
		$this->assertTrue($p2->hasPrev());
		$this->assertTrue($p2->hasNext());

		$this->assertFalse($p2->page(4));
		$p2->page(3);
		$this->assertEquals($p2->offset, $this->CI->config->item('pagination_length') * 2);
		$p2->last();
		$this->assertEquals($p2->offset, $this->CI->config->item('pagination_length') * 2);
		$p2->page(2);
		$this->assertEquals($p2->offset, $this->CI->config->item('pagination_length'));
	}
}

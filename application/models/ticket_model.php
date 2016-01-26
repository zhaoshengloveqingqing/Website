<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_Model extends Pinet_Model {
	public function __construct() {
		parent::__construct('tickets');
	}

	public function haveTicket($ticket) {
        $this->result_mode = 'object';
		$ret = $this->get(array(
			'name'=>$ticket
		));
		if(isset($ret->id)){
			return TRUE;
		}
		return FALSE;
	}
}
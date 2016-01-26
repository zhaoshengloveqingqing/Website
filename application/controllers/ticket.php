<?php defined("BASEPATH") or exit("No direct script access allowed");
class Ticket extends Pinet_Controller {

	public function do_ticket() {
		$this->load->library(array('session'));			
		$this->load->model(array('ticket_model','token_model'));
		$haveticket = $this->ticket_model->haveTicket($this->input->post('ticket'));
		if($haveticket) {
			$serial = $this->session->userdata('serial');
			$mac = $this->session->userdata('mac');			
			$ip = $this->session->userdata('ip');

			//add token
			$data = array(
				'mac'=>$mac,
				'serial'=>$serial
			);
			$token = $this->token_model->madd($data);

			if($token){
                $url = 'http://' . $this->session->userdata('gateway_ip') . ':' . $this->session->userdata('gateway_port') . '/pinet/auth?token=' . $token;
                if($this->session->userdata('url')){
                    $url .= '&url=' . $this->session->userdata('url');
                }
                redirect($url);
            }else
                return FALSE;
		}else{
			return FALSE;
		}
	}

	/**
	 * Create a parameter URL
	 * @param  [type] $url    [description]
	 * @param  [type] $params [description]
	 * 		$params = array(
	 *		 	'serial'=>"2324124343",
	 *		  	'ip'=>$this->session->userdata('ip'),
	 *		   	'mac'=>$mac,
	 *		    'token' => $token,
	 *		    'incoming' => 1000,
	 *		    'outcoming' => 2000
	 *	 	);
	 * @return [type]         [description]
	 */
	private function _createUrl($url,$params) {
		$index = 0;
		foreach ($params as $k => $v) {
			if($index == 0) {
				$url = $url."?".$k."=".$v;
				$index = 1;
			}else{
				$url = $url."&".$k."=".$v;					
			}
		}
		return $url;
	}

}

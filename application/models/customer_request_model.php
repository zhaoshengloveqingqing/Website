<?php defined('BASEPATH') or exit('No direct script access allowed');

class Customer_Request_Model extends Pinet_Model{
    public function __construct(){
        parent::__construct('customer_requests');
    }
}
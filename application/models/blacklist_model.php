<?php defined('BASEPATH') or exit('No direct script access allowed');

class Blacklist_Model extends Pinet_Model {
    public function __construct() {
        parent::__construct('blacklists');
    }

    public function deleteBlacklists($ids){
        return $this->delete('id', $ids);
    }

    public function add2Bakcklist($gateway_id, $ids){
        foreach($ids as $id){
            $temp_ids = explode('_', $id);
            $this->insert(array(
                'gateway_id'=>$gateway_id,
                'type'=>'abandon',
                'sns_account_id'=>$temp_ids[0],
                'device_id'=>$temp_ids[1]
            ));
        }
    }
}

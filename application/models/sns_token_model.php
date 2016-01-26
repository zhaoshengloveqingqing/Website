<?php defined('BASEPATH') or exit('No direct script access allowed');


class SNS_Token_Model extends Pinet_Model {
    public function __construct() {
        parent::__construct('sns_tokens');
    }

    public function getWeiboPOIs($user_id, $provider, $keyword){
        if($keyword){
            $token = $this->getSnsToken($user_id, $provider);
            if($token){
                $this->load->spark('oauth2/0.4.0');
                $this->load->library(array('oauth2_provider_weibo'));
                $weibo = new OAuth2_Provider_Weibo();
                return $weibo->getPOIs($token->token, $keyword);
            }
        }
        return array();
    }

    public function getSnsToken($user_id, $provider){
        $this->db->select('soc.id, sa.uid,soc.type,soc.poi_id,soc.status,soc.content,sa.provider');
        $this->db->from('sns_accounts as sa');
        $this->db->join('sns_tokens as st', 'sa.id=st.sns_account_id', 'inner');
        $this->db->where('sa.user_id', $user_id);
        $this->db->where('sa.provider', $provider);
        return $this->db->get()->result();
    }
}
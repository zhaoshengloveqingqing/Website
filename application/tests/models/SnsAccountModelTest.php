<?php defined('BASEPATH') or exit('No direct script access allowed');


class SnsAccountModelTest extends Pinet_PHPUnit_Framework_TestCase {
    var $sResponse = '{"ret":0,"msg":"","is_lost":0,"nickname":"testnickname","gender":"男","province":"江苏","city":"苏州","year":"1987","figureurl":"http:\/\/qzapp.qlogo.cn\/qzapp\/100569850\/E58CF47C974641AF502E9CD598989016\/30","figureurl_1":"http:\/\/qzapp.qlogo.cn\/qzapp\/100569850\/E58CF47C974641AF502E9CD598989016\/50","figureurl_2":"http:\/\/qzapp.qlogo.cn\/qzapp\/100569850\/E58CF47C974641AF502E9CD598989016\/100","figureurl_qq_1":"http:\/\/q.qlogo.cn\/qqapp\/100569850\/E58CF47C974641AF502E9CD598989016\/40","figureurl_qq_2":"http:\/\/q.qlogo.cn\/qqapp\/100569850\/E58CF47C974641AF502E9CD598989016\/100","is_yellow_vip":"0","vip":"0","yellow_vip_level":"0","level":"0","is_yellow_year_vip":"0","client_id":"100569850","openid":"E58CF47C974641AF502E9CD598989016","access_token":"031560A305FEB741CF2E3EF83E7EFFF9","expires":1414642177,"refresh_token":"1A0AAE927051CC9A9939BD54ACE9EDA9"}';
    var $snsAccount = 'E58CF47C974641AF502E9CD598989016';
    var $sProvider = 'qq';
    var $serial = 'test';
    var $oResponse = null;
    var $gateway_id;
    public function doSetUp() {
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36';
        $this->CI->load->model(array('sns_account_model', 'gateway_model'));
        $this->library('test_data');
        $this->oResponse = json_decode($this->sResponse);
        $this->CI->gateway_model->clear();
        $this->gateway_id = $this->CI->gateway_model->insert(array(
            'serial'=> $this->serial
        ));
    }

    public function doTearDown() {
        $this->test_data->reset();
    }

    public function testSaveUserToken(){
        $this->CI->session->unset_userdata('user_id');
        $sSnsToken = $this->CI->sns_account_model->saveUserToken($this->oResponse, $this->sProvider);
        echo $sSnsToken;
        $this->assertTrue($sSnsToken != null);
    }

    public function testGetBySnsAccount(){
        $sns_account = $this->test_data->addSnsAccount();
        $account = $this->CI->sns_account_model->getBySnsAccount($sns_account['uid'], $sns_account['provider']);
        $this->assertTrue(isset($account));
    }

    public function testAddNewSnsAccount(){
        $aResult = $this->CI->sns_account_model->addNewSnsAccount($this->oResponse, $this->serial, $this->CI->session->unset_userdata('serial'), $this->sProvider);
        $this->assertTrue(isset($aResult['sns_account_id']));
    }

    public function testSnsLogin(){
        $sns_account = $this->test_data->addSnsAccount();
        $this->CI->sns_account_model->snsLogin($sns_account['uid'], $sns_account['provider']);
    }
}

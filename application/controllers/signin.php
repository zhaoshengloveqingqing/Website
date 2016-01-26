<?php defined("BASEPATH") or exit("No direct script access allowed");

class Signin extends Pinet_Controller {

	public $messages = 'signin';

	public function __construct() {
		parent::__construct();
        $this->load->library(array('session'));
        $this->load->model(array('user_model', 'portal_page_model'));
	}

	public function activities() {
		$this->init_responsive();
		$this->less('signin/activities_css');
        $settings = $this->portal_page_model->getPortalSettings($this->user_model->getLoginUserID());
        $data = array(
            'logo' => 'signin-logo.png',
            'company' => 'Waldorf Astoria',
            'activities' => array(
                array(
                    'photo' => 'signin-activities-act-logo-big.png',
                    'title'=>lang('activities name'),
                    'contents'=>lang("<p>Combining the history</p>")
                ),
                array(
                    'photo' => 'signin-activities-act-logo.png',
                    'title'=>lang('activities name'),
                    'contents'=>"<p>Combining the history and culturev   of  the celebrated </p>
                                                				<p>0315-0317</p>"
                ),
                array(
                    'photo' => 'signin-activities-act-logo.png',
                    'title'=>lang('activities name'),
                    'contents'=>"<p>Combining the history and culturev   of  the celebrated </p>
                                                				<p>0315-0317</p>"
                ),
                array(
                    'photo' => 'signin-activities-act-logo.png',
                    'title'=>lang('activities name'),
                    'contents'=>"<p>Combining the history and culturev   of  the celebrated </p>
                                                				<p>0315-0317</p>"
                ),
                array(
                    'photo' => 'signin-activities-act-logo.png',
                    'title'=>lang('activities name'),
                    'contents'=>"<p>Combining the history and culturev   of  the celebrated </p>
                                                				<p>0315-0317</p>"
                )
            ),
        );
		$this->render('signin/activities', array_merge($data, $settings));
	}

	public function let_me_online() {
        $settings = $this->portal_page_model->getPortalSettings($this->user_model->getLoginUserID());
		$this->init_responsive();
		$this->less('signin/let_me_online_css');
		$data = array(
			'logo' => 'signin-logo.png',
			'company'=> lang('Waldorf Astoria'),
			'login_wechat'=> 'on',
			'login_weibo'=> 'on',
			'login_qq'=> 'on',
			'login_yixin'=> 'on'
		);
        $this->render('signin/let_me_online', array_merge($data, $settings));
	}

	public function merchant($type) {
        $settings = $this->portal_page_model->getPortalSettings($this->user_model->getLoginUserID());
		$this->init_responsive();
		$this->less('signin/description_css');
        $data = array(
			'logo' => 'signin-logo.png',
			'photo' => 'signin-merchant-description-info.png',
			'introduction'=>'Combining the history and culturev   of  the celebrated Shanghai Bund with a taste for 21st century sophistication, Waldorf Astoria Shanghai on the Bund offers a heritage ambiance, legendary service and timeless amenities to make your stay truly memorable and distinct. Housed within the two-building complex are 260 well-appointed rooms and suites, stylish environments for dining and lounging, extensive banquet facilities with stunning views, luxury spa, fully-fitted gym, complimentary WiFi and more, all crafted onto a picture perfect setting that speaks volume of the grandeur and finesse that is uniquely ours.',
			'company' => lang('Waldorf Astoria')
		);
        $this->render('signin/'.$type, array_merge($data, $settings));
	}
}

{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
<style>

</style>
{/block}
{block name=body}
	<div class="container">
	<!-- Button trigger modal -->
		<!-- Modal -->
		<div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{lang}Sign in{/lang}</h4>
                <p id="error_msg" class="pull-left prompt-message hidden"></p>
              </div>
              <div class="modal-body">
                <div class="col-1280-8 pinet-form-input">
                    <input type="text" name="username" id="username" class="form-control" placeholder="{lang}User Name{/lang}">
                    <div class="help-block"></div>
                </div>
                <div class="col-1280-8 pinet-form-input">
                    <input type="password" name="password" id="password" class="form-control" placeholder="{lang}Password{/lang}">
                    <div class="help-block"></div>
                </div>

                <p class="pull-right"><a class="forget-password-link" href="{site_url url='welcome/forget_password'}">{lang}I forget my password{/lang}</a></p>

              </div>
              <div class="modal-footer">
                <input id="ok-btn" type="button" class="btn pinet-btn-cyan ok" value="{lang}OK{/lang}" >
                <button type="reset" class="btn pinet-btn-grey cancel">{lang}Cancel{/lang}</button>
              </div>
            </div>
		  </div>
		</div>

		<!-- Header -->
		<div id="header">
			<div id="nav">
				<nav class="navbar" role="navigation">
				  <div class="container-fluid">
				    <!-- Brand and toggle get grouped for better mobile display -->
				    <div class="navbar-header">
				      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse-nav">
				        <span class="sr-only">Toggle navigation</span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
				      <a class="navbar-brand" href="#">
				      	{picture path='/responsive/size' alt=$title title=$title src='home/logo.png'}
				      </a>
				    </div>

                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <div class="collapse navbar-collapse">
                          <ul class="nav navbar-nav navbar-right">
                              <li><a href="#" data-toggle="modal" data-target="#login-modal">&nbsp;{lang}LOGIN{/lang}</a></li>
                              <li><a  data-toggle="modal" data-target="#login-modal">&nbsp;/</a></li>
                              <li><a href="{site_url url='account/register'}">&nbsp;{lang}REGISTER{/lang}</a></li>
                              <li id="language-select-box" class="dropdown language-select-box">
                                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                      {lang}Language{/lang}
                                      <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu" role="menu" aria-labelledby="language-select-box">
                                      <li>
                                          <form name="setLangChinese" action="{site_url url='welcome/switch_lang'}" method="POST">
                                              <input type="hidden" name="language" value="chinese" />
                                              <input class="btn btn-link" type="submit" value="中文">
                                          </form>
                                      </li>

                                      <li>
                                          <form name="setLangEnglish" action="{site_url url='welcome/switch_lang'}" method="POST">
                                              <input type="hidden" name="language" value="english" />
                                              <input class="btn btn-link" type="submit" value="ENGLISH">
                                          </form>
                                      </li>
                                  </ul>
                              </li>
                          </ul>
                      </div><!-- /.navbar-collapse -->

                      <!-- Collect the nav links, forms, and other content for toggling -->
                      <div class="collapse navbar-collapse navbar-collapse-nav">
			            <ul class="nav navbar-nav">
			              <li class="active"><a href="#">Link</a></li>
			              <li><a href="#">Link</a></li>
			              <li><a href="#">Link</a></li>
			            </ul>
                      </div><!-- /.navbar-collapse -->                      
                  </div><!-- /.container-fluid -->
				</nav>
			</div><!-- /.nav -->

			<div class="jumbotron">
			  <h1>Pinet Business Wi-Fi</h1>
			  <p class="jumbotron-text">The new way to reach your targeted audiences using Wi-Fi. It changes the way businesses share their Wi-Fi, get Pinet Business Wi-Fi and let your  Wi-Fi market for you.</p>
			  <p class="jumbotron-btn-group">
			  	<a class="btn pinet-btn-cyan btn-lg" role="button">Start Now</a>
			  </p>
			</div>
		</div>

		<!-- Menu -->
		<div id="menu" class="res_row navbar-wrapper">
			<ul class="nav navbar-nav">
				<li class="menu-item" ><a href="#pinet_business">{lang}PINET BUSINESS{/lang}</a></li>
				<li class="menu-item" ><a href="#what_is_good_for">{lang}WHAT IS GOOD FOR{/lang}</a></li>
				<li class="menu-item" ><a href="#how_it_works">{lang}HOW IT WORKS{/lang}</a></li>
				<li class="menu-item" ><a href="#case_studies">{lang}CASE STUDIES{/lang}</a></li>
				<li class="menu-item" ><a href="#get_it_now">{lang}GET IT NOW{/lang}</a></li>
				<li class="menu-item" ><a href="#contact_us">{lang}CONTACT US{/lang}</a></li>
			</ul>
		</div>

		<!-- What Is Good For -->
		<div class="res_row" id="pinet_business">
	      <ul class="nav navbar-nav nav-title">
	        <li>
	        	<p>{lang}WHAT IS PINET BUSINESS WI-FI?{/lang}</p>
				<p class="info">{lang}The new way to reach your targeted audiences using Wi-Fi.<br>  It changes the way business share their Wi-Fi, get Pinet Business Wi-Fi and let your Wi-Fi and let your Wi-Fi market for you{/lang}</p>
	        </li>
	      </ul>
	      <ul class="nav navbar-nav nav-content">
	        <li>
	        	<p>{picture path='/responsive/size' alt=$title title=$title src='home/business_ibox_icon.png'}</p>
	        	<p class="title">Pinet iBox</p>
	        	<p class="info">The innovative device which transforms  your Wi-Fi into an effective marketing tool.</p>
	        </li>
	        <li>
	        	<p>{picture path='/responsive/size' alt=$title title=$title src='home/business_cloud_icon.png'}</p>
	        	<p class="title">Pinet Cloud</p>
	        	<p class="info">The cloud application for all your business analytics and CRM needs.</p>
	        </li>
	        <li>
	        	<p>{picture path='/responsive/size' alt=$title title=$title src='home/business_service_icon.png'}</p>
	        	<p class="title">Pinet On-Site service</p>
	        	<p class="info">The professional ease of mind service which gets you up andrunning with Pinet Business Wi-Fi.</p>
	        </li>
	      </ul>
		</div>

		<div class="banner-row" id="what_is_good_for">
			<div class="jumbotron">
			  <h1>WHAT CAN PINET BUSINESS WI-FI DO FOR YOU?</h1>
			  <p class="jumbotron-text">Pinet Business Wi-Fi transforms your Wi-Fi into an automated marketing tool, from the moment you connect to the store Wi-Fi, the customized portal page shows the latest in store offers andpromotions.</p>
			</div>
		</div>

		<div id="what_is_good_for_content" class="res_row">
			<ul class="nav navbar-nav nav-content">
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/wifi_ad_icon.png'}</p>
					<p class="info">Login using the most popular social media accounts such as Wechat and Weibo, rapidly buildup your business social following and exposure.</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/wifi_login_icon.png'}</p>
					<p class="info">Monitor your Wi-Fi usage and gather data about how your customers use Wi-Fi, make use of Pinet Business Analytics and get to know your customers.</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/wifi_monition_icon.png'}</p>
					<p class="info">The Pinet Business Wi-Fi solution includes a complete set of robust features to meet your needs.Centralized management </p>
				</li>
			</ul>
		</div>

		<div id="how_it_works" class="res_row">
			<ul class="nav navbar-nav nav-text">
			<li>
				<h1>{lang}HOW DOES IT WORK?{/lang}</h1>
				<p class="info">{lang}The Pinet Business Wi-Fi solution includes a complete set of robust features to meet your needs.{/lang}</p>
			</li>
			</ul>
			<ul class="nav navbar-nav nav-content ibox_management_nav">
			<li>
				<p>{picture path='/responsive/size' alt=$title title=$title src='home/work_ibox_management_bg.png'}</p>
			</li>
			<li>
				<p class="title">{lang}Centralized management{/lang}</p>
				<p class="info">{lang}Manage all your iBoxes in one place{/lang}</p>
			</li>
			</ul>
			<ul class="nav navbar-nav nav-content cloud_managment_nav">
			<li>
				<p class="title">{lang}Cloud managed devices{/lang}</p>
				<p class="info">{lang}Change and apply settings to your iBusiness Box anytime, anywhere{/lang}</p>
			</li>
			<li>
				<p>{picture path='/responsive/size' alt=$title title=$title src='home/work_cloud_service_bg.png'}</p>
			</li>
			</ul>
			<ul class="nav navbar-nav nav-content business_nav">
			<li>
				<p>{picture path='/responsive/size' alt=$title title=$title src='home/work_business_analytics_bg.png'}</p>
			</li>
			<li>
				<p class="title">{lang}LBS based business analytics{/lang}</p>
				<p class="info">{lang}Find out more about your customers with our Wi-Fi tracking system and business analytics{/lang}</p>
			</li>
			</ul>
		</div>

		<div class="banner-row" id="case_studies">
			<div class="jumbotron">
			  <h1>INDUSTRY APPLICATIONS AND BUSINESS CASE STUDIES</h1>
			  <p class="jumbotron-text" > The Pinet Business Wi-Fi  solution includes a complete set of robust features to meet you needs.</p>
			</div>
		</div>

		<div id="get_it_now" class="res_row">
			{form attr=['novalidate'=>''] action="{site_url url='welcome/request'}" method="POST"}
				<ul class="nav navbar-nav nav-text">
					<li>
						<h1>{lang}GET PINET BUSINESS WI-FI{/lang}</h1>
						<p class="info">{lang}Getting Pinet Business Wi-Fi is simple, just fill out the form  below and our sales representative will be in touch.{/lang}</p>
					</li>
					</ul>
					<ul class="nav navbar-nav nav-content">
					<li>
						<input type="text" class="form-control" placeholder="Name" name="request_name">
					</li>
					<li>
						<input type="text" class="form-control" placeholder="Email" name="request_email_address">
					</li>
					<li>
						<input type="text" class="form-control" placeholder="Contact Number" name="request_contact_number">
					</li>
					</ul>
					<ul class="nav navbar-nav nav-content">
					<li>
						<input type="text" class="form-control" placeholder="Company Name" name="request_company_name">
					</li>
					<li>
						<input type="text" class="form-control" placeholder="Company Address" name="request_company_address">
					</li>
					<li>
						<input type="text" class="form-control" placeholder="Type of Industry" name="request_industry_type">
					</li>
					</ul>
					<ul class="nav navbar-nav nav-content btn-send-request">
					<li>
						<input type="submit" class="btn pinet-btn-cyan" value="SEND REQUEST">
					</li>
				</ul>
			{/form}
	 	</div>

		<div id="the_process" class="res_row">
			<ul class="nav navbar-nav nav-text">
				<li>
					<h1>{lang}THE PROCESS{/lang}</h1>
				</li>
			</ul>
			<ul class="nav navbar-nav nav-content">
				<li>
					<p class="content">sstdsydts</p>
				 	{picture path='/responsive/size' alt=$title title=$title src='home/inquire_icon.png'}
					<p class="info">INQUIRE</p>
				</li>
				<li>
					<p class="content">sstdsydts</p>
				 	{picture path='/responsive/size' alt=$title title=$title src='home/site_survey_icon.png'}
					<p class="info">SITE-SURVEY</p>
				</li>
				<li>
					<p class="content">sstdsydts</p>
				 	{picture path='/responsive/size' alt=$title title=$title src='home/plan_icon.png'}
					<p class="info">PLAN</p>
				</li>
				<li>
					<p class="content">Once the contract is signed we will arrange a date for t-he installation</p>
				 	{picture path='/responsive/size' alt=$title title=$title src='home/install_icon.png'}
					<p class="info">INSTALL</p>
				</li>
				<li>
					<p class="content">sstdsydts</p>
				 	{picture path='/responsive/size' alt=$title title=$title src='home/enjoy_icon.png'}
					<p class="info">ENJOY</p>
				</li>
			</ul>
		</div>

		<div id="partner" class="res_row">
			<ul class="nav navbar-nav nav-text">
				<li>
					<p>{lang}PARTNERSHIPS & RESELLERS{/lang}</p>
				</li>
			</ul>
			<ul id="nav-icon" class="nav navbar-nav nav-content">
				<li class="reseller_deer">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_deer_icon.png'}
				</li>
				<li class="reseller_dashag">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_dashag_icon.png'}
				</li> 
				<li class="reseller_tidy">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_tidy_icon.png'}
				</li>
				<li class="reseller_smiling">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_smiling_icon.png'}
				</li>	
				<li class="reseller_coin">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_coin_icon.png'}
				</li>
				<li class="reseller_pixelo">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_pixelo_icon.png'}
				</li> 
				<li class="reseller_elify">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_elify_icon.png'}
				</li>
				<li class="reseller_eq">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_eq_icon.png'}
				</li>	
				<li class="reseller_boat">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_boat_icon.png'}
				</li>
				<li class="reseller_tree">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_tree_icon.png'}
				</li> 
				<li class="reseller_writehouse">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_writehouse_icon.png'}
				</li>
				<li class="reseller_oizo">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_oizo_icon.png'}
				</li>	
				<li class="reseller_pas">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_pas_icon.png'}
				</li>
				<li class="reseller_recess">
					{picture path='/responsive/size' alt=$title title=$title src='home/reseller_recess_icon.png'}
				</li>
			</ul>
		</div>

		<div id="about_us" class="res_row">
			<ul class="nav navbar-nav nav-text">
				<li>
					<p>{lang}ABOUT US{/lang}</p>
					<p class="info">{lang}We are a team of passionate believers that technology brings innovations to business solutions. With our collective expertise in technology, marketing, business analytics, we work together to develop seamless solutions for businesses.{/lang}</p>
				</li>
			</ul>
			<ul id="nav-btn-group" class="nav navbar-nav nav-content">
				<li>
					<p class="info">SOLUTION MUST CREATE CLIENT VALUE</p>
				</li>
				<li>
					<p class="info">INNOVATION IS THE KEY TO SUCCESS</p>
				</li>
				<li>
					<p class="info">QUALITY WORK BRINGS SMILES</p>
				</li>
				<li>
					<p class="info">RESPONSIBILITY</p>
				</li>
				<li>
					<p class="info">INTEGRITY</p>
				</li>
				<li>
					<p class="info">TEAMWORK</p>
				</li>
			</ul>
		</div>

		<div id="our_team" class="res_row">
			<ul class="nav navbar-nav nav-text">
				<li>
					<p>{lang}MEET OUR TEAM{/lang}</p>
				</li>
			</ul>
			<ul id="nav-team" class="nav navbar-nav nav-content">
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/james_logo.png'}</p>
					<p class="title">CEO</p>
					<p class="info">JAMES</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/jack_logo.png'}</p>
					<p class="title">CTO</p>
					<p class="info">JACK</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/nathan_logo.png'}</p>
					<p class="title">PARTNER/E SYSTEMS</p>
					<p class="info">NATHAN</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/moor_logo.png'}</p>
					<p class="title">COO</p>
					<p class="info">MOOR</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/tommy_logo.png'}</p>
					<p class="title">CMO</p>
					<p class="info">TOMMY</p>
				</li>
			</ul>
		</div>

		<!-- footer -->
		<div id="contact_us" class="res_row">
			<ul class="nav navbar-nav nav-text">
				<li>
					<p>{lang}FIND US{/lang}</p>
				</li>
			</ul>
			<ul id="nav-address" class="nav navbar-nav nav-content">
				<li>
					<p class="info">Suzhou Pyle Network Technology Co., Ltd. Suzhou City, Jiangsu Province Star Lake Street, 328 Industrial Park 15 506 Creative Industry Park</p>
				</li>
				<li>
					<p class="info">Suzhou Pyle Network Technology Co., Ltd. Anhui Branch Luyang District, Hefei, Anhui Changjiang Road, Renhe Building 1106</p>
				</li>
				<li>
					<p class="info">Suzhou Pyle Network Technology Co., Ltd. Hubei Branch Hongshan District, Wuhan City, Hubei Province Guangbutun Central China Digital City 7018</p>
				</li>
			</ul>
			<ul  id="copyright" class="nav navbar-nav nav-text">
				<li>
					<p class="logo">{picture path='/responsive/size' alt=$title title=$title src='home/logo_grey.png'}</p>
					<p class="info">©COPY RIGHT PINET,INC TERMS,PRIVACY,CONTACT</p>
					<p class="email"><a target="_top" href="mailto:info@pinet.co">info@pinet.co</a></p>
				</li>
				</ul>
				<ul id="sns-link" class="nav navbar-nav nav-content">
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/wechat_login_icon.png'}</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/weibo_login_icon.png'}</p>
				</li>
				<li>
					<p>{picture path='/responsive/size' alt=$title title=$title src='home/qq_login_icon.png'}</p>
				</li>
			</ul>
		</div>

	</div>
{/block}
{block name=foot}
{js}
<script>
	function initialise() {
		$("#the_process .nav-content").on('mouseenter','li',function(e){
			var self = $(this);
			self.find('.content').show();
		});
		$("#the_process .nav-content").on('mouseleave','li',function(e){
			var self = $(this);
			self.find('.content').hide();
		});	

        var login_modal = $("#login-modal");
        login_modal.find('.cancel').on('click', function(e){
        	e.preventDefault();
        	login_modal.modal('hide');
        })
	}

	$(function(){
        $(document).ready( function() {
          $('.navbar-wrapper').stickUp({
            parts: {
              0: 'pinet_business',
              1: 'what_is_good_for',
              2: 'how_it_works',
              3: 'case_studies',
              4: 'get_it_now',
              5: 'contact_us',
              6: 'wordpress',
              7: 'contact'
            },
            itemClass: 'menu-item',
            itemHover: 'active'
          });
        });

        $('#ok-btn').on('click', function(e){
            $.ajax({
                type: "POST",
                url: "{site_url url='welcome/login'}",
                dataType: "json",
                data: { password: $('#password').val(), username: $('#username').val() },
                success : function(data){
                    if(data.success){
                        window.location = data.msg;
                    }else{
                        $('#error_msg').html(data.msg);
                        $('#error_msg').removeClass('hidden');
                    }
                }
            });
        })
	})
</script>
{/block}
{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
<style>

</style>
{/block}
{block name=body}
	<div class="container">
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

		</div>

		<!-- send mail -->

		<div class="center-row" id="send_mail">
	      <ul class="nav navbar-nav nav-head">
	        <li>
	          <div class="response_row messagesbar">
		  {alert}
 		 </div>  
	        </li>
	      </ul>
	      <ul class="nav navbar-nav nav-body">
	        <li>
	            {form class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='account/register'}" method="POST"}
					<div class="panel panel-default">
					  <div class="panel-heading">{lang}Register{/lang}</div>
					  <div class="panel-body">
					  
					   <div class="info"> {lang}Personal Information{/lang}</div>
					    {field_group field='name' layout=['element' => 9]}{/field_group}
					      {field_group field='email_address' layout=['element' => 9]}{/field_group}
					       {field_group  field='username' layout=['element' => 9]}{/field_group}
					     <div class="row">
					  	     {field_group  field='password' class='col-1280-6' layout=['label' => 4,'element' => 6]}
					  	{password}
					  	      {/field_group}
					  	   {field_group field='password_confirm' class='col-1280-6' layout=['label' => 4,'element' => 6]} {password}{/field_group}
					  	   </div>
					  	    {field_group  field='mobile'  layout=['element' => 9]}{/field_group}
					  
 					
 					  <div class="row">
				                    {field_group class="col-1280-6 " field='birthday' layout=['label' => 4,'element' => 6]}{/field_group}
				                    {field_group class="col-1280-6" field='sex' layout=['label' => 4,'element' => 6]}
				                        {select options=$sexs}
				                        {/select}                     
				                    {/field_group}
				                </div>
				                <br><br><br>
 				    <div class="info"> {lang}Company Information{/lang}</div>
 				       {field_group  field='contact_company'  layout=['element' => 9]}{/field_group}
 				        {field_group  field='contact_street' layout=['element' => 9]}     {/field_group}
				
					 <div class="row">
					  	       {field_group layout=['label' => 4,'element' => 6] field='contact_city' class='col-1280-6'}
					  	      
					  	        {/field_group}

					  	      {field_group  field='contact_postalcode' class='col-1280-6' layout=['label' => 4,'element' => 6]}
					  	      	
					  	        {/field_group}
					  	       
					</div>
					 <div class="row">
					  	     

					  	       {field_group  layout=['label' => 4,'element' => 6] field='contact_province' class='col-1280-6'} {/field_group}
					  	 {field_group field='contact_country' class='col-1280-6' layout=['label' => 4,'element' => 6]}
					  	      {input}
					  	      {/field_group}
					</div>
							
  						
					  	     {field_group field='contact_profile' layout=false}
					  	   {label class='col-1280-2'}
						       {textarea class='col-1280-9'}
					  	     {/field_group}

                          {input field='id' type='hidden'}
 			
					    <input class="btn pinet-btn-blue" type="submit" value="{lang}Submit{/lang}">
					  </div>
					</div>
				{/form}
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
<script type="text/javascript">
$(function(){
    

    $("#field_birthday").datepicker({
        language: "zh-CN",
        format: "yyyy-mm-dd"
    });

})
</script>
{/block}
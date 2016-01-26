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
			{form class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='welcome/login'}" method="POST"}
			    <div class="modal-content">
			      <div class="modal-header">
			        <h4 class="modal-title" id="myModalLabel">{lang}Sign in{/lang}</h4>
			      </div>
			      <div class="modal-body">
			      	<div class="col-1280-8 pinet-form-input">
			      		<input type="text" name="username" class="form-control" placeholder="{lang}User ID{/lang}">
			      		<div class="help-block"></div>
			      	</div>
			      	<div class="col-1280-8 pinet-form-input">
			      		<input type="password" name="password" class="form-control" placeholder="{lang}Password{/lang}">
			      		<div class="help-block"></div>
			      	</div>
			      	<p class="pull-right"><a class="forget-password-link" href="">{lang}I forget my password{/lang}</a></p>
			      </div>
			      <div class="modal-footer">
  			        <input type="submit" class="btn pinet-btn-cyan ok" value="{lang}OK{/lang}" >
			        <button type="reset" class="btn pinet-btn-grey cancel">{lang}Cancel{/lang}</button>
			      </div>
			    </div>
		    {/form}
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
	           {form class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='welcome/forget_password'}" method="POST"}
					<div class="panel panel-default">
					  <div class="panel-heading">{lang}Registration Page {/lang}</div>
					  <div class="panel-body">
					
					  <div class="registration-form">
					  	<div class="info"> {lang}Pinet WIFI Box Information{/lang}</div>
					  	  {field_group field='box_name'  layout=false}
					  	  {label}
					  	     <p class="help-block">Please name your Pinet WiFi Box This is for your reference only</p>
					  	  {input}
					  	  {/field_group}

					  	  {field_group field='hostname' layout=false}
					  	  {label}
					  	     <p class="help-block">This is the hostname of your box, can't be changed </p>
					  	  {input}
					  	  {/field_group}

					  	     {field_group field='manual' layout=false}
					  	       {label}
					  	     {/field_group}
						           <div class="row">
					  	      {field_group  layout=false field='manual' class='col-1280-8'}
					  	          {input}
					  	      {/field_group}

					  	      {field_group layout=false field='address' class='col-1280-4'}
					  	      	  {input}
					  	        {/field_group}
							</div>
							  <div class="row">
					  	     {field_group  layout=false field='city' class='col-1280-6'}
					  	      {input}
					  	      {/field_group}

					  	   {field_group  layout=false field='china' class='col-1280-6'} {input}{/field_group}
					  	   </div>
  						<div class="row">
					  	     {field_group  layout=false field='state' class='col-1280-6'} {input}{/field_group}
					  	   {field_group  field='zipcode' layout=false class='col-1280-6'} {input}{/field_group}
					  	   </div>
					  	     {field_group field='notes' layout=false}
					  	        {label}
						       {textarea}
					  	     {/field_group}
					  	  
					  	    
					  </div>
					   <div class="registration-map">
					  	<div class="info"> {lang} Location<br>
					  	Please pinpoint the location of your business using
					  	Maps and manually enter the full address {/lang}</div>
					  	<div class="row">
					  	   {field_group class='col-1280-11' field='search' layout=false} 
					  	   {input}
						   {/field_group}
						    <button class='search'><i class="glyphicon glyphicon-search"></i></button> 
						    </div>
					                 <div class="map">
					  	   </div>
					  </div>
					 
					  
				
				
					  </div>
						   <input class="btn pinet-btn-blue" type="submit" value="{lang}Submit{/lang}"> 
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
{/block}
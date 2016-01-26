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
			      	<p class="pull-right"><a class="forget-password-link" href="{site_url url='welcome/forget_password'}">{lang}I forget my password{/lang}</a></p>
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

			<div class="jumbotron">
			  <h1>404</h1>
			  <p class="jumbotron-text">PAGE NOT FOUND</p>
			   <p class="jumbotron-text info">IT'S OKAY .WE KNOW IT WASN'T YOUR FAULT.</p>
			  
			</div>
		</div>

	</div>
{/block}
{block name=foot}
{js}
{/block}
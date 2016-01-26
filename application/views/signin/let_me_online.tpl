{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
	<div class="container">
		{header}
            <div id="head" class="row">
                {figure action='http://www.pinet.co' path='/responsive/size' class='col-320-4 col-1280-3' src=$logo title=$company}
                {/figure}
                {h1 class='col-320-8 col-1280-9'}<span>{lang}Login{/lang}</span>{lang}You can choose the ways below{/lang}{/h1}
            </div>        
		{/header}
		{sect name='buttons'}
			<div id="content" class="row">
				<ul id="buttons">
                    {if $login_wechat=='on'}
					<li class="col-320-6 col-1280-3">
						{a id='wechat_button' class='signin_button' uri='oauth/session/wechat' title='Wechat Login'}
					</li>
                    {/if}
                    {if $login_weibo=='on'}
					<li class="col-320-6 col-1280-3">
						{a id='weibo_button' class='signin_button' uri='oauth/session/weibo' title='Weibo Login'}
					</li>
                    {/if}
                    {if $login_qq=='on'}
					<li class="col-320-6 col-1280-3">
						{a id='qq_button' class='signin_button' uri='oauth/session/qq' title='QQ Login'}
					</li>
                    {/if}
                    {if $login_yixin=='on'}
					<li class="col-320-6 col-1280-3">
						{a id='yixin_button' class='signin_button' uri='oauth/session/yixin' title='Yixin Login'}
					</li>
                    {/if}
				</ul>
			</div>
		{/sect}
		{footer}
			<div id="foot">
				<div id="legal" class="row">
					{lang}Provide to you by{/lang}{link uri='http://www.pinet.co'}{figure src='pinet_footer_logo.png'
                    media320='32' media480='48' media640='64'  media720='72' title='Pinet'}{/figure}{/link}{lang}Suzhou Pinet Network Technology Co., Ltd. to provide technical support{/lang}
				</div>
			</div>
		{/footer}
	</div>
{/block}
{block name=foot}
{js}
{/block}

{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
	{header}
		<div class="container">
			<div id="head" class="row">
				{figure path='/responsive/size' class='col-320-4 col-1280-3' src=$logo title=$company}
				{/figure}
				{h1 class='col-320-8 col-1280-9'}{$company} {lang}description{/lang}{/h1}
			</div>
		</div>
	{/header}
	<div class="container">
       	{sect name='content'}
            <div id="content-bg">
                <div id="content" class="row"> 
                    <div class="col-1280-12">
                        {p}              
                        {picture path='/responsive/size' class='col-320-12 col-1280-3' alt=$company src=$photo}
                        {$introduction}
                        {/p}                        
                    </div>          
                </div>          
            </div>
        {/sect}		
	</div>
	{footer}
		<div id="foot">
			<div id="legal" class="row">
				{lang}Provide to you by{/lang}{link uri='http://www.pinet.co'}{figure src='pinet_footer_logo.png' media320='32'
				media480='48' media640='64'  media720='72'}{/figure}{/link}{lang}Suzhou Pinet Network Technology Co., Ltd. to provide technical support{/lang}
			</div>
			<div id="ads" class="row">
				{link id="ad-left" class='ad col-1280-6 col-320-12' uri='/'}
					{figure path='/responsive/size' src='ad1.png' title=$company} {/figure}
				{/link}
				{link id="ad-right" class='ad col-1280-6 col-320-12' uri='/'}
					{figure path='/responsive/size' src='ad2.png' title=$company} {/figure}
				{/link}
			</div>
		</div>
	{/footer}
{/block}
{block name=foot}
{js}
{/block}

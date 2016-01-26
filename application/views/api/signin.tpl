{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
    <div class="container">
        {header}
            <div id="head" class="row">
                {figure action='http://www.pinet.co' path='/responsive/size' class='col-320-4 col-1280-3' src=$logo title=$company}
                {/figure}
                {h1 class='col-320-8 col-1280-9'}{$contents}{/h1}
            </div>
        {/header}
        {sect name='buttons'}
            <div id="content" class="row">
                <ul id="buttons">
                    <li id="left_button" class="col-1280-4 text-right">
                        {a id='merchant_description' class='signin_button' uri='signin/merchant/description' title='Description'}
                    </li>
                    <li id="middle_button" class="col-1280-4 text-center">
                        {a id='merchant_activities' class='signin_button' uri='signin/activities' title='Activities'}
                    </li>
                    <li id="right_button" class="col-1280-4 text-left">
                        {a id='let_me_online' class='signin_button' uri='signin/let_me_online' title='Let Me Online'}
                    </li>
                </ul>
            </div>
        {/sect}
        {footer}
            <div id="foot">
                <div id="legal" class="row">
                    {lang}Provide to you by{/lang}{link uri='http://www.pinet.co'}{figure src='pinet_footer_logo.png'
                    media320='32' media480='48' media640='64'  media720='72' title='Pinet'}{/figure}{/link}{lang}Suzhou Pinet Network Technology Co., Ltd. to provide technical support{/lang}
                </div>
                <div id="ads" class="row">
                    {link id="ad-left" class='ad col-1280-6 col-320-12' uri='/'}
                    {figure path='/responsive/size/' src='ad1.png' title=$company} {/figure}
                    {/link}
                    {link id="ad-right" class='ad col-1280-6 col-320-12' uri='/'}
                    {figure path='/responsive/size' src='ad2.png' title=$company} {/figure}
                    {/link}
                </div>
            </div>
        {/footer}
    </div>
{/block}
{block name=foot}
    {js}
{/block}

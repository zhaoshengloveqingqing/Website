{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}USER & ACCOUNT SETTINGS{/lang}</div>
  <div class="col-1280-2 info">
    <a class="logo" data-original-title="right" data-placement="bottom" data-toggle="tooltip" path="/responsive/size" src="ibox_status.png">
        {picture path='/responsive/size' alt='$title' src='user-logo.png'}
    </a>  
    <a class="content" data-original-title="right" data-placement="bottom" data-toggle="tooltip" path="/responsive/size" src="ibox_status.png">
    DOUDOU
    </a>       
  </div>
{/block}
{block name=workbench}
    <div class="response_row toolbar">
    </div>
    <div class="response_row messagesbar">
        {alert}
    </div>
{/block}
{block name=aside}
    <ul class='subnavi parent'>
        <li>
            <h3>{lang}Account Settings{/lang}</h3>
            <ul class="subnavi parent">
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$account_menus['account_summary'] type='subnavi'}
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$account_menus['change_password'] type='subnavi'}
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$account_menus['reset_password'] type='subnavi'}
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

    </ul>
{/block}
{block name=foot append}
<script type="text/javascript">
$(function(){
})
</script>
{/block}

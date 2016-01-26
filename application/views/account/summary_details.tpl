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
        <a class="btn pinet-btn-blue edit" href="{$edit_url}">{lang}Edit{/lang}</a>
        <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
            ?
        </div>   
    </div>  

    <div class="response_row messagesbar">
       {alert}
  </div>   
  <div class="response_row scrollcontent">
    <div class="panel panel-default scrollcontent-inner">
    <div class="panel-body"> 
         <div class="row absolute">
          <div class="col-1280-12">{picture path='/responsive/size' src=$profile_image_path class='img'}</div>
        </div>
        {field_group field='username' layout=['element' => 7]}
        {/field_group}
        {field_group field='email_address' layout=['element' => 7]}
        {/field_group}
        {field_group layout=['element' => 7] field='last_name'}
        {/field_group}
        {field_group  layout=['element' => 7] field='first_name'}
        {/field_group}
        {field_group class='col-1280-6' field='birthday' layout=['label' => 4,'element' => 7]}
        {/field_group}
        {field_group class='col-1280-6 ' field='sex' layout=['label' => 4,'element' => 7]}
        {/field_group}
        {field_group class='col-1280-12' field='mobile'}
        {/field_group}
        {field_group class='col-1280-12' field='contact_company'}
        {/field_group}
        {field_group class='col-1280-12' field='contact_street'}
        {/field_group}
        {field_group class='col-1280-12' field='contact_city'}
        {/field_group}
        {field_group class='col-1280-6' field='contact_province' layout=['label' => 4,'element' => 7]}
        {/field_group}
        {field_group class='col-1280-6' field='contact_postalcode' layout=['label' => 4,'element' => 7]}
        {/field_group}
        {field_group class='col-1280-12' field='contact_profile'}
        {/field_group}
      </div>
    </div>  
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

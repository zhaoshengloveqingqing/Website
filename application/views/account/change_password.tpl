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
    <a id="save-btn" class="btn pinet-btn-cyan ok">{lang}OK{/lang}</a>
    <a id="cancel-btn" class="btn pinet-btn-grey cancel">{lang}Cancel{/lang}</a> 
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
      {form id="form" class='form-horizontal' attr=['novalidate'=>'']}
            {field_group field='password' layout=['element' => 6]}
              {password}
            {/field_group}
           {field_group field='new.password' layout=['element' => 6]}
             {password}
           {/field_group}     
           {field_group field='password.confirm' layout=['element' => 6]}
            {password}
           {/field_group}     
      {/form}                      
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
    $("#save-btn").on('click', function(){
        $("#form").submit();
    });
    $("#cancel-btn").on('click', function(){
        window.location.href = "{site_url url='account/index'}";
    });
})
</script>
{/block}

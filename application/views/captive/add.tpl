{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}CAPTIVE PORTAL SETTINGS{/lang}</div>
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
    <a id="save" class="btn pinet-btn-green add">{lang}Save{/lang}</a>
    <a id="save_and_continue" class="btn pinet-btn-blue save_continue">{lang}Save & Continue{/lang}</a>
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
      {form id='form' class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='captive/add'}" method="POST"}
        <div class="row">
            {field_group class="col-1280-6"  field='firewall_rules_protocol' layout=['label' => 4,'element' => 7]}
              {select options=[BOTH=>BOTH,TCP=>TCP,UDP=>UDP]}
              {/select}
            {/field_group}    
            {field_group class="col-1280-6"  field='firewall_rules_action' layout=['label' => 4,'element' => 7]}
               {select options=[ALLOW=>ALLOW,BLOCK=>BLOCK]}
              {/select}
            {/field_group}    
                </div>
              <div class="row">
             {field_group  class="col-1280-6" field='firewall_rules_ip_address' layout=['label' => 4,'element' => 7]}{/field_group}
             {field_group class="col-1280-6"  field='firewall_rules_port' layout=['label' => 4,'element' => 7]}{/field_group}
            
             </div>
              {field_group field='firewall_rules_comments'}
           
                {textarea}
            {/field_group}
            {input field='save_type' type='hidden'}
      {/form}                      
      </div> 
    </div>  
  </div>
{/block}
{block name=aside}
    <ul class='subnavi parent'>
        {section name=i loop=$navigations}
            {if ($navigations[i]->subnavi)}
                <li>
                    <h3>{$navigations[i]->label}</h3>
                    <ul class="subnavi parent">
                        <li>
                            <ul class="subnavi">
                                {section name=j loop=$navigations[i]->subnavi}
                                    {if ($navigations[i]->subnavi[j]->controller == $navigations[i]->controller && $navigations[i]->subnavi[j]->method == $navigations[i]->method)}
                                        <li>{action obj=$navigations[i]->subnavi[j] type='subnavi'}</li>
                                    {else}
                                        <li>{action obj=$navigations[i]->subnavi[j] type='subnavi'}</li>
                                    {/if}
                                {/section}
                            </ul>
                        </li>
                    </ul>
                </li>
            {/if}
        {/section}
    </ul>
{/block}
{block name=foot append}
<script type="text/javascript">
    $(function(){
        $("#save").on('click', function(){
            $('#field_save_type').val('on');
            $('#form').submit();
        });
        $("#save_and_continue").on('click', function(){
            $('#form').submit();
        });
    })
</script>
{/block}

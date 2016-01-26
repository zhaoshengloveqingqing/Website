{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}NETWORK SETTINGS{/lang}</div>
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
    <div class="btn-group switch-box switch-box-cyan " data-toggle="buttons">
        {container name='lan'}
        {states}
        {state name="readonly"}
            <label class="btn active">
                <input type="radio" name="rd_lan" id="rd_lan_dhcp" autocomplete="off"> {lang}DHCP{/lang}
            </label>
            <label class="btn">
                <input type="radio" name="rd_lan" id="rd_lan_manual" autocomplete="off">{lang}Manual{/lang}
            </label>
        {/state}
        {state}
            <label class="btn">
                <input type="radio" name="rd_lan" id="rd_lan_dhcp" autocomplete="off"> {lang}DHCP{/lang}
            </label>
            <label class="btn active">
                <input type="radio" name="rd_lan" id="rd_lan_manual" autocomplete="off">{lang}Manual{/lang}
            </label>
        {/state}
        {/states}
        {/container}
        </div>        
    <a id="btn-save" class="btn pinet-btn-green save">{lang}Save{/lang}</a>
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
          {form id="lan-form" class='form-horizontal' attr=['novalidate'=>'']}
          {field_group field='lan_ip_address'  layout=['element' => 6]}{/field_group}
          {input field='lan_type' type='hidden'}
          {input field='radio_switch' type='hidden'}
          {container name='lan'}
          {states}
          {state name="readonly"}
          {field_group field='lan_ip_mask'  layout=['element' => 6]}{/field_group}
          {field_group field='lan_ip_router'  layout=['element' => 6]}{/field_group}
          {field_group field='lan_ip_dns'  layout=['element' => 6]}{/field_group}
          {/state}
          {state}
          {field_group field='lan_ip_mask'  layout=['element' => 6]}{/field_group}
          {field_group field='lan_ip_router'  layout=['element' => 6]}{/field_group}
          {field_group field='lan_ip_dns'  layout=['element' => 6]}{/field_group}
          {/state}
          {/states}
          {/container}
          {/form}
      </div>
    </div>  
  </div>
{/block}
{block name=aside}
 
  <ul class='subnavi parent'>
    <li>
      <h3>{lang}Network Settings{/lang}</h3>
      <ul class="subnavi parent">
        <li>
          <ul class='subnavi'>
            <li>
                {action obj=$network_menus['network_lan'] type='subnavi'}
            </li>
          </ul>
        </li>
          <li>
              <ul class='subnavi'>
                  <li>
                      {action obj=$network_menus['network_wlan'] type='subnavi'}
                  </li>
              </ul>
          </li>
         <li>
          <ul class='subnavi'>
            <li>
                {action obj=$network_menus['network_ibox_basic'] type='subnavi'}
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
        $("#btn-save").on('click', function(){
            $("#lan-form").submit();
        });
        $('input#rd_lan_dhcp').on('change', function(){
          var value = $(this).val();
          if(value == 'on') {
              $('#field_radio_switch').val('dhcp');
              $("#lan-form").submit();
          }
        }); 
        $('input#rd_lan_manual').on('change', function(){
          var value = $(this).val();
          if(value == 'on') {
              $('#field_radio_switch').val('manual');
              $("#lan-form").submit();
          }  
        });         
    })
</script>
{/block}
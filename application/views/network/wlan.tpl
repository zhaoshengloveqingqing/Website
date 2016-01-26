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
    <div class="btn-group switch-box switch-box-green " data-toggle="buttons">
        {container name='wlan'}
        {states}
        {state name="view"}
            <label class="btn on">
                <input type="radio" name="rd_wlan" id="rd_wlan_on" autocomplete="off"> {lang}ON{/lang}
            </label>
            <label class="btn off active">
                <input type="radio" name="rd_wlan" id="rd_wlan_off" autocomplete="off"> {lang}OFF{/lang}
            </label>
        {/state}
        {state}
            <label class="btn on active">
                <input type="radio" name="rd_wlan" id="rd_wlan_on" autocomplete="off"> {lang}ON{/lang}
            </label>
            <label class="btn off">
                <input type="radio" name="rd_wlan" id="rd_wlan_off" autocomplete="off"> {lang}OFF{/lang}
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
          {form id="wlan-form" class='form-horizontal' attr=['novalidate'=>'']}
              {field_group  field='wlan_ssid1' layout=['element' => 10]}{/field_group}
              {input field='wlan_switch' type='hidden'}
                  <div id="ssid1" for="wlan_ssid1"  class="btn">  <i class="glyphicon glyphicon-remove"></i></div>
              {field_group field='wlan_ssid2'  layout=['element' => 10]}{/field_group}
                  <div id="ssid2" for="wlan_ssid2" class="btn">  <i class="glyphicon glyphicon-remove"></i></div>
              {field_group class="channel" field="wlan_channel"}
              {select options=$channels}{/select}
              {/field_group}
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
{block name=foot}
{js}
<script type="text/javascript">
    $(function(){
        $("select").selectBoxIt();
        $('nav.navigations > a').tooltip();
        $('.faq').tooltip({
            viewport: {
                selector: '.workbench',
                padding: 0
            }
        });
        $("#btn-save").on('click', function(){
            $("#wlan-form").submit();
        });
        $('input#rd_wlan_on').on('change', function(){
            var value = $(this).val();
            if(value == 'on') {
                $('#field_wlan_switch').val('on');
            }
        });
        $('input#rd_wlan_off').on('change', function(){
            var value = $(this).val();
            if(value == 'on') {
                $('#field_wlan_switch').val('off');
            }
        });
        $("form .btn").on("click", function(){
            var self = $(this);
            var inputs = $(this).parent().find("input");
            inputs.each(function(){
                var inputName = $(this).attr('name');
                if(inputName == self.attr('for')) {
                    $(this).val('');
                }
            });
        });
    })
</script>
{/block}
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
    <a id="btn-save" class="btn pinet-btn-cyan ok">{lang}OK{/lang}</a>
    <a id="btn-cancel" class="btn pinet-btn-grey cancel">{lang}Cancel{/lang}</a>
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

        {form id="basic_form" class='form-horizontal' attr=['novalidate'=>'']}

                 {field_group field='serial'}{input state="readonly"}{/field_group}
                   <div class="row">
                {field_group class="col-1280-6" field='name'  layout=['label' => 4,'element' => 5]}{/field_group}
                 {field_group  class="col-1280-6"  field='owner_name'  layout=['label' => 4,'element' => 5]}{/field_group}
                 </div>
                {field_group field='mac'}{input state="readonly"}{/field_group}
                {field_group field='hostname'}{/field_group}     
                 {field_group field='ip'}{/field_group}     
                 {field_group field='status'}{/field_group}
                 {field_group field='notes'}{/field_group}     
                {field_group field='address'}{/field_group}     
                 {field_group field='search_name'  layout=['element' => 4]}{/field_group}
               
                {input field='longitude' type='hidden'}
                {input field='latitude' type='hidden'}
                 <div id="place_container">
                     <iframe src="{site_url url='/page/network/map'}" width="100%"></iframe>
                 </div>
      
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
    var map;
    function refreshLocationOnMap(longitude, latitude){
        map.clearOverlays();
        var point = new BMap.Point(longitude, latitude);
        var mk = new BMap.Marker(point);
        map.centerAndZoom(point, 13);
        map.addOverlay(mk);
    }

    $(function(){
        $("#btn-save").on('click', function(){
            $("#basic_form").submit();
        });
        $("#btn-cancel").on('click', function(){
            window.location.href = "{site_url url='network/index'}";
        });
    })
</script>
{/block}

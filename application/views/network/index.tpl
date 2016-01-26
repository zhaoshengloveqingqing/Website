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
    <input id="search-input" type="text" class="form-control" placeholder="{lang}Serial ID/Owner{/lang}">
    <a id="search-btn" class="btn pinet-btn-green search">{lang}Search{/lang}</a>
      <a class="btn pinet-btn-orange" id="btn-maintain">{lang}Maintain{/lang}</a>
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
      {datatable}                                           
      </div>
    </div>  
  </div>
{/block}
{block name=foot append}
<script type="text/javascript">
    function selectIDs(){
        var select_items = $("#datatable tr.ui-selected");
        var ids = [];
        select_items.each(function(){
            var link = $(this).find('a.datatable-toggle');
            var dataid = link.attr("dataid");
            if(dataid)
                ids.push(dataid);
        });
        var selectedIDs = ids.join(',');
        $('#field_ids').val(selectedIDs);
        return selectedIDs;
    }

    $(function(){
        datatable_init(); 

        $("#btn-maintain").on('click', function(){
            var select_items = $("#datatable tr.ui-selected");
            select_items.each(function(){
                var link = $(this).find('a.no_text_decoration');
                var data_id = link.attr("data-id");
                if(data_id)
                    window.location = "ibox_basic/"+data_id;
            });
        });
    })
</script>
{/block}

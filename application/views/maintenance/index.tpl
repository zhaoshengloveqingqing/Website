{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}IBOX MAINTENANCE{/lang}</div>
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
        {form id="search-form" class='form-horizontal' attr=['novalidate'=>''] method="POST"}
            <input id="search-input" type="text" class="form-control" placeholder="{lang}Serial ID/Owner{/lang}">
            <a id="search-btn" class="btn pinet-btn-green search">{lang}Search{/lang}</a>
            <a class="btn pinet-btn-green" id="ibox_update">
                {picture path='/responsive/size' alt='$title' src='upload.png'}
            </a>
            <a class="btn pinet-btn-blue" id="ibox_restart">
                {picture path='/responsive/size' alt='$title' src='reboot.png'}
            </a>
            <a class="btn pinet-btn-orange" id="ibox_log">
                {picture path='/responsive/size' alt='$title' src='file.png'}
            </a>
            <a id="btn-maintain" class="btn pinet-btn-orange">{lang}Maintain{/lang}</a>
        {input field='ids' type='hidden'}
        {input field='operation_type' type='hidden'}
        {/form}
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
{block name=aside}
{/block}
{block name=foot append}
<script type="text/javascript">
    function selectIDs(){
        var select_items = $("#datatable tr.ui-selected");
        var ids = [];
        select_items.each(function(){
            var link = $(this).find('a.datatable-toggle');
            var data_id = link.attr("data-id");
            if(data_id)
                ids.push(data_id);
        });
        var selectedIDs = ids.join(',');
        $('#field_ids').val(selectedIDs);
        return selectedIDs;
    }
    $(function(){
        datatable_init(); 

        $("#ibox_update").on('click', function(){
            if(selectIDs()){
                $('#field_operation_type').val('update');
                $("#search-form").submit();
            }
        });

        $("#ibox_restart").on('click', function(){
            if(selectIDs()){
                $('#field_operation_type').val('restart');
                $("#search-form").submit();
            }
        });

        $("#ibox_log").on('click', function(){
            if(selectIDs()){
                $('#field_operation_type').val('log');
                $("#search-form").submit();
            }
        });

        $("#btn-maintain").on('click', function(){
            var select_items = $("#datatable tr.ui-selected");
            select_items.each(function(){
                var link = $(this).find('a.datatable-toggle');
                var data_id = link.attr("data-id");
                if(data_id)
                    window.location = "ibox_app/"+data_id;
            });
        });
    })
</script>
{/block}

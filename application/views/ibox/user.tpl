{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}IBOX STATUS{/lang}</div>
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
          <input id="search-input" type="text" class="form-control" placeholder="{lang}Owner{/lang}">
          <div id="search-btn" class="btn pinet-btn-green search">{lang}Search{/lang}</div>
          <a class="btn pinet-btn-orange" id="ibox_status">
              {picture path='/responsive/size' alt='$title' src='stop.png'}
          </a>
      {input field='ids' type='hidden'}
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
    function selectIDs(){
        var select_items = $("#datatable tr.ui-selected");
        var ids = [];
        select_items.each(function(){
            var link = $(this).find('a.no_text_decoration');
            var data_id = link.attr("data-id");
            if(data_id)
                ids.push(data_id);
        });
        var selectedIDs = ids.join(',');
        $('#field_ids').val(selectedIDs);
        return selectedIDs;
    }

    $(function(){
        var datatable = $('#datatable').DataTable();
        var seach_input = $("#search-input");
        $('#search').on('click',function(){
            var search_input_value = seach_input.val();
            datatable.search(search_input_value).draw();
        });

        $("#ibox_status").on('click', function(){
            if(selectIDs()){
                $("#search-form").submit();
            }
        });
    })
</script>
{/block}
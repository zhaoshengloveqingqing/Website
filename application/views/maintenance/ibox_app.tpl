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
    <a id="add-btn" class="btn pinet-btn-blue add">{lang}Add{/lang}</a>
    <a id="update-all-btn" class="btn pinet-btn-green update-all">{lang}Upate All{/lang}</a>
    <div id="delete-all-btn" class="btn pinet-btn-blue delete-all">
        <i class="glyphicon glyphicon-remove"></i>
    </div>
    <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
      ?
    </div>
  </div> 
    <div class="response_row scrollcontent">
        {listview}
            <li class='listview_item_template test'>
                <div class="showbox ibox-showbox">
                    <div class="showbox-body">
                        <div class="ibox-logo">
                            {picture path='/responsive/size' alt=$title title=$title src='signin-let-me-online-wechat-active-mobile.png'}
                        </div>
                        <div class="ibox-info">
                            <p class="name">_(item)</p>
                            <p class="version">v1.2</p>
                        </div>
                    </div>
                    <div class="showbox-footer">
                        <div class="btn pinet-btn-green ibox-upload-btn">
                           <i class="glyphicon glyphicon-arrow-up"></i>
                        </div>
                        <div class="btn pinet-btn-delete ibox-delete-btn">
                            <i class="glyphicon glyphicon-remove"></i>
                        </div>
                    </div>
                </div>
            </li>
        {/listview}
    </div>
{/block}
{block name=aside}
    <ul class='subnavi parent'>
        <li>
            <h3>{lang}iBox Maintenance{/lang}</h3>
            <ul class="subnavi parent">
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$maintenance_menus['ibox_app'] type='subnavi'}
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$maintenance_menus['task_scheduler'] type='subnavi'}
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

    </ul>
{/block}
{block name=foot append}
{init_js}
<script>
    function initialise() {
        $("#add-btn").on('click',function(){
            alert(1);
        });

        $("#update-all-btn").on('click',function(){
            alert(2);
        });

        $("#delete-all-btn").on('click',function(){
            alert(3);
        });
    }
</script>
{/block}
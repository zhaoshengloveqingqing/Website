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
  
    <input id="search-input" type="text" class="form-control" placeholder="{lang}Serial ID/Owner{/lang}">
    <a id="search-btn" class="btn pinet-btn-green search">{lang}Search{/lang}</a>
    <a id="stop-btn" class="btn pinet-btn-orange stop">
      {picture path='/responsive/size' alt='$title' src='stop.png'}
    </a>
    <a id="next-btn" class="btn pinet-btn-green next">
      {picture path='/responsive/size' alt='$title' src='next.png'}
    </a>
  
    <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
      ?
    </div>
  </div> 
    <div class="response_row scrollcontent">
        {listview}
            <li class='listview_item_template test'>
                <div class="showbox ibox-showbox">
                    <div class="showbox-body">
                        
                        <div class="ibox-info">
                            <p class="number">Serial number</p>
                            <p class="name">_(users_username)</p>
                         </div>
                    </div>
                    <div class="showbox-footer">
                        <div class="btn ibox-info-date">
                              <p class="date">YYYY/MM/DD</p>
                                <p class="picture">{picture path='/responsive/size' alt='$title' src='direction_down.png'}</p>
                              <p class="date">YYYY/MM/DD</p>
                        </div>
                        <div class="btn ibox-stop-btn">
                            <a class="btn pinet-btn-orange ibox-stop">
                         {picture path='/responsive/size' alt='$title' src='stop.png'}
                             </a>

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
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$maintenance_menus['ibox_activation'] type='subnavi'}
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
        $("#search-btn").on('click', function(){
            var listview_api = $('#listview').data('api');
            var search_input = $('#search-input');
            listview_api.search(search_input.val());
        });

        $("#stop-btn").on('click', function(){

        });

        $("#next-btn").on('click', function(){

        });
    }
</script>
{/block}
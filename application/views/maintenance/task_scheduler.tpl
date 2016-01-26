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
   <a class="btn pinet-btn-cyan new" href="{$new_task_url}">{lang}New{/lang}</a>
    <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
      ?
    </div>
  </div>
    <div class="response_row messagesbar">
        {alert}
    </div>
    <div class="response_row scrollcontent">
        {listview}
            <li class='listview_item_template test'>
                <div class="showbox ibox-showbox">
                    <div class="showbox-body">
                        <div class="ibox-info">
                            <p class="title">{lang}Crontab{/lang}</p>
                            <p class="date">_(minute) _(hour) _(day) _(month) _(week) _(task)</p>
                        </div>
                    </div>
                    <div class="showbox-footer">
                        <div class="btn-group switch-box switch-box-green  ibox-upload-btn" data-toggle="buttons">
                          <label class="btn active">
                            <input type="radio" name="options" id="option2" autocomplete="off" value="on"> ON
                          </label>
                          <label class="btn">
                            <input type="radio" name="options" id="option3" autocomplete="off" value="off"> OFF
                          </label>
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
        var listview = $("#listview");

        listview.on('list.loaded', function(e, data){
            listview.find(".listview_item").each(function(){
                var listview_item = $(this);
                listview_item.find(".btn-group").each(function(){
                    var btn_group = $(this);
                    var checkedInputValue = data[''];

                    btn_group.find('input[type=radio]').each(function(){
                        var input = $(this);
                        if (checkedInputValue == input.attr('value')) {
                            input.data("checked", true);
                        }else {
                            input.data('checked', false);
                        }
                    });
                });

                listview_item.find(".btn-group").on('click', '.btn', function(e){
                    var curbtn = $(e.currentTarget);
                    var input = curbtn.find('input').length ? curbtn.find('input') : null;
                    if (input) {
                        var isChecked = input.data('checked');
                        if (!isChecked) {
                            curbtn.addClass('active');
                            curbtn.siblings().removeClass('active');
                            input.data('checked', true);
                            curbtn.siblings().find('input').data('checked', false);
                            $(this).trigger('btn-group.btn.checked', [curbtn, input]);
                        };
                    };
                });

                listview_item.on('click', '.ibox-delete-btn', function(e){
                    alert(1);
                });

                listview_item.find(".btn-group").on('btn-group.btn.checked', function(e, btn, input){
                    if (input.attr("value") == "on") {
                        alert("on");
                    }else {
                        alert("off");
                    }
                });
            });
        });
    }
</script>
{/block}
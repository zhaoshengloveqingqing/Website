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
   <a id="btn-save" class="btn pinet-btn-green save">{lang}Save{/lang}</a>
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
            {form id="scheduler-form" class='form-horizontal' attr=['novalidate'=>'']}
          <div class="row">
           
          {field_group class="col-1280-6"  field='month' layout=['label' => 4,'element' => 6]}{/field_group}
              {field_group class="col-1280-6"  field='day' layout=['label' => 4,'element' => 6]}{/field_group}
          
          </div>
           <div class="row">
            {field_group class="col-1280-6"  field='hour' layout=['label' => 4,'element' => 6]}{/field_group}
               {field_group class="col-1280-6"  field='minute' layout=['label' => 4,'element' => 6]}{/field_group}
          </div>
           {field_group field='week' class="week"}
                  <div class="btn-group" data-toggle="buttons">
                  <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="0">S
                  </label>
                  <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="1">M
                    </label>
                  <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="2">T
                  </label>
                  <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="3">W
                  </label>
                   <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="4">T
                  </label>
                   <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="5">F
                  </label>
                  <label class="btn btn-success">
                    <input type="checkbox" autocomplete="off" value="6">S
                  </label>
                </div>
             {/field_group}
            {field_group field='task' layout=['element' => 9]}
             {textarea}
            {/field_group}
            {input field='interval' type='hidden'}
             {/form}
      </div> 
    </div>  
  </div>
{/block}
{block name=foot append}
<script type="text/javascript">
    $(function(){
        $("#btn-save").on('click', function(){
            $("#scheduler-form").submit();
        });
        $("#btn-cancel").on('click', function(){
            window.location.href = "{$goback_url}";
        });

        var input_interval = $("input[name=interval]");

        $('.form-group.week').find('input[type=checkbox]').each(function(){
            if ($(this).attr("checked") == "checked") {
                $(this).data('checked', true);
            }else {
                $(this).data('checked', false);
            }
        });

        $('.form-group.week').on('click', '.btn', function(e){
            var curbtn = $(e.currentTarget);
            var input = curbtn.find('input[type=checkbox]');
            if (input) {
                if (input.data('checked')) {
                    input.data('checked', false);
                    $('#field_interval').val($('#field_interval').val().replace(','+input.val(), ''));
                }else {
                    input.data('checked', true);
                    if($('#field_interval').val().indexOf(input.val())<0)
                        $('#field_interval').val($('#field_interval').val()+','+input.val());
                }
            }
        });

    })
</script>
{/block}

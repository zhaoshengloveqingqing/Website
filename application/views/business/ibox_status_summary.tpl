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
      {container name='status'}
      {states}
      {state name="month"}
          <a id="month-btn" class="btn pinet-btn-blue date month">{lang}Month{/lang}</a>
          <a id="week-btn" class="btn pinet-btn-grey date week">{lang}Week{/lang}</a>
          <a id="day-btn" class="btn pinet-btn-grey date day">{lang}Day{/lang}</a>
      {/state}
      {state name="week"}
          <a id="month-btn" class="btn pinet-btn-grey date month">{lang}Month{/lang}</a>
          <a id="week-btn" class="btn pinet-btn-blue date week">{lang}Week{/lang}</a>
          <a id="day-btn" class="btn pinet-btn-grey date day">{lang}Day{/lang}</a>
      {/state}
      {state}
          <a id="month-btn" class="btn pinet-btn-grey date month">{lang}Month{/lang}</a>
          <a id="week-btn" class="btn pinet-btn-grey date week">{lang}Week{/lang}</a>
          <a id="day-btn" class="btn pinet-btn-blue date day">{lang}Day{/lang}</a>
      {/state}
      {/states}
      {/container}
    <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
      ?
    </div>
  </div>  
  <div class="response_row messagesbar">
      {alert}
  </div>            
  <div class="response_row scrollcontent">
    <div class="panel panel-default pinet-panel">
      <div class="panel-heading">
          <ul class="nav nav-stock">
             <li><div class="triangle-left prev"></div></li>
             <li>
                <div class="title">
                    {form class='form-horizontal' attr=['novalidate'=>''] action="" method="POST"}
                    <div class="input-daterange input-group" id="datepicker">
                        {field_group  field='begin' class='input-sm'}{/field_group}
                        <span class="input-group-addon"> - </span>
                        {field_group  field='end' class='input-sm'}{/field_group}
                        {input field='mode' type='hidden' value='day'}
                    </div>
                    {/form}
                </div>
             </li>
             <li><div class="triangle-right next"></div></li>
           </ul> 
      </div>
      <div class="panel-body">
        <div id="ibox_online_report"></div>
      </div>
        <div class="panel-body">
            <div id="ibox_memory_report"></div>
        </div>
        <div class="panel-body">
            <div id="ibox_cpu_report"></div>
        </div>
        <br>
        <br>
        <br>
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

    {report name="ibox_online_report" begin=$begin end=$end args=$online_args mode=$mode}{/report}
    {report name="ibox_memory_report" begin=$begin end=$end args=$args mode=$mode}{/report}
    {report name="ibox_cpu_report" begin=$begin end=$end args=$args mode=$mode}{/report}

    var clock;

    function showReport(mode){
        clearTimeout(clock);
        if(mode)
            $('.form-horizontal').find("input[name=mode]").val(mode);
        clock = setTimeout(function(){
            $('.form-horizontal').submit();
        }, 300);
    }

    $(function(){
        var datepicker = $('#datepicker').datepicker({
            language: "zh-CN",
            format: "yyyy-mm-dd",
            todayHighlight: true
        });
        var dt = datepicker.data().datepicker;
        var pickers = dt.pickers;

        $('.scrollcontent').ready(function(){
            window.scrollcontent_offsetTop = $('.scrollcontent').offset().top;
            window.scrollcontent_scrollTop = $('.scrollcontent').scrollTop();

            $(".scrollcontent").scroll(function(e){
                var self = $(this);

                if($('.datepicker.datepicker-dropdown').length > 0) {

                    for (var i = 0; i < pickers.length; i++) {
                        if(pickers[i].element.is(':focus')) {
                            pickers[i].place();
                        }
                    };
                }
            });
        });

        datepicker.on('changeDate', function(){
            showReport("");
        });

        $("#month-btn").on("click", function(){
            showReport("month");
        });

        $("#week-btn").on("click", function(){
            showReport("week");
        });

        $("#day-btn").on("click", function(){
            showReport("day");
        });
    })
</script>
{/block}

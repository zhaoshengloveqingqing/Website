{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}SYSTEM MANAGEMENT{/lang}</div>
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
$(function(){
    datatable_init();    
})
</script>
{/block}

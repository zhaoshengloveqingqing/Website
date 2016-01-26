{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}USER & ACCOUNT SETTINGS{/lang}</div>
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
        <a id="btn-save" class="btn pinet-btn-cyan ok">{lang}Save{/lang}</a>
        {if $has_head}
            <a id="btn-cancel" class="btn pinet-btn-grey cancel">{lang}Cancel{/lang}</a>
        {/if}
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
            {form id="user-form" class='form-horizontal' attr=['novalidate'=>''] action="$form_action_url" method="POST"}
                <div class="row absolute">
                  <div class="col-1280-12">{picture id='preview' path='/responsive/size' src=$profile_image_path class='img user-logo'}</div>
                  {field_group field="userfile" class="upload"}
                    {input id="fileupload" class="fileinput-button" type="file" layout=['element' => 5]}
                  {/field_group}
                </div>        
                {field_group class="username" field='username' layout=['element' => 7]}{/field_group}
                {input field='id' type='hidden'}
                {field_group type="email"  field='email_address' layout=['element' => 7]}{/field_group}
                {field_group field='last_name' layout=['element' => 7]}{/field_group}
                {field_group class="firstname"  field='first_name' layout=['element' => 7]}{/field_group}

                <div class="row">
                    {field_group class="col-1280-6" field='birthday' layout=['label' => 4,'element' => 5]}{/field_group}
                    {field_group class="col-1280-6" field='sex' layout=['label' => 4,'element' => 5]}
                        {select options=$sexs}
                        {/select}
                    {/field_group}
                </div>

            {field_group class="mobile"  field='mobile'}{/field_group}

            {field_group field='contact_company'}{/field_group}

            {field_group field='contact_street'}{/field_group}

            {field_group field='contact_city'}{/field_group}
            <div class="row col-1280-12">
            
               {field_group class="col-1280-6 contact_province" field='contact_province' layout=['label' => 4,'element' => 5]}{/field_group}
               {field_group class="col-1280-6" field='contact_postalcode' layout=['label' => 4,'element' => 5]}{/field_group}
              
            </div>

            {field_group field='contact_profile'}
           
                {textarea}
            {/field_group}
            {input field='operate_type' type='hidden'}
        {/form}
        </div>
        </div>  
    </div>
{/block}
{block name=aside}
    <ul class='subnavi parent'>
        <li>
            <h3>{lang}Account Settings{/lang}</h3>
            <ul class="subnavi parent">
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$account_menus['account_summary'] type='subnavi'}
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$account_menus['change_password'] type='subnavi'}
                        </li>
                    </ul>
                </li>
                <li>
                    <ul class='subnavi'>
                        <li>
                            {action obj=$account_menus['reset_password'] type='subnavi'}
                        </li>
                    </ul>
                </li>
            </ul>
        </li>

    </ul>
{/block}
{block name=foot append}
<script type="text/javascript">
$(function(){
    
    if($("select").length > 0) {
        $("select").selectBoxIt();
    }

    $("#field_birthday").datepicker({
        language: "zh-CN",
        format: "yyyy-mm-dd"
    });

    $("#btn-save").on('click', function(){                 
        if(!$("body").hasClass('iframe')) {
            $("#field_operate_type").val('submit');
            $("#user-form").submit();
        }
    });

    $("#btn-cancel").on('click', function(){
        window.location = "{$goback_url}";
    });

    $('input[type=file]').fileupload({
        url: "{$form_action_url}",
        dataType: 'json',
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
        maxFileSize: 5000000, // 5 MB
        // Enable image resizing, except for Android and Opera,
        // which actually support image resizing, but fail to
        // send Blob objects via XHR requests:
        disableImageResize: /Android(?!.*Chrome)|Opera/
            .test(window.navigator.userAgent),
        previewMaxWidth: 100,
        previewMaxHeight: 100,
        previewCrop: true
    }).on('fileuploaddone', function (e, data) {
        $('#preview').attr('src', data.response().result.path).picture();
    });
})
</script>
{/block}

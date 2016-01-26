{extends file='admin_layout.tpl'}
{block name=navigations}
  {section name=i loop=$navigations}
    {action obj=$navigations[i] type='main'}
  {/section}
{/block}
{block name=statebar}
  <div class="col-1280-4 title">{lang}CAPTIVE PORTAL SETTINGS{/lang}</div>
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
    <div class="response_row messagesbar">
        {alert}
    </div>
    <div class="response_row scrollcontent">

  <!-- sns-display-box -->
  <div class="panel panel-default sns-display-box sns-display-box-cyan">
      <div class="panel-body">
          {form id="weibo-form" class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='captive/sns'}" method="POST"}
              <div class="sns-display-box-content">
                  {states}
                  {state name="weibo_account_setting"}
                  {field_group field='weibo_snsuid'}
                      {input field='weibo_snsuid' state="readonly"}
                  {/field_group}
                  {field_group field='weibo_message_content' layout=false}
                  {label}
                  {textarea}
                  {/field_group}
                  {field_group field='weibo_picture' layout=false}
                  {label}
                  {input type="file" attr=["accept"=>"image/*"]}
                      <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
                  {/field_group}
                  {/state}
                  {state}
                  {field_group field='weibo_snsuid'}
                  {input field='weibo_snsuid' state="readonly"}
                  {/field_group}
                  {field_group field='weibo_message_content' layout=false}
                  {label}
                  {textarea}
                  {/field_group}
                  {field_group field='weibo_picture' layout=false}
                  {label}
                  {input type="file" attr=["accept"=>"image/*"]}
                      <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
                  {/field_group}
                  {/state}
                  {/states}
                  {input field='oauth_type' type='hidden' value='weibo'}
                  {input field='poi_id' type='hidden'}
                  {input field='status' type='hidden' value=$form_data->weibo_status}
                  {input field='weibo_snsuid' type='hidden' value=$form_data->weibo_snsuid}
                  <!-- switch-dialog -->
                  <div class="thumbnail switch-dialog marketing-message-switch-dialog">
                      <div class="switch-dialog-content">
                          {lang}Marketing Message{/lang}
                      </div>
                      <div class="caption">
                          <div class="footer">
                              {container name='weibo_account_setting'}
                              {states}
                              {state name="view"}
                                  <div class="btn-group switch-box switch-box-green">
                                      <label class="btn">
                                          ON
                                      </label>
                                      <label class="btn active">
                                          OFF
                                      </label>
                                  </div>
                              {/state}
                              {state}
                              {if isset($form_data->weibo_message)}
                                  <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                      <label class="btn on active">
                                          <input type="radio" name="weibo_message" id="weibo_message_on" autocomplete="off" value='2'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off">
                                          <input type="radio" name="weibo_message" id="weibo_message_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  </div>
                                  {else}
                                  <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                      <label class="btn on">
                                          <input type="radio" name="weibo_message" id="weibo_message_on" autocomplete="off" value='2'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off active">
                                          <input type="radio" name="weibo_message" id="weibo_message_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  </div>
                                  {/if}
                              {/state}
                              {/states}
                              {/container}
                          </div>
                      </div>
                  </div>
                  <!-- END switch-dialog -->
                  <!-- switch-dialog -->
                  <div class="thumbnail switch-dialog check-in-poid-switch-dialog">
                      <div class="switch-dialog-content">
                          {lang}Check-in POID{/lang}
                      </div>
                      <div class="caption">
                          <div class="footer">
                              {container name='weibo_account_setting'}
                              {states}
                              {state name="view"}
                                  <div class="btn-group switch-box switch-box-green">
                                      <label class="btn">
                                          ON
                                      </label>
                                      <label class="btn active">
                                          OFF
                                      </label>
                                  </div>
                              {/state}
                              {state}
                              {if isset($form_data->weibo_checkin)}
                                  <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                      <label class="btn on">
                                          <input type="radio active" name="weibo_checkpoi" id="weibo_checkpoi_on" autocomplete="off" value='3'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off">
                                          <input type="radio" name="weibo_checkpoi" id="weibo_checkpoi_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  </div>
                              {else}
                                  <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                      <label class="btn on">
                                          <input type="radio" name="weibo_checkpoi" id="weibo_checkpoi_on" autocomplete="off" value='3'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off active">
                                          <input type="radio" name="weibo_checkpoi" id="weibo_checkpoi_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  </div>
                              {/if}
                              {/state}
                              {/states}
                              {/container}
                          </div>
                      </div>
                  </div>
                  <!-- END switch-dialog -->
              </div>
              <div class="sns-display-box-side">
                  <!-- sns-switch-dialog -->
                  <div class="thumbnail sns-switch-dialog">
                      <img src="{site_url url='static/img/signin-let-me-online-weibo-active-mobile.png'}" alt="...">
                      <div class="caption">
                          <div class="footer">
                              <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                  {if $form_data->weibo_status==1}
                                      <label class="btn on active">
                                          <input type="radio" name="weibo_status" id="weibo_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off">
                                          <input type="radio" name="weibo_status" id="weibo_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  {else}
                                      <label class="btn on">
                                          <input type="radio" name="weibo_status" id="weibo_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off active">
                                          <input type="radio" name="weibo_status" id="weibo_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  {/if}
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- END sns-switch-dialog -->
                  {container name='weibo_account_setting'}
                    {states}
                      {state name="view"}
                      {/state}
                      {state}
                        <input type="submit" class="btn pinet-btn-cyan ok" value="{lang}Save{/lang}" >
                      {/state}
                    {/states}
                  {/container}
              </div>
          {/form}
      </div>
  </div>
  <!-- END sns-display-box -->

  <!-- sns-display-box -->
    <div class="panel panel-default sns-display-box sns-display-box-blue">
        <div class="panel-body">
            {form id="wechat-form" class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='captive/sns'}" method="POST"}
                <div class="sns-display-box-content">
                  <div class="wechat-content">
                   <div class="wechat-content-introduction">
                     <h1>{lang}Introduction{/lang}</h1>
                     <p>&nbsp;&nbsp;&nbsp;&nbsp;{lang}Micro letter public platform, friends, news push function, users can use the "shake", "search number", "people near, scan two diensional code way to add friends and concern the public platform, at the same time, micro letter will friends share content and exciting content, users see the share to the micro letter to my circle of friends.{/lang}</p>
                   </div>
                   <div class="wechat-content-advantage">
                     <h1>{lang}Advantage{/lang}</h1>
                     
                     <dl>
                        <dt>{lang}High efficiency{/lang}</dt>
                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;{lang}Administrative announcement, human information, staff care, colleagues birthday information instantaneous notification.Through the micro letter assignments, let the non standardized tasks can also track, remind and justified.Community communication platform, let the staff knowledge and experience more efficient{/lang}</dd>
                     </dl>
                          <dl>
                        <dt>{lang}Easy to apply{/lang}</dt>
                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;{lang}Colleagues through Micro message to complete the task coordination, approval, at the office in mobile phone.Micro message meeting room reservation, Micro message notification meeting participants.Will the PC version of the cooperative office system, directly into the micro letter version, converted to micro letter do notice.{/lang}</dd>
                     </dl>
                   </div>
                  </div>
                    {input field='oauth_type' type='hidden' value='wechat'}
                    {input field='status' type='hidden' value=$form_data->wechat_status}
                </div>
                <div class="sns-display-box-side">
                    <!-- sns-switch-dialog -->
                    <div class="thumbnail sns-switch-dialog">
                        <img src="{site_url url='static/img/signin-let-me-online-wechat-active-mobile.png'}" alt="...">
                        <div class="caption">
                            <div class="footer">
                                <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                    {if $form_data->wechat_status==1}
                                        <label class="btn on active">
                                            <input type="radio" name="wechat_status" id="wechat_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                        </label>
                                        <label class="btn off">
                                            <input type="radio" name="wechat_status" id="wechat_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                        </label>
                                    {else}
                                        <label class="btn on">
                                            <input type="radio" name="wechat_status" id="wechat_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                        </label>
                                        <label class="btn off active">
                                            <input type="radio" name="wechat_status" id="wechat_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                        </label>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END sns-switch-dialog -->
                  <input type="submit" class="btn pinet-btn-cyan ok" value="{lang}Save{/lang}" >
                </div>
            {/form}
        </div>
    </div>
    <!-- END sns-display-box -->

  <!-- sns-display-box -->
  <div class="panel panel-default sns-display-box sns-display-box-green">
      <div class="panel-body">
          {form id="qq-form" class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='captive/sns'}" method="POST"}
              <div class="sns-display-box-content">
                  {states}
                  {state name="qq_account_setting"}
                  {field_group field='qq_snsuid'}
                  {input field='qq_snsuid' state="readonly"}
                  {/field_group}
                  {field_group field='qq_message_content' layout=false}
                  {label}
                  {textarea}
                  {/field_group}
                  {field_group field='qq_picture' layout=false}
                  {label}
                  {input type="file" attr=["accept"=>"image/*"]}
                      <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
                  {/field_group}
                  {/state}
                  {state}
                  {field_group field='qq_snsuid'}
                  {input field='qq_snsuid' state="readonly"}
                  {/field_group}
                  {field_group field='qq_message_content' layout=false}
                  {label}
                  {textarea}
                  {/field_group}
                  {field_group field='qq_picture' layout=false}
                  {label}
                  {input type="file" attr=["accept"=>"image/*"]}
                      <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
                  {/field_group}
                  {/state}
                  {/states}
                  {input field='oauth_type' type='hidden' value='qq'}
                  {input field='status' type='hidden' value=$form_data->qq_status}
                  {input field='qq_snsuid' type='hidden' value=$form_data->qq_snsuid}
                  <!-- switch-dialog -->
                  <div class="thumbnail switch-dialog marketing-message-switch-dialog">
                      <div class="switch-dialog-content">
                          {lang}Marketing Message{/lang}
                      </div>
                      <div class="caption">
                          <div class="footer">
                              {container name='qq_account_setting' state='readonly'}
                              {states}
                              {state name="readonly"}
                                  <div class="btn-group switch-box switch-box-green">
                                      <label class="btn">
                                          ON
                                      </label>
                                      <label class="btn active">
                                          OFF
                                      </label>
                                  </div>
                              {/state}
                              {state}
                              {if isset($form_data->qq_message)}
                                  <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                      <label class="btn on active">
                                          <input type="radio" name="qq_message" id="qq_message_on" autocomplete="off" value='2'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off">
                                          <input type="radio" name="qq_message" id="qq_message_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  </div>
                              {else}
                                  <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                      <label class="btn on">
                                          <input type="radio" name="qq_message" id="qq_message_on" autocomplete="off" value='2'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off active">
                                          <input type="radio" name="qq_message" id="qq_message_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  </div>
                              {/if}
                              {/state}
                              {/states}
                              {/container}
                          </div>
                      </div>
                  </div>
                  <!-- END switch-dialog -->
              </div>
              <div class="sns-display-box-side">
                  <!-- sns-switch-dialog -->
                  <div class="thumbnail sns-switch-dialog">
                      <img src="{site_url url='static/img/signin-let-me-online-qq-active-mobile.png'}" alt="...">
                      <div class="caption">
                          <div class="footer">
                              <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                  {if $form_data->qq_status==1}
                                      <label class="btn on active">
                                          <input type="radio" name="qq_status" id="qq_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off">
                                          <input type="radio" name="qq_status" id="qq_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  {else}
                                      <label class="btn on">
                                          <input type="radio" name="qq_status" id="qq_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off active">
                                          <input type="radio" name="qq_status" id="qq_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  {/if}
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- END sns-switch-dialog -->
                  {container name='qq_account_setting' state='readonly'}
                    {states}
                      {state name="readonly"}
                      {/state}
                      {state}
                        <input type="submit" class="btn pinet-btn-cyan ok" value="{lang}Save{/lang}" >
                      {/state}
                    {/states}
                  {/container}
              </div>
          {/form}
      </div>
  </div>
  <!-- END sns-display-box -->

    <!-- sns-display-box -->
    <div class="panel panel-default sns-display-box sns-display-box-red">
      <div class="panel-body">
          {form id="yixin-form" class='form-horizontal' attr=['novalidate'=>''] action="{site_url url='captive/sns'}" method="POST"}
              <div class="sns-display-box-content">
                 <div class="yixin-content">
                   <div class="yixin-content-introduction">
                     <h1>{lang}Introduction{/lang}</h1>
                     <p>&nbsp;&nbsp;&nbsp;&nbsp;{lang}Easecredit is jointly developed by Netease and China Telecom, a truly free chat instant messaging software, unique HD voice chat, free mass mapping expressions and free SMS and phone messages and other functions, make the communication more fun.{/lang}</p>
                   </div>
                   <div class="yixin-content-advantage">
                     <h1>{lang}Advantage{/lang}</h1>
                     
                     <dl>
                        <dt>{lang}Cross network message{/lang}</dt>
                        <dd>&nbsp; &nbsp;&nbsp;&nbsp;{lang}In addition to voice chat, send pictures, circle of friends is a familiar function, easy to believe the biggest feature is the cross network free SMS, free phone message function, interworking between APP and mobile phone, fixed phone. "Even if the other mobile phone no easy installation letter, also can receive information; the user can phone to Yi letter sent by telephone voice message, the other side to listen to the telephone voice message can reply.{/lang}</dd>
                     </dl>
                          <dl>
                        <dt>{lang}Full function{/lang}</dt>
                        <dd>&nbsp;&nbsp;&nbsp;&nbsp;{lang}Expression of texture, fresh and adorable love department built 6 sets of rich emoticons mapping, act loving, posing, cool, table "feeling" invincible!
                        Voice assistant, walk, drive also chat read each other's name, intelligent voice recognition, began to talk at once!
                        Share the music, express your good mood music, share, millions of music library, used as a relaxed mood, show music.
                        Circle of friends photos record life, can upload and share text, pictures, and friends to share their status.{/lang}</dd>
                     </dl>
                   </div>
                  </div>
                  {input field='oauth_type' type='hidden' value='yixin'}
                  {input field='status' type='hidden' value=$form_data->yixin_status}
              </div>
              <div class="sns-display-box-side">
                  <!-- sns-switch-dialog -->
                  <div class="thumbnail sns-switch-dialog">
                      <img src="{site_url url='static/img/signin-let-me-online-yixin-active-mobile.png'}" alt="...">
                      <div class="caption">
                          <div class="footer">
                              <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                                  {if $form_data->yixin_status==1}
                                      <label class="btn on active">
                                          <input type="radio" name="yixin_status" id="yixin_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off">
                                          <input type="radio" name="yixin_status" id="yixin_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  {else}
                                      <label class="btn on">
                                          <input type="radio" name="yixin_status" id="yixin_status_on" autocomplete="off" value='1'> {lang}ON{/lang}
                                      </label>
                                      <label class="btn off active">
                                          <input type="radio" name="yixin_status" id="yixin_status_off" autocomplete="off" value='0'> {lang}OFF{/lang}
                                      </label>
                                  {/if}
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- END sns-switch-dialog -->
                  <input type="submit" class="btn pinet-btn-cyan ok" value="{lang}Save{/lang}" >
              </div>
          {/form}
      </div>
    </div>
    <!-- END sns-display-box -->
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
    var url = [];
    url["weibo_status"] = "{site_url url='captive/oauth/weibo'}";
    url["qq_status"] = "{site_url url='captive/oauth/qq'}";

    $('.sns-display-box').each(function(){
        $(this).display_box({
            url:"{site_url url='captive/show_poi'}?nohead=true"
        });
    });

    $(".sns-display-box form").each(function(i){
        var form = $(this);
        form.on("click", "input[type=submit]", function(){
            form.submit();
        });

        form.on("change", "label input[type=radio]", function(){
          var value = $(this).val();
          form.find('input[name=status]').val(value);

          if(value == '1') {
            var field = $(this).attr('name');

            if (url[field]  ) {
                //当前页面跳转
                window.location.href = url[field];

                //新建标签跳转
                // window.open(url[field]);
            };
          }
        });


        form.on("change", ".marketing-message-switch-dialog label.on input[type=radio]", function(e){
            e.stopPropagation();
            var value = $(this).val();
            if(value == '2') {
            }
            return false;
        })

        form.on("switch-box.on", ".check-in-poid-switch-dialog", function(e){
            if (form.find(".marketing-message-switch-dialog .switch-box").length > 0) {
                var switch_box = form.find(".marketing-message-switch-dialog .switch-box");
                var radio_cons = switch_box.find("label.btn");
                radio_cons.each(function(i){
                    //如果选中off的
                    if(radio_cons.eq(i).hasClass("off") && radio_cons.eq(i).hasClass("active")) {
                        radio_cons.eq(i).removeClass("active");
                        switch_box.find("label.on").addClass("active");
                    }
                    //若果选中on
                    if(radio_cons.eq(i).hasClass("on") && radio_cons.eq(i).hasClass("active")) {
                    }
                });
            };
            return false;
        });

        form.on('click', '#file-btn', function(e){
            var file_input = $(e.currentTarget).parent().find('.file-input');
            file_input.find('.input-group-btn input').trigger('click');
        })

    });

    $('input[type=file]').each(function(){
        $(this).fileupload({
            url: "{site_url url='captive/sns'}",
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
        }).on('fileuploadadd', function (e, data) {
            $("#field_operate_type").val('');
        }).on('fileuploaddone', function (e, data) {
        });
    })

    $("#save-btn").on("click", function(){
      $("#form").submit();
    })
})
</script>
{/block}
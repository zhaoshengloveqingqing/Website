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
  <div class="response_row toolbar">  
    <a id="save-btn" class="btn pinet-btn-green add">{lang}Save{/lang}</a>
    <div class="faq" data-toggle="tooltip" data-placement="bottom" title="Tooltiponbottomssadsadasdasdsdsdsdsddsdasdasdasdasdasdsdsdsdasdsds">
      ?
    </div>   
  </div> 
  <div class="response_row messagesbar">
    {alert}
  </div> 
  <div class="response_row scrollcontent">
    {form id="form" class='form-horizontal' attr=['novalidate'=>'']}
    <!-- sns-display-box -->
    <div class="panel panel-default sns-display-box sns-display-box-blue">
      <div class="panel-body">
        <div class="sns-display-box-content">  
            {field_group field='logo' layout=false}
              {label}
              {input type="file" attr=["accept"=>"image/*"]}
                  <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
            {/field_group}                        
            {field_group field='company'}{/field_group}
            {field_group field='contents'}{/field_group}       
            {field_group field='login' layout=false}
              {label}
              <div class="sns-switch-content">
                <!-- sns-switch-dialog -->
                <div class="thumbnail sns-switch-dialog wechat-switch-dialog">
                  <img src="{site_url url='static/img/signin-let-me-online-wechat-active-mobile.png'}" alt="...">
                  <div class="caption">
                    <div class="footer">
                      <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                          {container name='wechat_switch'}
                          {states}
                          {state name="off"}
                              <label class="btn">
                                  <input type="radio" name="options" id="wechat_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn active">
                                  <input type="radio" name="options" id="wechat_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {state}
                              <label class="btn active">
                                  <input type="radio" name="options" id="wechat_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn">
                                  <input type="radio" name="options" id="wechat_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {/states}
                          {/container}
                      </div>            
                    </div>
                  </div>
                </div> 
                <!-- END sns-switch-dialog -->   
                <!-- sns-switch-dialog -->
                <div class="thumbnail sns-switch-dialog weibo-switch-dialog">
                  <img src="{site_url url='static/img/signin-let-me-online-weibo-active-mobile.png'}" alt="...">
                  <div class="caption">
                    <div class="footer">
                      <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                          {container name='weibo_switch'}
                          {states}
                          {state name="off"}
                              <label class="btn">
                                  <input type="radio" name="options" id="weibo_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn active">
                                  <input type="radio" name="options" id="weibo_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {state}
                              <label class="btn active">
                                  <input type="radio" name="options" id="weibo_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn">
                                  <input type="radio" name="options" id="weibo_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {/states}
                          {/container}
                      </div>
                    </div>
                  </div>
                </div> 
                <!-- END sns-switch-dialog -->  
                <!-- sns-switch-dialog -->
                <div class="thumbnail sns-switch-dialog qq-switch-dialog">
                  <img src="{site_url url='static/img/signin-let-me-online-qq-active-mobile.png'}" alt="...">
                  <div class="caption">
                    <div class="footer">
                      <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                          {container name='qq_switch'}
                          {states}
                          {state name="off"}
                              <label class="btn">
                                  <input type="radio" name="options" id="qq_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn active">
                                  <input type="radio" name="options" id="qq_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {state}
                              <label class="btn active">
                                  <input type="radio" name="options" id="qq_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn">
                                  <input type="radio" name="options" id="qq_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {/states}
                          {/container}
                      </div>
                    </div>
                  </div>
                </div> 
                <!-- END sns-switch-dialog -->  
                <!-- sns-switch-dialog -->
                <div class="thumbnail sns-switch-dialog yixin-switch-dialog">
                  <img src="{site_url url='static/img/signin-let-me-online-yixin-active-mobile.png'}" alt="...">
                  <div class="caption">
                    <div class="footer">
                      <div class="btn-group switch-box switch-box-green" data-toggle="buttons">
                          {container name='yixin_switch'}
                          {states}
                          {state name="off"}
                              <label class="btn">
                                  <input type="radio" name="options" id="yixin_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn active">
                                  <input type="radio" name="options" id="yixin_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {state}
                              <label class="btn active">
                                  <input type="radio" name="options" id="yixin_switch_on" autocomplete="off" value="on"> ON
                              </label>
                              <label class="btn">
                                  <input type="radio" name="options" id="yixin_switch_off" autocomplete="off" value="off"> OFF
                              </label>
                          {/state}
                          {/states}
                          {/container}
                      </div>
                    </div>
                  </div>
                </div> 
                <!-- END sns-switch-dialog -->                                                                   
              </div>           
            {/field_group}            
        </div>
        <div class="sns-display-box-side">
          {iframe lazy=true src='api/portal' frameborder='0'}
        </div> 
      </div>
    </div>
    <!-- END sns-display-box --> 

    <!-- sns-display-box -->
    <div class="panel panel-default sns-display-box sns-display-box-description sns-display-box-cyan">
      <div class="panel-body">
        <div class="sns-display-box-content">
          {field_group field='photo' layout=false}
            {label}
            {input type="file" attr=["accept"=>"image/*"]}
                <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
          {/field_group} 
          {field_group field='introduction' layout=false}
            {label}
            {textarea}
          {/field_group}                                         
        </div>
        <div class="sns-display-box-side">
          {iframe lazy=true src='signin/merchant/description' frameborder="0"}
        </div>
      </div>
    </div>
    <!-- END sns-display-box --> 

    <!-- sns-display-box -->
    <div class="panel panel-default sns-display-box sns-display-box-activities sns-display-box-red">
      <div class="panel-body">
        <div class="sns-display-box-content">
          {field_group field='photo1' layout=false}
            {label}
            {input type="file" attr=["accept"=>"image/*"]}
                <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
          {/field_group}   
          {field_group field='title1'}{/field_group}
          {field_group field='contents1' layout=false}
            {label}
            {textarea}
          {/field_group}
          {field_group field='photo2' layout=false}
            {label}
          {input type="file" attr=["accept"=>"image/*"]}
              <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
          {/field_group}
          {field_group field='title2'}{/field_group}
          {field_group field='contents2' layout=false}
            {label}
            {textarea}
          {/field_group}
                </div>
                 <div class="sns-display-box-side">
          <iframe src="{site_url url='signin/activities'}" frameborder="0">
          </iframe>
        </div>
          <div class="sns-display-box-content">
            {field_group field='photo3' layout=false}
            {label}
            {input type="file" attr=["accept"=>"image/*"]}
                <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
          {/field_group}
          {field_group field='title3'}{/field_group}
          {field_group field='contents3' layout=false}
            {label}
            {textarea}
          {/field_group}
           {field_group field='photo4' layout=false}
            {label}
           {input type="file" attr=["accept"=>"image/*"]}
               <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
          {/field_group}
          {field_group field='title4'}{/field_group}
          {field_group field='contents4' layout=false}
            {label}
            {textarea}
          {/field_group}
      
               </div>
                   <div class="sns-display-box-content">
              {field_group field='photo5' layout=false}
            {label}
              {input type="file" attr=["accept"=>"image/*"]}
                  <div id="file-btn" class="btn pinet-btn-grey">{lang}File{/lang}</div>
          {/field_group}
          {field_group field='title5'}{/field_group}
          {field_group field='contents5' layout=false}
            {label}
            {textarea}
          {/field_group}
          </div>
      </div>
    </div>
    <!-- END sns-display-box -->
    {input field='login_wechat' type='hidden'}
    {input field='login_weibo' type='hidden'}
    {input field='login_qq' type='hidden'}
    {input field='login_yixin' type='hidden'}
    {input field='operate_type' type='hidden'}
    {/form}
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
{init_js}
<script type="text/javascript">
function initialise() {
    $('.pinet-alert-map').alertMap();

    $('input[type=file]').each(function(){
      $(this).fileupload({
          url: "{site_url url='captive/portal'}",
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
        $("#field_operate_type").val('submit');
      $("#form").submit();
    })

    $('.wechat-switch-dialog').on('click', '.btn', function(e){
        var curbtn = $(e.currentTarget);
        $('input[name=login_wechat]').val(curbtn.find('input[type=radio]').val());
        if(curbtn.find('input[type=radio]').val() == "on") {
            $('input[name=login_wechat]').val('on');
        }else {
            $('input[name=login_wechat]').val('off');
        }
    });

    $('.weibo-switch-dialog').on('click', '.btn', function(e){
        var curbtn = $(e.currentTarget);
        $('input[name=login_weibo]').val(curbtn.find('input[type=radio]').val());
        if(curbtn.find('input[type=radio]').val() == "on") {
            $('input[name=login_wechat]').val('on');
        }else {
            $('input[name=login_wechat]').val('off');
        }
    });

    $('.qq-switch-dialog').on('click', '.btn', function(e){
        var curbtn = $(e.currentTarget);
        $('input[name=login_qq]').val(curbtn.find('input[type=radio]').val());
        if(curbtn.find('input[type=radio]').val() == "on") {
            $('input[name=login_wechat]').val('on');
        }else {
            $('input[name=login_wechat]').val('off');
        }
    });

    $('.yixin-switch-dialog').on('click', '.btn', function(e){
        var curbtn = $(e.currentTarget);
        $('input[name=login_yixin]').val(curbtn.find('input[type=radio]').val());
        if(curbtn.find('input[type=radio]').val() == "on") {
            $('input[name=login_wechat]').val('on');
        }else {
            $('input[name=login_wechat]').val('off');
        }
    });
}
</script>
{/block}

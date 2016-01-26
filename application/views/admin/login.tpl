{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
  <div class="container">
    {header}       
    {/header}
    {sect name='login'}
            <div id="login-componet" class="row">
                <div class="col-1440-12">
                    <div class="row login-componet-header">
                      {picture path='/responsive/size' alt='$title' src='logo.gif'}
                    </div>
                    <div class="row login-componet-content">
                        <div class="col-1440-8 login-componet-formcon">
                            {form class='form-horizontal' attr=['novalidate'=>'']}
                              <div class="form-group form-title">
                                {lang}RESET{/lang}   
                              </div>
                              {field_group field='username'}
                                  {input attr=['required'=>'']}
                              {/field_group}
                              {field_group field='email_address'}
                              {/field_group}
                              <div class="form-group form-bt">
                                <div class="btn pinet-btn-metro-green ok">
                                    {lang}ok{/lang}    
                                </div>
                                <div class="btn pinet-btn-metro-grey cancel">
                                    {lang}cancel{/lang}         
                                </div>       
                              </div>
                            {/form}
                        </div>
                    </div>
                </div>
            </div>
    {/sect}
        {footer}
        {/footer}         
  </div> 
{/block}
{block name=foot}
{js}
<script>
  function initialise() {
    $("input").not("[type=submit]").jqBootstrapValidation(); 
  }
</script>
{/block}
  
                       
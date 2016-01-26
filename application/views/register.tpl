{extends file='base_layout.tpl'}
{block name=head}
	{css}{/block}
{block name=body}
<div id="container" class="container">
	<form role="form" method="post" action="{site_url url='/auth/register'}">
	  <div class="form-group">
	    <label for="exampleInputEmail1">用户名</label>
	    <input type="text" class="form-control" id="exampleInputEmail1"
		name="email_address" placeholder="输入 用户名">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">密码</label>
	    <input type="password" class="form-control" id="exampleInputPassword1" 
	    name="password" placeholder="输入 密码">
	  </div>
	  <div class="form-group">
	    <label for="exampleInputPassword1">确认密码</label>
	    <input type="password" class="form-control" id="exampleInputPassword1" 
	    name="confirm_password" placeholder="输入 确认密码">
	  </div>	  	  
	  {captcha} 
	  <button type="submit" class="btn btn-default">注册</button>
	</form>
</div>
{/block}
{block name=foot}
{js}
<script>
	$(function(){
	});
</script>
{/block}

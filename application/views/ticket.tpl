{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
<div class="container" id="container">
	<form method="post" role="form" action="{site_url url='ticket/do_ticket'}">
	  <fieldset>
	    <div class="form-group">
	      <label for="disabledTextInput">邀请码</label>
	      <input type="text" name="ticket" id="disabledTextInput" class="form-control">
	    </div>
	    <button type="submit" class="btn btn-primary">提交</button>
	  </fieldset>
	</form>
</div>
{/block}
{block name=foot}
{js}
<script>
	$(function(){
		console.log(1);
	});
</script>
{/block}
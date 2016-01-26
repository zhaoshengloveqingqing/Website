{extends file='base_layout.tpl'}
{block name=head}{css}{/block}
{block name=body}
<div class="container">
	<div class="row">
	    {form class='form-horizontal' attr=['novalidate'=>'']}
            {field_group field='id'}
			{/field_group}
            {field_group field='username'}
                {input attr=['required'=>'']}
            {/field_group}
            {field_group field='email_address'}
            {/field_group}
            {field_group field='password'}
                {password}
            {/field_group}
            {field_group field='group'}
                {select options=$groups}
                {/select}
            {/field_group}  
            <input class="btn btn-primary" type="submit" value="Test">       
	    {/form}
	</div>
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

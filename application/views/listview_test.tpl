{extends file='base_layout.tpl'}
{block name=head}{css}
<style type="text/css">
.listview_wrapper {
	width: 1150px;
}

.listview_wrapper .listview li {
	width: 250px;
	height: 100px;
	margin-right: 50px;
	margin-bottom: 50px;
}

.listview_wrapper .listview li:nth-child(2){
	height: 250px;
}

</style>
{/block}
{block name=body}
<h1>Welcome</h1>
{form}
<img id="preview">
<input id="test" name="test" type="file">
{/form}
{listview}
	<li class='listview_item_template test'>
		<span>_(users_id)</span> |
		<span>_(users_username)</span>
	</li>
{/listview}
{/block}
{block name=foot}
{js}
{init_js}
<script>
	function initialise() {
		$("#test").fileupload({
			url: "{uri}welcome/listview{/uri}",
			dataType: "json"
		}).on('fileuploaddone', function (e, data){
			console.info(data.response().result.path);
			$('#preview').attr('src', data.response().result.path);
		});
	}
</script>
{/block}

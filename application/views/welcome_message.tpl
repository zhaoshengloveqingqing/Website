{extends file='base_layout.tpl'}
{block name=head}
{css}
{js position='head'}
<style>
	.test {
		width: 200px;
		height: 100px;
		background-color: red;
	}
</style>
{/block}
{block name=body}
{toolbar}
	{input field='test.ip_addr'}
	<hr>
	{states}
		{state name='disabled'}
			{input field='test.username'}
			<h1>I'm a disabeld toolbar</h1>
			{field_group field='test.username'} 
			{/field_group}
		{/state}
		{state}
			{input field='test.ip_addr'}
			<h1>I'm a default toolbar</h1>
			{field_group field='test.ip_addr'} 
			{/field_group}
		{/state}
	{/states}
	{field_group field='test.ip_addr'} 
	{/field_group}
	{container name='test_container' state='view'}
		{states}
			{state name='view'}
				<h1>I'm a inner container</h1>
				{container name='test_inner_container' state='inner_view'}
					{state name='inner_view'}
						<h3>Hello, I'm inner view</h3>
					{/state}
					{state}
						<h3> You shouldn't see this.  </h3>
					{/state}
					{states}
						{state name='inner_view'}
							<h3>Hello, I'm inner view</h3>
						{/state}
						{state}
							<h3> You shouldn't see this.  </h3>
						{/state}
					{/states}
				{/container}
			{/state}
			{state}
				<h1>I'm a default inner container</h1>
			{/state}
		{/states}
	{/container}
	{field_group field='test.ip_addr'} 
	{/field_group}
	<hr>
{/toolbar}
{container}
	<div class="row">
		<div class="pinet-alert-map">
		    <div class="alert pinet-alert-success alert-map-item" role="alert">
		      <div class="info"><strong>Warning!</strong> Better check yourself, you're not looking too good.</div>
		      <div class="menu">
		        <button class="btn pinet-alert-btn-default yes">YES</button> 
		        <button class="btn pinet-alert-btn-default no">NO</button>   
		      </div> 
		    </div>
		    <div class="alert pinet-alert-info alert-map-item" role="alert">
		      <div class="info"><strong>Warning!</strong> Better check yourself, you're not looking too good.</div>
		      <div class="menu">
		        <button class="btn pinet-alert-btn-default yes">YES</button> 
		        <button class="btn pinet-alert-btn-default no">NO</button>   
		      </div> 
		    </div>
		    <div class="alert pinet-alert-warn alert-map-item" role="alert">
		      <div class="info"><strong>Warning!</strong> Better check yourself, you're not looking too good.</div>
		      <div class="menu">
		        <button class="btn pinet-alert-btn-default yes">YES</button> 
		        <button class="btn pinet-alert-btn-default no">NO</button>   
		      </div> 
		    </div>
		    <div class="alert pinet-alert-error alert-map-item" role="alert">
		      <div class="info"><strong>Warning!</strong> Better check yourself, you're not looking too good.</div>
		      <div class="menu">
		        <button class="btn pinet-alert-btn-default yes">YES</button> 
		        <button class="btn pinet-alert-btn-default no">NO</button>   
		      </div> 
		    </div>
		</div>	    	    	    
	</div>
	<div class="row">
	    <div class="thumbnail sns-swicth-dialog">
	      <img src="{site_url url='static/img/signin-let-me-online-wechat-active-mobile.png'}" alt="...">
	      <div class="caption">
	        <div class="footer">
				<div class="btn-group switch-box switch-box-green" data-toggle="buttons">
				  <label class="btn active">
				    <input type="radio" name="options" id="option2" autocomplete="off"> ON
				  </label>
				  <label class="btn">
				    <input type="radio" name="options" id="option3" autocomplete="off"> OFF
				  </label>
				</div>	        	
	        </div>
	      </div>
	    </div>			
	</div>
	<div class="row">
		<input type="text" id="datepicker">
	</div>
	<div class="row">
	{alert}
	</div>
	<div class="row">
		{field_group field='test.ip_addr' layout=false}
			{label class=['tttt', 'ttttt']}
			{input class='tttt'}
		{/field_group}
		{field_group class='col-1280-6' field='test.ip_addr' layout=['label'=>12]}
			{input class='tttt'}
		{/field_group}
		{field_group class='col-1280-6' field='test.ip_addr' layout=['label'=>12, 'element'=>9]}
			{input class='tttt'}
		{/field_group}
	</div>
	<div class="row">
		{field_group field='test.ip_addr'}
		{/field_group}
		<input data-inputmask="'mask':'9[999]-9[999]-9[999]-9[999]'" />
	</div>
	<div class="row">
		<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
		  Popover on left
		</button>

		<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="top" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
		  Popover on top
		</button>

		<button type="button" class="btn btn-default" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Vivamus
		sagittis lacus vel augue laoreet rutrum faucibus.">
		  Popover on bottom
		</button>

		<button type="button" class="btn pinet-btn-delete btn-circle" data-container="body" data-toggle="popover" data-trigger="focus" data-placement="right" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">
		  ?
		</button>
	</div>
	<div class="row">
		<input class="form-control">
	</div>
	<div class="row">
	    <div class="thumbnail dialog dialog-green">
	      <div class="caption">
	        <h3>Thumbnail label</h3>
	        <div class="footer">
				<div class="btn-group switch-box switch-box-green" data-toggle="buttons">
				  <label class="btn active">
				    <input type="radio" name="options" id="option2" autocomplete="off"> ON
				  </label>
				  <label class="btn">
				    <input type="radio" name="options" id="option3" autocomplete="off"> OFF
				  </label>
				</div>	        	
	        </div>
	      </div>
	    </div>
	</div>
	<div class="row">
	    <div class="thumbnail">
	      <img data-src="static/img/2.png" alt="...">
	      <div class="caption">
	        <h3>Thumbnail label</h3>
	        <p>...</p>
	        <div class="footer">
				<div class="btn-group switch-box-green" data-toggle="buttons">
				  <label class="btn active">
				    <input type="radio" name="options" id="option2" autocomplete="off"> ON
				  </label>
				  <label class="btn">
				    <input type="radio" name="options" id="option3" autocomplete="off"> OFF
				  </label>
				</div>	        	
	        </div>
	      </div>
	    </div>
	</div>
	<div class="row">
		<div class="response_row messagesbar">
		    <div class="alert pinet-alert-success" role="alert">
		      <div class="info"><strong>Warning!</strong> Better check yourself, you're not looking too good.</div>
		      <div class="menu">
		        <button class="btn pinet-alert-btn-default yes">YES</button> 
		        <button class="btn pinet-alert-btn-default no">NO</button>   
		      </div> 
		    </div>
	  	</div> 
	</div>
	<div class="row" style="height:90px;">
		<div>
			<div class="tag">Checkbox Small</div>
			<input type="checkbox" id="checkbox-1-1" class="regular-checkbox" checked /><label for="checkbox-1-1"></label>
			<input type="checkbox" id="checkbox-1-2" class="regular-checkbox" /><label for="checkbox-1-2"></label>
			<input type="checkbox" id="checkbox-1-3" class="regular-checkbox" /><label for="checkbox-1-3"></label>
			<input type="checkbox" id="checkbox-1-4" class="regular-checkbox" /><label for="checkbox-1-4"></label>
		</div>
		<div>
			<div class="tag">Radio Small</div>
				<input type="radio" id="radio-1-1" name="radio-1-set" class="regular-radio" checked /><label for="radio-1-1"></label>
				<input type="radio" id="radio-1-2" name="radio-1-set" class="regular-radio" /><label for="radio-1-2"></label>
				<input type="radio" id="radio-1-3" name="radio-1-set" class="regular-radio" /><label for="radio-1-3"></label>
				<input type="radio" id="radio-1-4" name="radio-1-set" class="regular-radio" /><label for="radio-1-4"></label>
		</div>		
	</div>
	<div class="row">
		<div class="btn pinet-btn-delete btn-circle">
			<i class="glyphicon glyphicon-chevron-up"></i>
		</div>	
		<div class="btn pinet-btn-delete btn-circle">
			<i class="glyphicon glyphicon-chevron-down"></i>
		</div>		
	</div>
	<div class="row">
		<div class="btn pinet-btn-blue">
			<img src="{site_url url='static/img/file.png'}">
		</div>

		<div class="btn pinet-btn-blue disabled">
			{picture path='/responsive/size' alt=$title title=$title src='file.png'}
		</div>		
	</div>
	<div class="row">
		{datatable}
	</div>
	<div class="row">
		<div class="btn pinet-btn-delete">
			<i class="glyphicon glyphicon-remove"></i>
		</div>	
		<div class="btn pinet-btn-green">
			<i class="glyphicon glyphicon-play"></i>
		</div>
		<div class="btn pinet-btn-green">
			<i class="glyphicon glyphicon-arrow-up"></i>
		</div>	
		<div class="btn pinet-btn-delete">
			<i class="glyphicon glyphicon-chevron-up"></i>
		</div>	
		<div class="btn pinet-btn-delete">
			<i class="glyphicon glyphicon-chevron-down"></i>
		</div>								
	</div>
	<div class="row">
		<div class="btn-group btn-group-blue">
		  <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
		    Action <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
		    <li><a href="#">Action</a></li>
		    <li><a href="#">Another action</a></li>
		    <li><a href="#">Something else</a></li>
		  </ul>
		</div>
	</div>
	<div class="row">
		<div class="btn-group switch-box-green" data-toggle="buttons">
		  <label class="btn active">
		    <input type="radio" name="options" id="option2" autocomplete="off"> Option 2
		  </label>
		  <label class="btn">
		    <input type="radio" name="options" id="option3" autocomplete="off"> Option 3
		  </label>
		</div>
		<div class="btn-group switch-box-blue" data-toggle="buttons">
		  <label class="btn active">
		    <input type="radio" name="options" id="option2" autocomplete="off"> Option 2
		  </label>
		  <label class="btn">
		    <input type="radio" name="options" id="option3" autocomplete="off"> Option 3
		  </label>
		</div>		
	</div>						
	<div class="row">
		<div class="btn pinet-btn-green">
			OK
		</div>
		<div class="btn pinet-btn-grey">
			CANCEL
		</div>	
		<div class="btn pinet-btn-green disabled">
			Dis
		</div>			
	</div>
	<div class="row">
<button type="button" class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Tooltip on right">Tooltip on right</button>	
		{section name=i loop=$navigations}
			<h3>{action obj=$navigations[i] type='main'}</h3>
			{if ($navigations[i]->subnavi)}
				<ul>
					<li>
					{section name=j loop=$navigations[i]->subnavi}
						{action obj=$navigations[i]->subnavi[j] type='subnavi'}
					{/section}
					</li>
				</ul>
			{/if}
		{/section}
	</div>
	<div class="row">
		<h1>Welcome to CodeIgniter!</h1>
		<div id="body">
			<input class="form-control search" type="text">
			<div id="search" class="btn pinet-btn-green">
				search
			</div>
		</div>
		<div id="captcha">
			{captcha}
		</div>
		<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
	</div>
	<div class="row">
		<input type="text" id="datetimepicker">
	</div>
	<div class="row">
		<select id="test" name="test">
		    <option value="SelectBoxIt is:">SelectBoxIt is:</option>
		    <option value="a jQuery Plugin">a jQuery Plugin</option>
		    <option value="a Select Box Replacement">a Select Box Replacement</option>
		    <option value="a Stateful UI Widget">a Stateful UI Widget</option>
		 </select>
	</div>
	<div class="row">
		<div id="qqLoginBtn"><a href="#" onclick='toLogin()'>{img alt='QQ' src='static/img/Connect_logo_5.png' title='QQ'}</a></div>
	</div>
	<div class="row">
	    {figure src='Connect_logo_5.png' title='$title'}
			Just testing
		{/figure}
	</div>
	<div class="row">
		<p>
			adsfadsgasga {picture path='/responsive/size' class='col-xs-2' alt=$title title=$title src='signin-logo.png'} adsfagjalsfgjaklsg;jafkls;gajfl;gj
		</p>
	</div>
	<div class="row">
	<ul id="test">
		<li class='listview_item_template test'>
			<span>_(users_id)</span> | 
			<span>_(users_username)</span>
		</li>
<!-- 		<div class="listview_pagination_template dataTables_paginate">
			<a id="datatable_previous" class="paginate_button previous pagination_previous_template" aria-controls="datatable">{lang}Previous{/lang}</a>
		    <span class="listview_pagination_button_group_template">
		        <a class="pagination_button_template" tabindex="0" data-dt-idx="_(index)" aria-controls="datatable">_(index)</a>
		    </span>
		    <a id="datatable_next" class="paginate_button next pagination_next_template" aria-controls="datatable">{lang}Next{/lang}</a>
		</div>	 -->	
	</ul>			
	</div>
	<div class="row">
		<div class="btn pinet-btn-blue">
			按钮		
		</div>
		<div class="btn-group">
		  <button type="button" class="btn pinet-btn-blue dropdown-toggle" data-toggle="dropdown">
		    Action <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
		    <li><a href="#">Action</a></li>
		    <li><a href="#">Another action</a></li>
		    <li><a href="#">Something else here</a></li>
		    <li class="divider"></li>
		    <li><a href="#">Separated link</a></li>
		  </ul>
		</div>	
<!-- 		<div class="btn-group">
		  <button type="button" class="btn pinet-btn-blue">Action</button>
		  <button type="button" class="btn pinet-btn-blue dropdown-toggle" data-toggle="dropdown">
		    <span class="caret"></span>
		    <span class="sr-only">Toggle Dropdown</span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
		    <li><a href="#">Action</a></li>
		    <li><a href="#">Another action</a></li>
		    <li><a href="#">Something else here</a></li>
		  </ul>
		</div>	 -->		
	</div>
	<div class="row">
		<div class="btn pinet-btn-green">
			按钮		
		</div>
	</div>	
	<div class="row">
		<div class="btn pinet-btn-grey">
			按钮		
		</div>
	</div>	
	<div class="row">
		<div class="btn pinet-btn-metro-green">
			按钮		
		</div>
		<div class="btn pinet-btn-metro-blue">
			按钮		
		</div>		
	</div>		
	<div class="row" style="width: 1700px;">
		<form class="form-horizontal" role="form">
		  <div class="form-group">
		    <label for="inputEmail3" class="col-1440-3 control-label">Email</label>
		    <div class="col-1440-9">
		      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-1440-3 control-label">Password</label>
		    <div class="col-1440-9">
		      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-1440-3 control-label">Password</label>
		    <div class="col-1440-9">
		      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" disabled>
		    </div>
		  </div>	
		  <div class="form-group">
		    <label for="inputPassword3" class="col-1440-3 control-label">Password</label>
		    <div class="col-1440-3">
		      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" disabled>
		    </div>
		  </div>		  	  
		</form>
	</div>	
{/container}
{/block}
{block name=foot}
{js}
{init_js}
<script>
	function initialise() {
		$('ul#test').listview({
			ajax: '{uri}/{/uri}',
			gap: 30,
			columns_count: 3,
			columns: datatable_conf.columns
		});

		var table = $('#datatable').DataTable();
		$("#search").on('click',function(){
			table.search('admin').draw();
		});

 		$('#datetimepicker').datetimepicker({
 			language: 'zh-CN'
 		});

		$("select").selectBoxIt();	

		$('button').popover();	

		$('picture').on('picture.ready',function(e){
			$('.btn').PictureButton();
		});

		// $('.btn').PictureButton();

		$("#datepicker").datepicker();

		$(document).ready(function(){
		    $(".row :input").inputmask();
		});

		$('.pinet-alert-map').alertMap();
	}
</script>
{/block}

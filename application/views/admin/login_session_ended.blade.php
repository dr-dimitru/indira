<div class="row-fluid">
	<div class="span9">
		<div class="alert alert-block">
  			<button type="button" class="close" data-dismiss="alert">&times;</button>
			{{ Lang::line('content.logged_out_warning')->get(Session::get('lang')) }}
		</div>
		@include('admin.login_area')
	</div>
	<div class="span3">
		<h6>{{ Lang::line('content.adminizer_welcome')->get(Session::get('lang')) }}</h6>
	</div>
</div>
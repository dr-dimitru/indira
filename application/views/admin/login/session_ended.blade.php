<div class="row-fluid">
	<div class="span9">
		<div class="alert alert-block">
  			<button type="button" class="close" data-dismiss="alert">&times;</button>
			{{ __('content.logged_out_warning') }}
		</div>
		@include('admin.login.form')
	</div>
	<div class="span3">
		<h6>{{ __('content.short_desc') }}</h6>
	</div>
</div>
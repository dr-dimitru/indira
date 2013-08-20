@layout('admin.template')

@section('content_area')
<div class="row-fluid">
	<div class="span9">
		@include('admin.login.form')
	</div>
	<div class="span3">
		<h6>{{ __('content.short_desc') }}</h6>
	</div>
</div>
@parent
@endsection
@layout('admin.template')

@section('content_area')
<div class="row-fluid">
	<div class="span9">
		@include('admin.login_area')
	</div>
	<div class="span3">
		<h6>{{ Lang::line('content.adminizer_welcome')->get(Session::get('lang')) }}</h6>
	</div>
</div>
@parent
@endsection
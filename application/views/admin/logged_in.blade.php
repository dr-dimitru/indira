@layout('admin.template')

@section('content_area')
<div class="row-fluid">
	<div class="span12">
		@include('admin.sidebar')
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="work_area">
			<h1><i class="icon-th"></i> Welcome to Indira<sup><i class="icon-lemon"></i></sup><sub>CMS</sub></h1>
		</div>
	</div>
</div>
@parent
@endsection
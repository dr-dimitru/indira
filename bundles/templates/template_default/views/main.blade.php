@layout('templates::template')

@section('content')
	@if(isset($page_data) && Admin::check() && Input::get('edit'))
		
		@include('templates::assets.pages_eip_bar')

	@endif

	@if(isset($page_data) && Admin::check() && Input::get('edit'))
		<div id="page_editor_{{ $page_data->id }}">
	@endif
	
		@if(isset($pattern))
			{{ $pattern }}
		@endif

		@if(isset($page))

			@include($page)

		@endif

	@if(isset($page_data) && Admin::check() && Input::get('edit'))
		</div>
	@endif

@endsection
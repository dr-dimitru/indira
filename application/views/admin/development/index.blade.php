@layout('admin.development.template')

<h3>
	<i class="icon-code"></i>  {{ __('content.development') }} 

	<span id="dev_thumbler">
		@include('admin.development.thumbler')
	</span>
</h3>

<hr>

@section('development')
	<div class="row-fluid">
		<div class="span12">
			<div class="well">
				<p>{{ __('development.annotation') }}</p>
			</div>
		</div>
	</div>
@endsection
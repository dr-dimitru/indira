@layout('item.template')

@section('header')
    
@endsection


@section('content')
	<div class="row">
		<div class="span12">
			<div class="page-header well">
				<h1>{{ HTML::image('/img/arrow.png', 'arrow', array('title' => 'arrow', 'height' => '45', 'width' => '45')) }} {{ Lang::line('content.permissions_denied')->get(Session::get('lang')) }}</h1>
			</div>
		</div>
	</div>
@endsection

@section('after_content')
	@include('item.posts_preview')
@endsection
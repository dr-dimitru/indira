<div class="row">
	<div class="span12">
		<div class="page-header">
			<h1>{{ HTML::image('/img/arrow.png', 'arrow', array('title' => 'arrow', 'height' => '45', 'width' => '45')) }} {{ Lang::line('content.more_word')->get(Session::get('lang')) }}</h1>
		</div>
		<ul class="thumbnails">
		<? $posts_preview = Posts::where('lang', '=', Session::get('lang'))->where_not_id($post->id)->get(); ?>
		
		@foreach ($posts_preview as $post)
		    @if(Session::get('user.access_level') >= $post->access)
    			<div class="span3">
    				@include('partials.postpreview')
    			</div>
			@endif
		@endforeach
		</ul>
	</div>
</div>
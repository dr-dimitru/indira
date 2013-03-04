<? $post_media = explode(",", $post->media); ?>
<h2>
	<a 
		href="{{ URL::to($post->id) }}" 
		title="{{ Lang::line('content.read_all_word')->get(Session::get('lang')) }}" 
		rel="tooltip" 
		alt="{{ Lang::line('content.read_all_word')->get(Session::get('lang')) }}">
			{{ $post->title }}
	</a>
</h2>
<div class="mozaic_desc" onclick="location.href='{{ URL::to($post->id) }}'">
	{{ substr(strip_tags($post->text), 0, 600); }}

	<a 
		class="continue_read" 
		href="{{ URL::to($post->id) }}" 
		title="{{ Lang::line('content.read_all_word')->get(Session::get('lang')) }}" 
		rel="tooltip" 
		alt="{{ Lang::line('content.read_all_word')->get(Session::get('lang')) }}">
			…<i class="icon-arrow-right"></i>
	</a>
</div>
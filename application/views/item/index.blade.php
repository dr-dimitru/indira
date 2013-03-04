@layout('item.template')

@section('header')
    
@endsection


@section('content')
	<div class="row">
		<div class="span12">
			<div class="page-header">
				<h1>
			
					{{ $post->qr_code_filename }}
					<small class="time">{{ $post->updated_at }}</small>
					{{ $post->title }}
					<small class="tweet-btn"><a class="btn btn-mini" href="http://twitter.com/home?status=<?= urlencode($post->title.': '.URL::current()) ?>" target="_blank"><i class="icon-twitter icon-large"></i> Tweet</a> <a class="btn btn-mini" href="https://plus.google.com/share?url=<?= urlencode(URL::current()); ?>" target="_blank"><i class="icon-google-plus icon-large"></i> +1</a></small>

				</h1>
			</div>
			<div class="row">
				<div class="span12">
					@if (Admin::check())
						<div
							id="text_{{ $post->id }}" 
						>
								{{ $post->text }}
						</div>
					@else
						{{ $post->text }}
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@section('after_content')
	@include('item.posts_preview')
@endsection
@if($posts)
	
	<header class="sub-header">
		<h2>{{ __('templates::content.posts_word') }}</h2>
	</header>

	<div class="post-listing">
	@foreach($posts as $post)

		@include('templates::posts.article')

	@endforeach
	</div>
@endif

@if($blogs && $posts)
	<hr>
@endif

@if($blogs)
	
	<header class="sub-header">
		<h2>{{ __('templates::content.blog_word') }}</h2>
	</header>

	<div class="post-listing">
	@foreach($blogs as $blog)

		@include('templates::blog.article')

	@endforeach
	</div>
@endif

@if(!$blogs && !$posts)
	<div class="well well-small" style="text-align: center">
		<h3>{{ __('templates::content.search.no_results') }}</h3>
	</div>
@endif
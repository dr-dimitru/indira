@if($posts)
	
	<header class="sub-header">
		<h1>{{ __('templates::content.posts_word') }}</h1>
	</header>

	<div class="row post-listing">
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
		<h1>{{ __('templates::content.blog_word') }}</h1>
	</header>

	<section class="row post-listing">
	@foreach($blogs as $blog)

		@include('templates::blog.article')

	@endforeach
	</section>
@endif

@if(!$blogs && !$posts)
	<div class="well well-small" style="text-align: center">
		<h3>{{ __('templates::content.search.no_results') }}</h3>
	</div>
@endif
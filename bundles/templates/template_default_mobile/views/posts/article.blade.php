<article 
	class="well col-xs-12 col-md-6" 
	itemscope 
	itemtype="http://schema.org/Article"
	data-link="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
	data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.posts_word', $post->title)) }}"
	data-ajaxify="true"
>
	<header class="post-heading">

		@if($post->image)
			<div 
				class="post-header-image" 
				style="{{ 'background: url('.asset($images->{$post->image}->formats->mobile_header).'); background-size: cover;' }}"
			></div>
		@endif

		<div class="post-header">
			<h4 itemptop="name">
				<a 	itemprop="url" 
					id="go_to_post_{{ $post->id }}"
					href="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
					data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.posts_word', $post->title)) }}"
				>
					{{  $post->title }}
				</a>
			</h4>

			@if($post->tags)
				<?php $tags = explode(',', $post->tags); ?>
				@foreach($tags as $tag_key => $tag)
					@if(!empty($tag))
					<span 	id="ajax_go_to_tag_{{ $tag_key }}"
							data-link="{{ URL::to_route('search_tag', array(trim($tag))) }}"
							data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.search.by_tag', trim($tag))); }}"
							itemprop="keywords" 
							class="tag label label-danger"
					>
						{{ trim($tag) }}
					</span>
					@endif
				@endforeach
			@endif
		
		</div>
	</header>

	<hr>

	<p style="text-align:justify" itemprop="description">
		{{ ($post->short) ? $post->short : ucfirst(strtolower(preg_replace("/\s+/", " ",substr(strip_tags($post->text), 0, 200)))) }}
	</p>
</article>
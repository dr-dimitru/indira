<article 
	class="span6" 
	itemscope 
	itemtype="http://schema.org/Article"
	data-link="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
	data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.posts_word', $post->title)) }}"
	data-ajaxify="true"
>
	<header>

		@if($post->image)
			<div 
				class="post-header-image pull-left" 
				style="{{ 'background: url('.asset($images->{$post->image}->formats->gallery_thumbnail).'); background-size: cover;' }}"
			></div>
		@endif

		<h4 itemptop="name">
			<a 	itemprop="url" 
				id="go_to_post_{{ $post->id }}"
				href="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
				data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.posts_word', $post->title)) }}"
			>
				{{  $post->title }}
			</a>
		</h4>
	
	</header>

	<p style="text-align:justify" itemprop="description">
		{{ ($post->short) ? $post->short : ucfirst(strtolower(preg_replace("/\s+/", " ",substr(strip_tags($post->text), 0, 200)))) }}
	</p>

	@if($post->tags)
		<span class="btn btn-mini disabled">Tags:</span>
		<?php $tags = explode(',', $post->tags); ?>
		@foreach($tags as $tag_key => $tag)
			@if(!empty($tag))
			<span 	id="ajax_go_to_tag_{{ $tag_key }}"
					data-link="{{ URL::to_route('search_tag', array(trim($tag))) }}"
					data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.search.by_tag', trim($tag))); }}"
					itemprop="keywords" 
					class="tag label label-inverse"
			>
				{{ trim($tag) }}
			</span>
			@endif
		@endforeach
	@endif
</article>
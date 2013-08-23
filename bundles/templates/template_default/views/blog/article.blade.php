<article 
	class="span6" 
	itemprop="blogPosts" 
	itemscope 
	itemtype="http://schema.org/BlogPosting"
	data-link="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)) }}"
	data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $blog->title)) }}"
	data-ajaxify="true"
>
	<header>

		@if($blog->image)
			<div 
				class="post-header-image pull-left" 
				style="{{ 'background: url('.asset($images->{$blog->image}->formats->gallery_thumbnail).'); background-size: cover;' }}"
			></div>
		@endif

		<small>
			<i class="icon-time"></i> 
			<time datetime="{{ date('Y-m-d\Th:i', $blog->created_at) }}" itemprop="datePublished" pubdate>
				{{ (is_numeric($blog->created_at)) ? date('d M Y', $blog->created_at) : $blog->created_at }}
			</time>
		</small>
		<h4 itemptop="name">
			<a 	itemprop="url" 
				id="go_to_blog_post_{{ $blog->id }}"
				href="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)) }}"
				data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $blog->title)) }}"
			>
				{{ $blog->title }}
			</a>
		</h4>

	</header>


	<p itemprop="description">
		{{ ($blog->short) ? $blog->short : ucfirst(strtolower(preg_replace("/\s+/", " ",substr(strip_tags($blog->text), 0, 200)))) }}
		&nbsp; | &nbsp;
		<a	id="go_to_blog_post_{{ $blog->id }}"
			href="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)) }}"
			data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $blog->title)) }}"
		>
			{{ __('templates::content.read_all') }}
		</a>
	</p>

	@if($blog->tags)
		<span class="btn btn-mini disabled">Tags:</span>
		<?php $tags = explode(',', $blog->tags); ?>
		@foreach($tags as $tag_key => $tag)
			@if(!empty($tag))
			<span 	id="ajax_go_to_tag_{{ $tag_key }}"
					data-link="{{  URL::to_route('search_tag', array(trim($tag))) }}"
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
<article 
	class="well col-xs-12 col-md-6" 
	itemprop="blogPosts" 
	itemscope 
	itemtype="http://schema.org/BlogPosting"
	data-link="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)) }}"
	data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $blog->title)) }}"
	data-ajaxify="true"
>
	<header class="post-heading">

		@if($blog->image)
			<div 
				class="post-header-image" 
				style="{{ 'background: url('.asset($images->{$blog->image}->formats->mobile_header).'); background-size: cover;' }}"
			></div>
		@endif

		<div class="post-header">
			<h4 itemptop="name">
				<a 	itemprop="url" 
					id="go_to_blog_post_{{ $blog->id }}"
					href="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)) }}"
					data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $blog->title)) }}"
				>
					{{ $blog->title }}
				</a>
			</h4>

			<small>
				<i class="icon-time"></i> 
				<time datetime="{{ date('Y-m-d\Th:i', $blog->created_at) }}" itemprop="datePublished" pubdate>
					{{ date('d M Y', $blog->created_at) }}
				</time>
			</small>

			<br/>

			@if($blog->tags)
				<?php $tags = explode(',', $blog->tags); ?>
				@foreach($tags as $tag_key => $tag)
					@if(!empty($tag))
					<span 	id="ajax_go_to_tag_{{ $tag_key }}"
							data-link="{{  URL::to_route('search_tag', array(trim($tag))) }}"
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
		{{ ($blog->short) ? $blog->short : ucfirst(strtolower(preg_replace("/\s+/", " ",substr(strip_tags($blog->text), 0, 200)))) }}
	</p>
</article>
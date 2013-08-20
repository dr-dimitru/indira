<article class="posts" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
	<header class="post-heading black-background">

		@if($blog->image)
			<div 
				class="post-header-image" 
				style="{{ 'background: url('.asset($post_image).'); background-size: cover;' }}"
			></div>
		@endif

		<div class="post-header">
			<h2 itemprop="name">{{ $blog->title }}</h2>
			<small>
				<i class="icon-time"></i> 
				<time datetime="{{ date('Y-m-d\Th:i', $blog->created_at) }}" itemprop="datePublished" pubdate>
					{{ date('d F Y', $blog->created_at) }}
				</time>
			</small>

			<hr style="opacity:0.25">

			<?php $tags = explode(',', $blog->tags); ?>
			@foreach($tags as $tag_key => $tag)
				@if($tag)
				<span 
					id="ajax_go_to_tag_{{ $tag_key }}"
					data-link="{{ URL::to_route('search_tag', array(trim($tag))) }}"
					data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.search.by_tag', trim($tag))); }}"
					itemprop="keywords" 
					class="tag label label-danger"
				>
					{{ trim($tag) }}
				</span>&nbsp;
				@endif
			@endforeach

			<ul class="pager">
			@if(isset($previous) && !empty($previous))
				<li class="previous">
					<a 	href="{{ URL::to_route('blog', array(($previous->link) ? $previous->link : $previous->id)) }}"
						data-ajaxify="true"
						data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $previous->title)) }}"
						title="{{ $previous->title }}"
						class="pull-left"
						rel="tooltip"
						onmouseover='$(this).tooltip({"title": "{{ e(addslashes($previous->title)) }}"}); $(this).tooltip("show")'
					>
						<i class="icon-chevron-left"></i> {{ __('templates::content.previous_word') }}
					</a>
				</li>
			@endif

			@if(isset($next) && !empty($next))
				<li class="next">
					<a 	href="{{ URL::to_route('blog', array(($next->link) ? $next->link : $next->id)) }}"
						data-ajaxify="true"
						data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word', $next->title)) }}"
						title="{{ $next->title }}"
						class="pull-right"
						rel="tooltip"
						onmouseover='$(this).tooltip({"title": "{{ e(addslashes($next->title)) }}"}); $(this).tooltip("show")'
					>
						{{ __('templates::content.next_word') }} <i class="icon-chevron-right"></i>
					</a>

					<link rel="prefetch" href="{{ URL::to_route('blog', array(($next->link) ? $next->link : $next->id)) }}">
					<link rel="prerender" href="{{ URL::to_route('blog', array(($next->link) ? $next->link : $next->id)) }}">
				</li>
			@endif
			</ul>

		</div>
	</header>

	<hr class="no-vertical-margin">

	<section>
		@if(Admin::check())
			<div class="admin-editable">
				<div class="pull-left" id="status_{{ $blog->id }}"></div>
				<div class="btn-group pull-right">
					<a
						href="{{ action('admin.blog.home@edit', array($blog->id)) }}"
						class="btn btn-info"
					>
						<i class="icon-lemon"></i>
					</a>
					<button 
						id="ajax_save_button_{{ $blog->id }}"
						class="btn btn-success"
						type="button" 
						data-link="{{ action('admin.blog.action@save') }}" 
						data-post="{{ e('{"id": "'.$blog->id.'","title":  encodeURI(\''.$blog->title.'\'),"access": "'.$blog->access.'","lang": "'.$blog->lang.'","text": encodeURI($(\'#text_'.$blog->id.'\').html())}') }}"
						data-out="status_{{ $blog->id }}"
						data-load="status_{{ $blog->id }}"
						data-prevent-follow="true"
					>
						<i class="icon-save"></i>
					</button>
					<button
						type="button"
						class="btn btn-default"
						onclick="$('#text_{{ $blog->id }}').redactor()"
					>
						<i class="icon-pencil"></i>
					</button>
					<button
						type="button"
						class="btn btn-danger"
						onclick="$('#text_{{ $blog->id }}').redactor('destroy');"
					>
						<i class="icon-remove-sign"></i>
					</button>
				</div>
			</div>

			<div class="redactor_area">

				<div id="text_{{ $blog->id }}">
					{{ $blog->text }}
				</div>

			</div>
		
		@else

			<main itemprop="articleBody" id="text_{{ $blog->id }}">
				{{ $blog->text }}
			</main>

		@endif
	</section>

	<footer class="black-background">

		@if($disqus_shortname = Template::where('type', '=', 'disqus')->and_where('name', '=', 'shortname')->only('value'))
			<div id="disqus_thread"></div>
			<script type="text/javascript">
				var disqus_shortname = '{{ $disqus_shortname }}';
				var disqus_url = '{{ (isset($canonical_url)) ? $canonical_url : rawurldecode(URL::full()) }}';
				var disqus_title = '{{ $title }}';
				var disqus_identifier = 'posts/{{ $blog->id }}';
				var disqus_config = function () { 
					this.language = "{{ Session::get('lang') }}";
				};

				if (!$("script[src$='disqus.com/embed.js']").length){

					(function() {
						var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
						dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
						(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					})();

				}else{

					DISQUS.reset({
						reload: true,
						config: function () {  
							this.page.identifier = disqus_identifier;  
							this.page.url = disqus_url;
							this.page.shortname = disqus_shortname;
							this.page.title = disqus_title;
						}
					});
				}
			</script>

			<hr>
		@endif

		<div style="text-align:center; padding: 15px">
			@if($blog->qr_code)
				<img src="{{ $blog->qr_code }}" class="img-rounded footer-qrcode" />
			@endif
		</div>

	</footer>
</article>

@if(Admin::check() && isset($_GET['edit']) == 'true')
	<script>
		$(function(){
			$('#text_{{ $blog->id }}').redactor();
		});
	</script>
@endif
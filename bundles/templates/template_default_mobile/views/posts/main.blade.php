<article class="posts" itemscope itemtype="http://schema.org/Article">
	<header class="post-heading black-background">

		@if($post->image)
			<div 
				class="post-header-image" 
				style="{{ 'background: url('.asset($post_image).'); background-size: cover;' }}"
			></div>
		@endif
		
		<div class="post-header">
			<h1 itemprop="name">{{ $post->title }}</h1>
			<small itemprop="articleSection">
				<a 	id="go_to_section_{{ $section->id }}"
					href="{{ URL::to_route('sections', array(($section->link) ? $section->link : $section->id)) }}"
					data-title="{{ Utilites::build_title(array(Indira::get('name'), $section->title)) }}"
				>
					{{ $section->title }}
				</a>
			</small>

			<hr style="opacity:0.5">

			<?php $tags = explode(',', $post->tags); ?>
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
				</span>
				@endif
			@endforeach
		</div>
	</header>

	<hr class="no-vertical-margin">

	<section>
		@if(Admin::check())
			<div class="admin-editable">
				<div class="pull-left" id="status_{{ $post->id }}"></div>
				<div class="btn-group pull-right">
					<a
						href="{{ action('admin.posts.home@edit', array($post->id)) }}"
						class="btn"
					>
						<i class="icon-lemon"></i>
					</a>
					<button 
						id="ajax_save_button_{{ $post->id }}"
						class="btn"
						type="button" 
						data-link="{{ action('admin.posts.action@save') }}" 
						data-post="{{ e('{"id": "'.$post->id.'","title": encodeURI(\''.$post->title.'\'),"section": "'.$post->section.'","access": "'.$post->access.'","lang": "'.$post->lang.'","text": encodeURI($(\'#text_'.$post->id.'\').html())}') }}"
						data-out="status_{{ $post->id }}"
						data-load="status_{{ $post->id }}"
						data-prevent-follow="true"
					>
						<i class="icon-save"></i>
					</button>
					<button
						type="button"
						class="btn"
						onclick="$('#text_{{ $post->id }}').redactor()"
					>
						<i class="icon-pencil"></i>
					</button>
					<button
						type="button"
						class="btn"
						onclick="$('#text_{{ $post->id }}').redactor('destroy');"
					>
						<i class="icon-remove-sign"></i>
					</button>
				</div>
			</div>

			<div class="redactor_area">

				<div id="text_{{ $post->id }}">
					{{ $post->text }}
				</div>

			</div>
		
		@else

			<main itemprop="articleBody" id="text_{{ $post->id }}">
				{{ $post->text }}
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
				var disqus_identifier = 'posts/{{ $post->id }}';
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
			@if($post->qr_code)
				<img src="{{ $post->qr_code }}" class="img-rounded footer-qrcode" />
			@endif
		</div>

	</footer>
</article>

@if(Admin::check() && isset($_GET['edit']) == 'true')
	<script>
		$(function(){
			$('#text_{{ $post->id }}').redactor();
		});
	</script>
@endif
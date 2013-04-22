@layout('item.template')

@section('header')
    
@endsection


@section('content')
	<div class="row">
		<div class="span12">

			<article>
				<header class="page-header">
					<h1>
						<img src="{{ $post->qr_code }}" alt="{{ Lang::line('content.site_title')->get(Session::get('lang')) }} · {{ $post->title }}" title="{{ Lang::line('content.site_title')->get(Session::get('lang')) }} · {{ $post->title }}" />
						<small class="time"><time datetime="{{ $post->updated_at }}">{{ date("d/m/Y", strtotime($post->updated_at)) }}</time></small>
						{{ $post->title }}
						<small class="tweet-btn"><a class="btn btn-mini" href="http://twitter.com/home?status=<?= urlencode($post->title.': '.URL::current()) ?>" target="_blank"><i class="icon-twitter icon-large"></i></a> <a class="btn btn-mini" href="https://plus.google.com/share?url=<?= urlencode(URL::current()); ?>" target="_blank"><i class="icon-google-plus icon-large"></i></a>
							@if (Admin::check())
								<span id="status" class="btn btn-mini btn-success disabled"></span>
							@endif
						</small>
					</h1>
				</header>
			
				@if (Admin::check())
					<div
						id="text_{{ $post->id }}" 
						onkeypress="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);" 
					>
							{{ $post->text }}
					</div>
				@else
					<main>
						{{ $post->text }}
					</main>
				@endif
			

				<footer class="comments">
					<hr>

					<div id="disqus_thread"></div>
					<script type="text/javascript">
					    var disqus_shortname = 'indiracms';
					    var disqus_url = '{{ URL::to('/'.$post->id) }}';
					    var disqus_title = '{{ $post->title }}';
					    var disqus_config = function () { 
						  this.language = "{{ Session::get('lang') }}";
						};

					    (function() {
					        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
					        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
					        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
					    })();
					</script>
				</footer>
			</article>
		</div>
	</div>
@endsection

@section('after_content')
	@include('item.posts_preview')
@endsection
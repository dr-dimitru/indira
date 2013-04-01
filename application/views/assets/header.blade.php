<header>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span9">
				<div class="pull-left">
					<div class="bs-links">
						<ul class="quick-links" onclick=" _gaq.push(['_trackEvent', 'github', 'go_to_github', 'View on GitHub']);">
							<li>
							    <a class="btn" href="https://github.com/dr-dimitru/indira" target="_blank"><i class="icon-github-alt icon-large"></i> Watched by</a>
      							<a id="watchers" class="count btn" href="#">10+</a>
          
							</li>
							<li>
						       <a class="btn" href="https://github.com/dr-dimitru/indira" target="_blank"><i class="icon-github icon-large"></i> Forked by</a>
						       <a id="forks" class="count btn" href="#">20+</a>
							</li>
						</ul>
						<ul class="quick-links">
							<li class="follow-btn">
								<a class="btn btn-mini" href="http://twitter.com/VeliovGroup/" target="_blank"><i class="icon-twitter-sign icon-large"></i> @VeliovGroup</a>
      							<span id="vg_followers" class="count btn btn-mini">100+</span>
							</li>
							<li class="follow-btn">
								<a class="btn btn-mini" href="http://twitter.com/smart_egg/" target="_blank"><i class="icon-twitter icon-large"></i> @smart_egg</a>
      							<span id="se_followers" class="count btn btn-mini">200+</span>
							</li>
							<li class="tweet-btn">
								<a class="btn btn-mini" href="http://twitter.com/home?status=<?= urlencode('Indira CMS: '.URL::to('/', '')); ?>" target="_blank"><i class="icon-twitter icon-large"></i> Tweet</a>
							</li>
							<li class="tweet-btn">
								<a class="btn btn-mini" href="http://www.facebook.com/plugins/like.php?href=<?= urlencode(URL::to('/', '')); ?>" target="_blank"><i class=" icon-thumbs-up icon-large"></i> Like</a>
							</li>
							<li class="tweet-btn">
								<a class="btn btn-mini" href="https://plus.google.com/share?url=<?= urlencode(URL::to('/', '')); ?>" target="_blank"><i class="icon-google-plus icon-large"></i></a>
							</li>
							<li class="tweet-btn">
								<a class="btn btn-mini" href="http://www.facebook.com/sharer.php?t=<?= urlencode('Indira CMS: ')?>&u=<?= urlencode(URL::to('/', '')); ?>" target="_blank"><i class="icon-facebook-sign icon-large"></i></a>
							</li>
							<li class="tweet-btn">
								<a class="btn btn-mini" href="http://vkontakte.ru/share.php?url=<?= urlencode(URL::to('/', '')); ?>" target="_blank"><strong>B</strong></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="span3">
				<div class="pull-right" onclick="location.href='{{ URL::to('/', '') }}'">
					<h1>indira<sup><i class="icon-lemon"></i></sup></h1>
				</div>
			</div>
		</div>
	</div>
</header>
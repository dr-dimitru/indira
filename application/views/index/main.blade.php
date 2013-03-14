@layout('index.template')

@section('header')
@parent

@endsection

@section('welcome_area')
<div class="welcome_text hero-unit">
	<div class="container">
		<div class="row">
			<div class="span12">
				<h1 style="font-size:160px;">indira<sup style="top: -95px;"><i class="icon-lemon"></i></sup></h1>
				<p class="lead">{{ Lang::line('promo.slogan')->get(Session::get('lang')) }}</p>
			</div>
		</div>
		<div class="row">
			<div class="span4">
		  		<a href="https://github.com/dr-dimitru/indira" onclick=" _gaq.push(['_trackEvent', 'github', 'go_to_github', 'View on GitHub']);" class="btn btn-info btn-large btn-block"><i class="icon-github-alt icon-white"></i> {{ Lang::line('promo.view_on_git')->get(Session::get('lang')) }}</a>
		  	</div>
		  	<div class="span4">
		  		<a  href="<?= Config::get('application.url') ?>/admin" onclick=" _gaq.push(['_trackEvent', 'demo', 'go_to_demo', 'Test admin side']);" class="btn btn-success btn-large btn-block"><i class="icon-play icon-white"></i> {{ Lang::line('promo.try_it')->get(Session::get('lang')) }}</a>
		  	</div>
		  	<div class="span4">
		  		<a  href="https://github.com/dr-dimitru/indira/archive/master.zip" target="_blank" onclick=" _gaq.push(['_trackEvent', 'download', 'download_click', 'Download Indira']);" class="btn btn-inverse btn-large btn-block"><i class="icon-download-alt icon-white"></i> {{ Lang::line('promo.download')->get(Session::get('lang')) }}</a>
		  	</div>
		</div>
		
		<div class="row" style="text-align: center">
			<div class="span4">
				<img style="margin-bottom:10px" src="<?= Config::get('application.url') ?>/img/icon.png" height="100" width="100" alt="adminizer_logo" title="adminizer_logo" />
				<div class="well-small well" style="text-align: justify">
					{{ Lang::line('promo.adminizer')->get(Session::get('lang')) }}
				</div>
			</div>
			<div class="span4">
				<img style="margin-bottom:10px" src="<?= Config::get('application.url') ?>/img/logoback.png" height="100" width="146" alt="laravel_logo" title="laravel_logo" />
				<div class="well-small well" style="text-align: justify">
					{{ Lang::line('promo.laravel')->get(Session::get('lang')) }}
				</div>
			</div>
			<div class="span4">
				<h1 style="font-size: 100px" >indira<sup><i class="icon-lemon"></i></sup></h1>
				<div class=" well well-small" style="text-align: justify">
					{{ Lang::line('promo.indira')->get(Session::get('lang')) }}
				</div>
			</div>
		</div>


		<div class="row" style="text-align: center">
			<div class="span12">
				<div class="well-small well" style="text-align: justify">
					<h2>What included: Features</h2>
				</div>
			</div>
			<div class="span4">
				<div class="well-small well" style="text-align: justify">
					<h4>For Adminstration</h4>
					<ul>
						<li>CMS - Content management system</li>
						<li>"EiP" - Edit in Place</li>
						<li>User and Admin Access Level control</li>
						<li>Multilanguage support out of box</li>
						<li>Promocodes to limit access to posts or registration</li>
					</ul>
				</div>
			</div>
			<div class="span4">
				<div class="well-small well" style="text-align: justify">
					<h4>For Coding</h4>
					<ul>
						<li>Useful JS functions</li>
						<li>QR-code generator</li>
						<li>Templates based on Laravel</li>
						<li>Multilanguage support out of box</li>
						<li><a href="./34">NoSQL architecture</a>: file based & encrypted</li>
					</ul>
				</div>
			</div>
			<div class="span4">
				<div class=" well well-small" style="text-align: justify">
					<h4>For Designing</h4>
					<ul>
						<li>"EiP" - Edit in Place</li>
						<li>QR-code generator</li>
						<li>Default Twitter Bootstrap template</li>
						<li>Templates based in Laravel</li>
						<li>Font Awesome - iconic font</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('content')
	@include('index.mozaic')
@endsection
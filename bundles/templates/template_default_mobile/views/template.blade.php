@include('templates::assets.head')
<body id="body" class="{{ TMPLT_TYPE }}">
	<!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
	<div id="wrapper">
			
		<div id="navbar_wrapper">
			<nav class="navigation">
				<div class="container" id="nav_wrapper">
					@include('templates::assets.navbar')
				</div>
				<ul class="hot-menu pull-right">
					<li>
						<a href="#" id="show_sidebar">
							<i class="icon-align-justify icon-large"></i>
						</a>
					</li>
				</ul>
			</nav>
		</div>

		<div id="iosappcontainer">

			<div class="container">
				<div class="inner">
					<div id="work_area">
						@__yield('content')
					</div>
				</div>
			</div>

			@include('templates::assets.footer')
			
		</div>

	</div>

	<aside id="sidebar_wrapper">
		{{ Controller::call('templates::content@sidebar') }}
	</aside>

</body>
</html>
@include('admin.head')
	<body id="body" class="admin">
		<!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
		<div class="container-fluid">
			<div class="row-fluid">
				<div class="span4">
					<h1>Indira<sup><i class="icon-lemon"></i></sup><sub>CMS</sub></h1>
				</div>
				<div class="8">
				</div>
			</div>
		</div>
		<div id="main_container" class="container-fluid">
			<div class="inner">
				<div class="row-fluid">
					<div class="span12">
						@include('admin.sidebar')
					</div>
				</div>
				<div class="row-fluid">
					<div class="span12">
						<div id="work_area">
							@section('content_area')
							@yield_section
						</div>
					</div>
				</div>
			</div>
		</div>
		@include('admin.assets.footer')
		@include('admin.assets.password_recovery')
	</body>
</html>
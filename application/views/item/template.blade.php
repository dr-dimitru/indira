@include('assets.head')
<body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    @include('assets.header')

    	@section('header')
    		
    	@yield_section
    		
    	<div class="content_container">
            <div class="cc_top"></div>
            <div class="navbar">
              <div class="navbar-inner" id="user_login_logout">
                @include('assets.bar')
              </div>
            </div>
    		<div id="main_container" class="container">
                @include('assets.admin_buttons')
    			@yield('content')
    			@yield('after_content')
    		</div>
    		@include('assets.footer')
    	</div>
	</div>
	 @include('assets.forms')
</body>
</html>
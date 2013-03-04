@include('assets.head')
<body>
    <input hidden style="display:none" id="loader" name="loader" value="{{ rawurlencode(Config::get('application.default_loader')) }}" />
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
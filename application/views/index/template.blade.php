@include('assets.head')
<body>
	@section('header')
		@include('assets.header')
	<div class="content_container">
		<div class="navbar">
		  <div class="cc_top"></div>
		  <div class="navbar-inner" id="user_login_logout">
		    @include('assets.bar')
		  </div>
		  <div class="cc_bottom"></div>
		</div>
	@yield_section
	</div>
		
		@section('welcome_area')
		@yield_section
		
	<div class="content_container" style="margin-top: -16px;">
		<div class="cc_top"></div>
		<div id="main_container" class="container">
			@yield('content')
		</div>
		@yield('after_content')
		@include('assets.footer')
	</div>
	@include('assets.forms')
</body>
</html>
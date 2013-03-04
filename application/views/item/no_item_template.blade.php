@include('assets.head')
<body>

	<div class="content_container">
    	@section('header')
    		
    	@yield_section
    		
    	<div class="content_container" style="margin-top: -16px;">
    		<div class="cc_top"></div>
    		@include('assets.header')
    		<div id="main_container" class="container">
    			@yield('content')
    			@yield('after_content')
    		</div>
    		@include('assets.footer')
    	</div>
	</div>
	 @include('assets.forms')
</body>
</html>
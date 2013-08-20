<!DOCTYPE HTML>
<!--
___________________________________________________________
_____////////////////////////////////////////////////////||
____//|                Indira CMS               |///////|||
___///|        WE'RE PROWIDE HIGH-QUALITY       |//////||||
__////|   CONTACT AUTHOR: INFOatVELIOV.COM      |////||||||
_/////|               VeliovGroup.com           |//||||||||
//////////////////////////////////////////////////|||||||||
___________________________________________________________
-->
<!--[if lt IE 7]>   <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="{{ Session::get('lang'); }}"> <![endif]-->
<!--[if IE 7]>     <html class="no-js lt-ie9 lt-ie8" lang="{{ Session::get('lang'); }}"> <![endif]-->
<!--[if IE 8]>     <html class="no-js lt-ie9" lang="{{ Session::get('lang'); }}"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="{{ Session::get('lang'); }}"> <!--<![endif]-->
	<head>

		<meta charset="UTF-8" />

		<!-- STYLES -->
		{{ HTML::style('cms/styles/bootstrap.min.css') }}
		{{ HTML::style('cms/styles/vendor/font-awesome.min.css') }}
		<!--[if IE 7]>
			{{ HTML::style('cms/styles/vendor/font-awesome-ie7.min.css') }}
		<![endif]-->
		{{ HTML::style('cms/styles/vendor/add2home.css') }}
		{{ HTML::style('cms/styles/vendor/redactor.min.css') }}
		{{ HTML::style('cms/styles/indira.min.css') }}
		{{ HTML::style('cms/styles/vendor/animate.min.css') }}

		@if(TMPLT_TYPE == 'mobile')
			<style type="text/css">
				body {
					height: 100%;
					overflow: hidden;
				}
				.scroll, .scroll-y, .scroll-x {
					-webkit-overflow-scrolling: touch;
				}
				.scroll > *, .scroll-y > *, .scroll-x > * {
					-webkit-transform : translateZ(0);
				}
				.scroll { overflow: auto; }
				.scroll-y { overflow-y: auto; }
				.scroll-x { overflow-x: auto; }
			</style>
		@endif

		<!-- SCRIPTS -->
		{{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js') }}
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		{{ HTML::script('cms/scripts/vendor/jquery.history.js') }}
		{{ HTML::script('cms/scripts/vendor/redactor.js') }}
		{{ HTML::script('cms/scripts/vendor/gritter.min.js') }}
		{{ HTML::script('cms/scripts/bootstrap.min.js') }}
		{{ HTML::script('cms/scripts/vendor/fastclick.js') }}
		{{ HTML::script('cms/scripts/indira.min.js') }}
		{{ HTML::script('cms/scripts/app.js') }}

		@if(TMPLT_TYPE == 'mobile')
			{{ HTML::script('cms/scripts/nativescrolling.js') }}
		@endif

		@if(Admin::check() && TMPLT_TYPE == 'mobile')
			<script type="text/javascript">
				var addToHomeConfig = {
					animationIn: 'bubble',
					animationOut: 'drop',
					lifespan:10000,
					touchIcon:true,
				};
			</script>
			{{ HTML::script('cms/scripts/vendor/add2home.js') }}
		@endif
		
		<!-- META TAGS -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="generator" content="Indira CMS-Toolkit">

		<meta name="apple-mobile-web-app-title" content="Indira CMS">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

		<!-- TOUCH ICONS -->
		@foreach(Template::where('type', '=', 'icon')->get() as $icon)
			<link rel="{{ $icon->name }}" sizes="{{ $icon->additions }}" href="{{ asset($icon->value) }}">
		@endforeach

		<!-- SPLASH SCREEN FOR IOS_WEB APP -->
		@foreach(Template::where('type', '=', 'apple-touch-startup-image')->get() as $startup_image)

			<?php list($size, $media_query) = explode(',', $startup_image->additions); ?>

			<link href="{{ asset($startup_image->value) }}" media="{{ trim($media_query) }}" rel="apple-touch-startup-image">
		@endforeach

		<!-- ICONS AND IMAGES -->
		@foreach(Template::where('type', '=', 'shortcut icon')->get() as $icon)
			<link rel="{{ ($icon->name == 'image/png') ? 'icon' : $icon->type }}" type="{{ $icon->name }}" href="{{ asset($icon->value) }}">
		@endforeach

		<meta content="width=920, maximum-scale=1.0" name="viewport">

		<title>Indira CMS · Admin</title>

</head>
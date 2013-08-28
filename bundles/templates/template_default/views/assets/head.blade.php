<?php $template = Template::init(); ?>
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
<!--[if gt IE 8]><!--><html xmlns:og="http://ogp.me/ns#" itemscope itemtype="http://schema.org/WebPage" lang="{{ Session::get('lang'); }}"> <!--<![endif]-->
	<head>

		<meta charset="{{ Config::get('application.encoding') }}" />

		<!-- STYLES -->
		{{ Asset::container('header')->styles() }}
		@if(Admin::check())
			{{ HTML::style('cms/styles/vendor/redactor.min.css') }}
			<style type="text/css">
				.redactor_box {
					border: none;
					margin: 0px -20px;
				}
				.redactor_toolbar{
					top: -15px;
				}
			</style>
		@endif

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
		{{ Asset::container('header')->scripts() }}

		@if(Admin::check())
			{{ HTML::script('cms/scripts/vendor/redactor.js') }}
		@endif

		<!-- META TAGS -->		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="robots" content="{{ (isset($meta_robots)) ? $meta_robots : 'index, follow' }}">
		<meta name="google" content="notranslate">

		<meta name="generator" content="Indira CMS-Toolkit">
		<link rel="canonical" href="{{ (isset($canonical_url)) ? $canonical_url : rawurldecode(URL::full()) }}"/>

		<meta itemprop="description" name="description" content="{{ e((isset($description)) ? $description : $template->where('type', '=', 'meta')->and_where('name', '=', 'description')->only('value')) }}">
		<meta itemprop="keywords" name="keywords" content="{{ e((isset($keywords)) ? $keywords : $template->where('type', '=', 'meta')->and_where('name', '=', 'keywords')->only('value')) }}">

		<!-- Open Graph -->
		<meta itemprop="url" property="og:url" content="{{ (isset($canonical_url)) ? $canonical_url : rawurldecode(URL::full()) }}">
		<meta itemprop="image" property="og:image" content="{{ e((isset($image)) ? URL::to_asset($image) : URL::to_asset($template->where('type', '=', 'icon')->and_where('name', '=', 'image')->only('value'))) }}">
		<meta property="og:type" content="website">
		<meta property="og:title" content="{{ e((isset($title)) ? $title : $template->where('type', '=', 'meta')->and_where('name', '=', 'title')->only('value')) }}">
		<meta property="og:site_name" content="{{ Config::get('indira.name') }}">
		<meta property="og:description" content="{{ e((isset($description)) ? $description : $template->where('type', '=', 'meta')->and_where('name', '=', 'description')->only('value')) }}">

		<!-- TWITTER META -->
		<meta name="twitter:card" content="summary">
		<meta name="twitter:url" content="{{ (isset($canonical_url)) ? $canonical_url : rawurldecode(URL::full()) }}">
		<meta name="twitter:title" content="{{ e((isset($title)) ? $title : $template->where('type', '=', 'meta')->and_where('name', '=', 'title')->only('value')) }}">
		<meta name="twitter:description" content="{{ e((isset($description)) ? $description : $template->where('type', '=', 'meta')->and_where('name', '=', 'description')->only('value')) }}">
		<meta name="twitter:image" content="{{ e((isset($image)) ? URL::to_asset($image) : URL::to_asset($template->where('type', '=', 'icon')->and_where('name', '=', 'image')->only('value'))) }}">
		@if($twitter_site = $template->where('type', '=', 'meta')->and_where('name', '=', 'twitter:site')->only('value'))
		<meta name="twitter:site" value="@{{ $twitter_site }}">
		@endif
		@if($twitter_creator = $template->where('type', '=', 'meta')->and_where('name', '=', 'twitter:creator')->only('value'))
		<meta name="twitter:creator" value="@{{ $twitter_creator }}">
		@endif

		@if($author = $template->where('type', '=', 'meta')->and_where('name', '=', 'author')->only('value'))
		<link rel="author" href="{{ $author }}">
		@endif


		<meta name="apple-mobile-web-app-title" content="{{ Indira::get('name') }}">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- TOUCH ICONS -->
		@foreach(Template::where('type', '=', 'icon')->get() as $icon)
			<link rel="{{ $icon->name }}" sizes="{{ $icon->additions }}" href="{{ asset($icon->value) }}">

			<?php unset($icon) ?>
		@endforeach

		<!-- SPLASH SCREEN FOR IOS_WEB APP -->
		@foreach(Template::where('type', '=', 'apple-touch-startup-image')->get() as $startup_image)

			<?php list($size, $media_query) = explode(',', $startup_image->additions); ?>

			<link href="{{ asset($startup_image->value) }}" media="{{ trim($media_query) }}" rel="apple-touch-startup-image">

			<?php unset($icon, $size, $media_query) ?>
		@endforeach

		<!-- ICONS AND IMAGES -->
		@foreach(Template::where('type', '=', 'shortcut icon')->get() as $icon)
			<link rel="{{ ($icon->name == 'image/png') ? 'icon' : $icon->type }}" type="{{ $icon->name }}" href="{{ asset($icon->value) }}">
			
			<?php unset($icon) ?>
		@endforeach
		
		<title>{{ e((isset($title)) ? $title : $template->where('type', '=', 'meta')->and_where('name', '=', 'title')->only('value')) }}</title>

</head>
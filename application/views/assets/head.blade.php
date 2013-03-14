<!DOCTYPE HTML>
<!--
____________________________________________________________________________
_________////////////////////////////////////////////////////|_____________
________////////////////////////////////////////////////////||____________
_______//|                Indira CMS               |///////|||////////////\
______///|       WE'RE PROWIDE HIGH-QUALITY        |//////||||///////////_\\
_____////|_AND_NON-COMMERCIAL_SERVICES_FOR_PEOPLE__|/////|||||//////////_\\\\
____/////|     CONTACT AUTHOR: INFOatVELIOV.COM;   |////||||||/////////_\\\\\\
___//////|        SaaS APPS AND DEVELOPMENT.       |///|||||||////////_\\\\\\\\
__///////|           (c) VeliovGroup.com           |//||||||||///////_\\\\\\\\\\
_////////////////////////////////////////////////////|||||||||//////_\\\\\\\\\\\\
////////////////////////////////////////////////////||||||||||/////_\\\\\\\\\\\\\\
_________|||||||||||||||||||||||||||||||||||||||||||||||||||||////_\\\\\\\\\\\\\\\\
_________|||||||||||||||||||||||||||||||||||||||||||||||||||||///_\\\\\\\\\\\\\\\\\\
_________|||||||||||||||||||||||||||||||||||||||||||||||||||||//_\\\\\\\\\\\\\\\\\\\\
______________________________________________________________________________________
-->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html itemscope itemtype="http://schema.org/WebPage" xmlns:og="http://ogp.me/ns#" style="padding:0px; margin:0px;" class="no-js" lang="{{ Session::get('lang'); }}"> <!--<![endif]-->
	<head>
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/bootstrap-responsive.css') }}
		{{ HTML::style('css/styles.css') }}
		{{ HTML::style('css/font-awesome.min.css') }}
		{{ HTML::style('js/css/redactor.css') }}
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		{{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js') }}
		{{ HTML::script('js/modernizr-2.5.3.min.js') }}
		{{ HTML::script('js/indira.js') }}
		
		@if (Admin::check() && isset($post->id))
			{{ HTML::script('js/redactor.js') }}
			<? $json_save = '{"id": "'.$post->id.'", "title": "\'+encodeURI(\''.$post->title.'\')+\'", "text": "\'+encodeURI($(\'#text_'.$post->id.'\').html())+\'", "access": "'.$post->access.'", "media": "'.$post->media.'", "section": "'.$post->section.'", "tags": "\'+encodeURI(\''.$post->tags.'\')+\'", "lang": "'.$post->lang.'"}'; ?>
			<script>
				function save_btn(){
					showerp('<?= $json_save ?>', '../admin/post_area/save', 'save_button_{{ $post->id }}', 'status', false, true);
				}
			</script>
			@if(isset($_GET['edit']) == 'true')
				<script>
					$(function(){
						$('#text_{{ $post->id }}').redactor();
					});
				</script>
			@endif
		@endif

		<script type="text/javascript">
			  $.ajax({
			    url: 'http://api.twitter.com/1/users/show.json',
			    data: {screen_name: 'smart_egg'},
			    dataType: 'jsonp',
			    success: function(data) {
			      $('#se_followers').html(data.followers_count);
			    }
			  });
			  $.ajax({
			    url: 'http://api.twitter.com/1/users/show.json',
			    data: {screen_name: 'VeliovGroup'},
			    dataType: 'jsonp',
			    success: function(data) {
			      $('#vg_followers').html(data.followers_count);
			    }
			  });
			  $.ajax({
			    url: 'https://api.github.com/repos/dr-dimitru/indira',
			    dataType: 'jsonp',
			    success: function(data) {
			      $('#watchers').html(data.data.watchers);
			      $('#forks').html(data.data.forks);
			    }
			  });
		</script>
		
		<meta charset="UTF-8" />
		
		<!-- META TAGS -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="generator" content="Indira CMS-Toolkit">
		
		<link rel="shortcut icon" href="img/favicon.ico" />
		<link rel="apple-touch-icon-precomposed" href="img/icon.png">

		<!--[if IE 7]>
			<link rel="stylesheet" href="css/font-awesome-ie7.min.css">
		<![endif]-->

		@if ( isset($post->title) )
			<title>{{ Config::get('application.name') }} » {{ $post->title }}</title>
		@else
			<title>{{ Config::get('application.name') }}</title>
		@endif

</head>
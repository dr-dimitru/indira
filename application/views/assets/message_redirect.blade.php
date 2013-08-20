<?php

if(!isset($data_out)){

	$data_out = 'work_area';
}

if(!isset($data_link)){ 

	$data_link = Session::get('href.previous');

}

if(!isset($data_load)){ 

	$data_load = 'super_logo';

}

if(!isset($data_title)){ 

	$data_title = '';

}
?>

@if(isset($lang_line))
	{{ Lang::line($lang_line) }}
@endif

@if(isset($text))
	
	@if(isset($success))
		{{ Utilites::success_message($text) }}
	@elseif(isset($fail))
		{{ Utilites::fail_message($text) }}
	@else
		{{ $text }}
	@endif

@endif

	<script type="text/javascript">

		@if(isset($location_replace))

			location.replace("{{ $data_link }}");

		@else
			$(function(){
				History.pushState({"query":null, "load_element":"{{ $data_load }}", "out_element":"{{ $data_out }}", "msg":null, "appnd":false, "rstr":true, "enc":true}, '{{ $data_title }}', '{{ $data_link }}');
			});
		@endif

	</script>
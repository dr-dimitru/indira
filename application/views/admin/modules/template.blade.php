@yield('modules')
<script type="text/javascript">

	$('select').change(function(){

		if($('button[id^="ajax_save_button"]').attr('disabled')){

			$('button[id^="ajax_save_button"]').attr('disabled', false);
		}

	});

	$('textarea, input').on('input', function(){

		if($('button[id^="ajax_save_button"]').attr('disabled')){

			$('button[id^="ajax_save_button"]').attr('disabled', false);
		}

	});

</script>
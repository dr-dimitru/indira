@yield('pages')
<script type="text/javascript">

	$('input[id^="tags"]').typeahead({

		"source": {{ Utilites::get_all_tags() }}
	});

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
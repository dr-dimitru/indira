@__yield('newsletter')
<?php
	$users = array();
	$subscribed_users = array();

	if($select = Users::only(array('email', 'newsletter_subscription'))){
		
		foreach($select as &$user){

			$users[] = trim($user["email"]);

			if($user["newsletter_subscription"] == 'true'){
				
				$subscribed_users[] = trim($user["email"]);
			}

			unset($user);
		}

		unset($select);
	}
?>
<script type="text/javascript">

	$('#pretty_checkbox_icon').bind('click',function(e){

		var subscribed_users = {{ json_encode(array_values($subscribed_users)) }};

		if($('input[id^="to_all_subscribers"]').val() == 'true'){

			subscribed_users = subscribed_users.join(',');

			$('input[id^="to"]input[id$="_fake_multiselect"]').val(subscribed_users);

			$('input[id^="to"]input[id$="_fake_multiselect"]').trigger('enterKey');
		
		}else{

			var to = $('#' + $('input[id^="to"]input[id$="_fake_multiselect"]').attr('data-id')).val().split(',');

			var to_remove = jQuery.grep(subscribed_users, function(value) {

				return (jQuery.inArray(to, value));

			});

			$.each(to_remove, function(index, value){

				removePrettyMultiselect($('i[class="icon-remove"]i[data-pretty-multiselect="' + value + '"]'), $('input[id^="to"]input[id$="_fake_multiselect"]').attr('data-id'));

			});
		}
	});
	
	$('input[id^="to"]input[id$="_fake_multiselect"]').typeahead({

		"source": {{ json_encode(array_values($users)) }}
	});

	$('select').change(function(){

		if($('button[id^="ajax_save_button"]').attr('disabled')){

			$('button[id^="ajax_save_button"]').attr('disabled', false);
		}

	});

	$('textarea, input, .redactor_editor').on('input', function(){

		if($('button[id^="ajax_save_button"]').attr('disabled')){

			$('button[id^="ajax_save_button"]').attr('disabled', false);
		}

	});

</script>
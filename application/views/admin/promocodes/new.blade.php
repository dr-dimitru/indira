<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>

<div class="modal-body scroll scroll-y">

	@foreach($fields as $column => $value)

		{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern'), __('promocode.'.$column), $fields[$column]['attributes']) }}

	@endforeach
	
</div>

<div class="modal-footer">
	<div class="actions">

		<button 
			id="ajax_save_button_new_promocode"
			class="btn"
			type="button"
			disabled="disabled" 
			data-link="{{ action('admin.promocodes.action@save') }}?new=true" 
			data-post="{{ e($json_save) }}"
			data-out="status"
			data-out-popup="true"
			data-prevent-follow="true"
		>
			<i class="icon-save green"></i> {{ __('forms.save_word') }}
		</button>

		<span id="status" class="btn disabled"></span>

	</div>
</div>

<script type="text/javascript">
	
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
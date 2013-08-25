@layout('admin.newsletter.template')

<h3>
	<i class="icon-envelope-alt"></i> {{ __('content.newsletter') }} · {{ __('content.add_new_word') }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.newsletter.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.newsletter')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
		<button 
			id="ajax_save_button"
			class="btn"
			type="button"
			disabled="disabled" 
			data-post="{{ e($json_save) }}"
			data-link="{{ action('admin.newsletter.action@save') }}?new=true"
			data-out="null"
			data-out-popup="true"
			data-prevent-follow="true"
			title="{{ __('forms.save_word') }}"
		>
			<i class="icon-save green"></i>
		</button>
	</div>
</div>

@section('newsletter')
	<div class="row-fluid">
		<div class="span11">

			<div class="form-horizontal">

				@foreach($fields as $column => $value)

					{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern_2'), __('newsletter.'.$column), $fields[$column]['attributes']) }}

				@endforeach
			</div>

		</div>
	</div>

	<hr>

	<div class="row-fluid">
		<div class="span12">
			<div class="redactor_area">
				<div
					class="input-block-level"
					id="text" 
					onkeypress="$('button[id^={{ e('"ajax_save_button"') }}]').attr('disabled', false);"
				></div>
			</div>
		</div>
	</div>

	<div class="form-actions">
		<div class="row-fluid">
			<div class="span12">
				<div class="control-group" style="text-align: center">
					<div class="controls">

						<button 
							id="ajax_save_button"
							class="btn"
							type="button"
							disabled="disabled" 
							data-link="{{ action('admin.newsletter.action@save') }}?new=true" 
							data-post="{{ e($json_save) }}"
							data-out="null"
							data-out-popup="true"
							data-prevent-follow="true"
						>
							<i class="icon-save green"></i> {{ __('forms.save_word') }}
						</button>

						<button 
							id="ajax_save_button_and_send"
							class="btn"
							type="button"
							disabled="disabled" 
							data-link="{{ action('admin.newsletter.action@save') }}?new=true&send=true" 
							data-post="{{ e($json_save) }}"
							data-out="null"
							data-out-popup="true"
							data-prevent-follow="true"
						>
							<i class="icon-envelope green"></i> {{ __('newsletter.save_and_send') }}
						</button>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

<script>
	$(function(){
		$('#text').redactor();
	});
</script>
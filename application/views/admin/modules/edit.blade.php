@layout('admin.modules.template')

<h3>
	<i class="icon-suitcase"></i> {{ __('content.modules_word') }} · {{ stripslashes($module->name) }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back" 
			class="btn"
			href="{{ action('admin.modules.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.modules_word')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@section('modules')
	
<div class="row-fluid">
	<div class="offset3 span6">

		@foreach($fields as $column => $value)

			{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern'), __('forms.'.$column.'_word'), $fields[$column]['attributes'], $module->id) }}

		@endforeach

	</div>
</div>

<div class="form-actions">
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group" style="text-align: center">
				<div class="controls">

					<button 
						id="ajax_save_button_{{ $module->id }}"
						class="btn"
						type="button"
						disabled="disabled" 
						data-post="{{ e($json_save) }}"
						data-link="{{ action('admin.modules.action@save') }}"
						data-prevent-follow="true"
						data-out-popup="true"
						data-out="status_{{ $module->id }}"
					>
						<i class="icon-save green"></i> {{ __('forms.save_word') }}
					</button>

					<span id="status_{{ $module->id }}" class="btn disabled"></span>
				
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
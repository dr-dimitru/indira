@layout('admin.languages.template')

<h3>
	<i class="icon-globe"></i> {{ __('content.language_word') }} · {{ __('content.add_new_word') }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.languages.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.locales')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@section('languages')
	<div class="offset3 span6">
		@foreach($fields as $column => $value)

			{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern'), __('languages.'.$column), $fields[$column]['attributes']) }}

		@endforeach
	</div>

	<div class="clearfix"></div>

	<div class="form-actions">
		<div class="row-fluid">
			<div class="span12">
				<div class="control-group" style="text-align:center">
					<div class="controls">

						<button 
							id="ajax_save_button" 
							class="btn" 
							type="button"
							data-link="{{ URL::to('admin/languages/action/save') }}" 
							data-post="{{ e($json_save) }}" 
							data-out="status"
							data-prevent-follow="true" 
							data-out-popup="true"
							disabled
						>
							<i class="icon-save green"></i> {{ __('forms.save_word') }}
						</button>
				
						<span id="status" class="btn disabled"></span>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
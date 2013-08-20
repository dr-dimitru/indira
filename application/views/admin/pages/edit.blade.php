@layout('admin.pages.template')

<h3>
	<i class="icon-file-alt"></i> {{ $pages->title }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn btn-small"
			href="{{ action('admin.pages.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.pages_word')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>

		<a href="{{ URL::to_route('pages', array(($pages->link) ? $pages->link : $pages->id)).'?edit=true' }}" class="btn btn-inverse" title="{{ __('forms.edit_on_page') }}">
			<i class="icon-lemon"></i>
		</a>

		<button 
			id="ajax_save_button"
			class="btn"
			type="button"
			disabled="disabled" 
			data-post="{{ e($json_save) }}"
			data-link="{{ action('admin.pages.action@save') }}"
			data-prevent-follow="true"
			data-out-popup="true"
			data-out="status"
		>
			<i class="icon-save green"></i>
		</button>
	</div>
</div>

@section('pages')

<div class="row-fluid">
	<div class="offset3 span6">

		@foreach($fields as $column => $value)

			{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern'), __('forms.'.$column.'_word'), $fields[$column]['attributes'], $pages->id) }}

		@endforeach

	</div>
</div>

<div class="form-actions">
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group" style="text-align: center">

				<div class="controls btn-group">
					<a href="{{ URL::to_route('pages', array(($pages->link) ? $pages->link : $pages->id)).'?edit=true' }}" class="btn btn-inverse" title="{{ __('forms.edit_on_page') }}">
						<i class="icon-lemon"></i>
					</a>
					<button 
						id="ajax_save_button"
						class="btn"
						type="button"
						disabled="disabled" 
						data-post="{{ e($json_save) }}"
						data-link="{{ action('admin.pages.action@save') }}"
						data-prevent-follow="true"
						data-out-popup="true"
						data-out="status"
					>
						<i class="icon-save green"></i> {{ __('forms.save_word') }}
					</button>

					<span id="status" class="btn disabled">&nbsp;</span>

				</div>
			</div>
		</div>
	</div>
</div>

@endsection
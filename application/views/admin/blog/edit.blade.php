@layout('admin.blog.template')

<h3>
	<i class="icon-coffee"></i> {{ __('content.blog_word') }} · {{ stripslashes($blog->title) }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.blog.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>

		<button 
			id="edit_button_{{ $blog->id }}"
			class="btn"
			type="button"
			title="{{ __('forms.edit_word') }}" 
			onclick="$('#text_{{ $blog->id }}').redactor(<?php echo (DEVICE_TYPE == 'desktop') ? '{fixed: true}' : null; ?>); $('button[id^={{ e('"edit_button_"')}}]').attr('disabled', true); $('button[id^={{ e('"ajax_save_button"') }}], #text_{{ $blog->id }}').attr('disabled', false);"
		>
			<i class="icon-pencil blue"></i>
		</button>

		<a href="{{ URL::to_route('blog', array(($blog->link) ? $blog->link : $blog->id)).'?edit=true' }}" class="btn btn-inverse" title="{{ __('forms.edit_on_page') }}">
			<i class="icon-lemon"></i>
		</a>

		<button 
			id="ajax_save_button_{{ $blog->id }}"
			class="btn"
			type="button"
			title="{{ __('forms.save_word') }}"
			disabled="disabled" 
			data-post="{{ e($json_save) }}"
			data-link="{{ action('admin.blog.action@save') }}"
			data-out="status"
			data-out-popup="true"
			data-prevent-follow="true"
		>
			<i class="icon-save green"></i>
		</button>
	</div>
</div>

@section('blog')

<div class="row-fluid">
	<div class="span4">

		@foreach($fields as $column => $value)

			{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern'), __('forms.'.$column.'_word'), $fields[$column]['attributes'], $blog->id) }}

		@endforeach

	</div>

	<div class="span8">
		<h6 style="margin-top: -3px;">{{ __('forms.text_word') }} 
			<sup>
				<i 	class="icon-pencil icon-large blue" 
					style="cursor:pointer" 
					onclick="$('#text_{{ $blog->id }}').redactor(<?php echo (DEVICE_TYPE == 'desktop') ? '{fixed: true}' : null; ?>); $('button[id^={{ e('"edit_button_"')}}]').attr('disabled', true); $('button[id^={{ e('"ajax_save_button"') }}], #text_{{ $blog->id }}').attr('disabled', false);"
					title="{{ __('content.edit_word') }}"
				></i>
			</sup>
		</h6>

		<div class="redactor_area">
			<div
				class="input-block-level"
				id="text_{{ $blog->id }}" 
				onkeypress="$('button[id^={{ e('"ajax_save_button"') }}]').attr('disabled', false);"
			>{{ $blog->text }}</div>
		</div>
	</div>
</div>

<div class="form-actions">
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group" style="text-align: center">
				<div class="controls">

					<div class="btn-group">
						<button 
							id="edit_button_{{ $blog->id }}"
							class="btn"
							type="button" 
							title="{{ __('forms.edit_word') }}"
							onclick="$('#text_{{ $blog->id }}').redactor(<?php echo (DEVICE_TYPE == 'desktop') ? '{fixed: true}' : null; ?>); $('button[id^={{ e('"edit_button_"')}}]').attr('disabled', true); $('button[id^={{ e('"ajax_save_button"') }}], #text_{{ $blog->id }}').attr('disabled', false);"
						>
							<i class="icon-pencil blue"></i>
						</button>

						<button 
							id="ajax_save_button_{{ $blog->id }}"
							class="btn"
							type="button"
							disabled="disabled" 
							data-link="{{ action('admin.blog.action@save') }}" 
							data-post="{{ e($json_save) }}"
							data-out="status"
							data-out-popup="true"
							data-prevent-follow="true"
						>
							<i class="icon-save green"></i> {{ __('forms.save_word') }}
						</button>
					</div>
					
					<span id="status" class="btn disabled"></span>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
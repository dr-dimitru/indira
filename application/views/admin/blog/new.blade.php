@layout('admin.blog.template')

<h3>
	<i class="icon-coffee"></i> {{ __('content.blog_word') }} · {{ __('content.add_new_word') }}
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
			id="ajax_save_button"
			class="btn"
			type="button"
			disabled="disabled" 
			data-post="{{ e($json_save) }}"
			data-link="{{ action('admin.blog.action@save') }}?new=true"
			data-out="status"
			data-out-popup="true"
			data-prevent-follow="true"
			title="{{ __('forms.save_word') }}"
		>
			<i class="icon-save green"></i>
		</button>
	</div>
</div>

@section('blog')
	<div class="row-fluid">
		<div class="span4">

			@foreach($fields as $column => $value)

				{{ Utilites::html_form_build($fields[$column]['type'], $fields[$column]['data'], View::make('admin.assets.form_pattern'), __('forms.'.$column.'_word'), $fields[$column]['attributes']) }}

			@endforeach

		</div>

		<div class="span8">
			<h6>{{ __('forms.text_word') }}</h6>

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

						<div class="btn-group">
							<button 
								id="ajax_save_button"
								class="btn"
								type="button"
								disabled="disabled" 
								data-link="{{ action('admin.blog.action@save') }}?new=true" 
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

<script>
	$(function(){
		$('#text').redactor();
	});
</script>
<div id="edit_user_form" class="form edit-form" style="display:none">
	<div class="fields">

		@foreach($edit_user_form_fields as $column => $value)

			{{ Utilites::html_form_build($edit_user_form_fields[$column]['type'], $edit_user_form_fields[$column]['data'], View::make('templates::assets.form_pattern'), __('forms.'.$column.'_word'), $edit_user_form_fields[$column]['attributes'], Session::get('user.id')) }}

		@endforeach

		<div id="status_user_edit"></div>
	</div>

	<div class="actions">
		<button 
			id="ajax_user_save"
			class="btn btn-block" 
			type="button"
			data-link="{{ URL::to_route('user_signup') }}?frontend=true"
			data-post="{{ e(Utilites::json_with_js_encode($json_edit_user_form, $user_id)) }}"
			data-out="status_user_edit"
			data-prevent-follow="true"
		>
			{{ __('templates::content.save_word') }}
		</button>
		<hr>
		<button 	
			onclick="$('#user_info').slideToggle();$('#edit_user_form').slideToggle()"
			class="btn btn-block" 
			type="button"
		>
			{{ __('templates::content.close_word') }}
		</button>
	</div>
</div>
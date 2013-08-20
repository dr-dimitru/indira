<div id="user_sign_form" class="form edit-form" style="display:none">
	<div class="fields">

		@foreach($user_sign_form_fields as $column => $value)

			{{ Utilites::html_form_build($user_sign_form_fields[$column]['type'], $user_sign_form_fields[$column]['data'], View::make('templates::assets.form_pattern'), __('forms.'.$column.'_word'), $user_sign_form_fields[$column]['attributes']) }}

		@endforeach

		<div id="status_user_edit"></div>
	</div>

	<div class="actions">
		<button 
			id="ajax_user_save"
			class="btn" 
			type="button"
			data-link="{{ URL::to_route('user_signup') }}?new=true&frontend=true"
			data-post="{{ e(Utilites::json_with_js_encode($json_user_sign_form)) }}"
			data-out="status_user_edit"
			data-prevent-follow="true"
		>
			{{ __('templates::content.registration_word') }}
		</button>
		<button 	
			onclick="$('#user_login_form').slideToggle();$('#user_sign_form').slideToggle()"
			class="btn pull-right" 
			type="button"
		>
			{{ __('templates::content.cancel_word') }}
		</button>
	</div>
</div>
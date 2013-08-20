<div id="user_iforgot" class="form iforgot-form" style="display:none">
	<div class="fields">
		
		<div class="controls">
			<input 
				REQUIRED 
				class="input" 
				id="iforgot_email" 
				type="email" 
				placeholder="email"
				value="{{ (Cookie::get('user_login')) ? trim(Crypter::decrypt(Cookie::get('user_login'))) : null }}" 
			/>
			
			<button 
				id="ajax_iforgot_password"
				class="btn btn-block"
				data-link="{{ URL::to_route('user_iforgot') }}"
				data-post="{{ e('{"email": encodeURI($(\'#iforgot_email\').val())}') }}"
				data-out="status_user_iforgot"
				data-prevent-follow="true"
				title="{{ __('content.pass_recovery_action') }}"
			>
				{{ __('content.pass_recovery_action') }} <i class="icon-angle-right icon-large"></i>
			</button>
		</div>

		<div id="status_user_iforgot"></div>

	</div>

	<button 	
		onclick="$('#user_iforgot').slideToggle();$('#user_login_form').slideToggle()"
		class="btn" 
		type="button"
	>
		{{ __('templates::content.cancel_word') }}
	</button>
</div>
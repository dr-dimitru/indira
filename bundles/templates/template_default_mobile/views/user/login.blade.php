<div id="user_login_form" class="form login-form">
	<div class="fields">
		<div class="form-group">
			<input 
				id="email_user_login"
				type="email" 
				placeholder="{{ __('templates::content.email_word') }}" 
				value="{{ (Cookie::get('user_login')) ? trim(Crypter::decrypt(Cookie::get('user_login'))) : null }}"
				class="form-control"
			/>
		</div>

		<div class="form-group">
			<input 
				id="password_user_login"
				type="password" 
				placeholder="{{ __('templates::content.password_word') }}" 
				value="{{ (Cookie::get('user_login')) ? trim(Crypter::decrypt(Cookie::get('user_password'))) : null }}"
				class="form-control"
			/>
		</div>

		<i 	id="remember_me" 
			style="cursor: pointer"
			onclick="if($('#remember_user_login').val() !== '1'){$('#remember_user_login').val('1'); $(this).removeClass().addClass('icon-check'); }else{$('#remember_user_login').val('0'); $(this).removeClass().addClass('icon-check-empty'); }" 
			class="icon-check"
		> 
			{{ __('templates::content.remember_me_word') }}
		</i>

		<input  
			id="remember_user_login" 
			name="remember" 
			type="hidden"
			style="display:none" 
			value="1" 
			onchange="if(this.value !== '1'){this.value = '1'; }else{this.value = '0'}"
		/>

		<div id="status_user_login"></div>
	</div>

	<div class="actions">
		<button 
			id="ajax_user_login"
			class="btn" 
			type="button"
			data-link="{{ URL::to_route('user_login') }}"
			data-post="{{ e(Utilites::json_with_js_encode(array('email' => null, 'password' => null, 'remember' => null), 'user_login')) }}"
			data-out="status_user_login"
			data-prevent-follow="true"
		>
			{{ __('templates::content.login_word') }}
		</button>
		<button 	
			onclick="$('#user_login_form').slideToggle();$('#user_sign_form').slideToggle()"
			class="btn pull-right" 
			type="button"
		>
			{{ __('templates::content.registration_word') }}
		</button>
	</div>
</div>
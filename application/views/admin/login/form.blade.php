<h6>{{ __('content.login_word') }}</h6>
<div class="form-inline">
	<div class="input-prepend input-append">
		<span class="add-on"><i class="icon-user"></i></span>
		<input 
			id="name" 
			type="text" 
			class="input" 
			placeholder="{{ __('placeholders.login') }}" 
			value="{{ $admin_login }}" 
			autocapitalize="none"
			autocorrect="off"
		/>

		<span class="add-on"><i class="icon-key"></i></span>
		<input 
			id="password" 
			type="password" 
			class="input" 
			placeholder="{{ __('placeholders.password') }}" 
			value="{{ $admin_password }}" 
			autocapitalize="none"
			autocorrect="off"
		/>

		<button 
			id="login_button"
			class="ajax_login_button btn btn-inverse"
			type="button"
			data-link="{{ action('admin.home@login') }}" 
			data-post="{{ e($json_query) }}"
			data-out="status"
			data-prevent-follow="true"
			data-out-popup="true"
		>
			{{ __('content.login_action_word') }} <i class="icon-fighter-jet gold"></i>
		</button>

	</div>
</div>
<div>
	<i 
        style="cursor: pointer"
        onclick="if($('#remember').val() !== '1'){$('#remember').val('1'); $(this).removeClass().addClass('icon-check'); }else{$('#remember').val('0'); $(this).removeClass().addClass('icon-check-empty'); }" 
        id="remember-me_icon" 
        class="icon-check"> 
            {{ __('content.remember_me_word') }}
    </i>

    <input  
        id="remember" 
        name="remember" 
        type="hidden"
        style="display:none" 
        value="1" 
        onchange="if(this.value !== '1'){this.value = '1'; }else{this.value = '0'}"
    />

</div>

<h6>{{ __('content.login_annotation') }}</h6>

<div id="status"></div>

<a
	id="go_to_password_recovery"
	class="btn btn-mini btn-inverse" 
	href="{{ action('admin.home@password_recovery') }}"
	onclick="$('#main_modal').modal('show')"
	data-prevent-follow="true"
	data-out="main_modal"
	data-load="main_modal"
>
	<i class="icon-warning-sign red"></i> {{ __('content.pass_recovery_word') }}
</a>
<script type="text/javascript">
$(document).keypress(function(e) {
    if(e.which == 13 && $('#name.input').is(":focus") || e.which == 13 && $('#password.input').is(":focus")) {
        showerp('{{ $login_query }}', '{{ action('admin.home@login') }}', 'super_logo', 'status', false, true);
    }
});
</script>
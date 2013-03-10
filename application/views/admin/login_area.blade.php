<? $login_query = '{ "login": "\'+$(\'#admin_login\').val()+\'", "password": "\'+$(\'#admin_password\').val()+\'", "remember": "\'+$(\'#remember-me\').val()+\'" }'; 
$admin_login = null;
$admin_password = null;

if(Cookie::get('admin_login')){
	$admin_login = trim(Crypter::decrypt(Cookie::get('admin_login', null)));
}
if(Cookie::get('admin_password')){
	$admin_password = trim(Crypter::decrypt(Cookie::get('admin_password', null)));
}
?>
<h6>{{ Lang::line('content.login_word')->get(Session::get('lang')) }}</h6>
<div class="form-inline">
	<div class="input-prepend">
		<span class="add-on"><i class="icon-user"></i></span>
		<input 
			id="admin_login" 
			type="text" 
			class="input" 
			placeholder="{{ Lang::line('content.name_word')->get(Session::get('lang')) }}" 
			value="{{ $admin_login }}" 
		/>
	</div>

	<div class="input-prepend">
		<span class="add-on"><i class="icon-key"></i></span>
		<input 
			id="admin_password" 
			type="password" 
			class="input" 
			placeholder="{{ Lang::line('content.password_word')->get(Session::get('lang')) }}" 
			value="{{ $admin_password }}" 
		/>
	</div>

	<button 
		style="min-width: 60px" 
		id="login_button" 
		onclick="showerp('{{ htmlspecialchars($login_query) }}', '{{ URL::to('admin/login') }}', 'status', 'status', false)" 
		class="btn btn-primary" 
		type="submit">{{ Lang::line('content.login_action_word')->get(Session::get('lang')) }}
	</button>
</div>
<div>
	<i 
        style="cursor: pointer"
        onclick="if($('#remember-me').val() !== '1'){$('#remember-me').val('1'); $(this).removeClass().addClass('icon-check'); }else{$('#remember-me').val('0'); $(this).removeClass().addClass('icon-check-empty'); }" 
        id="remember-me_icon" 
        class="icon-check"> 
            {{ Lang::line('content.remember_me_word')->get(Session::get('lang')) }}
    </i>
    <label class="checkbox" style="margin: 0px 5px">
        <input 
            CHECKED 
            id="remember-me" 
            name="remember-me" 
            type="hidden"
            style="display:none" 
            value="1" 
            onchange="if(this.value !== '1'){this.value = '1'; }else{this.value = '0'}"
        />
    </label>
</div>
<h6>{{ Lang::line('content.login_annotation')->get(Session::get('lang')) }}</h6>
<div id="status"></div>
<a 
    href="#pass_recovery_form" 
    class="btn btn-mini" 
    data-toggle="modal">
        <i class="icon-warning-sign"></i> {{ Lang::line('content.pass_recovery_word')->get(Session::get('lang')) }}
</a>
<script type="text/javascript">
$(document).keypress(function(e) {
    if(e.which == 13 && $('#admin_login').is(":focus") || e.which == 13 && $('#admin_password').is(":focus")) {
        showerp('{{ $login_query }}', '{{ URL::to("admin/login") }}', 'status', 'status', false);
    }
});
</script>
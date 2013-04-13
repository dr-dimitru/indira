{{-- LOGIN ERRORS --}}
@if($uni_error == 'incorrect_login_message')
    <div class="alert alert-error">{{ Lang::line('content.incorrect_login_message')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'empty_login_message')
    <div class="alert alert-error">{{ Lang::line('content.empty_login_message')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'incorrect_pass_message')
    <div class="alert alert-error">{{ Lang::line('content.incorrect_pass_message')->get(Session::get('lang')) }}</div>
@endif


@if($uni_error == 'user_success_login')
    {{ Lang::line('content.user_success_login')->get(Session::get('lang')) }}<script type="text/javascript">location.replace('{{ Session::get('href.previous') }}');</script>
@endif

@if($uni_error == 'admin_success_login')
    {{ Lang::line('content.user_success_login')->get(Session::get('lang')) }}<script type="text/javascript">location.replace('{{ Session::get('href.previous') }}');</script>
@endif


{{-- REGISTRATION ERRORS --}}
@if($uni_error == 'incorrect_email_message')
    <div class="alert alert-error">{{ Lang::line('content.incorrect_email_message')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'registered_message')
    <div class="alert alert-error">{{ Lang::line('content.registered_message')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'name_error_message')
    <div class="alert alert-error">{{ Lang::line('content.name_error_message')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'password_error')
    <div class="alert alert-error">{{ Lang::line('content.password_error')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'incorrect_pass_repass')
    <div class="alert alert-error">{{ Lang::line('content.incorrect_pass_repass')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'user_success_signup')
    {{ Lang::line('content.user_success_signup')->get(Session::get('lang')) }}<script type="text/javascript">location.replace('{{ Session::get('href.previous') }}')</script>
@endif


{{-- PROMO CODE ERRORS --}}
@if($uni_error == 'others_promo_message')
    <div class="alert alert-error">{{ Lang::line('content.others_promo_message')->get(Session::get('lang')) }}</div>
@endif

@if($uni_error == 'non_exsist_promo_message')
    <div class="alert alert-error">{{ Lang::line('content.non_exsist_promo_message')->get(Session::get('lang')) }}div>
@endif


{{-- PASS RECOVERY ERRORS --}}
@if($uni_error == 'user_success_recovery')
    {{ Lang::line('content.user_success_recovery')->get(Session::get('lang')) }}
@endif
@if(!Session::get('user.name'))
<ul class="nav">
	<li>
		<a href="#login_form" data-toggle="modal"><i class="icon-signin"></i> {{ Lang::line('content.login_word')->get(Session::get('lang')) }}</a>
	</li>
	<li>
		<a href="#registration_form" data-toggle="modal"><i class="icon-edit"></i> {{ Lang::line('content.registration_word')->get(Session::get('lang')) }}</a>
	</li>
	<li class="divider-vertical"></li>
</ul>
@else
<a class="brand" href="#"><i class="icon-user"></i> {{ Session::get('user.name') }}</a>
<ul class="nav">
	<li>
		<a id="logout_href" href="#user_login_logout" onclick="shower('{{ Config::get('application.url') }}/user_logout', 'logout_href', 'user_login_logout')"><i class="icon-off"></i> {{ Lang::line('content.logout_word')->get(Session::get('lang')) }}</a>
	</li>
	<li class="divider-vertical"></li>
</ul>
@endif
@if(isset($redirect))
<script type="text/javascript">location.replace('{{ Session::get('href.previous') }}');</script>
@endif
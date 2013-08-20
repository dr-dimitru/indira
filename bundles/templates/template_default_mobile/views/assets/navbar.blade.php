<ul class="navigation-links">
	<li class="logo">
		<a 	id="go_to_main_page"
			href="{{ URL::to_route('main_page') }}"
			data-title="{{ Indira::get('name') }}"
		>
			{{ ($logo = Template::where('type', '=', 'logo')->only('value')) ? $logo : Config::get('indira.name') }}
		</a>
	</li>
	<li style="min-width:35px"><span id="super_logo"><i style="color:#FAFAFA" class="icon-lemon icon-2x"></i></span></li>
</ul>
<ul class="navigation-links">
	<li style="min-width:35px"><span id="super_logo"><i style="color:#FAFAFA" class="icon-lemon icon-2x"></i></span></li>
	<li class="logo">
		<a 	id="go_to_main_page"
			href="{{ URL::to_route('main_page') }}"
			data-title="{{ Indira::get('name') }}"
		>
			{{ ($logo = Template::where('type', '=', 'logo')->only('value')) ? $logo : Config::get('indira.name') }}
		</a>
	</li>
	<li class="divider-vertical"></li>
	@if(Indira::get('modules.sections.active') && Indira::get('modules.posts.active'))
	<li>
		<a 	id="go_to_contents"
			href="{{ URL::to_route('posts_listing') }}"
			data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.contents_word')) }}"
		>
			{{ __('templates::content.contents_word') }}
		</a>
	</li>
	<li class="divider-vertical"></li>
	@endif
	@if(Indira::get('modules.blog.active'))
	<li>
		<a 	id="go_to_contents"
			href="{{ URL::to_route('blog_listing') }}"
			data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.blog_word')) }}"
		>
			{{ __('templates::content.blog_word') }}
		</a>
		
	</li>
	<li class="divider-vertical"></li>
	@endif
</ul>
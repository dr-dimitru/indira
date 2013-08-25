<div class="navbar-inner">
	<ul class="nav" id="admin_nav">
		<li id="ajax_go_to_admin_home"
			data-link="{{ URL::to('admin') }}"
		>
			<a 	class="super_logo" 
				id="super_logo"
			>
				<i class="icon-lemon icon-2x"></i>
			</a>
		</li>

		<li class="divider-vertical"></li>
		@if(Admin::check())
		<li class="dropdown">
			<a 	tabindex="-1" 
				href="#" 
				class="dropdown-toggle icon" 
				data-toggle="dropdown"
			>
				<i class="icon-fixed-width icon-user icon-2x"></i>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li class="nav-header striked">
					@if(Admin::check()) 
						<hr>
						<span>{{ Session::get('admin.login') }}</span>
					@endif
				</li>
				<li>
					<a 	tabindex="-1" 
						id="go_to_admin_home" 
						href="{{ URL::to('admin') }}"
					>
						<i class="icon-fixed-width icon-lemon"></i> {{ __('content.home_word') }}
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a tabindex="-1" href="/">
						<i class="icon-fixed-width icon-eye-open"></i> {{ __('content.view_site_word') }}
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a 
						tabindex="-1"
						id="go_to_logout"
						href="{{ action('admin.home@logout') }}"
						data-title="Indira CMS · Admin"
					>
						<i class="icon-fixed-width icon-off red"></i> {{ __('content.logout_word') }}
					</a>
				</li>
			</ul>
		</li>

		<li class="divider-vertical"></li>

		<li class="dropdown">
			<a 	tabindex="-1" 
				href="#" 
				class="dropdown-toggle icon" 
				data-toggle="dropdown"
			>
				<i class="icon-fixed-width icon-list-alt icon-2x"></i>
			</a>
			<ul class="dropdown-menu" role="menu">
				<li class="nav-header striked">
					<hr>
					<span>{{ __('content.content_management') }}</span>
				</li>

				@if(Indira::get('modules.blog.active'))
				<li>
					<a 	tabindex="-1" 
						id="go_to_blog" 
						href="{{ action('admin.blog.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.blog_word')) }}"
					>
						<i class="icon-fixed-width icon-coffee"></i> {{ __('content.blog_word') }}
					</a>
				</li>
				@endif

				@if(Indira::get('modules.pages.active'))
				<li>
					<a 	tabindex="-1" 
						id="go_to_pages" 
						href="{{ action('admin.pages.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.pages_word')) }}"
					>
						<i class="icon-fixed-width icon-file-alt"></i> {{ __('content.pages_word') }}
					</a>
				</li>
				<li class="divider"></li>
				@endif

				@if(Indira::get('modules.posts.active'))
				<li>
					<a 	tabindex="-1" 
						id="go_to_posts" 
						href="{{ action('admin.posts.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.post_word')) }}"
					>
						<i class="icon-fixed-width icon-desktop"></i> {{ __('content.post_word') }}
					</a>
				</li>
				@endif

				@if(Indira::get('modules.sections.active'))
				<li>
					<a 	tabindex="-1" 
						id="go_to_sections" 
						href="{{ action('admin.sections.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.sections_word')) }}"
					>
						<i class="icon-fixed-width icon-reorder"></i> {{ __('content.sections_word') }}
					</a>
				</li>
				<li class="divider"></li>
				@endif

				@if(Indira::get('modules.media.active'))
				<li>
					<a 	tabindex="-1" 
						id="go_to_meida_lib" 
						href="{{ action('admin.media.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.media_lib')) }}"
					>
						<i class="icon-fixed-width icon-picture"></i> {{ __('content.media_lib') }}
					</a>
				</li>
				@endif

				@if(Indira::get('modules.qrcode.active'))
				<li>
					<a 	tabindex="-1" 
						id="go_to_qrcode_generator" 
						href="{{ action('admin.qrcode.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.qrcode_generator')) }}"
					>
						<i class="icon-fixed-width icon-qrcode"></i> {{ __('content.qrcode_generator') }}
					</a>
				</li>
				@endif

			</ul>
		</li>

		<li class="divider-vertical"></li>

		<li class="dropdown">
			<a 	tabindex="-1" 
				href="#" 
				class="dropdown-toggle icon" 
				data-toggle="dropdown"
				role="button"
				id="settings_menu"
			>
				<i class="icon-fixed-width icon-wrench icon-2x"></i>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="settings_menu">
				<li class="nav-header striked">
					<hr>
					<span>{{ __('content.settings_word') }}</span>
				</li>

				@if(Indira::get('modules.settings.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_main_settings" 
						href="{{ action('admin.settings.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.main_settings')) }}"
					>
						<i class="icon-fixed-width icon-cog"></i> {{ __('content.main_settings') }}
					</a>
				</li>
				@endif

				<li>
					<a 	tabindex="-1"
						id="go_to_template_settings" 
						href="{{ action('admin.template_settings.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.template_settings')) }}"
					>
						<i class="icon-fixed-width icon-columns"></i> {{ __('content.template_settings') }}
					</a>
				</li>
				<li>
					<a 	tabindex="-1"
						id="go_to_modules" 
						href="{{ action('admin.modules.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.modules_word')) }}"
					>
						<i class="icon-fixed-width icon-suitcase"></i> {{ __('content.modules_word') }}
					</a>
				</li>
				<li class="nav-header striked">
					<hr>
					<span>{{ __('content.admin_tools') }}</span>
				</li>

				@if(Indira::get('modules.admins.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_admins" 
						href="{{ action('admin.admins.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.admins_word')) }}"
					>
						<i class="icon-fixed-width icon-group"></i> {{ __('content.admins_word') }}
					</a>
				</li>
				@endif

				@if(Indira::get('modules.users.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_users" 
						href="{{ action('admin.users.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word')) }}"
					>
						<i class="icon-fixed-width icon-user"></i> {{ __('content.users_word') }}
					</a>
				</li>
				@endif

				@if(Indira::get('modules.newsletter.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_newsletter" 
						href="{{ action('admin.newsletter.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.newsletter')) }}"
					>
						<i class="icon-fixed-width icon-envelope-alt"></i> {{ __('content.newsletter') }}
					</a>
				</li>
				@endif

				<li class="divider"></li>


				@if(Indira::get('modules.access_control.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_access" 
						href="{{ action('admin.access.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.access_levels')) }}"
					>
						<i class="icon-fixed-width icon-key"></i> {{ __('content.access_levels') }}
					</a>
				</li>
				@endif

				@if(Indira::get('modules.languages.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_languages" 
						href="{{ action('admin.languages.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.locales')) }}"
					>
						<i class="icon-fixed-width icon-globe"></i> {{ __('content.locales') }}
					</a>
				</li>
				@endif


				<li class="nav-header striked">
					<hr>
					<span>{{ __('content.admin_pro_tools') }}</span>
				</li>

				<li>
					<a 	tabindex="-1"
						id="go_to_dev_mode" 
						href="{{ action('admin.development.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.development')) }}"
					>
						<i class="icon-fixed-width icon-code"></i> {{ __('content.development') }}
							@if(Config::get('indira.under_development') == 'true')
								<span class="label label-important">{{ __('forms.on_word') }}</span>
							@else
								<span class="label">{{ __('forms.off_word') }}</span>
							@endif
					</a>
				</li>

				@if(Indira::get('modules.cli.active'))
				<li>
					<a 	tabindex="-1"
						id="go_to_cli" 
						href="{{ action('admin.cli.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.cli')) }}"
					>
						<i class="icon-fixed-width icon-terminal"></i> {{ __('content.cli') }}
					</a>
				</li>
				@endif

				<li>
					<a 	tabindex="-1"
						id="go_to_filedb" 
						href="{{ action('admin.filedb.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb')) }}"
					>
						<i class="icon-fixed-width icon-hdd"></i> {{ __('filedb.filedb') }}
					</a>
				</li>
				<li>
					<a 	tabindex="-1"
						id="go_to_schema" 
						href="{{ action('admin.schema.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.sql_migrations')) }}"
					>
						<i class="icon-fixed-width icon-archive"></i> {{ __('content.sql_migrations') }}
					</a>
				</li>
				<li>
					<a 	tabindex="-1"
						id="go_to_cache_control" 
						href="{{ action('admin.cache.home@index') }}" 
						data-title="{{ Utilites::build_title(array('content.application_name', 'content.cache_control')) }}"
					>
						<i class="icon-fixed-width icon-rocket"></i> {{ __('content.cache_control') }}
					</a>
				</li>
			</ul>
		</li>
		<li class="divider-vertical"></li>
		@endif
	</ul>
	@include('admin.assets.lang')
</div>
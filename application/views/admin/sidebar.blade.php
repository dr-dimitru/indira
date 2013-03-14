<div class="navbar navbar-inverse">
  <div class="navbar-inner">
  	<div class="super_logo" id="super_logo" style="color: rgb(255, 194, 0);">
  		<i class="icon-lemon icon-2x"></i>
  	</div>
  	@if(Admin::check())
	<ul class="nav" id="admin_nav">
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<i class="icon-user"></i> 
				@if(Admin::check()) 
					{{ Session::get('admin.login') }}
				@endif
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a class="" href="/admin">
						<i class="icon-lemon"></i> {{ Lang::line('content.home_word')->get(Session::get('lang')) }}
					</a>
				</li>
				@if(Admin::check() == 777)
				<li class="dropdown-submenu">
			    	<a tabindex="-1" href="#">
			    		<i class="icon-cogs"></i> {{ Lang::line('content.admin_tools')->get(Session::get('lang')) }}
			    	</a>
				    <ul class="dropdown-menu">
				      	<li>
							<a 	id="go_to_admins" 
								href="{{ URL::to('admin/admins') }}" 
								data-title="Indira CMS · {{ Lang::line('content.admins_word')->get(Session::get('lang')) }}"
							>
								<i class="icon-group"></i> {{ Lang::line('content.admins_word')->get(Session::get('lang')) }}
							</a>
						</li>
						<li>
							<a 	id="go_to_admins" 
								href="{{ URL::to('admin/db') }}" 
								data-title="Indira CMS · {{ Lang::line('content.db_management')->get(Session::get('lang')) }}"
							>
								<i class="icon-hdd"></i> {{ Lang::line('content.db_management')->get(Session::get('lang')) }}
							</a>
						</li>
				    </ul>
			  	</li>
				@endif
				<li class="divider"></li>
				<li>
					<a class="" href="/">
						<i class="icon-home"></i> {{ Lang::line('content.main_page_word')->get(Session::get('lang')) }}
					</a>
				</li>
				<li class="divider"></li>
				<li>
					<a class="" href="/admin/logout">
						<i class="icon-off"></i> {{ Lang::line('content.logout_word')->get(Session::get('lang')) }}
					</a>
				</li>
			</ul>
		</li>
		<li class="divider-vertical"></li>
		<li>
			<a 	id="go_to_blog" 
				href="{{ URL::to('admin/blog_list') }}" 
				data-title="Indira CMS · {{ Lang::line('content.blog_word')->get(Session::get('lang')) }}"
			>
				{{ Lang::line('content.blog_word')->get(Session::get('lang')) }}
			</a>
		</li>
		<li class="dropdown">
	    	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				{{ Lang::line('content.content_management')->get(Session::get('lang')) }}
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a 	id="go_to_posts" 
						href="{{ URL::to('admin/posts_list') }}" 
						data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }}"
					>
						{{ Lang::line('content.post_word')->get(Session::get('lang')) }}
					</a>
				</li>
				<li>
					<a 	id="go_to_sections" 
						href="{{ URL::to('admin/sections') }}" 
						data-title="Indira CMS · {{ Lang::line('content.sections_word')->get(Session::get('lang')) }}"
					>
						{{ Lang::line('content.sections_word')->get(Session::get('lang')) }}
					</a>
				</li>
			</ul>
		</li>
	</ul>
	@endif
	@include('admin.assets.lang')
  </div>
</div>
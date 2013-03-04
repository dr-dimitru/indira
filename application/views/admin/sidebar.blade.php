<div class="navbar navbar-inverse">
  <div class="navbar-inner">
  	<div class="super_logo" id="super_logo" style="color: rgb(255, 194, 0);">
  		<i class="icon-lemon icon-2x"></i>
  	</div>
  	@if(Admin::check())
	<ul class="nav" id="admin_nav">
		<li>
			<a href="#" class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#">
				<i class="icon-user"></i> 
				<? if(Admin::check()){ 
					echo Session::get('admin.login'); 
				} ?>
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				<li><a class="" href="/admin"><i class="icon-user"></i> {{ Lang::line('content.home_word')->get(Session::get('lang')) }}</a></li>
				<li><a class="" href="/admin/logout"><i class="icon-off"></i> {{ Lang::line('content.logout_word')->get(Session::get('lang')) }}</a></li>
				<li class="divider"></li>
				<li><a class="" href="/"><i class="icon-home"></i> {{ Lang::line('content.main_page_word')->get(Session::get('lang')) }}</a></li>
			</ul>
		</li>
		<li class="divider-vertical"></li>
		<li>
			<a id="go_to_posts" href="#!/posts_list" onclick="shower('../admin/posts_list', 'go_to_posts', 'work_area', false, true)">{{ Lang::line('content.post_word')->get(Session::get('lang')) }}</a></li>
		</li>
		<li>
			<a id="go_to_sections" href="#!/sections" onclick="shower('../admin/sections', 'go_to_sections', 'work_area', false, true)">{{ Lang::line('content.sections_word')->get(Session::get('lang')) }}</a></li>
		</li>
		<li>
			<a id="go_to_admins" href="#!/admins" onclick="shower('../admin/admins', 'go_to_admins', 'work_area', false, true)">{{ Lang::line('content.admins_word')->get(Session::get('lang')) }}</a></li>
		</li>
		<li>
			<a id="go_to_blog" href="#!/blog_list" onclick="shower('../admin/blog_list', 'go_to_blog', 'work_area', false, true)">{{ Lang::line('content.blog_word')->get(Session::get('lang')) }}</a></li>
		</li>
	</ul>
	@endif
	@include('admin.assets.lang')
  </div>
</div>
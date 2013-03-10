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
			<a id="go_to_posts" href="{{ URL::to('admin/posts_list') }}" data-title="Indira CMS · {{ Lang::line('content.post_word')->get(Session::get('lang')) }}">{{ Lang::line('content.post_word')->get(Session::get('lang')) }}</a></li>
		</li>
		<li>
			<a id="go_to_sections" href="{{ URL::to('admin/sections') }}" data-title="Indira CMS · {{ Lang::line('content.sections_word')->get(Session::get('lang')) }}">{{ Lang::line('content.sections_word')->get(Session::get('lang')) }}</a></li>
		</li>
		<li>
			<a id="go_to_blog" href="{{ URL::to('admin/blog_list') }}" data-title="Indira CMS · {{ Lang::line('content.blog_word')->get(Session::get('lang')) }}">{{ Lang::line('content.blog_word')->get(Session::get('lang')) }}</a></li>
		</li>
		<li class="divider-vertical"></li>
		<li>
			<a id="go_to_admins" href="{{ URL::to('admin/admins') }}" data-title="Indira CMS · {{ Lang::line('content.admins_word')->get(Session::get('lang')) }}">{{ Lang::line('content.admins_word')->get(Session::get('lang')) }}</a></li>
		</li>
	</ul>
	@endif
	@include('admin.assets.lang')
  </div>
</div>
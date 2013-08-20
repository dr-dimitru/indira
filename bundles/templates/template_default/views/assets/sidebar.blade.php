<nav id="main_sidebar" class="sidebar closed">
	<div class="sidebar-container">
		
		<menu class="sidebar-menu">

			@if(Indira::get('modules.users.active'))
				<div id="user_form"  style="display:none">
					@if(!Session::get('user.id'))

						@include('templates::user.login')
						@include('templates::user.sign')
						@include('templates::user.iforgot')

					@else

						@include('templates::user.info')
						@include('templates::user.edit')

					@endif
				</div>
			@endif

			<hr>

			<div class="hot-links">

				@if(Indira::get('modules.users.active'))
					<a type="button" style="cursor:pointer" onclick="$('#user_form').slideToggle();">
						<i class="icon-fixed-width icon-2x icon-user"></i>
					</a>
				@endif

				@if(Admin::check())
				<a type="button" style="cursor:pointer" href="{{ URL::to('admin') }}">
					<i class="icon-fixed-width icon-2x icon-lemon"></i>
				</a>
				@endif
				
				@include('templates::assets.language_selector')

			</div>
		</menu>

	@if(Indira::get('modules.sections.active') && Indira::get('modules.posts.active'))
		@if($sections)
			@if(TMPLT_TYPE == 'mobile')
				<div id="sidebar_sections">
			@endif
			@foreach($sections as $section)
				@if(isset($posts[$section->id]))
				
				<section>
					<div class="header">
						<h5>
							<a 	id="go_to_section_{{ $section->id }}"
								href="{{ URL::to_route('sections', array(($section->link) ? $section->link : $section->id)) }}"
								data-title="{{ Utilites::build_title(array(Indira::get('name'), 'templates::content.section_word', $section->title)) }}"
							>
								{{ $section->title }}
							</a>
						</h5> 
						<span id="sidebar_section_section_name" class="pull-right arrow">
							<i class="icon-angle-up icon-large"></i>
						</span>
					</div>

					@if(isset($posts[$section->id]))
						@foreach($posts[$section->id] as $post)

						<div id="ajax_go_to_post_{{ $post->id }}"
							class="post-body"
							data-link="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
							data-title="{{ Utilites::build_title(array(Indira::get('name'), $section->title, $post->title)) }}"
						>
							<h6 class="post-header">
								<a 	id="go_to_post_{{ $post->id }}"
									href="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
									data-title="{{ Utilites::build_title(array(Indira::get('name'), $section->title, $post->title)) }}"
								>
									{{ $post->title }}
								</a>
							</h6>

							<p class="post-text-preview">
								{{ ($post->short) ? $post->short : ucfirst(strtolower(preg_replace("/\s+/", " ",substr(strip_tags($post->text), 0, 200)))) }}
							</p>
						</div>

						@endforeach
					@else
						<div class="post-body no-posts">
							<p>{{ __('templates::content.no_posts_word') }}</p>
						</div>
					@endif

				</section>

				@endif
			@endforeach
			@if(TMPLT_TYPE == 'mobile')
				</div>
			@endif
		@endif
	@endif
	</div>
</nav>
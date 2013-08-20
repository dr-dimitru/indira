@if(Indira::get('modules.sections.active') && Indira::get('modules.posts.active') && $posts && $sections)

	@include('templates::posts.listing')

@endif

@if(Indira::get('modules.blog.active') && $blogs)
	
	@include('templates::blog.listing')

@endif
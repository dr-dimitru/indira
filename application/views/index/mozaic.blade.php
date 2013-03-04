<? $sections = Sections::where('lang', '=', Session::get('lang'))->get(); ?>

@if($sections)
	@foreach ($sections as $section)

	<div class="row">
		<div class="section" id="{{ $section->id }}">
			<div class="page-header">
				<h1>{{ $section->title }}</h1>
			</div>
			
			<? $posts = Posts::where('section', '=', array($section->id))->get(); ?>
			
			@if($posts)
				@foreach ($posts as $post)
				    @if($post->access <= Session::get('user.access_level'))
					<div class="span4">
						@include('partials.postpreview')
					</div>
					@endif
				@endforeach
			@else
				<h6>No posts here yet</h6>
			@endif
			
		</div>
	</div>
		
	@endforeach
@else
<div class="well well-large" style="text-align: center">
	<h6>No Sections</h6><br>
	<h6>Please create Sections & Posts at first</h6>
</div>
@endif
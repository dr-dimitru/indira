<section class="black-background">
	<header class="section-header">
		<div>
			<h1>{{ __('templates::content.blog_word') }}</h1>
			<small>{{ __('templates::content.last_blog_posts', array('num' => 10)) }}</small>
		</div>
	</header>
</section>

<hr class="no-vertical-margin">

{{ (isset($pagination)) ? $pagination : null }}

<section class="post-listing" itemscope itemtype="http://schema.org/Blog">

	<?php $i = 0; $closed = false;?>

	@foreach($blogs as $blog)
		<?php $i++; ?>

		@if($i == 1)

			<div class="row-fluid">
			<?php $closed = false; ?>

		@endif


		@include('templates::blog.article')

		@if($i >= 2)

			</div>
			<hr style="margin-top: 0px; margin-bottom: 10px">
			<?php $i = 0; ?>
			<?php $closed = true; ?>

		@endif
	

	@endforeach

	@if(!$closed)
		</div>
	@endif

	{{ (isset($pagination)) ? $pagination : null }}

</section>
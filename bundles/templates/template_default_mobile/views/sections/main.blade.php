<header class="section-header">
			
	<h1 itemprop="name">{{ $section->title }}</h1>

</header>

<hr class="no-vertical-margin">

<section class="post-listing black-background">
	<main itemprop="articleBody">

		<?php $i = 0; $closed = false;?>

		@foreach($posts as $post)

			<?php $i++; ?>

			@if($i == 1)

				<div class="row-fluid">
				<?php $closed = false; ?>

			@endif

				@include('templates::posts.article')

			@if($i >= 2)

				</div>
				<?php $i = 0; ?>
				<?php $closed = true; ?>

			@endif

		@endforeach

		@if(!$closed)
			</div>
		@endif

	</main>
</section>
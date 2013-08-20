<section>
	<header class="section-header">
		<h1>{{ Indira::get('name') }}</h1>
		<small>{{ __('templates::content.contents_word') }}</small>
	</header>
</section>

<hr class="no-vertical-margin">

<?php $i = 0; $count = 0; $closed = false;?>
@foreach($sections as $section)

	<?php ++$count; ?>

	@if(isset($posts[$section->id]))

		<?php $i++; ?>

		@if($i == 1)
			<section class="black-background">
				<div class="row posts-listing">
					<?php $closed = false; ?>
		@endif
					<div class="col-xs-12 col-md-4">
						<article class="posts-listing well" itemscope itemtype="http://schema.org/Article">
							<h4 itemptop="articleSection" itemprop="name">
								<a 	id="go_to_section_{{ $section->id }}"
									href="{{ URL::to_route('sections', array(($section->link) ? $section->link : $section->id)) }}"
									data-title="{{ Utilites::build_title(array(Indira::get('name'), $section->title)) }}"
									itemprop="url"
								>
									{{ $section->title }}
								</a>
							</h4>
							
							<hr>

							<div itemptop="articleBody">
								<ul class="list-unstyled">
								@foreach($posts[$section->id] as $post)

									@if($post->section == $section->id)
									
									<li>
										<a 	id="go_to_post_{{ $post->id }}"
											href="{{ URL::to_route('posts', array(($post->link) ? $post->link : $post->id)) }}"
											data-title="{{ Utilites::build_title(array(Indira::get('name'), $section->title, $post->title)) }}"
										>
											{{ $post->title }}
										</a>
									</li>

									@endif

								@endforeach
								</ul>
							</div>
						</article>
					</div>

		@if($i >= 3 || $count == $section->qty)
				</div>

				<hr class="no-vertical-margin">

			</section>

			<?php $closed = true; ?>

		@endif

		<?php
			
			if($i >= 3){

				$i = 0;
			}
		?>

	@endif

	@if(!$closed && $count == $section->qty)
				</div>
			</section>
	@endif

@endforeach
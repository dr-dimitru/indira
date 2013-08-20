@if($media)
	@foreach($media as $image)

		<div id="holder_{{ $image->id }}" class="preview">
			<span class="imageHolder">

				<img class="lazy" style="max-height: 150px; height: 150px;" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-original="{{ asset($image->formats->gallery_thumbnail) }}" alt="{{ e($image->name) }}" />

				<?php $h = e('"holder"'); ?>

				<span class="uploaded" onclick="$('[id^={{ $h }}]').removeClass('done'); $('#holder_{{ $image->id }}').addClass('done'); $('#redactor_file_link').val('{{ asset($image->original) }}')"></span>

			</span>
		</div>

	@endforeach

	{{ HTML::script('cms/scripts/vendor/jquery.lazyload.min.js') }}
	<script type="text/javascript">
		$("img.lazy").lazyload({
			effect: "fadeIn",
			container: $("#gallery.redactor_js")
		});
	</script>

@else
	<center>
		<h6>{{ __('media.no_images') }}</h6>
	</center>
@endif
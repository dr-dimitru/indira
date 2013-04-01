@if($media)
	@foreach($media as $image)
	<div id="holder_{{ $image->id }}" class="preview">
		<span class="imageHolder">
			<img src="{{ $image->url }}" />
			<?php $h = htmlspecialchars('"holder"'); ?>
			<span class="uploaded" onclick="$('[id^={{ $h }}]').removeClass('done'); $('#holder_{{ $image->id }}').addClass('done'); $('#redactor_file_link').val('{{ $image->url }}')"></span>
		</span>
	</div>
	@endforeach
@else
	<center>
		<h6>No Images Uploaded Yet :(</h6>
	</center>
@endif
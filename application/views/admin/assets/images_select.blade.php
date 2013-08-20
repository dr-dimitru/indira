<div class="control-group well well-small">

    <label class="control-label" for="%3$s">
    	<h6>
    		%1$s

	    	<span class="imageHolder">
				<i 	class="icon-plus-sign icon-large" 
					style="cursor:pointer"
					data-link="/admin/media/home/select",
	                onclick="$('#main_modal').modal('show')",
	                data-prevent-follow="true",
	                data-out="main_modal",
	                data-load="main_modal",
	                data-post="{{ e('{"page": "admin.media.selector", "selected": $(\'#'.$column.'\').val(), "column":"'.$column.'"}') }}",
	                data-ajaxify="true"
				></i>
			</span>
		</h6>
	</label>

    %2$s

	<div id="gallery" class="controls" style="min-height:380px">

		<div id="gallery_content_{{ $column }}">
    	@if($selected_images)
    		@foreach($selected_images as $id)

    			@if(isset($images[$id]))

	    			<div id="selected_holder_{{ $id }}" class="preview" style="max-width: 110px;height: 110px;">
						<span class="imageHolder">

							<img style="max-height: 110px; height: 110px;" src="{{ asset($images[$id]->formats->gallery_thumbnail) }}" alt="{{ e($images[$id]->name) }}" />

						</span>
					</div>

				@endif

    		@endforeach
    	@endif
   		</div>

	</div>

</div>
<hr style="margin: 10px -10px">
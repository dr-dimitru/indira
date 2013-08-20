<div class="modal-header">
			
	<input 	type="file" 
			class="btn btn-mini" 
			id="upload_input"
			name="pic"
			onchange="$('#upload_button').trigger('click')"
	/>

	<button type="button" 
			class="btn btn-inverse" 
			id="upload_button"
			data-ajaxify="true"
			data-link="{{ action('admin.media.action@index') }}?return_holder=true"
			data-out="gallery.modal-body"
			data-append="prepend"
			data-file-field="upload_input"
			data-form-name="pic"
			data-prevent-follow="true"
			style="display:none"
	>
		{{ __('content.upload_word') }}
	</button>

	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
</div>
<div id="gallery" style="max-height:500px;padding: 0px;" class="modal-body scroll scroll-y">

	@if($media)
		@foreach($media as $image)

			<div id="holder_{{ $image->id }}" class="preview {{ (in_array($image->id, $selected)) ? 'done' : null }}">
				<span class="imageHolder">

					<img class="lazy" style="max-height: 150px; height: 150px;" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-original="{{ asset($image->formats->gallery_thumbnail) }}" alt="{{ e($image->name) }}" />

					<span class="uploaded" onclick="addimage('{{ $image->id }}', '{{ asset($image->formats->gallery_thumbnail) }}')"></span>

				</span>
			</div>

		@endforeach

		{{ HTML::script('cms/scripts/vendor/jquery.lazyload.min.js') }}
		<script type="text/javascript">
			$("img.lazy").lazyload({
				effect: "fadeIn",
				container: $("#gallery.modal-body")
			});
		</script>

		<script type="text/javascript">
			function arrayUnique(array) {
			    var a = array.concat();
			    for(var i=0; i<a.length; ++i) {
			        for(var j=i+1; j<a.length; ++j) {
			            if(a[i] === a[j])
			                a.splice(j--, 1);
			        }
			    }

			    return a;
			};

			function cleanArray(actual){
			  var newArray = new Array();
			  for(var i = 0; i<actual.length; i++){
			      if (actual[i]){
			        newArray.push(actual[i]);
			    }
			  }
			  return newArray;
			}

			function addimage(id, url){

				var ids_string = $("#{{ $column }}").val();
				var ids_array = ids_string.split(',');

				if($("#{{ $column }}").attr("data-select") == 'single'){

					$('[id^="holder_"]').removeClass("done");
					$("#holder_" + id).addClass("done");
					$("#{{ $column }}").val(id);
					$("#gallery_content_{{ $column }}").children().remove();
					$('#gallery_content_{{ $column }}').append('<div id="selected_holder_' + id +'" class="preview" style="max-height: 110px; height: 110px;"><span class="imageHolder"><img style="max-height: 110px; height: 110px;" src="'+ url +'" /></span></div>');

				}else{

					if($("#holder_" + id).hasClass("done")){

						$("#holder_" + id).removeClass("done");
						$("#gallery_content_{{ $column }}").children("#selected_holder_" + id).remove();
						ids_array.splice( $.inArray(id, ids_array), 1 );
					
					}else{

						$("#holder_" + id).addClass("done");
						$('#gallery_content_{{ $column }}').append('<div id="selected_holder_' + id +'" class="preview" style="max-height: 110px; height: 110px;"><span class="imageHolder"><img style="max-height: 110px; height: 110px;" src="'+ url +'" /></span></div>');
						ids_array.push(id);

					}


					ids_array = arrayUnique(cleanArray(ids_array));

					$("#{{ $column }}").val(ids_array.join(','));
				}
			}
		</script>

	@else
		<center>
			<h6>{{ __('media.no_images') }}</h6>
		</center>
	@endif

</div>
<div class="modal-footer">
</div>
@layout('admin.media.template')

<h3>
	<i class="icon-picture"></i> {{ __('content.media_lib') }}
</h3>

<hr>

@section('media')

<div class="row-fluid">
	<div class="span12">
		<div id="dropbox" class="well">
			<div id="message" class="alert alert-info">
				<div class="row-fluid">
					<div class="span6">
						{{ __('media.drop_box_message') }}
					</div>
					<div class="span6">
						<h5>{{ __('media.upload_via_button') }}</h5>
						<form method="post" id="uploader_form" action="{{ action('admin.media.action@index') }}?viabutton=true" enctype="multipart/form-data">
							
							<input 	type="file" 
									name="pic" 
									class="btn btn-mini" 
									onchange="$('#uploader_form').submit();" 
							/>

						</form>
					</div>
				</div>
			</div>
			<div>
				<i class="icon-cloud-upload icon-4x" style="position: absolute;margin-left: 43%;"></i>
			</div>
		</div>
		<div class="form-actions" style="padding:20px; bottom:10px">
			<strong>{{ __('forms.selected_action_word') }}: </strong>
			<button  
				id="ajax_delete_many"
				data-link="{{ action('admin.media.action@delete_many') }}" 
				data-post="{{ e('{"id": encodeURI($(\'#select_delete_many\').attr(\'class\')), "delete": "delete"}') }}" 
				data-message="{{ e(__('forms.delete_warning', array('item' => e(__('forms.delete_many'))))) }}" 
				data-out-popup="{{ e(Utilites::alert(__('forms.deleted_many'), "success")) }}"
				data-load="super_logo"
				data-prevent-follow="true" 
				class="btn btn-small btn-danger" 
				disabled
			>
				<i class="icon-trash icon-large"></i> {{ __('forms.delete_word') }}
			</button>
			<input class="" id="select_delete_many" type="hidden" style="display:none" value=""/>
		</div>
	</div>
</div>

@if($media)
	<?php $i = 1; ?>
	@foreach($media as $image)
		@if($i == 1)
			<div class="row-fluid">
				<div class="span12">
					<ul class="thumbnails">
		@endif
						<li class="span2" id="img_item_{{ $image->id }}">
							<div class="thumbnail">
								<a id="go_to_full_{{ $image->id }}" href="{{ action('admin.media.home@view', array($image->id)) }}">
									<img class="lazy span12" style="max-height: 190px;" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-original="{{ asset($image->formats->gallery_thumbnail) }}" alt="{{ e($image->name) }}" />
								</a>

								<h6 class="ellipsis" style="max-width:180px;clear:both;padding-top:6px;">{{ e($image->name) }}</h6>
								<input type="url" class="span12 input" value="{{ asset($image->original) }}" />
								<p style="text-align: center">
									<i 
								        style="cursor: pointer"
								        onclick="$('#ajax_delete_many').attr('disabled', false);if($('#select_{{ $image->id }}').val() !== '1'){$('#select_{{ $image->id }}').val('1');$(this).removeClass('icon-check-empty').addClass('icon-check');$('#select_delete_many').toggleClass('{{ $image->id }}');$('#select_delete_many').val($('#select_delete_many').attr('class'));}else{$('#select_{{ $image->id }}').val('0');$(this).removeClass('icon-check').addClass('icon-check-empty');$('#select_delete_many').toggleClass('{{ $image->id }}');$('#select_delete_many').val($('#select_delete_many').attr('class'));}" 
								        id="select_icon_{{ $image->id }}" 
								        class="icon-check-empty icon-large"> 
								    </i>
								    <input  
							            id="select_{{ $image->id }}" 
							            type="hidden"
							            style="display:none" 
							            value="0" 
							            onchange="if(this.value !== '1'){this.value = '1'; }else{this.value = '0'}"
							        />

									<button  
										id="ajax_delete_{{ $image->id }}"
										class="btn btn-mini" 
										data-link="{{ action('admin.media.action@delete') }}" 
										data-post="{{ e('{"id": '.$image->id.', "delete": "delete"}') }}" 
										data-restore="true" 
										data-message="{{ e(__('forms.delete_warning', array('item' => e($image->name)))) }}" 
										data-out="img_item_{{ $image->id }}" 
										data-remove="img_item_{{ $image->id }}" 
										data-out-popup="true"
										data-load="super_logo"
										data-prevent-follow="true" 
									>
										<i class="icon-trash icon-large red"></i>
									</button>

									<button  
										onclick="window.open('{{ action('admin.media.home@download', array($image->id)) }}','_newtab');"
										class="btn btn-mini" 
									>
										<i class="icon-download-alt icon-large"></i>
									</button>
								</p>
							</a>
						</li>
		@if($i == 6)
					</ul>
				</div>
			</div>
		@endif
	<?php 
		if($i >= 6){
			$i = 1;
		}else{
			$i++;
		}
	?>
	@endforeach
	
@else
	<center>
		<h6>{{ __('media.no_images') }}</h6>
	</center>
@endif

@endsection
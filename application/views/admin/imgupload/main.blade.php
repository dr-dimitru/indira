@layout('admin.imgupload.template')

<h3>
	{{ Lang::line('content.media_lib')->get(Session::get('lang')) }}
	<small>
		<button 
			id="back"
			onclick="History.back()"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-chevron-left"></i> {{ Lang::line('content.go_back')->get(Session::get('lang')) }}
		</button>
	</small>
</h3>

<hr>

<div class="row-fluid">
	<div class="span12">
		<div id="dropbox" class="well">
			<div id="message" class="alert alert-info">
				<div class="row-fluid">
					<div class="span6">
						{{ Lang::line('content.drop_box_message')->get(Session::get('lang')) }}
					</div>
					<div class="span6">
						<h5>Or upload via button:</h5>
						<form method="post" id="uploader_form" action="../../../admin/imgupload?viabutton=true" enctype="multipart/form-data">
							
							<input 	type="file" 
									name="pic" 
									class="btn btn-mini" 
									style="max-width:80px" 
									onchange="$('#uploader_form').submit();" 
							/>

						</form>
					</div>
				</div>
			</div>
			<center>
				<i class="icon-cloud-upload icon-4x" style="position: absolute;"></i>
			</center>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<ul class="thumbnails">
			@if($media)
				@foreach($media as $image)
				<li class="span2">
					<div class="thumbnail">
						<img style="max-height: 180px; height: 180px;" src="{{ $image->url }}" alt="{{ htmlspecialchars($image->name) }}">
						<h6 class="ellipsis" style="max-width: 180px">{{ htmlspecialchars($image->name) }}</h6>
						<input type="url" class="span12 input" value="{{ $image->url }}" />
						<p>
							<?
								$json_delete = '{"id": '.$image->id.', "delete": "delete"}';
							?>
							<a  id="go_to_delete_{{ $image->id }}"
								href="{{ URL::to('admin/imgupload/delete') }}" 
								data-post="{{ htmlspecialchars($json_delete) }}" 
								data-restore="true" 
								data-message="{{ sprintf(Lang::line('content.delete_warning')->get(Session::get('lang')), addslashes(htmlspecialchars($image->name)) ) }}" 
								data-out="work_area" 
								data-load="super_logo"
								data-prevent-follow="true" 
								class="btn btn-danger" 
								>
									<i class="icon-trash icon-large"></i> {{ Lang::line('content.delete_word')->get(Session::get('lang')) }}
							</a>
						</p>
					</div>
				</li>
				@endforeach
			@else
				<center>
					<h6>No Images Uploaded Yet :(</h6>
				</center>
			@endif
		</ul>
	</div>
</div>
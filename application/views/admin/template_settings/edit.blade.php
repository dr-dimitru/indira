@layout('admin.template_settings.template')

<h3>
	<i class="icon-columns"></i> {{ __('content.template_settings') }} · {{ ucfirst($type) }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.template_settings.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.template_settings')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@section('template_settings')

	@if($type == 'icon')

		<h3><small>{{ __('template_settings.icon') }}</small></h3>

		<div class="row-fluid">
			<div class="span4">

				<strong>{{ __('template_settings.upload_button') }}</strong>
				<form method="post" id="upload_icons_form" action="{{ action('admin.template_settings.action@upload_icons') }}" enctype="multipart/form-data">
							
					<input 	type="file" 
							name="pic" 
							class="btn btn-small" 
							onchange="$('#upload_icons_form').submit();" 
					/>

				</form>

				<hr>

				<strong>{{ __('template_settings.icons_types_annotation') }}:</strong>
				<ul>
					@foreach($setting as $row)

						<li>
							{{ $row->name }}  <i class="icon-resize-full icon-li"></i> <small>{{ $row->additions }}</small>
						</li>

					@endforeach
				</ul>

			</div>
			<div class="span8">
				<div class="well well-small">
					<ul class="thumbnails">
						@foreach($setting as $row)
							
							<li>
								<div style="max-width: 200px" class="thumbnail">
									<img src="{{ ($row->value) ? asset($row->value) : 'http://placehold.it/'.$row->additions }}">
								</div>
							</li>

						@endforeach
					</ul>
				</div>
			</div>
		</div>

	@elseif($type == 'shortcut icon')

		<h3><small>{{ __('template_settings.favicon') }}</small></h3>

		<div class="row-fluid">
			<div class="span4">

				<strong>{{ __('template_settings.upload_button') }}</strong>
				<form method="post" id="upload_favicon_form" action="{{ action('admin.template_settings.action@upload_favicon') }}" enctype="multipart/form-data">
							
					<input 	type="file" 
							name="pic" 
							class="btn btn-small" 
							onchange="$('#upload_favicon_form').submit();" 
					/>

				</form>

				<hr>

				<strong>{{ __('template_settings.favicons_types_annotation') }}:</strong>
				<ul>
					@foreach($setting as $row)

						<li>
							{{ $row->type }} ({{ $row->name }})  <i class="icon-resize-full icon-li"></i> <small>{{ $row->additions }}</small>
						</li>

					@endforeach
				</ul>

			</div>
			<div class="span8">
				<div class="well well-small">
					<ul class="thumbnails">
						@foreach($setting as $row)
							
							<li>
								<div style="max-width: 200px" class="thumbnail">
									<img src="{{ ($row->value) ? asset($row->value) : 'http://placehold.it/'.$row->additions }}">
								</div>
							</li>

						@endforeach
					</ul>
				</div>
			</div>
		</div>

	@elseif($type == 'apple-touch-startup-image')

		<h3><small>{{ __('template_settings.startup_image') }}</small></h3>

		<div class="row-fluid">
			<div class="span4">

				<strong>{{ __('template_settings.upload_button') }}</strong>
				<form method="post" id="upload_startup_image_form" action="{{ action('admin.template_settings.action@upload_startup_image') }}" enctype="multipart/form-data">
							
					<input 	type="file" 
							name="pic" 
							class="btn btn-small" 
							onchange="$('#upload_startup_image_form').submit();" 
					/>

				</form>

				<hr>

				<strong>{{ __('template_settings.startup_image_annotation') }}:</strong>
				<ul>
					@foreach($setting as $row)

						<li>
							{{ $row->name }}  <i class="icon-resize-full icon-li"></i> <small>{{ $row->additions }}</small>
						</li>

					@endforeach
				</ul>

			</div>
			<div class="span8">
				<div class="well well-small">
					<ul class="thumbnails">
						@foreach($setting as $row)

							<?php list($size, $media_query) = explode(',', $row->additions); ?>
							
							<li>
								<div style="max-width: 200px" class="thumbnail">
									<img src="{{ ($row->value) ? asset($row->value) : 'http://placehold.it/'.$size }}">
								</div>
							</li>

						@endforeach
					</ul>
				</div>
			</div>
		</div>
		
	@else
		<div class="row-fluid">
			<div class="offset3 span6">
				@foreach($setting as $row)
					<div class="control-group">
						<label class="control-label" for="value_of_{{ $row->id }}">
							<h6>{{ $row->type }}: {{ $row->name }}</h6>
						</label>

						<div class="controls input-append">
							<input type="text" class="span11" id="value_of_{{ $row->id }}" value="{{ htmlspecialchars($row->value) }}" />
							
							<button
								id="ajax_save_{{ $row->id }}"
								class="btn"
								data-link="{{ action('admin.template_settings.action@save') }}"
								data-post="{{ e('{ "id": '.$row->id.', "value": encodeURI($(\'#value_of_'.$row->id.'\').val()) }') }}"
								data-out="null"
								data-out-popup="true"
								data-prevent-follow="true"
								title="{{ __('forms.save_word') }}"
							>
								<i class="icon-save green"></i>
							</button>
						</div>
						<small class="help-block">{{ (Lang::has('template_settings.'.$row->type.'_'.$row->name.'_annotation')) ? __('template_settings.'.$row->type.'_'.$row->name.'_annotation') : null }}</small>
					</div>

					<hr>
				@endforeach
			</div>
		</div>
	@endif

@endsection
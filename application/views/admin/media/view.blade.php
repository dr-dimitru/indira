@layout('admin.media.template')

<h3>
	<i class="icon-picture"></i> {{ $image->name }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.media.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.media_lib')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

<div class="row-fluid">
	<div class="span6">
		{{ $img }}
	</div>
	<div class="span6">
		<table class="table table-striped table-bordered table-condensed">
			<tbody>
				<tr>
					<td><strong>{{ __('forms.title_word') }}</strong></td>
					<td class="ellipsis">{{ $image->name }}</td>
				</tr>
				<tr>
					<td><strong>URL</strong></td>
					<td class="ellipsis">{{	asset($image->original) }}</td>
				</tr>
				<tr>
					<td><strong>{{ __('media.size_word') }}</strong></td>
					<td class="ellipsis">{{ get_file_size($size) }}</td>
				</tr>
				<tr>
					<td><strong>{{ __('media.width_word') }}</strong></td>
					<td class="ellipsis">{{ $width }}px</td>
				</tr>
				<tr>
					<td><strong>{{ __('media.height_word') }}</strong></td>
					<td class="ellipsis">{{ $height }}px</td>
				</tr>
				<tr>
					<td><strong>Base 64</strong></td>
					<td class="ellipsis">
						<img width="150" src="data:{{ $mime }};base64,{{ $base64 }}" />
						<h6>{{ __('media.size_word') }}: {{ get_file_size(strlen('data:'.$mime.';base64,'.$base64)) }}</h6>
						<input class="span12" type="text" value="data:{{ $mime }};base64,{{ $base64 }}" />
					</td>
				</tr>
			</tbody>
		</table>

		@foreach($image->formats as $name => &$route)

		<?php list($width, $height) = getimagesize('public/'.$route) ?>

		<table class="table table-striped table-bordered table-condensed">
			<thead>
				<tr>
					<th colspan="2">
						{{ ucfirst($name) }}
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><strong>URL</strong></td>
					<td class="ellipsis">{{ asset($route) }}</td>
				</tr>
				<tr>
					<td></td>
					<td class="ellipsis">{{ HTML::image(asset($route)) }}</td>
				</tr>
				<tr>
					<td><strong>{{ __('media.size_word') }}</strong></td>
					<td class="ellipsis">{{ get_file_size(filesize('public/'.$route)) }}</td>
				</tr>
				<tr>
					<td><strong>{{ __('media.width_word') }}</strong></td>
					<td class="ellipsis">{{ $width }}px</td>
				</tr>
				<tr>
					<td><strong>{{ __('media.height_word') }}</strong></td>
					<td class="ellipsis">{{ $height }}px</td>
				</tr>
			</tbody>
		</table>

		<?php unset($name, $route, $width, $height) ?>
		@endforeach
	</div>
</div>
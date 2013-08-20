@layout('admin.qrcode.template')

<h3>
	<i class="icon-qrcode"></i> {{ __('content.qrcode_generator') }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_new_qrcode"
			class="btn"
			href="{{ action('admin.qrcode.home@new') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.qrcode_generator', 'content.add_new_word')) }}"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>

	<div class="btn-group pull-right">
		<a 
			id="go_to_module_settings"
			class="btn"
			href="{{ action('admin.tools.action@module_settings', array('QRCode')) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.qrcode', 'content.settings_word')) }}"
			title="{{ __('content.settings_word') }}"
		>
			<i class="icon-cog"></i>
		</a>
	</div>
</div>

@section('qrcode')
	
	@if($qrcodes)

		<table class="table table-condensed table-bordered table-hover">
			<thead>
				<tr>
					@if(in_array('id', $listing_columns))
					<th style="width:2%;">
						ID
					</th>
					@endif

					@if(in_array('preview', $listing_columns))
					<th style="width:5%; text-align:center">
						<i class="icon-qrcode"></i>
					</th>
					@endif

					@if(in_array('title', $listing_columns))
					<th>
						{{ __('forms.title_word') }}
					</th>
					@endif

					@if(in_array('data', $listing_columns))
					<th>
						{{ __('forms.data_word') }}
					</th>
					@endif

					@if(in_array('url', $listing_columns))
					<th>
						{{ __('forms.url_word') }}
					</th>
					@endif

					@if(in_array('created_at', $listing_columns))
					<th>
						{{ __('forms.created_at_word') }}
					</th>
					@endif

					@if(in_array('updated_at', $listing_columns))
					<th>
						{{ __('forms.updated_at_word') }}
					</th>
					@endif

					<th style="width: 6%">
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>
			@foreach($qrcodes as $qrcode)

				<tr id="qrcode_row_{{ $qrcode->id }}">
					@if(in_array('id', $listing_columns))
					<td style="vertical-align: middle;">
						<span class="label label-inverse">{{ $qrcode->id }}</span>
					</td>
					@endif

					@if(in_array('preview', $listing_columns))
					<td>
						<img class="lazy" height="50" width="50" style="max-width:50px; max-height:50px" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" data-original="{{ $qrcode->url }}" alt="{{ e($qrcode->title) }}" />
					</td>
					@endif

					@if(in_array('title', $listing_columns))
					<td style="vertical-align:middle">
						<a 	id="go_to_qrcode_{{ $qrcode->id }}" 
							href="{{ action('admin.qrcode.home@view', array($qrcode->id)) }}"
							onclick="$('#main_modal').modal('show')"
							data-prevent-follow="true"
							data-out="main_modal"
							data-load="main_modal"
						>
							{{ $qrcode->title }}
						</a>
					</td>
					@endif

					@if(in_array('data', $listing_columns))
					<td style="vertical-align: middle;">
						<small>{{ $qrcode->data }}</small>
					</td>
					@endif


					@if(in_array('url', $listing_columns))
					<td style="vertical-align: middle;">
						<small>{{ $qrcode->url }}</small>
					</td>
					@endif

					@if(in_array('created_at', $listing_columns))
					<td style="vertical-align: middle;">
						<small>{{ (is_numeric($qrcode->created_at)) ? date('Y-m-d h:i', $qrcode->created_at) : $qrcode->created_at }}</small>
					</td>
					@endif

					@if(in_array('updated_at', $listing_columns))
					<td style="vertical-align: middle;">
						<small>{{ (is_numeric($qrcode->updated_at)) ? date('Y-m-d h:i', $qrcode->updated_at) : $qrcode->updated_at }}</small>
					</td>
					@endif

					<td style="vertical-align:middle">
						<div class="btn-group">

							<a 	id="go_to_btn_qrcode_{{ $qrcode->id }}" 
								class="btn btn-small" 
								href="{{ action('admin.qrcode.home@view', array($qrcode->id)) }}"
								onclick="$('#main_modal').modal('show')"
								data-prevent-follow="true"
								data-out="main_modal"
								data-load="main_modal"
							>
								<i class="icon-eye-open icon-large"></i>
							</a>

							<button 
								id="ajax_delete_{{ $qrcode->id }}"
								class="btn btn-small"
								type="button"
								title="{{ e(__('forms.delete_word')) }}"
								data-post="{{ e('{ "id": "'.$qrcode->id.'", "delete": "delete"}') }}"
								data-link="{{ action('admin.qrcode.action@delete') }}"
								data-message="{{ e(__('forms.delete_warning', array('item' => $qrcode->title))) }}"
								data-out="qrcode_row_{{ $qrcode->id }}"
								data-out-popup="true"
								data-remove="qrcode_row_{{ $qrcode->id }}"
								data-prevent-follow="true"
							>
								<i class="icon-trash icon-large red"></i>
							</button> 

						</div>
					</td>
				</tr>

			@endforeach
		</tbody>
	</table>

	{{ HTML::script('cms/scripts/vendor/jquery.lazyload.min.js') }}
	<script type="text/javascript">
		$(document).ready(function() {

			var container = window;

			if($(".scroll-y").length !== 0){ 

				container = $(".scroll-y");
			}

			$("img.lazy").lazyload({
				effect: "fadeIn",
				container: container
			});
		});
	</script>

	@else

		<div class="well well-large" style="text-align: center">
			<h6>{{ __('qrcode.no_qrcode_exists') }}</h6>
		</div>

	@endif

@endsection
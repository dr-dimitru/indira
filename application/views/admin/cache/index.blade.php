@layout('admin.cache.template')

<h3>
	<i class="icon-rocket"></i> {{ __('content.cache_control') }}
</h3>

<hr>

@section('cache')
	
<div class="row-fluid">
	<div class="span6">

		<h4>{{ __('cache.cache_word') }}</h4>
		<h6>{{ __('cache.current_cahe_driver') }}: {{ $driver }}</h6>
		@if(in_array($driver, array('redis', 'memory', 'file', 'database')))
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>
							{{ __('cache.cahe_driver') }}
						</th>
						<th>
							{{ __('cache.cached_qty') }}
						</th>
						<th>
							{{ __('forms.action_word') }}
						</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							{{ ucfirst($driver) }}
						</td>
						<td>
							<span class="badge" id="cached">{{ $cached }}</span>
						</td>
						<td>
							<button
								id="ajax_flush_blades"
								class="btn"
								data-link="{{ action('admin.cache.action@flush') }}"
								data-post="{{ e('{"driver": "'.$driver.'"}') }}"
								data-prevent-follow="true"
								data-out="cached"
								data-out-popup="{{ e(Utilites::alert(__('cache.flushed'), 'success')) }}"
								@if($cached == 0)
									DISABLED
								@endif
							>
								<i class="icon-circle-blank red"></i> {{ __('cache.clear_cache') }}
							</button>
						</td>
					</tr>
				</tbody>
			</table>
		@else
			<div class="well">
				{{ __('cache.driver_not_supported', array('driver' => $driver)) }}
			</div>
		@endif

		<hr>

		<h4>{{ __('cache.bladed_word') }}</h4>
		<h6>{{ __('cache.blade_annotation') }}</h6>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>
						{{ __('cache.blade_route') }}
					</th>
					<th>
						{{ __('cache.bladed_qty') }}
					</th>
					<th>
						{{ __('forms.action_word') }}
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<code>storage/views</code>
					</td>
					<td>
						<span class="badge" id="blades">{{ $blades }}</span>
					</td>
					<td>
						<button
							id="ajax_flush_blades"
							class="btn"
							data-link="{{ action('admin.cache.action@flush_blade') }}"
							data-post="{{ e('{"flush": "blades"}') }}"
							data-prevent-follow="true"
							data-out="blades"
							data-out-popup="{{ e(Utilites::alert(__('cache.blades_flushed'), 'success')) }}"
							@if($blades == 0)
								DISABLED
							@endif
						>
							<i class="icon-trash red"></i> {{ __('cache.delete_blades') }}
						</button>
					</td>
				</tr>
			</tbody>
		</table>	
	</div>

	<div class="span6">
		<div class="well">
			{{ __('cache.cache_annotation') }}
		</div>
	</div>
</div>

@endsection
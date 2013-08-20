@if($promocodes)

	@if($pagination)
		<div class="row-fluid">
			<div class="span7">
				{{ $pagination }}
			</div>
			<div class="span5" align="right">
				@include('admin.assets.show_by_bar')
			</div>
		</div>
	@endif

	<table class="table table-condensed table-bordered table-hover" id="users_listing_table">
		<thead>
			<tr>
				<th>
					{{__('promocode.promocode')}}
				</th>
				<th>
					{{__('promocode.owner')}}
				</th>
				<th>
					{{__('promocode.used')}}
				</th>
				<th>
					{{__('promocode.access_level')}}
				</th>
				<th>
					{{__('forms.action_word')}}
				</th>
			</tr>
		</thead>

	@foreach($promocodes as $row)
		
		<tbody>
			<tr id="promocode_row_{{ $row->id }}">
				<td>
					{{ $row->code }}
				</td>
				<td>
					{{ $row->owner }}
				</td>
				<td style="text-align:center">
					@if($row->used)
						<i class="icon-ok"></i>
					@endif
				</td>
				<td>
					<strong>{{ $row->level }}</strong> :
					@foreach($useraccess as $access)
						@if($access->level == $row->level)
							{{ __('useraccess.'.$access->name) }}
						@endif
					@endforeach
				</td>
				<td>
					<div class="btn-group">
						<a 	id="go_to_promocode_{{ $row->id }}" 
							href="{{ action('admin.promocodes.home@edit', array($row->id)) }}" 
							class="btn btn-small" 
							data-title="{{ Utilites::build_title(array('content.application_name', 'promocode.promocode')) }} · {{ $row->code }}"
							onclick="$('#main_modal').modal('show')"
							data-prevent-follow="true"
							data-out="main_modal"
							data-load="main_modal"
						>
							<i class="icon-edit icon-large"></i>
						</a> 

						<button 
							id="ajax_delete_{{ $row->id }}"
							class="btn btn-small"
							type="button"
							data-link="{{ action('admin.promocodes.action@delete') }}" 
							data-post="{{ e('{ "id": "'.$row->id.'", "delete": "delete"}') }}" 
							data-message="{{ e(__('forms.delete_warning', array('item' => $row->code))) }}" 
							data-prevent-follow="true" 
							data-out="promocode_row_{{ $row->id }}"
							data-remove="promocode_row_{{ $row->id }}"
							data-out-popup="true"
						>
							<i class="icon-trash icon-large red"></i>
						</button> 
					</div>
				</td>
			</tr>
		</tbody>

	@endforeach

	</table>

	@if($pagination)
		<div class="row-fluid">
			<div class="span7">
				{{ $pagination }}
			</div>
			<div class="span5" align="right">
				@include('admin.assets.show_by_bar')
			</div>
		</div>
	@endif

@else

	<div class="well" style="text-align:center">
		<h6>No Promocodes created yet | Use generator above, please</h6>
	</div>	

@endif
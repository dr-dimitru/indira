@layout('admin.filedb.template')

<h3>
	<i class="icon-table"></i> {{ ucfirst($table_name) }} 
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			href="{{ action('admin.filedb.home@index') }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb')) }}"
			class="btn"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>

		<a 
			id="go_to_new_{{ $table_name }}"
			href="{{ URL::to('admin/filedb/home/add_row/'.$table_name) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb', $table_name, 'content.add_new_word')) }}"
			class="btn"
			title="{{ __('content.add_new_word') }}"
		>
			<i class="icon-plus green"></i>
		</a>
	</div>

	<div class="btn-group pull-right">
		<a 
			id="go_to_model_{{ $table_name }}"
			href="{{ URL::to('admin/filedb/home/model/'.$table_name) }}" 
			data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb', $table_name, 'filedb.model_word')) }}"
			class="btn"
			title="{{ __('filedb.model_word') }}"
		>
			<i class="icon-th-list"></i>
		</a>

		<button 
			id="ajax_update_db_{{ $table_name }}"
			class="btn"
			type="button"
			data-link="{{ action('admin.filedb.action@update', array($table_name)) }}"
			data-prevent-follow="true"
			data-out-popup="{{ e(Utilites::alert(__('filedb.table_updated_notification', array('t' => $table_name)), 'success')) }}"
			title="{{ __('filedb.update_table') }}"
		>
			<i class="icon-refresh"></i>
		</button>
	</div>
</div>

@section('filedb')

<div class="row-fluid">
	<div class="span12">
		@if($table)
		
			<h6>{{ ($encryption) ? '<span style="color: #000">'.__('filedb.encrypted_word').'</span> | ' : '' }}{{ __('filedb.records_word') }}: {{ Filedb::get_table_records($table_name) }} | {{ __('filedb.size_word') }}: {{ get_file_size(Filedb::get_table_size($table_name)) }}</h6>
			
			<div class="row-fluid">
				<div class="span7">
					{{ ($pagination) ? $pagination : null }}
				</div>
				<div class="span5" align="right">
					@include('admin.assets.show_by_bar')
				</div>
			</div>

			<div class="scroll" style="overflow-y: scroll; -webkit-overflow-scrolling: touch;">
				<table class="table table-bordered table-hover" style="max-width: inherit !important">
					<thead>
						<tr>
							@foreach($table as $value1)@endforeach
									<th style="width:5%">
										{{ __('forms.action_word') }}
									</th>
								@foreach($value1 as $key => $row_value)
									<th>
										<span style="white-space:nowrap;">{{ $key }} 
										@if(isset($order))
											@if($order['field'] == $key && $order['order'] == 'desc')
												<a 	href="{{ URL::to('admin/filedb/home/sort/'.$table_name.'/'.$key.'/asc'.$query) }}" 
												 	class="order-caret selected" 
												 	id="go_to_order_asc_{{ $key }}"
												>
													<i class="icon-caret-down icon-large"></i>
												</a>
											@elseif($order['field'] == $key && $order['order'] == 'asc')
												<a 	href="{{ URL::to('admin/filedb/home/sort/'.$table_name.'/'.$key.'/desc'.$query) }}" 
												 	class="order-caret selected" 
												 	id="go_to_order_desc_{{ $key }}"
												>
													<i class="icon-caret-up icon-large"></i>
												</a>
											@else
												<a 	href="{{ URL::to('admin/filedb/home/sort/'.$table_name.'/'.$key.'/asc'.$query) }}" 
													class="order-caret" 
													id="go_to_order_asc_{{ $key }}" 
												>
													<i class="icon-caret-up icon-large"></i>
												</a>
											@endif
										@elseif($key == 'id')
											<a 	href="{{ URL::to('admin/filedb/home/sort/'.$table_name.'/'.$key.'/desc'.$query) }}" 
												class="order-caret selected" 
												id="go_to_order_asc_{{ $key }}"
											>
												<i class="icon-caret-up icon-large"></i>
											</a>
										@else
											<a 	href="{{ URL::to('admin/filedb/home/sort/'.$table_name.'/'.$key.'/asc'.$query) }}" 
											 	class="order-caret"
											 	id="go_to_order_asc_{{ $key }}" 
											>
												<i class="icon-caret-up icon-large"></i>
											</a>
										@endif
										</span>
									</th>
								@endforeach
						</tr>
					</thead>
					<tbody>
						@foreach($table as $value)
						<tr id="{{ $table_name }}_row_{{ $value->id }}">
							<td>
								<div class="btn-group">
									<a
										href="{{ URL::to('admin/filedb/home/edit/'.$table_name.'/'.$value->id) }}" 
										id="go_to_edit_row_{{ $value->id }}" 
										class="btn btn-small"
										data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb', $table_name, 'forms.edit_word')) }} · {{ $value->id }}"
										title="{{ __('forms.edit_word') }}"
									>
										<i class="icon-edit icon-large"></i>
									</a>

									<?php
										$json_delete = '{ "id": "'.$value->id.'", "table": "'.$table_name.'", "delete": "delete"}';
									?>
									<button 
										id="ajax_delete_row_{{ $value->id }}" 
										class="btn btn-small"
										type="button"
										data-link="{{ action('admin.filedb.action@delete') }}"
										data-post="{{ e('{ "id": "'.$value->id.'", "table": "'.$table_name.'", "delete": "delete"}') }}"
										data-message="{{ e(__('forms.delete_warning', array('item' => $value->id))) }}"
										data-prevent-follow="true"
										data-out="{{ $table_name }}_row_{{ $value->id }}"
										data-out-popup="true"
										data-remove="{{ $table_name }}_row_{{ $value->id }}"
										title="{{ __('forms.delete_word') }}"
									>
										<i class="icon-trash icon-large red"></i>
									</button>
								</div>
							</td>
							@foreach($value as $key => $row_value)
								@if(is_object($value->$key))
									<td class="ellipsis">{{ substr(strip_tags(var_dump($value->$key)), 0, 100) }}</td>
								@elseif($key == 'updated_at' || $key == 'created_at')
									<td class="ellipsis">{{ (is_numeric($value->$key)) ? date('d F Y H:i', $value->$key) : $value->$key }}</td>
								@else
									<td class="ellipsis">{{ substr(strip_tags($value->$key), 0, 100) }}</td>
								@endif
							@endforeach
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="row-fluid">
				<div class="span7">
					{{ ($pagination) ? $pagination : null }}
				</div>
				<div class="span5" align="right">
					@include('admin.assets.show_by_bar')
				</div>
			</div>

		@else
			<center>
				<h6>No records in "{{ $table_name }}" table</h6>
			</center>
		@endif
	</div>
</div>

@endsection
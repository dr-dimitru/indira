@layout('admin.filedb.template')

<h3>
	<i class="icon-hdd"></i> {{ __('filedb.filedb') }}
	<small>
		<button
			id="download_filedb_dump"
			onclick="window.open('{{ action('admin.filedb.action@dbMakeDump') }}','_newtab');"
			class="btn btn-small btn-inverse"
		>
			<i class="icon-hdd icon-large"></i> {{ __('filedb.dump_word') }} 
		</button>
	</small>
</h3>

<hr>

@section('filedb')
<div class="row-fluid">
	<div class="span6">
		<h4>{{ __('filedb.summary') }}</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>{{ __('filedb.db_size') }}</th>
					<th>{{ __('filedb.db_records') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ get_file_size(Filedb::get_db_size()) }}</td>
					<td>{{ Filedb::get_db_records() }}</td>
				</tr>
			</tbody>
		</table>

		<hr>

		<h4>
			{{ __('filedb.tables_word') }} 
			<small>
				<a 
					id="go_to_new_table"
					href="{{ action('admin.filedb.home@add_table') }}" 
					data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb', 'content.add_new_word')) }}"
					class="btn btn-small"
				>
					<i class="icon-plus green"></i> {{ __('content.add_new_word') }}
				</a>
			</small>
		</h4>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>{{ __('filedb.table_word') }}</th>
					<th>{{ __('forms.action_word') }}</th>
					<th>{{ __('filedb.records_word') }}</th>
					<th>{{ __('filedb.size_word') }}</th>
				</tr>
			</thead>
			<tbody>
				@foreach(Filedb::get_tables() as $table)
				<tr id="table_row_{{ $table }}">
					<td>
						{{ ($table::has_encryption()) ? '<i class="icon-shield icon-large" rel="tooltip" title="'.e(__('filedb.encrypted_word')).'"></i>' : '' }}
						<a 
							href="{{ action('admin.filedb.home@table', array($table)) }}" 
							id="go_to_table_{{ $table }}"
							data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb')) }} · {{ $table }}" 
						>
							{{ $table }}
						</a>
					</td>
					<td id="actions_{{ $table }}">
						<a 
							href="{{ action('admin.filedb.home@table', array($table)) }}" 
							id="go_to_table_btn_{{ $table }}" 
							data-title="{{ Utilites::build_title(array('content.application_name', 'filedb.filedb')) }} · {{ $table }}" 
							class="btn btn-mini"
						>
							<i class="icon-search"></i>
						</a>

						<div class="btn-group">
							<a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="icon-trash icon-large red"></i>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a 
										id="go_to_truncate_table_{{ $table }}" 
										href="{{ action('admin.filedb.action@truncate_table') }}"
										data-post="{{ e('{ "trunc": "truncate", "table": "'.$table.'"}') }}"
										data-message="{{ e(__('forms.delete_warning', array('item' => __('filedb.truncate_notification')))) }}"
										data-prevent-follow="true"
										data-out="records_of_{{ $table }}"
										data-out-popup="{{ e(Utilites::alert(__('filedb.truncated_table', array('t' => $table)), 'success')) }}"
									>
										<i class="icon-circle-blank red"></i> {{ __('filedb.truncate_table') }}
									</a>
								</li>
								<li>
									<a 
										id="go_to_drop_table_{{ $table }}" 
										href="{{ action('admin.filedb.action@drop_table') }}"
										data-post="{{ e('{ "drop": "drop", "table": "'.$table.'"}') }}"
										data-message="{{ e(__('forms.delete_warning', array('item' => __('filedb.drop_notification')))) }}"
										data-prevent-follow="true"
										data-out="actions_{{ $table }}"
										data-out-popup="true"
										data-remove="table_row_{{ $table }}"
									>
										<i class="icon-trash red"></i> {{ __('filedb.drop_table') }}
									</a>
								</li>
							</ul>
						</div>

						<a 
							href="{{ action('admin.schema.action@create_migration') }}" 
							id="go_to_create_migration_{{ $table }}" 
							data-post="{{ e('{ "table": "'.$table.'"}') }}"
							data-title="{{ Utilites::build_title(array('content.application_name', 'content.sql_migrations')) }}"
							data-message="{{__('schema.create_migration_warning')}}"
							data-prevent-follow="true"
							title="{{__('schema.create_migration_word')}}"
							class="btn btn-mini"
						>
							<i class="icon-archive"></i>
						</a>
					</td>
					<td id="records_of_{{ $table }}">{{ Filedb::get_table_records($table) }}</td>
					<td>{{ get_file_size(Filedb::get_table_size($table)) }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	<div class="span6">
		<div class="well well-small">
			{{ __('filedb.promo') }}
		</div>
	</div>
</div>

@endsection

<script type="text/javascript">
	$('[rel=tooltip]').tooltip();
</script>
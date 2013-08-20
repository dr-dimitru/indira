@foreach($migrations as $file_name => $table_name)
	<tr id="migration_row_{{ $file_name }}">
		<td>
			<span class="label">{{ (stripos($table_name, 'nosqlfiledb')) ? ucfirst(str_replace('nosqlfiledb', '', $table_name)) : ucfirst($table_name) }}</span>
		</td>
		<td>
			@if(in_array($table_name, $models))
				<span class="label label-success">{{__('schema.up_word')}}</span>
			@else
				<span class="label label-important">{{__('schema.down_word')}}</span>
			@endif

			@if(stripos($table_name, 'nosqlfiledb'))
				<span class="label label-inverse">{{__('schema.on_nosql')}}</span>
			@endif
		</td>
		<td>
			<code>application/migrations/{{ $file_name }}.php</code>
		</td>
		<td>
			@if(stripos($table_name, 'nosqlfiledb'))

				<button
					id="ajax_schema_migrate_{{ $table_name }}"
					class="btn btn-small"
					data-prevent-follow="true"
					data-link="{{ action('admin.schema.action@migrate_in') }}"
					data-post="{{ e('{ "table": "'.$table_name.'"}') }}"
					data-message="{{ e(__('schema.run_migration_warning')) }}"
				>
					<i class="icon-archive icon-large"></i> {{__('schema.migrate_from_nosql')}}
				</button>

			@else

				<button
					id="ajax_schema_action_{{ $table_name }}"
					class="btn btn-small"
					data-prevent-follow="true"
					@if(in_array($table_name, $models))
					data-link="{{ action('admin.schema.action@down', array($table_name)) }}"
						><i class="icon-ban-circle red icon-large"></i> {{__('schema.down_word')}}
					@else
					data-link="{{ action('admin.schema.action@up', array($table_name)) }}"
						><i class="icon-cloud-upload icon-large"></i> {{__('schema.up_word')}}
					@endif
				</button>

			@endif

			<button
				id="ajax_delete_schema_{{ $table_name }}"
				class="btn btn-small"
				data-prevent-follow="true"
				data-link="{{ action('admin.schema.action@delete_migration') }}"
				data-post="{{ e('{ "file_name": "'.$file_name.'"}') }}"
				data-out="migration_row_{{ $file_name }}"
				data-remove="migration_row_{{ $file_name }}"
				data-out-popup="true"
				title="{{ __('forms.delete_word') }}"
			>
				<i class="icon-trash red icon-large"></i>
			</button>
		</td>
	</tr>
@endforeach
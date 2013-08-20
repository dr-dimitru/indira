@layout('admin.schema.template')

<h3>
	<i class="icon-archive"></i> {{ __('content.sql_migrations') }} 
</h3>

<hr>

@section('schema')
	
	@if(Config::get('database.connections.'.Config::get('database.default').'.host'))

		@if(!DB::only('SELECT COUNT(*) as `exists` FROM information_schema.tables WHERE table_name IN (?) AND table_schema = database()', 'laravel_migrations'))

			<div class="well">
				<h6>{{ __('schema.no_migrations_table') }}</h6>

				<button
					id="ajax_create_migration_table"
					class="btn btn-inverse btn-block"
					data-prevent-follow="true"
					data-link="{{ action('admin.schema.action@artisan') }}"
					data-post="{{ e('{ "method": "migrate:install", "param": ""}') }}"
				>
					<i class="icon-exchange icon-large"></i> {{__('schema.create_migration_table')}}
				</button>
			</div>

		@else

			@if($migrations)
				<h4>
					{{__('schema.migration_files_word')}} 
					<small>
						<div class="btn-group">
							<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="icon-terminal icon-large"></i> PHP Artisan Migrate
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a 
										id="go_to_migrate_rollback" 
										href="{{ action('admin.schema.action@artisan') }}"
										data-post="{{ e('{ "method": "migrate:rollback", "param": ""}') }}"
										data-prevent-follow="true"
										data-out="false"
										data-out-popup="true"
									>
										migrate:rollback
									</a>
								</li>
								<li>
									<a 
										id="go_to_migrate_reset" 
										href="{{ action('admin.schema.action@artisan') }}"
										data-post="{{ e('{ "method": "migrate:reset", "param": ""}') }}"
										data-prevent-follow="true"
										data-out="false"
										data-out-popup="true"
									>
										migrate:reset
									</a>
								</li>
								<li>
									<a 
										id="go_to_migrate_rebuild" 
										href="{{ action('admin.schema.action@artisan') }}"
										data-post="{{ e('{ "method": "migrate:rebuild", "param": ""}') }}"
										data-prevent-follow="true"
										data-out="false"
										data-out-popup="true"
									>
										migrate:rebuild
									</a>
								</li>
								<li class="divider"></li>
								<li>
									<a 
										id="go_to_migrate_application" 
										href="{{ action('admin.schema.action@artisan') }}"
										data-post="{{ e('{ "method": "migrate", "param": "application"}') }}"
										data-prevent-follow="true"
										data-out="false"
										data-out-popup="true"
									>
										migrate application
									</a>
								</li>
								<li>
									<a 
										id="go_to_migrate_bundle" 
										href="{{ action('admin.schema.action@artisan') }}"
										data-post="{{ e('{ "method": "migrate", "param": "bundle"}') }}"
										data-prevent-follow="true"
										data-out="false"
										data-out-popup="true"
									>
										migrate bundle
									</a>
								</li>
								<li>
									<a 
										id="go_to_migrate" 
										href="{{ action('admin.schema.action@artisan') }}"
										data-post="{{ e('{ "method": "migrate", "param": ""}') }}"
										data-prevent-follow="true"
										data-out="false"
										data-out-popup="true"
									>
										migrate
									</a>
								</li>
							</ul>
						</div>
					</small>
				</h4>
				<table class="table table-condensed table-bordered table-hover" id="schema_listing_table">
					<thead>
						<tr>
							<th>
								{{__('schema.name_word')}}
							</th>
							<th>
								{{__('schema.status_word')}}
							</th>
							<th>
								{{__('schema.route_word')}}
							</th>
							<th>
								{{__('forms.action_word')}}
							</th>
						</tr>
					</thead>
					<tbody id="schema_listing_body">

						@include('admin.schema.listing_body')

					</tbody>
				</table>

			@else
				<div class="well well-large" style="text-align: center">
					<h6>{{ __('schema.no_migrations') }}</h6>
				</div>
			@endif


			@if($sql_tables)
				<hr>

				<h4>{{__('schema.sql_tables_word')}}</h4>
				<table class="table table-condensed table-bordered table-hover" id="schema_listing_table">
					<thead>
						<tr>
							<th>
								{{__('schema.name_word')}}
							</th>
							<th>
								{{__('forms.action_word')}}
							</th>
						</tr>
					</thead>
					<tbody id="sql_listing_body">
						@foreach($sql_tables as $sql_table)
							<tr>
								<td>
									<span class="label">{{ ucfirst($sql_table->table_name) }}</span>
								</td>
								<td>
									@if($sql_table->table_name == 'laravel_migrations')

									<button
										type="button"
										class="btn btn-inverse btn-small disabled"
										DISABLED
									>
										<i class="icon-exchange icon-large"></i> {{__('schema.create_migration_table')}}
									</button>

									@else

									<button
										type="button"
										id="ajax_create_migration_file_for_{{ $sql_table->table_name }}"
										class="btn btn-inverse btn-small"
										data-prevent-follow="true"
										data-link="{{ action('admin.schema.action@create_migration') }}"
										data-post="{{ e('{ "table": "'.$sql_table->table_name.'"}') }}"
									>
										<i class="icon-exchange icon-large"></i> {{__('schema.create_migration_table')}}
									</button>

									<div class="btn-group">
										<a class="btn btn-small dropdown-toggle" data-toggle="dropdown" href="#">
											<i class="icon-terminal icon-large"></i> PHP Artisan Migrate
											<span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li>
												<a 
													id="go_to_migrate_make_{{ $sql_table->table_name }}" 
													href="{{ action('admin.schema.action@artisan') }}"
													data-post="{{ e('{ "method": "migrate:make", "param": "create_'.$sql_table->table_name.'_table"}') }}"
													data-prevent-follow="true"
													data-out="false"
													data-out-popup="true"
												>
													<small>migrate:make create_{{ $sql_table->table_name }}_table</small>
												</a>
											</li>
										</ul>
									</div>

									<button
										id="ajax_schema_migrate_to_nosql_{{ $sql_table->table_name }}"
										class="btn btn-small"
										data-prevent-follow="true"
										data-link="{{ action('admin.schema.action@migrate_out') }}"
										data-post="{{ e('{ "table": "'.$sql_table->table_name.'"}') }}"
										data-message="{{ e(__('schema.run_migration_to_nosql_warning')) }}"
									>
										<i class="icon-hdd icon-large"></i> {{__('schema.migrate_to_nosql')}}
									</button>

									@endif
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

			@endif

		@endif

	@else

		<div class="well">
			<h6>{{ __('schema.no_connection') }}</h6>
		</div>

	@endif

@endsection
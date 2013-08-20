@layout('admin.filedb.template')

<h3>	
	<i class="icon-edit"></i> {{ ucfirst($table_name) }} · {{ __('forms.edit_word') }} · {{ $row_id }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<button 
			id="go_to_back"
			type="button"
			onclick="History.back()" 
			class="btn"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</button>
	</div>
</div>

@section('filedb')

@foreach ($table as $columns)

	<?php
		$save_json = array();
		$save_json['id'] = $columns->id;
		$save_json['table'] = $table_name;
	?>

	@foreach ($columns as $key => $column)
		<?php
			if($key == 'id'){
				$save_json['data_arr'][$key.'_'.$columns->id] = $column;
			}else{
				$save_json['data_arr'][$key.'_'.$columns->id] = null;
			}
		?>

		@if(in_array($key, array('id', 'created_at', 'updated_at')))

			<div class="row-fluid">
				<div class="span2" style="text-align:right">
					<h6>{{ $key }} <small>(<strong>Uneditable</strong>)</small></h6>
				</div>
				<div class="span10">
					<input 
						id="{{ $key }}_{{ $columns->id }}"
						class="span10 readonly disabled"
						type="text"
						value="{{ e(stripslashes($column)) }}"
						readonly
						disabled
					/>
				</div>
			</div>

		@else

			<div class="row-fluid">
				<div class="span2" style="text-align:right">
					<h6>{{ $key }} <small>(<strong>{{ Utilites::print_type($column) }}</strong>)</small></h6>
				</div>
				<div class="span10">
					@if(is_object($column) || is_array($column))
					
						<?php $save_json['data_arr'][$key] = $column; ?>
						{{ Utilites::echo_object($column) }}

					@else

						<textarea 
							id="{{ $key }}_{{ $columns->id }}"
							rows="2"
							placeholder="Put data here" 
							class="span10" 
							autocapitalize="none" 
							autocorrect="off"
						>{{ e(stripslashes($column)) }}</textarea>

					@endif
				</div>
			</div>
		@endif
	@endforeach

<div class="form-actions">
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group" style="text-align: center">
				<div class="controls">

					<div class="btn-group">
						<button 
							id="ajax_save_button_{{ $columns->id }}"
							class="btn"
							type="button"
							data-link="{{ action('admin.filedb.action@save') }}"
							data-post="{{ e(Utilites::json_with_js_encode($save_json)) }}"
							data-out="status_{{ $columns->id }}"
							data-out-popup="true"
							data-prevent-follow="true"
						>
							<i class="icon-save green"></i> {{ __('forms.save_word') }}
						</button>
					</div>

					<span id="status_{{ $columns->id }}" class="btn disabled"></span>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach

@endsection
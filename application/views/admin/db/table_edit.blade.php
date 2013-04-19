@layout('admin.db.template')

<h3>
	{{ $table_name }} 
	<small>
		<button 
			id="back"
			onclick="History.back()"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-chevron-left"></i> {{ Lang::line('content.go_back')->get(Session::get('lang')) }}
		</button>
	</small>
</h3>

<hr>

@foreach ($table as $columns)

	<?php
		$save_json = array();
		$save_json['id'] = $columns->id;
		$save_json['table'] = $table_name;
	?>

	@foreach ($columns as $key => $column)
		<?php
			if($key == 'id'){
				$save_json['data_arr'][$key] = $column;
			}else{
				$save_json['data_arr'][$key] = "'+encodeURI($('#".$key."_".$columns->id."').val())+'";
			}
		?>

		@if($key == 'id')

			<div class="row-fluid">
				<div class="span2" style="text-align:right">
					<h6>{{ $key }} <small>(<strong>Uneditable</strong>)</small></h6>
				</div>
				<div class="span10">
					<h6>{{ $column }}</h6>
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
						>{{ htmlspecialchars(stripslashes($column)) }}</textarea>

					@endif
				</div>
			</div>
		@endif
	@endforeach

	<div class="row-fluid">
		<div class="span2" style="text-align:right">
			<h6>{{ Lang::line('content.action_word')->get(Session::get('lang')) }}</h6>
		</div>
		<div class="span10">
			<button 
				id="save_button_{{ $columns->id }}"
				class="btn"
				type="button"
				onclick="showerp('{{ htmlspecialchars(json_encode($save_json)) }}', '{{ URL::to('admin/db/save') }}', 'save_button_{{ $columns->id }}', 'work_area', false, true); ">
					<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
			</button>
			<span id="status_{{ $columns->id }}" class="btn disabled">
				@if(isset($status))
					{{ $status }}
				@endif
			</span>
		</div>
	</div>
@endforeach
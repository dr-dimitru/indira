@layout('admin.filedb.template')

<h3>
	<i class="icon-plus"></i> {{ ucfirst($table_name) }} · {{ __('content.add_new_word') }} 
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

@foreach ($table as $key => $val)

	<?php
		$json_save['data_arr'][$key.'_'.$table_name] = null;
	?>

	<div class="row-fluid">
		<div class="span2" style="text-align:right">
			<h6>{{ $key }}</h6>
		</div>
		<div class="span10">
			<textarea 
				id="{{ $key.'_'.$table_name }}"
				rows="2"
				placeholder="Put data here" 
				class="span10" 
				autocapitalize="none" 
				autocorrect="off"
			>{{ e(stripslashes($val)) }}</textarea>
		</div>
	</div>

@endforeach

<div class="form-actions">
	<div class="row-fluid">
		<div class="span12">
			<div class="control-group" style="text-align: center">
				<div class="controls">

					<div class="btn-group">
						<button 
							id="ajax_save_button"
							class="btn"
							type="button"
							data-link="{{ action('admin.filedb.action@create_row') }}"
							data-post="{{ e(Utilites::json_with_js_encode($json_save)) }}"
							data-out="status"
							data-out-popup="true"
							data-prevent-follow="true"
						>
							<i class="icon-save green"></i> {{ __('forms.save_word') }}
						</button>
					</div>

					<span id="status" class="btn disabled"></span>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
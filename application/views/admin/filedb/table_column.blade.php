@foreach($columns as $key => $data)
	
	<?php 

	$readonly = (in_array($data["name"], array('id', 'created_at', 'updated_at'))) ? 'readonly' : '';
	$disabled = (in_array($data["name"], array('id', 'created_at', 'updated_at'))) ? 'disabled' : '';

	?>

	<div class="row-fluid">
		<div class="span6" style="text-align:right">
			<input 
				id="{{ $key }}_name"
				type="text"
				placeholder="{{ __('filedb.column') }}" 
				class="span8 {{ $readonly }}"  
				value="{{ e($data["name"]) }}" 
				{{ $readonly }}
				autocapitalize="none" 
				autocorrect="off"
			/>
		</div>
		<div class="span6">

			<input 
				id="{{ $key }}_default"
				type="text"
				placeholder="{{ __('filedb.default_value') }}" 
				class="span10 {{ $readonly }}" 
				value="{{ e($data["default"]) }}"
				{{ $readonly }}
				autocapitalize="none" 
				autocorrect="off"
			/>

			<button 
				id="ajax_remove_column_{{ $key }}"
				class="btn"
				type="button"
				style="top: -6px; position: relative;"
				data-link="{{ action('admin.filedb.action@remove_column') }}?edit={{ $edit }}" 
				data-post="{{ e(${'json_delete_'.$key}) }}" 
				data-prevent-follow="true" 
				{{ $disabled }}
			>
				<i class="icon-trash red"></i>
			</button>

		</div>
	</div>

@endforeach
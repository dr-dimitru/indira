@layout('admin.filedb.template')

<h3>
	<i class="icon-th-list"></i> {{ ucfirst($table_name) }} · {{ __('filedb.model_word') }}
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

<div class="row-fluid">
	@if($file_lines == 1)
	<div class="span6">
		<div class="control-group">
		    <label class="control-label" for="table_name"><h6>{{ __('filedb.table_name') }}</h6></label>
			<div class="controls">
				<div class="input-append">
			    	<input 	id="table_name_" 
			    			class="span10 disabled readonly" 
			    			type="text" 
			    			value="{{ $table_name }}"  
			    			placeholder="{{ __('filedb.table_name') }}" 
			    			maxlength="30" 
			    			disabled 
			    			readonly 
			    	/><button 	
			    			id="rename"
			    			type="button"
			    			onclick="$('#rename_table_{{ $table_name }}_area').slideToggle()"
			    			class="btn" 
			    		>
			    			{{ __('filedb.rename_word') }}
			    		</button>
			    </div>

				<span class="help-block h6">{{ __('filedb.table_name_desc') }}</span>
			</div>
		</div>

		<div class="control-group" style="display:none" id="rename_table_{{ $table_name }}_area">
		    <label class="control-label" for="table_name"><h6>{{ __('filedb.new_name_word') }}</h6></label>
			<div class="controls input-append">
		    	<input 	id="table_name_new_{{ $table_name }}" 
		    			class="span10" 
		    			type="text" 
		    			value="{{ $table_name }}"  
		    			placeholder="{{ __('filedb.table_name') }}" 
		    			maxlength="30" 
		    			autocapitalize="none" 
						autocorrect="off"
		    	/>
		    		<button 	
		    			id="ajax_rename_table_{{ $table_name }}"
		    			class="btn"
		    			type="button"
		    			data-link="{{ action('admin.filedb.action@rename_table') }}"
		    			data-prevent-follow="true"
		    			data-out="status_new_name"
		    			data-out-popup="true"
		    			data-post="{{ e('{ "rename": "rename", "table": "'.$table_name.'", "name": encodeURI($(\'#table_name_new_'.$table_name.'\').val())}') }}"
		    		>
		    			<i class="icon-save green"></i> {{ __('forms.save_word') }}
		    		</button>

		    		<span class="btn disabled" id="status_new_name">&nbsp;</span>
			</div>
		</div>
	</div>
	<div class="span6">
		<h6>{{ __('filedb.encrypted_word') }}: <strong style="color:#000">{{ ($encrypt) ? __('forms.yes_word') : __('forms.no_word') }}</strong></h6>

		@if($encrypt)

			<button 
				id="ajax_decrypt_table_{{ $table_name }}"
				class="btn btn-small"
				type="button"
				data-post="{{ e('{"type": "decrypt"}') }}"
				data-link="{{ action('admin.filedb.action@decrypt', array($table_name)) }}"
				data-prevent-follow="true"
				data-out-popup="{{ e(Utilites::alert(__('filedb.decrypted_action', array('t' => $table_name)), 'success')) }}"
			>
				<i class="icon-unlock icon-large"></i>  {{ __('filedb.decrypt_word') }}
			</button>

		@else

			<button 
				id="ajax_encrypt_db_{{ $table_name }}"
				class="btn btn-small"
				type="button"
				data-post="{{ e('{"type": "encrypt"}') }}"
				data-link="{{ action('admin.filedb.action@encrypt', array($table_name)) }}"
				data-prevent-follow="true"
				data-out-popup="{{ e(Utilites::alert(__('filedb.encrypted_action', array('t' => $table_name)), 'success')) }}"
			>
				<i class="icon-shield icon-large"></i>  {{ __('filedb.encrypt_word') }}
			</button>

		@endif

		<input 	id="encrypt" 
				class="hidden" 
				type="hidden" 
				value="{{ (!$encrypt) ? '0' : 'true' }}"  
				style="display:none" 
		/>
		<span class="help-block h6">{{ __('filedb.encryption_annotation') }}</span>
	</div>
	@else
		<div class="span12">
			<input 	id="table_name_" 
	    			class="hidden" 
	    			type="hidden" 
	    			value="{{ $table_name }}"  
	    			style="display:none" 
		    />
		    <input 	id="encrypt" 
	    			class="hidden" 
	    			type="hidden" 
	    			value="{{ (!$encrypt) ? '0' : 'true' }}"  
	    			style="display:none" 
	    	/>
			<div class="well" style="text-align:center">
				<h6>{{ __('filedb.uneditable_model', array('t' => $table_name)) }}</h6>
			</div>
		</div>
	@endif
</div>

<div id="columns" class="well">
	
	@include('admin.filedb.table_column')

</div>
<button
	id="ajax_add_column"
	type="button"
	class="btn btn-block btn-inverse"
	data-link="{{ action('admin.filedb.action@add_column') }}?edit={{ $edit }}"
	data-post="{{ e($json_save) }}"
	data-prevent-follow="true"
>
	<i class="icon-plus green"></i> {{ __('filedb.add_column') }}
</button>

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

							@if($file_lines == 1)
								data-link="{{ action('admin.filedb.action@create_table') }}?edit={{ $edit }}"
							@else
								data-link="{{ action('admin.filedb.action@save_model') }}"
							@endif
							
							data-post="{{ e($json_save) }}"
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
@layout('admin.filedb.template')

<h3>
	<i class="icon-hdd"></i> {{ __('filedb.filedb') }} · {{ __('content.add_new_word') }} 	
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			href="{{ action('admin.filedb.home@index') }}"
			class="btn"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@section('filedb')

<div class="row-fluid">
	<div class="span6">
		<div class="control-group">
			<label class="control-label" for="table_name"><h6>{{ __('filedb.table_name') }}</h6></label>
				<div class="controls">
					<input 
						id="table_name_" 
						class="span12" 
						type="text" 
						value="{{ $table_name }}" 
						placeholder="{{ __('filedb.table_name') }}" 
						maxlength="30" 
						autocapitalize="none" 
						autocorrect="off"
					/>
				<span class="help-block h6">{{ __('filedb.table_name_desc') }}</span>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="control-group">
		    <label class="control-label" for="enctypt"><h6>{{ __('filedb.encrypt_word') }}</h6></label>
			<div class="controls">
		    	<select id="encrypt" class="span12">
		    		<option value="0" <?php if(!$encrypt){ echo 'selected'; } ?> >{{ __('forms.no_word') }}</option>
		    		<option value="true" <?php if($encrypt == 'true'){ echo 'selected'; } ?> >{{ __('forms.yes_word') }}</option>
		    	</select>
			</div>
		</div>
	</div>
</div>

<div id="columns" class="well">
	
	@include('admin.filedb.table_column')

</div>
<button
	id="ajax_add_column"
	type="button"
	class="btn btn-block btn-inverse"
	data-link="{{ action('admin.filedb.action@add_column') }}"
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
							data-link="{{ action('admin.filedb.action@create_table') }}"
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
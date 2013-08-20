@layout('admin.settings.template')

<h3>
	<i class="icon-columns"></i> {{ __('content.settings_word') }} · {{ ucfirst($type) }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.settings.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.main_settings')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@section('settings')
	
	<div class="row-fluid">
		<p>
			{{ __('settings.warning') }}
		</p>
		<hr>
		<div class="offset3 span6">
			@foreach($setting as $row)
				<div class="control-group">
					
						@if(is_object($row->value))

							<small class="help-block">{{ (Lang::has('settings.'.$row->type.'_'.$row->param.'_annotation')) ? __('settings.'.$row->type.'_'.$row->param.'_annotation') : null }}</small>

							{{ ${'form_'.$row->id} }}

							<div class="form-actions" style="padding-top:5px; margin: -24px 0px 0px 0px; text-align:center">
								<button
									id="ajax_save_{{ $row->id }}"
									class="btn"
									data-link="{{ action('admin.settings.action@save') }}"
									data-post="{{ e('{ "id": '.$row->id.', "value": '.${'json_save_'.$row->id}.' }') }}"
									data-out="null"
									data-out-popup="true"
									data-prevent-follow="true"
									title="{{ __('forms.save_word') }}"
								>
									<i class="icon-save green"></i>
								</button>
							</div>

						@else
							<label class="control-label" for="value_of_{{ $row->id }}">
								<h6>{{ $row->param }}:</h6>
							</label>
							<div class="controls">

								<small class="help-block">{{ (Lang::has('settings.'.$row->type.'_'.$row->param.'_annotation')) ? __('settings.'.$row->type.'_'.$row->param.'_annotation') : null }}</small>

								
								@if($row->value == 'false' || $row->value == 'true')
								<div>
									<select class="span10" id="value_of_{{ $row->id }}">
										<option value="true" {{ ($row->value == 'true') ? 'selected' : null }}>True</option>
										<option value="false" {{ ($row->value == 'false') ? 'selected' : null }}>False</option>
									</select>

								@else

								<div class="input-append">
									<input type="text" class="span11" id="value_of_{{ $row->id }}" value="{{ htmlspecialchars($row->value) }}" />

								@endif

									<button
										id="ajax_save_{{ $row->id }}"
										class="btn"
										data-link="{{ action('admin.settings.action@save') }}"
										data-post="{{ e('{ "id": '.$row->id.', "value": encodeURI($(\'#value_of_'.$row->id.'\').val()) }') }}"
										data-out="null"
										data-out-popup="true"
										data-prevent-follow="true"
										style="margin-bottom:10px"
										title="{{ __('forms.save_word') }}"
									>
										<i class="icon-save green"></i>
									</button>
								</div>
							</div>
						@endif
				</div>

				<hr>
			@endforeach
		</div>
	</div>

@endsection
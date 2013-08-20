@layout('admin.users.template')

<h3>
	<i class="icon-user"></i> {{ __('content.users_word') }} · <i class="icon-wrench"></i> {{ __('content.settings_word') }}
</h3>

<hr>

<div class="module-actions">
	<div class="btn-group pull-left">
		<a 
			id="go_to_back"
			class="btn"
			href="{{ action('admin.users.home@index') }}"
			data-title="{{ Utilites::build_title(array('content.application_name', 'content.users_word')) }}"
			title="{{ __('content.go_back') }}"
		>
			<i class="icon-angle-left icon-large"></i>
		</a>
	</div>
</div>

@section('users')
	<div class="row-fluid">
		<div class="span6 offset3">

			<div class="well">
				{{ Utilites::html_form_build('select', array('default_access_level', $settings['default_access_level']['value'], Utilites::prepare_additions('useraccess')), View::make('admin.assets.form_pattern'), __('users.settings.default_al'), array('id' => 'default_access_level','class' => 'span10')) }}

				<div class="clearfix"></div>

				<div class="form-actions">
					<div class="control-group" style="text-align:center">
						<div class="controls">

							<button 
								id="ajax_save_button" 
								class="btn" 
								type="button"
								data-link="{{ action('admin.users.action@save_settings') }}"
								data-post="{{ e('{ "id": "'.$settings['default_access_level']['id'].'", "value": encodeURI($(\'#default_access_level\').val()) }') }}"
								data-out="null"
								data-out-popup="{{ e(Utilites::alert(__('forms.saved_notification', array('item' => __('users.settings.default_al'))),'success')) }}"
								data-prevent-follow="true"
								disabled
							>
								<i class="icon-save green"></i> {{ __('forms.save_word') }}
							</button>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

	<hr>

	<div class="row-fluid">
		<div class="span12" id="promocodes_area">

				<h4>
					{{ __('users.settings.promocodes') }}

					<small class="btn-group" data-toggle="buttons-radio">
						<button 
							type="button" 
							@if($settings['promocodes_active']['value'] == 'false')
							class="btn"
							id="ajax_promocodes_on"
							data-link="{{ action('admin.users.action@save_settings') }}"
							data-post="{{  e('{ "id": "'.$settings['promocodes_active']['id'].'", "value": "true" }')  }}"
							@else
							class="btn active"
							@endif
							data-prevent-follow="true"
						>
							<i class="icon-off green"></i> {{ __('forms.on_word') }}
						</button>

						<button 
							type="button" 
							@if($settings['promocodes_active']['value'] == 'true')
							class="btn"
							id="ajax_promocodes_off"
							data-link="{{ action('admin.users.action@save_settings') }}"
							data-post="{{ e('{ "id": "'.$settings['promocodes_active']['id'].'", "value": "false" }') }}"
							@else
							class="btn active"
							@endif
							data-prevent-follow="true"
						>
							{{ __('forms.off_word') }}
						</button>
					</small>

					<small>
						<a 	id="go_to_promocode_generator" 
							class="btn btn-inverse" 
							href="{{ action('admin.promocodes.home@generator') }}"
							onclick="$('#main_modal').modal('show')"
							data-prevent-follow="true"
							data-out="main_modal"
							data-load="main_modal"
						>
							{{ __('promocode.generator.generator') }}
						</a>
					</small>
				</h4>

				@if($settings['promocodes_active']['value'] == 'true')

					<table class="table table-bordered table-condensed">
						<tbody>
							<tr>
								<td style="width:25%">
									{{ __('users.settings.promo_on_signup') }}
								</td>
								<td>
									<small class="btn-group" data-toggle="buttons-radio">
										<button 
											type="button" 
											@if($settings['promocodes_on_signup']['value'] == 'false')
											class="btn btn-small"
											id="ajax_promocodes_on"
											data-link="{{ action('admin.users.action@save_settings') }}"
											data-post="{{  e('{ "id": "'.$settings['promocodes_on_signup']['id'].'", "value": "true" }')  }}"
											@else
											class="btn active btn-small"
											@endif
											data-prevent-follow="true"
										>
											<i class="icon-off green"></i> {{ __('forms.yes_word') }}
										</button>

										<button 
											type="button" 
											@if($settings['promocodes_on_signup']['value'] == 'true')
											class="btn btn-small"
											id="ajax_promocodes_off"
											data-link="{{ action('admin.users.action@save_settings') }}"
											data-post="{{ e('{ "id": "'.$settings['promocodes_on_signup']['id'].'", "value": "false" }') }}"
											@else
											class="btn active btn-small"
											@endif
											data-prevent-follow="true"
										>
											{{ __('forms.no_word') }}
										</button>
									</small>
								</td>
							</tr>


							<tr>
								<td>
									{{ __('users.settings.promo_on_login') }}
								</td>
								<td>

									<small class="btn-group" data-toggle="buttons-radio">
										<button 
											type="button" 
											@if($settings['promocodes_on_login']['value'] == 'false')
											class="btn btn-small"
											id="ajax_promocodes_on"
											data-link="{{ action('admin.users.action@save_settings') }}"
											data-post="{{  e('{ "id": "'.$settings['promocodes_on_login']['id'].'", "value": "true" }')  }}"
											@else
											class="btn active btn-small"
											@endif
											data-prevent-follow="true"
										>
											<i class="icon-off green"></i> {{ __('forms.yes_word') }}
										</button>

										<button 
											type="button" 
											@if($settings['promocodes_on_login']['value'] == 'true')
											class="btn btn-small"
											id="ajax_promocodes_off"
											data-link="{{ action('admin.users.action@save_settings') }}"
											data-post="{{ e('{ "id": "'.$settings['promocodes_on_login']['id'].'", "value": "false" }') }}"
											@else
											class="btn active btn-small"
											@endif
											data-prevent-follow="true"
										>
											{{ __('forms.no_word') }}
										</button>
									</small>
								</td>
							</tr>
						</tbody>
					</table>

					{{ $promocodes_table }}

				@endif
		</div>
	</div>
@endsection
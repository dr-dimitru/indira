<div class="control-group">

    <label class="control-label" for="default_template"><h6>{{ __('template_settings.default_template') }}</h6></label>

	<div class="controls">

    	<select id="default_template">

    		@foreach($d_templates as $template)

    			<option {{ ($template->active == 'true') ? 'SELECTED' : null }} value="{{ $template->id }}">
    				{{ ucfirst($template->name) }}
    			</option>

    		@endforeach

    	</select>

        <button
            id="ajax_save_default_template"
            class="btn"
            data-link="{{ action('admin.template_settings.action@save_default_template') }}"
            data-post="{{ e('{"value": encodeURI($(\'#default_template\').val()) }') }}"
            data-out="null"
            data-out-popup="true"
            data-prevent-follow="true"
            title="{{ __('forms.save_word') }}"
            style="margin-bottom: 10px"
        >
            <i class="icon-save green"></i>
        </button>

        <small class="help-block">{{ __('template_settings.default_template_annotation') }}</small>
	</div>

</div>

@if($m_templates)
<hr style="margin: 10px -10px">

<div class="control-group">

    <label class="control-label" for="default_template">
        <h6>
            {{ __('template_settings.default_mobile_template') }}

            <small class="btn-group" data-toggle="buttons-radio">
                <button 
                    type="button" 
                    class="btn {{ (!$mobile_active) ? 'active' : null }} btn-mini"
                    @if($mobile_active)
                    id="ajax_mobile_template_off"
                    data-link="{{ action('admin.template_settings.action@mobile_toggle') }}"
                    data-post="{{  e('{ "turn": "false" }')  }}"
                    @endif
                    data-out="templates_control_panel"
                    data-prevent-follow="true"
                >
                    <i class="icon-minus-sign-alt red"></i> {{ __('forms.off_word') }}
                </button>

                <button 
                    type="button" 
                    class="btn {{ ($mobile_active) ? 'active' : null }} btn-mini"
                    @if(!$mobile_active)
                    id="ajax_mobile_template_on"
                    data-link="{{ action('admin.template_settings.action@mobile_toggle') }}"
                    data-post="{{ e('{ "turn": "true" }') }}"
                    @endif
                    data-out="templates_control_panel"
                    data-prevent-follow="true"
                >
                    <i class="icon-off green"></i> {{ __('forms.on_word') }}
                </button>
            </small>
        </h6>
    </label>

    <div class="controls">

        @if($mobile_active)
        <select id="default_mobile_template">

            @foreach($m_templates as $template)

                <option {{ ($template->active == 'true') ? 'SELECTED' : null }} value="{{ $template->id }}">
                    {{ ucfirst($template->name) }}
                </option>

            @endforeach

        </select>

        <button
            id="ajax_save_default_mobile_template"
            class="btn"
            data-link="{{ action('admin.template_settings.action@save_default_mobile_template') }}"
            data-post="{{ e('{"value": encodeURI($(\'#default_mobile_template\').val()) }') }}"
            data-out="null"
            data-out-popup="true"
            data-prevent-follow="true"
            title="{{ __('forms.save_word') }}"
            style="margin-bottom: 10px"
        >
            <i class="icon-save green"></i>
        </button>

        <small class="help-block">{{ __('template_settings.default_mobile_template_annotation') }}</small>
        @endif
    </div>

</div>
@endif
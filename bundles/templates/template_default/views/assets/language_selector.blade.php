@if(Langtable::count() > 1)

	<button style="display:none"
			id="ajax_lang_switcher"
			data-link=""
	></button>

	<span class="select-button">

		<a href="#" onclick="preventDefault()">
			<i class="icon-fixed-width icon-2x icon-globe"></i>
		</a>
		
		<select tabindex="-1" id="language_selector" class="selectable-link" style="width: 44px;top: -10px;" onchange="$('#ajax_lang_switcher').attr('data-link', $(this).val()); $('#ajax_lang_switcher').trigger('click');">
			
	    @foreach(Langtable::all() as $lang)

				<?php $langs[$lang->lang] = $lang->text_lang; ?>

		@endforeach

		@foreach($langs as $key => $value)

		    @if(Session::get('lang') == $key)

			<option value="{{ rawurldecode((isset($language_selector_url)) ? URL::to($language_selector_url, null, false, $key) : URL::to_language($key)) }}" SELECTED>
				{{ $value }}
			</option>

		    @else

			<option value="{{ rawurldecode((isset($language_selector_url)) ? URL::to($language_selector_url, null, false, $key) : URL::to_language($key)) }}">
				{{ $value }}
			</option>

		    @endif
		
		@endforeach
			
		</select>
	</span>

@endif
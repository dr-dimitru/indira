{{-- LANGUAGE CYCLE --}}

		<ul class="nav pull-right">
    <? $langs = Langtable::get_lang_params();?>
    		<li class="divider-vertical"></li>
		@foreach($langs as $key => $value)
		
		    @if(Session::get('lang') == $key)
			<li class="active">{{ HTML::link_to_route('admin_lang', $value["text_lang"], array($key)) }}</li>
		    @else
			<li>{{ HTML::link_to_route('admin_lang', $value["text_lang"], array($key)) }}</li>
		    @endif
		
		@endforeach
		</ul>
	
{{-- END LANGUAGE CYCLE --}}
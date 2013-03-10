<h3>{{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
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

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.title_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<input 
			id="title_{{ $section->id }}" 
			type="text"
			class="span6" 
			value="{{ htmlspecialchars(stripslashes($section->title)) }}" 
			oninput="$('#save_button_{{ $section->id }}').attr('disabled', false);"
		/>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.language_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
<?
	$langs = Langtable::all(); 
?>
		<select 
			id="lang_{{ $section->id }}" 
			class="span6" 
			onchange="$('#save_button_{{ $section->id }}').attr('disabled', false);"
		>
			<option DISABLED value="0">{{ Lang::line('content.select_lang_word')->get(Session::get('lang')) }}</option> 
			@foreach ($langs as $key => $value)
				<option  
					value="{{ $value->lang }}"
				>
						{{ $value->text_lang }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.action_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<div class="btn-group">
<? $json_save = '{"title": "\'+encodeURI($(\'#title_'.$section->id.'\').val())+\'", "lang": "\'+$(\'#lang_'.$section->id.'\').val()+\'"}'; ?>

			<button 
				id="save_button_{{ $section->id }}"
				class="btn"
				type="button"
				disabled="disabled" 
				onclick="showerp('<?= htmlspecialchars($json_save) ?>', '{{ URL::to('admin/section_area/add') }}', 'work_area', 'work_area', false, true)">
					<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
			</button>
		</div>
		<span id="status_{{ $section->id }}" class="btn disabled">
			@if(isset($status))
				{{ $status }}
			@endif
		</span>
	</div>
</div>
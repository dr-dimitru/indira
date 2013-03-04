<h3>{{ Lang::line('content.add_new_word')->get(Session::get('lang')) }}
	<small>
		<a 
			href="#!/posts_list" 
			id="back"
			onclick="shower('../admin/posts_list', 'back', 'work_area', false, true)"
			class="btn btn-small"
			style="position: relative; top:-6px;"
		>
			<i class="icon-chevron-left"></i> {{ Lang::line('content.go_back')->get(Session::get('lang')) }}
		</a>
	</small>
</h3>
<hr>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.title_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<input 
			id="title_{{ $post->id }}" 
			type="text"
			class="span6" 
			value="{{ $post->title }}" 
			oninput="$('#save_button_{{ $post->id }}').attr('disabled', false);"
		/>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.tags_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<input 
			id="tags_{{ $post->id }}"
			type="text" 
			placeholder="tag1, tag2, tag3, " 
			class="span6" 
			value="{{ $post->tags }}" 
			oninput="$('#save_button_{{ $post->id }}').attr('disabled', false);" 
		/>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.access_level_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
<?
	${'post_access_'.$post->access.$post->id} = 'SELECTED';
	$accessLevels = AccessLevels::get_accesslevels(); 
?>
		<select 
			id="post_access_{{ $post->id }}" 
			class="span6" 
			onchange="$('#save_button_{{ $post->id }}').attr('disabled', false);"
		>
			@foreach ($accessLevels as $key => $value)
				<option
					value="{{ $value->level }}"
					@if (isset(${'post_access_'.$value->level.$post->id}))
						{{ ${'post_access_'.$value->level.$post->id} }}
					@endif
				>
					{{ $value->{'description_'.Session::get('lang')} }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.section_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
<?
	${'post_section_'.$post->section.$post->id} = 'SELECTED';
	$sections = Sections::all(); 
?>
		<select 
			id="section_{{ $post->id }}" 
			class="span6" 
			onchange="$('#save_button_{{ $post->id }}').attr('disabled', false);"
		>
			<option DISABLED value="0">{{ Lang::line('content.select_section_word')->get(Session::get('lang')) }}</option> 
			@foreach ($sections as $key => $value)
				<option  
					value="{{ $value->id }}"
					@if (isset(${'post_section_'.$value->id.$post->id}))
						{{ ${'post_section_'.$value->id.$post->id} }}
					@endif
				>
						{{ $value->title }}
				</option>
			@endforeach
		</select>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.language_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
<?
	${'post_lang_'.$post->lang.$post->id} = 'SELECTED';
	$langs = Langtable::all(); 
?>
		<select 
			id="lang_{{ $post->id }}" 
			class="span6" 
			onchange="$('#save_button_{{ $post->id }}').attr('disabled', false);"
		>
			<option DISABLED value="0">{{ Lang::line('content.select_lang_word')->get(Session::get('lang')) }}</option> 
			@foreach ($langs as $key => $value)
				<option  
					value="{{ $value->lang }}"
					@if (isset(${'post_lang_'.$value->lang.$post->id}))
						{{ ${'post_lang_'.$value->lang.$post->id} }}
					@endif
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

<? $json_save = '{"title": "\'+encodeURI($(\'#title_'.$post->id.'\').val())+\'", "text": "\'+encodeURI($(\'#text_'.$post->id.'\').html())+\'", "access": "\'+$(\'#post_access_'.$post->id.'\').val()+\'", "section": "\'+$(\'#section_'.$post->id.'\').val()+\'", "tags": "\'+encodeURI($(\'#tags_'.$post->id.'\').val())+\'", "lang": "\'+$(\'#lang_'.$post->id.'\').val()+\'"}'; ?>

		<button 
			id="save_button_{{ $post->id }}"
			class="btn"
			type="button"
			disabled="disabled" 
			onclick="showerp('<?= htmlspecialchars($json_save) ?>', '../admin/post_area/add', 'save_button_{{ $post->id }}', 'work_area', false, true); ">
				<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
		</button>
		<span id="status_{{ $post->id }}" class="btn disabled">
			@if(isset($status))
				{{ $status }}
			@endif
		</span>
	</div>
</div>

<hr />

<div class="row-fluid">
	<div class="span12">
		<div
			class="input-block-level"
			id="text_{{ $post->id }}" 
			rows="20" placeholder="{{ Lang::line('placeholders.text')->get(Session::get('lang')) }}">{{ $post->text }}</div>
	</div>
</div>
<script>
	$(function(){
		$('#text_{{ $post->id }}').redactor();
	});
</script>
<script>
	function save_btn(){
		showerp('<?= $json_save ?>', '../admin/post_area/add', 'save_button_{{ $post->id }}', 'work_area', false, false);
	}
</script>
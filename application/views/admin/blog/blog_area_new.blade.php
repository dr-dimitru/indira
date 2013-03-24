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
			id="title_{{ $post->id }}" 
			type="text"
			class="span6" 
			value="{{ $post->title }}" 
			oninput="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);"
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
			oninput="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);" 
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
			onchange="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);"
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
			onchange="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);"
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

<? $json_save = '{"title": "\'+encodeURI($(\'#title_'.$post->id.'\').val())+\'", "text": "\'+encodeURI($(\'#text_'.$post->id.'\').html())+\'", "access": "\'+$(\'#post_access_'.$post->id.'\').val()+\'", "tags": "\'+encodeURI($(\'#tags_'.$post->id.'\').val())+\'", "lang": "\'+$(\'#lang_'.$post->id.'\').val()+\'", "published": 0}'; ?>

<? $json_save_publish = '{"title": "\'+encodeURI($(\'#title_'.$post->id.'\').val())+\'", "text": "\'+encodeURI($(\'#text_'.$post->id.'\').html())+\'", "access": "\'+$(\'#post_access_'.$post->id.'\').val()+\'", "tags": "\'+encodeURI($(\'#tags_'.$post->id.'\').val())+\'", "lang": "\'+$(\'#lang_'.$post->id.'\').val()+\'", "published": 1}'; ?>

		<button 
			id="save_button_{{ $post->id }}"
			class="btn"
			type="button"
			disabled="disabled" 
			onclick="showerp('<?= htmlspecialchars($json_save) ?>', '{{ URL::to('admin/blog_area/add') }}', 'save_button_{{ $post->id }}', 'work_area', false, true); ">
				<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
		</button>
		<button 
			id="save_button_publish_{{ $post->id }}"
			class="btn btn-success"
			type="button"
			disabled="disabled" 
			onclick="showerp('<?= htmlspecialchars($json_save_publish) ?>', '{{ URL::to('admin/blog_area/add') }}', 'save_button_{{ $post->id }}', 'work_area', false, true); ">
				<i class="icon-save"></i> & <i class="icon-cloud-upload"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }} & {{ Lang::line('content.publish')->get(Session::get('lang')) }}
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
			rows="20" 
			placeholder="{{ Lang::line('placeholders.text')->get(Session::get('lang')) }}" 
			onkeypress="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);" 
		>{{ $post->text }}</div>
	</div>
</div>
<script>
	$(function(){
		$('#text_{{ $post->id }}').redactor();
	});
</script>
<script>
	function save_btn(){
		showerp('<?= $json_save ?>', '{{ URL::to("admin/blog_area/add") }}', 'save_button_{{ $post->id }}', 'work_area', false, false);
	}
</script>
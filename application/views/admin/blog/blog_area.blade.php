<h3>{{ stripslashes($post->title) }}
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
		<h6>{{ Lang::line('content.created_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<h6>{{ $post->created_at }}</h6>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.updated_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<h6>{{ $post->updated_at }}</h6>
	</div>
</div>

<div class="row-fluid">
	<div class="span4" style="text-align:right">
		<h6>{{ Lang::line('content.title_word')->get(Session::get('lang')) }}</h6>
	</div>
	<div class="span8">
		<input 
			id="title_{{ $post->id }}" 
			type="text"
			class="span6" 
			value="{{ htmlspecialchars(stripslashes($post->title)) }}" 
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
			value="{{ htmlspecialchars(stripslashes($post->tags)) }}" 
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
	$accessLevels = AccessLevels::all(); 
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
		<div class="row-fluid" style="margin-bottom: 5px">
			<div class="span12">
				<div class="btn-group">
					<button 
						id="edit_button_{{ $post->id }}"
						class="btn"
						type="button" 
						onclick="$('#text_{{ $post->id }}').redactor(); $('#edit_button_{{ $post->id }}').attr('disabled', 'disabled'); $('button[id^={{ htmlspecialchars('"save_button"') }}], #text_{{ $post->id }}').attr('disabled', false);">
							<i class="icon-pencil" style="color:#5bc0de"></i> {{ Lang::line('content.edit_word')->get(Session::get('lang')) }}
					</button>
					<a href="{{ URL::to('/blog/'.$post->id.'?edit=true') }}" class="btn btn-inverse"><i class="icon-lemon" style="color: rgb(255, 194, 0);"></i> {{ Lang::line('forms.edit_on_page')->get(Session::get('lang')) }}</a>
				</div>
			</div>
		</div>

		<div class="row-fluid" style="margin-bottom: 5px">
			<div class="span12">
				<div class="btn-group">
		<? $json_save = '{"id": "'.$post->id.'", "title": encodeURI($(\'#title_'.$post->id.'\').val()), "text": encodeURI($(\'#text_'.$post->id.'\').html()), "access": $(\'#post_access_'.$post->id.'\').val(), "tags": encodeURI($(\'#tags_'.$post->id.'\').val()), "lang": $(\'#lang_'.$post->id.'\').val(), "published": '.$post->published.'}'; ?>

				<button 
					id="save_button_{{ $post->id }}"
					class="ajax_save_button_{{ $post->id }} btn"
					type="button"
					disabled="disabled" 
					data-link="{{ URL::to('admin/blog_area/save') }}" 
					data-post="{{ htmlspecialchars($json_save) }}"
					data-out="work_area"
					data-restore="true" 
					data-load="super_logo" 
					data-prevent-follow="true"
				>
						<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
				</button>

			@if($post->published == 0)
				<? $json_save_publish = '{"id": "'.$post->id.'", "title": encodeURI($(\'#title_'.$post->id.'\').val()), "text": encodeURI($(\'#text_'.$post->id.'\').html()), "access": $(\'#post_access_'.$post->id.'\').val(), "tags": encodeURI($(\'#tags_'.$post->id.'\').val()), "lang": $(\'#lang_'.$post->id.'\').val(), "published": 1}'; ?>
				<button 
					id="save_button_publish_{{ $post->id }}"
					class="ajax_save_button_publish_{{ $post->id }} btn btn-success"
					type="button"
					disabled="disabled" 
					data-link="{{ URL::to('admin/blog_area/save') }}" 
					data-post="{{ htmlspecialchars($json_save_publish) }}"
					data-out="work_area"
					data-restore="true" 
					data-load="super_logo" 
					data-prevent-follow="true"
				>
						<i class="icon-save"></i> & <i class="icon-cloud-upload"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }} & {{ Lang::line('content.publish')->get(Session::get('lang')) }}
				</button>
			@else
				<? $json_save_publish = '{"id": "'.$post->id.'", "title": encodeURI($(\'#title_'.$post->id.'\').val()), "text": encodeURI($(\'#text_'.$post->id.'\').html()), "access": $(\'#post_access_'.$post->id.'\').val(), "tags": encodeURI($(\'#tags_'.$post->id.'\').val()), "lang": $(\'#lang_'.$post->id.'\').val(), "published": 0}'; ?>
				<button 
					id="save_button_publish_{{ $post->id }}"
					class="ajax_save_button_publish_{{ $post->id }} btn btn-danger"
					type="button"
					disabled="disabled" 
					data-link="{{ URL::to('admin/blog_area/save') }}" 
					data-post="{{ htmlspecialchars($json_save_publish) }}"
					data-out="work_area"
					data-restore="true" 
					data-load="super_logo" 
					data-prevent-follow="true"
				>
						<i class="icon-save"></i> & <i class="icon-minus-sign"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }} & {{ Lang::line('content.unpublish')->get(Session::get('lang')) }}
				</button>
			@endif
				</div>
				<span id="status_{{ $post->id }}" class="btn disabled">
					@if(isset($status))
						{{ $status }}
					@endif
				</span>
			</div>
		</div>
	</div>
</div>

<hr />

<div class="row-fluid">
	<div class="span12">
		<div
			class="input-block-level"
			id="text_{{ $post->id }}" 
			rows="20" 
			onkeypress="$('button[id^={{ htmlspecialchars('"save_button"') }}]').attr('disabled', false);"
		>{{ $post->text }}</div>
	</div>
</div>
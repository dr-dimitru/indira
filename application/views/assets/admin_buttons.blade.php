@if (Admin::check())
	<div class="edit_btns btn-group btn-group-vertical">
		<button 
			id="edit_button_{{ $post->id }}"
			class="btn btn-large"
			type="button" 
			onclick="$('#text_{{ $post->id }}').redactor(); $('#edit_button_{{ $post->id }}').attr('disabled', 'disabled'); $('#save_button_{{ $post->id }}, #cancel_button_{{ $post->id }}').attr('disabled', false);">
				<i class="icon-pencil" style="color:#5bc0de"></i> {{ Lang::line('content.edit_word')->get(Session::get('lang')) }}
		</button>
		<button 
			id="cancel_button_{{ $post->id }}"
			class="btn btn-large"
			type="button"
			disabled="disabled"  
			onclick="$('#text_{{ $post->id }}').destroyEditor(); $('#edit_button_{{ $post->id }}').attr('disabled', false); $('#save_button_{{ $post->id }}, #cancel_button_{{ $post->id }}').attr('disabled', 'disabled');">
				<i class="icon-remove-sign" style="color:#bd362f"></i> {{ Lang::line('content.cancel_word')->get(Session::get('lang')) }}
		</button>
		<button 
			id="save_button_{{ $post->id }}"
			class="btn btn-large"
			type="button"
			disabled="disabled" 
			onclick="save_btn();">
				<i class="icon-save" style="color:#5bb75b"></i> {{ Lang::line('content.save_word')->get(Session::get('lang')) }}
		</button>
		<a
			style="max-width: 160px"
			href="/admin" 
			id="indira_button"
			class="btn btn-large"
			type="button">
				<i class="icon-laptop"></i> {{ Lang::line('content.go_back_to_admin')->get(Session::get('lang')) }}
		</a>
	</div>
@endif
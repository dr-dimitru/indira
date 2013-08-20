
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="title">{{ $qrcode->title }}</h3>
</div>
<div class="modal-body scroll scroll-y">
	<div style="text-align:center">
		<img src="{{ $qrcode->url }}" />
	</div>
	
	<div class="well well-small">
		<small>{{ $qrcode->data }}</small>
	</div>

	<pre>{{ e('<img src="'.$qrcode->url.'" />') }}</pre>
</div>
<div class="modal-footer">
</div>
@layout('admin.cli.template')

<h3>
	<i class="icon-terminal"></i> {{ __('content.cli') }} 
</h3>

<hr>

@section('cli')

<div class="row-fluid">
	<div class="span12">

<pre class="cli" id="cli_window">
Please start typing in input below
Or type "help:commands" for help
Docs: <a href="http://laravel3.veliovgroup.com/docs/artisan/commands" target="_blank">Artisan Commands</a>

Use "up"/"down" arrows to navigate thru commands.

Please <strong> note: <u>all bundle artisan methods require write (777) permissions on folders used by installed bundle!</u></strong>
To avoid security issues use CLI via SSH as superuser.
</pre>

		<input id="cli_input" name="cli_input" type="text" class="cli span12" placeholder="help:commands" />

	</div>
</div>

@endsection
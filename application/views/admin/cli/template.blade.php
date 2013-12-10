@__yield('cli')
<script type="text/javascript">
	$(function(){

		var commands = [];
		var command_position = 0;
		commands.push('help:commands');

		$('#cli_input').keypress(function(event){

			if(event.which == 13) {
				
				showerp('{"command" : $(\'#cli_input\').val()}', '{{ action('admin.cli.action@run') }}', 'super_logo', 'cli_window', 'true', true, true, false, false, function(){

					commands.push($('#cli_input').val());
					command_position = commands.length - 1
					$('#cli_input').val('');
					$('#cli_window').append('<br />');

				});
			}
		});

		document.onkeydown = function(event){

			if(event.which == 38){


				if(command_position >= 0 && command_position < commands.length - 1){

					command_position = command_position + 1;
				}

				$('#cli_input').val(commands[command_position]);
			}

			if(event.which == 40){


				if(command_position > 0 && command_position <= commands.length - 1){

					command_position = command_position - 1;
				}

				$
				('#cli_input').val(commands[command_position]);
			}
		}
	});
</script>
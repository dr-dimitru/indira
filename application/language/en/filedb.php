<?php

return array(

	'filedb' 					=> 	'File DB',
	'summary' 					=> 	'Database Summary',
	'db_size' 					=> 	'Database size',
	'db_records' 				=> 	'Total records',
	'tables_word' 				=> 	'Tables',
	'table_word' 				=> 	'Table',
	'records_word' 				=> 	'Records',
	'size_word' 				=> 	'Size',
	'update_table' 				=> 	'Update Table within model',
	'default_value' 			=> 	'Default Value',
	'column' 					=> 	'Column Name',
	'table_name' 				=> 	'Table Name',
	'table_name_desc' 			=> 	'No spaces, no underscores, no capital letters, please',
	'add_column' 				=> 	'Add one more column',
	'model_word' 				=> 	'Model',
	'rename_word' 				=> 	'Rename',
	'new_name_word' 			=> 	'New name',
	'dump_word' 				=> 	'Download FileDB dump',

	'encrypt_word' 				=> 	'Encrypt',
	'encrypted_word'			=> 	'Encrypted',
	'encrypted_action'			=> 	'Table <strong>:t<strong> is encrypted',
	'encryption_annotation' 	=>	'This process may take up to the <span style="color:#bd362f">one minute!</span> Please <span style="color:#bd362f">do not reload</span> or <span style="color:#bd362f">leave</span> this page<span style="color:#bd362f">!</span> It depends on your <span style="color:#bd362f">server performance</span>.',
	
	'decrypt_word' 				=> 	'Decrypt',
	'decrypted_action'			=> 	'Table <strong>:t<strong> is decrypted',

	'truncate_table'			=> 	'Truncate table',
	'truncate_notification'		=> 	'all record from table',
	'truncated_table'			=> 	'Table <strong>:t</strong> is successfully truncated',

	'drop_table'				=> 	'Drop table',
	'drop_notification'			=> 	'full table',
	'dropped_table'				=> 	'Table <strong>:t</strong> is dropped',

	'table_updated_notification'=> 	'Table <strong>:t</strong> successfully updated!',
	'uneditable_model' 			=> 	'This model is uneditable as you have additional methods in it. Please go to: <code>application/models/:t.php</code> to edit model',



	'promo' 					=> 	'
<h6>Thank you using Filedb</h6>
<p>
	Filedb is noSQL file-oriented database.<br>
	Filedb is based on php files and arrays.<br>
	Filedb is lighter and faster on <strong>small projects</strong> than other noSQL or SQL DBs<br>
</p>
<p>
	We hope you\'ll enjoy using Filedb as driver for your content, cause:
		<ul>
			<li>When installing Indira CMS you don\'t need to take care about dumping, exporting, importing, installing, connecting your DB - <strong>Filedb is working out of box</strong> as soon as you upload your project on server</li>
			<li>Easy dumping or reserve copying content</li>
			<li>JSON ready - All data saved in arrays and already URI (RAW) encoded. Just do <code>json_encode()</code></li>
			<li>Laravel friendly - Filedb supports most of Laravel\'s fluent queries and Eloquent ready</li>
		<ul>
</p>',
);
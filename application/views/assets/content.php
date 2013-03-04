<?php
echo '<pre>';
	foreach ($content as $key => $value) {
echo '\''.$key.'\' => \''.addslashes(htmlspecialchars($value)).'\',<br>';
	}
echo '</pre>';

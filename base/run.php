<?php
	$database_update = true;
	$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
	require '../config.php';
	print_r($mysql);

	$queries_str = file_get_contents('port-current.sql');
	$queries = explode(';', $queries_str);

	foreach ($queries as $query) 
	{
		mysqli_query($mysql, $query);
	}

?>
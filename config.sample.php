<?php
	
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' and !isset($database_update))
	{
		$host = 'localhost';
		$database = 'port';
		$user = 'root';
		$password = '';
	}
	else
	{
		$host = 'mysql.hostinger.co.uk';
		$database = '';
		$user = '';
		$password = '';		
	}

	$charset = 'utf8';
	
	$pdo = $dbh = new PDO("mysql:host=$host;dbname=$database", $user, $password, 
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset"));
	if(!$dbh)
	{
		echo "We've got issue with database MySQL PDO connection.";
		exit;
	}

	$mysql = mysqli_connect($host, $user, $password, $database);
	mysqli_set_charset($mysql,'utf8');
	if(!$mysql)
	{
		echo "We've got issue with database MySQL connection.";
		exit;
	}

	$array = explode('/', $_SERVER['SCRIPT_NAME']);
	if (count($array) > 1)
		$addition_url = '/' . $array[0];
	$base_url = 'http://' . $_SERVER['HTTP_HOST'] . $addition_url . '/';
	
?>
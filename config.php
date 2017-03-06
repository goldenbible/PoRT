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
		/*$host = '184.168.47.17';
		$database = 'port_17';
		$user = 'u_port_17';
		$password = 'T7jb0%h7';*/
		$host = 'mysql.hostinger.co.uk';
		$database = 'u753511775_port';
		$user = 'u753511775_php';
		$password = 'CXOwnecx7kZj';		
	}

	$charset = 'utf8';
	
	$dbh = new PDO("mysql:host=$host;dbname=$database", $user, $password, 
		array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset"));
	if(!$dbh)
	{
		echo "Whoops. We've got issue with database MySQL PDO connection.";
		exit;
	}

	$mysql = mysqli_connect($host, $user, $password, $database);
	mysqli_set_charset($mysql,'utf8');
	if(!$mysql)
	{
		echo "Whoops. We've got issue with database MySQL connection.";
		exit;
	}
?>
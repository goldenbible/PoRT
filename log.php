<?php

	// Super log for the site
	// use it everywhere =]
	
	$datetime = new Datetime();

	if (!file_exists('./logs/'))
		mkdir('logs');

	$log_file = fopen(pathinfo(__FILE__)['dirname'] . '/logs/log.' . $datetime -> format('Y-m-d') . '.txt', 'a');

	$slog_file = fopen(pathinfo(__FILE__)['dirname'] . '/logs/slog.' . $datetime -> format('Y-m-d') . '.txt', 'a');

	function log_msg($message)
	{
		if(is_array($message)) $message = implode(', ', $message);
		global $log_file;
		global $datetime;
		fwrite($log_file, $datetime -> format('H:i:s') . ' ' . $message . PHP_EOL);
	}

	function slog_msg($message)
	{
		if(is_array($message)) $message = implode(', ', $message);
		global $slog_file;
		global $datetime;
		fwrite($slog_file, $datetime -> format('H:i:s') . ' ' . $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['HTTP_USER_AGENT'] . ' ' . $message . PHP_EOL);
	}
?>
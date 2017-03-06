<?php
	$timezone = new DateTimezone(date_default_timezone_get());
	$user_timezone = new DateTimezone('Europe/London');
	print_r( $timezone -> getLocation() );
	$date = new DateTime();
	print "Here is "; print_r( $date );
	print_r( $timezone -> getOffset($date) );
	$date -> setTimezone($user_timezone);
	print "In London: "; print_r($date);
	print("<br /><br /><br />");
	$abr = DateTimezone::listIdentifiers(); //listAbbreviations();
	print_r($abr);
?>
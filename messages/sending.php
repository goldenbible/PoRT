<?php
	$row = array(
		'from_user_id' => $_SESSION['uid'],
		'to_user_id' => $_POST['to_user_id'],
		'subject' => $_POST['subject'],
		'message' => $_POST['message']
				 );
	$statement = $dbh -> prepare('insert into messages (from_user_id, to_user_id, subject, message, inserted) values (:from_user_id, :to_user_id, :subject, :message, now());');
	$result = $statement -> execute($row);

	if ($result)
	{
		$msg_type = 'success';
		$message = 'Message was successfully sent.';
	}
	else
	{
		$msg_type = 'danger';
		$message = 'We\'ve got issue with message sending. Please contact support.';
	}
?>
<h1><a href="./?menu=messages_inbox">Messages</a> :: Send</h1>
<?php
	if (isset($msg_type))
	{
		echo '<p class="alert alert-' . $msg_type . '">' . $message . '</p>';
	}
?>
<p><a href="./?menu=messages_inbox">Return to Inbox</a></p>
<p><a href="./?menu=messages_sent">Open Sent Messages</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=messages_inbox">
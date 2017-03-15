<?php
	
	if(!isset($_POST['messages'])) 
		echo 'What are you doing here genius? Get out!';
	else
	{
		$messages = $_POST['messages'];
		foreach ($messages as $message) 
		{
			$row = array(
				'to_user_id' => $_SESSION['uid'],
				'message_id' => $message
						 );
			$statement = $dbh -> prepare('update messages set when_read = null where to_user_id = :to_user_id and id = :message_id and when_read is not null');
			$result = $statement -> execute($row);

			if ($result)
			{
				$msg_type = 'success';
				$message = 'Message[s] was marked as unread.';
			}
			else
			{
				$msg_type = 'danger';
				$message = 'We\'ve got issue with messages marking. Please contact support.';
			}
		}

	}
?>
<h1><a href="./?menu=messages_inbox">Messages</a> :: <a href="./?menu=messages_inbox">Inbox</a> :: Mark as Read</h1>
<?php
	if (isset($msg_type))
	{
		echo '<p class="alert alert-' . $msg_type . '">' . $message . '</p>';
	}
?>
<p><a href="./?menu=messages_inbox">Return to Inbox</a></p>
<p><a href="./?menu=messages_sent">Open Sent Messages</a></p>
<meta http-equiv="refresh" content="1;url=./?menu=messages_inbox">
<?php
	
	if(!isset($_POST['messages'])) 
		echo 'What are you doing here genius? Get out!';
	else
	{
		$messages = $_POST['messages'];
		foreach ($messages as $message) 
		{
			$row = array(
				'from_user_id' => $_SESSION['uid'],
				'message_id' => $message
						 );
			$statement = $dbh -> prepare('update messages set from_deleted = now()
											where from_user_id = :from_user_id and id = :message_id and from_deleted is null');
			$result = $statement -> execute($row);

			if ($result) $message = "Message[s] was deleted.";
			else $message = "Whoops. We've got issue with messages deleting. Please contact support.";
		}

	}
?>
<h1><a href="./?menu=messages_inbox">Messages</a> :: <a href="./?menu=messages_sent">Sent</a> :: Delete</h1>
<p><?=$message;?></p>
<p><a href="./?menu=messages_sent">Return to Sent Messages</a></p>
<p><a href="./?menu=messages_inbox">Open Inbox</a></p>
<meta http-equiv="refresh" content="1;url=./?menu=messages_sent">
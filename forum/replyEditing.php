<?php

	$statement = $dbh -> prepare('select * from forum_replies where id = :id');
	$statement -> execute(array('id' => $_POST['reply_id'] ));
	$reply_row = $statement -> fetch();

	if($_SESSION['uid'] == $reply_row['user_id'] or $_SESSION['role_id'] < 3)
	{

		$row = array(
			'id' => $_POST['reply_id'],
			'entry' => $_POST['entry'],
			'user_id' => $_SESSION['uid']
					 );
		$statement = $dbh -> prepare('update forum_replies set entry = :entry, updated = now(), updated_by = :user_id where id = :id');
		$statement -> execute($row);

		if ($statement) $message = "Post was successfully saved.";
		else $message = "Whoops. We've got issue with forum. Please contact support.";
	}
	else $message = 'You have no permission to edit this post.';
?>
<h1>Edit Reply</h1>
<p><?=$message;?></p>
<p><a href="./?menu=forum_topic&id=<?=$reply_row['topic_id'];?>">Return to the Topic</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=forum_topic&id=<?=$reply_row['topic_id'];?>">
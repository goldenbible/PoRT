<?php
	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $_GET['id'] ));
	$forum_topic_row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $forum_topic_row['subforum_id'] ));
	$subforum_row = $statement -> fetch();

	$statement = $dbh -> prepare('select count(id) from forum_replies where topic_id = :id');
	$statement -> execute(array('id' => $_GET['id'] ));
	$reply_count_row = $statement -> fetch();

	if(($_SESSION['uid'] == $forum_topic_row['user_id']
		and $reply_count_row['count(id)'] == 0) 
		or $_SESSION['role_id'] < 3)
	{
		$statement = $dbh -> prepare('update forum_topics set closed = now(), closed_by = :user_id where id = :id');
		$result = $statement -> execute(array('id' => $_GET['id'], 'user_id' => $_SESSION['uid'] ));

		if(!$result)
		{
			$msg_type = 'danger';
			$message = 'We\'ve got issue with password reset. Sorry. Please, contact support.';
		}
		else 
		{
			$msg_type = 'success';
			$message = 'Topic was closed.';
		}
	}
	else 
	{
		$msg_type = 'danger';
		$message = 'You have no permission to close this topic.';
	}
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>"><?=$subforum_row['title'];?></a> :: <a href="./?menu=forum_topic&id=<?=$forum_topic_row['id'];?>"><?=$forum_topic_row['title'];?></a> :: Close Topic</h1>
<br />
<?php
	if (isset($msg_type))
	{
		echo '<p class="alert alert-' . $msg_type . '">' . $message . '</p>';
	}
?>
<p><a href="./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>">Return to the Subforum</a></p>
<p><a href="./?menu=forum">Return to the Forum</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>">
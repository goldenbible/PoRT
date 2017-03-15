<?php
	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $_GET['id'] ));
	$forum_topic_row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $forum_topic_row['subforum_id'] ));
	$subforum_row = $statement -> fetch();


	if($_SESSION['role_id'] < 3)
	{
		$statement = $dbh -> prepare('update forum_topics set closed = null, opened_by = :user_id where id = :id');
		$result = $statement -> execute(array('id' => $_GET['id'], 'user_id' => $_SESSION['uid'] ));

		if(!$result)
		{
			$msg_type = 'danger';
			$message = 'We\'ve got issue with password reset. Sorry. Please, contact support.';
		}
		else
		{
			$msg_type = 'success';
			$message = 'Topic was opened.';
		}
	}
	else 
	{
		$msg_type = 'danger';
		$message = "You have no permission to open this topic.";
	}
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>"><?=$subforum_row['title'];?></a> :: <a href="./?menu=forum_topic&id=<?=$forum_topic_row['id'];?>"><?=$forum_topic_row['title'];?></a> :: Open Topic</h1>
<br />
<?php
	if (isset($msg_type))
	{
		echo '<p class="alert alert-' . $msg_type . '">' . $message . '</p>';
	}
?>
<p><a href="./?menu=forum_topic&id=<?=$forum_topic_row['id'];?>">Return to the Topic</a></p>
<p><a href="./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>">Return to the Subforum</a></p>
<p><a href="./?menu=forum">Return to the Forum</a></p>
<meta http-equiv="refresh" content="1; ./?menu=forum_topic&id=<?=$forum_topic_row['id'];?>">
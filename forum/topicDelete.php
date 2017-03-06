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
		$statement = $dbh -> prepare('update forum_topics set deleted = now(), deleted_by = :user_id where id = :id');
		$result = $statement -> execute(array('id' => $_GET['id'], 'user_id' => $_SESSION['uid'] ));
		
		if(!$result)
		{
			$message = "Whoops. We've got issue with password reset. Sorry. Please, contact support.";
		}
		else $message = 'Topic was deleted.';
	}
	else $message = "You have no permission to delete this topic.";
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>"><?=$subforum_row['title'];?></a> :: <?=$forum_topic_row['title'];?></h1>
<br />
<p><?=$message;?></p>
<p><a href="./?menu=subforum&id=<?=$forum_topic_row['subforum_id'];?>">Return to the Subforum</a></p>
<p><a href="./?menu=forum">Return to the Forum</a></p>
<?php

	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $_POST['topic_id'] ));
	$row = $statement -> fetch();

	if($_SESSION['uid'] == $row['user_id'] or $_SESSION['role_id'] < 3)
	{

		$row = array(
			'id' => $_POST['topic_id'],
			'title' => $_POST['title'],
			'post' => $_POST['post']
					 );
		$statement = $dbh -> prepare('update forum_topics set title = :title, post = :post, updated = now() where id = :id');
		$result = $statement -> execute($row);

		if ($result) 
		{
			$msg_type = 'success';
			$message = 'Topic was successfully saved.';
		}
		else 
		{
			$msg_type = 'danger';
			$message = 'We\'ve got issue with forum. Please contact support.';
		}
	}
	else 
	{
		$msg_type = 'danger';
		$message = 'You have no permission to edit this topic.';
	}
?>
<h1>Edit Topic</h1>
<?php
	if (isset($msg_type))
	{
		echo '<p class="alert alert-' . $msg_type . '">' . $message . '</p>';
	}
?>
<p><a href="./?menu=forum_topic&id=<?=$_POST['topic_id'];?>">Return to the Topic</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=forum_topic&id=<?=$_POST['topic_id'];?>">
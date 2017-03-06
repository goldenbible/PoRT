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

		if ($result) $message = "Topic was successfully saved.";
		else $message = "Whoops. We've got issue with forum. Please contact support.";
	}
	else $message = 'You have no permission to edit this topic.';
?>
<h1>Edit Topic</h1>
<p><?=$message;?></p>
<p><a href="./?menu=forum_topic&id=<?=$_POST['topic_id'];?>">Return to the Topic</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=forum_topic&id=<?=$_POST['topic_id'];?>">
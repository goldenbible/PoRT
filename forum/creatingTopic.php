<?php

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $_POST['subforum_id']));
	$subforum_row = $statement -> fetch();

	$statement = $dbh -> prepare('select is_read_only from forums where id = :forum_id');
	$statement -> execute(array('forum_id' => $subforum_row['forum_id']));
	$forum_row = $statement -> fetch();

if ((($subforum_row['is_read_only'] != '1') and 
			($forum_row['is_read_only'] != '1') and $_SESSION['uid'] > -1)
			or ($_SESSION['role_id'] <= 2))
	{
		$row = array(
			'user_id' => $_SESSION['uid'],
			'subforum_id' => $_POST['subforum_id'],
			'title' => $_POST['title'],
			'post' => $_POST['post']
					 );
		$statement = $dbh -> prepare('insert into forum_topics (user_id, subforum_id, title, post, inserted) values (:user_id, :subforum_id, :title, :post, now());');
		$result = $statement -> execute($row);

		if ($result) $message = "Topic was successfully created.";
		else { $message = "Whoops. We've got issue with topic creating on forum. Please contact support."; print_r($statement->errorInfo());}
	}
	else $message = 'What are you doing here genius? Get out!';
?>
<h1>Create Topic</h1>
<p><?=$message;?></p>
<p><a href="./?menu=subforum&id=<?=$_POST['subforum_id'];?>">Return to the Subforum</a></p>
<p><a href="./?menu=forum">Return to the Forum</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=subforum&id=<?=$_POST['subforum_id'];?>">
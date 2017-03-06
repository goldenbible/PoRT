<?php
	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $_POST['topic_id']));
	$row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $row['subforum_id']));
	$subrow = $statement -> fetch();

	$statement = $dbh -> prepare('select is_read_only from forums where id = :forum_id');
	$statement -> execute(array('forum_id' => $subrow['forum_id']));
	$forum_row = $statement -> fetch();
	
	$statement = $dbh -> prepare('select role_id from users where id = :user_id');
	$statement -> execute(array('user_id' => $_SESSION['uid']));
	$user_row = $statement -> fetch();


	if ((($subrow['is_read_only'] != '1') and 
			($forum_row['is_read_only'] != '1'))
			or ($user_row['role_id'] <= 2))
	{

?>
		<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subrow['id'];?>"><?=$subrow['title'];?> :: <a href="./?menu=forum_topic&id=<?=$_POST['topic_id'];?>&page=<?=$_POST['page'];?>"><?=$row['title'];?></a> :: Reply</h1>
<?php
		$statement = $dbh -> prepare('insert into forum_replies (topic_id, user_id, entry, inserted) values (:topic_id, :user_id, :entry, now());');
		$row = array('topic_id' => $_POST['topic_id'], 'user_id' => $_SESSION['uid'],
						'entry' => $_POST['entry']);
		$result = $statement -> execute($row);

		if(!$result)
		{
			echo "<p>Whoops. We've got issue with password reset. Sorry. Please, contact support.</p>";
		}
		else echo "<p>Your reply was sent.</p>";
	}
	else
	{
		echo '<p>Shoo! You shouldn`t be here. Get out.</p>';
	}
?>
<p><a href="./?menu=forum_topic&id=<?=$_POST['topic_id'];?>&page=<?=$_POST['page'];?>">Return to the Topic</a></p>
<p><a href="./?menu=subforum&id=<?=$subrow['id'];?>">Return to the Forum</a></p>
<meta http-equiv="refresh" content="2;url=./?menu=forum_topic&id=<?=$_POST['topic_id'];?>&page=<?=$_POST['page'];?>">
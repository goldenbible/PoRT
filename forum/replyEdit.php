<?php


	$statement = $dbh -> prepare('select * from forum_replies where id = :id');
	$statement -> execute(array('id' => $_GET['id']));
	$forum_reply_row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $forum_reply_row['topic_id']));
	$topic_row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $topic_row['subforum_id']));
	$subforum_row = $statement -> fetch();
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subrow['id'];?>"><?=$subforum_row['title'];?></a> :: <a href="./?menu=forum_topic&id=<?=$_GET['id'];?>"><?=$topic_row['title'];?></a> :: Edit Reply</h1><br />
<form method="post">
	<div class="row">
		<div class="col-md-2">
			<p>Post</p>
		</div>
		<div class="col-md-2">
			<textarea name="entry" maxlength="5000" cols="80" rows="20"><?=$forum_reply_row['entry'];?></textarea>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" name="menu" value="forum_replyEditing">
			<input type="hidden" name="reply_id" value="<?=$_GET['id']?>">
			<!-- TO DO: check email by pattern-->
			<p align="center"><input type="submit" name="submit" value="Save" /></p>
		</div>
	</div>
</form>
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
	<div class="form-group">
			<label for="postField">Post</label>
			<textarea name="entry" class="form-control" maxlength="5000" rows="10" id="postField"><?=$forum_reply_row['entry'];?></textarea>
	</div>

	<input type="hidden" name="menu" value="forum_replyEditing">
	<input type="hidden" name="reply_id" value="<?=$_GET['id']?>">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Save" />
</form>
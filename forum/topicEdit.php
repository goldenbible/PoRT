<?php

	$statement = $dbh -> prepare('select * from forum_topics where id = :id');
	$statement -> execute(array('id' => $_GET['id']));
	$row = $statement -> fetch();

	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $row['subforum_id']));
	$subrow = $statement -> fetch();
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$subrow['id'];?>"><?=$subrow['title'];?></a> :: <a href="./?menu=forum_topic&id=<?=$_GET['id'];?>"><?=$row['title'];?></a> :: Edit Topic</h1><br />
<form method="post">
	<div class="form-group">
			<label for="titleField">Title</label>
			<input type="text" class="form-control" name="title" maxlength="100" size="77" value="<?=$row['title'];?>" id="titleField">
	</div>
	<div class="form-group">
			<label for="postField">Post</label>
			<textarea class="form-control" name="post" maxlength="5000" cols="80" rows="10" id="postField"><?=$row['post'];?></textarea>
	</div>

	<input type="hidden" name="menu" value="forum_topicEditing">
	<input type="hidden" name="topic_id" value="<?=$_GET['id']?>">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Save" />
</form>
<?php
	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $_GET['subforum_id']));
	$row = $statement -> fetch();
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$row['id'];?>"><?=$row['title'];?></a> :: Create Topic</h1>
<form method="post">
	<div class="form-group">
			<label for="titleField">Subject</label>
			<input type="text" class="form-control" name="title" maxlength="100" id="titleField">
	</div>
	<div class="form-group">
			<label for="postField">Post</label>
			<textarea name="post" class="form-control" rows="10" maxlength="5000" id="postField"></textarea>
	</div>

	<input type="hidden" name="menu" value="forum_creatingTopic">
	<input type="hidden" name="subforum_id" value="<?=$_GET['subforum_id']?>">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Create Topic" />
</form>
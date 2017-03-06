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
	<div class="row">
		<div class="col-md-2">
			<p>Title</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="title" maxlength="100" size="77" value="<?=$row['title'];?>">
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<p>Post</p>
		</div>
		<div class="col-md-2">
			<textarea name="post" maxlength="5000" cols="80" rows="20"><?=$row['post'];?></textarea>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" name="menu" value="forum_topicEditing">
			<input type="hidden" name="topic_id" value="<?=$_GET['id']?>">
			<!-- TO DO: check email by pattern-->
			<p align="center"><input type="submit" name="submit" value="Save" /></p>
		</div>
	</div>
</form>
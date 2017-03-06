<?php
	$statement = $dbh -> prepare('select * from subforums where id = :id');
	$statement -> execute(array('id' => $_GET['subforum_id']));
	$row = $statement -> fetch();
?>
<h1><a href="./?menu=forum">Forum</a> :: <a href="./?menu=subforum&id=<?=$row['id'];?>"><?=$row['title'];?></a> :: Create Topic</h1>
<form method="post">
	<div class="row">
		<div class="col-md-2">
			<p>Title</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="title" maxlength="100" size="77">
		</div>
	</div>
	<div class="row">
		<div class="col-md-2">
			<p>Post</p>
		</div>
		<div class="col-md-2">
			<textarea name="post" maxlength="5000" cols="80" rows="20"></textarea>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" name="menu" value="forum_creatingTopic">
			<input type="hidden" name="subforum_id" value="<?=$_GET['subforum_id']?>">
			<!-- TO DO: check email by pattern-->
			<p align="center"><input type="submit" name="submit" value="Create Topic" /></p>
		</div>
	</div>
</form>
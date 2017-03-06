<h1><a href="./?menu=messages_inbox">Messages</a> :: <a href="./?menu=messages_inbox">Inbox</a> :: Read</h1><br />

<?php
	$statement = $dbh -> prepare('select msg.subject, msg.message, u.nickname, msg.from_user_id from messages msg
									join users u on u.id = msg.from_user_id
								where msg.id = :message_id and to_user_id = :user_id');
	$statement -> execute(array('user_id' => $_SESSION['uid'], 'message_id' => $_GET['id']));
	$message_row = $statement -> fetch();

	$statement = $dbh -> prepare('update messages set `when_read` = now() where `when_read` is null and id = :message_id and to_user_id = :user_id');
	$result = $statement -> execute(array('user_id' => $_SESSION['uid'], 'message_id' => $_GET['id']));

	if (!$result){ echo "<p>Whoops. We've got issue with reading messages. Please contact support.</p>";
	print_r($statement -> errorInfo());}
?>
	<div class="row">
		<div class="col-md-3">
			<p>From</p>
		</div>
		<div class="col-md-3">
			<p><a href="./?menu=user_profile&id=<?=$message_row['from_user_id'];?>"><?=$message_row['nickname'];?></a></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<p>Subject</p>
		</div>
		<div class="col-md-3">
			<p><b><?=$message_row['subject'];?></b></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<p>Message</p>
		</div>
		<div class="col-md-3">
			<p><?=prepare_post($message_row['message']);?></p>
		</div>
	</div>

<h3>Reply</h3>
<hr />
<br />
<form method="post">
	<div class="row">
		<div class="col-md-3">
			<p>To</p>
		</div>
		<div class="col-md-3">
			<input type="hidden" name="to_user_id" value="<?=$message_row['from_user_id'];?>">
			<input type="text" name="nickname" value="<?=$message_row['nickname'];?>" readonly="1" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<p>Subject</p>
		</div>
		<div class="col-md-3">
			<input type="text" name="subject" value="<?=$message_row['subject'];?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<p>Message</p>
		</div>
		<div class="col-md-3">
			<textarea name="message" cols="50" rows="10"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<input type="hidden" name="menu" value="messages_sending">
			<p align="center"><input type="submit" name="submit" value="Send" /></p>
		</div>
	</div>	
</form>
<h1>Messages :: Send</h1><br />
<?php
	$statement = $dbh -> prepare('select id, nickname from users where id = :user_id');
	$statement -> execute(array('user_id' => $_REQUEST['id']));
	$user_row = $statement -> fetch();
?>
<form method="post">
	<div class="form-group">
			<label for="toUserField">To</label>
			<input type="hidden" name="to_user_id" value="<?=$user_row['id'];?>">
			<input type="text" class="form-control" name="nickname" value="<?=$user_row['nickname'];?>" readonly="1" id="toUserField"/>
	</div>
	<div class="form-group">
			<label for="subjectField">Subject</label>
			<input type="text" class="form-control" name="subject" value="<?php if(isset($_REQUEST['subject'])) echo $_REQUEST['subject']; ?>" id="subjectField"/>
	</div>
	<div class="form-group">
			<label for="messageField">Message</label>
			<textarea name="message" class="form-control" rows="10" id="messageField"></textarea>
	</div>
	<input type="hidden" name="menu" value="messages_sending">
	<input type="submit" class="btn btn-default form-control" name="submit" value="Send" />
</form>
<h1>Messages :: Send</h1><br />
<?php
	$statement = $dbh -> prepare('select id, nickname from users where id = :user_id');
	$statement -> execute(array('user_id' => $_REQUEST['id']));
	$user_row = $statement -> fetch();
?>
<form method="post">
	<div class="row">
		<div class="col-md-3">
			<p>To</p>
		</div>
		<div class="col-md-3">
			<input type="hidden" name="to_user_id" value="<?=$user_row['id'];?>">
			<input type="text" name="nickname" value="<?=$user_row['nickname'];?>" readonly="1" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<p>Subject</p>
		</div>
		<div class="col-md-3">
			<input type="text" name="subject" value="<?php if(isset($_REQUEST['subject'])) echo $_REQUEST['subject']; ?>" />
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
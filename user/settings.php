<?php
	$statement = $dbh -> prepare('select * from users where id = :id');
	$statement -> execute(array('id' => $_SESSION['uid']));
	$user_row = $statement -> fetch();
?>
<h1>Settings</h1>
<br />
<form method="post">
	<div class="form-group">
			<label for="nicknameField">Nickname</label>
			<input type="text" class="form-control" name="nickname" value="<?=$user_row['nickname'];?>" id="nicknameField">
	</div>

	<div class="form-group">
			<label for="fullNameField">Full Name</label>
			<input type="text" class="form-control" name="full_name" value="<?=$user_row['full_name'];?>" id="fullNameField">
	</div>

	<div class="form-group">
			<label for="timezoneField">Timezone</label>
			<select name="timezone" class="form-control" id="timezoneField">
				<?php
					$timezones = DateTimezone::listIdentifiers();
					foreach ($timezones as $item) 
					{
						if ($item == $user_row['timezone'])
							echo '<option value="' . $item . '" selected>' . $item . '</option>';
						else
							echo '<option value="' . $item . '">' . $item . '</option>';
					}
				?>
			</select>
	</div>	
	
	<div class="form-group">
			<label for="emailField">E-Mail</label>
			<input type="text" class="form-control" name="email" value="<?=$user_row['email'];?>" id="emailField">
	</div>

	<div class="form-group">
			<label for="passwordField">Password</label>
			<input type="password" class="form-control" name="password" maxlength="16"  value="" id="passwordField">
	</div>

	<div class="form-group">
			<label for="repeatPasswordField">Repeat Password</label>
			<input type="password" class="form-control" name="password_repeat" maxlength="16" value="" id="repeatPasswordField">
	</div>


	<div class="form-group">
			<label for="currentPasswordField">Current Password</label>
			<input type="password" class="form-control" name="current_password" maxlength="16" value="" title="Fill this field if you wanna change the password" id="currentPasswordField">
	</div>

	<div class="form-group">
			<label for="secretQuestionField">Secret Question</label>
			<input type="text" class="form-control" name="secret_question" value="<?=$user_row['secret_question'];?>" id="secretQuestionField">
	</div>

	<div class="form-group">
			<label for="secretAnswerField">Secret Answer</label>
			<input type="text" class="form-control" name="secret_answer" value="<?=$user_row['secret_answer'];?>" id="secretAnswerField">
	</div>

	<input type="hidden" name="menu" value="user_saveSettings">
	<!-- TO DO: check email by pattern-->
	<input type="submit" class="btn btn-default form-control" name="submit" value="Save" />


</form>
<h1>Sign Up</h1>
<br />
<form method="post">
	<div class="form-group">
			<label for="nicknameField">Nickname</label>
			<input class="form-control" type="text" name="nickname" id="nicknameField">
	</div>

	<div class="form-group">
			<label for="fullNameField">Full Name</label>
			<input class="form-control" type="text" name="full_name" id="fullNameField">
	</div>

	<div class="form-group">
			<label for="timezoneField">Timezone</label>
			<select class="form-control" name="timezone" id="timezoneField">
				<?php
					$timezones = DateTimezone::listIdentifiers();
					foreach ($timezones as $item) 
					{
						if ($item == 'UTC')
						echo '<option value="' . $item . '" selected>' . $item . '</option>';
					else
						echo '<option value="' . $item . '">' . $item . '</option>';
					}
				?>
			</select>
	</div>	
	
	<div class="form-group">
			<label for="emailField">E-Mail</label>
			<input class="form-control" type="text" name="email" id="emailField">
	</div>

	<div class="form-group">
			<label for="passwordField">Password</label>
			<input class="form-control" type="password" name="password" maxlength="16" id="passwordField">
	</div>

	<div class="form-group">
			<label for="repeatPasswordField">Repeat Password</label>
			<input class="form-control" type="password" name="password_repeat" maxlength="16" id="repeatPasswordField">
	</div>

	<p class="alert alert-warning">You are not able to reset password by email now. Be sure that you filled and remembered "Secret Question" and "Secret Answer" fields.</p>

	<div class="form-group">
			<label for="secretQuestionField">Secret Question</label>
			<input class="form-control" type="text" name="secret_question" id="secretQuestionField">
	</div>

	<div class="form-group">
			<label for="secretAnswerField">Secret Answer</label>
			<input class="form-control" type="text" name="secret_answer" id="secretAnswerField">
	</div>

	<div class="form-group">
			<label for="possibleRoleField">What you plan to do in community?</label>
			<select class="form-control" name="possible_role" id="possibleRoleField">
				<option value="programming">Programming</option>
				<option value="suggesting">Suggesting</option>
				<option value="hanging_out">Hanging out</option>
			</select>
	</div>

	<input type="hidden" name="menu" value="registration">
	<!-- TO DO: check email by pattern-->
	<input class="btn btn-default form-control" type="submit" name="submit" value="Sign Up" />

</form>
<h1>Sign Up</h1>
<br />
<form method="post">
	<div class="row">
		<div class="col-md-2">
			<p>Nickname</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="nickname">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Full Name</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="full_name">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Timezone</p>
		</div>
		<div class="col-md-2">
			<select name="timezone">
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
	</div>	
	
	<div class="row">
		<div class="col-md-2">
			<p>E-Mail</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="email">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Password</p>
		</div>
		<div class="col-md-2">
			<input type="password" name="password" maxlength="16">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Repeat Password</p>
		</div>
		<div class="col-md-2">
			<input type="password" name="password_repeat" maxlength="16">
		</div>
	</div>

	<br />
	<div class="row">
		<div class="col-md-12">
			<p class="alert">Site of PoRT community at that moment doesn't provide restoring passwords by e-mail, please, make sure that you remembered secret question and answer.</p>
		</div>
	</div>


	<div class="row">
		<div class="col-md-2">
			<p>Secret Question</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="secret_question">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>Secret Answer</p>
		</div>
		<div class="col-md-2">
			<input type="text" name="secret_answer">
		</div>
	</div>

	<div class="row">
		<div class="col-md-2">
			<p>What you plan to do in community?</p>
		</div>
		<div class="col-md-2">
			<select name="possible_role">
				<option value="programming">Programming</option>
				<option value="suggesting">Suggesting</option>
				<option value="hanging_out">Hanging out</option>
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<input type="hidden" name="menu" value="registration">
			<!-- TO DO: check email by pattern-->
			<p align="center"><input type="submit" name="submit" value="Sign Up" /></p>
		</div>
	</div>


</form>
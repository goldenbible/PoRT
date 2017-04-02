<h1>Sign In</h1>
<?php
	if(isset($message))
		echo '<p class="alert alert-danger">' . $message . '. <br /><a class="alert-link" href="./?menu=auth_resetPassword&reset_email=' .$reset_email . '">Reset Password by "Secret Question"</a>
	<br /><a class="alert-link" href="./?menu=user_resetPasswordByEMail&email=' . $_REQUEST['email'] . '">Reset Password by email</a>.
	</p>';
?>
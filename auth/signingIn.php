<h1>Sign In</h1>
<?php
	if(isset($message))
		echo '<p class="alert alert-danger">' . $message . '. <a class="alert-link" href="./?menu=auth_resetPassword&reset_email=$reset_email">Reset Password</p>';
?>
<h1>Sign In</h1>
<?php
	if(isset($message))
		echo "<p class='alert'>$message</p><p><a href='./?menu=auth_resetPassword&reset_email=$reset_email'>Reset Password</p>";
?>
<?php
	//log_msg(__FILE__ . ':' . __LINE__ . ' en.php included.');
	$text['port_short_title'] = 'PoRT';
	$text['text_search'] = 'Search';
	$text['reset_password'] = 'Reset Password';	
	$text['sorry'] = 'Sorry. ';
	$text['please_contact_support'] = 'Please contact support.';

	$text['mail_not_found'] = 'Information for your email not found.';
	$text['verification_code_exception'] = 'Verification code was not set.';
	
	$text['text_password'] = 'Password';
	$text['repeat_password'] = 'Repeat Password';

	$text['text_greetings'] = 'Greetings';
	$text['reset_password_mail'] = 'Greetings, %user_name%. ' . PHP_EOL
					. 'For your account on PoRT Site http://%http_host%'
					. ' was requested resetting of password. ' . PHP_EOL
					. ' If you want to reset your password, please, click this link: ' . PHP_EOL
					. ' http://%http_host%?menu=users_resetPasswordByEMail' 
					. '&verification_code=%verification_code%'
					. '&email=%user_email% ' . PHP_EOL . PHP_EOL . PHP_EOL
					. 'If you did not request this operation, just ignore this letter.'
					. 'Thank you.';
	$text['reset_mail_sent'] = 'Letter to your email `%user_email%` was sent. Please, check your inbox. If you did not find it, check your "Spam" folder';
	$text['reset_mail_sent_not'] = 'Mail to `%user_email%` was not sent.';
	$text['reset_password_email_vf_exception'] = 'Your email not found or incorrect verification code.';
	$text['text_reset'] = 'Reset';
	$text['password_changed'] = 'Password changed.';
	$text['sign_in'] = 'Sign In';
	$text['reset_password_exception'] = 'We have got issue with resetting password. ';
	$text['different_passwords'] = 'You typed different passwords.';


?>
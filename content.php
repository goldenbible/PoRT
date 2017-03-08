<?php
	if (isset($_REQUEST['menu']))
		$menu = $_REQUEST['menu'];
	else
		$menu = 'forum';

	$menu_items = array('auth_signUp', 'registration', 'auth_signIn', 'auth_signingIn', 'forum', 'subforum', 'forum_createTopic', 'forum_creatingTopic', 'forum_topic', 'forum_replying',
		'forum_topicEdit', 'forum_topicEditing', 'forum_replyEdit', 'forum_replyEditing', 'forum_topicDelete', 'forum_replyDelete', 'forum_closeTopic', 'forum_openTopic', 
			'forum_pinTopic', 'forum_unpinTopic',
			// auth
			'auth_resetPassword', 'auth_secretAnswerChecking', 'auth_passwordResetting', 
			// user
			'user_profile', 'user_settings', 'user_saveSettings', 'messages_inbox', 
			// messages
			'messages_sent', 'messages_readIn', 'messages_readOut', 'messages_send', 'messages_sending', 'messages_inboxMarkAsRead', 'messages_inboxMarkAsUnread', 'messages_inboxDelete', 'messages_deleteSent');

	if (in_array($menu, $menu_items))
	{
		require './' . str_replace('_', '/', $menu) . '.php';
	}
?>
<?php
	if (isset($_REQUEST['page']))
		$page = $_REQUEST['page'];
	else $page = 1;
?>
<h1><a href="./?menu=messages_inbox">Messages</a> :: <a href="./?menu=messages_inbox">Inbox</a></h1><br />

<div class="row">
	<div class="col-md-6">
		<p><a class="messages-link" href="./?menu=messages_inbox">[Inbox]</a> <a class="messages-link" href="./?menu=messages_sent">[Sent]</a></p>
	</div>
	<!--<div class="col-md-6">
		<p align="right"><button><a href="./?menu=messages_send">Send a Message</a></button></p>
	</div>-->
</div>
<?php
	$statement = $dbh -> prepare('select msg.id, msg.from_user_id, msg.to_user_id, msg.subject, msg.message, u.nickname, msg.when_read,msg.inserted, msg.to_deleted from messages msg
									join users u on msg.from_user_id = u.id
									where msg.to_user_id = :id and msg.to_deleted is null order by msg.inserted desc limit ' . (($page - 1)* $_SESSION['messages_per_page'] ) . ', ' . $_SESSION['messages_per_page']);
	$result = $statement -> execute(array('id' => $_SESSION['uid']));
	if(!$result)
	{
		echo "<p>Whoops! We've got issue with messages.</p>";
		print_r($statement -> errorInfo());
	}
	elseif($statement -> rowCount() > 0)
	{
		$page_nav = '<a href="./?menu=messages_inbox">First Page</a> ';
		$count_statement = $dbh -> prepare('select count(id) from messages where to_user_id = :id and to_deleted is null');
		$count_statement -> execute(array('id' => $_SESSION['uid'] ));
		$message_count_row = $count_statement -> fetch();
		$message_count = $message_count_row['count(id)'];
		$page_count = floor($message_count / $_SESSION['messages_per_page']);
		if( ($message_count % $_SESSION['messages_per_page']) != 0) $page_count++;
		/*echo 'rowCount = ' . $statement -> rowCount() . '<br />' . 
			'message_count = `' . $message_count . '`<br />' .
			'messages_per_page = `' . $_SESSION['messages_per_page'] . '`<br />' .
			'page_count = `' . $page_count . '`<br />' .
			'page = `' . $page . '` <br />';*/

		if ($page_count > 1)
		{
			for($i=($page-5); $i<($page+5); $i++)
			{
				if($i>1 and $i<$page_count)
				{
					$page_nav .= "<a href=\"./?menu=messages_inbox&page=$i\">[$i]</a> ";
				}
			}
			$page_nav .= '<a href="./?menu=messages_inbox&page=' . $page_count . '">Last Page</a> ';
		}
		else $page_nav = '';
		echo $page_nav;

		echo '<form method="post" name="messagesForm"><table class="table table-striped"><thead><tr><th></th><th>Subject</th><th>From</th><th>Sent</th></tr></thead><tbody>';
		while ($message_row = $statement -> fetch()) 
		{
			echo "<tr><td><input type='checkbox' name='messages[]' value='" . $message_row['id'] . "'></td><td>";
			if (empty($message_row['when_read']))
				echo '<b>';
			echo "<a href='./?menu=messages_readIn&id=" . $message_row['id'] . "'>" . $message_row['subject'] . "</a>";
			if (empty($message_row['when_read']))
				echo '</b>';
			echo "</td><td><a href='./?menu=user_profile&id=" . $message_row['from_user_id'] . "'>" . $message_row['nickname'] . "</a></td><td>" . format_date($message_row['inserted']) . "</td></tr>";
		}
		echo "</tbody></table>" . $page_nav;
?>

<div class="row">
	<div class="col-md-6">
		<input type="hidden" id="menu" name="menu" value="messages_inboxMarkAsRead" />
		<p>

			<input type="submit" class="btn btn-default btn-sm" name="submit_mark" value="Mark as Read" onclick="document.getElementById('menu').value='messages_inboxMarkAsRead'; document.messagesForm.action='./?menu=messages_inboxMarkAsRead'; document.messagesForm.submit();" />
			<input type="submit" class="btn btn-default btn-sm" name="submit_mark_as_unread" value="Mark as Unread" onclick="document.getElementById('menu').value='messages_inboxMarkAsUnread'; document.messagesForm.action='./?menu=messages_inboxMarkAsUnread'; document.messagesForm.submit();" />
			<input type="submit" class="btn btn-danger btn-sm" name="submit_delete" onclick="document.getElementById('menu').value='messages_inboxDelete'; document.messagesForm.action='./?menu=messages_inboxDelete'; document.messagesForm.submit();"" value="Delete" />
		</p>
	</div>
</div>
</form>
<?php

	}
	else 
	{
		echo '<p class="alert alert-info">No messages</p>';
	}
?>
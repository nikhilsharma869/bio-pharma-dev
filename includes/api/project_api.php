<?php


function send_interview($project_id, $receiver_id, $sender_id, $message = '') {
	global $prev;
	$query = sprintf("INSERT INTO ".$prev."interview (project_id, receiver_id, sender_id, message) VALUES ('%s', '%s', '%s', '%s')",
			$project_id,
			$receiver_id,
			$sender_id,
			mysql_real_escape_string($message)
		);
	$result = mysql_query($query);
}


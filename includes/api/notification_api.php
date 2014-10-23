<?php

function add_notification($user_id, $message, $type, $link = '') {
	global $prev;
	$query = sprintf("INSERT INTO ".$prev."notification (user_id, message, link, add_date, type) VALUES ('%s', '%s', '%s', '%s', '%s')",
		$user_id,
		mysql_real_escape_string($message),
		mysql_real_escape_string($link),
		date('Y-m-d'),
		$type
	);

	$result = mysql_query($query);

	return $result;
}
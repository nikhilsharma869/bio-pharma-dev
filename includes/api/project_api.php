<?php


function send_interview($project_id, $receiver_id, $sender_id, $message = '') {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$query = sprintf("INSERT INTO ".$prev."interview (project_id, receiver_id, sender_id, message, sent) VALUES ('%s', '%s', '%s', '%s', '%s')",
			$project_id,
			$receiver_id,
			$sender_id,
			mysql_real_escape_string($message),
			$datetime
		);
	$result = mysql_query($query);
}

function get_hire_job($user_id) {

}

function get_interview_list($user_id) {
	global $prev;
	$datetime = date('Y-m-d H:i:s');
	$q = "SELECT *, DATEDIFF('".$datetime."', i.sent) AS date_diff FROM ".$prev."interview AS i 
	LEFT JOIN ".$prev."projects AS p ON i.project_id=p.id
		INNER JOIN ".$prev."user AS u ON p.user_id=u.user_id
	WHERE i.receiver_id='".$user_id."'
	GROUP BY i.project_id";
	$r = mysql_query($q);
	$list = array();
	while ($val = mysql_fetch_array($r)) {
		array_push($list, $val);
	}
	return $list;
}

function get_sent_job($user_id) {

}
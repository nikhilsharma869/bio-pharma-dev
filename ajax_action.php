<?php
include('includes/function.php');
include('configs/path.php');
if(isset($_REQUEST['action'])) {
	eval($_REQUEST['action']());
}

function save_job() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$project_id = $_REQUEST['project_id'];
	$datetime = date('Y-m-d H:i:s');
	$check = mysql_num_rows(mysql_query("select * from ".$prev."job_save where user_id=".$user_id." and project_id=".$project_id));
	
	if(!$check) {
		$query = sprintf("INSERT INTO ".$prev."job_save (user_id, project_id, created_time) VALUES ('%s', '%s', '%s')",
				$user_id,
				$project_id,
				$datetime
			);
		$result = mysql_query($query);
		
		if($result) {
			echo "Save job successfully!";
		} else {
			echo "Save failed!";
		}
	} else {
		echo "Job has been saved!";
	}
}

function remove_save_sme() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$uid = $_REQUEST['uid'];
	
	$result = mysql_query("DELETE FROM ".$prev."wishlist WHERE user_id=".$user_id." AND uid=".$uid);
	if($result) {
		echo "Remove sme successfully!";
	} else {
		echo "Remove failed!";
	}
}

function add_manual_time() {
	global $prev;
	$user_id = $_REQUEST['user_id'];
	$project_id = $_REQUEST['project_id'];

	$date2add = $_REQUEST['date2add'];
	$stime2add = $_REQUEST['stime2add'];
	$etime2add = $_REQUEST['etime2add'];

	$memo2add = $_REQUEST['memo2add'];

	$start_time = date('Y-m-d H:i:s', strtotime($date2add.' '.$stime2add));
	$stop_time = date('Y-m-d H:i:s', strtotime($date2add.' '.$etime2add));
	
	if($start_time >= $stop_time) {
		$ra['error'] = "Start time should not greater or equal stop time!";
		echo json_encode($ra);
		exit();
	}

	$q_checker = sprintf("SELECT * FROM ".$prev."project_tracker WHERE project_id='%s' AND worker_id='%s' AND ((start_time <= '%s' AND start_time >= '%s') OR (stop_time <= '%s' AND stop_time >= '%s'))",
		mysql_real_escape_string($project_id),
		mysql_real_escape_string($user_id),
		mysql_real_escape_string($stop_time),
		mysql_real_escape_string($start_time),
		mysql_real_escape_string($stop_time),
		mysql_real_escape_string($start_time)
	);

	$row_check = mysql_num_rows(mysql_query($q_checker));

	$ra = array();
	if($row_check > 0) {
		$ra['error'] = "Exist Time! Please select other start time and end time!";
	} else {
		$q_itracker = sprintf("INSERT INTO ".$prev."project_tracker SET project_id='%s',worker_id='%s',start_time='%s',stop_time='%s',note='%s',status='1',time_added_by='M'",
			mysql_real_escape_string($project_id),
			mysql_real_escape_string($user_id),
			mysql_real_escape_string($start_time),
			mysql_real_escape_string($stop_time),
			mysql_real_escape_string($memo2add)
		);

		$r_itracker = mysql_query($q_itracker);
		$itracker_id=mysql_insert_id();
		if($itracker_id) {
			mysql_query("INSERT INTO ".$prev."project_tracker_snap SET project_tracker_id='".$itracker_id."',project_work_snap_time='".mysql_real_escape_string($start_time)."'");
			mysql_query("INSERT INTO ".$prev."project_tracker_snap SET project_tracker_id='".$itracker_id."',project_work_snap_time='".mysql_real_escape_string($stop_time)."'");
		}
		$ra['success'] = "Added successfully!";
	}

	echo json_encode($ra);
	exit();
}


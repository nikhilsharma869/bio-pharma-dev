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

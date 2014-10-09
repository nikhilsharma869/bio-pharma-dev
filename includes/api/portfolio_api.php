<?php
function get_Count_Portfolio($user_id){
	global $prev;
	
	$q = "SELECT COUNT(*) as Total FROM ".$prev."portfolio p
				WHERE p.user_id='".$user_id."' AND p.status= 'Y'";	
			
	$r = mysql_query($q);	
	
	while ($val = mysql_fetch_array($r)) {
	
		$Total = $val['Total'];
		
	}
	return $Total;
}
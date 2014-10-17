<?php
 global $prev;

include('api/project_api.php');
include('api/menu_api.php');
include('api/portfolio_api.php');
include('api/mn_freelance_api.php');

function project_start_end_date($project_id){
		global $prev,$lang;
	$query = "SELECT ".$prev."projects.* FROM " . $prev . "projects where  " . $prev . "projects.id='".$project_id."'";
					
					$result1 = mysql_fetch_array(mysql_query($query));
					$secondsPerDay = ((24 * 60) * 60);
					$timeStamp = $result1[date2];
					$timeStamp2 = time();
					$daysUntilExpiry = $result1[expires];
					$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);			

						$datleft = '&nbsp;';
						$datstart = round(abs($timeStamp2 - $timeStamp)/60/60/24);

						if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0)
						{
							$datleft = " &nbsp;".$lang['LESS_DAY']."&nbsp;";
						}
						elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
						{
						  $datleft = " &nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)." &nbsp;".$lang['day'];
						   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
						   {
							 $datleft .= "s";
						   }
						   $datleft .= " &nbsp;".$lang['LFT']." &nbsp;";
						}
						else
						{
						   $datleft = "<font color=red>&nbsp;".$lang['EXPIRED']."&nbsp;</font>";
						}
						if($datstart<1)
							$datstart = $lang['TDAY'];
						elseif($datstart>1) 
							$datstart .= " &nbsp;".$lang['day_before']."s &nbsp;";	
						else
						$datstart .= " &nbsp;".$lang['day_before']." &nbsp;";	
						
				$project['end'] = $datleft;	
				$project['start'] = $datstart;	
			return $project;
}
function project_start_end_date_new($project_id){
		global $prev,$lang;
	$query = "SELECT ".$prev."projects.* FROM " . $prev . "projects where  " . $prev . "projects.id='".$project_id."'";
	
		
					$result1 = mysql_fetch_array(mysql_query($query));
					$secondsPerDay = ((24 * 60) * 60);
					$timeStamp = $result1[date2];
					$timeStamp2 = time();
					$daysUntilExpiry = $result1[expires];
					$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);			

						$datleft = '&nbsp;';
						$datstart = round(abs($timeStamp2 - $timeStamp)/60/60/24);
if($result1['status']=="open"){
						if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0)
						{
							$datleft = " <p class='cal_text'>&nbsp;</p><p class='cal_s_text'>".$lang['LESS_DAY']."</p>";
						}
						elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
						{
						  $datleft = " <p class='cal_text'>" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)."</p> <p class='cal_s_text'>".$lang['day'];
						   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
						   {
							 $datleft .= "s";
						   }
						   $datleft .= " ".$lang['LFT']." </p>";
						}
						else
						{
						   $datleft = "<p class='cal_text'>&nbsp;</p><p class='cal_s_text'>".$lang['EXPIRED']."</p>";
						}
						if($datstart<1)
							$datstart = $lang['TDAY'];
						elseif($datstart>1) 
							$datstart .= " &nbsp;".$lang['day_before']."s &nbsp;";	
						else
						$datstart .= " &nbsp;".$lang['day_before']." &nbsp;";	
						
				$project['end'] = $datleft;	
				$project['start'] = $datstart;
}else{
   $project['end'] = "<p class='cal_text'>&nbsp;</p><p class='cal_s_text'>".$result1['status']."</p>";

}				
			return $project;
}
function user_details($buyer_id){
		global $prev;		
		$buyer_info = @mysql_fetch_array(mysql_query("select user_id,username,fname,lname,country,profile,logo,ldate from ".$prev."user where user_id=".$buyer_id));
		if(empty($buyer_info['logo']))
	  	 $buyer_info['logo'] = "images/face_icon.gif";
	
		$skill_q = mysql_query("select skills from ".$prev."user_profile where user_id=".$buyer_id);
		while($data_skill=@mysql_fetch_array($skill_q)){
		  $data_skills = $data_skill['skills'];
		 } 
		
		$buyer_info['skills'] = $data_skills;
		
		return $buyer_info;
}

function project_category($project_id){
		global $prev;
		$rr=mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $project_id);

			$txt="";

			while($dd=@mysql_fetch_array($rr)){
			  $txt.="<span class='skilslinks2'>".$dd['cat_name'] . "</span>  / ";
			}

			if($txt!="")
			$jobtype=substr($txt,0,-2);			
			else			
			  $jobtype="not defined";	
		return $jobtype; 
}


function new_paging($adjacents, $targetpage, $param, $limit=10, $page=0, $total_pages)
	{
		//echo "aa";
		// How many adjacent pages should be shown on each side?
		//$adjacents = $adjacents;
		
		$total_pages = $total_pages;
		
		/* Setup vars for query. */
		$targetpage = $targetpage; 	//your file name  (the name of this file)
		$limit = $limit; 								//how many items to show per page
		$page = $_REQUEST['page'];
		if($page) 
			$start = ($page - 1) * $limit; 			//first item to display on this page
		else
			$start = 0;								//if no page var is given, set start to 0
		
		/* Setup page vars for display. */
		if ($page == 0) $page = 1;					//if no page var is given, default to 1.
		$prev = $page - 1;							//previous page is page - 1
		$next = $page + 1;							//next page is page + 1
		$lastpage = @ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
		$lpm1 = $lastpage - 1;						//last page minus 1

		/* 
			Now we apply our rules and draw the pagination object. 
			We're actually saving the code to a variable in case we want to draw it more than once.
		*/
		$pagination = "";
		if($lastpage > 1)
		{//	echo "aa";
			$pagination .= '<div class="pagination_box">
							<div class="pagination">
							<ul>';
			//previous button
			if ($page != 1 || $page > 1) 
			{
				$pagination.= "<li><a href=\"$targetpage?page=$prev$param\">&laquo; Previous</a></li>";
			}

			
			//pages	
			if ($lastpage < 15 + ($adjacents * 2))	//not enough pages to bother breaking it up
			{	
				for ($counter = 1; $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=$counter$param\">$counter</a></li>";
					else
						$pagination.= "<li><a href=\"$targetpage?page=$counter$param\">$counter</a></li>";					
				}
			}
			elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
			{
				//close to beginning; only hide later pages
/*				if($page < 1 + ($adjacents * 2))		
				{
					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li><a class=\"active\" href=\"$targetpage?page=$counter$param\">$counter</a></li>";
						else
							$pagination.= "<li><a href=\"$targetpage?page=$counter$param\">$counter</a></li>";					
					}
					$pagination.= "...";
					$pagination.= "<li><a href=\"$targetpage?page=$lpm1$param\">$lpm1</a></li>";
					$pagination.= "<li><a href=\"$targetpage?page=$lastpage$param\">$lastpage</a></li>";		
				}
*/				
				//in middle; hide some front and some back
				if($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
				{
				 	if($page==1)
					{
						$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=1$param\">1</a></li>";
					}
					else
					{
						$pagination.= "<li><a href=\"$targetpage?page=1$param\">1</a></li>";
					}
					if($page==2)
					{
						$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=2$param\">2</a></li>";
					}
					else
					{
						$pagination.= "<li><a href=\"$targetpage?page=2$param\">2</a></li>";
					}
					$pagination.= "<li>...</li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
					{
						if ($counter == $page && $page!=1 && $page!=2 && $page!=$lpm1 && $page!=$lastpage )
							$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=$counter$param\">$counter</a></li>";
					}
					$pagination.= "<li>...</li>";
					if($page==$lpm1)
					{
						$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=$lpm1$param\">$lpm1</a></li>";
					}
					else
					{
						$pagination.= "<li><a href=\"$targetpage?page=$lpm1$param\">$lpm1</a></li>";
					}
					if($page==$lastpage)
					{
						$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=$lastpage$param\">$lastpage</a></li>";
					}
					else
					{
						$pagination.= "<li><a href=\"$targetpage?page=$lastpage$param\">$lastpage</a></li>";
					}
				}
				//close to end; only hide early pages
				else
				{//echo "aaaaaaaaaaa";
					$pagination.= "<li><a href=\"$targetpage?page=1$param\">1</a></li>";
					$pagination.= "<li><a href=\"$targetpage?page=2$param\">2</a></li>";
					$pagination.= "<li>...</li>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<li ><a class=\"active\" href=\"$targetpage?page=$counter$param\">$counter</a></span></li>";
						else
							$pagination.= "<li><a href=\"$targetpage?page=$counter$param\">$counter</a></li>";					
					}
				}
			}
			
			//next button
			if ($page != $lastpage || $page < $lastpage) 
			{
				$pagination.= "<li><a href=\"$targetpage?page=$next$param\">Next &raquo;</a></li>";
			}
			
			$pagination.= "</ul><br /><br /></div></div>\n";		
		}
		//echo $pagination;
		return $pagination;
	}

function smoothdate ($year, $month, $day)
{
    return sprintf ('%04d', $year) . sprintf ('%02d', $month) . sprintf ('%02d', $day);
}
 
function date_difference ($first, $second)
{
    $month_lengths = array (31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
 
    $retval = FALSE;
 
    if (    checkdate($first['month'], $first['day'], $first['year']) &&
            checkdate($second['month'], $second['day'], $second['year'])
        )
    {
        $start = smoothdate ($first['year'], $first['month'], $first['day']);
        $target = smoothdate ($second['year'], $second['month'], $second['day']);
 
        if ($start <= $target)
        {
            $add_year = 0;
            while (smoothdate ($first['year']+ 1, $first['month'], $first['day']) <= $target)
            {
                $add_year++;
                $first['year']++;
            }
 
            $add_month = 0;
            while (smoothdate ($first['year'], $first['month'] + 1, $first['day']) <= $target)
            {
                $add_month++;
                $first['month']++;
 
                if ($first['month'] > 12)
                {
                    $first['year']++;
                    $first['month'] = 1;
                }
            }
 
            $add_day = 0;
            while (smoothdate ($first['year'], $first['month'], $first['day'] + 1) <= $target)
            {
                if (($first['year'] % 100 == 0) && ($first['year'] % 400 == 0))
                {
                    $month_lengths[1] = 29;
                }
                else
                {
                    if ($first['year'] % 4 == 0)
                    {
                        $month_lengths[1] = 29;
                    }
                }
 
                $add_day++;
                $first['day']++;
                if ($first['day'] > $month_lengths[$first['month'] - 1])
                {
                    $first['month']++;
                    $first['day'] = 1;
 
                    if ($first['month'] > 12)
                    {
                        $first['month'] = 1;
                    }
                }
 
            }
 
            $retval = array ('years' => $add_year, 'months' => $add_month, 'days' => $add_day);
        }
    }
 
    return $retval;
}

function get_list_skill_linkedin() {
	global $prev;
    $csquery = "SELECT skill_name, COUNT(*) AS cnumber
    FROM (SELECT DISTINCT * FROM " . $prev . "skill_linkedin) AS skills_linked
    GROUP BY skill_name";
    $count_skills = mysql_query($csquery);
    
    $top_skill_skill = array();
    $one_know_skill = array();

    while($skills = mysql_fetch_array($count_skills)) {   
        if($skills['cnumber'] > 1) {
            array_push($top_skill_skill, array('skill_name' => $skills['skill_name'], 'skill_count' => $skills['cnumber']));
        } else {
            array_push($one_know_skill, array('skill_name' => $skills['skill_name']));
        }
    }

    usort($top_skill_skill, function($a, $b) {
        return $b['skill_count'] - $a['skill_count'];
    });

    // var_dump($top_skill_skill);

    $skills_linkedin['top_skill_skill'] = $top_skill_skill;
    $skills_linkedin['one_know_skill'] = $one_know_skill;

    // var_dump($skills_linkedin);

    return $skills_linkedin;
}


function check_user_skill($skill_name, $user_id) {
	global $prev;
    $query = mysql_query("SELECT * FROM " . $prev . "skill_linkedin WHERE skill_name='".$skill_name."' AND user_id='".$user_id."'");
    $result = mysql_num_rows($query);

    if ($result>0) {
    	return true;
    } else {
    	return false;
    }
}

function get_list_user_by_skl($skill_name, $except_user_id){
	global $prev;

	$query = mysql_query("SELECT user_id FROM " . $prev . "skill_linkedin WHERE skill_name='".$skill_name."' AND NOT user_id='".$except_user_id."'");
	
	$users = array();
	while($user = mysql_fetch_array($query)) { 
		$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = '" . $user['user_id'] . "' LIMIT 6"));
		
		if (empty($row_user[logo])) {
		    $row_user[logo] = "images/face_icon.gif";
		}

		array_push($users, $row_user);
	}
	return $users;
	
}


function paging_new($sql,$st,$page){
		//Phan trang 
		$pp=$st;  //so ban ghi tren 1 trang
		$p_now = $page;
		$result=mysql_query($sql) or die(mysql_error());
			$total=mysql_num_rows($result);  //lay tong so dong
			$numofpages=ceil($total/$pp);
			
			if ($p_now<=0) {
				$page = 1;
			} else {
				if($p_now <= ceil($numofpages))
					$page = $p_now;
				else
					$page = 1;
			}
			$limitvalue = $page * $pp - ($pp);
		$parr=array();
		$parr[0]=$page;
		$parr[1]=$limitvalue;
		$parr[2]=$numofpages;
		$parr[3]=$total; // THIEN ADD: lay total cua paging
		
	return $parr; 
}

function get_list_skill_by_job_id($job_id){
	global $prev;
	$query = "SELECT * FROM " . $prev . "projects_cats 
									LEFT JOIN 
										" . $prev . "skill_linkedin ON " . $prev . "skill_linkedin.id=" . $prev . "projects_cats.cat_id
								WHERE " . $prev . "projects_cats.id='".$job_id."'";
	$result = mysql_query($query);
	
	$list_skill = array();
	while($rows = mysql_fetch_array($result)) { 
		$list_skill[] = array(	
								'skill_id'   => $rows['id'],
								'url_skill'   => $rows['url_skill'],
								'skill_name' => $rows['skill_name']
							);
	}
	return $list_skill;
	
}


function get_skill_by_id($skill_id){
	global $prev;
	$query = "SELECT * FROM " . $prev . "skill_linkedin 	WHERE " . $prev . "skill_linkedin.id='".$skill_id."'";
	$result = mysql_query($query);
	
	
	while($rows = mysql_fetch_array($result)) { 
		$list_skill = array(	
								'skill_id'   => $rows['id'],
								'url_skill'   => $rows['url_skill'],
								'skill_name' => $rows['skill_name']
							);
	}
	return $list_skill;
	
}

function get_DatLeft_Of_Project($project_id){
	global $prev,$lang;
	$query="SELECT ".$prev."projects.*  FROM ".$prev."projects  where  " . $prev . "projects.status='open' and ".$prev."projects.id='".$project_id."' ORDER BY " . $prev . "projects.date2 desc ";
	
	$result1=mysql_query($query);
	$secondsPerDay = ((24 * 60) * 60);
	$timeStamp =@mysql_result($result1,0,"date2");
	$timeStamp2 = time();
	$daysUntilExpiry =@mysql_result($result1,0,"expires");
	$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);			

	$datleft = '';


	if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0)
	{
		$datleft = " &nbsp;".$lang['LESS_DAY']."&nbsp;";
	}
	elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
	{
	  $datleft = " &nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)."&nbsp;" .$lang['day'];
	   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
	   {
		 $datleft .= "s";
	   }
	   $datleft .= "&nbsp;".$lang['LFT']."&nbsp;";
	}
	else
	{
	   $datleft = "<font color=red>&nbsp;".$lang['EXPIRED']."&nbsp;</font>";
	}
	
	return $datleft ;
}

function set_Color_for_Status($status){
	if($status=="open"){
		$class_stype = "color_open";
	}
	else if($status=="frozen"){
		$class_stype = "color_frozen";
	}else if($status=="cancelled"){
		$class_stype = "color_closed";
	}else if($status=="expired"){
		$class_stype = "color_expired";
	}else if($status=="complete"){
		$class_stype = "color_complete";
	}else if($status=="color_closed"){
		$class_stype = "color_closed";
	}else{
		$class_stype = "color_process";
	}
	
	return $class_stype;
}


function showrating($avg_rate)
{
    global $dbh;
    global $prev;
    global $conn;
    
    $a .= " ";
    for( $i = 0; $i < $avg_rate; $i++ ) 
    {
        $a .= "<img src='" . $vpath . "images/1star.png' />";
    }
    for( $j = 5; $avg_rate < $j; $j-- ) 
    {
        $a .= "<img src='" . $vpath . "images/star_3.png' />";
    }
    return $a;
}

function check_permission($per, $page) {
	$sme_noper = array();
	$client_noper = array(	
		'job_application',
		'saved_job',
		'my_jobs_sme',
		'contracts',
		'job_work_diary'
	);

	// check permission for client (e) or sme (w)
	if($per == 'w') {
		if(in_array($page, $sme_noper)) {
			header('Location: /no_permission.php?section='.$page);
		} 
	} else {
		if(in_array($page, $client_noper)) {
			header('Location: /no_permission.php?section='.$page);
		} 
	}
}

function check_Login_Worker($user_id,$user_type){

	if($user_id != '' && $user_type=='W'){
		return true;
	}
	
	return false;
} 

function hoursRange( $lower = 0, $upper = 86400, $step = 3600, $format = '' ) {
    $times = array();

    if ( empty( $format ) ) {
        $format = 'g:i a';
    }

    foreach ( range( $lower, $upper, $step ) as $increment ) {
        $increment = gmdate( 'H:i', $increment );

        list( $hour, $minutes ) = explode( ':', $increment );

        $date = new DateTime( $hour . ':' . $minutes );

        $times[(string) $increment] = $date->format( $format );
    }

    return $times;
}

function create_random_str($length=8,$use_upper=1,$use_lower=1,$use_number=1,$use_custom=""){
	$upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$lower = "abcdefghijklmnopqrstuvwxyz";
	$number = "0123456789";
	if($use_upper){
		$seed_length += 26;
		$seed .= $upper;
	}
	if($use_lower){
		$seed_length += 26;
		$seed .= $lower;
	}
	if($use_number){
		$seed_length += 10;
		$seed .= $number;
	}
	if($use_custom){
		$seed_length +=strlen($use_custom);
		$seed .= $use_custom;
	}
	for($x=1;$x<=$length;$x++){
		$rstr .= $seed{rand(0,$seed_length-1)};
	}
	return($rstr);
}

function getTimeDiff($dtime,$atime){ 
	$time_diff = array();
	$nextDay=$dtime>$atime?1:0;
	$dep=explode(':',$dtime);
	$arr=explode(':',$atime);
	$diff=abs(mktime($dep[0],$dep[1],0,date('n'),date('j'),date('y'))-mktime($arr[0],$arr[1],0,date('n'),DATE('j')+$nextDay,date('y')));
	$hours=floor($diff/(60*60));
	$mins=floor(($diff-($hours*60*60))/(60));
	$secs=floor(($diff-(($hours*60*60)+($mins*60))));
	if(strlen($hours)<2){$hours="0".$hours;}
	if(strlen($mins)<2){$mins="0".$mins;}
	if(strlen($secs)<2){$secs="0".$secs;}
	$time_diff['hours'] = $hours;
	$time_diff['mins'] = $mins;
	$time_diff['secs'] = $secs;
	return $time_diff;
}

?>
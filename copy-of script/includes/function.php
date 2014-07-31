<?php
 global $prev;

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
		$buyer_info = @mysql_fetch_array(mysql_query("select user_id,username,country,profile,logo,ldate from ".$prev."user where user_id=".$buyer_id));
		if(empty($buyer_info['logo']))
	  	 $buyer_info['logo'] = "images/face_icon.gif";
	
		$skill_q = mysql_query("select cat_name from ".$prev."categories c inner join ".$prev."user_cats u on c.cat_id=u.cat_id where u.user_id=".$buyer_id);
		while($data_skill=@mysql_fetch_array($skill_q))
		  $data_cat_name.= $data_skill['cat_name'].',';

		 $cat_name = substr($data_cat_name,0,-1);
		 
		$buyer_info['skills'] = $cat_name;

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

?>
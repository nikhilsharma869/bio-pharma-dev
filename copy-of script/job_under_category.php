<?php
/*********
This file created by sourav
******/
?>
<style type="text/css">
.classheader
{
text-align:left; font-size:14px; color:#333333; font-weight:bold; line-height:30px;
}
</style>
<style type="text/css">
/*pagination start*/

div.pagination {
	padding: 3px;
	margin: 3px;
}


div.pagination a {
font-size:12px;
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	text-decoration: none; /* no underline */
	color: #D7E3F3;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #D7E3F3;
	color:#666666;
}
div.pagination span.current {
	padding: 2px 4px 2px 5px;
	margin: 2px;
	border:1px solid #AAAADD;
	font-size:12px;	
		font-weight:normal;
		background-color:#D7E3F3;
		color:#021D9B;
		font-weight:bold;
	}
	div.pagination span.disabled {
	font-size:12px;	
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #666666;
		color:#666666;
	}
	.joinnow {
		width: 97px;
		text-align: center;
		background: url(../images/joinnow.gif) 7px 3px no-repeat;
	}

</style>
<?php
function new_paging_one($adjacents,$targetpage,$param,$limit=2,$page=1,$total_pages,$table_id="",$tbl_name="")
{

	$tbl_name=$tbl_name;		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = $adjacents;
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$k=0;$arr=array();$txt="";$t=1;

	for($i=1;$i<=ceil($total_pages/16);$i++):

	   if($page==$i):
	      $arno=$t;

	   endif;
	   $txt.=$i . ",";

	   $k++;
	   if(!($k%3)):

		 $arr[$t]=substr($txt,0,-1);$txt="";
		 $t++;

	   endif;
	endfor;

	if($k%3){$arr[$t]=$arr[($t-1)] .",".substr($txt,0,-1);}

	/* Setup vars for query. */
	$targetpage = $targetpage; 	//your file name  (the name of this file)
	$limit = $limit; 								//how many items to show per page

	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Setup page vars for display. */

	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1

	/*
		Now we apply our rules and draw the pagination object.
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1)
			$pagination.= "<a href=\"" . $targetpage . "?page=1" .$param . "\">&laquo; first</a>";
		else
			$pagination.= "<span class=\"disabled\">&laquo; first</span>";


		if($page>1):
		   $pagination.= "<a href=\"$targetpage?page=$prev$param\"><</a>";
		endif;

		//if($lastpage>=5):


		    $arrp=explode(",",$arr[$arno]);
			for($counter = 0; $counter<count($arrp) ; $counter++)
			{
	            if($arrp[$counter]):
					if($arrp[$counter] == $page):
						$pagination.= "<span class=\"current\">" . $arrp[$counter]." </span>";
				    else:

						$pagination.= "<a href=\"" . $targetpage . "?page=" . $arrp[$counter] . $param."\">" . $arrp[$counter]." </a>";
					endif;
				endif;
			}
		//endif;

		//next button
		if ($page < $lastpage):
			$pagination.= "<a href=\"". $targetpage."?page=".$next.$param."\">></a></a>";
		else:
			$pagination.= "<span class=\"disabled\">></span></span>";
		endif;

		if($page==$lastpage):
			$pagination.= "<span class=\"current\">last(" .ceil($total_pages/16) . ")</span>";
		else:
		    $pagination.= "<a href=\"$targetpage?page=" . ceil($total_pages/16) .$param ."\" >last(" .ceil($total_pages/16) . ")</a>";
		endif;
		$pagination.= "</div>\n";
	}
	return $pagination;
}

?>

<?php

/////////////////////////////////////////  current file name  ///////////////////////////////
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];
////////////////////////////////////////  end current file name  ///////////////////////////////

?>




<?php

	if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}	
	$select_project="";
			
	$r=mysql_query("select freelan_projects_cats.*,freelan_projects.* from freelan_projects_cats,freelan_projects where freelan_projects_cats.cat_id='".$_REQUEST['cat_id']."' and freelan_projects_cats.id=freelan_projects.id and freelan_projects.status='open' group by freelan_projects.id ORDER BY freelan_projects.date2 desc LIMIT 0,15 ");
	
	

			  $total_pages = @mysql_num_rows($r);
			  $page = $_GET['page'];
			  	if($page==1) 
				{
					$start = ($page - 1) * 16; 			//first item to display on this page
					$limit=16;
				}
				elseif($page>1) 
				{
					$start = 16 + ($page - 2) * 16; 			//first item to display on this page
					$limit=16;
				}
				else
				{
					$start = 0;$limit=16;
				}

	
		$query = "select freelan_projects_cats.*,freelan_projects.* from freelan_projects_cats,freelan_projects where freelan_projects_cats.cat_id='".$_REQUEST['cat_id']."' and freelan_projects_cats.id=freelan_projects.id and freelan_projects.status='open' group by freelan_projects.id ORDER BY freelan_projects.date2 desc LIMIT 0,15 ";
	
    //$params="&param=latest";
	$re=mysql_query($query);
	$total=@mysql_num_rows($re);
	$result=mysql_query($query);
?>	
<table width="951" border="0" cellpadding="0" cellspacing="0"  >
 <tr>
    <td class="thtxt" width="285">Project Name</td>
    <td class="thtxt" width="80" align="center">Bid</td>
    <td class="thtxt" width="210">Job Type</td>
    <td class="thtxt"  width="130" align="center">Avg Bid</td>
    <td class="thtxt"  width="150">Time Left</td>
    <td class="thtxt" width="100" align="center">Action</td>
  </tr>

<?php
$pa=1;
if($total > 0)
{
	
		while($row=@mysql_fetch_array($result))
		{
		if($pa % 2 == 0){$ca='tr2';}else{$ca='tr1';}
		$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id] . " limit 0, 1");
			while($dd=@mysql_fetch_array($rr))
			{
				$txt.=$dd[cat_name] . " , ";
			}
		//////////////////////////////////////////// select bids //////////////////////////////////////////////////
		$select_bids="select " . $prev . "buyer_bids.*," . $prev . "projects.* from " . $prev . "buyer_bids," . $prev . "projects where " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $prev . "buyer_bids.project_id='".$row[id]."'";
		$rec_bids=mysql_query($select_bids);
		$num_bids=mysql_num_rows($rec_bids);
		
		
		
		
		//////////////////////////////////////////// select bids //////////////////////////////////////////////////	
				$rr=mysql_query("select * from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id]);
				$txt="";
				while($dd=@mysql_fetch_array($rr)):
				  $txt.=$dd[cat_name] . " , ";
				endwhile;
				if($txt!=""){
				$jobtype=substr($txt,0,-2);
				}
				else
				{
				  $jobtype="not defined";
				}
							 $totalbid=totalbid($row[id]);
							 $avaragebid=avaragebid($row[id]);
							 $avaragebid=ceil($avaragebid);
							 if($avaragebid!=0)
							 {
								$avgbids=$setting[currency].'&nbsp;'.$avaragebid;
							}
							else
							{
								$avgbids='-';
							}	
		?>
		<?
		if($row[special]== "featured"):
			$fjobs='&nbsp;<img src="images/featured.png"  style=" position:absolute; padding-left:2px;" />';
		endif;
		?>
		
		  <tr class="<?php echo $ca;?>">
			<td width="290" class="sm bdn space" ><p><a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" style="text-decoration:none; color:#a1282c;"><?php echo $row['project'];?></a><?php echo $fjobs;?></p><p><img src="images/user.png" style="padding-right:3px;" /><span><?=ucwords(getusername($row["user_id"]));?> |<img src="images/budget.png" style="padding-left:3px;" /> Budget : <?=$budget_array[$row[budget_id]]?></span></p> </td>
			<td width="60" align="center" class="tdm" style="padding-left:10px;" ><?php echo $num_bids;?> </td>
		   <!-- <td width="99" class="tdm">$ 3000.00</td>-->
			<td width="200" class="tdm"><?php if(strlen($jobtype)>50){echo substr($jobtype,0,50).'...';} else {echo $jobtype;} ?></td>
			<td width="130" align="center" class="tdm"  ><?php echo $avgbids;?></td>
			<td width="150" class="tdm ">
			
			
			<?php
						$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open' and ".$prev."projects.id='".$row['id']."'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
						$result1=mysql_query($query);
							
							$secondsPerDay = ((24 * 60) * 60);
					
							$timeStamp = mysql_result($result1,0,"date2");
							$timeStamp2 = time();
					
							$daysUntilExpiry = mysql_result($result1,0,"expires");
							$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
					
							//echo genDate($daysUntilExpiry);
					
							if ((($daysUntilExpiry - $timeStamp2)/$secondsPerDay)<1 && (( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)>=0)
							{
								echo " &nbsp;less than a day left&nbsp;";
							}
							elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
							{
							   echo " &nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";
							   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
							   {
								  echo "s";
							   }
							   echo " left&nbsp;";
							}
							else
							{
							   echo "<font color=red>&nbsp;expired&nbsp;</font>";
							}
							?>
			
			</td>
			        <td class="tdm" align="center">
            <div >
            <?php
    if($row[user_id]!=$_SESSION[user_id])
	{
	?><a href="bid.php?id=<?php print base64_encode($row['id']);?>"><input type="button" name="bid" id="bid" value="Bid" class="submit_bott"  /></a><?php
	}
	else
	{
	?><input type="button" name="bid" id="bid" value="Bid" class="submit_bott1"  /><?php
	}
	?>
	</div>
        </td>
		  </tr>
		
		 <?php
		 $pa++;
		 }
 
 }
else
{	 
 ?>
 
 <tr>
 	<td colspan="6">
	<div style="height:50px;"></div>
	
	<div align="center" style="color:#999999; font-size:12px;"> Latest jobs not found ..</div>
	
	<div style="height:50px;"></div>
	
	</td>
 </tr>
 <?php
 }
 ?>
 
 
 
 <?php
 if($currentFile == 'latest_job.php')
 {
 ?> 
 <tr >
 <td colspan="6" >
 
 <div style="">
<?=new_paging_one(3,"latest_job.php",$parameter,16,$_REQUEST[page],$total_pages,$table_id="",$tbl_name="")?>
</div>	
 
 </td>
 </tr>
 <?php
 }
 else
 {
 }
 ?> 
 
   
  <tr><td colspan="6" class="btbrd2"></td></tr>
 </table> 
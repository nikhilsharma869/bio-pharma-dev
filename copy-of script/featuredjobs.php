



<?php

function new_paging_featured($adjacents,$targetpage,$param,$limit=2,$page=1,$total_pages,$table_id="",$tbl_name="")

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

<table width="930" border="0" cellpadding="0" cellspacing="0" style=" font-size:12px;" >

<?php

	if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}	

	$select_project="";

	

	if($currentFile == 'latest_job.php')

	{	

	$r=mysql_query("SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where " .$prev ."projects.special='featured' and freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc");

	}

	else

	{

	$r=mysql_query("SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where " .$prev ."projects.special='featured' and freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc  LIMIT 0,15");

	}



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





if($currentFile == 'latest_job.php')

	{

		//$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc  LIMIT ".$start.", ".$limit;

		$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where " .$prev ."projects.special='featured' and freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc LIMIT ".$start.", ".$limit;

	}

	else

	{

		$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where " .$prev ."projects.special='featured' and freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc Limit 0,15";

	}







    //$params="&param=latest";

	$re=mysql_query($query);

	$total=@mysql_num_rows($re);

	$result=mysql_query($query);

?>	





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

		

/*		if($num_bids > 0)

		{

			$num_bids=$num_bids;

		}

		else

		{

			$num_bids='&nbsp;Bid&nbsp;Now!&nbsp;';

		}*/

		

		

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

			$fjobs="";

		endif;

		?>

		

		  <tr class="<?php echo $ca;?>">

			<td width="290" align="left" valign="top" class="sm bdn"> <p><a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" style="text-decoration:none; color:#a1282c;"><?php echo $row['project'];?></a><?php echo $fjobs;?> <img src="images/featured.png"  style=" position:absolute; padding-left:2px;" /></p><p><img src="images/user.png" style="padding-right:3px;" /><span><?=ucwords(getusername($row["user_id"]));?> | <img src="images/budget.png"/> Budget : <?=$budget_array[$row[budget_id]]?></span></p> </td>

			<td width="60" class="tdm" style="padding-left:10px;" ><?php echo $num_bids;?> </td>

		   <!-- <td width="99" class="tdm">$ 3000.00</td>-->

			<td width="200" class="tdm"><?php if(strlen($jobtype)>50){echo substr($jobtype,0,50).'...';} else {echo $jobtype;} ?></td>

			<td width="130" class="tdm" style="padding-left:40px;" ><?php echo $avgbids;?></td>

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

							?>			</td>

            <td class="tdm" width="100">

         <div style="padding-left:40px;">

            <?php

    if($row[user_id]!=$_SESSION[user_id])

	{

	?><a href="bid.php?id=<?php print base64_encode($row['id']);?>"><input type="button" name="bid" id="bid" value="Bid" class="submit_bott" /></a><?php

	}

	else

	{

	?><input type="button" name="bid" id="bid" value="Bid" class="submit_bott1"  /><?php

	}

	?>

	</div>        </td>

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

	

	<div align="center" style="color:#999999; font-size:12px;">No project found ..</div>

	

	<div style="height:50px;"></div>	</td>

 </tr>

 <?php

 }

 ?> 

 

 

 <?php

 if($total_pages>25)

 {

 ?> 

 <tr >

 <td colspan="6">

 

 <div style="">

<?=pagination(3,"search.php",$parameter,25,$_REQUEST[page],$total_pages,$table_id="",$tbl_name="")?>

</div> </td>

 </tr>

 <tr >

   <td colspan="6" height="20"></td>

 </tr>

 <?php

 }

 ?> 

 </table>

<!--<tr class="tr2">

    <td width="325" class="sm bdn"><p>Small project site - a 4 pages max.</p><p><span>Imranmbutt | Budget : Between $500 and $1,000</span></p> </td>

    <td width="49" class="tdm">11 </td>

    <td width="99" class="tdm">$ 3000.00</td>

    <td width="211" class="tdm">Java Script, Web security</td>

    <td width="175" class="tdm">13 Nov 2001</td>

    <td width="119" class="tdm ">6d  21hour </td>

  </tr>-->
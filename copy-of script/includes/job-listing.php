<div class="recent_projects_middle">



	<table width="941" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr class="tbl_bg">

        <td width="316" align="left" class="space"><?=$lang['PROJECT_NAMEE']?> </td>

        <td width="102" align="center"> <?=$lang['BIDS']?> </td>

        <td width="151" align="left"><?=$lang['JOB_TYPE']?></td>

        <td width="125" align="center"> <?=$lang['AVG']?> </td>

        <td width="155" align="left"><?=$lang['TIME_LEFT']?> </td>

        <td width="102" align="left"><?=$lang['SUBMISSION6']?></td>

		</tr>



	  <?php



	if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}	

	$select_project="";

	

	if($currentFile == 'latest_job.php')

	{	

	$r=mysql_query("SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc");

	}

	else

	{

	$r=mysql_query("SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc  LIMIT 0,15");

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

		$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc  LIMIT ".$start.", ".$limit;

	}

	else

	{

		$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc  LIMIT 0,15";

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

		

		/*if($num_bids > 0)

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

			$fjobs='<img src="images/featured.png"  style=" position:absolute; padding-left:2px;" />';

		endif;

		?>

		

		  <tr class="<?php echo $ca;?>">

			<td  class="sm bdn space" ><p><a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" style="text-decoration:none; color:#a1282c;"><?php echo $row['project'];?></a><?php echo $fjobs;?></p><p><span><img src="images/user.png" style="padding-right:3px;" /><?=ucwords(getusername($row["user_id"]));?> | <img src="images/budget.png" style="padding-right:3px;" /><?=$lang['BUDGETT']?> : <?=$budget_array[$row[budget_id]]?></span></p> </td>

			<td  class="tdm" align="center"><?php echo $num_bids;?> </td>

		   <!-- <td width="99" class="tdm">$ 3000.00</td>-->

			<td   class="tdm"><?php if(strlen($jobtype)>50){echo substr($jobtype,0,50).'...';} else {echo $jobtype;}?></td>

			<td class="tdm" align="center" ><?php echo $avgbids;?></td>

			<td  class="tdm ">

			

			

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

								echo " &nbsp;".$lang['LESS_DAY']."&nbsp;";

							}

							elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)

							{

							   echo " &nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";

							   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)

							   {

								  echo "s";

							   }

							   echo $lang['LFT']."&nbsp;";

							}

							else

							{

							   echo "<font color=red>&nbsp;".$lang['EXPIRED']."&nbsp;</font>";

							}

							?>

			

			</td>

			 <td class="tdm" >

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

	

	<div align="center" style="color:#999999; font-size:12px;"><?=$lang['NO_PRODUCT_FOUND']?></div>

	

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

 <td colspan="6">

 

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



<!--      <tr class="tbl_bg2">

        <td align="left" class="space">Magento Programmer<br />

/ Data entry </td>

        <td align="left">Fixed</td>

        <td align="left">Bid Now!	</td>

        <td align="left">-</td>

        <td align="left">Copywriting,<br />

 Data Processing, </td>

        <td align="left">Today</td>

        <td align="left">5d 23h</td>

      </tr>

      <tr class="tbl_bg2">

        <td align="left" class="space">Magento Programmer<br />

/ Data entry </td>

        <td align="left">Fixed</td>

        <td align="left">Bid Now!	</td>

        <td align="left">-</td>

        <td align="left">Copywriting,<br />

 Data Processing, </td>

        <td align="left">Today</td>

        <td align="left">5d 23h</td>

      </tr>

-->    </table>





</div>
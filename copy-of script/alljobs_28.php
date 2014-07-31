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



/////////////////////////////////////////  current file name  ///////////////////////////////

$currentFile = $_SERVER["SCRIPT_NAME"];

$parts = explode('/', $currentFile);

$currentFile = $parts[count($parts) - 1];

////////////////////////////////////////  end current file name  ///////////////////////////////



?>



<table width="930" border="0" cellpadding="0" cellspacing="0" style=" font-size:12px;" >

<?php



if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}	

$select_project="";

$condition=array();

if($_REQUEST['featured_jobs'])
{

		 $condition[]=$prev ."projects.special='featured'";	
		 $parameter="&special=featured";
}

if(count($condition)){$cond=implode("and",$condition); }

$cond.="and ".$prev."projects.project LIKE '%".$_REQUEST['keyword']."%'";

$q="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open' " . $cond . " group by " . $prev . "projects.id";

$r=mysql_query($q);

# total projects

$total_pages = @mysql_num_rows($r);

# list of projects

//echo $q. " ORDER BY " . $prev . "projects.date2 desc Limit 0,25"; 		   

$result=mysql_query($q. " ORDER BY " . $prev . "projects.date2 desc Limit 0,25");

$pa=1;



if($total_pages > 0)

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
	if($row[special]== "featured")
	{
		$fjobs='<img src="images/featured.png"  style=" position:absolute; padding-left:2px;" />';
	}
	else
	{
		$fjobs="&nbsp;";
	}

	?>

	

	  <tr class="<?php echo $ca;?>">

		<td  width="290" align="left" valign="top"  class="sm bdn" ><div class="featured_img_bott"></div> <p><a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" style="text-decoration:none; color:#a1282c;"><?php echo $row['project'];?></a><?php echo $fjobs;?></p>

	    <p><img src="images/user.png" style="padding-right:3px;" /><span><?=ucwords(getusername($row["user_id"]));?> |<img src="images/budget.png"/> <?=$lang['BUDGETT']?> : <?=$budget_array[$row[budget_id]]?></span></p> </td>

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
 if($total_pages>25)
 {

 ?> 

 <tr >

 <td colspan="6" class="thtxt">

 

 <div style="">

<?=pagination(3,"search.php",$parameter,25,$_REQUEST[page],$total_pages,$table_id="",$tbl_name="")?>

</div>	

 

 </td>

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
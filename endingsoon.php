<?php
$query="SELECT ".$prev."projects.*,".$prev ."projects_cats.cat_id FROM ".$prev."projects,".$prev ."projects_cats where  freelan_projects.status='open'  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.expires asc Limit 0,15";
    //$params="&param=latest";
	$re=mysql_query($query);
	$total=@mysql_num_rows($re);
	$result=mysql_query($query);
?>	


<?php
$pa=1;
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
if($row[special]== "featured")
{
	$fjobs="&nbsp;<a href='".$vpath."featured.php'><img src='images/featured.gif' alt='Featured Project!' border=0></a>";
}
else
{
	$fjobs="&nbsp;";
}
?>

  <tr class="<?php echo $ca;?>">
    <td width="325" class="sm bdn" style="border-right: 1px solid #CCCCCC;"><p><a href="<?=$vpath?>project-dtl.php?id=<?php print $row[id];?>" style="text-decoration:none; color:#2F5B67;"><?php echo $row['project'];?></a><?php echo $fjobs;?></p><p><span><a href='<?=$vpath?>viewprofile.php?user_id=<?=getusername($row["user_id"]);?>' class=link><?=ucwords(getusername($row["user_id"]));?></a> | Budget : <?=$budget_array[$row[budget_id]]?></span></p> </td>
    <td width="49" class="tdm"><?php echo $num_bids;?> </td>
   <!-- <td width="99" class="tdm">$ 3000.00</td>-->
    <td width="211" class="tdm"><?php echo $jobtype;?></td>
    <td width="175" class="tdm"><?php echo $avgbids;?></td>
    <td width="119" class="tdm ">
	
	
	<?php
	
	//echo $row['id'];
	
	
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
						echo " (&nbsp;less than a day left&nbsp;)";
					}
					elseif ((( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) >= 1)
					{
					   echo " (&nbsp;" . round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay) . " day";
					   if(round(( $daysUntilExpiry - $timeStamp2 ) / $secondsPerDay)!=1)
					   {
						  echo " ' s";
					   }
					   echo " left&nbsp;)";
					}
					else
					{
					   echo "<font color=red>(&nbsp;expired&nbsp;)</font>";
					}
					?>
	
	</td>
            <td class="tdm">
            <?php
    if($row[user_id]!=$_SESSION[user_id])
	{
	?><a href="bid.php?id=<?php print base64_encode($row['id']);?>"><img src="images/bid.jpg" /></a><?php
	}
	else
	{
	?><img src="images/bid1.jpg" /><?php
	}
	?>
        </td>
  </tr>
 <?php
 $pa++;
 }
 ?> 
  <!--<tr class="tr2">
    <td width="325" class="sm bdn"><p>Small project site - a 4 pages max.</p><p><span>Imranmbutt | Budget : Between $500 and $1,000</span></p> </td>
    <td width="49" class="tdm">11 </td>
    <td width="99" class="tdm">$ 3000.00</td>
    <td width="211" class="tdm">Java Script, Web security</td>
    <td width="175" class="tdm">13 Nov 2001</td>
    <td width="119" class="tdm ">6d  21hour </td>
  </tr>-->
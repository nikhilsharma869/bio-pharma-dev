<?
$cond=array();
if(!$_REQUEST['status']){$cond[]=$prev . "projects.status='open'";}
else{$cond[]=$prev . "projects.status='" . $_REQUEST['status'] ."'";}
if($_REQUEST['param']=='featured')
{
	$cond[]=$prev . "projects.special='Y'";
}
if($_REQUEST['cat_id'])
{
	$cond[]=$prev . "projects_cats.cat_id=".$_REQUEST['cat_id'];
}
if(count($cond)){$conds=implode(" and ",$cond);}
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
$result1=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and ".$conds . " group by " . $prev . "projects_cats.id");
$total=mysql_num_rows($result1);		
if($_REQUEST[param]=="endingsoon"):
 	$result=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " .$conds . "  group by " . $prev . "projects_cats.id ORDER BY expires asc limit " . ($_REQUEST['limit']-1)*20 . ",20");
else:
    $result=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " .$conds . "  group by " . $prev . "projects_cats.id ORDER BY date2 desc limit " . ($_REQUEST['limit']-1)*20 . ",20");
    //echo"SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " .$conds . "  group by " . $prev . "projects_cats.id ORDER BY date2 desc limit " . ($_REQUEST['limit']-1)*20 . ",20";
endif;
$rowno=mysql_num_rows($result1);	
?>
<table width="98%" border="0" align="center" cellspacing="0" cellpadding="0">
 <tr>
   <td align="left" valign="middle" class="bid_heading_txt">
   <?php 
   if(($_REQUEST['param']=="")&&($cond==""))
   {
   echo 'Borwse Jobs';
   }
   else
   {
   echo 'Search Result';
   }
   ?> <?=$lang['FND']?> <?=$total?> <?=$lang['JOBS']?></td>
   <td align="center" valign="middle" class="bid_number_heading_txt"><?=$lang['BIDS']?></td>
   <td align="left" valign="middle" class="bid_number_heading_txt"><?=$lang['JOB_TYPE']?></td>
   <td align="right" valign="middle" class="bid_number_heading_txt"><?=$lang['LIST']?></td>
   <td align="right" valign="middle" class="bid_number_heading_txt" style='padding-right:10px'><?=$lang['EXPRD']?></td>
 </tr>
<tr><td colspan=5 style="border-top:1px solid #87b0b1;" height=3>&nbsp;</td></tr>

<?
if(!$total){echo"<tr><td align=center height=100 class=red colspan=5><h3><font color=red>No jobs found.</font></h3></td></tr>";}
$j=0;
while($row=@mysql_fetch_array($result)):
	$j++;

	if(!($j%2)){$bg="background-color:#ffffff;";}else{$bg="background-color:#e9f3fb;";}
	echo"<tr  style='" . $bg . "'><td  align='left' valign='middle' class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-left:10px'><a href='index.php?mode=project-dtl&id=" . $row[id] . "' class=bx_text-2><strong>" . $row[project] . "</strong></a>";
	if($row[special] == "featured"):
		echo"<A href='javascript://' class=description onClick=\"javascript:window.open('poppage.php?title=Featured+Project','_new','Width=300,height=300,addressbar=no,scrollbars=no');\" target=\"_blank\"><img src='images/featured.gif' alt='Featured Project!' border=0></a>";
    endif;
	$secondsPerDay9 = ((24 * 60) * 60);
	$timeStamp9 = time();
	$daysUntilExpiry9 = $row[expires];
	$getdat9  = $timeStamp9 + ($daysUntilExpiry9 * $secondsPerDay9);
	$thedat9  = $getdat9-$timeStamp9;
	$realdat9 = round($thedat9/((24 * 60) * 60));
	$explod9  = explode('-', $projectudays);
	for($i9=0;$i9<count($explod9);$i9++):
		if($realdat9==$explod9[$i9]):
			echo" <img src='images/urgent.gif' alt='Urgent!' border=0>";
        endif;
    endfor;
	echo"</td><td valign='middle' class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-left:10px' align=center>";
	$result2 = mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $row[id] . "' AND status='open'");
	$rows = mysql_num_rows($result2);
	echo $rows . "</td><td valign='middle' class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-left:10px'>";
	$txt="";
	$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id] . " limit 0, 1");
	while($dd=@mysql_fetch_array($rr)):
	    $txt.=$dd[cat_name] . " , ";
	endwhile;
	echo substr($txt,0,-2) . " &nbsp;</td><td valign='middle' class='listing_txt' align=right style='border-bottom:1px solid #b1ced9;padding-left:10px'>" . genDate($row[date2]) . "</td><td valign='middle'align=right class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-right:10px'>";
	$secondsPerDay = ((24 * 60) * 60);
	$timeStamp = $row[date2];
	$daysUntilExpiry = $row[expires];
	$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
	$expiryDate = genDate($daysUntilExpiry);
	echo $expiryDate . "</td></tr>";
endwhile;
if($total>5):
   echo"<tr class=description><td colspan=5 align=right style='border-top:dotted 1px silver'>" . paging($total,20,"$param",'no') . "</td></tr>";
endif;
echo"</table>";
/*if($java==1):
	$entry = str_replace("'", "\\'", $entry);
	$entry = ereg_replace("\n",'',@$entry);
	$entry = ereg_replace("\r",'',@$entry);
	print "document.write('$entry');\n";
else:
	echo $entry;
endif;
*/
?>
<br>
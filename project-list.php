<?php
function paging1($total,$perpage=12,$param="",$class="lnk",$limitp="limit")
{
	global $vpath;
	
	$limit=$_REQUEST['limit'];
	if(!$limit){$limit = 1;}
	
	$page=ceil($total/$perpage);
	$start=1;$end=10;$t=@($limit%10);
	if($t){$start=$limit-$t+1;}
    elseif($limit>10){$start=$limit-9;}
	
    $end=$start+9;
    if($page<$end){$end=$page;}
    $data="";
	
	if(substr_count($_SERVER[PHP_SELF],"admin")):
	  #================= 
		  if($limit>1 && $start!=1){$data .="<a href='" . $_SERVER['PHP_SELF'] . "?limit=" . ($start-1)  . $param . "' class=" . $class . "> &laquo;~Prev.</a>";}
	  
		  for($i=$start;$i<=$end;$i++):
	   		  if($limit==$i):
	      		  $data .="<a href='search.php?limit=" . $i . $param ."' class=" . $class . "><b>[" . $i . "]</b></a> | ";
	    	  else:
	       		  $data .="<a href='search.php?limit=" . $i . $param . "' class=" . $class . ">" . $i . "</a> | ";
	    	  endif;
		  endfor;
		  if($i<$page):
	  		  $data .="<a href='search.php?limit=" . $i . $param . "' class=" . $class . "> Next~&raquo; </a>";
		  endif;
		  #================= 
	else:
	  	if($limit>1 && $start!=1){$data .="<a href='" .$vpath. $_REQUEST['mode'] . "/?".$limitp."=" . ($start-1)  . "". $param . "' class='" . $class . "'> &laquo;~Prev.</a>";}  
	    for($i=$start;$i<=$end;$i++):
	   		if($limit==$i):
	      		$data .="<a href='" .$vpath. $_REQUEST['mode'] . "search.php?".$limitp."=" . $i . "". $param ."' class='current-page'><b>" . $i . "</b></a>  ";
	    	else:
	       		$data .="<a href='" .$vpath. $_REQUEST['mode'] . "search.php?".$limitp."=" . $i . "". $param . "' class='" . $class . "'>" . $i . "</a>  ";
	    	endif;  
		endfor;
		if($i<$page):
	  		$data .="<a href='" .$vpath. $_REQUEST['mode'] . "search.php?".$limitp."=" . $i . "". $param . "' class='" . $class . "'> Next~&raquo; </a>";  
		endif;
	endif;
	
	if($total>$perpage):
	   return "<b>".$lang['PGS']." :</b> " . $data; 
    endif;	
}
?>
<script>
function displaySource(ids,htm)
{
   // var h = sanitizeHTML(document.documentElement.outerHTML);
    document.getElementById(ids).innerHTML = "<pre>" + htm + "</pre>";
	//document.getElementById(j).style.backgroundColor="#5ecbff";
}

</script>
<style>
/*---------- bubble tooltip -----------*/
a.tt{
    position:relative;
    z-index:24;
    color:#106a6d;
	font-weight:bold;
    text-decoration:none;
}
a.tt span{ display: none; }

/*background:; ie hack, something must be changed in a for ie to execute it*/
a.tt:hover{ z-index:125; color: #454545; background:;}
a.tt:hover span.tooltip{
    display:block;
    position:absolute;
    top:0px; left:0;
	padding: 15px 0 0 0;
	width:400px;
	color: #111111;
    text-align: center;
	filter: alpha(opacity:90);
	KHTMLOpacity: 0.90;
	MozOpacity: 0.90;
	opacity: 0.90;
}
a.tt:hover span.top{
	display: block;
	padding: 30px 8px 0;
    background: url(bubble2.gif) no-repeat top;
	font-family:Verdana, Arial, Helvetica, sans-serif;
text-decoration:none;
font-style:normal;
font-size:12px;
color:#111111;
font-weight:normal;
line-height:18px;
}
a.tt:hover span.middle{ /* different middle bg for stretch */
	display: block;
	padding: 0 8px; 
	background: url(bubble_filler.gif) repeat bottom; 
	font-family:Verdana, Arial, Helvetica, sans-serif;
text-decoration:none;
font-style:normal;
font-size:12px;
color:#111111;
font-weight:normal;
line-height:18px;
}
a.tt:hover span.bottom{
	display: block;
	padding:3px 8px 10px;
	color: #548912;
    background: url(bubble2.gif) no-repeat bottom;
	font-family:Verdana, Arial, Helvetica, sans-serif;
text-decoration:none;
font-style:normal;
font-size:12px;
color:#106a6d;
font-weight:normal;
line-height:18px;
}
/*---------- bubble tooltip -----------*/


.bid_number_heading_txt
{

  color: #2C5662;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    font-size: 13px;
    font-style: normal;
    font-weight: bold;
    line-height: normal;
    padding-left: 6px;
    text-decoration: none;
}

</style>
<?
//echo "testing=".$_REQUEST['search'];
//echo "param=".$_REQUEST[param];
$str= $_SERVER['REQUEST_URI'];
$arr=array();
$arr=explode("/",$str);
$page=$arr[3];
if($page=="project-list")
{

  $query="SELECT * FROM " . $prev . "projects";
}

$cond=array();
$cond[]=$prev ."projects.id=" .$prev ."projects_cats.id";
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
$limit=" limit " . ($_REQUEST['limit']-1)*12 . ",12";
if(!$_REQUEST['status']){$cond[]="" .$prev ."projects.status='open'";}
else{$cond[]=$prev ."projects.status='" . $_REQUEST['status'] ."'";}
if($_REQUEST['param']=='featured')
{
	$cond[]="" .$prev ."projects.special='featured'";
}

if($_REQUEST['cat_id'])
{
	$cond[]=$prev ."projects_cats.cat_id=" .$_REQUEST['cat_id'];
}
if(count($cond)){$conds=implode(" and ",$cond);}

if($_REQUEST[param]=="all")
{
	 $query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats where " . $conds ."  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.expires asc  ";
     $params="&param=all";
}
elseif($_REQUEST[param]=="latest" && empty($_REQUEST['search']))
{
	  $query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats where " . $conds ."  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
      $params="&param=latest";
}
elseif($_REQUEST[param]=="latest" && !empty($_REQUEST['search']))
{
	  $query="SELECT * FROM " . $prev . "projects where project like '".$_REQUEST['search']."%'";
      //$params="&param=latest";
}
elseif($_REQUEST[param]=="ending")
{
	 $query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats where " . $conds ."  group by " . $prev . "projects.id ORDER BY " . $prev . "projects.expires asc ";
     $params="&param=ending";
}
elseif($_REQUEST[param]=="search")
{
 	$cat_id= $_REQUEST['cat_id'];
	$params="&param=search";
	$query="select * from " .$prev ."projects,".$prev ."projects_cats where " . $conds . "  group by " . $prev . "projects.id ORDER BY date2 asc ";
}
else
{
   $query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats where " . $conds ."  group by " . $prev . "projects.id ORDER BY ".$prev ."projects.date2 desc ";
}

if($_REQUEST['adv_search'])
{
	$conds="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	$conds=$prev ."projects.status='".$_REQUEST['projectStatus']."'";
	$conds=$prev ."projects.budgetmin='".$_REQUEST['budget_min']."'";
	$conds=$prev ."projects.budgetmax='".$_REQUEST['budget_max']."'";
	$p_name=$_REQUEST['keyword'];
	$p_status=$_REQUEST['projectStatus'];
	$budget_min=$_REQUEST['budget_min'];
	$budget_max=$_REQUEST['budget_max'];
	$flag=$_REQUEST['f'];
	$category=$_REQUEST['new_categories'];
	$_SESSION['owner']=$_REQUEST['owner'];

	$query=array();
	if($_REQUEST['owner']!="Search By Owner" && $_REQUEST['owner']!="")
	{
		$query[]=$prev ."projects.user_id in(select user_id from ".$prev."user where username rlike '".$_REQUEST['owner']."')";
	}
	if($_REQUEST['keyword']!="Search Project" && $_REQUEST['keyword'])
	{
	    $query[]="(" .$prev ."projects.project rlike '".$_REQUEST['keyword']."' or " .$prev ."projects.description rlike '".$_REQUEST['keyword']."')";
	}
	if($budget_min!="")
	{
		$query[]=$prev ."projects.budgetmin='".$_REQUEST['budget_min']."'";
	}
	if($budget_max!="")
	{
		$query[]=$prev ."projects.budgetmax='".$_REQUEST['budget_max']."'";
	}
	
	if(!empty($flag))
	{
		$query[]=$prev ."projects.special='featured' ";
	}
	
	if($p_status!="")
	{
		$query[]=$prev ."projects.status='$p_status' ";
	}
	if(!empty($_REQUEST['new_categories']))
	{
		$cat_id= $_REQUEST['new_categories'];
	  	$query[]=$prev."projects_cats.cat_id=".$cat_id. ") ";
	}
	if(!empty($_REQUEST['biddingEnds']) )
	{
	   $dt=$_REQUEST['biddingEnds'];
		//$dt=strtotime($dt);
		$query[]=" date_format( FROM_UNIXTIME(".$prev ."projects.expires ) , '%Y%m%d' )='$dt' ";
	}
	if(!empty($query))
	{
		$MyQuery = implode(" and ", $query);	
	    $MyQuery = "where  " . $prev . "projects.id= ".$prev ."projects_cats.id and ".$MyQuery;	
	}
	else
	{
	 $MyQuery = $prev ."projects.status='open' and where  " . $prev . "projects.id= ".$prev ."projects_cats.id";	
	}
	$query="SELECT * FROM " . $prev . "projects,".$prev ."projects_cats  ".$MyQuery."    group by " . $prev . "projects.id ORDER BY " . $prev . "projects.date2 desc ";
    
}
//echo $query;

/*$result1=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and ".$conds . " group by " . $prev . "projects_cats.id");
$total=mysql_num_rows($result1);		
if($_REQUEST[param]=="endingsoon"):
 	$result=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " .$conds . "  group by " . $prev . "projects_cats.id ORDER BY expires asc limit " . ($_REQUEST['limit']-1)*20 . ",20");
else:
    $result=mysql_query("SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " .$conds . "  group by " . $prev . "projects_cats.id ORDER BY date2 desc limit " . ($_REQUEST['limit']-1)*20 . ",20");
    //echo"SELECT " . $prev . "projects.* FROM " . $prev . "projects," . $prev . "projects_cats WHERE " . $prev . "projects.id=" . $prev . "projects_cats.id and " .$conds . "  group by " . $prev . "projects_cats.id ORDER BY date2 desc limit " . ($_REQUEST['limit']-1)*20 . ",20";
endif;*/
//echo "||" . $query;
$re=mysql_query($query);

	//$result=mysql_query("SELECT * FROM " . $prev . "projects where status='open' ".$conds." ORDER BY date2 asc limit " . ($_REQUEST['limit']-1)*20 . ",20");
$total=@mysql_num_rows($re);

$result=mysql_query($query . $limit);
//$rowno=mysql_num_rows($result1);	
?>
<table width="100%" border="0"  cellspacing="0" cellpadding="0">
 <?if($total):?>
 <tr>
   <td align="left" valign="middle" class="" style='border-bottom:1px silver silver; color: #3B5998;  font-family: Arial,Verdana,Sans-serif;  font-size: 26px; font-weight: normal;letter-spacing: -1px;'>
   <b class="h3"><?php 
   if(($_REQUEST['param']=="") && (count($cond)==0))
   {
   echo 'Borwse Jobs';
   }
   else
   {
  // echo 'Search Result';
   }
   if($_REQUEST[cat_id]):
      $rc=mysql_query("select * from " . $prev . "categories  where cat_id=" . $_REQUEST[cat_id] ."");
	  $cat_name=mysql_result($rc,0,"cat_name");
	  echo $cat_name . " : ";
   endif;

   ?> <?=$total?> <?=$lang['j_ob']?><?if($total>1){echo"s";}?></b></td>
   <!--<td align="center" valign="middle" class="bid_number_heading_txt" style='border-bottom:1px silver silver'>Bids</td>-->
   <td align="left" valign="middle" class="bid_number_heading_txt" style='border-bottom:1px silver silver'><?=$lang['JOB_TYPE']?></td>
  <!-- <td align="center" valign="middle" class="bid_number_heading_txt" style='border-bottom:1px silver silver'>Listed</td>
   <td align="right" valign="middle" class="bid_number_heading_txt" style='padding-right:10px;border-bottom:dotted 1px silver'>Expire</td>-->
 </tr>
<!--<tr><td colspan=5 style="border-top:1px solid #87b0b1;" height=3>&nbsp;</td></tr>-->

<?
endif;
if(!$total){echo"<tr><td align=center height=100 class=red colspan=5><h3><font color=red>".$lang['NO_JB_FND'].".</font></h3></td></tr>";}
$j=0;
while($row=@mysql_fetch_array($result))
{
	$j++;
    $new_user_id=$row['user_id'];
	$t_date=date('Ymd');
	$n_date=date('Ymd',($row[date2]));
	if(strcmp($t_date,$n_date)==0)
	{
	  $t_date=$lang['TDAY'];
	
	}
	else
	{
	$t_date=genDate($row[date2]);
	$t_date=substr($t_date,0,10);
	}
	$secondsPerDay = ((24 * 60) * 60);
	$timeStamp = $row[date2];
	$daysUntilExpiry = $row[expires];
	$temp_expdate=strtotime(date('Ymd',$row[expires]));
	$temp_new_expdate=strtotime(date('Ymd'));
	$new_expiryDate=$temp_expdate-$temp_new_expdate;
	$new_expiryDate=$new_expiryDate/(24*3600);
	$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
	$expiryDate = genDate($daysUntilExpiry);
	if($new_expiryDate<0){
	 	$exp='<font color="red">'.$lang['EXPIRED'].'</font>';
	 }
	else{
		$exp=round($new_expiryDate) ." days remaining";
	}
	if(!($j%2)){$bg="background-color:#ffffff;";}else{$bg="background-color:#f3f8f1;";}?>
	<!--onMouseOver="javascript:displaySource('trow<?=$j?>','<?=wordwrap(substr(str_replace("'","\'",$row['description']),0,100),60,"<br>\n",1)?>...');" onMouseOut="javascript:displaySource('trow<?=$j?>','');"-->
	<tr  height='36' bgcolor="whitesmoke">
	<td  align='left' valign='middle' class='listing_txt'  width=420 style='border-bottom:1px solid #b1ced9;padding-left:6px;padding-top:10px;padding-bottom:10px;border-right:1px  solid #b1ced9;' >
	<img src='images/small_dot.png' align=absmiddle><a   href="<?=$vpath?>viewprojects.php?id=<?=$row[id];?>"  class="tt"><strong><?=txt_value_output($row['project']);?></strong>
	<span class="tooltip"><span class="top"></span><span class="middle">
	<table border=0 cellspacing=0 cellpadding=4 width=100%  align=center bgcolor=#ffffff >
    <tr bgcolor=whitesmoke><td colspan=2 align=left style='border-bottom:1px silver silver'><small style='align:justify'><?
	echo substr($row[description],0,500) ."..."?></small></td></tr><tr><td style='border-bottom:1px silver silver'><small><?=$lang['POST_ON']?> : <?=$t_date?></small></td><td style='border-bottom:1px silver silver'><small><?=$lang['EXP_ON']?> : <?=$exp?></small></td></tr>
	 
	 <TR class=link>
	     <td align=left style='background-color:#e9f3fb;border-bottom:solid 1px #b1ced9;border-top:solid 1px #b1ced9'><a href="javascript://" onclick="javascript:window.open('<?php echo $vpath;?>pop-violation.php?bidder_id=<?=$row[user_id]?>&project_id=<?=$row[id]?>','_new','width=500,height=400,left=100,top=80,addressbar=no');"><IMG src="images/report-violation.gif" border="0" Alt="Report Violation"></A></TD>
	     <TD  style='background-color:#e9f3fb;border-bottom:solid 1px #b1ced9;border-top:solid 1px #b1ced9;border-bottom:solid 1px #b1ced9;'>
		 <? if($row[status] == "open"){?><A href="<?=$vpath?>project-dtl.php?bid=<?=$row[id];?>"><IMG src="images/bid.jpg" border=0 alt="Place Bid"></A><?}?></TD></tr>
		 </TABLE>
	</span><span class="bottom"></span></span>
	</a><br>&nbsp;&nbsp;&nbsp;&nbsp;<span class=link><a href='<?=$vpath?>viewprofile.php?user_id=<?=getusername($row["user_id"]);?>' class=link><?=ucwords(getusername($row["user_id"]));?></a> | <?=$lang['BUDGETT']?>  : <?=$budget_array[$row[budget_id]]?> &nbsp;&nbsp;</span>
	<? 
	if($row[special] == "featured"):
		echo"<img src='images/featured.gif' alt='Featured Project!' border=0>";
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
	echo "<div id='trow" . $j . "'></div>";
	echo"</td><!--<td valign='middle' class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-left:10px;border-right:dotted 1px #b1ced9;' align=center>";
	
	$result2 = mysql_query("SELECT * FROM " . $prev . "bids WHERE id='" . $row[id] . "' AND status='open'");
	$rows = mysql_num_rows($result2);
	if($rows==0)
	{
	   //echo $t="select * from ".$prev."user where user_id=".$_SESSION['user_id'];
	   if(!empty($_SESSION['user_id'])){
	   $d=mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id=".$_SESSION['user_id'])); }
	   
	   if($_SESSION[user_id]!=$new_user_id){
	       //echo "test";
	?>
	     
		<a href="<?=$vpath?>viewprojects.php?id=<?=$row[id];?>"><img src="images/bid.jpg" border="0"/></a> <? }else{echo"--";}?>
		
		</td><!--<td valign='middle' class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-left:10px;border-right:dotted 1px #b1ced9;'>
	<? 
	  
	}
	else
	{
	echo $rows . "</td>--><td valign='middle' class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-left:10px;'>";
	}
	$txt="";
	
	//echo "select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id] . " limit 0, 1";
	
	$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $row[id] . " limit 0, 1");
	while($dd=@mysql_fetch_array($rr)):
	    $txt.=$dd[cat_name] . " , ";
	endwhile;

	echo substr($txt,0,-2) . " &nbsp;</td><!--<td valign='middle' class='listing_txt' align=center style='border-bottom:1px solid #b1ced9;padding-left:15px;border-right:dotted 1px #b1ced9;'>" . $t_date. "</td><td valign='middle'align=right class='listing_txt' style='border-bottom:1px solid #b1ced9;padding-right:10px;'>";
	
	$secondsPerDay = ((24 * 60) * 60);
	$timeStamp = $row[date2];
	$daysUntilExpiry = $row[expires];
	$temp_expdate=strtotime(date('Ymd',$row[expires]));
	$temp_new_expdate=strtotime(date('Ymd'));
	$new_expiryDate=$temp_expdate-$temp_new_expdate;
	$new_expiryDate=$new_expiryDate/(24*3600);
	$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
	$expiryDate = genDate($daysUntilExpiry);
	if($new_expiryDate<0){
	 	echo '<font color="red">Expired</font>' . "</td>--></tr>";
	 }
	else{
		echo round($new_expiryDate) ." days remaining". "</td>--></tr>";
	}
}
if($total>2):

   echo"<tr class=link><td colspan=5 valign=middle align=right style='border-top:1px silver silver;height:30px;padding-right:20px'>" . paging1($total,12,"$params",'no') . "</td></tr>";
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
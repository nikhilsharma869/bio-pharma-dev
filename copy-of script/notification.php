<?php 
	$current_page="Notifications"; 
	include "includes/header.php";

	CheckLogin();
	$tbl_name=$prev."notification";
	if(isset($_GET[del]))
	{
		mysql_query("delete from ".$prev."notification where id='".base64_decode($_GET[del])."'");
		header("location:notification.php?tpages=".$_GET[tpages]."&adjacents=".$_GET[adjacents]."&page=".$_GET[page]);
	}
?>
<?php
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);

$row1 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".base64_decode($_GET[id])."'"));

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = 

'".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));

$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = 

'".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));

$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
$sum=0;

$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");
while($row4pend=mysql_fetch_array($res4pend))
{
	$sum+=$row4pend['amount'];
}
$sum1=number_format($sum,2);
?>
<?php
///////////////////////////////////////////////PAGINATION//////////////////////////////////////////////////
	$query = "SELECT COUNT(*) as num FROM $tbl_name where user_id='".$_SESSION['user_id']."' order by add_date desc";
	$total_pages =@mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	$limit = 10;
	$lastpage = ceil($total_pages/$limit);
	//how many items to show per page
	$page = intval($_GET['page']);
	if($page) 
	$start = ($page - 1) * $limit; 			//first item to display on this page
	else
	$start = 0;	
	//$page   = intval($_GET['page']);
	$tpages = ($_GET['tpages']) ? intval($_GET['tpages']) : $lastpage; // 20 by default
	$adjacents  = intval($_GET['adjacents']);
	
	if($page<=0)  $page  = 1;
	if($adjacents<=0) $adjacents = 1;
	
	$reload = $_SERVER['PHP_SELF'] . "?tpages=" . $tpages . "&amp;adjacents=" . $adjacents;
////////////////////////////////////////////PAGINATION END////////////////////////////////////////////////////////
?>

<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['NOTIFICATION']?></a></p></div>
<div class="clear"></div>
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
    <!--middle -->
<?php
		 $res_notification = mysql_query("select * from ".$prev."notification where user_id='".$_SESSION['user_id']."'order by add_date desc LIMIT $start, $limit");
		 
		$as=$start+1;
		$en=$as*10;
		if($en>$total_pages) {
		$en=$total_pages;
		
		}
?>
<div class="profile_right">
<ul class="tabs">
  <li><a href="javascript:void(0)" class="selected"><?=$lang['NOTIFICATIONS']?>: ( <? echo $as."-".$en;?> )</a></li>
  </ul>

<div class="newclassborder">

   
    	<div class="browse_tab-content"> 
            <div class="browse_job_middle">
<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->

            <table cellpadding="0" cellspacing="0" border="0" style="color:#4E4D4D; font-size:12px;" width="100%" >
          
<!------------------------------------------------Middle Body-------------------------------------------------------------->
            <tr>
            	<td>
				<table width="100%" align="center" border="0" cellpadding="5" cellspacing="0">
					<tr class='tbl_bg_4'>
						
						<td colspan="2" style="padding-left:80px;"><?=$lang['NOTIFICATIONS']?></td>
						<td align="center"><?=$lang['DATE']?></td>
					</tr>
               
    <?php
		 if(mysql_num_rows($res_notification)>0)
		 {
			 while($row_notification = mysql_fetch_array($res_notification))
			 {
	?>
                <tr class="tbl_bg2">
                    <td align="center" style="border-bottom:1px dotted #bdbdbd; ">
                    <a href="notification.php?del=<?php print base64_encode($row_notification[id]); if(isset($_SERVER['QUERY_STRING'])) {print '&'.$_SERVER['QUERY_STRING']; }?>" title="Delete" onclick="javascript:if(confirm('Do you really want to delete ?')){return true;} else {return false;};">
                    	<img src="images/clear.gif" style="width:9px; height:9px; border:none;" />
                    </a></td>
                    <td align="left" style="border-bottom:1px dotted #bdbdbd; "><?php print $row_notification[message];?></td>
                    <td align="center" style="border-bottom:1px dotted #bdbdbd; "><?php print date('F d-y', strtotime($row_notification[add_date]));?></td>
                <tr>
	<?php
			 }
    	 }
		 else
		 {
	?>
				<tr class="tbl_bg2"><td colspan="3" align="center"><strong><?=$lang['NO_RECORD_EXISTS']?></strong></td></tr>
	<?php
		 }
	 ?>
                
                </table>
                </td>
            </tr>
            <tr height="50px">
            <td valign="center" align="right" style="border-top:1px solid #e8e8e8; padding-right:20px;">
       <?php
						if($lastpage>1)
						{
							include("pagination3.php");
							echo paginate_three($reload, $page, $tpages, $adjacents);
						}
        ?>
            </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>
 </div>
<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

</div></div>
</div>
<!--end content-->
</div>
</div></div>
<?php include 'includes/footer.php';?> 
</body>
</html>
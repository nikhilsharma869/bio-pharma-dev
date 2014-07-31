<?php
$current_page = "<p>Job History</p>"; 
include "includes/header.php";
CheckLogin();
?>
<?php
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);

$type=$row['user_type'];

$row1 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".base64_decode($_GET[id])."'"));

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));

$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));

$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
$sum=0;

$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");
while($row4pend=mysql_fetch_array($res4pend))
{
	$sum+=$row4pend['amount'];
}
$sum1=number_format($sum,2);
$no_of_records=10;
?>


<style type="text/css">
.starsSmall{background:transparent url("images/group_icons.gif") no-repeat scroll -553px 0;vertical-align:top;display:inline-block;margin:.25em 5px 2px 0;width:50px;height:10px;}
.starsSmall.rating0{background-position:-553px 0;}
.starsSmall.rating1{background-position:-553px -70px;}
.starsSmall.rating2{background-position:-553px -140px;}
.starsSmall.rating3{background-position:-553px -210px;}
.starsSmall.rating4{background-position:-553px -280px;}
.starsSmall.rating5{background-position:-553px -350px;}
.starsMedium{background:transparent url("images/group_icons.gif") no-repeat scroll -433px 0;vertical-align:top;display:inline-block;margin:4px 5px 2px 0;width:70px;height:15px;}
.starsMedium.rating0{background-position:-433px 0;}
.starsMedium.rating1{background-position:-433px -70px;}
.starsMedium.rating2{background-position:-433px -140px;}
.starsMedium.rating3{background-position:-433px -210px;}
.starsMedium.rating4{background-position:-433px -280px;}
.starsMedium.rating5{background-position:-433px -350px;}
.starsLarge{background:transparent url("images/group_icons.gif") no-repeat scroll -280px 0;vertical-align:top;display:inline-block;margin:0 5px 2px 0;width:102px;height:20px;}
.starsLarge.rating0{background-position:-280px 0;}
.starsLarge.rating1{background-position:-280px -70px;}
.starsLarge.rating2{background-position:-280px -140px;}
.starsLarge.rating3{background-position:-280px -210px;}
.starsLarge.rating4{background-position:-280px -280px;}
.starsLarge.rating5{background-position:-280px -350px;}
.feedbackRating{display:inline;margin:0 0 2px 0;vertical-align:middle;}

</style>
<link rel="stylesheet" type="text/css" href="<?=$vpath?>highslide/highslide.css" /><script type="text/javascript" src="<?=$vpath?>highslide/highslide-with-html.js"></script>
<script type="text/javascript">
hs.graphicsDir = '<?=$vpath?>highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
hs.minHeight =300 ;
hs.minWidth =450 ;
hs.creditsText = '<i><?=$lang['FDB_RTNG_H']?></i>';
</script>

<!-----------Header End-----------------------------> 
  <?php
  $no_of_records=10;
  if(!$_GET[page]){$_GET[page]=1;}
  $res2t=mysql_query("select * from ".$prev."buyer_bids where bidder_id='".$_SESSION['user_id']."' and chose != 'C'");
  $total=mysql_num_rows($res2t);
  if($_GET['page'])
	{
		$sql="select * from ".$prev."buyer_bids where bidder_id='".$_SESSION['user_id']."' and chose != 'C' limit " . ($_GET['page']-1)* $no_of_records. ",".$no_of_records."";
	}
	else
	{	
		$sql="select * from ".$prev."buyer_bids where bidder_id='".$_SESSION['user_id']."' and chose != 'C' limit 0,".$no_of_records."";
	}
	//echo $sql;
	$res2=mysql_query($sql);

   ?> 
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?php echo currentPageName($current_page); ?></a></p></div>
<div class="clear"></div>
<?php include 'includes/leftpanel1.php';?>     <!-- left side-->
    <!--middle -->
<div class="profile_right">

<!--Profile Right Start-->
<div id="wrapper_3">
    <ul class="tabs">      
        <?php if($type == 'W'){	?>
				
				<li><a href="<?=$vpath?>mybids.html" rel="tabs2"><?=$lang['MY_BIDS']?></a></li>
				
				<li><a href="<?=$vpath?>lostbids.html" rel="tabs2"><?=$lang['LOST_BIDS']?></a></li>
				
				<li><a href="<?=$vpath?>closedbids.html" rel="tabs2"><?=$lang['COMPLETE_JOBS']?></a></li>
			  
			  	<? } ?>
			  
			  	<?php if($type == 'E'){ ?>      
                
				<li><a href="<?=$vpath?>my-jobs.html"  rel="tabs1"><?=$lang['MY_JOBS']?></a></li>
				
				<li><a href="<?=$vpath?>active_jobs.html" rel="tabs2"><?=$lang['ACTIVE_JOB']?></a></li>
        		
				<li><a href="<?=$vpath?>running_jobs.html" rel="tabs2"><?=$lang['RUNNING_JOBS']?></a></li>
				
				<li><a href="<?=$vpath?>closed_jobs.html" rel="tabs2"><?=$lang['CLOSED_JOBS']?></a></li>
				
				<li><a href="<?=$vpath?>bidhistory.html" class="selected" rel="tabs2"><?=$lang['JOB_HISTRY']?></a></li>
				
				<? } ?>
				
				
            	<?php if($type == 'B') {  ?>
				
				<li><a href="<?=$vpath?>my-jobs.html"  rel="tabs1"><?=$lang['MY_JOBS']?></a></li>
		
		
				<li><a href="<?=$vpath?>active_jobs.html" rel="tabs2"><?=$lang['ACTIVE_JOB']?></a></li>
        
		
				<li><a href="<?=$vpath?>running_jobs.html" rel="tabs2"><?=$lang['RUNNING_JOBS']?></a></li>
		
		
				<li><a href="<?=$vpath?>closed_jobs.html" rel="tabs2"><?=$lang['CLOSED_JOBS']?></a></li>
		
		
				<li><a href="<?=$vpath?>mybids.html" rel="tabs2"><?=$lang['MY_BIDS']?></a></li>
		
		
				<li><a href="<?=$vpath?>lostbids.html" rel="tabs2"><?=$lang['LOST_BIDS']?></a></li>
		
		
				<li><a href="<?=$vpath?>closedbids.html" rel="tabs2"><?=$lang['COMPLETE_JOBS']?></a></li>
		
		
				<li><a href="<?=$vpath?>bidhistory.html" rel="tabs2" class="selected"><?=$lang['JOB_HISTRY']?></a></li>
				
				<? } ?>
	</ul>
    <div class="browse_tab-content"> 
    	<div class="browse_job_middle">
			<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>

<!------------------------------------------------Middle Body-------------------------------------------------------------->
						<table width="750" border="0" align="left" cellpadding="0" cellspacing="0">
                      		<tr class="tbl_bg_4">
                        		<td width="196" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="71" align="center"><?=$lang['BIDS']?></td>
						<td width="87" align="center"><?=$lang['AVG_BID']?></td>
                        <td width="117" align="center"><?=$lang['STATUS']?></td>
                        <td width="132" align="center"><?=$lang['ACTION']?></td>
						<td width="147" align="center"><?=$lang['POST_DATE']?></td>
                   		  </tr>

            
<?php
if($total>0)
	{
		while($row2=@mysql_fetch_array($res2))
			{
				$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id='".$row2['project_id']."'"));
				$res3=mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id='".$rw1['user_id']."'"));
				$date=strtotime($row2['add_date']);
			?>
			
			<tr class="tbl_bg2">
	 			<td align="left" class="space" style="border-right:none;"><a href="<?=$vpath?>project/<?php print $row2[project_id];?>" class="font_bold2"><?php print ucwords($rw1['project']);?></a></td>
				
				<td><?php print $curn.' '.$row2[bid_amount];?></td>
				
				<td align="center"><?php print $row2[duration];?></td>
				
				<td align="center"><?php print date('d-m-Y',$date);?></td>
				<?php
				$bidreview = "<font color=\"#FF0000\"><b>".$lang['NO_RES']."</b></font>";
				$bidreview_res = mysql_query("select * from ".$prev."buyer_bids where project_id = '".$row2[project_id]."'");
				while($bidreview_row = mysql_fetch_array($bidreview_res))
					{
						if($bidreview_row[chose] == 'Y')
							{
								if($bidreview_row[bidder_id] == $_SESSION[user_id])
									{
										$bidreview = "<font color=\"#66CC00\"><b>".$lang['BID_WON_BY']."</b></font>";
										break;
									}
								else
									{
										$bidreview = "<font color=\"#FF0000\"><b>".$lang['BID_LOST']."</b></font>";
										break;
									}
							}
						if($bidreview_row[chose] == 'P')
							{
								if($bidreview_row[bidder_id] == $_SESSION[user_id])
									{
										$bidreview = "<font color=\"#0000FF\"><b>".$lang['CONFIRM_BID']."</b></font><br/><font color=\"#FF0000\" size=\"-2\"><i>".$lang['CHECK_YOUR_EMAIL']."</i></font>";
										break;
									}
								else
									{
										$bidreview = "<font color=\"#FF0000\"><b>".$lang['CONFIRMATION_PENDING']."</b></font>";
										break;
									}
							}
					}
				?>
            	<td align="center"><?php print $bidreview;?></td>
                <td align="center"></td>
			</tr>
			<?php
			}
		}
	else
		{
		?>
			<tr class="tbl_bg2" >
	 			<td colspan="5" align="center"><strong><?=$lang['NO_ACTIVE_PRO']?></strong></td>
			</tr>
		<?php
		}
		?>
			<tr><td colspan="5">
			<?
			if($total>$no_of_records)
				{										echo"<div align=right>". new_pagingnew(0,$vpath.'bidhistory/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
				}
			?>
			</td>
		</tr>
     </table>
  </td>
</tr>
</tbody>
</table>
</div></div>
               
			 </td>
            </tr>
			</table>
			<tr><td height="10px;" style="border-bottom:1px solid #e8e8e8;"></td></tr>
            <tr><td height="10px;"></td></tr>
<!---------------------------------------------------------------------------------------------------->
            <tr>
            	<td>
				<div class="browse_tab-content"> 
            <div class="browse_job_middle">
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#ffffff">
	<tbody>
    <tr>
    	<td class="bid_heading_txt" style="font-size:18px; color:#1b4471; font-family:Arial, Helvetica, sans-serif; padding-left:12px;"><?=$lang['PROJECT_COMPLETE']?> :</td>
    </tr>
    <tr>
    	<td>
        <table width="750" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr class="tbl_bg_4">
                        <td width="25%" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                		<td width="15%" align="center"><?=$lang['BID_USD']?></td>
                		<td width="18%" align="center"><?=$lang['DELIVRY_DAYS']?></td>
                		<td width="18%" align="center"><?=$lang['D_OF_BID']?></td>
                		<td width="25%" align="center"><?=$lang['DETAILS']?></td>
                      </tr>
   <?php

    $rw2 = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y'");

if(mysql_num_rows($rw2)>0){
$found = 0;
	while($rw3 = mysql_fetch_array($rw2)){	
	$rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from ".$prev."escrow where bidid = '".$rw3['id']."' and status = 'Y'"));
		$bid_amount = floatval($rw3['bid_amount']);
		if($rw5['escrow_amount'] >= $bid_amount)
		{
$ds1[]=$rw3['id'];
		}
	}
}
//$ds2=implode(",",$ds1);


   $bid_amount = 0.00;

   $employer_id = '';

$rw4 = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y' and id in($ds2) order by id desc");
$totalp=@mysql_num_rows($rw4);

$rw2 = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y' and id in($ds2) order by id desc limit 0,5");
//echo "select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y' and id in($ds2) order by id desc limit 0,10";
//echo mysql_num_rows($rw2);
if($totalp>0)

{

	while($rw3 = mysql_fetch_array($rw2))

	{		

		$rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from ".$prev."escrow where bidid = '".$rw3['id']."' and status = 'Y'"));

		

		$bid_amount = floatval($rw3['bid_amount']);

		

		if($rw5['escrow_amount'] >= $bid_amount)

		{

			$temp = mysql_fetch_array(mysql_query("SELECT ".$prev."projects.user_id, ".$prev."projects.project FROM ".$prev."projects, ".$prev."buyer_bids WHERE ".$prev."projects.id = ".$prev."buyer_bids.project_id AND ".$prev."buyer_bids.id ='".$rw3['id']."'"));

			

			$rs_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$temp['user_id']."'"));

				

			$employer_id = ucwords($rs_user['fname']).' '.ucwords($rs_user['lname']);

		?>
							
            				<tr>
            					<td><?php print $temp['project'];
			 					if($temp[special] == "featured"):

								echo' <img src="'.$vpath.'images/featured.png"  style=" position:absolute; padding-left:2px;" />';

								endif;
				
								?>
				
               					<td><?php print $employer_id;?></td>
                				<td align="center"><?php print $curn.' '.$rw3[bid_amount];?></td>
                				<td><?php print date('d-m-Y',strtotime($rw3['add_date']));?></td>
                				<td>
								<?php
								$rw6 = mysql_query("select * from ".$prev."feedback where project_id = '".$rw3['project_id']."' and bidid = '".$rw3['id']."' and feedback_from = '".$_SESSION['user_id']."' and feedback_to = '".$temp['user_id']."'");
								if(mysql_num_rows($rw6)>0)
									{
										$rw7 = mysql_fetch_array($rw6);
	   									?>
										<span class="feedbackRating starsMedium rating<?php print $rw7['avg_rate'];?> __ppDone" title="" > </span>&nbsp;&nbsp;&nbsp;
										<a href="<?=$vpath?>contractor_rating_view.php?rid=<?php print $rw7['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" style="color:#0066FF"><?=$lang['VIEW']?></a>
									<?php
									}
								else
									{
										?>
										<a href="<?=$vpath?>contractor_rating.php?pid=<?php print $rw3['project_id'];?>&bid=<?php print $rw3['id'];?>&eid=<?php print $temp['user_id'];?>&cid=<?php print $_SESSION['user_id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" style="color:#0066FF"><?=$lang['GIVE_FEEDBACK']?></a>
									<?php
									}
									?>
								</td>
							</tr>
							<?php
						}
				}
		}
	else
		{
		?>
		<tr class="tbl_bg2" >
	 		<td colspan="5" align="center"><strong><?=$lang['NO_COMP_JOB']?></strong></td>
		</tr>
		<?php
		}
		?>

<tr>
<td colspan="5" >
<?
if($totalp>5)
{
   echo"<div align=right><a href='".$vpath."closedbids.html' class='submit_bott'>".$lang['VIEW_ALL']."</a></div>";
}
?>
</td>
</tr>
        </table>
        </td>
    </tr>
	</tbody>
</table>
                </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>
</div>

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->
</div>
</div>
</div>


<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 
</body>
</html>
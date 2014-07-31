<?php 
$current_page = "<p>My Bids</p>";
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

?>
<link rel="stylesheet" type="text/css" href="<?=$vpath?>highslide/highslide.css" /><script type="text/javascript" src="<?=$vpath?>highslide/highslide-with-html.js"></script>

<script type="text/javascript">

hs.graphicsDir = '<?=$vpath?>highslide/graphics/';

hs.outlineType = 'rounded-white';

hs.wrapperClassName = 'draggable-header';

hs.minHeight =300 ;

hs.minWidth =450 ;

hs.creditsText = '<i>Feedback Rating</i>';

</script>



<!-----------Header End-----------------------------> 
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['MY_BIDS']?></a></p></div>
<div class="clear"></div>

<?php
$no_of_records=10;

if(!$_REQUEST[page]){$_REQUEST[page]=1;}
$res21=mysql_query("select * from ".$prev."buyer_bids where bidder_id='".$_SESSION['user_id']."' and chose != 'C' order by id desc ");


$total =@mysql_num_rows($res21);

$res2=mysql_query("select * from ".$prev."buyer_bids where bidder_id='".$_SESSION['user_id']."' and chose != 'C' order by id desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."");

?> 


<!-- content-->

<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

<div class="profile_right">
   <div id="wrapper_3">
   		
 <? echo getprojecttab(6,'1');?>
		<div class="browse_tab-content"> 
        	<div class="browse_job_middle">

			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr>
					<td>
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
            			<tr class="tbl_bg_4">
                		<td width="290" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="54" align="center"><?=$lang['BIDS']?></td>
						<td width="110" align="center"><?=$lang['DURATION']?></td>
                        <td width="150" align="center"><?=$lang['POST_DATE']?></td>
                       
						<td width="185" align="center"><?=$lang['STATUS']?></td>
                		</tr>

<?php
	if($total>0)
		{
			while($row2=mysql_fetch_array($res2))
				{
					$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id='".$row2['project_id']."'"));
					$res3=mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id='".$rw1['user_id']."'"));
					$date=strtotime($row2['add_date']);
					?>
					<tr class="tbl_bg2" >
						<td align="left" class="space" style="border-right:none;">
							<a href="<?=$vpath?>project/<?php print $row2[project_id];?>" class="font_bold2"><?php if($rw1['project']!=''){print ucwords($rw1['project']);}else{echo $lang['NOT_DFND'];}?></a>
						</td>
						<td align="center"><?php print $curn." ".$row2['bid_amount'];?></td>
						<td align="center"><?php print $row2['duration'];?> <? echo $lang['day'];if($row2['duration']>1){echo "s";}?></td>
						<td align="center"><?php print date('M d, Y',$date);?></td>
						<?php
						$bidreview = "<font color=\"#FF0000\"><b>".$lang['NO_RES']."</b></font>";
						$bidreview_res = mysql_query("select * from ".$prev."buyer_bids where project_id = '".$row2[project_id]."'");
						while($bidreview_row = mysql_fetch_array($bidreview_res))
							{
								if($bidreview_row[chose] == 'Y')
									{
										if($bidreview_row[bidder_id] == $_SESSION[user_id])
											{
												$bidreview = "<font color=\"#66CC00\"><b>".$lang['BID_WON1']." </b></font>";
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
												$bidreview = '<a href="my-jobs.php?mode=accept&id='.$row2['project_id'].'&confirm='.$row2['project_id'].'" style="color:#2f5b67; text-decoration:none;">'.$lang['ACCEPT_JOB'].'</a>';
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
			<tr>
				<td colspan="5">
				<?
				if($total>$no_of_records)
					{											echo"<div align=right>". new_pagingnew(0,$vpath.'mybids/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";							
}
?>



</td></tr>
        </table>

        </td>

    </tr>

	</tbody>

</table>

               


</div>

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

</div>

</div>
</div>
</div>

</div></div>
<?php include 'includes/footer.php';?>

</body>

</html>
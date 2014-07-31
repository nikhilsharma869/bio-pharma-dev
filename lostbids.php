<?php 
$current_page = "<p>Lost Bids</p>";
include "includes/header.php";

CheckLogin();

?>

<?php

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$row=mysql_fetch_array($res);

$type=$row['user_type'];



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

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>">Home</a> | <a href="javascript:void(0);" class="selected">Lost Bids</a></p></div>
<div class="clear"></div>

<?php include 'includes/leftpanel1.php';?> 



    <!-- left side-->

    <!--middle -->

<div class="profile_right">
   <div id="wrapper_3">
            <? echo getprojecttab(7);?>

			<div class="browse_tab-content"> 
            	<div class="browse_job_middle">         

<!------------------------------------------------Middle Body-------------------------------------------------------------->

<?php

 $res2t3=mysql_query("select project_id from ".$prev."buyer_bids where bidder_id='".$_SESSION['user_id']."' and (chose = 'N' or chose = 'P')"); while($as=@mysql_fetch_array($res2t3)){ $a[]=$as[project_id];  } $pr=@implode(",",$a);   $res2t=mysql_query("select * from ".$prev."buyer_bids where project_id in ($pr) and  chose='Y' and bidder_id!='".$_SESSION['user_id']."'");

    $total=mysql_num_rows($res2t);
  
  if($_GET['page'])
	{
		$sql="select * from ".$prev."buyer_bids where project_id in ($pr) and  chose='Y' and bidder_id!='".$_SESSION['user_id']."' limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";
	}
	else
	{	
		$sql="select * from ".$prev."buyer_bids where project_id in ($pr) and  chose='Y' and bidder_id!='".$_SESSION['user_id']."' limit 0,".$no_of_records."";
	}
	$res2=mysql_query($sql);


   ?> 

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
    <tr>
	  <td>
		<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
			<tr class="tbl_bg_4">
				<td width="290" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="54" align="center"><?=$lang['BIDS']?></td>
						<td width="110" align="center">Duration</td>
                       <td width="150" align="center"><?=$lang['POST_DATE']?></td>
                       
						<td width="185" align="center"><?=$lang['STATUS']?></td>
            </tr>
<?php
	if($total>0){

		$flg = 'false';

		while($row2=mysql_fetch_array($res2))

		{

			

				$flg = 'true';

				$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id='".$row2['project_id']."'"));

				$res3=mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id='".$rw1['user_id']."'"));

				$date=strtotime($row2['add_date']);

	?>

			<tr>

				<td>

				<a href="<?=$vpath?>project-dtl.php?id=<?php print $row2[project_id];?>" class="font_bold2">

				<?php print ucwords($rw1['project']);?>

				</a>

				</td>

				<td><?php print $curn.' '.$row2[bid_amount];?></td>

				<td align="center"><?php print $row2[duration];?></td>

				<td><?php print date('M d, Y',$date);?></td>

				<td><?php print "<font color=\"#FF0000\"><b>Bid Lost</b></font>";?></td>

			</tr>

		<?php

			

		}

		if($flg == 'false')

		{

	?>

            <tr class="tbl_bg2" >

             	<td colspan="5" align="center"><strong><?=$lang['NO_LOST']?></strong></td>

            </tr>

	<?php

		}

	}

	else

	{

	?>

            <tr class="tbl_bg2" >

             	<td colspan="5" align="center"><strong><?=$lang['NO_LOST']?></strong></td>

            </tr>

	<?php

	}
?>
<tr>

 <td colspan="5" align="center">
	<?php
		if($total>$no_of_records)
		{		   		   echo"<div align=right>". new_pagingnew(0,$vpath.'lostbids/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";	
		}
	?>
</td>

            </tr>
			
        </table>

        </td>

    </tr>

	</tbody>

</table>

<!------------------------------------------------Middle Body End---------------------------------------------------------->
</div>
</div>
</div>

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

</div>

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>

</body>

</html>
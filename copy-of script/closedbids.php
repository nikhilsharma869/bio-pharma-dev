<?php 
$current_page = "<p>Completed Jobs</p>";

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
<link rel="stylesheet" type="text/css" href="<?=$vpath?>highslide/highslide.css" /><script type="text/javascript" src="<?=$vpath?>highslide/highslide-with-html.js"></script><script type="text/javascript">hs.graphicsDir = '<?=$vpath?>highslide/graphics/';



hs.outlineType = 'rounded-white';



hs.wrapperClassName = 'draggable-header';



hs.minHeight =300 ;



hs.minWidth =450 ;



hs.creditsText = '<i>Feedback Rating</i>';



</script>
<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>">Home</a> | <a href="javascript:void(0);" class="selected">Completed Projects </a></p></div>
<div class="clear"></div>

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->



    <!--middle -->

<div class="profile_right">
   <div id="wrapper_3">
              <? echo getprojecttab(5);?>
              <div class="browse_tab-content"> 
            	<div class="browse_job_middle">





<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center" bgcolor="#ffffff" >
	<tbody>
		<tr>
			<td>
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                      <tr class="tbl_bg_4">
                        <td width="290" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="54" align="center"><?=$lang['BIDS']?></td>
					
                        <td width="170" align="center"><?=$lang['ACTION']?></td>
						<td width="185" align="center"><?=$lang['POST_DATE']?></td>
                      </tr>



   <?php
$no_of_records=10;

if(!$_REQUEST[page]){$_REQUEST[page]=1;}

$rw2 = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y'");
if(mysql_num_rows($rw2)>0){
$found = 0;
	while($rw3 = mysql_fetch_array($rw2)){	
	$rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from ".$prev."escrow where bidid = '".$rw3['id']."' and status = 'Y'"));
		$bid_amount = floatval($rw3['bid_amount']);
		if($rw5['escrow_amount'] >= $bid_amount)
		{
$ds1[]=$rw3[id];
		}
}
}
//$ds2=implode(",",$ds1);







   $bid_amount = 0.00;



   $employer_id = '';



$rwp = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y' and id in($ds2) order by id desc");

$totalp=@mysql_num_rows($rwp);
$rw2 = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and chose = 'Y' and id in($ds2) order by id desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."");
if($totalp>0)



{

	$found = 0;

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



            	<td><?php print ucwords($temp['project']);?></td>



                <td><?php print $employer_id;?></td>



                <td align="center"><?php print '$ '.$rw3[bid_amount];?></td>



                <td><?php print date('M d, Y',strtotime($rw3['add_date']));?></td>



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



		
		$found++;
		}

		/*else
		{
			$row_show='true';
		}*/

	}



}



if($found==0)



{



?>



	<tr class="tbl_bg2" >



	 <td colspan="5" align="center"><strong><?=$lang['NO_COMP']?></strong></td>



	</tr>



<?php	



}



?>

<tr><td colspan="5">
<?

if($totalp>$no_of_records)
{
 echo"<div align=right>". new_pagingnew(0,$vpath.'closedbids/','/',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";	
   
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


<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>

</body>



</html>
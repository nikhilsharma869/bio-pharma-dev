<?php 

$current_page = "<p>Feedback</p>";

	include "includes/header.php"; 



	CheckLogin();





if($_SESSION['user_id']){$user_id=$_SESSION['user_id'];}else{$user_id=$_SESSION['user_id'];}

if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}



include("country.php");



$e=mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]); 

$data=@mysql_fetch_array($e);



$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$row=mysql_fetch_array($res);



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



$rw4t = mysql_query("select * from ".$prev."feedback where feedback_to = '".$_SESSION[user_id]."'  group by project_id order by id desc");

$rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION[user_id]."'"));

$total=@mysql_num_rows($rw4t);



$no_of_records=10;



if($_GET['page'])

{

	$q="select * from ".$prev."feedback where feedback_to = '".$_SESSION[user_id]."'  group by project_id order by id desc limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records."";

}

else

{	

	$q="select * from ".$prev."feedback where feedback_to = '".$_SESSION[user_id]."'  group by project_id order by id desc limit 0,".$no_of_records."";

}

$rw4=mysql_query($q);



?>



<script type="text/javascript" src="highslide/highslide-with-html.js"></script>



<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />



<script type="text/javascript">



hs.graphicsDir = 'highslide/graphics/';



hs.outlineType = 'rounded-white';



hs.wrapperClassName = 'draggable-header';



hs.minHeight =300 ;



hs.minWidth =450 ;



hs.creditsText = '<i>Feedback Rating</i>';



</script>
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">

<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['FEEDBACK_PN']?></a></p></div>
<div class="clear"></div>

  <?php include 'includes/dashboard_menu.php';?>

  <!-- left side-->

  <!--middle -->

	<div class="profile_right">

	



		<!-- <ul class="tabs">      

		<li><a href="feedback.php" class="selected" rel="tabs1"><?=$lang['FEEDBACK_PN']?></a></li>

		</ul> -->

		

		<div class="browse_tab-content"> 

		<div class="browse_job_middle">

	

	

		   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

           <tr>

                    <td >

					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

                      <tr class="tbl_bg_4">

                        <td width="12%" align="left" class="space"><?=$lang['DATE']?></td>

                        <td width="19%" align="left"><?=$lang['CONTRACT']?></td>

                        <td width="19%" align="left"><?=$lang['EMPLOYER']?></td>
						
                        <td width="12%" align="center"><?=$lang['BILLED']?></td>

                        <td width="19%" align="center"><?=$lang['FEED_BACK_GIVEN_TO_YOU']?></td>

                        <td width="19%" align="center"><?=$lang['FEED_BACK_GIVEN_BY_YOU']?></td>

                      </tr>

              

              <?php



        if($total>0)

        {

		$i=1;

            while($rw6 = mysql_fetch_array($rw4))

            {

                $rs1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw6['feedback_from']."'"));

                $rs3 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$rw6['project_id']."'"));

                $rs4 = mysql_fetch_array(mysql_query("select * from ".$prev."buyer_bids where id = '".$rw6['bidid']."'"));

                $rs5 = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where project_id = '".$rw6['project_id']."' and feedback_from = '".$rw6['feedback_to']."'"));

				

				if($i%2==0)

				{

					$cls="tbl_bg2";

				}

				else

				{

					$cls="tbl_bg3";

				}

            ?>

              <tr class="<? echo $cls; ?>">

                <td align="center" ><?php print date('M / Y',strtotime($rw6['add_date']));?></td>

                <td><?php print $rs3['project'];?></td>

                <td><?php print ucwords($rs1['fname']).' '.ucwords($rs1['lname']);?></td>

                <td align="center">$ <?php print number_format($rs4['bid_amount'],2);?></td>

                <td align="center"><span class="starsSmall rating<?php print $rw6['avg_rate'];?>">&nbsp;</span><br />

                      <a href="employer_rating_view.php?rid=<?php print $rw6['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="link_class"><?=$lang['VIEW']?></a>

                      <!--<a href="contractor_rating_view.php?rid=<?php print $rw6['id'];?>" onClick="return hs.htmlExpand(this, { objectType: 'iframe'} )">...View</a>-->

                </td>

                <td align="center"><?php if($rs5)

					{?>

                      <span class="starsSmall rating<?php print $rs5['avg_rate'];?>">&nbsp;</span><br />

                      <a href="contractor_rating_view.php?rid=<?php print $rs5['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="link_class"><?=$lang['VIEW']?></a>

                      <!--<a href="employer_rating_view.php?rid=<?php print $rs5['id'];?>" onClick="return hs.htmlExpand(this, { objectType: 'iframe'} )">...View</a>-->

                      <?php }

					else

					{

					?>

                      <span class="starsSmall rating0">&nbsp;</span><br /> <?=$lang['NOT_GIVEN']?>

                  <?php

					}?>

                </td>

              </tr>

              <?php

			  $i++;

            }

        }

        else

        {

        ?>

              <tr class="tbl_bg2">

                <td colspan="6" align="center"><strong><?=$lang['NO_RECORD_EXISTS']?></strong></td>

              </tr>

              <?php

        }

        ?>

		

		<tr><td colspan="6">

		<?php

		if($total>$no_of_records)

			{

			   echo"<div align=right>" .new_paging(0,'feedback.php','&user=W',$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";

			

			}

		?>

		</td></tr>

          </table>

		  </td>

		  </tr>

		  </table>

		  

		  

		</div>

		</div>







	</div>

<!--Profile Right End-->



</div>		  

</div></div>

<div style="clear:both; height:10px;"></div>



<?php include 'includes/footer.php';?>
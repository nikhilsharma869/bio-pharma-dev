<?php 

	include "includes/header.php"; 

	//session_start();

	CheckLogin();

?>

<?php

//if(!$link){header("Location: ./index.php"); exit();}

if($_SESSION['user_id']){$user_id=$_SESSION['user_id'];}else{$user_id=$_SESSION['user_id'];}

if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}

include("country.php");

$e=mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]); 

$data=@mysql_fetch_array($e);

?>

<?php

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

?>

<!--<link href="css/globals__visitor.css" rel="stylesheet" type="text/css" media="all" />-->

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

</style>

<!-----------Header End-----------------------------> 



<!-- content-->

<div class="freelancer">



<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

    <div class="profile_right">

	<div class="edit_profile">

	<h2><span style="color:#6d6d6d; font-size:22px;">Welcome </span><?php print $_SESSION['fullname'];?><br />

	<span>Your last login was on <?=mysqldate_show($_SESSION[ldate],1)?></span></h2>

	

	<div align="right" style="padding-right:10px;">

	Balance  :  $ <strong><?php print $balsum;?></strong><br />

	Pending Transactions  :  $ <strong><?php print $sum1;?></strong>

	</div>

	<!--<ul>

	<li ><a href="profile.php">Update Profile</a></li>

	<li ><a href="select-expertise.php">Update Expertise</a></li>

	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>

	

	

	</ul>-->

	</div>

   

   

    <div class="edit_form_box">

	<?php

 

 $rw4 = mysql_query("select * from ".$prev."feedback where feedback_to = '".$_SESSION[user_id]."' or feedback_from ='".$_SESSION[user_id]."' group by project_id order by id desc");

 //echo "select * from ".$prev."feedback where feedback_to = '".$_SESSION[user_id]."'";

 $rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION[user_id]."'"));

 

?>

            <table cellpadding="0" cellspacing="0" border="0" style="font-size:12px; font-family:Arial,Verdana,Sans-serif;" width="100%" >

            <tr><td height="10px;"></td></tr>

<!------------------------------------------------Middle Body-------------------------------------------------------------->

            <tr>

            	<td>

                <table width="90%" cellpadding="5" cellspacing="1" align="center" style="color:#4E4D4D;">                

                <tbody>

				<tr style="color:#a1282c;"><td colspan="6"><h3>Work History &amp; Feedback : ( <?php print mysql_num_rows($rw4);?> )</h3><br /></td></tr>

                <tr style="background-color:whitesmoke; height:40px; color:#4E4D4D;"> 

                    <td><strong>Date :</strong></td>

                    <td><strong>Contract :</strong></td>

                    <td><strong>Employer :</strong></td>

                    <td><strong>Billed (USD):</strong></td>

                    <td><strong>Feedback Given to You</strong></td>

                    <td><strong>Feedback Given by You</strong></td>

                </tr>

         <?php

        if(mysql_num_rows($rw4)>0)

        {

            while($rw6 = mysql_fetch_array($rw4))

            {

                $rs1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw6['feedback_from']."'"));

                $rs3 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$rw6['project_id']."'"));

                $rs4 = mysql_fetch_array(mysql_query("select * from ".$prev."buyer_bids where id = '".$rw6['bidid']."'"));

                $rs5 = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where project_id = '".$rw6['project_id']."' and feedback_from = '".$rw6['feedback_to']."'"));

            ?>

                <tr>                            

                    <td><?php print date('M / Y',strtotime($rw6['add_date']));?></td>                            

                    <td><?php print $rs3['project'];?></td>

                    <td><?php print ucwords($rs1['fname']).' '.ucwords($rs1['lname']);?></td>                            

                    <td>$ <?php print number_format($rs4['bid_amount'],2);?></td>

                    <td>

                    <span class="starsSmall rating<?php print $rw6['avg_rate'];?>">&nbsp;</span><br />
					
					<a href="contractor_rating_view.php?rid=<?php print $rw6['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="button-small">...View</a>

                    <!--<a href="contractor_rating_view.php?rid=<?php print $rw6['id'];?>" onClick="return hs.htmlExpand(this, { objectType: 'iframe'} )">...View</a>-->

                    </td>

                    <td>

                    <?php if($rs5)

					{?>

                    <span class="starsSmall rating<?php print $rs5['avg_rate'];?>">&nbsp;</span><br />
  <a href="employer_rating_view.php?rid=<?php print $rs5['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" class="button-small">...View</a>

                    <!--<a href="employer_rating_view.php?rid=<?php print $rs5['id'];?>" onClick="return hs.htmlExpand(this, { objectType: 'iframe'} )">...View</a>-->

                    <?php }

					else

					{

					?>

					<span class="starsSmall rating0">&nbsp;</span><br />...Not Given

					<?php

					}?>

                    </td>

                </tr>

            <?php

            }

        }

        else

        {

        ?>

                <tr>

                    <td colspan="6" align="center">No record exists</td>

                </tr>

         <?php

        }

        ?>

                </tbody>

    </table>

                </td>

            </tr>

<!------------------------------------------------Middle Body End---------------------------------------------------------->

            </table>

	</div>

    <!--end middle--> 

    <!-- rightside-->

    <!-- end rightside-->

</div>

</div>





</div>

</div>

</div>

</div>

<?php include 'includes/footer.php';?> 

</body>

</html>
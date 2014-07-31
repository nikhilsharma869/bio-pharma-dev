<?php 







	include "includes/header.php";



	CheckLogin();



	//echo "select * from ".$prev."membership where id=1 ";



	$r=mysql_query("select * from ".$prev."membership where id=1 ");



	$data=@mysql_fetch_array($r);

	

	$r1=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."' ");



	$data1=@mysql_fetch_array($r1);

	

	$suc_msg="";

	

if($data1['gold_member']=='Y')

{

	echo '<div style="padding-left:100px; height:700px;"> You are already a Gold Member. </div>';

}

else

{



if($_POST['update'])



{

		



	$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));



	$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));







	$balsum = $rwbal['balsum1']-$rwbal2['baldeb'];







//$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);



	$new_balance=$balsum-$_POST['price'];



	$cur_time=time();



	//echo $new_balance;



	if($new_balance>=0)



	{



	//echo $new_balance;



	$query="insert into ".$prev."transactions set amount=".$_POST['price'].",details='Gold Member',user_id='".$_SESSION['user_id']."', balance=".$_POST['price'].", add_date=now(), date2=".$cur_time.", paypaltran_id='0', status='Y', amttype='DR'";



	//echo $query;



	$res=mysql_query($query);



	if($res)



	{

		if($_POST['auto_up']=="auto_up")

		{

		//print_r ($_POST);

			$update_query=mysql_query("update ".$prev."user set gold_member='Y',member_date=now(),gold_member_expire=(DATE_ADD(now(), INTERVAL 1 MONTH)), auto_update_member='Y' where user_id='".$_SESSION['user_id']."'");

		

		}

		else

		{

			$update_query=mysql_query("update ".$prev."user set gold_member='Y',member_date=now(),gold_member_expire=(DATE_ADD(now(), INTERVAL 1 MONTH))  where user_id='".$_SESSION['user_id']."'");

		}

		

		if($update_query)

		{

		$suc_msg="Your membership is successfully updated as a Gold Member";

		}



	}



	}



	else



	{

		//echo "less";

		header("Location: payment.php");

	}



}





	



?>



<div class="freelancer">



<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 





 <div class="profile_right">

<div class="dispute_contain_box">
      <h2>Membership Plans</h2>
    </div>

<div>

<?php

if($suc_msg!="")

{

?>

	<table width="650" height="50" align="center" style="border:solid 1px #60be4f; background-color:#ace0a3;border-radius:6px;;-webkit-border-radius:6px;-moz-border-radius:6px">

    <tr>

    	<td style="padding-left: 20px; font-size:12px;"><span style="background:#fff; color:#000;"><strong><?php print $suc_msg;?></strong></span></td>

    </tr>

    </table>

<?php

}

?>

</div>

<div class="main_pricin">







<!--Pricin Left-->



<div class="pricing_left">



<div class="textbold_left">



  <h1>Membership

  

  <br />





   <span style="color: #990000; font-size:22px;"> Plans!</span></h1>



</div>



 <div class="pricing_link">   



      <ul>



      <li><a href="#" class=" selected">Skills to set</a></li>



      <li><a href="#">Portfolio to set</a></li>



      <li><a href="#">Bids Available</a></li>



     



      </ul>







      <br />



      </div>



</div>











<div class="basic_box">



<div class="basic_top_tex">



<p><?php echo $data['membership_name']; ?></p>



<h1><?php echo number_format($data['price'],0,'.',','); ?><span><br />



  monthly</span></h1>



  



  <h2>Plan</h2>



</div>







<div class="basic_tex"><p><?php echo $data['skills']; ?></p></div>



<div class="basic_tex2"><p><?php echo $data['portfolio']; ?></p></div>



<div class="basic_tex"><p><?php echo $data['bids']; ?></p></div>















<!--<div class="basic_tex"><div class="basic_tex_img"><img src="images/Included_icon.png" width="27" height="28" /></div>



</div>-->







<div><input class="pricing_sign" type="submit" id="update" name="update" value="Free" /></div>



</div>







<?php



$r1=mysql_query("select * from ".$prev."membership where id=2 ");



	$data1=@mysql_fetch_array($r1);



	



?>



<form method="post" id="frm1" >



<div class="basic_box selected"><div class="basic_top_tex"><p><?php echo $data1['membership_name']; ?></p>



<h1><?php echo number_format($data1['price'],0,'.',','); ?><span><br />







<input type="hidden" id="price" name="price" value="<?php echo $data1['price']; ?>" />



  monthly</span></h1>



  



  <h2>Plan</h2>



</div>







<div class="basic_tex"><p><?php echo $data1['skills']; ?></p></div>



<div class="basic_tex2"><p><?php echo $data1['portfolio']; ?></p></div>



<div class="basic_tex"><p><?php echo $data1['bids']; ?></p></div>





<input type="checkbox" id="auto_up" name="auto_up" value="auto_up"  /> Do you want auto upgradation of your membership? Every month $<?php echo $data1['price']; ?> Amount will be deducted from your account. (You can cancel this by editing your profile.) 



<!--<div class="basic_tex2"><p><?php// echo $data['membership_name']; ?></p></div>-->











<!--<div class="basic_tex"><div class="basic_tex_img"><img src="images/Included_icon.png" width="27" height="28" /></div></div>-->







<div ><input class="pricing_sign" type="submit" id="update" name="update" value="update" /></div>











<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />







</div>



</form>



















</div>





<?php

}

?>



</div>

</div>





</div>

</div>

</div>

</div>

<?php include 'includes/footer.php';?> 

</body>

</html>
<?php 

include "includes/header.php";

CheckLogin();



if($_SESSION['error'])

{

	echo '<script> alert("'.$lang['BANNED_WORDS'].'"); </script>';

}



?>

<?php

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$row=mysql_fetch_array($res);

	if($row[user_type]=='E')

	{

		$_SESSION[errmsg] = $lang['NOT_PERMITTED_TO_BID']; 

		header("location:display.php");

	}

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

.profilebutton {

    background-color: #58AFDE;

    border: 1px solid #388bb5;

    color: #FFFFFF;

    cursor: pointer;

   

    padding: 2px 4px;

    text-shadow: 1px 1px 1px #CCCCCC;

	-webkit-border-radius:4px;-moz-border-radius:4px;

}

</style>

<script type="text/javascript">

function getbid(amt)

{

	var m = parseFloat(amt);

	var comm_type = document.getElementById('bid_commitype_hid_id').value

	var feeprcnt = parseFloat(document.getElementById('bid_commission_hid_id').value);

	if(isNaN(amt)||m<1||amt=='')

	{

		document.getElementById('bidamount1').value = '0.00';

		document.getElementById('bidamount').value = '0.00';

	}

	else if(m>=1)

	{

		if(comm_type=='P')

		{

			var fee = (m*feeprcnt)/100;

		}

		else if(comm_type=='F')

		{

			var fee = feeprcnt;

		}

		var chrg = m+fee;

		document.getElementById('site_fee_hid_id').value = fee.toFixed(2);

		document.getElementById('bidamount').value = chrg.toFixed(2);

	}

}

function bid_valid()

{

	if(document.getElementById('bidamount').value=='0.00' || document.getElementById('bidamount').value=='')

	{

		alert('Please enter a valid bid amount');

		document.getElementById('bidamount1').focus();

		return false;

	}

	if(isNaN(document.getElementById('bidamount').value))

	{

		alert('Please enter a valid bid amount');

		document.getElementById('bidamount1').focus();

		return false;

	}

	if(document.getElementById('delivery').value=='')

	{

		alert('Please enter number of days');

		document.getElementById('delivery').focus();

		return false;

	}

	if(isNaN(document.getElementById('delivery').value) || parseInt(document.getElementById('delivery').value)<1)

	{

		alert('Please enter a valid number of days');

		document.getElementById('delivery').focus();

		return false;

	}

	if(document.getElementById('details').value=='')

	{

		alert('Please enter bid details');

		document.getElementById('details').focus();

		return false;

	}

	return true;

}

</script>



<!-----------Header End-----------------------------> 





<!-- content-->

<div class="freelancer">





<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 





    <!-- left side-->

    <!--middle -->

    <div class="profile_right">

    <br />

<?php

if(isset($_SESSION['succ']))

{

?>

	<table width="650" height="50" align="center" style="border:solid 1px #60be4f; background-color:#ace0a3;border-radius:6px;;-webkit-border-radius:6px;-moz-border-radius:6px">

    <tr>

    	<td style="padding-left: 20px; font-size:12px;"><span style="background:#fff; color:#000;"><strong><?php print $_SESSION['succ'];?></strong></span></td>

    </tr>

    </table>

<?php

	unset($_SESSION['succ']);

	unset($_SESSION['error']);

}





else

{



	if(isset($_SESSION['error']))

		{

		?>

			<table width="650" height="50" align="center" style="border:solid 1px #F00; background-color:#FCC;-webkit-border-radius:6px;-moz-border-radius:6px">

			<tr>

				<td style="padding-left: 20px;font-size:10px;"><img src="images/exclamation.png" />&nbsp;&nbsp;&nbsp;<strong><?php print $_SESSION['error'];?></strong></td>

			</tr>

			</table>

		<?php

			unset($_SESSION['succ']);

			unset($_SESSION['error']);

		}

	

?>

 



<div class="edit_profile">

	<h2><span style="color:#6d6d6d; font-size:22px;"><?=$lang['PH_WELCOME']?></span> <?php print $_SESSION['fullname'];?><br />

	<span><?=$lang['World_p1']?> <?=mysqldate_show($_SESSION[ldate],1)?></span></h2>

	

	<div align="right" style="padding-right:10px;">

	<?=$lang['BALANCE']?>  :  $ <strong><?php print $balsum;?></strong><br />

	<?=$lang['B_MSG']?>  :  $ <strong><?php print $sum1;?></strong>

	</div>

	<!--<ul>

	<li ><a href="profile.php">Update Profile</a></li>

	<li ><a href="select-expertise.php">Update Expertise</a></li>

	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>

	

	

	</ul>-->

	</div>

   

   

    

	

	

<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->

<div class="edit_form_box">

            <table cellpadding="0" cellspacing="0" border="0"  width="100%" >

           

<tr>

            	<td>

<!------------------------------------------------Middle Body-------------------------------------------------------------->

<table border="0" cellspacing="0" cellpadding="4" width="90%" align="center" bgcolor="#ffffff" >

	<tbody>

    <tr class="link">

    	<td class="bid_heading_txt"><strong> <?=$lang['B_MSG1']?>: </strong>

        	<a href="<?=$vpath?>project-dtl.php?id=<?php print base64_decode($_GET[id]);?>" style="text-decoration:none; color:#a1282c;">

            	<h2><?php print $row1[project];?></h2>

            </a>        </td>

    </tr>

<form method="POST" name="bidform" action="applybid.php" onsubmit="return bid_valid();">

<?php

$bid_comm = 0.00;

$row_setting = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

if($row_setting[bid_charge_type]=='F')

{

	$str_type = 'US $ '.$row_setting[bid_charge_fixed].' (fixed)';

	$bid_comm = $row_setting[bid_charge_fixed];

}

elseif($row_setting[bid_charge_type]=='P')

{

	$str_type = $row_setting[bid_charge_percent].'(%)';

	$bid_comm = $row_setting[bid_charge_percent];

}

?>

	<input type="hidden" name="projectid_hid" id="projectid_hid_id" value="<?php print base64_decode($_GET[id]);?>"/>

    <input type="hidden" name="bid_commitype_hid" id="bid_commitype_hid_id" value="<?php print $row_setting[bid_charge_type];?>" />

    <input type="hidden" name="bid_commission_hid" id="bid_commission_hid_id" value="<?php print $bid_comm;?>" />

    <input type="hidden" name="site_fee_hid" id="site_fee_hid_id" value="" />

    <tr class="link" bgcolor="whitesmoke">

    	<td style="padding-left:10px">

        	<b><?=$lang['B_MSG2']?><font color="#FF0000" size="+1">*</font>:</b>        </td>

    </tr>

    <tr class="link">

    	<td style="padding-left:8px">

        	<?=$lang['B_MSG3']?><input type="text" name="bidamount1" id="bidamount1" maxlength="6" size="6" value="" onblur="javascript:getbid(this.value);"> + <?php print $str_type.' '.$dotcom_site;?> <?=$lang['B_MSG4']?> 

            <input type="text" name="bidamount" id="bidamount" maxlength="6" size="6" value="" readonly="readonly"> <?=$lang['B_MSG5']?>        </td>

    </tr>

	<tr class="link" bgcolor="whitesmoke">

    	<td style="padding-left:10px">

        	<b><?=$lang['B_MSG6']?> <font color="#FF0000" size="+1">*</font></b>        </td>

    </tr>

	<tr class="link">

    	<td style="padding-left:30px">

        	<input type="text" id="delivery" name="delivery" maxlength="3" size="6" value=""><?=$lang['B_MSG7']?></td>

    </tr>

	<tr class="link" bgcolor="whitesmoke">

    	<td style="padding-left:10px">

        	<b><?=$lang['B_MSG8']?> <font color="#FF0000" size="+1">*</font>:</b>        </td>

    </tr>

	<tr class="link">

	  <td height="5"></td>

	  </tr>

	<tr class="link">

    	<td>

        	<textarea rows="10" id="details" name="details" cols="50" style="width:80%" value=""></textarea>        </td>

    </tr>

<!--	<tr class="link">

    	<td style="padding-left:30px">

        	<input type="checkbox" name="outbid" value="y"> Notify me by e-mail if someone bids lower than me on this job.

        </td>

    </tr>-->

	<tr class="link">

    	<td >

<?php

	$row_bid_test = mysql_query("select * from ".$prev."buyer_bids where bidder_id = '".$_SESSION['user_id']."' and project_id = '".base64_decode($_GET[id])."'");

	if(mysql_num_rows($row_bid_test)>0)

	{

		$row_bid_test1 = mysql_fetch_array($row_bid_test);

?>

		<input type="hidden" name="rev_bidid_hid" value="<?php print $row_bid_test1[id]?>" />

        <input type="submit" value="<?=$lang['B_MSG10']?>" name="submit" class="submit_bott">

<?php

	}

	else

	{

?>

		<input type="submit" value="<?=$lang['B_MSG9']?>" name="submit" class="submit_bott">

<?php

    }

?>        </td>

    </tr>

</form>

	</tbody>

</table>



<!------------------------------------------------Middle Body End---------------------------------------------------------->               

			 </td>

            </tr>

			<tr><td height="10px;"></td></tr>

            </table>

</div>



<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

</div>

</div>





</div>

</div>

<? } ?>

</div>

</div>

<?php include 'includes/footer.php';?> 

</body>

</html>
<?php 
include "includes/header.php";
CheckLogin();
?>
<?php
$res1k=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row1k=mysql_fetch_array($res1k);

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
$respay = mysql_query("select * from ".$prev."user where user_id !='".$_SESSION['user_id']."' and status = 'Y'");
$rwbal1 = mysql_fetch_array(mysql_query("select sum(balance) as balsum from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y'"));
if($rwbal1['balsum']>0)
{
	$res1=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."' and status = 'process'");
	if(mysql_num_rows($res1)>0)
	{
		while($row1=mysql_fetch_array($res1))
		{
			$resbidpr = mysql_query("select * from ".$prev."buyer_bids where project_id = '".$row1['id']."' and chose='Y'");
			if(mysql_num_rows($resbidpr)>0)
			{
				while($rwbidpr = mysql_fetch_array($resbidpr))
				{
					$prarr[$cntpr]=$rwbidpr['id'];
					$cntpr++;
				}
			}
	/*		else
			{
				$errmsg.="There are no successful bids in your project";
			}*/
		}
	}
	else
	{
		$errmsg.="You have not posted any project<br/>";
	}
}
else
{
	$errmsg.="You have no balance in your account for this transfer<br/>";
}
//print_r($prarr);

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

<script type="text/javascript">
function chkfrm()
{
	if(document.transferpayment_frm.transfer_sel.value=='select')
	{
		alert('Please select a payee');
		return false;
	}
	if(document.transferpayment_frm.tranamt_txt.value=='')
	{
		alert('Please enter an amount to transfer');
		document.transferpayment_frm.tranamt_txt.value='0.00';
		document.transferpayment_frm.tranamt_txt.focus();
		return false;
	}
	if(isNaN(document.transferpayment_frm.tranamt_txt.value)||parseFloat(document.transferpayment_frm.tranamt_txt.value)<=0.00)
	{
		alert('Please enter a valid amount to transfer');
		document.transferpayment_frm.tranamt_txt.value='0.00';
		document.transferpayment_frm.tranamt_txt.focus();
		return false;
	}
	if(document.transferpayment_frm.reason_txt.value=='')
	{
		alert('Please enter a reason for transfer');
		document.transferpayment_frm.reason_txt.focus();
		return false;
	}
return true;
}
</script>
<style type="text/css">

.button-small {
	color:#2f5b67;
    background-color: #E8F0F7 !important;
    border-color: #BFD7F5 #7FAEEA #7FAEEA #BFD7F5 !important;
    border-style: solid !important;
    border-width: 1px !important;
    font-size: 10px !important;
    padding: 1px 3px !important;
    text-decoration: none;
    white-space: nowrap !important;
}
.mytable_payments
{
	color:#2f5b67;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
}
.mytable_payments td
{
	border-bottom:1px dotted #2f5b67; height:25px;
}
</style>
<!-----------Header End-----------------------------> 

<!-- content-->
<div class="freelancer">


<!--Profile-->
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
<div class="profile_right">
   <div class="edit_profile">
     <h2>Welcome <?php print $_SESSION['fullname'];?><br />
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

            <table cellpadding="0" cellspacing="0" border="0"  width="90%" align = "center" style="color:#4E4D4D; font-size:14px; font-family:Tahoma,Arial,Verdana,Sans-serif;">
            <tr><td height="10px;"></td></tr>
<!------------------------------------------------Middle Body-------------------------------------------------------------->
            <tr style="color:#a1282c;">
            	<td>
<!----------------------------------------------------------------------------------------------------------->
<h3 style="margin-left:5px;">Transfer Funds</h3><br />
<form name="transferpayment_frm" action="transferpayment.php" method="post" onsubmit="return chkfrm();">
<input type="hidden" name="pmttype" value="Payment Transfer" />
<input type="hidden" name="emailhid" value="<?php print $row['email'];?>" />
<input type="hidden" name="fnamehid" value="<?php print $row['fname'];?>" />
<table width="100%" cellpadding="8" style="color:#4E4D4D; font-size:14px; font-family:Tahoma,Arial,Verdana,Sans-serif;"> 
<tbody>
<tr style="background-color:whitesmoke; height:40px;"> 
	<td colspan="2" style="font-weight:bold; font-size:14px;">Transfer Money</td>
</tr>
<tr>
	<td style="width:300px;"><strong>Select Payee</strong></td>
    <td>
    <select name="transfer_sel">
    	<option value="select">Select Payee</option>
<?php
foreach($prarr as $bidid)
{
	$rwbidd1 = mysql_fetch_array(mysql_query("select * from ".$prev."buyer_bids where id = '".$bidid."'"));
	$rwuser1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rwbidd1['bidder_id']."'"));

?>
        <option value="<?php print $rwuser1['user_id']; ?>"><?php print ucwords($rwuser1['fname']).' '.ucwords($rwuser1['lname']);?></option>
<?php } ?>
    </select>
    </td>
</tr>
<tr>
	<td style="width:300px;"><strong>How much money would you like to transfer ?</strong></td>
    <td><input type="text" name="tranamt_txt"  size="15" value="" />&nbsp;<b>USD</b></td>
</tr>
<tr>
	<td style="width:300px;" valign="top"><strong>Reason</strong></td>
    <td><textarea name="reason_txt" rows="6" cols="30"></textarea></td>
</tr>
<tr>
<td colspan="2" align="center"><input type="submit" name="milesub" value="Submit" style="width:55px; height:25px;" /></td>
</tr>
</tbody>
</table>
  </form>
<!----------------------------------------------------------------------------------------------------------->
                </td>
            </tr>
<!------------------------------------------------Middle Body End---------------------------------------------------------->
            </table>

    

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------>
    
<!---------------------------------------------------------------------------------------------------------------------------->
<div style="width:90%; margin:auto;">
<h5 style="color:#a1282c;font-family:Tahoma,Arial,Verdana,Sans-serif;">Money Transfer Transactions</h5> 
 <table width="100%" cellpadding="8" class="mytable_payments" style="color:#4E4D4D; font-size:14px; font-family:Tahoma,Arial,Verdana,Sans-serif;"> 
 <tbody>
<tbody>
 <tr style="background-color:whitesmoke; height:40px;">  
	<td width="13%">Date</td> 
	<td width="16%">Transaction ID</td> 
	<td width="11%">Receiver</td>
	<td width="10%">Status</td> 
	<td width="8%">Debit/Credit</td>
    <td width="11%">Amount(USD)</td>
</tr> 
<?php
$restrntab = mysql_query("select * from ".$prev."transactions where user_id='".$_SESSION['user_id']."' and details='Payment Transfer' order by add_date desc");
if(mysql_num_rows($restrntab)>0)
{
	while($rwtrntab=mysql_fetch_array($restrntab))
	{
		$rwrecver = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rwtrntab['amount']."'"));
?>
		<tr>  
			<td><?php print date('d-m-Y H:i:s',strtotime($rwtrntab['add_date']));?></td> 
			<td><?php print $rwtrntab['paypaltran_id'];?></td> 
			<td><?php print ucwords($rwrecver['fname']).' '.ucwords($rwrecver['lname']);?></td> 
			<td><?php if($rwtrntab['status']=='P'){print "<font color='#FF0000'><b>Pending</b></font>";}elseif($rwtrntab['status']=='Y'){print "<font color='#009900'><b>Completed</b></font>";}?></td>
			<td align="center"><?php print $rwtrntab['amttype'];?></td>
			<td>$<?php print $rwtrntab['balance'];?></td>
		</tr>
	<?php
	}
}
else
{
?>
	<tr><td colspan="6" align="center"><b>No records found</b></td></tr>
<?php
}
?> 
</tbody>
</table>
    
    </div>
<!---------------------------------------------------------------------------------------------------------------------------->

</div>

</div>
<!--end content-->


</div>
</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>
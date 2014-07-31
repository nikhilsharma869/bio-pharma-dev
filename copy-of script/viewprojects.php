<?php 
include "includes/header.php";
CheckLogin();
?>
<?php
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php print $setting[meta_keys];?>" />
<meta name="description" content="<?php print $setting[meta_desc];?>" /> 
<title><?php print $setting[site_title];?></title>
<link rel="stylesheet" href="css/style3.css"/>
<link rel="shortcut icon" href="images/favicon.ico">
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
</head>

<body>
<div id="container">
<!-----------Header----------------------------->
<?php include 'includes/header1.php';?> 
<!-----------Header End-----------------------------> 
<div class="clear"></div>
<!-- content-->
<div id="content">
	<div id="profile_content">
    <!--leftside-->
<?php include 'includes/leftpanel1.php';?> 
    <!-- left side-->
    <!--middle -->
    <div class="rightside left">
<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->
    	<div style="border:1px solid #d4dce2; -webkit-border-radius:6px;-moz-border-radius:6px">
    
		<div style="height:80px; border-bottom:1px solid #d4dce2; color:#3387B1; font-size:13px;">
        
            <table cellpadding="0" cellspacing="0" border="0" style="" width="100%">
            <tr><td style="height:20px;"></td></tr>
            <tr>
                <td align="center">
                <!--------------------------------------------------->
                <table width="80%">
                    <tr>
                        <td>Your last login was on <?=mysqldate_show($_SESSION[ldate],1)?></td>
                        <td align="right">Balance  :  $ <strong><?php print $balsum;?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">Pending Transactions  :  $ <strong><?php print $sum1;?></strong></td>
                    </tr>
                </table>
                <!--------------------------------------------------->
                </td>
            </tr>
            <tr><td style="height:20px;"></td></tr>
            </table>
    
		</div>
	    <div >
            <table cellpadding="0" cellspacing="0" border="0" style="color:#2F5B67; font-size:12px;" width="100%" >
            <tr><td height="10px;"></td></tr>
            <tr>
            	<td>
<!------------------------------------------------Middle Body-------------------------------------------------------------->
<table border="1" cellspacing="0" cellpadding="4" width="80%" align="center" bgcolor="#ffffff">
	<tbody>
    <tr class="link">
    	<td class="bid_heading_txt"> 
        	<a href="<?=$vpath?>project-dtl.php?id=<?php print base64_decode($_GET[id]);?>" style="text-decoration:none; color:#2F5B67;">
            	<h2><?php print $row1[project];?></h2>
            </a>
        </td>
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
    	<td style="border-bottom:1px solid #b1ced9;border-top:1px solid #b1ced9;padding-left:10px">
        	<b>Job Summary :</b>
        </td>
    </tr>
    <tr class="link">
    	<td style="padding-left:8px">
        <table width="100%">
        	<tr>
            	<td width="25%">ID :</td>
                <td width="10%">&nbsp;</td>
                <td></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
            	<td>Job Type :</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
            	<td>Status :</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
            <tr>
            	<td>Budget Range :</td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
        </table>
        </td>
    </tr>
	<tr class="link" bgcolor="whitesmoke">
    	<td style="border-bottom:1px solid #b1ced9;border-top:1px solid #b1ced9;padding-left:10px">
        	<b>In how many days can you deliver a completed job? <font color="#FF0000" size="+1">*</font></b>
        </td>
    </tr>
	<tr class="link">
    	<td style="padding-left:30px">
        	<input type="text" id="delivery" name="delivery" maxlength="3" size="6" value=""> Day(s)
        </td>
    </tr>
	<tr class="link" bgcolor="whitesmoke">
    	<td style="border-bottom:1px solid #b1ced9;border-top:1px solid #b1ced9;padding-left:10px">
        	<b>Provide the details of your bid <font color="#FF0000" size="+1">*</font>:</b>
        </td>
    </tr>
	<tr class="link">
    	<td style="padding-left:30px">
        	<textarea rows="10" id="details" name="details" cols="50" style="width:80%" value=""></textarea>
        </td>
    </tr>
	<tr class="link">
    	<td style="padding-left:30px">
        	<input type="checkbox" name="outbid" value="y"> Notify me by e-mail if someone bids lower than me on this job.
        </td>
    </tr>
	<tr class="link">
    	<td style="padding-left:30px">
        	<input type="submit" value="Place Bid" name="submit" class="profilebutton">
        </td>
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
    
    	</div>
<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->
    </div>
    <!--end middle--> 
    <!-- rightside-->
    <!-- end rightside-->
<div class="clear"></div>
    </div>
  
    <div class="clear"></div>
<!-----------Footer----------------------------->
	<?php include 'includes/footer.php';?> 
<!-----------Footer End----------------------------->
     <div class="clear"></div>
      <!-- end job listing chart-->
</div>
<!--end content-->
<div class="clear"></div>
</div>
 </body>
</html>

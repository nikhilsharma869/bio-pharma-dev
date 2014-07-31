<?php
session_start();
include "configs/config.php";
include "configs/path.php";
CheckLogin();
?>
<?php
$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'"));
if(($_POST['sub']=='Add')||($_POST['sub']=='Update'))
{
	if($_POST['sub']=='Add')
	{ $st = 'added';}
	elseif($_POST['sub']=='Update')
	{ $st = 'updated';}
	$rs1 = mysql_query("update ".$prev."user set user_payoneeracc = '".$_POST['ppemail_txt']."' where user_id = '".$_SESSION['user_id']."'");
	if($rs1)
	{
		$res2=mysql_query("select * from ".$prev."mailsetup where mail_type=\"registration\"");
		$row=mysql_fetch_array($res2);
		$to  = $rw1['email'];
		$subject = 'Payoneer Account ID for Withdrawal';
		$message = '
		<html>
		<head>
		  <title>oDesk Notification</title>
		</head>
		<body>
			<p>&nbsp;</p>
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody>
				<tr>
					<td>'.html_entity_decode($row['header']).'</td>
				</tr>
			</tbody>
			</table>
		<br />
		Hi '.ucwords($rw1['fname']).',<br />
		<br />
		<p>You recently '.$st.' a payment withdrawal account in Payoneer.</p>

		<p>Please contact Customer Support if you did not authorize this change.</p>

		<p>Thanks,</p>
		<p>oOfficework Support</p>
		<br />
		'.html_entity_decode($row['footer']).'
		</body>
		</html>';
		//print $message;die();
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		mail($to, $subject, $message, $headers);
		print '<script>parent.location.href=\'withdraw.php\';</script>';
	}
	else
	{
		print 'DB Error, Please try later';
	}
}
?>
<html>
<head>
<script type="text/javascript">
function fun()
{
	parent.location.href='withdraw.php';
}
function funvalid()
{
	if(document.pp_frm.ppemail_txt.value=="")
	{
		alert('This field cannot be empty');
		document.pp_frm.ppemail_txt.focus();
		return false;
	}
	if(document.pp_frm.ppemail_txt.value!="")
	{
		if (echeck(document.pp_frm.ppemail_txt.value)==false)
		{
			document.pp_frm.ppemail_txt.value="";
			document.pp_frm.ppemail_txt.focus();
			return false;
		}
	}
return true;
}
function echeck(str)
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at);//search position of @
	var lstr=str.length;//length of the emil id
	var ldot=str.indexOf(dot)

	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr+1)//search as array if @ not exist||search if @ at first position||search if @ at the previous last position
	{
	   alert("Invalid E-mail ID")
	   return false
	}

	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr+1)//search as array if ( . ) not exist||search if ( . ) at first position||search if ( . ) at the previous last position
	{
		alert("Invalid E-mail ID")
		return false
	}

	 if (str.indexOf(at,(lat+1))!=-1)//"at" the search string item & "lat+1" is the starting point for searching i.e "@" occurs more than once
	 {
		alert("Invalid E-mail ID")
		return false
	 }

	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot)/* if ( . ) beforre @||if  ( . ) at 2 nd position after @ i.e ".@"||"@."
The substring() method extracts the characters from a string, between two specified indices, and returns the new sub string.

This method extracts the characters in a string between "from" and "to", not including "to" itself.
Syntax
string.substring(from, to)
*/
	 {
		alert("Invalid E-mail ID")
		return false
		
	 }

	 if (str.indexOf(dot,(lat+3))==-1)//id "." not present after 3 chr from "@"
	 {
		alert("Invalid E-mail ID")
		return false
	 }
	
	 if (str.indexOf(" ")!=-1)//if space is present in mailid
	 {
		alert("Invalid E-mail ID")
		return false
	 }

	 return true					
}

</script>
</head>
<body>
<style>

#myfrm1{
font-family:Arial, Helvetica, sans-serif;
}

</style>
<form name="pp_frm" action="" method="post" onSubmit="return funvalid();">
<table width="398" style="font-family:Arial, Helvetica, sans-serif;">
<tr><td colspan="2"><h2><?=$lang['PH_WELCOME']?> <?php print ucwords($rw1['fname']);?></h2></td></tr>
<!--<tr><td colspan="2">&nbsp;</td></tr>-->
<tr><td colspan="2"><p><?=$lang['pr_with']?> <b><?=$lang['pr_with1']?></b> <?=$lang['pr_with2']?> <font color="#0000FF"><?=$lang['pr_with3']?> </font><?=$lang['pr_with4']?></p><p><?=$lang['pr_with5']?> <font color="#0000FF"><?=$lang['pr_with6']?></font></p><p><?=$lang['pr_with7']?> <font color="#0000FF"><?=$lang['pr_with8']?></font> <?=$lang['pr_with9']?></font></p></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td width="177"><?=$lang['pr_with10']?></td>
    <td width="209"><input type="text" name="ppemail_txt" <?php if($rw1['user_payoneeracc']!='N') {?> value="<?php print $rw1['user_payoneeracc'];?>" <?php }?>></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td align="center">
<?php 
	if($rw1['user_payoneeracc']!='N') 
	{
?>
		<input type="submit" name="sub" value="<?=$lang['UPDATE']?>">
<?php
	}
	else
	{
?>
    	<input type="submit" name="sub" value="<?=$lang['pr_ad']?>">
<?php } ?>
	</td>
    <td><input type="button" name="sub" value="<?=$lang['pr_can']?>" onClick="return fun();"></td>
</tr>
</table>
</form>
</body>
</html>
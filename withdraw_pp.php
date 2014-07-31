<?php
session_start();
include "configs/path.php";
CheckLogin();
?>
<?php
$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'"));
if(isset($_POST['sub']) && (($_POST['sub']==$lang['pr_ad'])||($_POST['sub']==$lang['UPDATE'])))
{
	if($_POST['sub']==$lang['pr_ad'])
	{ $st = 'added';}
	elseif($_POST['sub']==$lang['UPDATE'])
	{ $st = 'updated';}
	$rs1 = mysql_query("update ".$prev."user set user_paypalacc = '".$_POST['ppemail_txt']."' where user_id = '".$_SESSION['user_id']."'");
	if($rs1)
	{
		$to  = $rw1['email'];
		
		$from = $setting['admin_mail'];
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='paypal_id_change' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailqf) == 0) {
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='paypal_id_change' AND `langid`='en'");
			}
	

			$mailrf = mysql_fetch_assoc($mailqf);
			

			$mailbodyf = html_entity_decode($mailrf['body']);
			
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $rw1['username'], $mailbodyf);
		$mailbodyf = str_replace("{old_id}", $rw1['user_paypalacc'], $mailbodyf);
		$mailbodyf = str_replace("{new_id}", $_POST['ppemail_txt'], $mailbodyf);
	
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
		$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
		
		mail($to, $subjectf, $mailbodyf, $headers);

		
		print '<script>parent.location.href=\'withdraw.html\';</script>';
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
	parent.location.href='withdraw.html';
}
function funvalid()
{
	if(document.pp_frm.ppemail_txt.value=="")
	{
		alert('<?=$lang['FIELD_CANNOT_BE_EMPTY']?>');
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
		alert("<?=$lang['INVALID_EMAILID']?>")
		return false
		
	 }

	 if (str.indexOf(dot,(lat+3))==-1)//id "." not present after 3 chr from "@"
	 {
		alert("<?=$lang['INVALID_EMAILID']?>")
		return false
	 }
	
	 if (str.indexOf(" ")!=-1)//if space is present in mailid
	 {
		alert("<?=$lang['INVALID_EMAILID']?>")
		return false
	 }

	 return true					
}

</script>
</head>
<body>
<style>
.submit_bott{ border:none;    padding:7px 11px 7px 11px;	margin:0px 5px 0px 0px;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:12px;	color: #FFFFFF;		text-align:center;	font-weight:bold;	background:#3268a3;float: left;	 	}	         
	.submit_bott:hover{border:none;	  padding:7px 11px 7px 11px;	margin:0px 5px 0px 0px;	font-family:Verdana, Arial, Helvetica, sans-serif;	font-size:12px;	color: #FFFFFF;		text-align:center;	font-weight:bold;	background:#1b4471;float: left; cursor:pointer; 	}
</style>
<form name="pp_frm" action="" method="post" onSubmit="return funvalid();">
<table width="398" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
<tr><td colspan="2"><h2><?=$lang['PH_WELCOME']?> <?php print ucwords($rw1['fname']);?></h2></td></tr>
<!--<tr><td colspan="2">&nbsp;</td></tr>-->
<tr><td colspan="2"><p><?=$lang['pr_with']?> <b><?=$lang['PAYPAL']?></b> <?=$lang['pr_with2']?> <font color="#1b4471"><?=$lang['pr_with3']?> </font><?=$lang['pr_with4']?></p><p><?=$lang['pr_with5']?> <font color="#1b4471"><?=$lang['pr_with6']?></font></p><p><?=$lang['pr_with7']?> <font color="#1b4471"><?=$lang['pr_with8']?></font> <?=$lang['pr_with9']?></font></p></td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td width="177"><?=$lang['pr_with10']?>:</td>
    <td width="209"><input style="padding:5px; border:1px solid #CCCCCC;" type="text" name="ppemail_txt" <?php if($rw1['user_paypalacc']!='N') {?> value="<?php print $rw1['user_paypalacc'];?>" <?php }?>></td>
</tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr>
	<td colspan="2" align="center">
<?php 
	if($rw1['user_paypalacc']!='N') 
	{
?>
		<input class="submit_bott" type="submit" name="sub" value="<?=$lang['UPDATE']?>">
<?php
	}
	else
	{
?>
    	<input class="submit_bott" type="submit" name="sub" value="<?=$lang['pr_ad']?>">
<?php } ?>	<input class="submit_bott" type="button" name="sub" value="<?=$lang['pr_can']?>" onClick="return fun();"></td>
    </tr>
</table>
</form>
</body>
</html>
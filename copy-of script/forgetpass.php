<?php 

	include "configs/path.php";

	session_start();
if($_SESSION[lang_id]){

$lang_file=mysql_fetch_array(mysql_query("select * from  " . $prev . "language where lang_id='".$_SESSION[lang_id]."'"));
	$lang_file['short_code'];

include("lang/".$lang_file['short_code'].".inc.php");

}
else{
    $_SESSION[lang_id] = 0;
	include("lang/fr.inc.php");
}

	if(isset($_REQUEST[pass_sub]))
		
	{
		if(!$_POST['email']){
			 $msg = "<font color=\"red\"><i>Please provide valid email id</i></font>";}
		else{

		$password = rand(1111111, 9999999);

		$res_user = mysql_query("select * from ".$prev."user where email = '".$_REQUEST[email]."'");

		if(mysql_num_rows($res_user)>0)

		{

			$row_user = mysql_fetch_array($res_user);

			$res_user_temp = mysql_query("update ".$prev."user set password = '".md5($password)."' where user_id = '".$row_user[user_id]."'");

			if($res_user_temp)

			{

				$mail_type="forgot_password";

				$row_mail_type = mysql_fetch_array(mysql_query("select * from ".$prev."mailsetup where mail_type = '".$mail_type."'"));

		

			
				$headers  = "MIME-Version: 1.0\r\n";

				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

				$headers .= "From: servilence.com\r\n";

				$headers .= "Reply-to: " . $setting['admin_mail'] . "\r\n";

				$subject = "Mail Password";

				$message = '

				<table width="80%" border="0" cellspacing="0" cellpadding="0">

					<tr>

		  				<td align="left" valign="top">

							<table width="80%" border="0" cellpadding="2" cellspacing="0"> 

		  					<tbody> 

		  						<tr> 

		  							<td> '.html_entity_decode($row_mail_type[header]) .'</td>

			 					</tr>

			 				 </tbody>

		   					</table>

						</td>

					</tr>

					<tr>

		  				<td align="left" valign="top"><strong>Your  Login Details</strong></td>

	    			</tr>

					<tr>

		  				<td align="left" valign="top">&nbsp;</td>

	    			</tr>

	  				<tr>

		 				<td align="left" valign="top"><strong>Your Username :'.$row_user[username].'</strong></td>

	  				</tr>

	  				<tr>

		 				<td align="left" valign="top"><strong>Your Login Password :'.$password.'</strong></td>

		  			</tr>

	   <tr>

		 <td align="left" valign="top">

		   <table width="80%" border="0" cellpadding="2" cellspacing="0">

		    <tbody> 

			 <tr> 

		  <td> '.html_entity_decode($row_mail_type[footer]).'</td>

		   </tr> 

			

			</tbody>

		   </table>

		 </td>

	  </tr>

	  </table>';

		$ret_mail=mail($row_user['email'],$subject,$message,$headers);

				if($ret_mail == true)

				{

					$msg = "<font color=\"green\"><i>Email with new password is successfully sent to your mail id.</i></font>";

				}

				else

				{

					$msg = "<font color=\"red\"><i>Mail cannot be sent, Please try later.</i></font>";

				}

			}

		}

		else

		{

			$msg = "<font color=\"red\"><i>This mail id is not registered with ".$dotcom.".</i></font>";

		}

	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<link href="style/style.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forget Password</title>
<script type="text/javascript" src="js/forgotpass.js"></script>
</head>

<body>
<form name="forgotpass_frm" action="" method="post" onsubmit="return forgotpass_valid();">
  <div style="width:400px; height:130px;">
    <div style="margin-bottom:10px; margin-top:10px; margin-left:10px;">
      <p style="font-family:Arial, Helvetica, sans-serif; font-size:18px;color:#3b5998; margin:0px;"><?php echo $lang['FORGOT_USERNAME_PASSWORD'];?></p>
    </div>
    
    <div style="float:left; color:#3B5998; margin-top:20px;">E-mail :
      <input type="text" id="email" name="email" required/>
      <input type="submit" name="pass_sub" value="<?php echo $lang['SUBMIT'];?>" class="submit_bott"/>
      <br>
      <br>
      <font color=red></font></div>
    <div style="clear:both;"> </div>
    <div style="width:370px;">
      <?php

if(isset($msg))

{

?>
      <div style="font-family:Arial, Helvetica, sans-serif; font-style:italic; font-size:12px; margin-top:10px;"><?php print $msg;?></div>
      <?php

}

else

{

?>
      <div id="errbox2" style="color:#F00; font-family:Arial, Helvetica, sans-serif; font-style:italic; font-size:12px;margin-top:10px;"></div>
      <?php

}

?>
    </div>
  </div>
</form>
</body>
</html>

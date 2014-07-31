<?php
ob_start();
include("includes/header_dashbord.php");
include("includes/access.php");
/*--------------------------------------------------+
| COMMUNITY CLASSIFIEDS SCRIPT                      |
+===================================================+
| File: admin/mailtemplates.php                     |
| Manage email templates                            |
+---------------------------------------------------+
| Copyright © 2005 Davis 'X-ZERO' John              |
| Scriptlance ID: davisx0                           |
| Email: support@xzeroscripts.com                   |
+--------------------------[ Sun, Oct 09, 2005 ]---*/




//require_once("aauth.inc.php");


if ($demo)
	$err = "Changes to templates cannot be saved in demo";


if (strpos($_POST['tpl'], "..") !== FALSE)
	$_POST['update'] = "";


if (!$demo && $_POST['update']) { # Update email template
	$tpl = stripslashes($_POST['tpl']);
	$fp = fopen("../mailtemplates/$_POST[filename]", "w") or $err = "Cannot open template file to write";

	if( empty( $err ) ) {
		fwrite($fp, $tpl);
		fclose($fp);
		
		$_SESSION['succ_msg'] = "Template &ldquo;$_POST[filename]&rdquo; Updated successfully.";
		pageRedirect( basename( $_SERVER['PHP_SELF'] ) );
	}
}


?>


<script language="javascript">
function insertVar(editpane, myvar)
{
	editpane.focus();
	if (editpane.selectionStart || editpane.selectionStart == '0')
	{
		var selstart = editpane.selectionStart;
		var selend = editpane.selectionEnd;
		
		editpane.value = editpane.value.substring(0, selstart) + myvar + editpane.value.substring(selend);
		editpane.selectionStart = selstart + myvar.length;
		editpane.selectionEnd = editpane.selectionStart;
	}
	else if (document.selection)
	{
		var txt = document.selection.createRange().text = myvar;
	}
	editpane.focus();
}
$(document).ready(function(){
  $("#newpost").click(function(){
    //$("#new_post").show();
	alert('hi');
  });
});
</script>
<div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->

        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Edit Email Templates</h1>
                    </div>
        
<p style="font-size:12px;"><?php ?>
	<a href="<?=$_SERVER['PHP_SELF']?>#newpost">New Post</a>
	- <a href="<?=$_SERVER['PHP_SELF']?>#newuser">New User</a>
	- <a href="<?=$_SERVER['PHP_SELF']?>#forgotpwd">Forgot Password</a>
	- <a href="<?=$_SERVER['PHP_SELF']?>#newimg">New Image</a>
	- <a href="<?=$_SERVER['PHP_SELF']?>#emailad">Email Ad</a>
	<?php //- <a href="#renew">Renew Ad</a> ?>
	- <a href="<?=$_SERVER['PHP_SELF']?>#contact_header">Contact User</a>
</p>


<?php if( !empty( $_SESSION['succ_msg'] ) ) { ?>
<div class="msg"><?php echo $_SESSION['succ_msg']; ?></div>
<?php unset( $_SESSION['succ_msg'] ); } ?>

<div class="err"><?php echo $err; ?></div>


<a name="newpost"></a>

<h1>New Post</h1>
    <form action="?" method="post" name="frmTemplate1" class="box">
        <table border="0">
          <tr>
            <td valign="top"> 
                <textarea name="tpl" cols="60" rows="20"><?php readfile("../mailtemplates/newpost2.txt"); ?></textarea>
                <br /><br />
                <input type="hidden" name="filename" value="newpost2.txt"/>
                <input type="hidden" name="update" value="1"/>
                <button type="submit">Update</button><br /><br />
            </td>
            <td width="10"></td>
            <td valign="top" class="hint">
                <table cellspacing="1" cellpadding="3">
                    <tr><td><b>Insert Variable</b></td></tr>
					<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate1['tpl'], '{@SITEURL}');">Siteurl</a></td></tr>
					<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate1['tpl'], '{@SITENAME}');">Sitename</a></td></tr>
					<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate1['tpl'], '{@USERNAME}');">User Name</a></td></tr>
                    <tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate1['tpl'], '{@ADTITLE}');">Post Title</a></td></tr>
                   <tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate1['tpl'], '{@ADID}');">Ad Id</a></td></tr>
					<tr><td>
			<?php  $mailview=file_get_contents("../mailtemplates/newpost2.txt");
$mailview=str_replace("{@SITEURL}", $vpath,$mailview);
$mailview=str_replace("{@SITENAME}", $dotcom,$mailview); 
echo $mailview;?>
<br /><br />
			
			</td></tr>
                </table>
            </td>
          </tr>
        </table>
    </form>

<br /><br />


<a name="newuser"></a>
<h3>New User</h3>
<form action="?" method="post" name="frmTemplate2new" class="box">
	<table border="0">
	  <tr>
		<td valign="top"> 
			<textarea name="tpl" cols="60" rows="20"><?php readfile("../mailtemplates/new_user_registration2.txt"); ?></textarea>
			<br /><br />
			<input type="hidden" name="filename" value="new_user_registration2.txt"/>
			<input type="hidden" name="update" value="1"/>
			<button type="submit">Update</button><br /><br />
		</td>
		<td width="10"></td>
		<td valign="top" class="hint">
			<table cellspacing="1" cellpadding="3">
			<tr><td><b>Insert Variable</b></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate2new['tpl'], '{@SITEURL}');">Siteurl</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate2new['tpl'], '{@SITENAME}');">Sitename</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate2new['tpl'], '{@USERNAME}');">User Name</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate2new['tpl'], '{@PASSWORD}');">Password</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate2new['tpl'], '{@EMAIL}');">Email</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate2new['tpl'], '{@CONFIRMVERIFICATIONLINK}');">Verify User Account Link</a></td></tr>
			<tr><td>
			<?php  $mailview=file_get_contents("../mailtemplates/new_user_registration2.txt");
$mailview=str_replace("{@SITEURL}", $vpath,$mailview);
$mailview=str_replace("{@SITENAME}", $dotcom,$mailview); 
echo $mailview;?>
<br /><br />
			
			</td></tr>
			</table>
		</td>
	  </tr>
	</table>
</form>
<br /><br />



<a name="forgotpwd"></a>
<h3>Forgot Password</h3>
<form action="?" method="post" name="frmTemplate9new" class="box">
	<table border="0">
	  <tr>
		<td valign="top"> 
			<textarea name="tpl" cols="60" rows="20"><?php readfile("../mailtemplates/forgot_pass2.txt"); ?></textarea>
			<br /><br />
			<input type="hidden" name="filename" value="forgot_pass2.txt"/>
			<input type="hidden" name="update" value="1"/>
			<button type="submit">Update</button><br /><br />
		</td>
		<td width="10"></td>
		<td valign="top" class="hint">
			<table cellspacing="1" cellpadding="3">
			<tr><td><b>Insert Variable</b></td></tr>
			<tr><td><b>Insert Variable</b></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate9new['tpl'], '{@SITEURL}');">Siteurl</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate9new['tpl'], '{@SITENAME}');">Sitename</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate9new['tpl'], '{@USERNAME}');">User Name</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate9new['tpl'], '{@PASSWORD}');">Password</a></td></tr>
			
			
			<tr><td>
			<?php  $mailview=file_get_contents("../mailtemplates/forgot_pass2.txt");
$mailview=str_replace("{@SITEURL}", $vpath,$mailview);
$mailview=str_replace("{@SITENAME}", $dotcom,$mailview); 
echo $mailview;?>
<br /><br />
			
			</td></tr>
			</table>
		</td>
	  </tr>
	</table>
</form>
<br /><br />







<a name="forgotpwd"></a>
<h3>Email Ad</h3>
<form action="?" method="post" name="frmTemplate10new" class="box">
	<table border="0">
	  <tr>
		<td valign="top"> 
			<textarea name="tpl" cols="60" rows="20"><?php readfile("../mailtemplates/emailad.txt"); ?></textarea>
			<br /><br />
			<input type="hidden" name="filename" value="emailad.txt"/>
			<input type="hidden" name="update" value="1"/>
			<button type="submit">Update</button><br /><br />
		</td>
		<td width="10"></td>
		<td valign="top" class="hint">
			<table cellspacing="1" cellpadding="3">
			<tr><td><b>Insert Variable</b></td></tr>
			<tr><td><b>Insert Variable</b></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate10new['tpl'], '{@SITEURL}');">Siteurl</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate10new['tpl'], '{@SITENAME}');">Sitename</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate10new['tpl'], '{@ADTITLE}');">Post Title</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate10new['tpl'], '{@FROM}');">From</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate10new['tpl'], '{@MESSAGE}');">Message</a></td></tr>
			
			<tr><td>
			<?php  $mailview=file_get_contents("../mailtemplates/emailad.txt");
$mailview=str_replace("{@SITEURL}", $vpath,$mailview);
$mailview=str_replace("{@SITENAME}", $dotcom,$mailview); 
echo $mailview;?>
<br /><br />
			
			</td></tr>
			</table>
		</td>
	  </tr>
	</table>
</form>
<br /><br />




<?php /* PENDING 
<a name="renew"></a>
<h3>Renew Ad</h3>
<form action="?" method="post" name="frmTemplate8" class="box">
	<table border="0"><tr>
		<td valign="top"> 
			<textarea name="tpl" cols="60" rows="20"><?php readfile("../mailtemplates/renew.txt"); ?></textarea>
			<br /><br />
			<input type="hidden" name="filename" value="renew.txt"/>
			<input type="hidden" name="update" value="1"/>
			<button type="submit">Update</button><br /><br />
		</td>
		<td width="10"></td>
		<td valign="top" class="hint">
			<table cellspacing="1" cellpadding="3">
			<tr><td><b>Insert Variable</b></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@SITENAME}');">Sitename</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@ADID}');">Ad ID</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@ADTITLE}');">Ad Title</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@ADURL}');">Ad URL</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@AD}');">Full Ad</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@EXPIRESON}');">Ad Expires On</a></td></tr>
			<tr><td><b style="color:#CC3300">&#8249;</b> <a href="javascript:insertVar(document.frmTemplate8['tpl'], '{@RENEWURL}');">Renew URL</a></td></tr>
			</table>
		</td>
	</tr></table>
</form>
<br /><br />
*/ ?>


                </div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div>




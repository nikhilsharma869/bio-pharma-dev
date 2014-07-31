<?php 
	include "configs/path.php"; 
	include("country.php");
	session_start();
	CheckLogin();
	$r=mysql_query("select * from  ". $prev . "user where  gold_member='Y' and user_id=" . $_SESSION[user_id] . " and gold_member_expire>'" . date("Y-m-d") . "'");
	if(@mysql_num_rows($r)):
 	 $gold_member=1;
	endif;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Account</title>
<link rel="stylesheet" href="css/style.css"/>
<link rel="shortcut icon" href="images/favicon.ico">


<script language="javascript" type="text/javascript">

function validateLogin(login1){
	
	if (login1.elements['username'].value == false){
        alert("Please enter a valid user name.");
        login1.elements['username'].focus();
        return false;
	} 
	if (login1.elements['password'].value == false){
        alert("Please enter password.");
        login1.elements['password'].focus();
        return false;
	} 
    return true;
}

</script>
</head>

<body>
<div id="container">

<!-----------Header----------------------------->
<?php include 'includes/header.php';?> 
<!-----------Header End-----------------------------> 
<div class="clear"></div>
<!-- content-->
<div id="content">
	<div id="about_cotent">
    <!--leftside-->
   
    <!-- left side-->
    <!-- rightside-->
	
	
	
	
	
	
    <div style="margin:20px 0 10px 0;" class="">
	
	
		<div style='padding-left:10px;padding-right:10px'>

			<table class="loginclass" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
			<td width="300">


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td>
<h2>Welcome <?=$_SESSION[username]?></h2>
</td>
<td align=right>
<?php if(!$gold_member){?>
<a style="text-decoration:none; color:#BB5E00; font-weight:bold;" href="upgrade-membership/">
<span >
<img src='images/gold-membership.png' width='25'   border="0" alt="" />Still you are not a gold member ?<br>Upgrade your membership and save more money!!
</span>
</a><?php }?>
</td>
</tr>
</table>
<form action="index.php?mode=profile" method="POST" name="_profile" id="_profile">
<table width="651" border="0" cellspacing="0" cellpadding="0">
	<tr>
    	<td align="left" valign="top"><img src="images/inner_bx-top.jpg" alt="image" width="651" height="10" /></td>
    </tr>
    <tr>
    	<td align="left" valign="top" class="bx-border">
			<table border="0" cellpadding="10" cellspacing="0" align="center" width="100%" >
			<tr valign="top" class="subtitle">
					<td style="border-bottom:1px solid #87b0b1; color:#3387b1;">					
					Your last login was on <?=mysqldate_show($_SESSION[ldate],1)?><br><br></td>
			<td style="border-bottom:1px solid #87b0b1; color:#3387b1;"></td>
			</tr>
     		<?php
				$da1=mysql_query("select * from ".$prev."announcement where status='Y' order by date desc limit 0,5");
				if(@mysql_num_rows($da1))
				{
					echo"<tr valign='top' class='subtitle'><td>Announcement</td></tr>";
					while($da=@mysql_fetch_array($da1))
					{
					    ?>
						<tr><td align="left" valign="top"><strong><?=$da['title']?></strong></a></b>
						<br/>
						<?=nl2br($da['announcement'])?>
						</td></tr>
						<?php
					}
				}
				?>
				
			<tr><td class=subtitle>Your extername profile url</td></tr>
			<tr><td class=link>

			Your external profile is at: <strong><?=$vpath . "/viewprofile/" . getusername($_SESSION[user_id])?>/</strong>
            </td></tr>
             <tr><td class=subtitle>RSS Feeds</td></tr>
			 <tr><td>Coming soon...</td></tr>
			 <tr><td class=subtitle>If you have success story</td></tr>
			 <tr class=link><td>If you have something good to share with our other members about <?=$dotcom?>,please <a href='<?=$vpath?>post-feedback/' class=link><u>submit here</u></a>. </td></tr>
       </table>
    </td>
	</tr>
	
	<tr>
		<td align="left" valign="top" class="inner_bx-bottom">
		<table align="center" width="100%" cellpadding="0" cellspacing="0">
			<tr class="lnk"><td width=32%></td>
			<td >
			<br />
			<br />
		
			<br />
			</td>
			</tr>
		</table>
		</td>
	</tr>
</table>
</form>
			</td>
			<td valign="top" align="left" style="padding:44px 0 0 0; "><?php include("includes/right.php");?>
			</td>
			</tr>
			</table>

		
	
	
	
	
	</div>
    
    </div>
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

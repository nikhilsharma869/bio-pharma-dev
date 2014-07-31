<?php 
include "includes/header.php"; 
CheckLogin();
	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
?>
<?php
//if(!$link){header("Location: ./index.php"); exit();}
if($_REQUEST['user_id']){$user_id=$_REQUEST['user_id'];}else{$user_id=getuserid($_REQUEST['viewprofile']);}
if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}

//echo $user_id;


include("country.php");
$e=mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]); 
$data=@mysql_fetch_array($e);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php print $row_settings[meta_keys];?>" />
<meta name="description" content="<?php print $row_settings[meta_desc];?>" /> 
<title><?php print $row_settings[site_title];?></title>
<link rel="stylesheet" href="css/style2.css"/>

<link rel="shortcut icon" href="images/favicon.ico">

<script>
function ValidateForm(form1) {
	

	if (form1.elements['rate'].value == '') {
		alert('Please enter your rate/hour.');
		form1.elements['rate'].focus();
		return false;
	}
	if (form1.elements['profile'].value == '') {
		alert('Please enter profile details.');
		form1.elements['profile'].focus();
		return false;
	}
	
	return true;
}
</script>	


<script type="text/javascript" src="domcollapse.js"></script>
<style type="text/css">
		@import "ottools.css";
		/* domCollapse styles */
		@import "domcollapse.css";
</style>
<style type="text/css">
.bx_top {
    background: url("images/bx-top.jpg") no-repeat scroll left top transparent;
    height: 34px;
    width: 262px;
}
.bx_repeat {
    background-color: #E5F4F5;
    border-left: 1px solid #7AC9CC;
    border-right: 1px solid #7AC9CC;
}
.myaccviewprofile {
    background-color: #3B5998;
    border: 1px solid #CCCCCC;
    color: #FFFFFF;
    cursor: pointer;
	font-size:14px;
    font-weight: bold;
    padding: 4px 20px;
    text-shadow: 1px 1px 1px #CCCCCC;
}
.nav_profile{width:482px; height:29px; border-bottom:1px solid #235098;}
.nav_profile ul{margin:0px 0px 0px 10px;}
.nav_profile li{float:left; margin:0px 2px 0px 0px;}
.nav_profile li a{display:block; height:28px; border-left:1px solid #003399; border-right:1px solid #003399; border-top:1px solid #003399; text-decoration:none; padding:0px 10px 0px 10px; line-height:28px; font-size:14px; font-weight:bold; background:url(images/p_navbg.gif) repeat-x; color:#235098;}
.nav_profile li a:hover{background:url(images/p_navhover.gif) repeat-x;}



.rightside_box {
    background: url("images/bg_rigthboxhead.gif") repeat-x scroll center top #ECF3F8;
    border: 1px solid #CED5E5;
    border-radius: 5px 5px 5px 5px;
    margin: 20px 0 0 20px;
    padding: 0 0 15px;
    width: 260px;
}
.rightside_box ul {
    float: left;
	padding:0 0 0 5px;
}
style2.css (line 64)
.leftul {
    margin: 10px 0 10px 10px;
    width: 150px;
}
.leftul li {
    background: url("images/bullet3.png") no-repeat scroll 0 35% transparent;
    border-bottom: 1px dotted #0033FF;
    color: #1E5A6B;
    font-size: 13px;
    font-weight: bold;
    height: 30px;
    padding-top: 5px;
}
.leftul li span {
    line-height: 0;
    padding: 0 0 0 10px;
}
.rightside_box ul {
    float: left;
}
.rightul {
    margin: 10px 10px 0 0;
    width: 90px;
}
.leftul li span {
    line-height: 0;
    padding: 0 0 0 10px;
}
.leftul li span a {
    color: #1E5A6B;
    text-decoration: none;
}
.rightul li {
    border-bottom: 1px dotted #0033FF;
    color: #1E5A6B;
    font-size: 13px;
    height: 30px;
    line-height: 16px;
    padding-top: 5px;
    text-align: right;
}
.rightside_box ul {
    float: left;
}
.leftul {
    margin: 10px 0 10px 10px;
    width: 140px;
}
.singuptest {
    color: #3B5998;
    font-family: Arial,Verdana,Sans-serif;
    font-size: 26px;
    font-weight: normal;
    letter-spacing: -1px;
    margin-bottom: 20px;
    padding-bottom: 5px;
    width: 100%;
}
.link {
    color: #2F5B67;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-style: normal;
    font-weight: normal;
    text-decoration: none;
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
	<?php include 'includes/leftpanel.php';?> 
    <!-- left side-->
    <!--middle -->
		<?php
					$r = mysql_query("SELECT * FROM " . $prev . "user where status='Y' and (username='".$user_id."' or user_id='".txt_value($user_id)."')");
					$d=@mysql_fetch_array($r);
					if(empty($d['user_id'])){header("Location: ".$vpath); exit();}
					$user_id=$d['user_id'];
					?>
	
    <div class="middle left">
	
    	
       		<link rel="stylesheet" type="text/css" href="ajaxtabs/ajaxtabs.css" />
					<script type="text/javascript" src="ajaxtabs/ajaxtabs.js"></script>
						
						
						
						<div class="nav_profile">
					  <ul id="countrytabs" class="tab_box">
						<li class=heading_intro_blue_txt><a href="#" rel="#default" class="selected"><?=$lang['PROFILE_PGN']?></a></li>
						<li class=heading_intro_blue_txt><a href="portfolio.php?user_id=<?=$user_id?>"  rel="countrycontainer"><?=$lang['PRTFLO']?></a></li>
						<li class=heading_intro_blue_txt><a href="activities.php?user_id=<?=$user_id?>" rel="countrycontainer"><?=$lang['ACTIVITIES']?></a></li>
						<li class=heading_intro_blue_txt><a href="reviews.php?user_id=<?=$user_id?>" rel="countrycontainer"><?=$lang['REVIEWS']?></a></li>
						<li class=heading_intro_blue_txt><a href="invite_provider.php?user_id=<?=$user_id?>" rel="countrycontainer"><?=$lang['INVITE']?> <?=getusername($user_id);?></a></li>
						</ul>
					</div>	
						
						
						<!--<div>
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
						<tr>
						<td width="10%" style="padding:0 5px 2px 0;"><input type="Button" class="myaccviewprofile" onclick="JavaScript:window.location.href='viewprofile.php?user_id=<?=$user_id?>';" value="Profile"></td>
						<td width="10%" style="padding:0 5px 2px 0;"><input type="Button" class="myaccviewprofile" onclick="JavaScript:window.location.href='portfolio.php?user_id=<?=$user_id?>';" value="Portfolio"></td>
						<td width="10%" style="padding:0 5px 2px 0;"><input type="Button" class="myaccviewprofile" onclick="JavaScript:window.location.href='activities.php?user_id=<?=$user_id?>';" value="Activities"></td>
						<td width="10%" style="padding:0 5px 2px 0;"><input type="Button" class="myaccviewprofile" onclick="JavaScript:window.location.href='reviews.php?user_id=<?=$user_id?>';" value="Reviews"></td>
						<td width="10%" style="padding:0 5px 2px 0;"><input type="Button" class="myaccviewprofile" onclick="JavaScript:window.location.href='invite_provider.php?user_id=<?=$user_id?>';" value="Invite <?=getusername($user_id);?>"></td>
						<td></td>
						</tr>
						</table>
						</div>-->
						
						
						<table width="480" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td align="left" valign="top" class="bx-border1">
						<div id="countrydivcontainer" style="width:100%;margin-bottom: 1em; padding-right:10px;">
								<table border="0" cellspacing=0 align=center cellpadding=4 width=98%>
								<?
								
							
								if(!$d[profile]){$d[profile]="Profile not updated yet.";}
								echo'<tr class=link ><td  valign=top colspan=2>' . nl2br($d[profile]) . '</td></tr>';
								
								
								$txt="";
								$rr=mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "cats where " . $prev . "categories.cat_id=" . $prev . "cats.cat_id and " . $prev . "cats.user_id=" . $user_id);
								while($dd=@mysql_fetch_array($rr)):
								   $txt.=$dd[cat_name] . ",";
								endwhile;
								$tx=substr($txt,0,-1);
								if($tx):
									echo'<tr class=link ><td  valign=top colspan=2><b>Area(s) of Expertise </b><br><br>
									' . $tx . '</td></tr>';
								endif;
							?>
								
								
							
							
							<tr>
								<td align=right colspan=2><a href="javascript://" onclick="javascript:window.open('<?=$vpath?>pop-violation.php?bidder_id=<?=$userid?>','_new','width=500,height=400,left=100,top=80,addressbar=no');"><img src='images/report-violation.gif' border=0></a></td>
							</tr>
							</table>
						</div>
					
					</td>
					<tr>
							<td align="left" valign="top" class="inner_bx-bottom1">&nbsp;
						   
							</td>
						</tr>
					</table>
	   
    </div>
    <!--end middle--> 
    <!-- rightside-->
	<?php include 'includes/rightpanel.php';?>     
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
<script type="text/javascript">

var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")
countries.setpersist(true)
countries.setselectedClassTarget("link") //"link" or "linkparent"
countries.init()

</script>
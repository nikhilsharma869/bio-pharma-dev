<?php
session_start();
include "configs/config.php";
include "configs/path.php";
include "logincheck.php";
?>
<?php
$res1=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");
$row1=mysql_fetch_array($res1);
$res=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");
$row=mysql_fetch_array($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My Posted Jobs</title>
<link href="css/master.css" rel="stylesheet" type="text/css" media="all" />
<!--<link href="css/home__user.css" rel="stylesheet" type="text/css" media="all" />-->
<link href="css/index__user.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/globals__user1.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/applications__user.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/globals__visitor.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
hs.minHeight =300 ;
hs.minWidth =450 ;
hs.creditsText = '<i>Feedback Rating</i>';
</script>
</head>
<body>
<!--wrapper -->
<div id="wrapper">
<!--header -->
<div id="header">
<?php
	include "includes/innerheader.php";
?>
</div>
<!--header end-->
<!--nav_facebook -->
<div id="nav_facebook">
<!--nav -->
 <div id="tabs8">
<ul>
<?php
 if($row['user_id'])
 {
 ?>
 <li><a href="sing_in_iner_1.php"><span>Home</span></a></li>                              
 <?php
 }
 else
 {
?>
 <li><a href="sing_in_iner.php"><span>Home</span></a></li>
<?php
 }
?>
<li><a href="browse_job.php"><span>Find Work</span></a></li>
<li id="current"><a href="active.php"><span>My Jobs</span></a></li>
<li><a href="payment.php"><span>Wallet</span></a></li>
</ul>
</div>
<!--nav end-->
<!--face_book-->
<div class="face_book">
<?php $tst = mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));?>
<a href="http://<?php print $tst['twitter_url'];?>"><img src="images/t.png" height="19" width="20" alt="" /></a>
<a href="http://<?php print $tst['facebook_url'];?>"><img src="images/f.png" height="19" width="20" alt="" /></a>
<a href="http://<?php print $tst['linkedin_url'];?>"><img src="images/in.png" height="19" width="19" alt="" id="f_m" /></a>
</div>
<!--face_book end-->
<!--name -->
<div class="name">
<h1><a href="logout.php">Logout</a></h1>

<a href="notification.php"><img src="images/2s.png"  height="16" width="16" alt="" align="right" /></a>
<a href="inbox.php"><img src="images/3s.png" height="13" width="18" alt="" align="right" style="margin:2px 10px 0 0;" /></a>
</div>
<!--name end-->
</div>
<!--nav_facebook end-->
<!--sing_in_iner -->
<div class="sing_in_iner">
<!--sing_in_iner_menu -->
<div class="sing_in_iner_menu">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" valign="middle"><a href="browse_job.php" style="color: #000099; font-weight:bold;">Find Jobs</a></td>
    <td align="center" valign="middle"><a href="active.php" style="color:#000099; font-weight:bold;">Job Applications</a></td>
    <td align="center" valign="middle"><a href="user_info.php" style="color:#000099; font-weight:bold;">Profile</a></td>
    <td align="center" valign="middle"><a href="my_project.php" style="color:#0000; font-weight:bold;">My Posted Jobs</a></td>
	<td align="center" valign="middle"><a href="my_bids.php" style="color:#000099; font-weight:bold;">My Bids</a></td>
   <!-- <td align="center" valign="middle"><a href="#s" style="color:#000099; font-weight:bold;">Tests</a></td>-->
  </tr>
</table>
</td>
    <td width="50%"><!--<a href="#s" class="sing_in_iner_menu_search"></a>
<input name="" type="text" />
<select name="">
<option>------------------------</option>
</select>-->
</td>
  </tr>
</table>



</div>
<?php
	include "includes/message.php";
?>

<!--messages_lft -->

<?php
if($row1['status']=='N')
{
?>
<div id="messages">
<div id="messages_lft"></div>
<!--messages_lft end-->
<!--messages_mid -->
<div class="messages_mid">
<h1><b>Please verify your email - a confirmation message was sent to <?php print $row1['email'];?></b><br />
You will have limited access to oOfficework until you verify.</h1>
</div>
<div id="messages_right"></div>
</div>
<?php
	}
?>
<!--sing_in_iner_menu end-->

<!-- -->

<!-- -->
<!--pro_up -->
<div id="pro_up">
<div id="bgBar"></div>
<noscript style="font-family:Verdana;font-size:10px;font-weight:bold;color:red;width:100%;">
 Javascript must be enabled to properly navigate this site. 
</noscript>
<?php
if($row1['company']!="")
{
?>
<div id="teamBar">
 <ul>
  <li id="teamSelectorContainer">
   <span class="small">Team:</span>
    <?php print $row1['company'];?> 
   <span class="small">&nbsp;</span> 
  </li> 
 </ul> 
</div>
<?php
}
?>
<div id="MUAAlert">
 <div id="MUAAlertShadow">&nbsp;</div> 
 <div id="MUAAlertWindow">
  <h3></h3> 
  <div class="contents"> </div> 
 </div> 
</div>
<div id="globalAlerts"> <!-- Global Alerts and Notifications go Here --> </div>
<div id="pageTitle">
 <div>
  <div class="breadcrumb">My Projects </div> 
 </div>
</div>
<div id="mainBody" class="layout1" style="background:#fff;" >
 <div id="col1">
  <div id="AcSelector">
   Agency Contractor:
    <?php print $row1['fname']." ".$row1['lname'];?>
   <input type="hidden" id="uri" value="/agencies/Scriptgiant:Scriptgiant"> 
   <input type="hidden" id="action" value="active"> 
  </div> 
  <!--<div class="tabBar">
   <ul class="tabs">
    <li class="current">
	<a href="/agencies/Scriptgiant:Scriptgiant/users/scriptgiant/applications/active/">Active</a>
	</li> 
	<li class="">
	 <a href="#s" style="color:#0000FF;">Archived</a>
	</li> 
   </ul> 
  </div>-->
  <?php
  $res2=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."' and status = 'Y'");
  $no=mysql_num_rows($res2);
   ?> 
  <table class="tabularData" name="interviewsTable">
   <caption>
   Running Projects (<?php print $no;?>) 
   <!--<span class="helpTip __ppDone" title="" bt-xtitle="These are job applications that you are discussing with an employer."></span>-->
   </caption> 
   <tbody>
    <tr> 
	 <th class="columnDate">Creation Date</th>
	 <th class="columnSubject">Project Name</th> 
	 <th class="columnBuyer">Company</th> 
	 <th class="columnBuyer">Details</th>
	</tr> 
	<?php
	if($no>0)
	{
		while($row2=mysql_fetch_array($res2))
		{
		$res3=mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'"));
		$date=strtotime($row2['creation']);
	?>
		<tr>
	 		<td name="noActiveInterviews"><?php print date('F d, Y',$date);?></td>
			<td name="noActiveInterviews"><?php print ucwords($row2['project']);?></td>
			<td name="noActiveInterviews"><?php print $res3['company'];?></td>
			<td name="noActiveInterviews"><a href="project_details.php?id=<?php print $row2['id'];?>" style="color:#0066FF">View Details</a></td>
		</tr>
	<?php
		}
	}
	else
	{
	?>
	<tr>
	 <td colspan="4" class="centered noData" name="noActiveInterviews">No Active Applications</td>
	</tr>
	<?php
	}
	?> 
   </tbody>
  </table>
    <table class="tabularData" name="interviewsTable">
   <caption>
   Completed Projects 
   <!--<span class="helpTip __ppDone" title="" bt-xtitle="These are job applications that you are discussing with an employer."></span>-->
   </caption> 
   <tbody>
    <tr> 
	 <th class="columnDate">Creation Date</th>
	 <th class="columnSubject">Project Name</th> 
	 <th class="columnBuyer">Bidder Name</th> 
	 <th class="columnBuyer">Feedback</th>
	</tr> 
   <?php
   $bid_amount = 0.00;
   $contractor_id = '';
$rw1 = mysql_query("select * from ".$prev."projects where user_id = '".$_SESSION['user_id']."' and status = 'Y'");
if(mysql_num_rows($rw1)>0)
{
	while($rw2 = mysql_fetch_array($rw1))
	{
		$rw3 = mysql_query("select * from ".$prev."buyer_bids where project_id = '".$rw2['id']."' and chose = 'Y'");
		if(mysql_num_rows($rw3)>0)
		{
			$rw4 = mysql_fetch_array($rw3);
			$bid_amount = floatval($rw4['bid_amount']);
			$contractor_id = $rw4['bidder_id'];
			$rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from ".$prev."escrow where bidid = '".$rw4['id']."' and status = 'Y'"));
			if($rw5['escrow_amount'] >= $bid_amount)
			{
				$rs1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$contractor_id."'"));
		?>
                <tr>
                    <td name="noActiveInterviews"><?php print date('F d, Y',strtotime($rw2['creation']));?></td>
                    <td name="noActiveInterviews"><?php print ucwords($rw2['project']);?></td>
                    <td name="noActiveInterviews"><?php print ucwords($rs1['fname']).' '.ucwords($rs1['lname']);?></td>
                    <td name="noActiveInterviews">
         <?php
         $rw6 = mysql_query("select * from ".$prev."feedback where project_id = '".$rw2['id']."' and bidid = '".$rw4['id']."' and feedback_from = '".$_SESSION['user_id']."' and feedback_to = '".$contractor_id."'");
		 if(mysql_num_rows($rw6)>0)
		 {
			 $rw7 = mysql_fetch_array($rw6);
	   ?>
	   <span class="feedbackRating starsMedium rating<?php print $rw7['avg_rate'];?> __ppDone" title="" > </span>&nbsp;&nbsp;&nbsp;
       <a href="employer_rating_view.php?rid=<?php print $rw7['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" style="color:#0066FF">View</a>
	   <?php
		 }
		 else
		 {
	   ?>
	   <a href="employer_rating.php?pid=<?php print $rw2['id'];?>&bid=<?php print $rw4['id'];?>&eid=<?php print $_SESSION['user_id'];?>&cid=<?php print $contractor_id;?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" style="color:#0066FF">Give Feeback</a>
	   <?php
		 }
		 ?>
                    
                    	
                    </td>
                </tr>
		
		<?php
			}
		}
	}
}
?> 
   </tbody>
  </table> 
</div> 
<div class="clearb"></div> 
</div>
</div>
<!--pro_up end-->
</div>
<!--sing_in_iner end-->
</div>
<!--wrapper end-->
<!--footer -->
<div id="footer">
<?php include "includes/footer.php";?>
</div>
<!--footer end-->
</body>
</html>

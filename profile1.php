<?php 
include "includes/header.php"; 
CheckLogin();
	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));
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
    <div class="middle left">
    	<div class="nav">
        	<ul>
        		<li><a href="#">Profile</a></li>
                <li><a href="#">Portfolio</a></li>
                <li><a href="#">Activities</a></li>
                <li><a href="#">Reviews</a></li>
                <li><a href="#">Skills</a></li>
            
            </ul>
        </div>
        <div class="clear"></div>
        <div class="profile">
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuriesrelease.</p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem </p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the i</p>
        <p>Lorem Ipsum is simply dummy text of the</p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuriesrelease.</p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard </p>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard </p>
        <p>Lorem Ipsum is simply </p>
        <p>Lorem Ipsum</p>
        <p>Lorem Ipsum is simply dummy </p>
        <p>Lorem Ipsum</p>
        <p>Lorem Ipsum is simply </p>
        <p>Lorem Ipsum is simply dummy </p>
        </div>
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

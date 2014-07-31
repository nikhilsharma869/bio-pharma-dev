<?php 
include "includes/header.php"; 
CheckLogin();
	$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='Looking For Workers'"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php print $row_content[meta_keys];?>" />
<meta name="description" content="<?php print $row_content[meta_desc];?>" /> 
<title><?php print $row_content['site_title'];?></title>
<link rel="stylesheet" href="css/style.css"/>
<link rel="shortcut icon" href="images/favicon.ico">
</head>

<body>
<div id="container">
<!-----------Header----------------------------->
<?php include 'includes/header.php';?> 
<!-----------Header End----------------------------->
<div class="clear"></div>
<!-- content-->
<div id="content">
	<div id="contact">
    <!--leftside-->
    
    <?php echo html_entity_decode($row_content['contents']);?>
  
    <!-- left side-->
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
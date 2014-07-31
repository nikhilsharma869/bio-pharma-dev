<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php print $setting[meta_keys];?>" />
<meta name="description" content="<?php print $setting[meta_desc];?>" /> 
<title><?php print $setting[site_title];?></title>
<link href="style/style.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="images/favicon.ico">
		
</head>

<style type="text/css">
<!--
.header {
	font-family: verdana, helvetica, sans-serif; 
	font-size: 11pt; 
	color: black; 
	font-weight: bold
}

.white {background-color: white}

body {
	font-family: arial, sans-serif;
	font-size: 12px;
	text-align: left;
	color: #363636;
}

.medium {background-color: #316293}

.text{
	font-family: verdana, sans-serif;
	font-size: 10pt;
}

.title {
	font-family: verdana, sans-serif;
	font-size: 10pt;
	font-weight: bold;
}

-->
</style>

<script language="JavaScript1.1">

	function exit_close()
	{

//		

//		
//		alert('a Question');
//		


	  var fname = "";
	  var id = "";
	  opener.addOption(id,fname,0);
	  window.close();
		
	}
	
	
</script>

<!-----------Header End-----------------------------> 


<!-- content-->
<div class="freelancer">


<!--Profile-->
<?php include 'includes/leftpanel1.php';?> 
<div class="profile_right">

<div class="edit_profile">
	<h2>Welcome <?php print $_SESSION['fullname'];?><br />
	<span>Your last login was on <?=mysqldate_show($_SESSION[ldate],1)?></span></h2>
	
	<div align="right" style="padding-right:10px;">
	Balance  :  $ <strong><?php print $balsum;?></strong><br />
	Pending Transactions  :  $ <strong><?php print $sum1;?></strong>
	</div>
	<!--<ul>
	<li ><a href="profile.php">Update Profile</a></li>
	<li ><a href="select-expertise.php">Update Expertise</a></li>
	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>
	
	
	</ul>-->
	</div>
   
    
	
	
<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->
<div class="edit_form_box">

<form method="post" ENCTYPE="multipart/form-data" action="">
<br>

<!--OUTER GREY BORDER TABLE BEGINS HERE-->
<table align=center border=0 cellPadding=1 cellSpacing=0 class=medium width=380>
  <Tr>
    <Td vAlign=top>
      <table align=center border=0 cellPadding=8 cellSpacing=0 class=white width="100%">
      
      
      
      	<tr>
      		<td colspan="2" class="header" class="header">
      			Select file and click Upload: 
      		</td>
      	</tr>
      	<tr>
      		<td colspan="2" class="text" align="center">(Maximum 10,240 Kbytes.)</td>
      	</tr>
      	<tr>
      		<td class="title">File:</td>
      		<td><input type="file" name="upload"></td>
      	</tr>
      	<tr>
      		<td colspan="2" class="text" align="center">This could take several minutes, please wait</td>
      	</tr>
      	<tr>
			<td colspan="2" align="center"><input type="submit" value="Upload"></td>
      		
      	</tr>
      	
      </table>
    </td>
  </tr>
</table>
<input type="hidden" name="upload_file" value="1">
</form>

</div>

</div>
</div>


</div>
</div>
</div>
</div>
<?php include 'includes/footer.php';?> 
</body>
</html>
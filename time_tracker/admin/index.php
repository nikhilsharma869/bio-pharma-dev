<?php
session_start();
include("main.php");
if(isset($_POST["submit"])){
		if($_POST["user_id"] =='admin' and $_POST["user_pass"]=='admin'){
		$_SESSION["user_id"]="admin";
	    $_SESSION["user_pass"]="admin";
				header("location:create_user.php");
	}else{
		echo "INVALID USER ID OR PASWORD" ;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LOGING</title>
</head>

<body>
<div>
<form action="" method="post">
<table align="center" border="1">
   <th bgcolor="#3300FF" colspan="2">LOGIN PANEL</th>
   <tr>
   	<td>USER NAME:</td>
    <td><input type="text" name="user_id" /></td>
   </tr>
  <tr>
  	<td>USER PASSWORD:</td>
    <td><input type="password" name="user_pass" /></td>
  </tr>
  <tr>
  	<td align="right" colspan="2"><input type="submit" name="submit"  value="Login"/><input type="reset"  value="Cancel"/></td>
  </tr>
</table>
</form>
</div>
</body>
</html>
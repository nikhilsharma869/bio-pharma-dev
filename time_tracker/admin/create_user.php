<?php
session_start();
include('main.php');
if($_SESSION["user_pass"]!="admin" and $_SESSION["user_id"]!="admin"){
	header("location:index.php");
}
if(isset($_POST["submit"])){
	$user_name=$_POST['user_name'];
	$user_email=$_POST['user_email'];
	$user_id=$_POST['user_id'];
	$user_pass=$_POST['user_pass'];
$sql="insert into mm_user(user_name,user_password,user_vname,user_email)values('$user_id','$user_pass','$user_name','$user_email')";
//echo $sql;exit;
$sql_query=mysql_query($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" />
<title>Create User</title>
</head>
<body>
<?php include("includes/menu.php");?>
<div class="boby_t">
    <table align="center" border="1">
    <th colspan="2" bgcolor="#3399FF"><h2>Create New User</h2></th>
    <form action="" method="post">
    <tr>
    	<td><label>User Name:</label></td>
        <td><input type="text" name="user_name" /></td>
    </tr>
    <tr>
    	<td><label>User E-mail Id:</label></td>
        <td><input type="text" name="user_email" /></td>
    </tr>
    <tr>
    	<td><label>User ID:</label></td>
        <td><input type="text" name="user_id" /></td>
    </tr>
    <tr>
    	<td><label>User Password:</label></td>
        <td><input type="password" name="user_pass" /></td>
    </tr>
    <tr>
    	<td align="right" colspan="2" ><input  type="submit" name="submit"	 value="Submit" /><input type="reset" value="Cancel" /></td>
    </tr>
    
    </form>
</table>
</div>
</body>
</html>
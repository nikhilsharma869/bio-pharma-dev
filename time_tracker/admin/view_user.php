<?php
session_start();
include_once('main.php');
if($_SESSION["user_pass"]!="admin" and $_SESSION["user_id"]!="admin"){
	header("location:index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" />
<title>View User</title>
</head>
<body>
<?php include("includes/menu.php");?>
<div class="boby_t">
<table align="center" border="1">
 <th colspan="5" bgcolor="#3399FF"><h2>View User</h2></th>
  <tr bgcolor="#336699">
    <th>USER NAME</th>
	<th>USER E-MAIL</th>
    <th>USER ID</th>
    <th>USER PASSWORD</th>
    <th>ACTION</th>
  </tr>
 <?php
    $sql = 'select *from freelan_user';
 	$sql_query=mysql_query($sql);
	while($user_view=mysql_fetch_object($sql_query))
	{
  ?>
  <tr>
    <td><?php echo $user_view->user_vname;?></td>
    <td><?php echo $user_view->user_email;?></td>
    <td><?php echo $user_view->user_name;?></td>
    <td><?php echo $user_view->user_password;?></td>
    <td><a href="#"> EDIT</a></td>
   </tr>
  <?php
	}
	?>
</table>
</div>
</body>
</html>
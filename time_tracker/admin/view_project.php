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
<title>View Project</title>
</head>
<body>
<?php include("includes/menu.php");?>
<div class="boby_t">
<table border="1">
 <th colspan="5" bgcolor="#3399FF"><h2>View Project</h2></th>
  <tr bgcolor="#336699">
    <th>PROJECT TITLE</th>
	<th>PROJECT DESCRIPTION</th>
    <th>PROJECT BY</th>
    <th>PROJECT USER</th>
    <th>ACTION</th>
  </tr>
 <?php
 	$sql_query=mysql_query("SELECT * 
FROM  `mm_project` inner join `mm_user` on `mm_project`.`project_uid`=`mm_user`.`user_id`");
	while($user_project=mysql_fetch_object($sql_query))
	{
  ?>
  <tr>
    <td><?php echo $user_project->project_title;?></td>
    <td><?php echo $user_project->project_desc;?></td>
    <td><?php echo $user_project->project_by;?></td>
    <td><?php echo $user_project->user_vname;?></td>
    <td><a href="view_progress.php?id=<?php echo $user_project->project_id;?>"> VIEW PROGRESS</a></td>
   </tr>
  <?php
	}
	?>
</table>
</div>
</body>
</html>
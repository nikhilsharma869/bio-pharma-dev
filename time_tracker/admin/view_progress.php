<?php
session_start();
include_once('main.php');
if($_SESSION["user_pass"]!="admin" and $_SESSION["user_id"]!="admin"){
	header("location:index.php");
}
if(!isset($_GET['id'])){
    header("location:index.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" />
<title>View Progress</title>
</head>
<body>
<?php include("includes/menu.php");?>
<div class="boby_t">
 <?php
 	$pro=mysql_query("SELECT * FROM  `mm_project_work` inner join `mm_project` on `mm_project_work`.`project_id`=`mm_project`.`project_id` inner join `mm_user` on `mm_project_work`.`user_id`=`mm_user`.`user_id` where `mm_project`.`project_id`=".$_GET["id"]);
  ?>
<table border="1">
 <th colspan="6" bgcolor="#3399FF"><h2>View Progress</h2></th>
  <tr  bgcolor="#FF9966" >
    <td>PROJECT TITLE</td>
	<td>USER NAME</td>
    <td>START TIME</td>
    <td>STOP TIME</td>
    <td>NOTE</td>
    <td>WORK TYPE</td>
  </tr>
  <?php
  if($pro){
  while($sql_query_progress=mysql_fetch_object($pro))
  {
  ?>
  <tr>
     <td><?php echo $sql_query_progress->project_title;?></td>
     <td><?php echo $sql_query_progress->user_vname;?></td>
     <td><?php echo $sql_query_progress->start_time;?></td>
     <td><?php echo $sql_query_progress->stop_time;?></td>
     <td><?php echo $sql_query_progress->note;?></td>
     <td><?php 
   if($sql_query_progress->work_type=='0'){
   	echo "WORKING";
	?>
   <a href="snap.php?id=<?php echo $sql_query_progress->project_work_id;?>"> View Snap</a>
   <?php
	 }else{
	echo "BREAK"; 
	 }
   ?></td>
  </tr>
  <?Php
  }
  }
  ?>
</table>
</div>
</body>
</html>
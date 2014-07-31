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
<title>View Snap</title>
</head>
<body>
<?php include("includes/menu.php");?>
<div class="boby_t">
 <?php
 	$sql_query=mysql_query('select *from tm_project_work_snap where project_work_id='.$_GET["id"]);
	while($snap_view=mysql_fetch_object($sql_query))
	{
  ?>

    <a  style="width:100px; padding:10px; margin:2px; height:150px; display:block; float:left" href="../mediafile/<?php echo $snap_view->project_work_snap_id;?>.jpg" target="_blank"> <img src="../mediafile/<?php echo $snap_view->project_work_snap_id;?>.jpg"  height="100" width="100"/>
    <br /><?php echo $snap_view->project_work_snap_time;?>
    </a>

  <?php
	}
	?>

</div>
</body>
</html>
<?php
session_start();
include_once("main.php");
if($_SESSION["user_pass"]!="admin" and $_SESSION["user_id"]!="admin"){
	header("location:index.php");
}
if(isset($_POST["submit"])){
	$project_title=$_POST['project_title'];
	$project_des=$_POST['project_des'];
	$project_by=$_POST['project_by'];
	$user_id=$_POST['user_id'];
$sql="insert into mm_project(project_title,project_desc,project_by,project_uid)values('$project_title','$project_des','$project_by','$user_id')";
$sql_query=mysql_query($sql);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Project</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php include("includes/menu.php");?>
<div class="boby_t">
    <table align="center" border="1">
    <th colspan="2" bgcolor="#3399FF"><h2>New Project</h2></th>
    <form action="" method="post">
    <tr>
    	<td><label>Project Title:</label></td>
        <td><input type="text" name="project_title" /></td>
    </tr>
    <tr>
    	<td><label>Project Description:</label></td>
        <td><textarea name="project_des"></textarea></td>
    </tr>
    <tr>
    	<td><label>Project By:</label></td>
        <td><input type="text" name="project_by" /></td>
    </tr>
    <tr>
    	<td><label>User Name:</label></td>
        <td>
        <select name="user_id">
        <?php
		$sql_user=mysql_query("select *from mm_user");
		while($view_user=mysql_fetch_object($sql_user))
		{
		?>
        <option value="<?php echo $view_user->user_id;?>"><?php echo $view_user->user_vname;?></option>
        <?php
		}
		?>
        </select>        
        </td>
    </tr>
    <tr>
    	<td align="right" colspan="2" ><input  type="submit" name="submit"	 value="Submit" /><input type="reset" value="Cancel" /></td>
    </tr>
    
    </form>
</table>
</div>
</body>
</html>
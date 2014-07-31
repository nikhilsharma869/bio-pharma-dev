<?php
include("main.php");
if(isset($_GET["comm"])){
session_destroy();
header("location:index.php");	
}
?>
<div class="menu">
<ul>
	<li><a href="create_user.php">New User</a></li>
    <li><a href="view_user.php">View User</a></li>
    <li><a href="new_project.php">New Project</a></li>
    <li><a href="view_project.php">View Project</a></li>
    <li><a href="?comm=logout">LOG OUT</a></li>
</ul>
</div>
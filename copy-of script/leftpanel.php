<?php   
$select_images="select * from ".$prev."user where user_id='".$_SESSION['user_id']."'";
$rec_images=mysql_query($select_images);   $row_images=mysql_fetch_array($rec_images);


/////////////////  current file name  /////////////////////////////// 

$currentFile = $_SERVER["SCRIPT_NAME"]; 
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1]; 
?>
<?php
if($current_page!="Profile")
{
?>
<div class="user_box">
    <?php
	if($row_images['logo']!=""){
	?>
    <div class="user_box_img"><img src="<?php print $vpath?><?php print $row_images['logo']?>" title=""  alt=""  width=150 height=150 /></div>
    <?php
	}else{
	?>
    <div class="user_box_img"> <img src="<?php print $vpath?>images/face_icon.gif" height="150" width="149" /></div>
    <?php
	}
	?> 
    <h2>Welcome:<span><?=ucwords($row_images['username'])?></span></h2>
</div>	
<?php
}
?>
<div class="dashboard">
<ul>
	<li>
    	<a href="<?=$vpath?>dashboard.html" <?php if($current_page=='dashboard'){?> class="selected" <?php }?>><span>
    	<span lang="en">Dashboard</span></a>
   </li>
   
   <li><a href="<?=$vpath?>profile.html" <?php if($current_page=='Profile'){?> class="selected" <?php }?>><span lang="en">My Profile</span></a></li>
   
   <li><a href="<?=$vpath?>my-jobs.html"><span lang="en">My projects</span></a></li>
   

   
   <li><a href="<?=$vpath?>bidhistory.html"><span lang="en">My work journal</span></a></li>
   

</ul>

<ul>
	<li><a href="<?=$vpath?>latest_jobs.html"><span lang="en">My contracts</span></a></li>
    <li><a href="<?=$vpath?>postjob.html"><span lang="en">My finances</span></a></li>        
    <li><a href="<?=$vpath?>browse-members.html?user=E"><span lang="en">Find Employer</span></a></li>        
    <li><a href="<?=$vpath?>browse-freelancers.html?user=W"> <span lang="en">My favorite clients</span></a></li>        
    <li><a href="browse-freelancers.html?user=W"><span lang="en">My favorite professionals</span></a></li>
</ul>     

<ul>        
    <li><a href="my-jobs.php"><span lang="en">Certify my skills</span></a></li>        
   
</ul>

</div>









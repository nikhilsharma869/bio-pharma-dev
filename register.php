<?php $current_page="Register"; ?>
<?php ob_start();?>
<?php
include("include/header.php");
?>
<?php
include("include/header_menu.php");
?>

<!------Start-middle-------->
<div class="inner-middle">
<div class="page_headding">
	<h2><span lang="en">New to HiredEASY</span> ? <span lang="en">Sign up now</span>!</h2>
    <p><span lang="en">Are you already registered</span>? <a href="<?php print $vpath;?>sign_in.html" lang="en">Sign in</a>	</p>
</div>
<div class="clear"></div>
<div class="register_panel">
	<div class="register_box">
    	<h2><span lang="en">Do you want to post</span><br />
<span lang="en">a project</span></h2>
	<div class="register_bnt1"><a href="<?php print $vpath;?>register-form-client.html" lang="en">Register</a></div>
    <p lang="en">or login using</p>
    <div class="link_icon">
    <a href="#"><img src="images/facebook_icon.png" /></a>
    <a href="#"><img src="images/gmail_icon.png" /></a>
    
    </div>
    
    </div>
    <div class="register_box1">
    	<h2><span lang="en">Do you want to join our</span><br /><span lang="en">team and work</span></h2>
	<div class="register_bnt2"><a href="<?php print $vpath;?>register-form-work.html" lang="en">Register</a></div>
   
    
    </div>
    
    <div class="clear"></div>
    <div class="comitment">“<span lang="en">We believe in an Individual Freelancer</span>”</div>
</div>

</div>


<!------end_middle-------->
<?php
include("include/footer.php");
?>
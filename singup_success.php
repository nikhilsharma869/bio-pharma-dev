<?php 
$current_page="How it Works"; 
include "includes/header.php"; 
?>
<div class="browse_contract">

    
   <!--Howitworks Start-->
   <div class="howitworks_box">
     <div class="howitworks_text">
	 <?php
	// echo $_SESSION['succ'];
	 if($_REQUEST['succ']!="")
	 {
	 ?>
		<h1>Registration Successful</h1>
		<p>Congratulation !!.<br>Your profile has been successfully created and thanking you for being a registered member .</p>
		<p>Please check your mail to complete your account.</p>
	<?php
	}
	
	?>
    
</div>
</div>
</div>
 <div style="clear:both; height:10px;"></div>
<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->
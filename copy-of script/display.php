<?php 
include "includes/header.php"; 
CheckLogin();

?>

<div class="browse_contract">

    

   <div class="howitworks_box">
     <div class="howitworks_text">
       <h1>ERROR !</h1>
      <p> <?php print $_SESSION[errmsg]; unset($_SESSION[errmsg]); ?></p>
     </div>
   </div>
   

   </div>

<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->


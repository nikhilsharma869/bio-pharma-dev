<?php
include "includes/header.php";
$section = $_REQUEST['section'];
?>



<div class="spage-container">
    <div class="main_div2">
        <div class="inner-middle"> 
            <div class="alert alert-warning" role="alert">
                You don't have permission to access <?php echo $section ;?> section!
            </div>   

        </div>
    </div>  
</div>
<script type="text/javascript">
    $(document).ready(function() {
        setTimeout(function(){
          window.location = '/dashboard.html';  
        },3000)
    })
</script>

<?php include 'includes/footer.php'; ?>
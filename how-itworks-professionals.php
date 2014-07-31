<?php 

$current_page="How it Works"; 

include "includes/header.php"; 

?>

<?php
$rwc=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='How It Works'"))
?>
<?php
$rwc1=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='Create a profile'"))
?>
<?php
$rwc2=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='Win a project'"))
?>
<?php
$rwc3=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='Work and get paid'"))
?>
<!------Start-middle-------->
<div class="inner-middle">
<div class="page_headding">

<div class="HowItWorkArea">
<a lang="en" href="<?=$vpath?>howitworks.php"><?=$lang['HOW_IT_WORKS_CLIENTS']?></a>
<a class="selected" href="how-itworks-professionals.php" lang="en"><?=$lang['HOW_IT_WORKS_PROFESSION']?></a>
</div>


<div class="HowItSecArea">
        	<div class="HowSec2">
            	<div class="WorkIconarea2"><img src="images/cat1.png"></div>
                <h1><?=$lang['CREATE']?>&nbsp;<?=$lang['A_PROFILE']?></h1>
                <p><?php print html_entity_decode($rwc1['contents']);?></p>
				<!--<p><input type="button" value="View More" class="viewCatBtn2" name=""></p>-->
            </div>
         
            <div class="blk_area"></div><!--blank area div-->
            
            <div class="HowSec2">
            	<div class="WorkIconarea2"><img src="images/moneyback_icon.png"></div>
                <h1><?=$lang['WIN']?>&nbsp;<?=$lang['A_PROJECT']?></h1>
                <p><?php print html_entity_decode($rwc2['contents']);?></p>
               <!--<p><input type="button" value="View More" class="viewCatBtn2" name=""></p>-->
            </div>
            
            <div class="blk_area"></div><!--blank area div-->
            
            <div class="HowSec2">
            	<div class="WorkIconarea2"><img src="images/cr2.png"></div>
                <h1><?=$lang['WORK_AND']?>&nbsp;<?=$lang['GET_PAID']?></h1>
                <p><?php print html_entity_decode($rwc3['contents']);?></p>
               <!--<p><input type="button" value="View More" class="viewCatBtn2" name=""></p>-->
            </div>
            
        </div>







<div class="clear"></div>
    </div>
<div class="register_panel">


<!--Register Form Start-->
   
<!--Register Form End-->

</div>

</div>


<!------end_middle-------->
<?php
include("includes/footer.php");
?>
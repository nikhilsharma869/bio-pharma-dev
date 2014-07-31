<?php
$current_page = "How it Works";

include "includes/header.php";
?>

<?php
$rwc = mysql_fetch_array(mysql_query("select * from " . $prev . "contents where cont_title ='How It Works'"))
?>
<?php
$rwc1 = mysql_fetch_array(mysql_query("select * from " . $prev . "contents where cont_title ='Post Project'"))
?>
<?php
$rwc2 = mysql_fetch_array(mysql_query("select * from " . $prev . "contents where cont_title ='Select Proposal'"))
?>
<?php
$rwc3 = mysql_fetch_array(mysql_query("select * from " . $prev . "contents where cont_title ='Hire Professional'"))
?>
<!------Start-middle-------->
<div style="width:100%; float:left; background:#FFF;">
    <div class="main_div2">
        <div class="inner-middle">
            <div class="page_headding">

                <div class="HowItWorkArea">
                    <a lang="en" class="selected" href="<?=$vpath?>howitworks.php"><?= $lang['HOW_IT_WORKS_CLIENTS'] ?></a>
                    <a href="<?=$vpath?>how-itworks-professionals.php" lang="en"><?= $lang['HOW_IT_WORKS_PROFESSION'] ?></a></div>

                <div class="HowItSecArea">
                    <div class="HowSec2">
                        <div class="WorkIconarea2"><img src="images/howitwork_icon.png"></div>
                        <h1><?= $lang['POST'] ?>&nbsp;<?= $lang['PROJECT_NAME'] ?></h1>
                        <p><?php print html_entity_decode($rwc1['contents']); ?></p>
                        <!--<p><input type="button" value="View More" class="viewCatBtn2" name=""></p>-->
                    </div>

                    <div class="blk_area"></div><!--blank area div-->

                    <div class="HowSec2">
                        <div class="WorkIconarea2"><img src="images/moneyback_icon.png"></div>
                        <h1><?= $lang['SLCT'] ?>&nbsp;<?= $lang['PROPOSALS'] ?></h1>
                        <p><?php print html_entity_decode($rwc2['contents']); ?></p>
                        <!--<p><input type="button" value="View More" class="viewCatBtn2" name=""></p>-->
                    </div>

                    <div class="blk_area"></div><!--blank area div-->

                    <div class="HowSec2">
                        <div class="WorkIconarea2"><img src="images/solution_icon.png"></div>
                        <h1><?= $lang['HIRE'] ?>&nbsp;<?= $lang['PROFESSION'] ?></h1>
                        <p><?php print html_entity_decode($rwc3['contents']); ?></p>
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
    </div></div>

<!--FOOTER BOX-->

<?php include 'includes/footer.php'; ?>

<!--FOOTER BOX END-->
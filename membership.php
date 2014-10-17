<?php
$current_page = "<p>Membership</p>";
include "includes/header.php";
CheckLogin();
$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$row = mysql_fetch_array($res);
$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));
$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));
$balsum = (float) $rwbal['balsum1'] - (float) $rwbal2['baldeb'];

?>
<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle">
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>">
                <?= $lang['HOME_LINK'] ?>
            </a> | <a href="<?= $vpath ?>payment/dsp/">
                <?= $lang['My_finance'] ?>
            </a> | <a href="javascript:void(0);" class="selected">
                <?= $lang['MEMBERSHIP'] ?>
            </a></p>
    </div>
    <div class="clear"></div>
    <?php include 'includes/dashboard_menu.php';?>
    <!-- left side--> 
    <!--middle -->
    <div class="profile_right">
        <div id="wrapper_3">
            
            <!-- <ul class="tabs">
                <li><a href="<?= $vpath ?>payment/dsp/" >
                        <?= $lang['DEPOSIT_FUNDS'] ?>
                    </a></li>
                <li><a href="<?= $vpath ?>milestone.html" >
                        <?= $lang['MILDSTONE'] ?>
                    </a></li>
                <li><a href="<?= $vpath ?>withdraw.html" >
                        <?= $lang['WITHDRAW_FUND'] ?>
                    </a></li>
                <li><a href="<?= $vpath ?>transaction_history.html" >
                        <?= $lang['TRANSACTION_HISTORY'] ?>
                    </a></li>
                <li><a class="selected" href="<?= $vpath ?>membership.html" >
                        <?= $lang['MEMBERSHIP'] ?>
                    </a></li>
				 <li><a  href="<?= $vpath ?>gift.html" >
					<?= $lang['GIVE_BONUS'] ?>
				</a></li>
            </ul> -->
<div style="width: 743px;float:left">
            <?php
            if ($_SESSION['error']!= "") {
                include('includes/err.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            if ($_SESSION['succ']!= "") {
                include('includes/succ.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            ?>
</div>
            <div class="box-title">
                <div class="latest_text latest_text_new"><h1><?= $lang['MEMBERSHIP'] ?></h1></div>
                <div class="balence"><span>
                    <?= $lang['BAL_H'] ?>
                    :</span>
                <?= $curn ?>
                    <?php echo number_format($balsum, 2) ?></div>
            </div>
            <div class="browse_tab-content">
                <form action="upgrade.php" name="upgrdfrm" method="post">
                    <div class="browse_job_middle">
                        <div class="member_table">
                            <div class="member_col">
                                <div class="coltitle" style="background:none;"><span class="font_18">&nbsp;</span><br />&nbsp;</div>
                                <div class="col_data_h">Skill</div>
                                <div class="col_data_h">Bid</div>
                                <div class="col_data_h">Portfolio</div>
                            </div>

                            <?php
							$planqrrymem = mysql_query("SELECT plane_id FROM `" . $prev . "usermembership` WHERE `user_id`='" . $_SESSION['user_id'] . "'");
							$planrowmem = @mysql_fetch_assoc($planqrrymem);
                            $planqrry = mysql_query("SELECT * FROM `" . $prev . "membership_plan` WHERE `status`='Y'");
                            while ($planrow = mysql_fetch_assoc($planqrry)) {
                                if ($planrow['id'] == 1 && $planrow['status'] == 'Y') {
                                    ?>
                                    <div class="member_col free_col">
                                        <div class="coltitle"><span class="font_18"><?= strtoupper($planrow['name']) ?></span><br /> $<?= $planrow['price'] ?></div>
                                        <div class="col_data"><?= $planrow['skills'] ?></div>
                                        <div class="col_data"><?= $planrow['bids'] ?></div>
                                        <div class="col_data"><?= $planrow['portfolio'] ?></div>
                                        <div class="col_data"><input type="radio" name="plan_name" value="<?= $planrow['id'] ?>" <?php if($planrowmem['plane_id']==$planrow['id']){?>checked=true <?php }?>/></div>
                                    </div>
                                    <?php
                                }
                                if ($planrow['id'] == 2 && $planrow['status'] == 'Y') {
                                    ?>
                                    <div class="member_col  silver">
                                        <div class="coltitle"><span class="font_18"><?= strtoupper($planrow['name']) ?></span><br /> $<?= $planrow['price'] ?>/month</div>
                                        <div class="col_data"><?= $planrow['skills'] ?></div>
                                        <div class="col_data"><?= $planrow['bids'] ?></div>
                                        <div class="col_data"><?= $planrow['portfolio'] ?></div>
                                        <div class="col_data"><input type="radio" name="plan_name" value="<?= $planrow['id'] ?>" <?php if($planrowmem['plane_id']==$planrow['id']){?>checked=true<?php }?>/></div>
                                    </div>
                                    <?php
                                }
                                if ($planrow['id'] == 3 && $planrow['status'] == 'Y') {
                                    ?>
                                    <div class="member_col gold">
                                        <div class="coltitle"><span class="font_18"><?= strtoupper($planrow['name']) ?></span><br /> $<?= $planrow['price'] ?>/month</div>
                                        <div class="col_data"><?= $planrow['skills'] ?></div>
                                        <div class="col_data"><?= $planrow['bids'] ?></div>
                                        <div class="col_data"><?= $planrow['portfolio'] ?></div>
                                        <div class="col_data"><input type="radio" name="plan_name" value="<?= $planrow['id'] ?>" <?php if($planrowmem['plane_id']==$planrow['id']){?>checked=true<?php }?>/></div>
                                    </div>
                                    <?php
                                }
                                if ($planrow['id'] == 4 && $planrow['status'] == 'Y') {
                                    ?>
                                    <div class="member_col prem brdr_right">
                                        <div class="coltitle"><span class="font_18"><?= strtoupper($planrow['name']) ?></span><br /> $<?= $planrow['price'] ?>/month</div>
                                        <div class="col_data"><?= $planrow['skills'] ?></div>
                                        <div class="col_data"><?= $planrow['bids'] ?></div>
                                        <div class="col_data"><?= $planrow['portfolio'] ?></div>
                                        <div class="col_data"><input type="radio" name="plan_name" value="<?= $planrow['id'] ?>" <?php if($planrowmem['plane_id']==$planrow['id']){?>checked=true <?php }?>/></div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="clr"></div>   

                        </div>
                        <div>
                            <input type="checkbox" name="autoupgrd" value="Y" checked="checked" /> Please Check For Auto Upgrade Membership
                            <input type="submit" name="upgrd_submit" class="submit_bott" value="Upgrade Membership" />
                        </div> 
                    </div>
                </form>
                <!--Profile Right End--> 
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php'; ?>
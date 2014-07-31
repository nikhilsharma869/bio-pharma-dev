<?php
require './configs/path.php';
CheckLogin();
if (isset($_POST['upgrd_submit'])) {
    $payment_id = rand(1000,9999).time();
    $rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));
    $rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));
    $balsum = (float) $rwbal['balsum1'] - (float) $rwbal2['baldeb'];
    $planid = 1;
    if ((int) $_POST['plan_name'] > 0) {
        $planid = (int) $_POST['plan_name'];
    }
    $planqrry = "SELECT * FROM `" . $prev . "membership_plan` WHERE `id`='" . $planid . "'";
    $planresult = mysql_query($planqrry);
    $planrow = mysql_fetch_assoc($planresult);
    if ((float) $balsum >= (float) $planrow['price']) {
        $day = (int) $planrow['date'];
        if ($day == 0) {
            $day = 30;
        }
        $upg ='N';
        if( $_POST['autoupgrd']=='Y'){
            $upg ='Y';
        }
        $uplnqrry = mysql_query("SELECT `user_id` FROM `" . $prev . "usermembership` WHERE `user_id`='" . $_SESSION['user_id'] . "'");
        if (mysql_num_rows($uplnqrry) > 0) {
            $umqrry = "UPDATE `" . $prev . "usermembership` SET 
                    `plane_id`='" . $planrow['id'] . "',
                    `skill`='" . $planrow['skills'] . "',
                    `bids`='" . $planrow['bids'] . "',
                    `portfolio`='" . $planrow['portfolio'] . "',
                    `day`='" . $day . "',
                    `sub_date`=NOW(),
                    `exp_date`=DATE_ADD(NOW(), INTERVAL " . $day . " DAY),
                    `auto_upgrade`='" .$upg. "' WHERE  `user_id`='" . $_SESSION['user_id'] . "'";
        } else {
            $umqrry = "INSERT INTO `" . $prev . "usermembership` SET 
                    `user_id`='" . $_SESSION['user_id'] . "',
                    `plane_id`='" . $planrow['id'] . "',
                    `skill`='" . $planrow['skills'] . "',
                    `bids`='" . $planrow['bids'] . "',
                    `portfolio`='" . $planrow['portfolio'] . "',
                    `day`='" . $day . "',
                    `sub_date`=NOW(),
                    `exp_date`=DATE_ADD(NOW(), INTERVAL " . $day . " DAY),
                    `auto_upgrade`='" .$upg. "'";
        }
        $result = mysql_query($umqrry);
        if ($result) {
            if ((float) $planrow['price'] > 0) {
                $trqrry = "INSERT INTO `" . $prev . "transactions` SET 
                amount='" . $planrow['price'] . "',
                details = 'Upgrade Membership to " . $planrow['name'] . "',
                user_id = '" . $_SESSION['user_id'] . "',
                balance='" . $planrow['price'] . "',
                add_date = NOW(),
                date2 = '" . time() . "',
                paypaltran_id = '".$payment_id."',
                status = 'Y',
                amttype='DR'";
                mysql_query($trqrry);
            }
            //reset skill
            $skillqrry = mysql_query("SELECT COUNT(user_id) AS tskill FROM `" . $prev . "user_cats` WHERE `user_id`='" . $_SESSION['user_id'] . "'");
            $skillrow = mysql_fetch_assoc($skillqrry);
            if (((int) $skillrow['tskill'] - (int) $planrow['skills']) > 0) {
                mysql_query("DELETE FROM `" . $prev . "user_cats` WHERE `user_id`=" . $_SESSION[user_id] . " LIMIT " . ((int) $skillrow['tskill'] - (int) $planrow['skills']));
            }
            //reset skill
            $prtqrry = mysql_query("SELECT COUNT(id) AS tprt FROM `" . $prev . "portfolio` WHERE `user_id`='" . $_SESSION['user_id'] . "' AND `status`='Y'");
            $prtrow = mysql_fetch_assoc($prtqrry);
            if (((int) $prtrow['tprt'] - (int) $planrow['portfolio']) > 0) {
                mysql_query("UPDATE `" . $prev . "portfolio` SET `status`='N' WHERE `user_id`=" . $_SESSION[user_id] . " LIMIT " . ((int) $prtrow['tprt'] - (int) $planrow['portfolio']));
            }
 $_SESSION['succ']= "Membership upgraded";
        } else {
            $_SESSION['error'] = "Some thing wrong. Please trry again later";
        }
    } else {
        $_SESSION['error']= "You have no insufficient fund in your account. Please add first";
    }

   header("Location: membership.php");
}
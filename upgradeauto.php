<?php

require './configs/path.php';
$uplnqrry = mysql_query("SELECT * FROM `" . $prev . "usermembership` WHERE DATE(`exp_date`)=DATE(NOW()) AND `auto_upgrade`='Y'");

while ($uprow = mysql_fetch_assoc($uplnqrry)) {
    $payment_id = rand(1000, 9999) . time();
    $rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $uprow['user_id'] . "' and status = 'Y' and amttype='CR'"));
    $rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $uprow['user_id'] . "' and status = 'Y' and amttype='DR'"));
    $balsum = (float) $rwbal['balsum1'] - (float) $rwbal2['baldeb'];

    $planid = (int) $uprow['plane_id'];

    $planqrry = "SELECT * FROM `" . $prev . "membership_plan` WHERE `id`='" . $planid . "'";
    $planresult = mysql_query($planqrry);
    $planrow = mysql_fetch_assoc($planresult);
    $day = (int) $planrow['date'];
    if ($day == 0) {
        $day = 30;
    }
    if ((float) $balsum >= (float) $planrow['price']) {
        $umqrry = "UPDATE `" . $prev . "usermembership` SET 
                    `plane_id`='" . $planrow['id'] . "',
                    `skill`='" . $planrow['skills'] . "',
                    `bids`='" . $planrow['bids'] . "',
                    `portfolio`='" . $planrow['portfolio'] . "',
                    `day`='" . $day . "',
                    `sub_date`=NOW(),
                    `exp_date`=DATE_ADD(NOW(), INTERVAL " . $day . " DAY),
                    `auto_upgrade`='" . $uprow['auto_upgrade'] . "' WHERE  `user_id`='" . $uprow['user_id'] . "'";
    } else {

        $fplanqrry = "SELECT * FROM `" . $prev . "membership_plan` WHERE `id`='1'";
        $fplanresult = mysql_query($fplanqrry);
        $fplanrow = mysql_fetch_assoc($fplanresult);

        $fday = (int) $fplanrow['date'];
        if ($fday == 0) {
            $fday = 30;
        }
        $umqrry = "UPDATE `" . $prev . "usermembership` SET 
                    `plane_id`='" . $fplanrow['id'] . "',
                    `skill`='" . $fplanrow['skills'] . "',
                    `bids`='" . $fplanrow['bids'] . "',
                    `portfolio`='" . $fplanrow['portfolio'] . "',
                    `day`='" . $fday . "',
                    `sub_date`=NOW(),
                    `exp_date`=DATE_ADD(NOW(), INTERVAL " . $fday . " DAY),
                    `auto_upgrade`='Y' WHERE  `user_id`='" . $uprow['user_id'] . "'";
    }
    $result = mysql_query($umqrry);
    if ((float) $planrow['price'] > 0) {
        $trqrry = "INSERT INTO `" . $prev . "transactions` SET 
                amount='" . $planrow['price'] . "',
                details = 'Upgrade Membership to " . $planrow['name'] . "',
                user_id = '" . $uprow['user_id'] . "',
                balance='" . $planrow['price'] . "',
                add_date = NOW(),
                date2 = '" . time() . "',
                paypaltran_id = '".$payment_id."',
                status = 'Y',
                amttype='DR'";
        mysql_query($trqrry);
    }
//reset skill
    $skillqrry = mysql_query("SELECT COUNT(user_id) AS tskill FROM `" . $prev . "user_cats` WHERE `user_id`='" . $uprow['user_id'] . "'");
    $skillrow = mysql_fetch_assoc($skillqrry);
    if (((int) $skillrow['tskill'] - (int) $planrow['skills']) > 0) {
        mysql_query("DELETE FROM `" . $prev . "user_cats` WHERE `user_id`=" . $uprow[user_id] . " LIMIT " . ((int) $skillrow['tskill'] - (int) $planrow['skills']));
    }
//reset skill
    $prtqrry = mysql_query("SELECT COUNT(id) AS tprt FROM `" . $prev . "portfolio` WHERE `user_id`='" . $uprow['user_id'] . "' AND `status`='Y'");
    $prtrow = mysql_fetch_assoc($prtqrry);
    if (((int) $prtrow['tprt'] - (int) $planrow['portfolio']) > 0) {
        mysql_query("UPDATE `" . $prev . "portfolio` SET `status`='N' WHERE `user_id`=" . $uprow[user_id] . " LIMIT " . ((int) $prtrow['tprt'] - (int) $planrow['portfolio']));
    }
}
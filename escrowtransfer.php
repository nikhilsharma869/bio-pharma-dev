<?php

include ("configs/config.php");
include ("configs/path.php");
if (isset($_POST['milesub']) && ($_POST['milesub'] == $lang[SUBMIT])) {
    $trans_pass = mysql_fetch_array(mysql_query("select trans_pass,account_type from " . $prev . "user where user_id = '" . $_POST['subcategory'] . "'"));
    $rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));
    $rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));

    if (getprojecttype($_POST['project_id']) == "F") {
        if ($trans_pass[account_type] == 'C') {
            if (trim(getfeatureicon($_POST['project_id'])) != '') {
                $str_type = $paypal_settings['featured_company_charge'] . '%';
                $bid_comm = $paypal_settings['featured_company_charge'];
            } else {
                $str_type = $paypal_settings['non_featured_company_charge'] . '%';
                $bid_comm = $paypal_settings['non_featured_company_charge'];
            }
        } else {
            if (trim(getfeatureicon($_POST['project_id'])) != '') {
                $str_type = $paypal_settings['featured_individual_charge'] . '%';
                $bid_comm = $paypal_settings['featured_individual_charge'];
            } else {
                $str_type = $paypal_settings['non_featured_individual_charge'] . '%';
                $bid_comm = $paypal_settings['non_featured_individual_charge'];
            }
        }
    } else {
        if ($trans_pass[account_type] == 'C') {
            if (trim(getfeatureicon($_POST['project_id'])) != '') {
                $str_type = $paypal_settings['featured_company_charge_hourly'] . '%';
                $bid_comm = $paypal_settings['featured_company_charge_hourly'];
            } else {
                $str_type = $paypal_settings['non_featured_company_charge_hourly'] . '%';
                $bid_comm = $paypal_settings['non_featured_company_charge_hourly'];
            }
        } else {
            if (trim(getfeatureicon($_POST['project_id'])) != '') {
                $str_type = $paypal_settings['featured_individual_charge_hourly'] . '%';
                $bid_comm = $paypal_settings['featured_individual_charge_hourly'];
            } else {
                $str_type = $paypal_settings['non_featured_individual_charge_hourly'] . '%';
                $bid_comm = $paypal_settings['non_featured_individual_charge_hourly'];
            }
        }
    }
    $balsum = $rwbal['balsum1'] - $rwbal2['baldeb'];
    if ($_POST['tranamt_txt'] == "" || $_POST['tranamt_txt'] < 0) {
        $_SESSION['error'] = 'Amount is not correct.';
        header('location:milestone.php');
    } else {
        if ($balsum > $_POST['tranamt_txt']) {

            $payable_amm = (float)$_POST['tranamt_txt'];
           /* $profit = ($payable_amm * $bid_comm) / 100;
            $user_payable_amm = $payable_amm - $profit;*/
            $user_payable_amm = ($payable_amm*100)/(100+(float)$bid_comm);
            $profit = $payable_amm - $user_payable_amm;
            $payment_id = rand(1000, 9999) . time();
            $res = mysql_query("insert into " . $prev . "escrow set
	bidid = '" . $_POST['project_sel'] . "',
	bidder_id = '" . $_POST['subcategory'] . "',
	user_id = '" . $_SESSION['user_id'] . "',
	amount = '" . $payable_amm . "',
	paypaltran_id = '" . $payment_id . "',
	reason = '" . $_POST['reason_txt'] . "',
	user_amount = '" . $user_payable_amm . "',
	add_date = now()");

	
			if($res){
		
			$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

			$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$_POST['project_id']));

			$emp = 	mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$proj['chosen_id']));
			$to=$emp[email];
			$to1=$usr[email];
			
			$from = $setting['admin_mail'];
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailqf) == 0) {
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_for_freelancer' AND `langid`='en'");
			}

			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_for_employe' AND `langid`='" . getUserLastLang($proj['user_id']) . "'");
			if (mysql_num_rows($mailqe) == 0) {
			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_payment_for_employe' AND `langid`='en'");
			}

			$mailrf = mysql_fetch_assoc($mailqf);
			$mailre = mysql_fetch_assoc($mailqe);

			$mailbodyf = html_entity_decode($mailrf['body']);
			$mailbodye = html_entity_decode($mailre['body']);
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $emp['username'], $mailbodyf);
		$mailbodyf = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$proj['id'].'">'.  $proj[project].'</a>', $mailbodyf);
		$mailbodyf = str_replace("{employer}", $usr[username], $mailbodyf);
		$mailbodyf = str_replace("{amount}", $payable_amm, $mailbodyf);
	
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
		$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
		
		
		$subjecte = html_entity_decode($mailre['subject']);
		$mailbodye = str_replace("{username}", $usr['username'], $mailbodye);
		$mailbodye = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$proj['id'].'">'. $proj[project].'</a>', $mailbodye);
		$mailbodye = str_replace("{freelancer}", $emp[username], $mailbodye);
		$mailbodye = str_replace("{amount}", $payable_amm, $mailbodye);
												

		mail($to, $subjectf, $mailbodyf, $headers);

		 mail($to1, $subjecte, $mailbodye, $headers);
			}
             mysql_query("insert into " . $prev . "profits (amount,descrip,add_date,status,paypaltran_id) values ('" . $profit . "','Escrow Transfer',now(),'Y','" . $payment_id . "')");


             mysql_query("INSERT INTO " . $prev . "transactions (amount,details,user_id,	balance,add_date,date2,paypaltran_id,status,amttype) values
	('" . $_POST['tranamt_txt'] . "','" . $_POST['reason_txt'] . "','" . $_SESSION['user_id'] . "','" . $_POST['tranamt_txt'] . "',now(),'" . time() . "','".$payment_id."','Y','DR')");
            $_SESSION['succ'] = 'Milestone is set successfully.You can release the milestone later.';
	
            header('location:milestone.php');
        } else {
            $_SESSION['error'] = 'You have not sufficient balance.';
            header('location:milestone.php');
        }
    }
}
?>
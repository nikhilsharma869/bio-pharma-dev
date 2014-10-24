<?php
include "includes/header.php";
CheckLogin();

$img_folder = 'disput_attach';

$dispue_sql = "select d.*,p.project,u.username,u.logo,u.user_id from " . $prev . "user u," . $prev . "disputes d inner join  " . $prev . "projects p on d.claim_proj_id=p.id where (d.disput_by='" . $_SESSION['user_id'] . "' or d.disput_for='" . $_SESSION['user_id'] . "') and  d.status='Y' and u.user_id=d.disput_by and d.disput_id='" . $_GET['disput_id'] . "'";

$dispue_res = mysql_query($dispue_sql);
$disputes = mysql_fetch_array($dispue_res);
//echo "select u.username,u.logo from  ". $prev ."user u, " . $prev . "disputes d  where u.user_id=d.disput_for and u.user_id=".$disputes['disput_for'];
$dispute_for = mysql_fetch_array(mysql_query("select u.* from  " . $prev . "user u, " . $prev . "disputes d  where u.user_id=d.disput_for and u.user_id=" . $disputes['disput_for']));

if ($_POST['r_submit']) {
//echo "update ". $prev ."disputs set reply_desc='" .$_REQUEST['reply']."' where disput_for=".$_REQUEST['disput_for'];
    $query = mysql_fetch_array(mysql_query("select username from  " . $prev . "user where user_id=" . $_SESSION['user_id']));
    $username = $query["username"];
    $dt = "insert into " . $prev . "disput_reply(disput_id,disput_for,reply_desc,reply_by,reply_on) values(" . $_REQUEST['disput_id'] . "," . $_REQUEST['disput_for'] . ",'" . $_REQUEST['reply'] . "'" . ",'" . $username . "',now())";
    $up = mysql_query($dt);

    if ($up) {
        $_SESSION['succ'] = $lang['REPLY_PAYMENT'];
        $id = mysql_insert_id();

        if ($_FILES['attach_file']['name']) {
            $pathinfo = pathinfo($_FILES['attach_file']['name'], PATHINFO_EXTENSION);
            $file_name = $id . time() . "." . $pathinfo;
            mysql_query("update " . $prev . "disput_reply set attach_file='" . $file_name . "' where reply_id='" . $id . "'");
            move_uploaded_file($_FILES['attach_file']['tmp_name'], $img_folder . "/" . $file_name);
        }
    } else {
        $_SESSION['error'] = $lang['REPLY_ERROR'];
    }
    $msg3 = true;
}

if ($_POST['submit'] == $lang['SUBMIT']) {
    if (!is_numeric($_POST['offer_amt'])) {
        $_SESSION['error'] = $lang['AMT_IN_DIGITS_ERROR'];
    } else {
        $claim_amount = $disputes['claim_amount'];
        $offer_amt = $_POST['offer_amt'];
        $rest = $claim_amount - $offer_amt;
        if ($offer_amt < $claim_amount) {
            if ($_SESSION['user_id'] == $disputes['user_id']) {

                $sql = "update " . $prev . "disputes set amt_disput_by=" . $offer_amt . ",amt_other_disput_by=" . $rest . " where disput_id=" . $disputes['disput_id'];
            }
            if ($_SESSION['user_id'] == $dispute_for['user_id']) {

                $sql = "update " . $prev . "disputes set amt_disput_for=" . $offer_amt . ",amt_other_disput_for=" . $rest . " where disput_id=" . $disputes['disput_id'];
            }
            //echo $sql;
            $ru_sql = mysql_query($sql);
            if ($ru_sql) {
                $_SESSION['succ'] = 'Your offer amount is submitted successfully.';
            }
        } else {
            $_SESSION['error'] = 'Error. offer amount not getter than dispute amount ';
        }
    }
    $msg3 = true;
}

if ($_GET['resolved'] == 'yes' && $disputes['resolve'] == 'N') {

    if ($_SESSION['user_id'] == $disputes['user_id']) {
        $rec_amt = $disputes['amt_disput_for'];
    }
    if ($_SESSION['user_id'] == $dispute_for['user_id']) {
        $rec_amt = $disputes['amt_other_disput_by'];
    }
    $restamount = $disputes['claim_amount'] - $rec_amt;
    $sql = "update " . $prev . "disputes set resolve='Y',received_amt=" . $rec_amt . " where disput_id=" . $disputes['disput_id'];
    $ru_sql = mysql_query($sql);
    if ($ru_sql) {
        $sql = "update " . $prev . "escrow set status='R',released_by='employer' where escrow_id=" . $disputes['escrow_id'];
        $ru_sqlr = mysql_query($sql);
        $payment_id = rand(1000, 9999) . time();
        $rw4 = mysql_query("insert into " . $prev . "transactions set 
				details = 'Milestone payment release',
				user_id = '" . $dispute_for['user_id'] . "',
				balance = '" . $rec_amt . "',
				add_date = now(),
				date2 = '" . time() . "',
				paypaltran_id = '" . $payment_id . "',
				status = 'Y',amttype = 'CR'");

        $payment_id = rand(1000, 9999) . time();
        $rw4 = mysql_query("insert into " . $prev . "transactions set 
				details = 'Milestone resolved amount',
				user_id = '" . $disputes['user_id'] . "',
				balance = '" . $restamount . "',
				add_date = now(),
				date2 = '" . time() . "',
				paypaltran_id = '" . $payment_id . "',
				status = 'Y',amttype = 'CR'");

   //      mysql_query("insert into " . $prev . "notification set 
			// user_id = '" . $dispute_for['user_id'] . "',
			// message = 'Employer has release one Milestone Payment',
			// add_date = now()");
        $link = $vpath.'transaction_history.html';
        $notify = add_notification($dispute_for['user_id'], 'Employer has release one Milestone Payment', 'W', $link);

   //      mysql_query("insert into " . $prev . "notification set 
			// user_id = '" . $disputes['user_id'] . "',
			// message = 'You Release a one Milestone Payment',
			// add_date = now()");
        $link = $vpath.'transaction_history.html';
        $notify = add_notification($disputes['user_id'], 'You Release a one Milestone Payment', 'E', $link);

        $_SESSION['succ'] = "Thank you for accepting the offer. You will get $" . $rec_amt . " in your account soon.";
        /*         * *************check for completed status update************ */
        $rw1 = mysql_fetch_array(mysql_query("select bidid from " . $prev . "escrow where escrow_id = '" . $disputes['escrow_id'] . "'"));
        $res2 = mysql_fetch_array(mysql_query("select emp_charge,project_id from " . $prev . "buyer_bids where id='" . $rw1['bidid'] . "'"));
        $rw5 = mysql_fetch_array(mysql_query("select sum(amount) as escrow_amount from " . $prev . "escrow where bidid = '" . $rw1['bidid'] . "' AND `status`='R'"));
			$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$_SESSION['user_id']));

			$proj = mysql_fetch_array(mysql_query("SELECT * from ".$prev."projects where id=".$res2['project_id']));

			$emp = 	mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id=".$proj['chosen_id']));
			$to=$emp[email];
			$to1=$usr[email];
			
			$from = $setting['admin_mail'];
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_resolve_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
			if (mysql_num_rows($mailqf) == 0) {
			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_resolve_for_freelancer' AND `langid`='en'");
			}

			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_resolve_for_employe' AND `langid`='" . getUserLastLang($proj['user_id']) . "'");
			if (mysql_num_rows($mailqe) == 0) {
			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='milestone_resolve_for_employe' AND `langid`='en'");
			}

			$mailrf = mysql_fetch_assoc($mailqf);
			$mailre = mysql_fetch_assoc($mailqe);

			$mailbodyf = html_entity_decode($mailrf['body']);
			$mailbodye = html_entity_decode($mailre['body']);
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $emp['username'], $mailbodyf);
		$mailbodyf = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$proj['id'].'">'.  $proj[project].'</a>', $mailbodyf);
		$mailbodyf = str_replace("{employer}", $usr[username], $mailbodyf);
			
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
		$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
		
		
		$subjecte = html_entity_decode($mailre['subject']);
		$mailbodye = str_replace("{username}", $usr['username'], $mailbodye);
		$mailbodye = str_replace("{project}", '<a href="'.$vpath . 'project-dtl.php?id=' .$proj['id'].'">'. $proj[project].'</a>', $mailbodye);
		$mailbodye = str_replace("{freelancer}", $emp[username], $mailbodye);
						

		mail($to, $subjectf, $mailbodyf, $headers);

		 mail($to1, $subjecte, $mailbodye, $headers);
        if (floatval($rw5['escrow_amount']) >= floatval($res2['emp_charge'])) {
            if (getprojecttype($res2['project_id']) == "F") {
                mysql_query("update " . $prev . "projects set status='complete' where id='" . $res2['project_id'] . "'");
            }
        }
        /*         * *************check for completed status update************ */
    }
    $msg3 = true;
}




$dispue_sql = "select d.*,p.project,u.username,u.logo,u.user_id from " . $prev . "user u," . $prev . "disputes d inner join  " . $prev . "projects p on d.claim_proj_id=p.id where (d.disput_by='" . $_SESSION['user_id'] . "' or d.disput_for='" . $_SESSION['user_id'] . "') and  d.status='Y' and u.user_id=d.disput_by and d.disput_id='" . $_GET['disput_id'] . "'";

$dispue_res = mysql_query($dispue_sql);
$disputes = mysql_fetch_array($dispue_res);
//echo "select u.username,u.logo from  ". $prev ."user u, " . $prev . "disputes d  where u.user_id=d.disput_for and u.user_id=".$disputes['disput_for'];
$dispute_for = mysql_fetch_array(mysql_query("select u.* from  " . $prev . "user u, " . $prev . "disputes d  where u.user_id=d.disput_for and u.user_id=" . $disputes['disput_for']));

if (!empty($disputes[logo])) {
    $temp_logo = $disputes[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}


$dreply = "select * from " . $prev . "disput_reply where disput_id='" . $_REQUEST['disput_id'] . "'";
$dres = mysql_query($dreply);
?>
<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="<?= $vpath ?>active_dispute.html"><?= $lang['ACTIVE_DISPUTE'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['DISPUTE_DETAIL'] ?></a></p></div>
    <div class="clear"></div>

    <div class="disput_contract">
        <div class="post_contract">
            <div style="color:#0B7398">
                <h3><?= $lang['DUPLICATE_ID'] ?> : <? printf('%05d', $disputes['disput_id']); ?>
                    <span style="float:right;" class="edit_bott"><a href="active_dispute.php"><?= $lang['BACK'] ?></a></span></h3>

                <ul>
                    <li><?= $lang['DISPUTE_PROJECT'] ?> : <?= $disputes['project'] ?></li>
                    <li><?= $lang['DISPUTE_BY'] ?> : <?= ucwords($disputes['username']) ?></li>
                </ul>

            </div>
            <div class="clear"></div>

            <?php
            if ($_SESSION['error'] != "") {
                include('includes/err.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            if ($_SESSION['succ'] != "") {
                include('includes/succ.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            echo "<br>";
            ?>
            <div class="reply_box_left">
                <div class="reply_msg_box">
                    <span> <img src="viewimage.php?img=<?php echo $temp_logo; ?>&amp;width=70&amp;height=70" /></span>
                    <div class="reply_massage">
                        <h2><?= ucwords($disputes['username']) ?> <p><?= date('M d, Y', strtotime($disputes['date'])) ?></p></h2>
                        <p><?= $disputes['claim_desc'] ?></p>
                    </div>
                </div>

                <?php
                while ($dispute_reply = mysql_fetch_array($dres)) {
                    ?>
                    <div class="reply_msg_box">
                        <span> <img src="viewimage.php?img=<?php echo $dispute_for['disput_for']; ?>&amp;width=70&amp;height=70" /></span>
                        <div class="reply_massage">
                            <h2><?= ucwords($dispute_reply['reply_by']) ?> <p><?= date('d-m-Y h:i s', strtotime($dispute_reply['reply_on'])) ?></p></h2>
                            <p><?= $dispute_reply['reply_desc'] ?></p>
                            <p><?php if ($dispute_reply['attach_file'] != "") echo '<a href="' . $vpath . 'disput_attach/' . $dispute_reply['attach_file'] . '">' . $lang['DOWNLOAD'] . '</a>' ?></p>
                        </div>
                    </div>

                    <?php
                }
                ?>


                <form name="replyfrm" id="replyfrm" method="post"  enctype="multipart/form-data">
                    <div class="reply_from">
                        <p> <?= $lang['REASON_FOR_DISPUTE'] ?>:</p><br /><br /><br />
                        <textarea name="reply" id="reply" cols="" rows="7" class="reply_text_box" style="color:#000000"></textarea>
                    </div>
                    <div class="reply_from">
                        <p><?= $lang['ATTACH_DOCUMENT'] ?> </p><br /><br />
                        <img src="images/attach_icon.png" /></span> <input class="input_box" type="file" name="attach_file" />
                    </div>


                    <div class="reply_from">
                        <p><input type="hidden" name="disput_for" value="<?= $disputes['disput_for'] ?>"/></p>
                        <span><input name="r_submit" type="submit" value="Reply" class="submit_bott" /></span>

                    </div>



                </form>
            </div>


            <div class="reply_box_right">
                <div class="clear"></div>
                <form  method="post" name="offer_frm" id="offer_frm">
                    <div class="proceed_bnt"><?= $lang['TOTAL_AMT_DISPUTE'] ?>( $<?= $disputes['claim_amount'] ?> )</div>
                    <p></p>
                    <div class="offer">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td style="border-right:#CDCDCD 1px dotted;"><p><?= $lang['AMT_OFFERED'] ?> <?= ucwords($disputes['username']) ?> <br /><span>$<?= $disputes['amt_disput_by'] ?></span></p></td>
                                <td><p><?= $lang['AMT_OFFERED'] ?> <?= ucwords($dispute_for['username']) ?><br /><span>$<?= $disputes['amt_disput_for'] ?></span></p></td>
                            </tr>
                            <tr>
                                <td style="border-right:#CDCDCD 1px dotted;"><?php if ($_SESSION['user_id'] == $dispute_for['user_id'] && $disputes['resolve'] == 'N') echo'<div class="edit_bott"><a href="' . $vpath . 'disputes_details.php?disput_id=' . $_REQUEST['disput_id'] . '&resolved=yes">' . $lang['ACCEPT_OFFER'] . '</a></div>'; ?></td>
                                <td><?php if ($_SESSION['user_id'] == $disputes['user_id'] && $disputes['resolve'] == 'N') echo'<div class="edit_bott"><a href="' . $vpath . 'disputes_details.php?disput_id=' . $_REQUEST['disput_id'] . '&resolved=yes">' . $lang['ACCEPT_OFFER'] . '</a></div>'; ?></td>
                            </tr>
                            <tr>
                                <td style="border-right:#CDCDCD 1px dotted;">&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </div>

                    <div class="clear"></div>
                    <? if ($disputes['resolve'] == 'N') { ?>
                        <div class="new_offer">
                            <p><?= $lang['NEW_OFFER'] ?></p>
                            <div class="account" style="padding-top:15px;">$ <input name="offer_amt" type="text" class="account_box" style="color:#000000" size="5" maxlength="5"  /></div> <div class="account">
                                <input name="submit" id="submit" type="submit" value="<?= $lang['SUBMIT'] ?>" class="submit_bott" /></div>
                            <div class="clear"></div>
                            <p><?= $lang['MAX_AMT'] ?> $ <?= $disputes['claim_amount'] ?></p>
                        </div><? } else { ?>
                        <p><?= $lang['AGREE_AMT'] ?> $ <?= $disputes['received_amt'] ?></p>

                    <? } ?>
                </form>
            </div>	

        </div>
    </div>
</div>
<div style="clear:both; height:10px;"></div>
<style>
    .offer .edit_bott a{
        width:115px;
    }
</style>
<?php include 'includes/footer.php'; ?>
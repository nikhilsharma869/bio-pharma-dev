<?php
$current_page = "<p>Proposal submitted successfully</p>";

include "includes/header.php";
CheckLogindecode(base64_encode("project/" . $_REQUEST['projectid_hid']));
//CheckLogin();
$checkd = mysql_fetch_array(mysql_query("select status,project_type from " . $prev . "projects where id=" . $_POST['projectid_hid']));
if ($checkd['status'] == "open") {
    $stringword = $_POST['details'];



    $banned_words = explode(',', $setting[bad_words]);

    $err = 0;

    $c_banned_words = count($banned_words);

    for ($i = 0; $i < $c_banned_words; $i++) {

        if (@substr_count($stringword, $banned_words[$i])) {

            $err++;

            break;
        }
    }



    if ($err != 0) {



        $_SESSION['error'] = $lang['MSG_BANND'];

        header("location:bid.php?id=" . $_POST['projectid_hid']);
    }





    if ($err == 0) {

        if (isset($_POST[submits]) && ($_POST[submits] == 'PlaceBid')) {
            if (canHeDo($_SESSION['user_id'], 'bid')) {
                $res = mysql_query("insert into " . $prev . "buyer_bids set

										project_id = " . $_POST['projectid_hid'] . ",

										bidder_id = " . $_SESSION['user_id'] . ",

										bid_amount = " . $_POST['bidamount1'] . ",

										odesk_fee = " . floatval($_POST['site_fee_hid']) . ",

										emp_charge = " . floatval($_POST['bidamount']) . ",

										add_date = now(),
										
										project_type_bid='" . $checkd['project_type'] . "',
										
										duration = '" . $_POST['delivery'] . "',

										cover_letter = '" . $_POST['details'] . "'");

                if ($res) {


                    $rw = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id=" . $_POST['projectid_hid']));



                    $recv = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = " . $rw['user_id']));



                    $send = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = " . $_SESSION['user_id']));

                    $inter = mysql_fetch_array(mysql_query("select * from " . $prev . "interview where sender_id=".$rw['user_id']." and project_id=".$_POST['projectid_hid']." and receiver_id=" . $_SESSION['user_id']));

                    if($inter) {
                        mysql_query("update " . $prev . "interview set status='A' where id=" . $inter['id']);
                    }

                    $_REQUEST['firstname'] = $recv['fname'];

                    $_REQUEST['lastname'] = $recv['lname'];

                    $msg_detail = 'Description : ' . $_POST['details'] . "<br/><br/>" . $lang['CHK_ML_MSG'];



                    $res3 = mysql_query("insert into " . $prev . "messages set

											receiver='" . $rw['user_id'] . "',

											sender_id='" . $_SESSION['user_id'] . "',

											sender='" . $send['email'] . "',

											subject='Project Bid - $rw[project]',

											message=\"" . $msg_detail . "\",

											user_type='reciver',

											sent_time=now(),

											status='Y',

											message_type='A',

											read_status='N',

											view_user='U'");

                    if ($res3) {

                        $res4 = mysql_query("insert into " . $prev . "messages set

														receiver='" . $rw['user_id'] . "',

														sender_id='" . $_SESSION['user_id'] . "',

														sender='" . $send['email'] . "',

														subject=\"" . $lang['PROJ_BID'] . $rw[project] . "\",

														message=\"" . $msg_detail . "\",

														user_type='sender',

														sent_time=now(),

														status='Y',

														message_type='A',

														read_status='N',

														view_user='U'");


                        $prurl = $vpath . "project/" . $rw[id] . "/" . str_replace("/", "", str_replace(" ", "-", $rw[project])) . ".html";

                        $amount = $setting['currency'] . floatval($_POST['bidamount']);
                        if ($rw['project_type'] == 'H') {
                            $amount = $setting['currency'] . floatval($_POST['bidamount']) . ' / hr';
                        }

                        $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
                        if (mysql_num_rows($mailqf) == 0) {
                            $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_freelancer' AND `langid`='en'");
                        }

                        $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_employe' AND `langid`='" . getUserLastLang($rw['user_id']) . "'");
                        if (mysql_num_rows($mailqe) == 0) {
                            $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_employe' AND `langid`='en'");
                        }

                        $mailrf = mysql_fetch_assoc($mailqf);
                        $mailre = mysql_fetch_assoc($mailqe);

                        $mailbodyf = html_entity_decode($mailrf['body']);
                        $mailbodye = html_entity_decode($mailre['body']);

                        $subjectf = html_entity_decode($mailrf['subject']);
                        $mailbodyf = str_replace("{username}", $send['username'], $mailbodyf);
                        $mailbodyf = str_replace("{project}", "<a href='" . $prurl . "'>" . $rw['project'] . "</a>", $mailbodyf);
                        $mailbodyf = str_replace("{project_url}", $prurl, $mailbodyf);
                        $mailbodyf = str_replace("{amount}", $amount, $mailbodyf);
                        $mailbodyf = str_replace("{duration}", $_POST['delivery'], $mailbodyf);

                        $subjecte = html_entity_decode($mailre['subject']);
                        $mailbodye = str_replace("{username}", $recv['username'], $mailbodye);
                        $mailbodye = str_replace("{freelancer}", $send['username'], $mailbodye);
                        $mailbodye = str_replace("{project}", "<a href='" . $prurl . "'>" . $rw['project'] . "</a>", $mailbodye);
                        $mailbodye = str_replace("{project_url}", $prurl, $mailbodye);
                        $mailbodye = str_replace("{amount}", $amount, $mailbodye);
                        $mailbodye = str_replace("{duration}", $_POST['delivery'], $mailbodye);


                        $headers = "MIME-Version: 1.0 \r\n";
                        $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
                        $headers.="From: " . $setting['admin_mail'] . "\r\n";
                        if ($setting['cc_mail'] != '') {
                            $headers.="Cc: " . $setting['cc_mail'] . "\r\n";
                        }

                        mail($send['email'], $subjectf, $mailbodyf, $headers);
                        mail($recv['email'], $subjecte, $mailbodye, $headers);



                        $message = $lang['MSG_BID_POST'];
                    } else {

                        $message = $lang['ERROR_DB'];
                    }
                } else {

                    $message = $lang['ERROR_DB'];
                }
            } else {
                $message = "Bid Limit Over.";
            }
        }

        if (isset($_POST[submits]) && ($_POST[submits] == 'ReviseBid')) {
            $res = mysql_query("update " . $prev . "buyer_bids set

		bid_amount = " . $_POST['bidamount1'] . ",

		odesk_fee = " . floatval($_POST['site_fee_hid']) . ",

		emp_charge = " . floatval($_POST['bidamount']) . ",

		add_date = now(),

		duration = '" . $_POST['delivery'] . "',

		cover_letter = '" . $_POST['details'] . "' where id = " . $_POST['rev_bidid_hid']);



            if ($res) {

                $rw = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id=" . $_POST['projectid_hid']));



                $recv = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = " . $rw['user_id']));



                $send = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = " . $_SESSION['user_id']));

                $_REQUEST['firstname'] = $recv['fname'];

                $_REQUEST['lastname'] = $recv['lname'];

                $msg_detail = $lang['DESCRIPTION'] . ': ' . $_POST['details'] . "<br/><br/>" . $lang['CHK_ML_MSG'];


                $res3 = mysql_query("insert into " . $prev . "messages set

			receiver='" . $rw['user_id'] . "',

			sender_id='" . $_SESSION['user_id'] . "',

			sender='" . $send['email'] . "',

			subject=\"" . $lang['PROJ_BID_REV'] . $rw[project] . "\",

			message=\"" . $msg_detail . "\",

			user_type='reciver',

			sent_time=now(),

			status='Y',

			message_type='A',

			read_status='N',

			view_user='U'");

                if ($res3) {

                    $res4 = mysql_query("insert into " . $prev . "messages set

				receiver='" . $rw['user_id'] . "',

				sender_id='" . $_SESSION['user_id'] . "',

				sender='" . $send['email'] . "',

				subject=\"" . $lang['PROJ_BID_REV'] . $rw[project] . "\",

				message=\"" . $msg_detail . "\",

				user_type='sender',

				sent_time=now(),

				status='Y',

				message_type='A',

				read_status='N',

				view_user='U'");


                    $prurl = $vpath . "project/" . $rw[id] . "/" . str_replace("/", "", str_replace(" ", "-", $rw[project])) . ".html";

                    $amounte = $setting['currency'] . floatval($_POST['bidamount']);
                    if ($rw['project_type'] == 'H') {
                        $amount = $setting['currency'] . floatval($_POST['bidamount']) . ' / hr';
                    }

                    $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_reverse_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
                    if (mysql_num_rows($mailqf) == 0) {
                        $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_reverse_for_freelancer' AND `langid`='en'");
                    }

                    $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_reverse_for_employe' AND `langid`='" . getUserLastLang($rw['user_id']) . "'");
                    if (mysql_num_rows($mailqe) == 0) {
                        $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_reverse_for_employe' AND `langid`='en'");
                    }

                    $mailrf = mysql_fetch_assoc($mailqf);
                    $mailre = mysql_fetch_assoc($mailqe);

                    $mailbodyf = html_entity_decode($mailrf['body']);
                    $mailbodye = html_entity_decode($mailre['body']);

                    $subjectf = html_entity_decode($mailrf['subject']);
                    $mailbodyf = str_replace("{username}", $send['username'], $mailbodyf);
                    $mailbodyf = str_replace("{project}", "<a href='" . $prurl . "'>" . $rw['project'] . "</a>", $mailbodyf);
                    $mailbodyf = str_replace("{project_url}", $prurl, $mailbodyf);
                    $mailbodyf = str_replace("{amount}", $amount, $mailbodyf);
                    $mailbodyf = str_replace("{duration}", $_POST['delivery'], $mailbodyf);

                    $subjecte = html_entity_decode($mailre['subject']);
                    $mailbodye = str_replace("{username}", $recv['username'], $mailbodye);
                    $mailbodye = str_replace("{freelancer}", $send['username'], $mailbodye);
                    $mailbodye = str_replace("{project}", "<a href='" . $prurl . "'>" . $rw['project'] . "</a>", $mailbodye);
                    $mailbodye = str_replace("{project_url}", $prurl, $mailbodye);
                    $mailbodye = str_replace("{amount}", $amount, $mailbodye);
                    $mailbodye = str_replace("{duration}", $_POST['delivery'], $mailbodye);


                    $headers = "MIME-Version: 1.0 \r\n";
                    $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
                    $headers.="From: " . $setting['admin_mail'] . "\r\n";
                    if ($setting['cc_mail'] != '') {
                        $headers.="Cc: " . $setting['cc_mail'] . "\r\n";
                    }

                    mail($send['email'], $subjectf, $mailbodyf, $headers);
                    mail($recv['email'], $subjecte, $mailbodye, $headers);


                    $message = '<font color="#008000">' . $lang['MSG_BID_REV'] . '</font>';
                } else {

                    $message = '<font color="#f00">' . $lang['ERROR_DB'] . '</font>';
                }
            } else {

                $message = '<font color="#f00">' . $lang['ERROR_DB'] . '</font>';
            }
        }
    }
} else {

    $message = '<font color="#f00">' . $lang['CANNOT_BID_PROJECT'] . '</font>';
}
?>
<div class="browse_contract">
   <div class="inner-middle">
    <div class="howitworks_box">
        <div class="howitworks_text">
            <h1><?= $lang['MESSAGE'] ?></h1>
            <p><?php echo $message; ?></p>
            <br clear="all" />
            <!--<a href="project-dtl.php?id=<?= $_POST['projectid_hid']; ?>">-->	  <a href="<?= $vpath ?>project/<?= $_POST['projectid_hid']; ?>" class="submit_bott" style="text-decoration:none; margin:6px 14px;">	<?= $lang['BACK'] ?></a> </div>
    </div>
   </div>
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php'; ?>

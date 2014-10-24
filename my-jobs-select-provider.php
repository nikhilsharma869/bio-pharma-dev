<?php
$current_page = "<p>My Jobs</p>";

include "includes/header.php";

CheckLogin();

$openjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='open'"));
$closejobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='frozen'"));
$closedjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='complete'"));
$cancelledjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='cancelled'"));


$r4 = mysql_query("select * from " . $prev . "user where user_id=" . $_SESSION['user_id']);

$d = @mysql_fetch_array($r4);
$type = $d['user_type'];
$no_of_records = 20;
?>
<script type="text/javascript" src="<?= $vpath ?>js/general_functions.js"></script>

<script language="javascript" type="text/javascript">

    var browser = navigator.appName;

    if (browser == "Microsoft Internet Explorer")

    {

        var displaystyle = "block";

    }

    else

    {

        var displaystyle = "table-row";

    }

    function showpass()

    {

        if (document.getElementById("chkChangePassword").checked == true)

        {

            document.getElementById("olspass").style.display = displaystyle;

            document.getElementById("newpass").style.display = displaystyle;

            document.getElementById("confpass").style.display = displaystyle;

        }

        else

        {

            document.getElementById("olspass").style.display = "none";

            document.getElementById("newpass").style.display = "none";

            document.getElementById("confpass").style.display = "none";

        }

    }

</script>
<script type="text/javascript" src="<?= $vpath ?>domcollapse.js"></script>

<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>">Home</a> | <a href="javascript:void(0);" class="selected">My Projects</a></p></div>
    <div class="clear"></div>

    <?php include 'includes/leftpanel1.php'; ?>


    <div class="profile_right">
        <div id="wrapper_3">
            <? echo getprojecttab(1); ?>
            <div class="browse_tab-content">
                <div class="browse_job_middle"> 




                    <table  class="space_left2" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <?php
                        if (isset($_SESSION['select_provider'])) {
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><?php
                                    $_SESSION['error'] = $_SESSION['select_provider'];
                                    include('includes/err.php');
                                    unset($_SESSION['error']);
                                    unset($_SESSION['select_provider']);
                                    ?></td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <?php
                        }
                        ?>
                        <tr>
                            <td align="left" valign="top" class="bx-border"><?php
                                if ($_REQUEST[confirm] && $_REQUEST[mode]) {




                                    if (mysql_query("UPDATE " . $prev . "buyer_bids SET chose='Y' WHERE project_id='$_REQUEST[confirm]' and bidder_id='$_SESSION[user_id]'")) {

                                        mysql_query("UPDATE " . $prev . "projects SET status='process' WHERE id='$_REQUEST[confirm]' and chosen_id='$_SESSION[user_id]'");







                                        $usr = mysql_fetch_array(mysql_query("SELECT * from " . $prev . "user where user_id=" . $_SESSION['user_id']));

                                        $proj = mysql_fetch_array(mysql_query("SELECT * from " . $prev . "projects where id=" . $_GET['id']));

                                        $emp = mysql_fetch_array(mysql_query("SELECT * from " . $prev . "user where user_id=" . $proj['user_id']));

                                        $message = $lang['BID_ACCPT'] . "<br /><br />" .
                                                $lang['PROJECT_NAMEE'] . ": " . $proj['project'];



                                        $msg = mysql_query("INSERT into " . $prev . "messages set 

					receiver=" . $emp['user_id'] . ",

					sender_id=" . $_SESSION['user_id'] . ",

					sender='" . $usr['email'] . "' ,

					subject='" . $lang['BID_ACCPT'] . "',

					message='" . $message . "',

					user_type='sender',

					sent_time='" . date('Y-m-d h:i:s') . "',

					status='Y',

					message_type='A'");



                                        $msg2 = mysql_query("INSERT into " . $prev . "messages set 

					receiver=" . $emp['user_id'] . ",

					sender_id=" . $_SESSION['user_id'] . ",

					sender='" . $usr['email'] . "' ,

					subject='" . $lang['BID_ACCPT'] . "',

					message='" . $message . "',

					user_type='reciver',

					sent_time='" . date('Y-m-d h:i:s') . "',

					status='Y',

					message_type='A'");





                                        // $notify = mysql_query("INSERT into " . $prev . "notification set user_id=" . $emp['user_id'] . ", message='" . $lang['BID_ACCPT'] . "', add_date='" . date('Y-m-d') . "'");
                                        $link = $vpath.'contract/'.$proj['id'];
                                        $notify = add_notification($emp['user_id'], $lang['BID_ACCPT'], 'E', $link);


                                        $res2 = mysql_query("select * from " . $prev . "mailsetup where mail_type=\"hire_contract_begins\"");

                                        $row = mysql_fetch_array($res2);

                                        $admin = mysql_fetch_assoc(mysql_query("select * from " . $prev . "paypal_settings"));

                                        $to = $emp['email'];

                                        $subject = $lang['MYJOBS_EM_SUB1'];

                                        $message = '

					<html>

					<head>

					<title>' . $dotcom . $lang['NOTIFICATION'] . '</title>

					</head>

					<body>

					<p>&nbsp;</p>

					<table cellpadding="0" cellspacing="0" border="0" width="100%">

					<tbody>

						<tr>

							<td>' . $lang['DET_PROVDR'] . ':' . $usr['fname'] . ' ' . $usr['lname'] . '</td>

						</tr>

						<tr>

							<td>' . $lang['PROVDR_NAME'] . ':' . $usr['username'] . '</td>

						</tr>

						<tr>

							<td>' . $lang['PROVDR_EMAIL'] . ':' . $usr['email'] . '</td>

						</tr>

						<tr>

							<td>' . $lang['PROVDR_COMP_NM'] . ':' . $usr['company'] . '</td>

						</tr>

					</tbody>

					</table>

					<p>

					<br />

					' . html_entity_decode($row['body']) . '

					<br />

					' . html_entity_decode($row['footer']) . '

					</body>

					</html>

					';


                                        $headers = 'MIME-Version: 1.0' . "\r\n";

                                        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                                        $headers.=$lang['FROM_H'] . ": " . $setting['admin_mail'] . "\r\n" . $lang['REPLY_TO'] . ":" . $setting['admin_mail'];



                                        mail($to, $subject, $message, $headers);


                                        $res_tlog = mysql_query("select * from " . $prev . "mailsetup where mail_type=\"login_begins\"");

                                        $row_tlog = mysql_fetch_array($res2);



                                        $to1 = $usr['email'];

                                        $subject1 = $lang['MYJOBS_EM_SUB2'];

                                        $message1 = '

					<html>

					<head>

					<title>' . $dotcom . $lang['NOTIFICATION'] . '</title>

					</head>

					<body>

					<p>&nbsp;</p>

					<table cellpadding="0" cellspacing="0" border="0" width="100%">

					<tbody>

						<tr>

							<td>' . $lang['DET_EMP'] . ':' . $emp['fname'] . ' ' . $emp['lname'] . '</td>

						</tr>

						<tr>

							<td>' . $lang['EMP_NAME'] . ':' . $emp['username'] . '</td>

						</tr>

						<tr>

							<td>' . $lang['EMP_EMAIL'] . ':' . $emp['email'] . '</td>

						</tr>

						<tr>

							<td>' . $lang['EMP_COMP_NM'] . ':' . $emp['company'] . '</td>

						</tr>

					</tbody>

					</table>

					<p>

					<br />

					' . html_entity_decode($row_tlog['body']) . '

					<br />

					' . html_entity_decode($row_tlog['footer']) . '

					</body>

					</html>

					';

                                        $headers1 = 'MIME-Version: 1.0' . "\r\n";

                                        $headers1 .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

                                        $headers.=$lang['FROM_H'] . ": " . $setting['admin_mail'] . "\r\n" . $lang['REPLY_TO'] . ":" . $setting['admin_mail'];


                                        mail($to1, $subject1, $message1, $headers1);



                                        header($lang['LOCATION'] . ": " . $vpath . "mybids.html");
                                    }

                                    exit;
                                }

                                if ($_REQUEST[pick]) {
                                    ?>
                                    <table cellpadding=4 cellspacing=1 align=center width=100% style='color:#4E4D4D;'>
                                        <tr class='tbl_bg_4'>
                                            <td colspan=2>
                                                <a href='<?= $vpath ?>my-jobs.html' class=link_class><u><b><?= $lang['MY_JOBS'] ?></b></u></a>
                                                <b> ><?= $lang['SELECT_PROVIDER'] ?></b>
                                            </td>
                                        </tr>
                                        <?php
                                        if (@mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE id='$_REQUEST[pick]' AND user_id=" . $_SESSION[user_id])) == 0) {
                                            ?>
                                            <tr class='tbl_bg2'>
                                                <td height=100 valign=middle colspan=2>
                                                    <span class=red><?= $lang['PROJECT_SPECIFIED_NUMBER'] ?><br>
                                                    <!--<a href='<?= $vpath ?>active_jobs.html' class=link_class><?= $lang['RETURN_TO_PREVIOUS_PAGE'] ?></a>-->
                                                        </td>
                                                        </tr>
                                                        </table>
                                                        <?php
                                                    } else {
                                                        if (!$_REQUEST[submit]) {
                                                            ?>
                                                            <tr class="tbl_bg_4">
                                                                <td class=link_class colspan=2>
                                                                    <strong><?= $lang['PROJECT'] ?> : <?= getproject($_REQUEST[pick]) ?></strong>
                                                                </td>
                                                            </tr>
                                                            <tr class="tbl_bg2" >
                                                                <td class="link_class" colspan="2" style="text-decoration:none;text-align: justify;">
                                                                    <?= str_replace("\\", "", html_entity_decode($lang['MY_JOBS_MSG'])) ?>
                                                                </td>
                                                            </tr>
                                                            <tr ><td class=link_class>
                                                                    <form method="POST" action="">
                                                                        <input type="hidden" name="pick" value="<?= $_REQUEST[pick] ?>">
                                                                        <input type="hidden" name="submit" value="select">
                                                                        </td></tr>
                                                                        </table><br>
                                                                        <table width="100%" border=0 cellspacing=1 cellpadding=4 bgcolor=whitesmoke>
                                                                            <tr class="tbl_bg_4">
                                                                                <td ><b><?= $lang['SLCT'] ?></b></td>
                                                                                <td><b><?= $lang['PROV_H'] ?></b></td>
                                                                                <td><b><?= $lang['BID'] ?></b></td>
                                                                                <td><b><?= $lang['DLV_WTN'] ?></b></td>
                                                                                <td><b><?= $lang['TIME_BID_H'] ?></b></td>
                                                                                <td><b><?= $lang['REVIEWS'] ?></td>
                                                                            </tr>
                                                                            <?php
                                                                            $rez_t = mysql_query("SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick]);
                                                                            $total = @mysql_num_rows($rez_t);
                                                                            if ($_GET['page']) {
                                                                                $sql = "SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick] . " limit " . ($_REQUEST['page'] - 1) * $no_of_records . "," . $no_of_records . "";
                                                                            } else {
                                                                                $sql = "SELECT * FROM " . $prev . "buyer_bids WHERE project_id=" . $_REQUEST[pick] . " limit 0," . $no_of_records . "";
                                                                            }

                                                                            $rez = mysql_query($sql);


                                                                            if ($total == 0) {
                                                                                ?>

                                                                                <tr><td  class="red" valign=middle align=center colspan=6><?= $lang['NO_BDS_YT'] ?></td></tr>
                                                                                <?php
                                                                            } else {

                                                                                $i = 0;
                                                                                while ($row = @mysql_fetch_array($rez)) {
                                                                                    $i++;
                                                                                    if (!($i % 2)) {
                                                                                        $bg = 'whitesmoke';
                                                                                    } else {
                                                                                        $bg = '#ffffff';
                                                                                    }
                                                                                    $result4 = mysql_query("SELECT AVG(avg_rate) as avg_rate FROM " . $prev . "feedback WHERE feedback_to=" . $row[bidder_id]);
                                                                                    if ($_REQUEST[select] == $row[user_id]) {
                                                                                        ?>
                                                                                        <tr class=link_class bgcolor="<?= $bg ?>">
                                                                                            <td>
                                                                                                <input type=radio name=chosen value="<?= $row[bidder_id] ?>">
                                                                                            </td>
                                                                                            <td><a href='<?= $vpath ?>publicprofile/<?= getusername($row[bidder_id]) ?>' class=link_class><u><?= getusername($row[bidder_id]) ?></u></a>
                                                                                            </td>
                                                                                            <td><?= $curn . $row[bid_amount] ?></td>
                                                                                            <td><?= $row[duration] ?> days</td>
                                                                                            <td><?= $row[add_date] ?></td>
                                                                                            <td>
                                                                                                <?php
                                                                                            } else {
                                                                                                ?>
                                                                                        <tr class=link_class bgcolor="<?= $bg ?>">
                                                                                            <td><input type=radio name=chosen value="<?= $row[user_id] ?>"></td>
                                                                                            <td><a href='<?= $vpath ?>publicprofile/<?= getusername($row[user_id]) ?>' class=link_class><u><?= getusername($row[bidder_id]) ?></u></a></td>
                                                                                            <td><?= $curn . $row[bid_amount] ?></td>
                                                                                            <td><?= $row[duration] ?> days</td>
                                                                                            <td><?= $row[add_date] ?></td>
                                                                                            <td>
                                                                                                <?php
                                                                                            }

                                                                                            if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to=" . $row[bidder_id])) == 0) {

                                                                                                echo $lang['NO_FDB_YT'];
                                                                                            } else {
                                                                                                echo '<a href="' . $vpath . 'publicprofile/' . getusername($row[bidder_id]) . '/" class=link_class>';

                                                                                                $avgratin = round(mysql_result($result4, 0, "avg_rate"), 2);
                                                                                                $avgrating = explode(".", $avgratin);
                                                                                                for ($t2 = 0; $t2 < $avgrating[0] - 5; $t2++):

                                                                                                endfor;

                                                                                                $numeric2 = 10 - $avgrating[0];

                                                                                                if ($numeric2) {

                                                                                                    for ($b2 = 0; $b2 < $numeric2 - 5; $b2++) {
                                                                                                        
                                                                                                    }
                                                                                                }

                                                                                                if (mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to='" . $row[bidder_id] . "'")) == 1) {

                                                                                                    echo ' (<b>1</b>' . $lang['REVIEW'] . ' )';
                                                                                                } else {

                                                                                                    echo "<span class=\"starsSmall rating" . $avgrating[0] . "\">&nbsp;</span>";

                                                                                                    echo ' (<b>' . mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "feedback WHERE feedback_to='" . $row[bidder_id] . "'")) . '</b> reviews)';
                                                                                                }

                                                                                                echo '</a>';
                                                                                            }
                                                                                            ?>
                                                                                        </td></tr>
                                                                                    <tr bgcolor='<?= $bg ?>'>
                                                                                        <td  colspan="6" class="link_class" style="border-bottom:solid 1px"><?= $row[cover_letter] ?></td>
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <tr class=link_class bgcolor="<?= $light ?>">
                                                                                <td colspan=5 >
                                                                                    <input type=button OnClick="javascript:history.back();" class="submit_bott" value="<?= $lang['BACK'] ?>"></td>
                                                                                <td   align=right>
                                                                                    <input type="submit" class="submit_bott"  value="<?= $lang['SELECT_PROVIDER'] ?>">
                                                                                </td>
                                                                            </tr>
                                                                    </form>
                                                                    </table>
                                                                    <?php
                                                                } else {

                                                                    if (!isset($_POST['chosen'])) {
                                                                        $_SESSION['select_provider'] = $lang['MSG_NO_PRV'];
                                                                        header($lang['LOCATION'] . ": " . $vpath . "my-jobs/pick/" . $_REQUEST['pick'] . "/");
                                                                    } else {
																	
																	   $usr = mysql_fetch_array(mysql_query("SELECT * from " . $prev . "user where user_id=" . $_SESSION['user_id']));
                                                                       $proj = mysql_fetch_array(mysql_query("SELECT * from " . $prev . "projects where id=" . $_REQUEST['pick']));
                                                                        mysql_query("UPDATE " . $prev . "projects SET chosen_id='$_REQUEST[chosen]', status='frozen' WHERE id='$_REQUEST[pick]'");

                                                                        mysql_query("UPDATE " . $prev . "buyer_bids SET chose='P', chosen_id='$_REQUEST[chosen]' WHERE project_id='$_REQUEST[pick]' and bidder_id='$_REQUEST[chosen]'");

                                                                        $prjct = '<a href="' . $vpath . 'my-jobs.php?mode=accept&id=' . $_REQUEST[pick] . '&confirm=' . $_REQUEST[pick] . '">' . getproject($_REQUEST[pick]) . '</a>';
																		$fetchproject=mysql_fetch_assoc(mysql_query("SELECT user_id,chosen_id FROM " . $prev . "projects WHERE id='".$_REQUEST[pick]."'"));
                                                                         
                                                                       /* $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_freelancer' AND `langid`='" . getUserLastLang($_REQUEST[chosen]) . "'");
                                                                        if (mysql_num_rows($mailqf) == 0) {
                                                                            $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_freelancer' AND `langid`='en'");
                                                                        }

                                                                        $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_employe' AND `langid`='" . $_SESSION['lang_code'] . "'");
                                                                        if (mysql_num_rows($mailqe) == 0) {
                                                                            $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='bid_on_job_for_employe' AND `langid`='en'");
                                                                        }

                                                                        $mailrf = mysql_fetch_assoc($mailqf);
                                                                        $mailre = mysql_fetch_assoc($mailqe);

                                                                        $mailbodyf = html_entity_decode($mailrf['body']);
                                                                        $mailbodye = html_entity_decode($mailre['body']); */



                                                                        $msg = nl2br($setting[emailheader]) . $lang['MSG_JOB'] . getproject($_REQUEST[pick]) . $lang['MSG_JOB_IMP'] . $prjct . $lang['MSG_JOB_2'] . $setting[emailaddress] . '

--------------------

' . $setting[emailfooter];

                                                                        $from = $setting['admin_mail'];

                                                                        $mail_id = getemail($_REQUEST[chosen]);

                                                                       /* $mail_type = 'select_provider';


                                                                        $row_mail_type = mysql_fetch_array(mysql_query("select * from " . $prev . "mailsetup where mail_type = '" . $mail_type . "'"));

                                                                        $body = html_entity_decode($row_mail_type['header']) . $msg . html_entity_decode($row_mail_type['footer']);*/
																		
																		$prurl = $vpath . "project/" . $_REQUEST[pick] . "/" . str_replace("/", "", str_replace(" ", "-", getproject($_REQUEST[pick]))) . ".html";
																		
																		$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='select_provider_for_freelancer' AND `langid`='" . $_SESSION['lang_code'] . "'");
																			if (mysql_num_rows($mailqf) == 0) {
																			$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='select_provider_for_freelancer' AND `langid`='en'");
																			}

																			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='select_provider_for_employe' AND `langid`='" . getUserLastLang($proj['user_id']) . "'");
																			if (mysql_num_rows($mailqe) == 0) {
																			$mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='select_provider_for_employe' AND `langid`='en'");
																			}

																			$mailrf = mysql_fetch_assoc($mailqf);
																			$mailre = mysql_fetch_assoc($mailqe);

																			$mailbodyf = html_entity_decode($mailrf['body']);
																			$mailbodye = html_entity_decode($mailre['body']);
                                                                        $subjectf = html_entity_decode($mailrf['subject']);
                                                                        $mailbodyf = str_replace("{username}", getUserDetailsById($fetchproject['chosen_id'],'username'), $mailbodyf);
                                                                        $mailbodyf = str_replace("{project}", "<a href='" . $prurl . "'>" .getproject($_REQUEST[pick]).'</a>',$mailbodyf);
																		$mailbodyf = str_replace("{employe}", getUserDetailsById($fetchproject['user_id'],'username'), $mailbodyf);

                                                                        $headers = "MIME-Version: 1.0\r\n";
                                                                        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                                                                        $headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
                                                                        $headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
																		
																		
																		$subjecte = html_entity_decode($mailre['subject']);
																		$mailbodye = str_replace("{username}", $usr['username'], $mailbodye);
																		$mailbodye = str_replace("{freelancer}", getUserDetailsById($fetchproject['chosen_id'],'username'), $mailbodye);
																		$mailbodye = str_replace("{project}", "<a href='" . $prurl . "'>" .getproject($_REQUEST[pick]).'</a>', $mailbodye);
																		

                                                                        mail($mail_id, $subjectf, $mailbodyf, $headers);

                                                                         mail($usr['email'], $subjecte, $mailbodye, $headers);


                                                            

                                                                        $message = $lang['HIRD_PROJ'] . '<br /><br />

						' . $lang['NEW_RT'] . ': $' . $_POST['rate'] . '<br />

						' . $lang['PROJECT_NAMEE'] . ': ' . $proj['project'];


                                                                        // $notify = mysql_query("INSERT into " . $prev . "notification set user_id='" . $_POST['chosen'] . "', message='" . $lang['HIRE_INFO'] . "', `add_date`='" . date('Y-m-d') . "'");
                                                                        $link = $vpath.'offer/'.$_POST[project_id];
                                                                        $notify = add_notification($_POST['chosen'], $lang['HIRE_INFO'], 'W', $link);
                                                                        ?>
                                                                <tr><td colspan="6" class="link_class" style="text-decoration: none;text-align: justify;">
                                                                        <?= $lang['MSG_JOB_3'] ?> <b><?= getusername($_REQUEST[chosen]) ?></b><?= $lang['MSG_JOB_4'] ?> <b><?= getproject($_REQUEST[pick]) ?></b><?= $lang['MSG_JOB_5'] ?><br><br>
                                                                        <?= $lang['MSG_JOB_6'] ?><b><?= getusername($_REQUEST[chosen]) ?></b> <?= $lang['DOES_NOT_RES'] ?>.<br><br>

                                                                        <?= $lang['MSG_JOB_8'] ?><br><br>
                                                                        <div align=right>
                                                                            <a href="<?= $vpath ?>active_jobs.html" class=link_class><?= $lang['GO_BK'] ?></a></div></td>
                                                                </tr></table>
                                                <?php
                                            }
                                        }
                                    }
                                } else {
                                    ?>
                                    <table width='743' border='0' align='left' cellpadding='0' cellspacing='0'>

                                        <tr class='tbl_bg_4'>
                                            <td width='200' align='left'class="spaces"><?= $lang['PROJECT_NAMEE'] ?></td>
                                            <td width='70' align='center'><?= $lang['BIDS'] ?></td>
                                            <td width='150' align='center'><?= $lang['STATUS'] ?></td>
                                            <td width='300' align='center'><?= $lang['ACTION'] ?></td>
                                        </tr>
                                        <?php
                                        $tinyres_t = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC");

                                        $total = @mysql_num_rows($tinyres_t);

                                        if ($_GET['page']) {
                                            $sql = "SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC limit " . ($_REQUEST['page'] - 1) * $no_of_records . "," . $no_of_records . "";
                                        } else {
                                            $sql = "SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY id,date2 DESC limit 0," . $no_of_records . "";
                                        }
                                        $tinyres = mysql_query($sql);


                                        if ($total == 0) {
                                            ?>
                                            <tr class="tbl_bg2"><td  colspan=4 height=50 valign=middle class=red><center><strong><?= $lang['NO_JOBS_DISPLAY'] ?></strong></td></tr>

                                                <?php
                                            } else {

                                                $i = 0;

                                                while ($kikrow = mysql_fetch_array($tinyres)) {

                                                    if (!($i % 2)) {
                                                        $bg = "#ffffff";
                                                    } else {
                                                        $bg = "whitesmoke";
                                                    }
                                                    ?>
                                                    <tr class="tbl_bg2" ><td align="left" class="space" style="border-right:none;"><a class="font_bold2" href="<?= $vpath ?>project/<?= $kikrow[id] ?>/"><?= ucwords($kikrow[project]) ?></a>

                                                        </td> <td align="center"><?= totalbid($kikrow[id]) ?></td><td align="center" class="job_type" style="border-right:none;">

                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                    ?>
                                                    </table>
                                                    <?php
                                                }
                                                ?></td>
                                        </tr>

                                </table>
                                </div>
                                </div>
                                </div>
                                </div>

                                <div style="clear:both; height:10px;"></div>
                                <?php include 'includes/footer.php'; ?>

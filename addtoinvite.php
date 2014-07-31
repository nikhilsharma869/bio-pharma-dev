<?php

include("configs/path.php");
$proj_id = $_POST['project_id_val'];
$txtemail = $_POST['txtemail'];
$sendflag = FALSE;
if ($_SESSION[user_id] != '' && $proj_id != "" && $txtemail != "") {
    $row_user1 = mysql_fetch_array(mysql_query("select username, email from " . $prev . "user where user_id = '" . $_SESSION['user_id'] . "'"));
    $row_user = mysql_fetch_array(mysql_query("select user_id,username, email from " . $prev . "user where `email` = '" . $txtemail . "'"));

    $proj = @mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id=" . $proj_id));

    $prjct = '<a href="' . $vpath . 'project/' . $proj['id'] . '">' . $proj['project'] . '</a>';


    $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='invitation_for_employe' AND `langid`='" . $_SESSION['lang_code'] . "'");
    if (mysql_num_rows($mailqe) == 0) {
        $mailqe = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='invitation_for_employe' AND `langid`='en'");
    }

    $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='invitation_for_freelancer' AND `langid`='" . getUserLastLang($row_user['user_id']) . "'");
    if (mysql_num_rows($mailqe) == 0) {
        $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='invitation_for_freelancer' AND `langid`='en'");
    }
    $mailre = mysql_fetch_assoc($mailqe);
    $mailbodye = html_entity_decode($mailre['body']);

    $mailrf = mysql_fetch_assoc($mailqf);
    $mailbodyf = html_entity_decode($mailrf['body']);

    $subjecte = html_entity_decode($mailre['subject']);
    $mailbodye = str_replace("{username}", $row_user1['username'], $mailbodye);
    $mailbodye = str_replace("{freelancer}", $row_user['username'], $mailbodye);
    $mailbodye = str_replace("{project}", $prjct, $mailbodye);

    $subjectf = html_entity_decode($mailre['subject']);
    $mailbodyf = str_replace("{username}", $row_user['username'], $mailbodyf);
    $mailbodyf = str_replace("{employe}", $row_user1['username'], $mailbodyf);
    $mailbodyf = str_replace("{project}", $prjct, $mailbodyf);



    $headers = "MIME-Version: 1.0 \r\n";
    $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
    $headers.="From: " . $setting['admin_mail'] . "\r\n";
    if ($setting['cc_mail'] != '') {
        $headers.="Cc: " . $setting['cc_mail'] . "\r\n";
    }
    if (mail($row_user['email'], $subjectf, $mailbodyf, $headers)) {
        mail($row_user1['email'], $subjecte, $mailbodye, $headers);
        $_SESSION['succ'] = $lang['MAIL_SUC'];
        $sendflag = TRUE;
    } else {
        $_SESSION['error'] = $lang['ERR_TRY_H'];
    }
}
?>
<?php

if ($sendflag) {
    echo '<font color=green>' . $_SESSION['succ'] . '</font>';
    unset($_SESSION['succ']);
} else {
    echo '<font color=red>' . $_SESSION['error'] . '</font>';
    unset($_SESSION['error']);
}
?>
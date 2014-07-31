<?php
include "configs/path.php";
session_start();

if (isset($_REQUEST[sub])) {
    $password = rand(1111111, 9999999);

    $res_user = mysql_query("select * from " . $prev . "user where email='" . $_REQUEST[email] . "'");
    if (mysql_num_rows($res_user) > 0) {
        $row_user = mysql_fetch_array($res_user);
        // echo "update ".$prev."user set  password='".md5($password)."' where user_id='".$row_user[user_id]."'";
        $res_user_temp = mysql_query("update " . $prev . "user set  password='" . md5($password) . "' where user_id='" . $row_user[user_id] . "'");
        if ($res_user_temp) {
            $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='forgot_password' AND `langid`='" . $_SESSION['lang_code'] . "'");
            if (mysql_num_rows($mailq) == 0) {
                $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='forgot_password' AND `langid`='en'");
            }
            $mailr = mysql_fetch_assoc($mailq);
            $mailbody = html_entity_decode($mailr['body']);

            $mailbody = str_replace("{username}", $row_user['username'], $mailbody);
            $mailbody = str_replace("{password}", $password, $mailbody);

            $subject = html_entity_decode($mailr['subject']);

            $headers = "MIME-Version: 1.0 \r\n";
            $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
            $headers.="From: " . $setting['admin_mail'] . "\r\n";
            if ($setting['cc_mail'] != '') {
                $headers.="Cc: " . $setting['cc_mail'] . "\r\n";
            }

            $ret_mail = mail($row_user['email'], $subject, $mailbody, $headers);

            if ($ret_mail == true) {
                $msg = "<font color=\"green\"><br><br><i>Email with new password is successfully sent to your mail id.</i></font>";
            } else {
                $msg = "<font color=\"red\"><i>Mail cannot be sent, Please try later.</i></font>";
            }
        }
    } else {
        $msg = "<font color=\"red\"><i>This mail id is not registered with " . $dotcom . ".</i></font>";
    }
}
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Forget Password</title>
        <script type="text/javascript" src="js/forgotpass.js"></script>
    </head>

    <style type="text/css">
        .creatbnt {
            background: none repeat scroll 0 0 #2878A6;
            border: 0 none;
            color: #FFFFFF;
            float: left;
            font-size: 16px;
            font-weight: bold;
            margin: 12px 0;
            padding: 8px 19px;
        }


        .reg_input{
            background: #FFFFFF;
            border: 1px solid #dfdede;

            -moz-box-shadow: 0 0 5px #ebeaea;
            -webkit-box-shadow: 0 0 5px#ebeaea;
            box-shadow: 0 0 5px #ebeaea;
            color: #999999;
            font-size: 13px;
            float:left;
            margin:3px 0px;
            padding:9px 9px;
            text-align: left;
            width: 330px;
            outline: none;
        }

        .reg_input:focus{
            -webkit-box-shadow:0 0 8px #98c1ef;
            -moz-box-shadow:0 0 8px #98c1ef;
            box-shadow:0 0 8px #98c1ef;
            border: #98c1ef 1px solid; 
        }

    </style>
    <body>
        <div class="clear"></div>
        <div class="register_panel">

            <div class="signin-form_box">
                <form name="forgotpass_frm" action="" method="post" onsubmit="return forgotpass_valid();">
                    <div class="register-form"><p><span lang="en">Forgot your Username or password ?</span>:</p>
                        <input class="reg_input" id="email" name="email" size="25"  />
                    </div>


                    <div class="register-form">
                        <input type="submit" class="creatbnt" name="sub" value="Submit" /><br />
                    </div>
            </div>
        </div>

        <?php
        if (isset($msg)) {
            ?>
            <div style="font-family:Arial, Helvetica, sans-serif; font-style:italic; font-size:12px; margin-top:10px;"><?php print $msg; ?></div>

            <?php
        } else {
            ?>
            <div id="errbox2" style="color:#F00; float:left;font-family:Arial, Helvetica, sans-serif; font-style:italic; font-size:12px;margin-top:10px;"></div>

            <?php
        }
        ?>

        </form>
        </div> 
    </body>
</html>





















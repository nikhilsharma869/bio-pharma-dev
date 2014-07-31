<?php
$current_page = "Create an Account";
include ('includes/header.php');
include("country.php");

$reg_date = date("Y-m-d");
if (isset($_POST['emp_reg'])) {
    $errormsg = 'false';

    if ((empty($_REQUEST['email'])) || (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST['email']))) {
        $emailerror = $lang['ALERT_P1'];
        $errormsg = 'true';
        $_SESSION['error'].=$emailerror;
    }
    if (!$emailerror) {

         if (!$emailerror && (@mysql_num_rows(mysql_query("select user_id from " . $prev . "user where email = '" . txt_value($_REQUEST['email']) . "' ")))) {
            $emailerror = " " . $lang['ALERT_P2'] . " ";
 $errormsg = 'true';

            $_SESSION['error'].=$emailerror;
        }
    }
    $pattern = "/[!|@|#|$|%|^|&|*|(|)|_|\-|=|+|\||,|.|\/|;|:|\'|\"|\[|\]|\{|\}]/i";
    if (empty($_REQUEST['username'])) {
        $usererror = $lang['PLEASE_ENTER_USERNAME'];
        $_SESSION['error'].=$usererror;
    }

    if (preg_match("/^[A-Z,a-z,0-9]{0,25}$/i", stripslashes(trim($_REQUEST['username'])))) {
        echo"";
    } else {
        $usererror = $lang['ILLEGAL_CHARACTER'];
        $errormsg = 'true';
        $_SESSION['error'].=$usererror;
    }
if (!usererror) {

         if (!usererror && (@mysql_num_rows(mysql_query("select user_id from " . $prev . "user where  username='".txt_value($_REQUEST['username'])."'")))) {
$usererror = "Already exists";
 $errormsg = 'true';
        $_SESSION['error'].=$usererror;
        }
    }
    if (empty($_REQUEST['password']) || (strlen(trim($_REQUEST['password'])) < 4) || (strlen(trim($_REQUEST['password'])) > 25)) {
        $passerror = $lang['ALERT_P5'];
        $errormsg = 'true';
        $_SESSION['error'].=$passerror;
    }
    if (empty($_REQUEST['password1']) || ($_REQUEST['password'] != $_REQUEST['password1'])) {
        $cpasserror = $lang['ALERT_P6'];
        $errormsg = 'true';
        $_SESSION['error'].=$cpasserror;
    }


    if ($errormsg == 'false' || $_SESSION['error'] == "") {

        $r = mysql_query("insert into " . $prev . "user set
		email='" . txt_value($_REQUEST['email']) . "',
		password='" . md5($_REQUEST['password']) . "',
		user_type='E',
		username='" . txt_value($_REQUEST['username']) . "',
		ip='" . $_SERVER['REMOTE_ADDR'] . "',
		country='" . addslashes($_REQUEST['country']) . "',
		v_key='" . md5($_REQUEST['username']) . "',
		reg_date=now(),
		edit_date=now(),
		ldate=now(),
		account_type='" . $_POST['account_type'] . "',
		v_stat='N'");
        $user_id = mysql_insert_id();
        $planqrry = mysql_query("SELECT * FROM `" . $prev . "membership_plan` WHERE `id`='1'");
        $planrow = mysql_fetch_assoc($planqrry);
        mysql_query("INSERT INTO `" . $prev . "usermembership` SET 
                `user_id`='" . $user_id . "',
                `plane_id`='1',
                `skill`='" . $planrow['skills'] . "', 
                `bids`='" . $planrow['bids'] . "',
                `portfolio`='" . $planrow['portfolio'] . "',
				`day`='".$planrow['date']."',
                `sub_date`=NOW(),
               `exp_date`=DATE_ADD(NOW(), INTERVAL ".$planrow['date']." DAY) ");
        if ($_POST['newsletter']) {
            mysql_query("insert into messenger_users set 
					firstname=\"" . $_REQUEST['firstname'] . "\",
					lastname=\"" . $_REQUEST['lastname'] . "\",
					signup_date=now(),
					email_address=\"" . $_REQUEST['email'] . "\"");
        }

        if ($user_id){

           
            $lnk = $vpath . "activate.php?v_key=" . md5($_REQUEST['username']) . "&user=".$user_id;
            $url = "<a href='" . $lnk . "'>";
            $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='registration' AND `langid`='" . $_SESSION['lang_code'] . "'");
            if (mysql_num_rows($mailq) == 0) {
                $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='registration' AND `langid`='en'");
            }
            $mailr = mysql_fetch_assoc($mailq);
            $mailbody = html_entity_decode($mailr['body']);

            $mailbody = str_replace("{username}", $_REQUEST['username'], $mailbody);
            $mailbody = str_replace("{password}", $_REQUEST['password'], $mailbody);
            $mailbody = str_replace("{url_link}", $url, $mailbody);
            $mailbody = str_replace("{a_cl}", "</a>", $mailbody);
            $mailbody = str_replace("{copy_url}", $lnk, $mailbody);

            $subject = html_entity_decode($mailr['subject']);

            $headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$dotcom.'<no-reply@bio-pharma.com>' . "\r\n" .
    'Reply-To: '.$setting['admin_mail']. "\r\n" .
    'X-Mailer: PHP/' . phpversion();


            mail($_POST['email'], $subject, $mailbody, $headers);

            header("location:singup_success.php?succ='succ'");
        } else {
            $_SESSION['error'] = $lang['REGIRTRATION_ERROR'];
        }
    }
}
?>

<script type="text/javascript">
<!--

    function ValidateAndSubmit()
    {
        form1 = document.forms['_register'];
        if (ValidateForm())
        {
            form1.submit();
            return true;
        }
        else
        {
            return false;
        }
    }

    function ValidateForm() {
        if (usernameCheck() && emailCheck() && passwordCheck() && termCheck()) {
            return true;
        }
        else {
            return false;
        }
    }

    function nameCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['firstname'].value == '' || form1.elements['lastname'].value == '')
        {
            if (form1.elements['firstname'].value == '') {
                alert("<?= $lang['ALERT_P3'] ?>");
                form1.elements['firstname'].focus();
                return false;
            }
            if (form1.elements['lastname'].value == '')
            {
                alert("<?= $lang['ALERT_P4'] ?>");
                form1.elements['lastname'].focus();
                return false;
            }
        }
        else {
            return true;
        }
    }
    function emailCheck() {
        form1 = document.forms['_register'];

        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(form1.elements['email'].value) == false || form1.elements['email'].value == '')
        {
            alert("<?= $lang['VALID_EMAIL_ADDRESS'] ?>");
            form1.elements['email'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function countryCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['country'].value == '')
        {
            alert("<?= $lang['ALERT_P15'] ?>");
            form1.elements['country'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function stateCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['state'].value == '')
        {
            alert("<?= $lang['ENTER_YOUR_STATE'] ?>");
            form1.elements['state'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function cityCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['city'].value == '')
        {
            alert("<?= $lang['ENTER_YOUR_CITY'] ?>");
            form1.elements['city'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function zipcodeCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['zip'].value == '')
        {
            alert("<?= $lang['ENTER_YOUR_ZIP'] ?>");
            form1.elements['zip'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function phoneCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['phone'].value == '')
        {
            alert("<?= $lang['ENTER_PHONE_NUMBER'] ?>");
            return false;
        }
        else {
            return true;
        }
    }

    function usernameCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['username'].value == '')
        {
            alert("<?= $lang['MUST_ENTER_USERNAME'] ?>");
            form1.elements['username'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function passwordCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['password'].value != '' && form1.elements['password1'].value != '') {
            if (form1.elements['password'].value != form1.elements['password1'].value)
            {
                alert("<?= $lang['PASSWORD_CONFIRMATION_FAILED'] ?>");
                form1.elements['password'].focus();
                return false;
            }
            else {
                return true;
            }
        }
        else {
            if (form1.elements['password'].value == '')
            {
                alert('You must enter and confirm your password.');
                form1.elements['password'].focus();
                return false;
            }
            if (form1.elements['password1'].value == '')
            {
                alert("<?= $lang['ENTER_CONFIRM_PASSWORD1'] ?>");
                form1.elements['password'].focus();
                return false;
            }
        }
    }
    function capchaTest() {
        form1 = document.forms['_register'];
        if (!form1.elements['captchatext'].value)
        {
            alert("<?= $lang['CORRECT_CONFIRMATION_CODE'] ?>");
            form1.elements['captchatext'].focus();
            return false;
        }
        else {
            return true;
        }
    }
    function termCheck() {
        form1 = document.forms['_register'];
        if (form1.elements['agree'].checked == false) {
            alert("<?= $lang['TERMS_CONDITION'] ?>");
            form1.elements['agree'].focus();
            return false;
        }
        else {
            return true;
        }
    }
// -->
    function ChnageCaptchText(captchaid, captchaform, sell)
    {
        document.getElementById(captchaid).src = 'captcha/captcha.php?' + Math.random();
        document.getElementById(captchaform).focus();
        return true;
    }
</script>

<div class="clear"></div>
<div class="inner-middle">
    <div class="page_headding">
        <h3><?= $lang['CREATE_AN_ACCOUNT_AS_CLIENT'] ?></h3><h3></h3>
        <div class="clear"></div>
        <div class="click_panel"><?= $lang['DO_YOU_WANTTO_SIGNUP_AS_FREELANCER'] ?><a href="<?= $vpath ?>signup-worker.html"><?= $lang['CLICK_HERE'] ?></a></div>
    </div>
    <div class="clear"></div>
    <div class="register_panel">
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
        ?>

        <!--Register Form Start-->
        <form method="post" name="_register" id="_register" action="">
            <div class="register-form_box">
                <div class="register-form"><p><?= $lang['USRNM'] ?></p>
                    <input class="reg_input" name="username" type="text" value="<?= txt_value_output($_REQUEST['username']) ?>"/>
<?php
                    if ($usererror) {
                        echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>" . $usererror. "</b></span>";
                    }
                    ?>
                </div>
                <div class="register-form"><p><?= $lang['EMAIL_ADDRESS'] ?>:</p>
                    <input class="reg_input" name="email" type="text" value="<?= txt_value_output($_REQUEST['email']) ?>"/>
                    <?php
                    if ($emailerror) {
                        echo"<br /><span style=\"color:#3268a3;\" class='lnkred'><b>" . $emailerror . "</b></span>";
                    }
                    ?></div>

                <div class="register-form"><p><?= $lang['PASSWORD1'] ?>:</p>
                    <input class="reg_input" name="password" type="password" />
                    <?php
                    if ($passerror) {
                        echo"<br /><span style='color:#3268a3;' class='lnkred'><b>" . $passerror . "</b></span>";
                    } else {
                        ?><p>
                            <?= $lang['ENTER_CHARACTER_IN_PASSWORD'] ?></p>		
                        <?php
                    }
                    ?></div>

                <div class="register-form"><p><?= $lang['RETYPE_PASSWORD'] ?>:</p>
                    <input class="reg_input" name="password1" type="password" value="" />
                    <?php
                    if ($cpasserror) {
                        echo"<br /><span style='color:#3268a3;' class='lnkred'><b>" . $cpasserror . "</b></span>";
                    }
                    ?></div>

                <div class="register-form">
                    <h1><input name="agree" type="checkbox" value="Y" /><?= $lang['CLICKING_AGREE_TO_FREELANCERLESS'] ?> <a href="<?= $vpath ?>terms.php" target="_blank"><?= $lang['terms_service'] ?></a>, <a href="<?= $vpath ?>privacy.php" target="_blank"><?= $lang['privacy_policy'] ?></a>, <?= $lang['AND_USER_AGREEMENT'] ?> 
                    </h1>
                </div>
                <div class="register-form">
                    <input type="hidden" name="emp_reg" value="1"/>
                    <input type="button" class="creatbnt" value="<?= $lang['CREATE_AN_ACCOUNT'] ?>" name="emp_reg1" onclick="return ValidateAndSubmit();" /><br /><br />



                </div>

            </div>  </form> 
        <!--Register Form End-->


        <!--Register Right Start-->
        <div class="register-right">
            <h1><?= $lang['Now_ITS_EASIER_THAN_EVER_TO_GET_THINGS_DONE'] ?></h1>
        </div>
        <!--Register Right End-->
    </div>

</div>


<?php include 'includes/footer.php'; ?>

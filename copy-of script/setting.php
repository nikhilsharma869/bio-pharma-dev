<?php
$current_page = "setting";

include "includes/header.php";

include("country.php");



CheckLogin();
?>

<?php
//if(!$link){header("Location: ./index.php"); exit();}



if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_SESSION['usre_id'];
}



if (empty($user_id)) {
    header("Location: " . $vpath . "login.php");
    exit();
}





if (isset($_POST['hiddProfileSubmit'])) {

    $e = explode("@", $_POST['email']);

    $valid_email = $e[1];

    if ((empty($_REQUEST['email'])) || (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $_REQUEST['email']))) {
        $emailerror = $lang['ALERT_P1'];
    }

    if (!emailerror) {

        if ((checkdnsrr($valid_email) == false)) {

            $emailerror = $lang['ALERT_P1'];
        }

        if (!$emailerror && (@mysql_num_rows(mysql_query("select user_id from " . $prev . "user where email='" . $_REQUEST['email'] . "' and user_id!=" . $_SESSION['user_id'])))) {

            $emailerror = $lang['ALERT_P2'];
        }
    }







    if (($_REQUEST['chkChangePassword'] == 1) && ((strlen(trim($_REQUEST['password'])) < 4) || (strlen(trim($_REQUEST['password'])) > 25))) {
        $passerror = $lang['ALERT_P5'];
        $r2 = false;
    }

    if (($_REQUEST['chkChangePassword'] == 1) && ($_REQUEST['password'] != $_REQUEST['password1'])) {
        $cpasserror = $lang['ALERT_P6'];
        $r2 = false;
    }

    $_SESSION['error'].=$cpasserror;

    if (!$cpasserror && !$passerror && ($_REQUEST['oldPassword'] != "")) {

        $r2 = false;

        $r3 = mysql_query("select user_id, username from " . $prev . "user where password='" . md5($_POST['oldPassword']) . "' and user_id=" . $_SESSION['user_id']);

        if (@mysql_num_rows($r3)) {

            $r2 = mysql_query("update " . $prev . "user set password='" . md5($_POST['password']) . "' where user_id=" . $_SESSION['user_id']);

            $s = mysql_fetch_assoc($r3);

            $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='change_password' AND `langid`='" . $_SESSION['lang_code'] . "'");
            if (mysql_num_rows($mailq) == 0) {
                $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='change_password' AND `langid`='en'");
            }
            $mailr = mysql_fetch_assoc($mailq);
            $mailbody = html_entity_decode($mailr['body']);

            $mailbody = str_replace("{username}", $s['username'], $mailbody);
            $mailbody = str_replace("{password}", $_POST['password'], $mailbody);

            $subject = html_entity_decode($mailr['subject']);

            $headers = "MIME-Version: 1.0 \r\n";
            $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
            $headers.="From: " . $setting['admin_mail'] . "\r\n";
            if ($setting['cc_mail'] != '') {
                $headers.="Cc: " . $setting['cc_mail'] . "\r\n";
            }

            mail($_POST['email'], $subject, $mailbody, $headers);
        } else {

            $opasserror = $lang['ALERT_P9'];

            $_SESSION['error'].=$opasserror;
        }
    } elseif ($_REQUEST['oldPassword'] == "" && $_REQUEST['chkChangePassword'] != 1) {

        $r2 = true;
    }



    /* if(isset($_POST['trans_pass'])){

      mysql_query("update ".$prev."user set trans_pass='".md5($_POST['trans_pass'])."' where user_id=".$_SESSION['user_id']);

      } */

    //echo '$emailerror: '.$emailerror.'$fnameerror:'.$fnameerror.'$lnameerror'.$lnameerror.'$r2:'.$r2. $_SESSION['error'];

    if (!$emailerror && !$fnameerror && !$lnameerror && $r2 && $_SESSION['error'] == "") {
        $r = mysql_query("update " . $prev . "user set 
	
		account_type='" . $_REQUEST['account_type'] . "',
		user_type='" . addslashes($_REQUEST['user_type']) . "',
		edit_date=now()
		where user_id=" . $_SESSION['user_id']);
    }





    if ($r && $r2) {

        if ($_FILES['logo']['name']):

            @copy($_FILES['logo']['tmp_name'], "portfolio/logo_" . $_SESSION['user_id'] . "." . substr($_FILES['logo']['name'], -3, 3));

            $r = mysql_query("update " . $prev . "user set logo=\"portfolio/logo_" . $_SESSION['user_id'] . "." . substr($_FILES['logo']['name'], -3, 3) . "\" where user_id=" . $_SESSION['user_id']);

        endif;

        $_SESSION['succ'] = $lang['ALERT_P10'];

        $_SESSION['fullname'] = addslashes($_REQUEST['firstname']) . " " . addslashes($_REQUEST['lastname']);
        $_SESSION[user_type] = addslashes($_REQUEST['user_type']);
    }

    else {

        $_SESSION['error'].=$lang['ALERT_P11'];
    }
}



$r4 = mysql_query("select * from " . $prev . "user where user_id=" . $_SESSION['user_id']);

$d = @mysql_fetch_array($r4);
?>



<script>

<!--



//Enter-listener

    if (document.layers)
        document.captureEvents(Event.KEYDOWN);

    document.onkeydown =
            function(evt)

            {

                var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;

                if (keyCode == 13)   //13 = the code for pressing ENTER

                {

                    sendRequest();

                }

            }

    var passwordValidFlag = -1, emailValidFlag = -1;
            function ValidEmail(EmailAddress)

            {

                if ((EmailAddress.indexOf(' ') >= 0) || (EmailAddress.indexOf(';') >= 0) || (EmailAddress.indexOf(',') >= 0) || (EmailAddress.indexOf('@') < 1))
                    return false;

                if (EmailAddress.substr(EmailAddress.indexOf('@')).indexOf('.') < 2)
                    return false;

                if (EmailAddress.substr(EmailAddress.indexOf('.', EmailAddress.indexOf('@'))).length < 3)
                    return false;

                return true

            }



    function ValidateForm() {



        form1 = document.forms['_profile'];


        if (form1.elements['email'].value == '') {

            alert("<?= $lang['ALERT_P14'] ?>");

            form1.elements['email'].focus();

            return false;

        }

        else if (!ValidEmail(form1.elements['email'].value)) {

            alert("<?= $lang['ALERT_P16'] ?>");

            form1.elements['email'].focus();

            return false;

        }

        else if (emailValidFlag == 0)

        {

            alert("<?= $lang['ALERT_P17'] ?>");

            form1.elements['email'].focus();

            return false;

        }

        if (form1.elements['chkChangePassword'].checked == true)

        {

            if (form1.elements['oldPassword'].value == "")

            {

                alert("<?= $lang['ALERT_P18'] ?>");

                form1.elements['oldPassword'].focus();

                return false;

            }

            /*else if(passwordValidFlag == -1 || passwordValidFlag == 0)
             
             {
             
             alert("Password entered is not correct");
             
             form1.elements['oldPassword'].focus();
             
             return false;
             
             }*/

            if (form1.elements['password'].value == "")

            {

                alert("<?= $lang['ALERT_P19'] ?>");

                form1.elements['password'].focus();

                return false;

            }

            if (form1.elements['password1'].value == '') {

                alert("<?= $lang['ALERT_P20'] ?>");

                form1.elements['password1'].focus();

                return false;

            }

            if (form1.elements['password'].value != form1.elements['password1'].value)

            {

                alert("<?= $lang['ALERT_P21'] ?>");

                form1.elements['password'].focus();

                return false;

            }

            /*if (form1.elements['trans_pass'].value == '') {
             
             alert("<?= $lang['ALERT_P22'] ?>");
             
             form1.elements['trans_pass'].focus();
             
             return false;
             
             }*/

        }



        return true;

    }

    function fnDisplayWaitPopUp()

    {

        //alert("kalpesh");

        $('process_waiting_dialog').style.top = Math.round((document.body.clientHeight / 2) - 50 + document.body.scrollTop) + 'px';

        $('process_waiting_dialog').style.left = Math.round((document.body.clientWidth / 2) - 150) + "px";

        new Effect.Appear('process_waiting_dialog', {duration: .1});

    }

    function sendRequest()

    {

        if (ValidateForm())

        {

            //new Effect.DropOut('mainContent'); 

            fnDisplayWaitPopUp();

            //window.setTimeout('Effect.Appear(\'mainContent\', {duration:.3})',2500);

            var form1 = document.forms['_profile'];

            new Ajax.Updater("mainContent", "profile.php?action=updateProfile", {method: 'post', parameters: Form.serialize(form1), asynchronous: false, onSuccess: function(t) {
                    new Effect.toggle('process_waiting_dialog', 'appear');
                }});

        }

    }



    function checkForOldPassword()

    {//alert("sdfsdf");

        var form1 = document.forms['_profile'];



        if (form1.elements['chkChangePassword'].checked == true)

        {

            var requestOptions;

            requestOptions = {
                method: 'post',
                parameters: 'oldPassword=' + form1.elements['oldPassword'].value + '',
                onSuccess: function(t)

                {//alert("sdrsrer");

                    passwordValidFlag = t.responseText;

                    //$('passwordErrorMessage').innerHTML = t.responseText;

                    if (t.responseText == '0')

                    {

                        passwordValidFlag = 0;

                        $('passwordErrorMessage').innerHTML = $lang['ALRT_30_H'];

                    }

                    else

                    {

                        passwordValidFlag = 1;

                        $('passwordErrorMessage').innerHTML = "";

                    }



                },
                onFailure: function(t) {

                    alert($lang['ALRT_31_H'] + t.statusText);

                }

            }



            new
                    Ajax.Request("profilechk.php?action=validatePassword", requestOptions);

        }

    }

    function checkForEmailId()

    {

        var form1 = document.forms['_profile'];

//	alert("here");

        var requestOptions;

        requestOptions = {
            method: 'post',
            parameters: 'email=' + form1.elements['email'].value + '',
            onSuccess: function(t)

            {





                $('divEmailErrorMessage').innerHTML = t.responseText;

                if (t.responseText == 1)

                {

                    emailValidFlag = 0;

                    $('divEmailErrorMessage').innerHTML = $lang['ALERT_P17'];

                }

                else

                {

                    emailValidFlag = 1;

                    $('divEmailErrorMessage').innerHTML = "";

                }

            }

        }



        new
                Ajax.Request("profilechk.php?action=validateEmailId", requestOptions);

    }

    // -->



</script>



<script language="javascript" type="text/javascript">

var browser=navigator.appName;

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

            document.getElementById("transpass").style.display = displaystyle;

        }

        else

        {

            document.getElementById("olspass").style.display = "none";

            document.getElementById("newpass").style.display = "none";

            document.getElementById("confpass").style.display = "none";

            document.getElementById("transpass").style.display = "none";

        }

    }

    function gtec(id) {
        $('.asd').toggle();
    }
</script>





<!-----------Header End-----------------------------> 



<!-- content-->

<div style="width:100%; float:left; background:#FFF;">
    <div class="main_div2">
        <div class="inner-middle"> 
            <div class="dash_headding">
                <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['setting'] ?></a></p></div>
            <div class="clear"></div>

            <!--Profile-->

            <?php include 'includes/leftpanel1.php'; ?> 

            <!-- left side-->

            <!--middle -->



            <div class="profile_right">


                <ul class="tabs">
                    <li><a href="javascript:void(0)" class="selected"><?= $lang['setting'] ?></a></li>
                </ul>

                <div class="newclassborder">


                    <div class="create_profile2">









                        <form  method="post" name="_profile" id="_profile" enctype="multipart/form-data">

                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_class">





                                <tr>

                                    <td align="left" valign="top" class="bx-border">

                                        <table border="0" cellpadding="4" cellspacing="0" align="center" width="97%"  >



                                            <tr><td colspan="2" align="center" >

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

                                                </td></tr>









                                    </td>

                                </tr>





                                <tr >

                                    <td class="tdclass" style="width:211px;"><b><?= $lang['EMAIL'] ?>: * </b></td>

                                    <td class="grid">

                                        <input name="email" type="text" onblur="checkForEmailId()" value="<?= $d['email'] ?>" size="30" class="from_input_box" readonly=true/>

                                        <?php
                                        if ($emailerror) {
                                            echo"<br /><span class='lnkred'><b>" . $emailerror . "</b></span><br />";
                                        }
                                        ?>
                                <tr><td>&nbsp;</td></tr>
                                <div id="divEmailErrorMessage"></div>            </td></tr>

                                <tr>

                                    <td  class="tdclass"><b><?= $lang['C_PASS'] ?></b></td>



                                    <td class="grid"><input type="checkbox" id="chkChangePassword" name="chkChangePassword"  value="1" onclick="showpass();"  /></td>

                                </tr>

                                <tr class="hilite1" style="display:none;" id="olspass">

                                    <td  class="tdclass"><b><?= $lang['O_PASS'] ?>*</b></td>

                                    <td class="grid"><br>

                                        <input name="oldPassword" type="password" onblur="checkForOldPassword()" value="" size="15" class="from_input_box" />

                                        <?php
                                        if ($opasserror) {
                                            echo"<br /><span class='lnkred'><b>" . $opasserror . "</b></span><br />";
                                        }
                                        ?>

                                        <div id='passwordErrorMessage'></div>          	</td>

                                </tr>



                                <tr style="display:none;" id="newpass">

                                    <td  class="tdclass"><b><?= $lang['N_PASS'] ?>: * </b></td>

                                    <td class="grid"><input name="password" type="password" value="" size="15" class="from_input_box" />

                                        <?php
                                        if ($passerror) {
                                            echo"<br /><span class='lnkred'><b>" . $passerror . "</b></span><br />";
                                        }
                                        ?>			</td>

                                </tr>

                                <tr class="hilite1" style="display:none;" id="confpass">

                                    <td class="tdclass"><b><?= $lang['CN_PASS'] ?>: * </b></td>

                                    <td>

                                        <input name="password1" type="password" value="" size="15" class="from_input_box" />

                                        <?php
                                        if ($cpasserror) {
                                            echo"<br /><span class='lnkred'><b>" . $cpasserror . "</b></span><br />";
                                        }
                                        ?>			</td>

                                </tr>

        <!--<tr style="display:none;" id="transpass">

    <td  class="tdclass"><b><?= $lang['TN_PASS'] ?>: * </b></td>

    <td class="grid"><input name="trans_pass" type="password" value="" size="15" class="from_input_box" />

    </td>

    </tr>-->
                                <tr class="hilite1">

                                    <td class="tdclass"><b><?= $lang['PROFILE_TYPE'] ?>: </b></td>

                                    <td class="boldfont_con">



                                        <input name="account_type" type="radio" value="I" <?php
                                        if ($d['account_type'] == 'I') {
                                            echo 'checked';
                                        }
                                        ?> onclick="gtec('I')" /><?= $lang['INDIVIDUAL'] ?>           

                                        <input name="account_type" type="radio" value="C" <?php
                                        if ($d['account_type'] == 'C') {
                                            echo 'checked';
                                        }
                                        ?> onclick="gtec('I')" /><?= $lang['COMPANY'] ?>  

                                    </td></tr>
                                <tr class="hilite1">

                                    <td class="tdclass"><b><?= $lang['WORK_AS'] ?>: </b></td>

                                    <td class="boldfont_con">

                                        <input type="radio" value='E' <?php
                                        if ($d['user_type'] == 'E') {
                                            echo 'checked';
                                        }
                                        ?>  name="user_type"> <?= $lang['CLIENTLE'] ?><br>

                                        <input type="radio" value='W'  <?php
                                        if ($d['user_type'] == 'W') {
                                            echo 'checked';
                                        }
                                        ?> name="user_type"> <?= $lang['PROFESSION'] ?><br>

                                        <input type="radio" value='B'  <?php
                                        if ($d['user_type'] == 'B') {
                                            echo 'checked';
                                        }
                                        ?> name="user_type"> <?= $lang['BOTH'] ?></td></tr>



                            </table>

                            </td></tr>

                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td align="left" valign="top" class="inner_bx-bottom">

                                    <table align="center" width="100%" cellpadding="0" cellspacing="0">

                                        <tr class="lnk"><td width="32%"></td>

                                            <td align="center" >

                                                <input type="submit"  class="submit_bott" value="<?= $lang['UPD_PRF'] ?>" onClick="return ValidateForm();"  style="background:url(images/update.png) 5% 50% no-repeat  #363636; 
                                                       color:#FFF; padding-left:30px;
                                                       " />



   <!-- <input type="image" src="images/update.jpg"  onClick="return ValidateForm();" />-->

                                                <input type="hidden" name="hiddProfileSubmit" value="1"> 

                                                <br />

                                            </td>

                                        </tr>

                                    </table>

                                </td>

                            </tr>

                            </table>

                        </form>




                    </div>




                </div>



            </div>



        </div> 
    </div></div>


<div style="clear:both; height:10px;"></div>



<?php include 'includes/footer.php'; ?>
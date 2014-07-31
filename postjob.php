<?php
$current_page = "Post your job";
include "includes/header.php";
CheckLogin();
$expdays = 14; /* * *****Project Expire days********* */
$restest = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$rowtest = mysql_fetch_array($restest);
$_REQUEST['firstname'] = $rowtest['fname'];
$_REQUEST['lastname'] = $rowtest['lname'];
?>

<link href="highslide/highslide.css" type="text/css" rel="stylesheet">
<script>



    function deleteOption(selectObject, optionRank) {

        if (selectObject.options.length != 0) {
            selectObject.options[optionRank] = null
        }

    }


    function Delete() {

        var formObject = document.forms['postjob']

        if (formObject.attachfile.selectedIndex != -1) {

            deleteOption(formObject.attachfile, formObject.attachfile.selectedIndex)



            selectBox = document.getElementById('attachfile');



            for (var i = 0; i < selectBox.options.length; i++) {

                selectBox.options[i].selected = true;

            }

        } else {

            alert("<?= $lang['ALERT1'] ?>");

        }

    }



    function RegValidate(frm)

    {

        var txt = "";

        if (document.getElementById("project").value == '')

        {

            txt += "<?= $lang['ALERT2'] ?>.\n";

        }



        if (document.postjob.description.value == '')

        {

            txt += "<?= $lang['ALERT3'] ?>.\n";

        }
        /*var ct=$("#categories:checked").length;
         
         if(ct<1)
         
         {
         
         txt+="<?= $lang['ALERT4'] ?>.\n";
         
         }
         */
        if (document.postjob.category_id.value == '')

        {

            txt += "<?= $lang['ALERT4'] ?>.\n";

        }
        if (document.postjob.scat_ids.value == '')

        {

            txt += "Please Add Skills.\n";

        }
        if (document.postjob.project_type.value == "F") {
            if (document.postjob.budget_id.value == '')

            {

                txt += "<?= $lang['ALERT7'] ?>.\n";

            }
        } else {
            if (document.postjob.budget_min.value < 1 || document.postjob.budget_max.value < 1)

            {

                txt += "Enter budget price.\n";

            }

        }
        /*if(document.postjob.cdays.value == '') 
         
         {
         
         txt+="<?= $lang['ALERT5'] ?>.\n";
         
         }
         
         if(document.postjob.cdays.value >45) 
         
         {
         
         txt+="<?= $lang['ALERT6'] ?>.\n";
         
         }
         
         
         if(document.postjob.agree.checked == false) {
         
         txt+="<?= $lang['TERMS_CONDITION'] ?>.\n";
         }
         */
        if (document.postjob.featured.checked == true)

        {

<?php
$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");

$row = mysql_fetch_array($res);

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));

$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));

$balsum = $rwbal['balsum1'] - $rwbal2['baldeb'];



if ($balsum < $setting['featuredcost']) {
    ?>

                txt += "<?= $lang['unsufficientamount'] ?>.<?php echo $setting['featuredcost']; ?>.\n";

    <?php
}
?>


        }



//	alert(txt);



        if (txt)

        {

            alert(txt);

            return false

        }

        return true

    }

//-->



    function ValidateForm(form1) {





        if (form1.elements['rate'].value == '') {

            alert('<?= $lang['ALERT12'] ?>');

            form1.elements['rate'].focus();

            return false;

        }

        if (form1.elements['profile'].value == '') {

            alert('<?= $lang['ALERT13'] ?>');

            form1.elements['profile'].focus();

            return false;

        }



        return true;

    }



    function EditValidate()
    {
        document.forms["postproject"].submit();
    }
    function project_type_box(project) {
        if (project == 'F') {
            $(".hourly").hide();
            $(".fixed").show();
        } else {
            $(".fixed").hide();
            $(".hourly").show();

        }

    }


</script>
<script type="text/javascript" src="<?= $vpath ?>domcollapse.js"></script>


<script src="<?= $vpath ?>js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?= $vpath ?>js/tag-it2.js" type="text/javascript" charset="utf-8"></script>
<link href="<?= $vpath ?>js/jquery.tagit.css" rel="stylesheet" type="text/css">
<link href="<?= $vpath ?>js/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
<script>
    function getscat(cat_id) {
        var info = "cat_id=" + cat_id;
        $.ajax({
            type: "POST",
            url: "<?= $vpath ?>getsubcat.php",
            data: info,
            success: function(dd) {

                $("#skills").html(dd);
            }
        });

    }

    function getfeature() {

        if ($('#featured').is(':checked')) {
            $('.sfeature').removeAttr("disabled");
        } else {
            $('.sfeature').prop("disabled", true);
        }
    }
    function edittext() {

        $(".descriptclass").slideDown('slow');

    }
</script>

<style type="text/css">

    /* domCollapse styles */
    @import "domcollapse.css";
.sk li a{ color:#000 !important}
</style>
<div style="width:100%; float:left; background:#FFF;">
    <div class="main_div2">
        <div class="browse_contract">
            <!--Post Contract-->
            <div class="post_contract">

                <!--Post Left-->
                <?php
                if ($_REQUEST[edit]) {
                    ?>									
                    <form method=post action="<?= $vpath ?>editpostjob.php" id="postproject" enctype="multipart/form-data" name='postjob' onsubmit="EditValidate();" >                    
                    <?php } else {
                        ?>
                        <form method=post action="<?= $vpath ?>postjob.html" id="postproject" enctype="multipart/form-data" name='postjob' onSubmit="javascript:return RegValidate(this);">                    
                        <?php } ?>
                        <input type=hidden name=edit value=<?= $_REQUEST[edit] ?>>
                        <?php
                        if ($_POST[submit] == $lang['SUBMIT'] && !$_REQUEST['editsubmit']) {
                            echo '<div class="post_left">';

                            $err_msg = "";
                            if (count($_REQUEST[attachfile])):

                                $attach = "";

                                for ($i = 0; $i < count($_REQUEST[attachfile]); $i++):

                                    $attach.= $_REQUEST[attachfile][$i] . ",";

                                endfor;

                                $rud = substr($attach, 0, -1);

                            endif;

                            ////////////////////////////////////////////////// start  insert amount in transaction table //////////////// feature project  ///////////////////////////////		

                            if ($_REQUEST[featured] && $_REQUEST[featured] == "featured") {
                                if ($balsum >= $setting['featuredcost']) {
                                    $special = $_POST[featured];

                                    if ($_POST[urgent] == 'urgent') {
                                        $special.="," . $_POST[urgent];
                                    }
                                    if ($_POST[sealed] == 'sealed') {
                                        $special.="," . $_POST[sealed];
                                    }
                                    if ($_POST[privacy] == 'privacy') {
                                        $special.="," . $_POST[privacy];
                                    }
                                    $today = getdate();

                                    $month = $today['mon'];

                                    $day = $today['mday'];

                                    $year = $today['year'];

                                    $hours = $today['hours'];

                                    $minutes = $today['minutes'];



                                    $payment_id = rand(1000, 9999) . time();



                                    $sql = "INSERT INTO " . $prev . "transactions set

		details = 'Posted Featured Project',

		user_id = '" . $_SESSION['user_id'] . "',

		balance = '" . $setting[featuredcost] . "',

		add_date = now(),

		date2 = '" . time() . "',

		paypaltran_id = '" . $payment_id . "',

		status = 'Y', amttype = 'DR'";



                                    mysql_query($sql);
                                } else {
                                    $_SESSION['error'].=$lang['NOT_SUFF_BALNC'];
                                    include("includes/err.php");
                                    unset($_SESSION['succ']);
                                    unset($_SESSION['error']);
                                }
                            }
                            ////////////////////////////////////////////////// start  insert amount in transaction table //////////////// feature project  ///////////////////////////////	

                            $secondsPerDay = ((24 * 60) * 60);

                            $ttoy = time();

                            $tttoy = genDate(time());

                            $expires = $ttoy + ($secondsPerDay * $expdays);

                            $txt = "";
                            $flag = 0;
                            $no_err = "";
                            $arraycat = explode(",", $_POST['scat_ids']);
                            if (count($arraycat) > 0) {
                                foreach ($arraycat as $id => $val) {


                                    $no_err = "no err";
                                    $err_msg = "";
                                    $flag++;

                                    $as = @mysql_fetch_array(mysql_query("select cat_id from " . $prev . "categories where cat_name='" . $val . "'"));

                                    $a = mysql_query("insert into " . $prev . "projects_cats set id=" . $ttoy . ",cat_id=" . $as[cat_id]);
                                    if ($a) {
                                        $txt.=$as[cat_id] . ",";
                                    }
                                }
                            }
                            if ($flag == 0) {

                                $_SESSION['error'].=$lang['POSTJOB_ERR'];
                                $err_msg = "err";
                            }
                            if ($err_msg == "" && $flag > 0) {
                                //echo "err_blank";

                                if ($txt) {
                                    $txt = substr($txt, 0, -1);
                                }
                                if ($_POST['project_type'] == "F") {
                                    if ($_REQUEST['budget_id'] == "1") {
                                        $budgetmin = "250";
                                        $budgetmax = "250";
                                    }
                                    if ($_REQUEST['budget_id'] == "2") {
                                        $budgetmin = "250";
                                        $budgetmax = "500";
                                    }
                                    if ($_REQUEST['budget_id'] == "3") {
                                        $budgetmin = "500";
                                        $budgetmax = "1000";
                                    }
                                    if ($_REQUEST['budget_id'] == "4") {
                                        $budgetmin = "1000";
                                        $budgetmax = "2500";
                                    }
                                    if ($_REQUEST['budget_id'] == "5") {
                                        $budgetmin = "2500";
                                        $budgetmax = "5000";
                                    }
                                    if ($_REQUEST['budget_id'] == "6") {
                                        $budgetmin = "5000";
                                        $budgetmax = "10000";
                                    }
                                    if ($_REQUEST['budget_id'] == "7") {
                                        $budgetmin = "10000";
                                        $budgetmax = "25000";
                                    }
                                    if ($_REQUEST['budget_id'] == "8") {
                                        $budgetmin = "above $25000";
                                    }
                                    if ($_REQUEST['budget_id'] == "9") {
                                        $budgetmin = "not sure";
                                    }
                                } else {
                                    $ptype = " / hr";
                                    $_REQUEST[budget_id] = 0;
                                    $budgetmin = $_POST['budget_min'];
                                    $budgetmax = $_POST['budget_max'];
                                }
                                $amnt = $setting['currency'] . $budgetmin;
                                if ($budgetmax != '') {
                                    $amnt .= "-" . $setting['currency'] . $budgetmax;
                                }
                                $amnt .=$ptype;
                                $sql_inser_project = mysql_query("insert into " . $prev . "projects set chosen_id='',status='open',id='" . $ttoy . "',date2='" . $ttoy . "',project='" . mysql_real_escape_string($_REQUEST[project]) . "',special='" . $special . "',categories='" . $txt . "',expires='" . $expires . "',budget_id='" . $_REQUEST[budget_id] . "',budgetmin='" . $budgetmin . "',budgetmax='" . $budgetmax . "',creation='" . date("Y-m-d") . "',ctime='" . date("h:i") . "',user_id='" . $_SESSION[user_id] . "',project_type='" . $_POST['project_type'] . "',description='" . mysql_real_escape_string($_REQUEST[description]) . "',attachment='" . $rud . "',opsys='" . $_REQUEST[opsys] . "',datasys='" . $_REQUEST[datasys] . "',zip='" . $_REQUEST[zip] . "',main_cat_id='" . $_POST['category_id'] . "'");

                                if ($sql_inser_project) {

                                    $res_user = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");

                                    $row_user = mysql_fetch_array($res_user);

                                    $purl = $vpath . "project/" . $ttoy . "/" . str_replace(" ", "-", $_REQUEST[project]) . ".html";

                                    $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='post_job_for_employe' AND `langid`='" . $_SESSION['lang_code'] . "'");
                                    if (mysql_num_rows($mailq) == 0) {
                                        $mailq = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='post_job_for_employe' AND `langid`='en'");
                                    }
                                    $mailr = mysql_fetch_assoc($mailq);
                                    $mailbody = html_entity_decode($mailr['body']);

                                    $mailbody = str_replace("{username}", $row_user['username'], $mailbody);
                                    $mailbody = str_replace("{project}", "<a href='" . $purl . "'>" . $_REQUEST[project] . "</a>", $mailbody);
                                    $mailbody = str_replace("{project_url}", $purl, $mailbody);
                                    $mailbody = str_replace("{amount}", $amnt, $mailbody);

                                    $subject = html_entity_decode($mailr['subject']);

                                    $headers = "MIME-Version: 1.0 \r\n";
                                    $headers.="Content-type: text/html; charset=\"UTF-8\" \r\n";
                                    $headers.="From: " . $setting['admin_mail'] . "\r\n";
                                    if ($setting['cc_mail'] != '') {
                                        $headers.="Cc: " . $setting['cc_mail'] . "\r\n";
                                    }

                                    mail($row_user['email'], $subject, $mailbody, $headers);


                                    ////////////////////////////////////////////////// end mail body ///////////////////////////////////////////////	
                                }



                                $project = $stat[project] + 1;

                                mysql_query("update " . $prev . "stat set project=" . $project . "");







                                /////////////////////////////////////////////////////////////////////////////// view messages and tr ////////////////////////////////////////////////////////////////
                                $_SESSION['succ'] = $lang['job_posted_successfully'];
                            }


                            if ($_SESSION['succ'] != "" && $err_msg == "" && $flag > 0) {

                                $_SESSION['succ'].='<br> ' . $lang["The_job_named"] . ' <b>' . $_REQUEST[project] . '</b> ' . $lang["has_been_added_to"] . ' <strong>' . $dotcom . '</strong> ' . $lang["and_can_now_be_viewed_by_all_service_providers"] . '.<br><br>
									<a href="' . $vpath . 'project/' . $ttoy . '/"><font color="#FFF"><b>' . $lang["CLICK_HERE"] . '</b></font></a> ' . $lang["to_view_your_project"] . '.';
                                include("includes/succ.php");

                                //echo"<tr class='link'><td colspan=2 align=center  height=30>" . $msg3 . "</td></tr>";
                                unset($_SESSION['succ']);
                                unset($_SESSION['error']);

                                /*                                 * **********invitaion************* */


                                if ($_POST['invtxtemail'] != '' && $_POST['invtxtemail_post'] == 'inviteuser' && $_POST['txtemail_stat'] == "open") {
                                    $link = $vpath . "project/" . $ttoy;
                                    $to = $_POST['invtxtemail'];

                                    $subj = $lang['PROJ_INV'] . $_REQUEST[project];

                                    $body = $lang[$setting[invitation]] . $lang['PROJ_FOR'] . '<b>' . ucwords($_REQUEST[project]) . '</b>.
	<br>' . $lang['PROJ_LINK'] . '
	<br>' . $link . '
	<br /><br /> ' . $lang['FROM_H'] . ' ' . $row_user['fname'] . ' ' . $row_user['lname'];
                                    $from = getusername($_SESSION['user_id']);
                                    $mail_type = 'invitation';
                                    $r = genMailing($to, $subj, $body, $from, $reply = true, $mail_type, $fname, $lname);
                                }
                                /*                                 * ************************ */
                            } else {
                                $_SESSION['error'].="<br>" . $lang['job_not_posted_successfully'] .
                                        "<br> <a href='postjob.html'><font color='#FFF'><strong>" . $lang['CLICK_HERE'] . "</strong></font> </a>" . $lang['submit_project_again'];
                                include("includes/err.php");
                                unset($_SESSION['succ']);
                                unset($_SESSION['error']);
                            }



                            /////////////////////////////////////////////////////////////////////////////// end view messages and tr ////////////////////////////////////////////////////////////////
                            echo '</div>';
                        } elseif (isset($_REQUEST['editsubmit']) && $_POST[edit] != "" && $_REQUEST['tba1'] != "") {


                            if (count($_REQUEST[attachfile])):
                                $attach = "";
                                for ($i = 0; $i < count($_REQUEST[attachfile]); $i++):
                                    $attach.= $_REQUEST[attachfile][$i] . ",";
                                endfor;

                                $rud = substr($attach, 0, -1);

                            endif;

                            if ($_REQUEST[featured] && $_REQUEST[featured] == "featured"):

                                $tyress = mysql_query("SELECT * FROM " . $prev . "transactions WHERE user_id='" . $_SESSION[user_id] . "' ORDER BY date2 DESC LIMIT 0,1");

                                $bal = mysql_result($tyress, 0, "balance");

                                if ($bal >= $setting[featuredcost]):

                                    $dadj2 = $bal - $setting[featuredcost];

                                    $today = getdate();

                                    $month = $today['mon'];

                                    $day = $today['mday'];

                                    $year = $today['year'];

                                    $hours = $today['hours'];

                                    $minutes = $today['minutes'];

                                    mysql_query("INSERT INTO " . $prev . "transactions (amount, details, user_id, balance, date, date2) VALUES ('-$setting[featuredcost]', 'Featured Project Fee', '" . $_SESSION[user_id] . "', '$dadj2', '" . genDate(time()) . "', '" . time() . "')");

                                endif;

                            endif;

                            $mymess = $setting[emailheader] . '

									----------

									' . $lang['This_is_to_confirm_that_your_new_project'] . ' (' . $_REQUEST[project] . ') ' . $lang['has_been_added_to'] . ' ' . $setting[companyname] . '

									

									' . $lang['postmail3'] . ' ' . $vpath . 'login.html

									----------

									' . $setting[emailfooter];



                            mail($setting[admin_mail], $lang['NEW'] . $setting[companyname] . $lang['PROJECT_NAME'] . ": " . $_REQUEST[project], $mymess, "From:$setting[retemailaddress]");




                            mysql_query("insert into " . $prev . "projects_additional set project_id=\"" . $_REQUEST[edit] . "\",user_id=\"" . $_SESSION[user_id] . "\",date='" . time() . "',info=\"" . $_REQUEST[info] . "\",attached_file=\"" . $rud . "\"");


                            $msg3 = $lang['ADDITIONAL_INFO'] . '<b>' . $_REQUEST[project] . '</b>' . $lang['VIEW_BY_ALL'] . '<br><br> <a href="' . $vpath . 'project/' . $_REQUEST[edit] . '/" class=link><b>' . $lang['CLICK_HERE'] . '</b></a> ' . $lang['VIEW_UR_PROJ'];

                            echo"<tr class='link'><td colspan=2 align=center  height=30>" . $msg3 . "</td></tr>";
                        }

                        elseif ($_REQUEST[edit] != "" && !$_REQUEST['editsubmit']) {

                            $d = mysql_fetch_array(mysql_query("select * from  " . $prev . "projects where id=" . $_REQUEST[edit] . " and user_id=" . $_SESSION[user_id]));
                            ?>
                            <div class="post_left">

                                <div class="post_box">
                                    <?php
                                    if ($_SESSION['succ'] != "") {
                                        include("includes/succ.php");

                                        unset($_SESSION['succ']);
                                        unset($_SESSION['error']);
                                    } elseif ($_SESSION['error'] != "") {

                                        include("includes/err.php");
                                        unset($_SESSION['succ']);
                                        unset($_SESSION['error']);
                                    }
                                    ?>
                                    <h1><?php
                                        if ($_REQUEST[edit]) {
                                            echo $lang['EDIT'];
                                        } else {
                                            echo $lang['POST'];
                                        }
                                        ?> <?= $lang['YOUR_JOB'] ?></h1>
                                    <?php
                                    if ($_REQUEST['msg'] != "") {
                                        echo $_REQUEST['msg'];
                                    }
                                    ?>
                                    <div class="post_form_box">
                                        <div class="post_form">
                                            <p><?= $lang['SUBMISSION2'] ?></p>
                                            <input type="text" name=project value="<?= $d[project] ?>" readonly="readonly" class="from_input_box">
                                            <input type="hidden" name='edit' value='<?= $_REQUEST[edit] ?>'>
                                        </div>

                                        <div class="post_form">
                                            <div class="edit_bott"><a href="javascript:void(0)" onclick="edittext()" >Edit</a></div>
                                            <p><?= $lang['DESCRIBE_YOUR_PROJECT_DETAILS'] ?></p><br  /><br  />
                                            <?php echo nl2br($d[description]); ?><br  /><br  />
                                            <?php
                                            $otherdet = mysql_query("select info from " . $prev . "projects_additional where project_id='" . $_REQUEST[edit] . "'");
                                            $ui = 0;
                                            $uia = 0;
                                            while ($infp = @mysql_fetch_assoc($otherdet)) {
                                                if ($infp[info] != '') {
                                                    $ui++;
                                                    echo $lang['ADDITION'] . $ui . " : " . nl2br($infp[info]) . "<br  /><br  />";
                                                }
                                            }
                                            ?>

                                            <textarea name='info' class="descriptclass text_box"></textarea>
                                        </div>



                                        <?php
                                        $rr = mysql_query("select " . $prev . "categories.* from " . $prev . "categories," . $prev . "projects_cats where " . $prev . "categories.cat_id=" . $prev . "projects_cats.cat_id and " . $prev . "projects_cats.id=" . $_REQUEST[edit]);

                                        $txt = "";

                                        while ($cat = @mysql_fetch_array($rr)):
                                            $txt2.=$cat[cat_name] . " , ";
                                        endwhile;
                                        ?>

                                        <div class="select_category_box">
                                            <p><?= $budget_array[$d[budget_id]]; ?></p>            


                                        </div>

                                        <div class="attach">

                                            <?php
                                            $no_of_att = @explode(",", $d['attachment']);
                                            $x = 1;
                                            if (count($no_of_att) > 0) {
                                                ?>
                                                <div class='news_heading'><?= $lang['Attach'] ?>  :</div>
                                                <div class="box-attachments">
                                                    <?php
                                                    foreach ($no_of_att as $atno) {
                                                        list($nm1, $nm) = explode("-", $atno, 2);
                                                        ?>
                                                        <a href="<?= $vpath . $atno ?>"  target="_blank"><?= ucfirst($nm) ?></a> <br />
                                                        <?php
                                                        $x++;
                                                    }
                                                    ?>
                                                </div></div>
                                            <?php
                                        }
                                        $otherdet1 = mysql_query("select attached_file from " . $prev . "projects_additional where project_id='" . $_REQUEST[edit] . "'");

                                        while ($infp1 = @mysql_fetch_assoc($otherdet1)) {

                                            if ($infp1[attached_file] != '') {
                                                $uia++;
                                                echo "<div class='attach'><div class='news_heading'>" . $lang['Addition_attach'] . $uia . " :</div>";
                                                ?>
                                                <div class="box-attachments">
                                                    <?php
                                                    $no_of_att1 = explode(",", $infp1['attached_file']);
                                                    $x = 1;
                                                    foreach ($no_of_att1 as $atno1) {
                                                        list($nm11, $nm1) = explode("-", $atno1, 2);
                                                        ?>
                                                        <a href="<?= $vpath . $atno1 ?>"  target="_blank"><?= ucfirst($nm1) ?></a> <br />
                                                        <?php
                                                        $x++;
                                                    }
                                                    ?>
                                                </div></div >
                                            <?php
                                        }
                                    }
                                    ?>


                                    <div class="category_form">
                                        <table cellpadding="0" cellspacing="0" border="0">
                                            <tr><td><h1><strong><?= $lang['p_msp1'] ?></strong></h1></td>
                                                <td><select  name='select[]' id="attachfile" size=5 style='width:300px' multiple class="text_box"> </select></td>
                                                <td style="padding-left:10px;"><input type='button' name='Upload2' value="<?= $lang['UPLOAD'] ?>" class="submit_bott" style='width:100px;margin-bottom:10px;'   onClick="javascript:window.open('<?= $vpath ?>pop.upload.php', '_new', 'width=350,height=330,addressbar=no,scrollbars=no');">

                                                    <input type='button' name='Remove2' class="submit_bott" Value='<?= $lang['REMOVE'] ?>' style='width:100px;'  onClick="javascript:Delete();">					                                                  </td>
                                        </table>											
                                    </div>

                                </div>
                            </div>
                            <input type="submit" id="signin" name="signin" class="submit_bott" value="<?= $lang['UPDATE'] ?>" onclick="EditValidate();"  />

                            <div class="post_box">
                                <input type="hidden" name="tba1" id="tba1" value='123a'>

                            </div>
                            </div>
                        <?php } else {
                            ?>
                            <div class="post_left">
                                <div class="post_box">
                                    <h1><?php
                                        if ($_REQUEST[edit]) {
                                            echo $lang['EDIT'];
                                        } else {
                                            echo $lang['POST'];
                                        }
                                        ?> <?= $lang['YOUR_JOB'] ?></h1>

                                    <div class="post_form_box">
                                        <div class="post_form">
                                            <p><?= $lang['SUBMISSION2'] ?></p>
                                            <input type=text name="project" id="project" style='width:98%' class="from_input_box">
                                        </div>

                                        <div class="post_form">
                                            <p><?= $lang['DESCRIBE_YOUR_PROJECT_DETAILS'] ?></p>

                                            <textarea rows="10" name="description" class="text_box"><?= $d[description] ?></textarea>
                                        </div>




                                        <div class="post_form">
                                            <div class="arrangemen_form">
                                                <p><?= $lang['SEL_CAT'] ?></p>
                                                <br />
                                                <select name="category_id" id="category_id" size="1" onchange="getscat(this.value)" class="from_input_box">
                                                    <option value=""><?= $lang['SELECT_CAT'] ?></option>
                                                    <?php
                                                    $r = mysql_query("select cat_name,cat_id from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");
                                                    $j = 0;
                                                    $n = 0;
                                                    while ($d = mysql_fetch_array($r)) {
                                                        if ($_SESSION[lang_id]) {
                                                            $row_content_lang = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id='" . $d['cat_id'] . "' and table_name='categories' and field_name='cat_name' and lang_id='" . $_SESSION[lang_id] . "'"));
                                                            $d['cat_name'] = $row_content_lang['content'];
                                                        }
                                                        ?>
                                                        <option value="<?= $d['cat_id'] ?>"><?= $d['cat_name'] ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>


                                        </div>
                                        <div id="skills" style="float:left;width:100%">
                                            <input type=hidden name="scat_ids" id="scat_ids" class="changebox" value="<?= $in ?>">
                                        </div>		

                                        <div class="category_box_form">

                                            <div class="category_form">
                                                <table cellpadding="0" cellspacing="0" border="0">
                                                    <tr><td width="17" valign="top"><h1><strong><?= $lang['ATTACH'] ?></strong></h1></td>
                                                        <td width="324">

                                                            <select  name='attachfile[]' id="attachfile" size=5 style='width:300px' multiple class="text_box"> </select></td>
                                                        <td width="180" style="padding-left:10px;"><input type='button' name='Upload' class="submit_bott" value='<?= $lang['UPLOAD'] ?>' style='width:100px;margin-bottom:10px;'   onClick="javascript:window.open('<?= $vpath ?>pop.upload.php', '_new', 'width=400,height=300,addressbar=no,scrollbars=no');">

                                                            <input type='button' name='Remove' class="submit_bott" Value='<?= $lang['REMOVE'] ?>' style='width:100px;'  onClick="javascript:Delete();">

                                                            <? if ($_SESSION['invite_email_id_user'] != '' && $_SESSION['invite_inviteuser_id_user'] == 'inviteuser' && $_SESSION['invite_status_id_user'] == "open") { ?>
                                                                <input type='hidden' name='invtxtemail' Value='<?= $_SESSION['invite_email_id_user'] ?>' >
                                                                <input type='hidden' name='invtxtemail_post' Value='<?= $_SESSION['invite_inviteuser_id_user'] ?>' >
                                                                <input type='hidden' name='txtemail_stat' Value='<?= $_SESSION['invite_status_id_user'] ?>' >			                                                 
                                                                <?
                                                                unset($_SESSION['invite_email_id_user']);
                                                                unset($_SESSION['invite_inviteuser_id_user']);
                                                                unset($_SESSION['invite_status_id_user']);
                                                            }
                                                            ?>
                                                            <? if ($_POST['invtxtemail'] != '' && $_POST['invtxtemail_post'] == 'inviteuser' && $_POST['txtemail_stat'] == "open") { ?>
                                                                <input type='hidden' name='invtxtemail' Value='<?= $_POST['invtxtemail'] ?>' >
                                                                <input type='hidden' name='invtxtemail_post' Value='<?= $_POST['invtxtemail_post'] ?>' >
                                                                <input type='hidden' name='txtemail_stat' Value='<?= $_POST['txtemail_stat'] ?>' >															
                                                            <? } ?>
                                                        </td></tr>
                                                </table>											
                                            </div>
                                        </div>

                                        <div class="post_form">  
                                            <p style="width:100%"><?= $lang['PROJECT_TYPE'] ?></p>
                                            <br />
                                            <select name="project_type" id="project_type" size="1" class="from_input_box" onchange="project_type_box(this.value)">
                                                <option value="F"><?= $lang['FIXED'] ?></option>
                                                <option value="H"><?= $lang['HOURLY'] ?></option>
                                            </select>
                                        </div>

                                        <div class="post_form fixed">  


                                            <div style="clear:both;width:100%"></div>
                                            <p style="width:100%"><?= $lang['BUDGET'] ?></p>
                                            <br />
                                            <select name="budget_id" size="1" class="from_input_box ">
                                                <option selected value="">--- <?= $lang['BUDGET_SL1'] ?> ---</option>
                                                <option value="1" <?
                                                if ($d[budget_id] == 1) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL2'] ?></option>
                                                <option value="2" <?
                                                if ($d[budget_id] == 2) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL3'] ?></option>
                                                <option value="3" <?
                                                if ($d[budget_id] == 3) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL4'] ?></option>
                                                <option value="4" <?
                                                if ($d[budget_id] == 4) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL5'] ?></option>
                                                <option value="5" <?
                                                if ($d[budget_id] == 5) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL6'] ?></option>
                                                <option value="6" <?
                                                if ($d[budget_id] == 6) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL7'] ?></option>
                                                <option value="7" <?
                                                if ($d[budget_id] == 7) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL8'] ?></option>
                                                <option value="8" <?
                                                if ($d[budget_id] == 8) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL9'] ?></option>
                                                <option value="9" <?
                                                if ($d[budget_id] == 9) {
                                                    echo "selected";
                                                }
                                                ?>><?= $lang['BUDGET_SL10'] ?></option>
                                            </select>
                                        </div>

                                        <div class="post_form hourly" style="display:none;"> 
                                            <div style="clear:both;width:100%"></div>
                                            <p style="width:100%"><?= $lang['AVS_HOURLY_RATE'] ?></p>
                                            <br /> 
                                            <div class="doller clearfix "  style="display: block;">
                                                <label style="width:auto;padding-top: 8px;"> <?= $lang['MIN'] ?> <?= $curn ?> </label>
                                                <input class="mini-inp" type="text" name="budget_min" value="0">
                                                <label style="width:auto;padding-top: 8px;">  <?= $lang['MAX'] ?> <?= $curn ?> </label>
                                                <input class="mini-inp" type="text" name="budget_max" value="0">

                                            </div>

                                                                                                                                        <!--<p style="width:100%;"><input type="checkbox" id="agree" name="agree" value="Y" size="5" style="width:12px; " /> <?= $lang['AGREE_TERMS_CONDITION2'] ?> <a href="<?= $vpath ?>terms.html" target="_blank" class="button-small"><?= $lang['AGREE_TERMS_CONDITION3'] ?></a> <?= $lang['AND'] ?> <a href="<?= $vpath ?>privacy.html" target="_blank" class="button-small"><?= $lang['PRIVACY_POLICY'] ?></a></p>-->


                                        </div>
                                    </div>
                                </div>

                                <div class="post_box">
                                    <h1><?= $lang['PRMT_LSTNG'] ?>:</h1>
                                    <div class="post_form_box">
                                        <div class="arrangemen_form" style="width:666px;">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="option">

                                                <tbody><tr><td colspan="5">
                                                        </td></tr>

                                                    <tr>
                                                        <td align="center" >

                                                            <INPUT type="checkbox" name="featured" id="featured" value="featured" <?
                                                            if ($d[featured]) {
                                                                echo" checked";
                                                            }
                                                            ?> onclick="getfeature(this.id)" />
                                                        </td>
                                                        <td align="center"><img src="<?= $vpath ?>/images/<?= $ln ?>/fratured.jpg" alt="fratured"></td>
                                                        <td align="left"><p><?= $lang['FEATURED_PROJ'] ?></p></td>
                                                        <td style="width:100px;"><p><b><? echo $curn . " " . $setting[featuredcost]; ?> </b></p></td>
                                                        <td></td>
                                                    </tr>




<!--

                                                    <tr><td></td><td colspan="4">
                                                            <hr>                </td></tr>

                                                    <tr >
                                                        <td align="left" colspan=4 i><p style="float:left;margin-left: 0px;"><input name="sealed" value="sealed" type="checkbox" class="sfeature" disabled></p>

                                                            <img src="<?= $vpath ?>/images/<?= $ln ?>/sealed.jpg" alt="sealed" style="float:left">

                                                            <p style="float:left;"><input name="urgent" value="urgent" type="checkbox" class="sfeature" disabled></p>


                                                            <img src="<?= $vpath ?>/images/<?= $ln ?>/urgent.jpg" alt="urgent" style="float:left">
                                                            <p style="float:left;"><input name="privacy" value="privacy" type="checkbox" class="sfeature" disabled></p>


                                                            <img src="<?= $vpath ?>/images/<?= $ln ?>/privacy.jpg" alt="privacy" style="float:left">
                                                        </td>
                                                        <td></td>
                                                    </tr>

-->

                                                </tbody></table>
                                        </div>

                                    </div>
                                </div>


                                <div class="post_box">
                                    <? if (!$msg3) { ?>


                                        <input type="submit" name="submit" value='<?= $lang['SUBMIT'] ?>' class="submit_bott">


                                    </div>
                                </div>

                                <?
                            }
                        }
                        ?>



                    </form>
                    <!--Post Left End-->
                    <!--Post Right-->
                    <div class="post_right">

                    </div>
            </div>
        </div></div>
</div>
<!--Post Right End-->
</div>
<style>
    #fetaturesection,.descriptclass{
        display:none;
    }
    .attach{
        width: 100%;
        float: left;
        padding-left: 20px;
    }
    .news_heading{
        border: none;
        padding: 5px;
    }
</style>
<!-- <div style="clear:both; height:10px;"></div>-->
<?php include 'includes/footer.php'; ?>
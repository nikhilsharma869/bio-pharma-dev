<?php
$current_page = "<p>Portfolio</p>";
include "includes/header.php";
CheckLogin();
?>
<?php
$rand = rand(1111111, 9999999);
if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_SESSION['usre_id'];
}
if (empty($user_id)) {
    header("Location: " . $vpath . "login.php");
    exit();
}
$count = mysql_num_rows(mysql_query("select * from " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " order by add_date desc"));

if ($_REQUEST['SBMT']):
    if ($_REQUEST['ed']) {
        $flag = FALSE;
        $prtq = mysql_fetch_assoc(mysql_query("SELECT `status` FROM `" . $prev . "portfolio` WHERE `id`='" . $_REQUEST['EDIT'] . "'"));

        $planqrry = mysql_query("SELECT `portfolio` FROM `" . $prev . "usermembership` WHERE `user_id`='" . $_SESSION[user_id] . "'");
        $planrow = mysql_fetch_assoc($planqrry);
        $portqrry = mysql_query("SELECT COUNT(id) AS tpl FROM `" . $prev . "portfolio` WHERE `user_id`='" .  $_SESSION[user_id]  . "' AND `status`='Y'");
        $portrow = mysql_fetch_assoc($portqrry);
       $prevprot = (int) $portrow['tpl'];
        if (($_POST['status'] == 'Y' && $prtq['status']=='Y') || $_POST['status'] == 'N') {
            $prevprot = $prevprot - 1;
        }
        if ((int) $planrow['portfolio'] > $prevprot) {
            $flag = TRUE;
        }
        if ($flag) {
            $q = "update " . $prev . "portfolio set project_title='" . $_REQUEST['project_title'] . "', description='" . $_REQUEST['description'] . "',link='" . $_POST['link'] . "',tags='" . $_POST['tags'] . "', `status`='".$_POST['status']."' where  id=" . $_REQUEST['EDIT'];
            mysql_query($q);
            if ($q) {
                if ($_FILES['thumb']['name']) {
                    list($image_ex, $ext) = explode('.', $_FILES['thumb']['name']);
                    $rand = rand(1111111, 9999999);
                    $file = "portfolio/" . $rand . time() . "." . $ext;
                    copy($_FILES['thumb']['tmp_name'], $file);
                    $r = mysql_query("update " . $prev . "portfolio set image=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");
                }

                if ($_FILES['thumb1']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb1']['name']);
                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    copy($_FILES['thumb1']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image1=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

                endif;


                if ($_FILES['thumb2']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb2']['name']);

                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    copy($_FILES['thumb2']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image2=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

                endif;

                if ($_FILES['thumb3']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb3']['name']);

                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    copy($_FILES['thumb3']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image3=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

                endif;


                if ($_FILES['thumb4']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb4']['name']);

                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    copy($_FILES['thumb4']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image4=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

                endif;
                $_SESSION['succ'] = $lang['PORTFOLIO_UPDATED'];
            }
        }else {
            $_SESSION['error'] .= "Limit Over";
        }
    }
endif;

if ($_REQUEST['EDIT']) {
    $e1 = mysql_query("select * from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['EDIT']);
    $data1 = @mysql_fetch_array($e1);
    $project_title = $data1['project_title'];
    $description = $data1['description'];
} elseif ($_REQUEST['DELT']) {
    $e = mysql_query("delete from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['DELT']);
}


$e = mysql_query("select * from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['EDIT']);
$data = @mysql_fetch_array($e);
$date_up = explode('-', $data[add_date]);
$date = $date_up[2] . '-' . $date_up[1] . '-' . $date_up[0];
?>


<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>">Home</a> | <a href="<?= $vpath ?>userportfolio.html">Portfolio</a> | <a href="javascript:void(0);" class="selected">Edit Portfolio</a></p></div>
    <div class="clear"></div>
    <!--Profile-->
    <?php include 'includes/leftpanel1.php'; ?>
    <!-- left side-->
    <!--middle -->
    <?php
    $r = mysql_query("SELECT * FROM " . $prev . "user where status='Y' and (user_id='" . $user_id . "')");
    $d = @mysql_fetch_array($r);
    if (empty($d['user_id'])) {
        header("Location: " . $vpath);
        exit();
    }
    $user_id = $d['user_id'];


    if ($d['gold_member'] == 'Y') {
        $mem = mysql_query("select * from " . $prev . "membership where id=2");
        $rowmem = mysql_fetch_array($mem);
    } else {
        $mem = mysql_query("select * from " . $prev . "membership where id=1");
        $rowmem = mysql_fetch_array($mem);
    }

    $pcount = $rowmem['portfolio'] - $count;
    ?>
    <div class="profile_right">
        <ul class="tabs">
            <li><a href="javascript:void(0)" class="selected">Edit Portfolio</a></li>
        </ul>

        <div class="newclassborder">
            <div align="center" ><?php
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
                ?></div>
            <form action="" method="post" enctype="multipart/form-data" name="exp_form" id="exp_form">
                <input type="hidden" name="ed" id="ed" value="1"/>
                <div class="latest_worbox">
                    <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="edit_tab">
                        <tr>
                            <td width="41%" height="12"></td>
                            <td width="59%" align="right"><span style=" font-size:12px;" class="style1"></span></td>
                        </tr>
                        <tr>
                            <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td width="15"></td>
                                        <td width="287"><img src="<?= $vpath ?>viewimage.php?img=<?= $data[image]; ?>&width=287&height=240"  /></td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="color: #999999; font-size:11px; text-align:center;">  <?= $lang['UPDATED_ON'] ?>  <?= $date; ?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table></td>
                            <td align="right" valign="top"><table width="97%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="22">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td align="left">Title<span class="style1"></span><br />

                                            <input class="edit_input" name="project_title" type="text"  value="<?= $data[project_title] ?>" /><br />
                                            <p>Create a descriptive title. Get found in search results.</p></td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Caption/Description<br />
                                            <textarea class="edit_input" name="description" cols="" rows="" ><?= $data[description] ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Tags<br />

                                            <input class="edit_input" name="tags" type="text" value="<?= $data['tags'] ?>" /></td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Web Address (URL)<br />

                                            <input class="edit_input" name="link" type="text"  value="<?= $data['link'] ?>" /><br />
                                            <p>URL associated with this work sample.<br /> 
                                                Do not enter your personal or company website here. See Site <a href="<?= $vpath ?>privacy.html" target="_blank">Usage Policy</a></p></td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                    </tr>
                                    <tr >
                                        <td align="left"><?= $lang['PICTURES_EXAMPLES'] ?> <br />
                                            <input type="file" name="thumb"  size="30" class="from_input_box" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                    </tr>
                                    <tr >
                                        <td align="left"><?= $lang['STATUS'] ?> <br />
                                            <input type="radio" name="status"  value="Y"<?php
                                            if ($data['status'] == 'Y') {
                                                echo ' checked="checked"';
                                            }
                                            ?> />&nbsp;Active&nbsp;&nbsp;&nbsp;
                                            <input type="radio" name="status"  value="N"<?php
                                            if ($data['status'] == 'N') {
                                                echo ' checked="checked"';
                                            }
                                            ?> />&nbsp;Inactive
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="12"></td>
                                    </tr>
                                    <tr>
                                        <td><input type="submit" class="savebnt" value="Save Changes" name="SBMT"  style="padding: 6px 9px;"/>
                                            <a href="<?= $vpath ?>userportfolio.html" class="cancbnt" style="text-decoration: none;">Cancel</a>
                                            <a href="<?= $vpath ?>userportfolio.php?DELT=<?= $_REQUEST['EDIT'] ?>&delete=1" class="deletbnt" style="text-decoration: none;">Delete File</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table></td>
                        </tr>
                        <tr>
                            <td height="12"></td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>

                </div>
            </form>
        </div>
    </div>
    <!--Dashboard Right End-->


</div> 

<?php include 'includes/footer.php'; ?>
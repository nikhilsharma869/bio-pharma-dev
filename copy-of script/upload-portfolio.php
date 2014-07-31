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
$count = mysql_num_rows(mysql_query("select * from " . $prev . "portfolio where user_id='" . $_SESSION[user_id] . "' AND `status`='Y'"));

if ($_REQUEST['SBMT']):
    if ($_REQUEST['ed']) {
        $q = "update " . $prev . "portfolio set project_title='" . $_REQUEST['project_title'] . "', description='" . $_REQUEST['description'] . "',link='" . $_POST['link'] . "',tags='" . $_POST['tags'] . "' where  id=" . $_REQUEST['EDIT'];
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

            //$msg="<h3 >Portfolio details has been updated.</h3>";	

            endif;


            if ($_FILES['thumb2']['name']):
                list($image_ex, $ext) = explode('.', $_FILES['thumb2']['name']);

                $rand = rand(1111111, 9999999);

                $file = "portfolio/" . $rand . time() . "." . $ext;

                copy($_FILES['thumb2']['tmp_name'], $file);

                $r = mysql_query("update " . $prev . "portfolio set image2=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

            //$msg="<h3 >Portfolio details has been updated.</h3>";	

            endif;

            if ($_FILES['thumb3']['name']):
                list($image_ex, $ext) = explode('.', $_FILES['thumb3']['name']);

                $rand = rand(1111111, 9999999);

                $file = "portfolio/" . $rand . time() . "." . $ext;

                copy($_FILES['thumb3']['tmp_name'], $file);

                $r = mysql_query("update " . $prev . "portfolio set image3=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

            //$msg="<h3 >Portfolio details has been updated.</h3>";	

            endif;


            if ($_FILES['thumb4']['name']):
                list($image_ex, $ext) = explode('.', $_FILES['thumb4']['name']);

                $rand = rand(1111111, 9999999);

                $file = "portfolio/" . $rand . time() . "." . $ext;

                copy($_FILES['thumb4']['tmp_name'], $file);

                $r = mysql_query("update " . $prev . "portfolio set image4=\"" . $file . "\" where id=\"" . $_REQUEST['EDIT'] . "\"");

            //$msg="<h3 >Portfolio details has been updated.</h3>";	

            endif;

            //$msg="<h3 >Portfolio details has been updated.</h3>";
            $_SESSION['succ'] = $lang['PORTFOLIO_UPDATED'];
        }
    }

    else {

        if (canHeDo($_SESSION['user_id'], 'portfolio')):

            $r = mysql_query("insert into " . $prev . "portfolio set user_id=" . $_SESSION[user_id] . ",project_title=\"" . $_REQUEST['project_title'] . "\",link='" . $_POST['link'] . "',tags='" . $_POST['tags'] . "',description=\"" . $_REQUEST['description'] . "\",add_date=NOW()");

            if ($r):
                $id = mysql_insert_id();
                if ($_FILES['thumb']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb']['name']);
                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    move_uploaded_file($_FILES['thumb']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image=\"" . $file . "\" where id=\"" . $id . "\"");

                endif;



                if ($_FILES['thumb1']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb1']['name']);
                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    move_uploaded_file($_FILES['thumb1']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image1=\"" . $file . "\" where id=\"" . $id . "\"");

                //$msg="<h3 >Portfolio details has been updated.</h3>";	

                endif;


                if ($_FILES['thumb2']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb2']['name']);
                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    move_uploaded_file($_FILES['thumb2']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image2=\"" . $file . "\" where id=\"" . $id . "\"");

                //$msg="<h3 >Portfolio details has been updated.</h3>";	

                endif;



                if ($_FILES['thumb3']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb3']['name']);
                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    move_uploaded_file($_FILES['thumb3']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image3=\"" . $file . "\" where id=\"" . $id . "\"");

                //$msg="<h3 >Portfolio details has been updated.</h3>";	

                endif;


                if ($_FILES['thumb4']['name']):
                    list($image_ex, $ext) = explode('.', $_FILES['thumb4']['name']);
                    $rand = rand(1111111, 9999999);

                    $file = "portfolio/" . $rand . time() . "." . $ext;

                    move_uploaded_file($_FILES['thumb4']['tmp_name'], $file);

                    $r = mysql_query("update " . $prev . "portfolio set image4=\"" . $file . "\" where id=\"" . $id . "\"");

                //$msg="<h3 >Portfolio details has been updated.</h3>";	

                endif;
                $_SESSION['succ'] = $lang['PORTFOLIO_UPDATED'];

            else:
                // $msg="<h3 ><font color=red><img src='images/error.png' align=absmiddle hspace=5>Duplicate title not allowed.</font></h3>";
                $_SESSION['error'].=$lang['DUPLICATE_TITLE'];

            endif;
        else:
            $_SESSION['error'].="Limit Over ";
        endif;
    }
endif;

if ($_REQUEST['EDIT']) {
    $e1 = mysql_query("select * from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['EDIT']);
    $data1 = @mysql_fetch_array($e1);
    $project_title = $data1['project_title'];
    $description = $data1['description'];

    echo '<script language="javascript" type="text/javascript">';
    echo "document.exp_form.ed.value='1'";
    echo "</script>";
} elseif ($_REQUEST['DELT']) {
    $e = mysql_query("delete from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['DELT']);
}


$e = mysql_query("select * from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id]);
$data = @mysql_fetch_array($e);
?>

<script type="text/javascript" src="<?= $vpath ?>js/gen_validatorv4.js"></script>
<script>
    function valueEdit()
    {
        document.exp_form.ed.value = 1;
    }
</script>

<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>">Home</a> | <a href="<?= $vpath ?>userportfolio.html">Portfolio</a> | <a href="javascript:void(0);" class="selected">Add New Portfolio</a></p></div>
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

    $mem = mysql_query("select `portfolio` from " . $prev . "usermembership where `user_id`='" . $_SESSION['user_id'] . "'");
    $rowmem = mysql_fetch_array($mem);

    $pcount = (int) $rowmem['portfolio'] - (int) $count;
    ?>
    <div class="profile_right">


        <ul class="tabs">
            <li><a href="javascript:void(0)" class="selected">Add New Portfolio</a></li>
        </ul>

        <div class="newclassborder">

            <div class="create_profile2">

                <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" class="table_class">
                    <tr>
                        <td height="10px;"></td>
                    </tr>
                    <!------------------------------------------------Middle Body-------------------------------------------------------------->
                    <tr>
                        <td>

                            <form action="<?= $vpath ?>upload-portfolio.html" method="post" enctype="multipart/form-data" name="exp_form" id="exp_form">
                                <table width="90%" align="center" border="0" cellspacing="0" cellpadding="0" >



                                    <tr>
                                        <td align="center" valign="top" class="bx-border"><input type="hidden" value="<?= $_REQUEST['ed'] ?>" name="ed"/>
                                            <input type="hidden" value="<?= $_REQUEST['EDIT'] ?>" name="EDIT"/>
                                            <table width="100%" border="0" cellpadding="4" cellspacing="0" align="center" >


                                                <tr style="background-color:#76A000;">
                                                    <td valign='top' class='link' colspan="2" align="center"><font color="#FFFFFF"><strong><?= $lang['YOU_CAN_UPLOAD_MAXIMUM'] ?> <?= $pcount; ?> <?= $lang['YOUR_BEST_WORK'] ?></strong></font></td>
                                                </tr>

                                                <tr >
                                                    <td valign='top' class='link' colspan="2">&nbsp;</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2" align="center" >
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
                                                    </td>
                                                </tr>

                                                <tr class='link'>
                                                    <td ><?= $lang['PROJECT_TITLE'] ?> : *</td>
                                                    <td><input type="text" name="project_title" style='width:300px' value="" size="100" class="from_input_box" /></td>
                                                </tr>
                                                <tr class='link'>
                                                    <td ><?= $lang['DESCRIBING_SHORT'] ?> : *</td>
                                                    <td><textarea name="description" rows="5" cols="10" class="text_box"></textarea>
                                                        <br />
                                                        <div style="
                                                             float: left;
                                                             width: 200px;
                                                             "> <small><?= $lang['NOT_MORE_THAN'] ?></small></div></td>
                                                </tr>
                                                <tr class='link'>
                                                    <td >Tags: </td>
                                                    <td><input type="text" name="tags" style='width:300px' value="" size="100" class="from_input_box" /></td>
                                                </tr>
                                                <tr class='link'>
                                                    <td >Link: </td>
                                                    <td><input type="text" name="link" style='width:300px' value="" size="100" class="from_input_box" /></td>
                                                </tr>
                                                <tr class='link'>
                                                    <td ><?= $lang['PICTURES_EXAMPLES'] ?> : </td>
                                                    <td><input type="file" name="thumb"  size="30" class="from_input_box" />
                                                    </td>
                                                </tr>



                                                <tr class='link'>
                                                    <td ></td>
                                                    <td><input name="submit" type="submit"  class="submit_bott" value="<?= $lang['UPDATE'] ?>">
                                                        <!--<input name="image" type="image" src="images/update.jpg"   />-->
                                                        <input type="hidden" name='SBMT'  value='Submit' /></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                </table>
                            </form>




                        </td>
                    </tr>
                    <!------------------------------------------------Middle Body End---------------------------------------------------------->
                </table>
            </div></div>
        <!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->
    </div>
</div>
<!--end content-->
</div>
</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>
</body>

</html>
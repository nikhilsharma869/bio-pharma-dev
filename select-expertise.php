<?php
$current_page = "Expertise";
include "includes/header.php";
CheckLogin();
?>

<?php
if ($_SESSION['user_id']) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_SESSION['usre_id'];
}

if (empty($user_id)) {
    header("Location: " . $vpath . "login.php");
    exit();
}

if ($_REQUEST['SBMT'] == 'Submit') {
    $k = 0;
    if (sizeof($_POST['cat_ids']) > 0) {
	
        if (canHeDo($_SESSION['user_id'],'skill',sizeof($_POST['cat_ids']))) {
          
            mysql_query("delete from  " . $prev . "user_cats where user_id=" . $_SESSION[user_id]);
            foreach ($_POST['cat_ids'] as $value) {
                $arr = explode(',', $value);
                mysql_query("insert into " . $prev . "user_cats set user_id=" . $_SESSION[user_id] . ",cat_id=" . $arr[0] . ",parent_cat_id=" . $arr[1]);
                $k++;
            }
        } else {
            $_SESSION['error'] = "Limit Over ";
        }
    }
    if ($k) {
        $_SESSION['succ'] = $lang['EXPERT_AREA'];
    } else {
        $_SESSION['error'].=$lang['EXPERT_AREA_NOTUPD'];
    }
}

$e = mysql_query("select * from  " . $prev . "user_cats where user_id=" . $_SESSION[user_id]);
$cnt_cat = @mysql_num_rows($e);
$usercats = array();
while ($dd = @mysql_fetch_array($e)) {
    $usercats[] = $dd[cat_id];
}

$e = mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]);
$d = @mysql_fetch_array($e);

$skill = $rowmem['skills'];
?>


<script>

    jQuery(document).ready(function() {
        var count =<?php echo $cnt_cat; ?>;
        var limit =<?php echo $skill; ?>;
        jQuery(".chkcbox").click(function() {
            if (this.checked)
            {
                if (count < limit)
                {
                    count++;
                }
                else
                {
                    alert("<?= $lang['PLAN_MSG'] ?>");
                    return false;
                }
            }
            else
            {
                count--;
            }

        });
    });
</script>
<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['CATEGORIES'] ?></a></p></div>
    <div class="clear"></div>
    <?php include 'includes/leftpanel1.php'; ?>

    <div class="profile_right">

        <ul class="tabs">
            <li><a href="javascript:void(0)" class="selected"><?= $lang['SELECT_SKILLS'] ?></a></li>
        </ul>

        <div class="newclassborder">
            <div class="create_profile2">
                <!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->
                <table cellpadding="0" cellspacing="0" border="0" width="100%" align="center" class="table_class">
                    <tr>
                        <td height="10px;"></td>
                    </tr>
                    <tr>
                        <td>

                            <form action="" method="post" name="exp_form" id="exp_form">
                                <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td align="left" valign="top"></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="bx-border">
                                            <table width="100%" border="0" cellpadding="10" cellspacing="0" align="center">
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


                                                <tr class='link'>
                                                    <td colspan='2'><?
                                                        $r = mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");

                                                        $j = 0;
                                                        $n = 0;


                                                        while ($da = mysql_fetch_array($r)) {

                                                            if (!$j) {
                                                                $cls = "expanded";
                                                            } else {
                                                                $cls = "trigger";
                                                            }

                                                            $catnm = $da['cat_name'];
                                                            if ($_SESSION[lang_id]) {
                                                                $row_content_lang1 = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id='" . $da['cat_id'] . "' and table_name='categories' and field_name='cat_name' and lang_id='" . $_SESSION[lang_id] . "'"));
                                                                $da['cat_name'] = $row_content_lang1['content'];
                                                            }
                                                            ?>
                                                            <h3 style="padding:10px;"><?php echo $da[cat_name]; ?></h3>
                                                            <div style="width:100%;" id="content">
                                                                <table border="0" cellpadding="2" cellspacing="0" align="center" width="100%">
                                                                    <tr class="link">
                                                                        <?php
                                                                        $rr = mysql_query("select * from " . $prev . "categories where parent_id=" . $da[cat_id] . " and status='Y' order by cat_name");
                                                                        $i = 1;
                                                                        while ($row = mysql_fetch_array($rr)) {
                                                                            if (@in_array($row[cat_id], $usercats)) {
                                                                                $chk = "checked";
                                                                            } else {
                                                                                $chk = " ";
                                                                            }
                                                                            $catnm = $row['cat_name'];
                                                                            if ($_SESSION[lang_id]) {
                                                                                $row_content_lang = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where content_field_id='" . $row['cat_id'] . "' and table_name='categories' and field_name='cat_name' and lang_id='" . $_SESSION[lang_id] . "'"));
                                                                                $row['cat_name'] = $row_content_lang['content'];
                                                                            }
                                                                            ?>
                                                                            <td width="50%" style="font-size:11;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                                                <input type="checkbox" class="chkcbox" <?= $chk ?>  name="cat_ids[]" value="<?= $row[cat_id] . ',' . $da[cat_id]; ?>" />
                                                                                <?= $row['cat_name']; ?></td>
                                                                            <?
                                                                            if ($i == 2) {
                                                                                ?>
                                                                            </tr>
                                                                            <tr class="link">
                                                                                <?php
                                                                                $i = 0;
                                                                            }
                                                                            $i++;
                                                                            $n++;
                                                                        }
                                                                        ?>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                            <?php
                                                            $j++;
                                                        }
                                                        ?>
                                                        <input type="hidden" name="num" value="<?= $n ?>" />
                                                    </td>
                                                </tr>


                                                <input type="hidden" name='SBMT' value='Submit' />
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top" class="inner_bx-bottom"><table align="center" width="95%" cellpadding="0" cellspacing="0">
                                                <tr class="lnk">
                                                    <td align="center"><input type="submit" name="update"  class="submit_bott" value="<?= $lang['UPDATE'] ?>"  />
                                                        <input type="hidden" name="hiddProfileSubmit" value="1" />                          </td>
                                                </tr>
                                            </table></td>
                                        <td valign="top" align="left"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="height:50px;"></td>
                                    </tr>
                                </table>
                            </form>
                            <!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->
                        </td>
                    </tr>
                </table>
            </div>  </div>
    </div>
</div>
<div style="clear:both; height:10px;"></div>
<script type="text/javascript">
    $(".edit").hide();
    $("#updatep").click(function() {
        $(".info").hide();
        $(".edit").show();
        $("#updatep").addClass("selected");
    });
<?php if (!$emailerror && !$fnameerror && !$lnameerror && $r2) { ?>
        $(".info").hide();
        $(".edit").show();
        $("#updatep").addClass("selected");
<?php } ?>
</script>
<?php include 'includes/footer.php'; ?>
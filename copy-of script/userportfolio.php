<?php
$current_page = "Profile details";
include "includes/header.php";
include("country.php");
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
if ($_REQUEST['DELT']) {
    $e = mysql_query("delete from  " . $prev . "portfolio where user_id=" . $_SESSION[user_id] . " and id=" . $_REQUEST['DELT']);
    header("location:" . $vpath . "userportfolio.html");
}
$rrcount = @mysql_num_rows(mysql_query("select id  from " . $prev . "portfolio where user_id=" . $_SESSION['user_id'] . " order by id desc "));
?>


<?php /* ?><script type="text/javascript" src="<?=$vpath;?>js/jquery_tab.js" ></script><?php */ ?>


<!-----------Header End----------------------------->
<div class="inner-middle">
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0)" class="selected"><?= $lang['PRTFLO'] ?> </a></p></div>
    <div class="clear"></div>
    <!--Profile Left Start-->
    <?php include 'includes/leftpanel1.php'; ?>
    <!--Profile Left End-->
    <!--Profile Right Start-->
    <div class="profile_right">
        <div class="editport_text">
            <h1><?= $lang['ALL_ITEMS'] ?> (<?= $rrcount ?>)</h1>
            <div class="upload_bott"><a href="<?= $vpath ?>upload-portfolio.html">+&nbsp;<?= $lang['UPLOAD_NEW'] ?></a></div>
        </div>

        <div class="latest_worbox">
            <table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="edit_tab">
                <tr>
                    <td width="41%" height="12"></td>
                </tr>
                <tr>
                    <td height="12"><!--<div class="select_bott"><a href="#">Select&nbsp;All</a></div>--></td>
                </tr>
                <tr>
                    <td height="12"></td>
                </tr>
                <?php
                $rr = mysql_query("select *  from " . $prev . "portfolio where user_id=" . $_SESSION['user_id'] . " order by id desc limit 20");
                $pro = mysql_num_rows($rr);
                if ($pro == "") {
                    echo '<div style="width:736px;padding:5px;float:left;"  align="center">';
                    echo $lang['PORTF_NOT_UPD'];
                    echo '</div>';
                } else {
                    $j = 0;
                    while ($f = mysql_fetch_array($rr)) {
                        $j++;
                        $date_up = explode('-', $f[add_date]);
                        $date = $date_up[2] . '-' . $date_up[1] . '-' . $date_up[0];
                        ?>	
                        <tr>
                            <td><table align="left" width="100%" border="0" cellspacing="0" cellpadding="0" class="edit_tab" style="border-bottom: #CCCCCC 1px dotted; padding-bottom:12px;">
                                    <tr>
                                      <td width="5%" align="left" valign="top"><!--<input name="" type="checkbox" value="" />--></td>
                                        <td width="11%" align="left" valign="top"><img src="<?= $vpath ?>viewimage.php?img=<?= $f[image]; ?>&width=71&height=60" /></td>
                                        <td width="65%" align="left" valign="top"><p><span><?= $f[project_title]; ?></span><br />        
                                                <?= $lang['UPDATED_ON'] ?>  <?= $date; ?></p><br /><br />

                                            <h1>  <?= $lang['TAGS'] ?>: <span><?= $f[tags]; ?></span></h1>                  </td>
                                        <td width="10%" align="center" valign="top">
                                        <?php
                                        if($f['status']=='Y'){
                                            echo '<span style="color:green;">Active</span>';
                                        }else{
                                            echo '<span style="color:red;">Inactive</span>';
                                        }
                                        ?>
                                        </td>
                                        <td width="3%" align="left" valign="top"><a href="<?= $vpath ?>edit-portfolio/1/<?= $f['id'] ?>/"><img src="<?= $vpath ?>images/edit_icon.jpg" width="16" height="18" /></a></td>
                                        <td width="6%" align="left" valign="top"><a href="<?= $vpath ?>userportfolio.php?DELT=<?= $f['id'] ?>&delete=1"><img src="<?= $vpath ?>images/delet_icon.jpg" width="16" height="18" /></a></td>
                                    </tr>
                                </table></td>
                        </tr>

                        <tr>
                            <td height="22"></td>
                        </tr>
                        <?
                    }
                }
                ?>

                <td height="22"></td>
                </tr>
            </table>

        </div>


    </div>
    <!--Dashboard Right End-->



</div>
<!--Dashboard Right End-->
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php'; ?>

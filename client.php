<?php
$current_page = "Profile details";
include "includes/header.php";
include("country.php");
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
if (!empty($row_user[logo])) {
    $temp_logo = $row_user[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}
?>


<?php /* ?><script type="text/javascript" src="<?=$vpath;?>js/jquery_tab.js" ></script><?php */ ?>


<!-----------Header End----------------------------->
<div style="width:100%; float:left; background:#FFF;">
    <div class="main_div2">
        <div class="inner-middle">
            <div class="dash_headding">
                <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="javascript:void(0)" class="selected"><?= $lang['CLIENT_PROFILE'] ?></a></p></div>
            <div class="clear"></div>
            <!--Profile Left Start-->
<?php include 'includes/leftpanel1.php'; ?>
            <!--Profile Left End-->
            <!--Profile Right Start-->
            <!--Dashboard Right Start-->
            <div class="profile_right">


                <div class="myproheading"><h3><img src="images/cl.png" align="left" style=" margin-top:-5px; margin-right:8px;" /><?= $lang['MY_CLIENT_PROF'] ?></h3></div>

                <div class="myproblock">
                    <div class="myproblockleft">
                        <div class="myproblockleft">
                            <div class="myproimg"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=120&height=120" alt="" /></div>
                            <div class="myprotext">
                                <table width="310" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td height="25" align="left" valign="middle"><?= $lang['USRNM'] ?>: <span><?= $row_user[username] ?></span><?= getrating($row_user[user_id]) ?></td>
                                    </tr>
                                    <tr>
                                        <td height="25" align="left" valign="middle"  style="padding-left:10px;"><?= ucfirst($row_user[slogan]) ?></td>
                                    </tr>

                                </table>

                            </div>
                        </div>
                        <div class="myproheading" style="margin-top:20px;"><h3><img src="images/about.png" align="left" style="margin-right:8px;" /><?= $lang['ABOUT_US'] ?></h3><a href="<?= $vpath ?>client_edit.html" class="myedit"><?= $lang['EDIT'] ?></a></div>

                        <div class="myproblock">
                           <?= nl2br(html_entity_decode($row_user['about_us'])) ?>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </div></div>
<!--Dashboard Right End-->
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php'; ?>

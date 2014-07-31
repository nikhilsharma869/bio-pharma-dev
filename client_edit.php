<?php
$current_page = "My Profile";

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





if (isset($_POST['update'])) {

    $r = "UPDATE " . $prev . "user SET 
	  	about_us = '" . htmlentities($_POST['about_us']) . "' where user_id='" . $_SESSION['user_id'] . "'";

    $query = mysql_query($r);
}

$row_user = mysql_fetch_array(mysql_query("select about_us from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
?>













<!-----------Header End-----------------------------> 



<!-- content-->
<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="<?= $vpath ?>client.html"><?= $lang['CLIENT_PROFILE'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['EDIT_CLIENT'] ?></a></p></div>
    <div class="clear"></div>

    <!--Profile-->

    <?php include 'includes/leftpanel1.php'; ?> 

    <!-- left side-->

    <!--middle -->



    <div class="profile_right">



        <ul class="tabs">
            <li><a href="javascript:void(0)" class="selected"><?= $lang['EDIT_ABOUT_US'] ?></a></li>
        </ul>

        <div class="newclassborder">

            <div class="create_profile2">









                <form  method="post" name="_profile" id="_profile" enctype="multipart/form-data">

                    <table width="97%" border="0" cellspacing="0" cellpadding="0" class="table_class" style="margin:0 auto;float:none">





                        <tr>

                            <td align="left" valign="top" class="bx-border">


                                <table>
                                    <tr >

                                        <td valign=top class="tdclass" width="18%"><strong><?= $lang['ABOUT_US'] ?>: </strong></td>
                                    </tr>

                                    <tr>
                                        <td >

                                            <?php
                                            include_once 'ckeditor/ckeditor.php';
                                            include_once 'ckfinder/ckfinder.php';
                                            $ckeditor = new CKEditor();
                                            $ckeditor->basePath = 'ckeditor/';
                                            $ckfinder = new CKFinder();
                                            $ckfinder->BasePath = 'ckfinder/';
                                            $ckfinder->SetupCKEditorObject($ckeditor);
                                            echo $ckeditor->editor('about_us', html_entity_decode($row_user[about_us]));
                                            ?>

        <!-- <textarea rows="3" id="about_us"  name="about_us" class="text_box" ><?= $row_user[about_us] ?></textarea>-->


    <br><!--<span class=boldfont_con style="float:left"><?= $lang['PUB_INFO'] ?></span>--></td></tr>
                                </table>

                            </td></tr>

                        <tr><td>&nbsp;</td></tr>

                        <tr>

                            <td align="left" valign="top" class="inner_bx-bottom">

                                <table align="right" width="100%" cellpadding="0" cellspacing="0">

                                    <tr class="lnk"><td width=30%></td>

                                        <td >

                                            <input type="submit"  class="submit_bott" value="<?= $lang['UPDATE'] ?>" name="update"   />



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

<div style="clear:both; height:10px;"></div>



<?php include ('includes/footer.php'); ?>
<?php
include("includes/header_dashbord.php");
include("includes/access.php");

$light2 = "#16559c";
if (isset($_POST[SBMT_REG])) {
    $chkqrry = mysql_query("SELECT `langid` FROM `" . $prev . "mailtemplet` WHERE `langid`='" . $_POST['langid'] . "' AND `mail_type`='" . $_POST['mail_type'] . "'");
    if (mysql_num_rows($chkqrry) == 0) {
        $query = "INSERT INTO `" . $prev . "mailtemplet` SET 
                            `langid`='" . $_POST['langid'] . "', 
                            `mail_type`='" . $_POST['mail_type'] . "', 
                            `subject` = '" . mysql_real_escape_string(htmlentities($_POST['subject'])) . "',
                            `body` = '" . mysql_real_escape_string(htmlentities($_POST['body'])) . "'";
    } else {
        $query = "UPDATE `" . $prev . "mailtemplet` SET  
                            `subject` = '" . mysql_real_escape_string(htmlentities($_POST['subject'])) . "', 
                            `body` = '" . mysql_real_escape_string(htmlentities($_POST['body'])) . "' 
                WHERE `langid`='" . $_POST['langid'] . "' AND `mail_type`='" . $_POST['mail_type'] . "'";
    }
    // echo $query;
    $result = mysql_query($query);
    if ($result) {
        $msg = "Update Successful.";
    } else {
        $msg = "Update Failed.";
    }
}
$mailqrry = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE  `langid`='" . $_GET['langid'] . "' AND `mail_type`='" . $_GET['type'] . "'");
$row = mysql_fetch_assoc($mailqrry);

$langqrry = mysql_query("SELECT * FROM `" . $prev . "language` WHERE `short_code`='" . $_GET['langid'] . "'");
$langrow = mysql_fetch_assoc($langqrry);
//print_r($langrow);
$class = "lnk";
?>



<div class="main">
    <?php
    include("includes/left_side.php");
    ?>
    <!-- End #sidebar  -->
    <script src="js/jquery.genyxAdmin.js"></script>
    <section id="content">
        <div class="wrapper">
            <div class="crumb">
                <ul class="breadcrumb">
                    <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                    <li><a href="maillist.php">Mail Template Management</a></li>
                    <li><a href="maillanglist.php?type=<?= $_GET['type'] ?>">Mail Language</a></li>
                </ul>
            </div>
            <div class="container-fluid">
                <div id="heading" class="page-header">
                    <h1><i class="icon20 i-list-4"></i>Mail Template Management</h1>

                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                <h4>&nbsp;
                                    <a href="maillanglist.php?type=<?= $_GET['type'] ?>" class="header">&nbsp;<?= $_GET['type'] ?></a>&nbsp;&nbsp;<?= $msg ?>

                                </h4> 
                                <a href="#" class="minimize"></a>
                            </div><!-- End .panel-heading -->

                            <div class="panel-body">
                                <form name="register" method="post"  onSubmit="javscript:return ValidSet(this);">

                                    <table width="100%" border="1" align="center" cellspacing="0" cellpadding="0" class="table">

                                        <tr bgcolor="#b7b5b5" class=header_tr><td height=25 >&nbsp;Email Setting for <?= $_GET['type'] ?> in <?= $langrow['lang_name'] ?></td></tr>

                                        <tr><td align=center valign=top>

                                                <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?= $light ?>>

                                                    <tr bgcolor=#ffffff class=lnk><td valign=top width=20%><b>Email Subject :</b></td>

                                                        <td><input type="text" name="subject" value="<?= html_entity_decode($row['subject']) ?>" style="width: 100%" /></td></tr>

                                                    <tr bgcolor="#ffffff" class=lnk><td valign=top><b>Email Body :</b></td>

                                                        <td><?php
                                                            $body = html_entity_decode($row['body']);
                                                            if ($body == '') {
                                                                $dqrry = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE  `langid`='en' AND `mail_type`='" . $_GET['type'] . "'");
                                                                $drow = mysql_fetch_assoc($dqrry);
                                                                $body = html_entity_decode($drow['body']);
                                                            }
                                                            require_once($fckapath . "fckeditor.php");

                                                            $sBasePath = $fckbasepath;

                                                            $oFCKeditor = new FCKeditor('body');

                                                            $oFCKeditor->BasePath = $sBasePath;

                                                            $oFCKeditor->ToolbarSet = "Default";

                                                            $oFCKeditor->Width = "100%";

                                                            $oFCKeditor->Height = "400";

                                                            $oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/';



                                                            $oFCKeditor->Value = stripslashes(html_entity_decode($body));

                                                            $oFCKeditor->Create();
                                                            ?></td></tr>



                                                    <tr bgcolor=<?= $light ?>><td></td><td  height="25" align="left">

                                                            <input type=submit class="button" name='SBMT_REG' value='Update'>

                                                            &nbsp;
                                                            <input type="hidden" name="mail_type" value="<?= $_GET['type'] ?>" />
                                                            <input type="hidden" name="langid" value="<?= $_GET['langid'] ?>" />   
                                                            <input type="button"  class="button" value="Back" onClick="javascript:window.location.href = 'mailsetup.php'">

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td></tr>
                                    </table>

                                </form>

                            </div><!-- End .panel-body -->
                        </div><!-- End .widget -->
                    </div><!-- End .col-lg-12  --> 
                </div><!-- End .row-fluid  -->

            </div> <!-- End .container-fluid  -->
        </div> <!-- End .wrapper  -->
    </section>
</div><!-- End .main  -->


</body>
</html>
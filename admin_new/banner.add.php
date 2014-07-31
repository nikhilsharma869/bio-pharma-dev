<?php 
include("includes/header_dashbord.php");
include("includes/access.php");

$width_gen_box = 350;
$row_num = 1;

function uploadLogo($cname, $filedname, $savepath) {
    $temp = explode(".", $_FILES[$filedname]["name"]);
    $extension = end($temp);
    if ($_FILES[$filedname]["type"] == "image/png" || $_FILES[$filedname]["type"] == "image/jpg" || $_FILES[$filedname]["type"] == "image/jpeg") {
        $name = $savepath . '/' . strtolower(str_replace(" ", "_", $cname)) . '.' . $extension;
        if (move_uploaded_file($_FILES[$filedname]["tmp_name"], "../" . $name)) {
            return $name;
        }
    } else {
        return FALSE;
    }
}

$id = $_REQUEST[id];
if (isset($_POST['SBMT_REG'])) {

    if ((int) $_POST['id'] == 0) {
        $logo = uploadLogo($_POST['title'], 'file1', 'slides');
        $comment = str_replace("'", "''", stripslashes($_POST['comment']));

        $r = mysql_query("INSERT INTO `" . $prev . "banner` SET 
                `title`='" . $_POST['title'] . "',
                `sub_title`=\"" . $_POST['sub_title'] . "\",
                `desc`=\"" . $_POST['desc'] . "\",
                `img`=\"" . $logo . "\",
                `link1_text`=\"" . $_POST['link1_text'] . "\",
                `link1`=\"" . $_POST['link1'] . "\",
                `link2_text`=\"" . $_POST['link2_text'] . "\",
                `link2`=\"" . $_POST['link2'] . "\",
                `status`=\"" . $_POST['status'] . "\"");


        //$id=mysql_insert_id();
    } else {
        $logo = uploadLogo($_POST['title'], 'file1', 'slides');
        if ($logo == '') {
            $logo = $_POST['old_logo'];
        }
        $r = mysql_query("UPDATE `" . $prev . "banner` SET 
                `title`='" . $_POST['title'] . "',
                `sub_title`=\"" . $_POST['sub_title'] . "\",
                `desc`=\"" . $_POST['desc'] . "\",
                `img`=\"" . $logo . "\",
                `link1_text`=\"" . $_POST['link1_text'] . "\",
                `link1`=\"" . $_POST['link1'] . "\",
                `link2_text`=\"" . $_POST['link2_text'] . "\",
                `link2`=\"" . $_POST['link2'] . "\",
                `status`=\"" . $_POST['status'] . "\" 
                 WHERE `id`='" . $_POST['id'] . "'");

        $id = $_POST['id'];
    }
	   if($r):


      $msg="Update Successful";


   else:


      $msg="Update Failure.";


   endif;
}
if ($_REQUEST[id]) {
    $id = $_REQUEST[id];
}

if ($id) {

    $r = mysql_query("select * from " . $prev . "banner where id=" . $id);

    $d = @mysql_fetch_array($r);
}
?>
    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="banner.list.php">Banner Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Banner Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="banner.list.php" class="header">Banner Management</a>  <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<form method="post" name="minform" action="" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $_REQUEST['id'] ?>"/>
    <table width="100%" border="0" align="left" cellspacing="0" cellpadding="4" bgcolor="<?= $td_bgcolor ?>" class="table">
        <tr bgcolor="<?= $light ?>">
            <td height="30" colspan="3" class="header_tr">Banner Add/Modify</td>
        </tr>



        <tr bgcolor="<?php echo adminRowColor($row_num++); ?>" class="lnk">
            <td width="25%" align="left" valign="top">Title</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top"><input type="text" name="title" value="<?= $d['title'] ?>"  /></td>
        </tr>
        <tr bgcolor="<?php echo adminRowColor($row_num++); ?>" class="lnk">
            <td width="25%" align="left" valign="top">Sub Title</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top"><input type="text" name="sub_title" value="<?= $d['sub_title'] ?>"  /></td>
        </tr>
        <tr class="lnk" bgcolor="<?php echo adminRowColor($row_num++); ?>">
            <td align="left" valign="top">Banner Picture(1343px X 354px)</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top">
                <? if (file_exists("../" . $d['img']) && $d['img'] != '') {
                    ?>
                    <img src="<?= $vpath ?>viewimage.php?img=<?= $d['img'] ?>&width=60&height=60" border=0>
                <? }
                ?><input type="file" name="file1"  />
                <input type="hidden" name="old_logo" value="<?= $d['img'] ?>" />
            </td>
        </tr>
        <tr bgcolor="<?php echo adminRowColor($row_num++); ?>" class="lnk">
            <td width="25%" align="left" valign="top">First Link</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top">Text: <input type="text" name="link1_text" value="<?= $d['link1_text'] ?>"  /> Link: <input type="text" name="link1" value="<?= $d['link1'] ?>"  /></td>
        </tr>
        <tr bgcolor="<?php echo adminRowColor($row_num++); ?>" class="lnk">
            <td width="25%" align="left" valign="top">Second Link</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top">Text: <input type="text" name="link2_text" value="<?= $d['link2_text'] ?>"  /> Link: <input type="text" name="link2" value="<?= $d['link2'] ?>"  /></td>
        </tr>
        <tr class="lnk" bgcolor="<?php echo adminRowColor($row_num++); ?>">
            <td align="left" valign="top">Description</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top"><textarea name="desc" id="comment" class="" cols="50" rows="5"><?= $d['desc'] ?></textarea> 
        </tr>
        <tr class="lnk" bgcolor="<?php echo adminRowColor($row_num++); ?>">
            <td align="left" valign="top">Status<span class="lnkred">*</span></td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top"><input type="radio" name="status" value="Y" <? if ($d['status'] == "Y" || $d['status'] == '') { ?>checked="checked"<? } ?>/>
                &nbsp;Active&nbsp;
                <input type="radio" name="status" value="N" <? if ($d['status'] == "N") { ?>checked="checked"<? } ?>/>
                &nbsp;Inactive
            </td>
        </tr>
        <tr bgcolor="<?= $light ?>">
            <td colspan="3" height="20" align="center"><input type="submit" name="SBMT_REG" value='Update &raquo;' class="button" />&nbsp;&nbsp;
            </td>
        </tr>
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
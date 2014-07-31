<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

$width_gen_box = 350;
$row_num = 1;

function uploadLogo($filedname, $savepath) {
    $temp = explode(".", $_FILES[$filedname]["name"]);
    $t = time();
    $extension = end($temp);
    if ($_FILES[$filedname]["type"] == "image/png" || $_FILES[$filedname]["type"] == "image/jpg" || $_FILES[$filedname]["type"] == "image/jpeg") {
        $name = $savepath . "/" . $t . '.' . $extension;
        if (move_uploaded_file($_FILES[$filedname]["tmp_name"], '../' . $name)) {
		
            return $name;
        }
    } else {
        return FALSE;
    }
}

$id = $_REQUEST[id];
if (isset($_POST['SBMT_REG'])) {
    if ($_GET['id'] == 0) {
        $comment = str_replace("'", "''", stripslashes($_POST['comment']));
        $img = uploadLogo("file1", "testimonial_images");
	
        $r = mysql_query("insert into " . $prev . "testimonial set
	    `client_name`='" . $_POST['client_name'] . "',
		`comment`='" . $comment . "',
               `picture`='" . $img . "',
		`post_date`=NOW(),
		`status`='" . $_POST['status'] . "'");


        //$id=mysql_insert_id();
    } else {
        $comment = str_replace("'", "''", stripslashes($_POST['comment']));
        $img = uploadLogo("file1", "testimonial_images");
        if ($img == '') {
            $img = $_POST['old_img'];
        }
        $r = mysql_query("update " . $prev . "testimonial set
	     `client_name`='" . $_POST['client_name'] . "',
		`comment`='" . $comment . "',
                `picture`='" . $img . "',
		`post_date`=NOW(),
		`status`='" . $_POST['status'] . "'
		  where testi_id='" . $_POST['id'] . "'");

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

if ($id):

    $r = mysql_query("select * from " . $prev . "testimonial where testi_id=" . $id);

    $d = @mysql_fetch_array($r);

endif;
?>




<!-------------------------- VALIDATION START ---------------------------------------------------->


<style>
.span{
color:red;
margin-left:5px;
}

</style>


<script>

function validateForm() {
    var x = document.forms["minform"]["client_name"].value;
    if (x == null || x == "") {
        alert("Client Name must be filled out");
			document.forms["frm1"]["client_name"].focus();
        return false;
    }
	
	
	var y = document.forms["minform"]["comment"].value;
    if (y == null || y == "") {
        alert("Comment Field must be filled out");
		document.forms["frm1"]["comment"].focus();
        return false;
    }
}


</script>



<!-------------------------- VALIDATION END  ------------------------------------------------------>



    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

<script src="js/jquery.genyxAdmin.js"></script>
 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="testimonial_list.php">Testimonial Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Testimonial Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='testimonial_list.php' class="header">Testimonial List:</a> <?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<form method="post" name="minform" action="" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="id" value="<?= $_REQUEST['id'] ?>"/>
    <table width="100%" border="0" align="left" cellspacing="0" cellpadding="4" bgcolor="<?= $td_bgcolor ?>" class="table">
        <tr bgcolor="<?= $light ?>">
            <td height="30" colspan="3" class="header_tr"><?php echo $page_name; ?></td>
        </tr>



        <tr bgcolor="<?php echo adminRowColor($row_num++); ?>" class="lnk">
            <td width="25%" align="left" valign="top"> Full Name <span class="span">*</span></td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top"><input type="text" name="client_name" value="<?= txt_value_output($d['client_name']) ?>"  /></td>
        </tr>
        <tr class="lnk" bgcolor="<?php echo adminRowColor($row_num++); ?>">
            <td align="left" valign="top">Client's Picture</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top">
                <? if (file_exists("../" . $d['picture']) && $d['picture'] != '') {
                    ?>
                    <img src="<?= $vpath ?>viewimage.php?img=<?= $d['picture'] ?>&width=60&height=60" border=0>
                <? }
                ?><input type="file" name="file1"  /></td>
        </tr>

        <tr class="lnk" bgcolor="<?php echo adminRowColor($row_num++); ?>">
            <td align="left" valign="top">Comments <span class="span">*</span><br />
                <br />
                (separate each Keyword by commas)</td>
            <td width="2%" align="left" valign="top"> : </td>
            <td align="left" valign="top"><textarea name="comment" id="comment" class="" cols="50" rows="5"><?= $d['comment'] ?></textarea> 
        </tr>
        <tr class="lnk" bgcolor="<?php echo adminRowColor($row_num++); ?>">
            <td align="left" valign="top">Status</td>
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
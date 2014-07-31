<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
				<!-----calender script add------>



<Script Language="JavaScript">
<!--
    function isValid(T)
    {
        if (!Trim(T.co_cat_name.value))
        {
            alert("Category Name is empty");
            return false;
        }
    }

    function Trim(s)
    {
        var iLen = s.length;
        var sOut = "";
        var chr = "";
        for (var i = 0; i < iLen; i++)
        {
            chr = s.charAt(i);
            if (chr != " ")
                sOut = sOut + chr;
        }
        return sOut;
    }
//-->
</Script>






<!-----small cms validation start-------->






<!---------------------------------- VALIDATION START --------------------------------->


<style>
.span{
color:red;
margin-left:5px;
}

</style>


<script>

function validateForm() {
    var x = document.forms["minform"]["cat_name"].value;
    if (x == null || x == "") {
        alert("category Name must be filled out");
			document.forms["frm1"]["cat_name"].focus();
        return false;
    }
	
	
	var y = document.forms["minform"]["cat_desc"].value;
    if (y == null || y == "") {
        alert("category description must be filled out");
			document.forms["frm1"]["cat_desc"].focus();
        return false;
    }
}


</script>




<!--------------------------------- VALIDATION END ------------------------------------>








<!------------small cms validation end---->
        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="project-category.list.php">Category Management</a></li>
                      
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Category Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>Add Main Category</h4>&nbsp; &nbsp; <?php if($msg){echo  $msg ;} ?> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
             
			 
			 <?php

function uploadLogo($cname, $filedname, $savepath) {
    $temp = explode(".", $_FILES[$filedname]["name"]);
     $extension = end($temp);
    if ($_FILES[$filedname]["type"] == "image/png" || $_FILES[$filedname]["type"] == "image/jpg" || $_FILES[$filedname]["type"] == "image/jpeg") {
       $name = $savepath . "/" . strtolower(str_replace(" ", "_", $cname)) . '.' . $extension;
        if (move_uploaded_file($_FILES[$filedname]["tmp_name"], '../' . $name)) {
		
            return $name;
        }
    } else {
        return FALSE;
    }
}

$l = mysql_query("select * from  " . $prev . "language where status='Y'");

$ln = mysql_num_rows($l);

$msg = "";
if ($_POST[Update]) {

    if (!$_POST[cat_id]) {
        $logo = uploadLogo($_POST[cat_name], 'file', 'cat_logo');
		//echo "insert into " . $prev . "categories set cat_desc=\"" . $_POST[cat_desc] . "\", cat_name=\"" . $_POST[cat_name] . "\",cat_logo=\"" . $logo . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\"";
        $r = mysql_query("insert into " . $prev . "categories set cat_desc=\"" . $_POST[cat_desc] . "\", cat_name=\"" . $_POST[cat_name] . "\",cat_logo=\"" . $logo . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\"");

        $cat_id = mysql_insert_id();

        if ($ln) {

            while ($lng = mysql_fetch_array($l)) {

                $cat_name_lang = $lng['lang_id'] . "_cat_name";

                $lang_cat_name_id = $lng['lang_id'] . "_lang_cat_name_id";

                if ($_POST[$lang_cat_name_id]) {
                    $sqllang = mysql_query("update " . $prev . "language_content set table_name = 'categories',field_name = 'cat_name',content_field_id = '" . $cat_id . "',content = '" . $_POST[$cat_name_lang] . "',lang_id ='" . $lng[lang_id] . "'where id='" . $_POST[$lang_cat_name_id] . "'");
                } else {
                    $sqllang = mysql_query("insert into " . $prev . "language_content set table_name = 'categories',field_name = 'cat_name',content_field_id = '" . $cat_id . "',content = '" . $_POST[$cat_name_lang] . "',lang_id ='" . $lng[lang_id] . "'");
                }
            }
        }
    } else {
       $logo = uploadLogo($_POST[cat_name], 'file', 'cat_logo');
        if ($logo == '') {
            $logo = $_POST['old_logo'];
        }
       // echo "update " . $prev . "categories set cat_desc=\"" . $_POST[cat_desc] . "\", cat_name=\"" . $_POST[cat_name] . "\",cat_logo=\"" . $logo . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\" where cat_id=" . $_POST[cat_id];
        $r = mysql_query("update " . $prev . "categories set cat_desc=\"" . $_POST[cat_desc] . "\", cat_name=\"" . $_POST[cat_name] . "\",cat_logo=\"" . $logo . "\",status=\"" . $_POST[status] . "\",parent_id=\"" . $_POST[parent_id] . "\" where cat_id=" . $_POST[cat_id]);

        $cat_id = $_POST[cat_id];

        if ($ln) {

            while ($lng = mysql_fetch_array($l)) {

                $cat_name_lang = $lng['lang_id'] . "_cat_name";

                $lang_cat_name_id = $lng['lang_id'] . "_lang_cat_name_id";

                if ($_POST[$lang_cat_name_id]) {
                    $sqllang = mysql_query("update " . $prev . "language_content set table_name = 'categories',field_name = 'cat_name',content_field_id = '" . $cat_id . "',content = '" . $_POST[$cat_name_lang] . "',lang_id ='" . $lng[lang_id] . "'where id='" . $_POST[$lang_cat_name_id] . "'");
                } else {
                    $sqllang = mysql_query("insert into " . $prev . "language_content set table_name = 'categories',field_name = 'cat_name',content_field_id = '" . $cat_id . "',content = '" . $_POST[$cat_name_lang] . "',lang_id ='" . $lng[lang_id] . "'");
                }
            }
        }
    }
    if ($r) {
        $msg = "<font face=verdana size=1 color=#ffffff><b>Update Successful.</b></font>";
      echo"<script>window.location.href='project-category.list.php';</script>";
    } else {
        $msg = "<font face=verdana size=1 color=#ffffff><b>Update Failure.</b></font>";
		echo"<script>window.location.href='project-category.list.php';</script>";
    }
} else {
    if ($_POST[DELT]) {
        $r = mysql_query("select * from " . $prev . "projects where cat_id=" . $_POST[cat_id]);
        if (@mysql_num_rows($r)) {
            $msg = "<font face=verdana size=1 color=#ffffff><b>You Can't delete. Projects are there.</b></font>";
        } else {
            $r = mysql_query("delete from " . $prev . "categories where cat_id=\"" . $_POST[cat_id] . "\"");
            echo"<script>window.location.href='project-category.list.php?tid=" . $_GET[tid] . "';</script>";
        }
    }
}
if ($_GET[cat_id]) {
    $r = mysql_query("select * from  " . $prev . "categories where cat_id=" . $_GET[cat_id]);
    $d = mysql_fetch_array($r);
}
if (!$_GET[parent_id]) {
    $_GET[parent_id] = "0";
}
?>
<form method="post" name="minform" action="<?= $PHP_SELF ?>" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="parent_id" value=<?= $_GET[parent_id] ?>>
    <input type="hidden" name="cat_id" value="<?= $_GET[cat_id] ?>">
    <input type="hidden" name="tid" value="<?= $_GET[tid] ?>">
    <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="<?= $light ?>" class="table"> 
           <tr class=lnk bgcolor=#ffffff>
            <td valign=top>Category Name <span class="span">*</span></td>
            <td><input type="text" size=35 name="cat_name" value="<?= $d[cat_name] ?>" class=lnk></td></tr>

        <?php
        if ($ln) {

            while ($lng = mysql_fetch_array($l)) {
                /* echo "select * from " . $prev . "language_content where lang_id='".$lng[lang_id]."' and field_name='cat_name' and content_field_id=" . $d[cat_id]; */

                $rr1 = mysql_fetch_array(mysql_query("select * from " . $prev . "language_content where lang_id='" . $lng[lang_id] . "' and field_name='cat_name' and content_field_id=" . $d[cat_id]));
                ?>
                <input type="hidden" name="<?= $lng[lang_id] ?>_lang_cat_name_id" value="<?= $rr1['id'] ?>">
                <tr class=lnk bgcolor=#ffffff>
                    <td valign=top>Category Name(<?= $lng[lang_name] ?>) </td>
                    <td><input type="text" size=35 name="<?= $lng[lang_id] ?>_cat_name" value="<?= $rr1[content] ?>" class=lnk></td>
                </tr>
                <?php
            }
        }
        if ((int) $_GET['parent_id'] == 0) {
            ?>
            <tr class=lnk bgcolor=#ffffff>
                <td valign=top>Category Logo<br>
                    <span style="font-size: 9px;">size 174px X 156px</span>
                </td>
                <td><input type="file" name="file" />
                    <input type="hidden" name="old_logo" value="<?= $d['cat_logo'] ?>" />
                </td></tr>
            <tr class=lnk bgcolor=#ffffff>
                <td valign=top>Category Description <span class="span">*</span></td>
                <td><textarea name="cat_desc" rows="5" cols="32"><?= $d[cat_desc] ?></textarea></td></tr>
            <?php
        }
        ?>
        <tr bgcolor=#ffffff class=lnk><td>Status</td><td><input type=radio name=status value="Y" <?php
                if ($d["status"] == "Y") {
                    echo" checked";
                }
                ?> >Online <input type=radio name=status value="N" <?
                                                                if ($d["status"] == "N") {
                                                                    echo" checked";
                                                                }
                                                                ?>> Offline </td></tr>
        <tr>
            <td align=center  colspan=2><input type="submit" name="Update" value="Update" class="button" />    &nbsp;&nbsp;<? if ($_GET[cat_id]) { ?>
            <input type="submit" name="DELT" value="Delete" class="button" ><? } ?>&nbsp;&nbsp;<input type="Button"  value="Back" onClick="JavaScript:window.location.href = 'project-category.list.php';" class="button" >&nbsp;&nbsp;<Blnk><?= $msg ?></Blnk></td></tr>
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
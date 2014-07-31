<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
//require_once("testimonial.inc.php");
if ($_GET[del]):
    $r = mysql_query("delete from " . $prev . "testimonial where testi_id=" . $_GET[id]);
	redirect('testimonial_list.php');
endif;

?>


    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

			
			
	<?php
if($_REQUEST['limit'])
	{
		$page = $_REQUEST['limit'];
	}
	else
	{
		$page = 1;
	}
	
	
$r=mysql_query("select count(*) as total from ".$prev."testimonial");
$total=@mysql_result($r,0,"total");



?>	
			
			
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
<p align="right">
<button class="btn btn-default" type="button" onClick="javascript:window.location.href='add_new_testimonial.php'">Add New Testimonial</button>
</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="testimonial_list.php" class="header">Testimonial List</a>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<table width="100%" cellpadding="5" cellspacing="0" border="0" class="table" align="center">
    <tr bgcolor="#FFFFFF">
        <td align="left" valign="top">
            <table id="table-content" width="100%" border="0" cellspacing="1" cellpadding="4" class="table table-striped table-bordered table-hover" id="dataTable">
                <thead>
                    <tr bgcolor="<?= $graywhite2 ?>">
                        <td height="25" align="left"><b>Full Name</b></td>
                        <td height="25" align="center"><b>Picture</b></td>
                        <td width="20%" align="center"><b>Date</b></td>
                        <td width="15%" align="center"><b>Status</b></td>
                        <td width="15%" align="center"><b>Options</b></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num_records_per_page = 5;
                    $offset = 0;
                    $parama = "";

                    if ($_GET['limit'] && $_GET['limit'] != '') {
                        $offset = ($_GET['limit'] - 1) * $num_records_per_page;
                    }

                    $where_clause = " WHERE ";
                    if ($_REQUEST['param'] && $_REQUEST['search']) {
                        if ($_REQUEST['param'] == "id") {
                            $cond = "testi_id = '" . $_REQUEST['search'] . "'";
                        } else if ($_REQUEST['param'] == "fullname") {
                            $cond = "client_name RLIKE '" . addslashes($_REQUEST['search']) . "'";
                        }
                        $parama = "&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
                    }

                    if ($cond)
                        $where_clause .= $cond;
                    else
                        $where_clause .= 1;

                    $total_exe = mysql_query("SELECT COUNT(*) AS `total` FROM " . $prev . "testimonial" . $where_clause . "");
                    $total = @mysql_result($total_exe, 0, "total");

                    $main_query = "SELECT * FROM " . $prev . "testimonial" . $where_clause . "	ORDER BY client_name ASC	LIMIT $offset, $num_records_per_page";
                    $main_exe = mysql_query($main_query) or die(mysql_error());

                    if (@mysql_num_rows($main_exe)) {
                        $j = 0;

                        $box_image_name = '';
                        $tid_link = '';
                        $tids = array();

                        if ($_GET['fid']) {
                            $tids = explode("|", $_GET['fid']);
                        }

                        while ($main_fetch = mysql_fetch_array($main_exe)) {
                            $j++;
                            if (($j % 2))
                                $class = "odd";
                            else
                                $class = "even";


                            if ($main_fetch['status'] == "Y")
                                $status = $main_icon_active_img;
                            else
                                $status = $main_icon_inactive_img;
                            ?>
                            <tr bgcolor="#ffffff" class="<?= $class ?>">
                                <td align="left"><?php echo stripslashes($main_fetch['client_name']); ?></td>
                                <td align="center"><img src="<?= $vpath ?>viewimage.php?img=<?= $main_fetch['picture'] ?>&width=60&height=60" border=0></td>
                                <td align="center"><?php echo $main_fetch['post_date']; ?></td>
                                <td align="center"><?php echo $status; ?></td>
                                <td align="center">
                                    <a class='lnk tip' title='Edit Testimonial' href="add_new_testimonial.php?id=<?php echo $main_fetch['testi_id']; ?>"><?php echo $main_icon_edit_img; ?></a>
                                    <?php if (!in_array($main_fetch['testi_id'], $no_delete_ids)) { ?>
                                        &nbsp;|&nbsp;
										<?php
										 echo"<a class='lnk tip' title='Delete Testimonial' href=\"javascript://\" onclick=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $main_fetch['testi_id'] . "&amp;del=1';}\"><img src='images/icon_del.png' border='0'></a> ";
										?>
                                       
                                    <?php } ?></td>
                            </tr>
                            <?php
                        }

                        if ($total > $num_records_per_page) {
                            ?>
                            <tr bgcolor="<?= $light ?>">
                                <td colspan="5" align="center" height="25"><?= paging($total, $num_records_per_page, $parama, "paging"); ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td align="center" colspan="5" class="lnkred">No Records Found!</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table></td>
    </tr>
</table>

<script type="text/javascript">
//<![CDATA[
    function addClassName(el, sClassName) {
        var s = el.className;
        var p = s.split(" ");
        var l = p.length;
        for (var i = 0; i < l; i++) {
            if (p[i] == sClassName)
                return;
        }
        p[p.length] = sClassName;
        el.className = p.join(" ");

    }

    function removeClassName(el, sClassName) {
        var s = el.className;
        var p = s.split(" ");
        var np = [];
        var l = p.length;
        var j = 0;
        for (var i = 0; i < l; i++) {
            if (p[i] != sClassName)
                np[j++] = p[i];
        }
        el.className = np.join(" ");
    }
    var st = new SortableTable(document.getElementById("table-content"),
            ["Number", "String", "String", "None"]);
    // restore the class names
    st.onsort = function() {
        var rows = st.tBody.rows;
        var l = rows.length;
        for (var i = 0; i < l; i++) {
            removeClassName(rows[i], i % 2 ? "odd" : "even");
            addClassName(rows[i], i % 2 ? "even" : "odd");
        }
    };
//]]>
</script>
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
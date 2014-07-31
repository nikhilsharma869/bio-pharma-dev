<?php
include("includes/header_dashbord.php");
include("includes/access.php");
?>

<div class="main">
    <? include("includes/left_side.php"); ?>
    <!-- End #sidebar  -->



    <script src="js/jquery.genyxAdmin.js"></script>



    <section id="content">
        <div class="wrapper">
            <div class="crumb">
                <ul class="breadcrumb">
                    <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                    <li><a href="mailsetup.php">Mail Template Management</a></li>

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
                                    <a href="mailsetup.php" class="header">Mail Template List</a>

                                </h4> &nbsp; &nbsp; <?php
                                if ($msg) {
                                    echo "<blink>" . $msg . "</blink>";
                                }
                                ?>
                                <a href="#" class="minimize"></a>
                            </div><!-- End .panel-heading -->

                            <div class="panel-body">
                                <table width="100%" cellpadding="5" cellspacing="0" border="0"  align="center" class="table table-striped table-bordered table-hover" id="dataTable">

                                    <tr bgcolor="#FFFFFF">

                                        <td align="left" valign="top">

                                            <table id="table-content" width="100%" class="sort-table" border="0" cellspacing="1" cellpadding="4">

                                                <thead>

                                                    <tr bgcolor="<?= $graywhite2 ?>">

                                                        <td height="25" width="70%" align="left"><b>Mail Type</b></td>

                                                        <td height="25" width="25%" align="center"><b>Action</b></td>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php
                                                    $num_records_per_page = 20;

                                                    $offset = 0;

                                                    $parama = "";



                                                    if ($_GET['limit'] && $_GET['limit'] != '') {

                                                        $offset = ($_GET['limit'] - 1) * $num_records_per_page;
                                                    }



                                                    $where_clause = " WHERE ";

                                                    if ($_REQUEST['param'] && $_REQUEST['search']) {

                                                        if ($_REQUEST['param'] == "id") {

                                                            $cond = "id = '" . $_REQUEST['search'] . "'";
                                                        } else if ($_REQUEST['param'] == "id") {

                                                            $cond = "id RLIKE '" . addslashes($_REQUEST['search']) . "'";
                                                        }

                                                        $parama = "&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
                                                    }



                                                    if ($cond)
                                                        $where_clause .= $cond;
                                                    else
                                                        $where_clause .= 1;



                                                    $total_exe = mysql_query("SELECT DISTINCT `mail_type` AS `total` FROM " . $prev . "mailtemplet " . $where_clause . "");

                                                    $total = @mysql_result($total_exe, 0, "total");



                                                    $main_query = "SELECT DISTINCT `mail_type` FROM " . $prev . "mailtemplet " . $where_clause . " ORDER BY `mail_type` ASC LIMIT $offset, $num_records_per_page";

                                                    $main_exe = mysql_query($main_query) or die(mysql_error());



                                                    if (@mysql_num_rows($main_exe)) {

                                                        $j = 0;



                                                        $box_image_name = '';

                                                        $tid_link = '';

                                                        $tids = array();



                                                        if ($_GET['id']) {

                                                            $tids = explode("|", $_GET['id']);
                                                        }



                                                        while ($main_fetch = mysql_fetch_array($main_exe)) {

                                                            $j++;

                                                            if (($j % 2)) {

                                                                $class = "odd";
                                                            } else {

                                                                $class = "even";
                                                            }


                                                            if ($main_fetch['status'] == "Y") {

                                                                $status = $main_icon_active_img;
                                                            } else {

                                                                $status = $main_icon_inactive_img;
                                                            }
                                                            ?>

                                                            <tr bgcolor="#ffffff" class="<?= $class ?>">

                                                               <td align="left"><?php echo stripslashes($main_fetch['mail_type']); ?></td>

                                                                <td align="center">

                                                                    <a class="lnk" href="maillanglist.php?type=<?php echo $main_fetch['mail_type']; ?>"><?php echo $main_icon_edit_img; ?></a></td>

                                                            </tr>

                                                            <?php
                                                        }



                                                        if ($total > $num_records_per_page) {
                                                            ?>

                                                            <tr bgcolor="<?= $light ?>">

                                                                <td colspan="2" align="center" height="25"><?= paging($total, $num_records_per_page, $parama, "paging"); ?></td>

                                                            </tr>

                                                            <?php
                                                        }
                                                    } else {
                                                        ?>

                                                        <tr>

                                                            <td align="center" colspan="2" class="lnkred">No Records Found!</td>

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
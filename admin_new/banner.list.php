<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
if ($_GET[del]):
    $r = mysql_query("delete from " . $prev . "banner where id=" . $_GET[id]);
	redirect('banner.list.php');
endif;
if ($_REQUEST['langs'] == "") {
    $langs = "english";
} else {
    $langs = $_REQUEST['langs'];
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
									<a href='banner.list.php' class="header">&nbsp;Banner List:</a>&nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<br />

<form method=post action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">

    <table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor="<?= $light ?>" class="table">
        <tr bgcolor="<?= $light ?>"><td width="54%" height="28" class="header">Banner Management&nbsp;
            </td>
            <td bgcolor="<?= $light ?>" width="46%" align="right">
                <input type="button" value='Add New' class="button" onclick="javascript:window.location.href = 'banner.add.php'">
            </td></tr></table>
    <p class="lnk" align="right">
        <?php echo $main_icon_active_img; ?>&nbsp;= Active
        &nbsp;|&nbsp;
        <?php echo $main_icon_inactive_img; ?>&nbsp;= Hidden
        &nbsp;|&nbsp;
        <?php echo $main_icon_edit_img; ?>&nbsp;= Edit
        &nbsp;|&nbsp;
        <?php echo $main_icon_del_img; ?>&nbsp;= Delete

    </p>
    <table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="6"  class="table table-striped table-bordered table-hover" id="dataTable">
        <thead>
            <tr bgcolor="<?= $graywhite2 ?>"><td height=22><b>Title</b></td><td align="center"><b>Status</b></td><td  align="center"><b>Action</b></td></tr>
        </thead><tbody>
            <?
            if (!$_REQUEST[limit]) {
                $_REQUEST[limit] = 1;
            }
            if ($_REQUEST[param] != '' && $_REQUEST[search] != ''):
                $cond = $_REQUEST[param] . " rlike '" . $_REQUEST[search] . "'";
            endif;
            if ($cond) {
                $cond2 = " where  " . $cond;
            }
            $r = mysql_query("select count(id) as total from " . $prev . "banner " . $cond2);
            $total = @mysql_result($r, 0, "total");
            if (!$total):
                echo"<tr class='lnkred'><td colspan='3' align='center'>No Record Found.</td></tr>";
            endif;
            $r = mysql_query("select * from " . $prev . "banner " . $cond2 . " limit " . ($_REQUEST['limit'] - 1) * 10 . ",10");
//echo "select * from " . $prev . "contents where lang='" . $_REQUEST[lang] . "'" . $cond2 . " limit " . ($_REQUEST['limit']-1)*20 . ",20";
            $j = 0;
            $k = 0;
            while ($d = @mysql_fetch_array($r)):
                if (!($j % 2)) {
                    $class = "even";
                } else {
                    $class = "odd";
                }
                if ($d[status] == "Y") {
                    $status = " $main_icon_active_img";
                } else {
                    $status = "$main_icon_inactive_img";
                }
                echo"<tr bgcolor='#ffffff' class='" . $class . "'>";

                echo"<td height=20><a class='lnk'  href='banner.add.php?id=" . $d[id] . "'><u>" . ucwords($d[title]) . "</u></a></td>";

                echo"<td align='center'>" . ucwords($status) . "</td><td align=center><a class='lnk tip' title='Edit Banner'  href='banner.add.php?id=" . $d[id] . "'><img src='images/icon_edit.png' border='0'></a> | ";
                echo"<a class='lnk tip' title='Delete Banner'  href=\"javascript://\" onclick=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&amp;del=1';}\"><img src='images/icon_del.png' border='0'></a> ";

                echo"</td></tr>\n";
                $j++;
            endwhile;
            $parama = "&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
            ?>
        </tbody>
    </table>
    <? if ($total > 10): ?>
        <table  width="100%"  border="0" align="center" cellspacing="0" cellpadding="4" style="border:solid 1px <?= $dark ?>">
            <tr bgcolor="<?= $light ?>"><td  align="center" height="25"><?= paging($total, 10, $parama, "lnk"); ?></td></tr>
        </table>
    <? endif; ?>
</form>
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
    var st = new SortableTable(document.getElementById("table-1"),
            ["Number", "String", "String", "String", "String", "String", "String", "String", "Number", "String", "None"]);
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
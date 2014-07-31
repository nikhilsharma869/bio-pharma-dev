<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
<?php 

if($_GET[del]){
   $r=mysql_query("delete from " . $prev . "contents where id=" . $_GET[id]);

   if($r)
   {
   ?>
    <script>
   function newDoc()
   {
   window.location.assign("content_list.php")
   }
   window.setTimeout("newDoc()",2000);
   </script>
   
   <?
   $msg= '<div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <strong><i class="icon24 i-checkmark-circle"></i>Successfully!</strong>delete your records.
                            </div>';
   
}
}


?>
        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="content.list.php">Content Management</a></li>
                      <li class="active">Content List</li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Content Management</h1>
                    </div>
<!--<p align="right">
<button class="btn btn-default" type="button" onClick="javascript:window.location.href='page.php'">Add Contents</button>
</p>-->
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-table"></i></div>
                                    <h4>Content List</h4>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->

                                <div class="panel-body">
                               <p align="center">
 <? if($msg!=''): echo $msg; endif;?>
 
</p>
                                   <form method="post" action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

                               <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="dataTable">
                                                                         
                                        <thead>
                                        <tr><td valign=top><b>Title</b></td><td align="center"><b>Status</b></td><td valign="top" align="center"><b>Action</b></td></tr>
                                        </thead>
                                        
                                       
                                        <tbody>
<?
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
if($_REQUEST[param]!='' && $_REQUEST[search]!=''){
   $cond=$_REQUEST[param]  . " rlike '" . $_REQUEST[search] . "'";
}
if($cond){$cond2=" where  " . $cond;}
$r=mysql_query("select count(id) as total from " . $prev . "contents " . $cond2);
$total=@mysql_result($r,0,"total");
if(!$total){
   echo"<tr class='lnkred'><td colspan='3' align='center'>No Record Found.</td></tr>";
}
$r=mysql_query("select * from " . $prev . "contents " . $cond2 . " limit " . ($_REQUEST['limit']-1)*10 . ",10");
//echo "select * from " . $prev . "contents where lang='" . $_REQUEST[lang] . "'" . $cond2 . " limit " . ($_REQUEST['limit']-1)*20 . ",20";
$j=0;$k=0;
while($d=@mysql_fetch_array($r)){
	if(!($j%2)){$class="even";}else{$class="odd";}
    if($d[status]=="Y"){$status="$main_icon_active_img";}else{$status="$main_icon_inactive_img";}
    echo"<tr bgcolor='#ffffff' class='" . $class . "'>";
	
	echo"<td height=20><a class='lnk'  href='page.editor.php?id=" . $d[id] . "'><u>" . ucwords($d[cont_title]) . "</u></a></td>";
	
	echo"<td align='center'>" . ucwords($status) . "</td><td align=center><a class='lnk  tip' title='Edit Content' href='page.editor.php?id=" . $d[id] . "'>".$main_icon_edit_img	."</a>  ";
	//echo"<a class='lnk'  href=\"javascript://\" onclick=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&amp;del=1';}\">".$main_icon_del_img."</a> ";
   
    echo"</td></tr>\n";
	$j++;
}
$parama="&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
?>
</tbody>
                                       
                                        
                                        <!--<tfoot>
                                            <tr>
                                                <th>Rendering engine</th>
                                                <th>Browser</th>
                                                <th>Platform(s)</th>
                                                <th>Engine version</th>
                                                <th>CSS grade11</th>
                                            </tr>
                                        </tfoot>-->
                                    </table>
									<? if ($total > 10): ?>
        <table  width="100%"  border="0" align="center" cellspacing="0" cellpadding="4" style="border:solid 1px <?= $dark ?>">
            <tr bgcolor="<?= $light ?>"><td  align="center" height="25"><?= paging($total, 10, $parama, "lnk"); ?></td></tr>
        </table>
<? endif; ?>
                                  
</form>
                                </div><!-- End .panel-body -->
                            </div><!-- End .widget -->

                        </div><!-- End .col-lg-12  --> 
                    </div><!-- End .row-fluid  -->

                </div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
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

        </section>
    </div><!-- End .main  -->
  </body>
</html>
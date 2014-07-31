<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

if($_GET[del]):
   $r1 = mysql_query("delete from " . $prev . "halp where id=" . $_GET[id]);
   if($r1)
   {
	   header("location:faq.list.php?msg=Record deleted successfully&limit=".$_REQUEST[limit]);
   }
   else
   {
	   header("location:faq.list.php?msg=Record deletetion failed&limit=".$_REQUEST[limit]);
   }
endif;
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
                      <li><a href="help.list.php">Help Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Help Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="help.list.php" class="header">Help Management</a><span style="float:right;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=button value='Add New' class=button onclick="javascript:window.location.href='help.entry.php?id=0'"></span>
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor="<?=$light?>" class="table">
<tr bgcolor="<?=$light?>">
<td bgcolor="<?=$light?>" width=100% align="right">
<table >
<tr class=lnk>
	<td>
    	<label><b>Enter Question</b></label>&nbsp;&nbsp;
	</td>
    <td>
    	<input type="text" name="search_txt" value="<?php print $_REQUEST[search_txt];?>" /> &nbsp;
    </td>
<td><input type=submit class=button name='SBMT_SEARCH'  value='  Search  '>	</td></tr></table>
</td></tr></table>

<p class="lnk" align="right"><?php if(isset($_REQUEST[msg])) { print "<font color=\"#FF0000\" size=\"-1\">".$_REQUEST[msg]."</font>";}?>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $main_icon_active_img; ?>&nbsp;= Active
	&nbsp;|&nbsp;
	<?php echo $main_icon_inactive_img; ?>&nbsp;= Hidden
	&nbsp;|&nbsp;
	<?php echo $main_icon_edit_img; ?>&nbsp;= Edit
	&nbsp;|&nbsp;
	<?php echo $main_icon_del_img; ?>&nbsp;= Delete
</p>
<table id="table-1" width="100%"  border="0" align="center" cellspacing="1" cellpadding="4" class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr><td height=22 width=70%><b>Question</b></td><td align=center><b>Display Order</b></td><td align=center><b>Status</b></td><td  align=center><b>Action</b></td></tr>
</thead><tbody>
<?
if(!$_GET[limit]){$limit=0;$lmt="limit " . $limit . ",20";}else{$lmt="limit " . $_GET[limit] . ",20";}
if($_POST[SBMT_SEARCH] && $_POST[search_txt]):
   if( $_POST[param]=='id'){
   	$cond=$_POST[param]  . " = '" . $_POST[search_txt] . "'";
   }
  else{
   $cond=" question like '%" . $_POST[search_txt] . "%'";}
endif;
if($cond){$cond2=" where " . $cond;}
$r=mysql_query("select count(*) as total from " . $prev . "halp " . $cond2);
$total=@mysql_result($r,0,"total");
$r=mysql_query("select * from " . $prev . "halp" . $cond2 . " " .  $lmt);
//echo "select * from " . $prev . "faq" . $cond2 . " " .  $lmt;
	if(!$total):
		echo"<tr class='lnkred'><td colspan='4' align='center'>No Result found.</td></tr>";
	endif;
$j=0;$k=0;
while($d=@mysql_fetch_array($r)):
	if(!($j%2)){$class="even";}else{$class="odd";}
    if($d[status]=="Y"){$status=$main_icon_active_img;}else{$status=$main_icon_inactive_img;}
    //$rr=mysql_query("select * from " . $prev . "faq_header where hid=". $d[hid]);
    //$menu_header=@mysql_result($rr,0,"name");
    //$place="";
	$dot="";
	if(strlen($d[question])>60){$dot="...";}
    echo"<tr bgcolor=#ffffff class=" . $class . "><td height=20><a class=lnk  href='help.entry.php?id=" . $d[id] . "'><u>" . substr($d[question],0,60) . "" . $dot . "</u></a></td><td align=center>" . $d[ord] . "</td><td align=center>" . $status . "</td><td align=center><a class='lnk tip' title='Edit Help'  href='help.entry.php?id=" . $d[id] . "'><u>".$main_icon_edit_img."</u></a> | <a class='lnk tip' title='Delete Help'  href=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $PHP_SELF . "?id=" . $d[id] . "&limit=".$_REQUEST['limit']."&del=1';}\"><u>".$main_icon_del_img."</u></a></td></tr>";
	$j++;
endwhile;
?>
</tbody>
</table>
<?
if($total>20):?>
<table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
  <tr bgcolor=<?=$light?>><td  align=center >
   <?php echo paging($total,20,"$parama","lnk");?>
</td></tr></table>
<? endif;?>
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
	["Number","String","String","Number","String","None"]);
	// restore the class names
st.onsort = function () {
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
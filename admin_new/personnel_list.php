<?php 
include("includes/header_dashbord.php");
include("includes/access.php");

if($_SESSION['admin_type']=='A' && $_SESSION['admin_id']!=''){
$quer1=mysql_fetch_array(mysql_query("SELECT per_submanagement FROM ".$prev."admin WHERE status='Y' AND type='".$_SESSION['admin_type']."' AND admin_id='".$_SESSION['admin_id']."'"));
 $asd1=explode(",",$quer1['per_submanagement']);
 $asd2=end(explode("/",$_SERVER['PHP_SELF']));

$rs=mysql_query("select id from " . $prev . "adminmenu where url='".$asd2."'");
$rrr=mysql_fetch_array($rs);

if(!in_array($rrr['id'],$asd1)){
?>
		 <script>
       function newDoc()
       {
       window.location.assign("dashboard.php")
       }
       window.setTimeout("newDoc()");
       </script>
<?php
}
}

if($_SESSION['admin_type']=='A' && $_SESSION['admin_id']){
//echo "SELECT * FROM ".$prev."admin WHERE status='Y' AND type='".$_SESSION['admin_type']."' AND admin_id='".$_SESSION['admin_id']."'";
$quer=mysql_query("SELECT * FROM ".$prev."admin WHERE status='Y' AND type='".$_SESSION['admin_type']."' AND admin_id='".$_SESSION['admin_id']."'");
}else {
$quer=mysql_query("SELECT * FROM ".$prev."admin WHERE status='Y'");
}
$sqlfetch = mysql_fetch_array($quer);
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
<?php 

if($_GET[del]){
$id=$_GET[id];
   $r=mysql_query("delete from " . $prev . "personnel where id=" . $_GET['id']);
   	if($_SESSION['admin_id']!='' && $_SESSION['admin_type']=='A'){
				loghistory($_SESSION['admin_id'],'Delete Driver id:'.$id);
			}
   if($r)
   {
   ?>
    <script>
   function newDoc()
   {
   window.location.assign("personnel_list.php")
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
                      <li><a href="personnel_list.php">Personnel Management</a></li>
                      <li class="active">Personnel List</li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Personnel Management</h1>
                    </div>
<p align="right">
<button class="btn btn-default" type="button" onClick="javascript:window.location.href='personnel_entry.php'">Add New Personnel</button>
</p>
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-table"></i></div>
                                    <h4>Personnel List</h4>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->

                                <div class="panel-body">
                               <p align="center">
 <? if($msg!=''): echo $msg; endif;?>
 
</p>
                                   <form method="post" action="<?=$_SERVER['PHP_SELF']?>">

                               <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="dataTable">
                                                                         
                                        <thead>
                                        <tr>
                                        <td valign=top><b>Personnel ID</b></td>
                                        <td valign=top><b>Personnel Name</b></td>
                                        <td valign=top><b>Personnel Picture</b></td>
                                        <td valign=top><b>Driver's Contact</b></td>
                                        <td valign=top><b>Emergency Contact</b></td>
                                        <td align="center"><b>Status</b></td>
                                        <td valign="top" align="center"><b>Action</b></td></tr>
                                        </thead>
                                        
                                       
                                        <tbody>
<?
	$num_records_per_page = 20;

	$offset = 0;

	if($_GET['limit'] && $_GET['limit'] != ''){

		$offset = ($_GET['limit'] - 1) * $num_records_per_page;

	}
	if($_REQUEST['status']=='Y')
	{
	    $cond="status='".$_REQUEST['status']."'";
	}
	   if($_REQUEST['status']=='N')
	{
		$cond="status='".$_REQUEST['status']."'";
	}
if($cond) {
	if($_SESSION['admin_type']=='S'){
		$cond2 = "". 'WHERE ' . $cond .''; 
		}else{
		$cond2 = "". ' AND ' . $cond .''; 
		}
	}
	else{
		$cond2 = '';
	}
if($_SESSION['admin_type']=='S'){
$r=mysql_query("select count(id) as total from " . $prev . "personnel " . $cond2 . "");
$total=@mysql_result($r,0,"total");
if(!$total){
   echo"<tr class='lnkred'><td colspan='3' align='center'>No Record Found.</td></tr>";
}
$r=mysql_query("select * from " . $prev . "personnel " . $cond2 . " LIMIT $offset, $num_records_per_page");
}else{
$r=mysql_query("select count(id) as total from " . $prev . "personnel WHERE admin_id='".$_SESSION['admin_id']."' AND user_type='".$_SESSION['admin_type']."' " . $cond2 . "");
$total=@mysql_result($r,0,"total");
if(!$total){
   echo"<tr class='lnkred'><td colspan='3' align='center'>No Record Found.</td></tr>";
}
$r=mysql_query("select * from " . $prev . "personnel WHERE admin_id='".$_SESSION['admin_id']."' AND user_type='".$_SESSION['admin_type']."' " . $cond2 . " LIMIT $offset, $num_records_per_page");
}
$j=0;$k=0;
while($d=@mysql_fetch_array($r)){
	$name = ucwords($d['fname'])."&nbsp;".ucwords($d['mname'])."&nbsp;".ucwords($d['sname']);
	if(!($j%2)){$class="even";}else{$class="odd";}
    if($d['status']=="Y"){$status="$main_icon_active_img";}else{$status="$main_icon_inactive_img";}
    echo"<tr bgcolor='#ffffff' class='" . $class . "'>";
	
	echo"<td height=20>" . $d['p_id'] . "</td>";
	
	echo"<td height=20><a class='lnk'  href='personnel_entry.php?id=" . $d['id'] . "'><u>" . $name . "</u></a></td>";
	
	if($d['personnel_pic'] == '')
	 {
	  echo"<td height=20><img src='../images/no_img.png' height='50px' width='100px' /></td>"; 
	 }
	else 
	 {
	  echo"<td height=20><img src='../images/".$d['personnel_pic']."' height='50px' width='100px' /></td>";
	 }
	
	echo"<td align='center'>" . $d['d_contact'] . "</td>";
	
	echo"<td align='center'>" . $d['e_contact'] . "</td>";
	
	echo"<td align='center'>" . ucwords($status) . "</td>";
	
	echo "<td align=center><a class=lnk  href='view_personal.php?id1=" . $d['id'] . "'>".$main_icon_view_img."</a> | ";
	if($sqlfetch['p_edit']=='Y'){
	echo"<a class=lnk  href='personnel_entry.php?id=" . $d['id'] . "'>".$main_icon_edit_img."</a> | ";
		}
   if($sqlfetch['p_delete']=='Y'){
	echo"<a class='lnk'  href=\"javascript://\" onclick=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d['id'] . "&amp;del=1';}\">".$main_icon_del_img."</a> ";
   }
    echo"</td></tr>\n";
	$j++;
}

		if($total > $num_records_per_page) {

	?>

	  <tr bgcolor="<?=$light?>">

		<td colspan="8" align="center" height="25"><?=paging($total, $num_records_per_page, $parama, "paging");?></td>

	  </tr>

	<?php

		}

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
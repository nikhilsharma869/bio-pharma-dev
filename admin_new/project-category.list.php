<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
?>
    <div class="main">
        <?php include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
<?php 

if($_GET[del] && $_GET[cat_id]){
   $r=mysql_query("select * from " . $prev . "projects where categories=" . $_GET[cat_id]);
   if(@mysql_num_rows($r)>0){
      $msg="<font face=verdana size=3 color=#f00><b>You Can't delete.Projects exists in this category.</b></font>";	
	  ?>
	  	 <script>
       function newDoc()
       {
       window.location.assign("project-category.list.php")
       }
       window.setTimeout("newDoc()",2000);
       </script>
	  <?php
	  }
  
  else{
      $r=mysql_query("delete from " . $prev . "categories where cat_id=\"" . $_GET[cat_id] . "\"");
      echo"<script>window.location.href='project-category.list.php?tid=" .$_GET[tid]. "';</script>";
   }
}
?>


        <section id="content">
            <div class="wrapper">
              <!---- breadcrumb ---->
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="category_list.php">Category Management</a></li>
                      <li class="active">Category List</li>
                    </ul>
                  
                </div>
                  <!---- breadcrumb ---->
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Category Manament</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-table"></i></div>
                                    <h4>
									<a href="project-category.list.php" >
									<u>Category List</u>
									</a>
									<?php
									if($_REQUEST['sublist']!='' && $_REQUEST['catid']!='')
									{
										$sql_sub = mysql_fetch_array(mysql_query("select catname from list_cats where catid='".$_REQUEST['catid']."'"));
									
									echo "<b>".ucwords($sql_sub['catname'])."</b>";
									}
									?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($msg) { echo $msg; } ?>
									</h4>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
<input type="hidden" name="p_id" value="<?=$_REQUEST['catid']?>">
                                <div class="panel-body">
<table width="100%" border="0" align="center" cellspacing="0" bgcolor=silver cellpadding="4" class="table">
<tr bgcolor=<?=$light?> ><td  class=header></td><td align=right > <a href="#" class="tip" title="Add Parent Category"><input type="button" class="button" onClick="javascritp:window.location.href='project-category.entryform.php?tid=<?=$_GET[tid]?>&parent_id=0';" value="Add Catgory"></a></td></tr></table>
<p class="lnk" align="right">&nbsp;
	<?php echo $main_icon_edit_img; ?>&nbsp;= Edit
	&nbsp;|&nbsp;
	<u><img src='images/icon/sub.png' border='0' width="25" height="25"></u>&nbsp;= Add Sub Page
	<?php echo $main_icon_del_img; ?>&nbsp;= Delete</p>
<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  style="border:solid 1px <?=$dark?>" class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr class="gridcell"><td valign=top height=22><b>Category Name</b></td><td valign=top><b>Sub Category</b></td><td valign=center><b>No of Projects</b></td><td valign=top align=center><b>Action</b></td></tr>
<?
$j=0;$tids=array();
if($_GET[tid]):
  $tids=explode("|",$_GET[tid]);
endif;
$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 order by cat_name");
while($d=@mysql_fetch_array($r)):
    if(!($j%2)){$class="even";}else{$class="odd";}
	echo"<tr bgcolor=#ffffff class='even gridcell'><td height=20 style='font-size:13px;'>";
	if(in_array($d[cat_id],$tids)):
        echo"<a  href='" . $_SERVER[PHP_SELF] . "?tid=". str_replace("|$d[cat_id]|","|",$tid) .  "'\" value='-'><img src='images/box2.png' border=0></a>";
    else:
        echo"<a class='tip' title='Click here to view Subcategory' href='" . $_SERVER[PHP_SELF] . "?tid=". $tid . "|" . $d[cat_id] . "|'\" value='+'><img src='images/box3.png' border=0></a>"; 
    endif;
    echo" <a class=lnk  href='project-category.entryform.php?tid=" . $_GET[tid] . "&cat_id=" . $d[cat_id] . "'><b>" . $d[cat_name] . "</b></a></td>
	<td align=center colspan=2>&nbsp;</td>
	<td align=center><a class='lnk tip' title='Edit Parent Category' href='project-category.entryform.php?cat_id=" . $d[cat_id] . "'><u>".$main_icon_edit_img."</u></a> | <a class='lnk tip' title='Add Subcategory' href='project-category.entryform.php?parent_id=" . $d[cat_id] . "'><u><img src='images/icon/sub.png' border='0' width='25' height='25'></u></a></td></tr>";
    if(in_array($d[cat_id],$tids)):
		$rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $d[cat_id] . " order by cat_name");
		$k=0;
		while($dd=mysql_fetch_array($rr)):
	        $rrr=mysql_query("select count(*) as total from " . $prev . "projects p JOIN ".$prev."projects_cats pc ON p.id = pc.id where cat_id=" . $dd[cat_id]);
            $total=@mysql_result($rrr,0,"total");
            if(!$total){$total="0";}
		    if(!($k%2)){$class="odd";}else{$class="even";} 
	        echo"<tr bgcolor=#ffffff class=odd>
			<td height=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|______________</td>
			<td ><a class=lnk href='project-category.entryform.php?parent_id=" .$d[cat_id]. "&cat_id=" . $dd[cat_id] . "'>" . $dd[cat_name] . "</a></td>
			<td align=center >" . $total . "</td>
			<td align=center> <a class='lnk tip' title='Edit Subcategory' href='project-category.entryform.php?parent_id=" .$d[cat_id]. "&tid=".$_GET[tid]."&cat_id=" . $dd[cat_id] . "' ><u>".$main_icon_edit_img."</u></a> | <a class=lnk href='project.list.php?cat_id=" . $dd[cat_id] . "'><u>View Projects</u></a> | <a class='lnk tip' title='Delete Subcategory' href=\"javascript:if(confirm('DO you want to delete?')){window.location='" . $_SERVER['PHP_SELF'] . "?tid=" . $_GET[tid] . "&cat_id=" . $dd[cat_id] . "&del=1';}\"><u>". $main_icon_del_img."</u></a></td></tr>";
        endwhile;
	endif;	
	$j++;
endwhile;   
?>
</tbody>

    
    
    &nbsp;
<? if($total>20){?>
<table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">

  <tr bgcolor=<?=$light?>><td  align=center ><?=paging($total,20);?></td></tr>

</table>

<? }?>
	
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
<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
if($_GET[del] && $_GET[tid]):
//	echo "select * from " . $prev . "faq where id=" . $_GET[id];
   $r=mysql_query("select * from " . $prev . "faq where id=" . $_GET[tid]);
   if(@mysql_num_rows($r)):
   //echo "aa";
      $msg="<font face=verdana size=1 color=#ffffff><b>You Can't delete.Faq exists in this category.</b></font>";	  
   else:
      $r=mysql_query("delete from " . $prev . "faq_category where id=\"" . $_GET[id] . "\"");
      echo"<script>window.location.href='faqcategory.list.php?tid=" .$_GET[tid]. "';</script>";
   endif;
endif;

?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="faqcategory.list.php">Faq Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Faq Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="faqcategory.list.php" class="header">Faq Category List</a>
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<table width="100%" border="0" align="center" cellspacing="0" bgcolor=silver cellpadding="4" class="table">
<tr bgcolor=<?=$light?> ><td  class=header></td><td align=right ><input type="button" class="button" onClick="javascritp:window.location.href='faqcategory.entryform.php?tid=<?=$_GET[tid]?>&parent_id=0';" value="Add Catgory"></td></tr></table>
<p class="lnk" align="right">&nbsp;
	<?php echo $main_icon_edit_img; ?>&nbsp;= Edit
	&nbsp;|&nbsp;
	<u><img src='images/icon/sub.png' width="20px" height="20px"' border='0'></u>&nbsp;= Add Sub Page
	<u><img src='images/view.png' border='0' height="20" width="20"></u>&nbsp;= View&nbsp;</p>
<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr><td valign=top height=22><b>Category Name</b></td><td valign=top width=25%><b>Sub Category</b></td><td valign=top align=center width=260><b>Action</b></td></tr>
<?
$j=0;$tids=array();
if($_GET[tid]):
  $tids=explode("|",$_GET[tid]);
endif;
$r=mysql_query("select * from " . $prev . "faq_category  where parent_id=0 order by name");
while($d=@mysql_fetch_array($r)):
    if(!($j%2)){$class="even";}else{$class="odd";}
	echo"<tr bgcolor=#ffffff class=even><td height=20>";
	if(in_array($d[id],$tids)):
        echo"<a href='" . $_SERVER[PHP_SELF] . "?tid=". str_replace("|$d[id]|","|",$tid) .  "'\" value='-'><img src='images/box2.png' border=0></a>";
    else:
        echo"<a class='lnk tip' title='Click Here to View Faq subcategory' href='" . $_SERVER[PHP_SELF] . "?tid=". $tid . "|" . $d[id] . "|'\" value='+'><img src='images/box3.png' border=0></a>"; 
    endif;
    echo" <a class=lnk href='faqcategory.entryform.php?tid=" . $_GET[tid] . "&id=" . $d[id] . "'><b>" . $d[name] . "</b></a></td>
	<td align=center >&nbsp;</td>
	<td align=center><a class='lnk tip' title='Edit Faqcategory' href='faqcategory.entryform.php?id=" . $d[id] . "'><u>".$main_icon_edit_img."</u></a> | <a class='lnk tip' title='Add Faqsubcategory' href='faqcategory.entryform.php?parent_id=" . $d[id] . "'><u><img src='images/icon/sub.png' width='20px' height='20px' border='0'></u></a></td></tr>";
    if(in_array($d[id],$tids)):
		//echo "select * from " . $prev . "faq_category where parent_id=" . $d[id] . " order by name";
		$rr=mysql_query("select * from " . $prev . "faq_category where parent_id=" . $d[id] . " order by name");
		$k=0;
		while($dd=mysql_fetch_array($rr)):
	        $rrr=mysql_query("select count(*) as total from " . $prev . "faq where id=" . $dd[id]);
            $total=@mysql_result($rrr,0,"total");
            if(!$total){$total="0";}
		    if(!($k%2)){$class="odd";}else{$class="even";} 
	        echo"<tr bgcolor=#ffffff class=odd>
			<td height=20>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|______________</td>
			<td ><a class=lnk href='faqcategory.entryform.php?parent_id=" .$d[id]. "&id=" . $dd[id] . "'>" . $dd[name] . "</a></td>
			
			<td align=center> <a class='lnk tip' title='Edit Faqsubcategory' href='faqcategory.entryform.php?parent_id=" .$d[id]. "&tid=".$_GET[tid]."&id=" . $dd[id] . "'><u>".$main_icon_edit_img."</u></a> | <a class='lnk tip' title='View Faqsubcategory' href='faq.list.php?faq_cat=" . $dd[id] . "'><u><img src='images/view.png' border='0' height='20' width='20'/></u></a> | <a class='lnk tip' title='Delete Faqsubcategory' href=\"javascript:if(confirm('DO you want to delete?')){window.location='" . $_SERVER['PHP_SELF'] . "?tid=" . $_GET[tid] . "&id=" . $dd[id] . "&del=1';}\"><u><img src='images/icon_del.png' border='0'></u></a></td></tr>";
        endwhile;
	endif;	
	$j++;
endwhile;   
?>
</tbody>
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
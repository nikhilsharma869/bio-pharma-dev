<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
if($_REQUEST[del]):
  $r=mysql_query("delete from " . $prev . "sitemap where id=\"" . $_REQUEST[id] . "\"");
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
                      <li><a href="sitemap.list.php">Sitemap Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Sitemap Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="sitemap.list.php" class="header">Sitemap List</a>&nbsp;&nbsp;&nbsp; 
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<form method=post action="<?=$_SERVER[PHP_SELF]?>">
<table width="100%" border="0" cellspacing="0" bgcolor=silver cellpadding="4" align=center class=table>
<tr bgcolor=<?=$light?>><td class=header>Site Map List</td><td align=right ><input type=button   class=button onClick="javascritp:window.location.href='sitemap.entryform.php';" value="Add Page"></td></tr></table>
<p class="lnk" align="right">
	<?php echo $main_icon_active_img; ?>&nbsp;= Active
	&nbsp;|&nbsp;
	<?php echo $main_icon_inactive_img; ?>&nbsp;= Hidden
	&nbsp;|&nbsp;
	<?php echo $main_icon_edit_img; ?>&nbsp;= Edit
	&nbsp;|&nbsp;
	<?php echo $main_icon_del_img; ?>&nbsp;= Delete
	&nbsp;|&nbsp;
	<u><img src='images/icon/sub.png' border='0' width='25' height='25'></u>&nbsp;= Add Sub Category Page
</p>
<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr><td valign=top><b>Page Name</b></td><td valign=top><b>Sub Page Name</b></td><td valign=top><b>Sub Sub Page Name</b></td><td valign=center><b>Url</b></td><td align="center"><b>Ord.</b></td><td align-center><b>Status</b></td><td valign=top align=center><b>Option</b></td></tr>
<?
$j=0;$tids=array();
if($_GET[tid]):
  $tids=explode("|",$_GET[tid]);
endif;
$j=0;
$r=mysql_query("select * from " . $prev . "sitemap where parent_id=0 order by ord");
while($d=@mysql_fetch_array($r)):
	if($d[status]=="Y"){$status=$main_icon_active_img;}else{$status=$main_icon_inactive_img;} 
    if(!($j%2)){$class="even";}else{$class="odd";}
	$r2=mysql_query("select count(*) as total from " . $prev . "sitemap where parent_id=" . $d[id]);
	$total=@mysql_result($r2,0,"total");
    echo"<tr bgcolor=#ffffff class=" . $class . "><td colspan=3>\n";
	if(!$total):
		echo"<img src='images/box2.png' border=0> \n";
	else:
		if(in_array($d[id],$tids)):
        	echo"<a href='" . $_SERVER[PHP_SELF] . "?tid=". str_replace("|$d[id]|","|",$tid) .  "'\" value='-'><img src='images/box2.png' border=0></a>\n";
    	else:
        	echo"<a class='lnk tip' title='Click here to view Sub sitemap' href='" . $_SERVER[PHP_SELF] . "?tid=". $tid . "|" . $d[id] . "|'\" value='+'><img src='images/box3.png' border=0></a>\n"; 
    	endif;
	endif;
	echo"<a class=lnk href='sitemap.entryform.php?tid=" . $_GET[tid] . "&id=" . $d[id] . "'>" . $d[pagename] . "</a></td><td>" . $d[url] . "</td><td align='center'>" . $d['ord'] . "</td><td>" . $status . "</td>\n";
	echo"<td align=center> <a class='lnk tip' title='Edit Sitemap' href='sitemap.entryform.php?tid=" . $_GET[tid] . "&id=" . $d[id] . "'><u>".$main_icon_edit_img."</u></a> | <a class='lnk tip' title='Delete Sitemap' href=\"javascript:if(confirm('You are deleting `" . $d[name] . "`?')){window.location='sitemap.list.php?tid=" . $_GET[tid] . "&id=" . $d[id] . "&del=1';}\"><u>".$main_icon_del_img."</u></a>";
	echo" | <a class='lnk tip' title='Add Sub Sitemap' href='sitemap.entryform.php?tid=" . $_GET[tid] . "&parent_id=" . $d[id] . "'><u><img src='images/icon/sub.png' width='25' height='25' border='0'></u></a>";
	echo"</td></tr>\n";
	
    if(in_array($d[id],$tids)):
		$rr=mysql_query("select * from " . $prev . "sitemap where parent_id=" . $d[id] . " order by ord");
		$k=0;
		while($dd=@mysql_fetch_array($rr)):
			  if($dd[status]=="Y"){$status="Active";}else{$status="<font color=Red>Hidden</font>";}		      
			  if(!($k%2)){$class="odd";}else{$class="even";}		  
		      echo"<tr bgcolor=#ffffff class=odd><td>&nbsp;|______________</td><td ><a class=lnk href='sitemap.entryform.php?tid=" . $_GET[tid] . "&id=" . $dd[id] . "&parent_id=" . $dd[parent_id] . "'>" . $dd[pagename] . "</a></td><td>&nbsp;</td><td>" . $dd[url] . "</td><td align='center'>" . $dd['ord'] . "</td><td>" . $status . "</td><td align=center> <a class=lnk href='sitemap.entryform.php?tid=" . $_GET[tid] . "&id=" . $dd[id] . "&parent_id=" . $dd[parent_id] . "'><u>Edit</u></a> | <a class=lnk href='sitemap.entryform.php?tid=" . $_GET[tid] . "&parent_id=" . $dd[id] . "'><u>Add Sub Page</u></a> | <a class=lnk href=\"javascript:if(confirm('You are deleting `" . $dd[name] . "`?')){window.location='sitemap.list.php?tid=" . $_GET[tid] . "&id=" . $dd[id] . "&del=1';}\"><u>Delete</u></a> </td></tr>\n";
			  	$r2=mysql_query("select * from " . $prev . "sitemap where parent_id=" . $dd[id] . " order by ord");
				$p=0;
				while($d2=@mysql_fetch_array($r2)):
					  if($dd[status]=="Y"){$status="Active";}else{$status="<font color=Red>Hidden</font>";}		      
					  if(!($p%2)){$class="odd";}else{$class="even";}		  
					  echo"<tr bgcolor=#ffffff class=odd><td>&nbsp;</td><td>&nbsp;|______________</td><td ><a class=lnk href='sitemap.entryform.php?tid=" . $_GET[tid] . "&id=" . $d2[id] . "&parent_id=" . $d2[parent_id] . "'>" . $d2[pagename] . "</a></td><td>" . $d2[url] . "</td><td align='center'>" . $d2['ord'] . "</td><td>" . $status . "</td><td align=center> <a class=lnk href='sitemap.entryform.php?tid=" . $_GET[tid] . "&id=" . $d2[id] . "&parent_id=" . $d2[parent_id] . "'><u>Edit</u></a> | <a class=lnk href=\"javascript:if(confirm('You are deleting `" . $d2[name] . "`?')){window.location='sitemap.list.php?tid=" . $_GET[tid] . "&id=" . $d2[id] . "&del=1';}\"><u>Delete</u></a> </td></tr>\n";
					  $p++;
				endwhile;
			  $k++;
	    endwhile;
		
	endif;	 
	$j++;
endwhile;   
?>
</tbody>
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
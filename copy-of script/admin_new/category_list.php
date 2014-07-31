<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
?>
    <div class="main">
        <?php include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
<?php 

if($_REQUEST['del'] && $_REQUEST['cat_id']!=''){
   
      $r=mysql_query("delete from ".$prev."cats where catid='" . $_REQUEST[cat_id] . "'");
      if($r){
		$msg_succ = "DELETION SUCCESSFULLY DONE...";
	  }
	  else
		$msg_fails ="UNABLE TO DELETE...";
	 
}   
elseif($_REQUEST['del'] && $_REQUEST['subcatid']!=''){
  
  $r=mysql_query("delete from ".$prev."subcats where subcatid='" . $_REQUEST[subcatid] . "'");
  if($r){
	$msg_succ = "DELETION SUCCESSFULLY DONE...";
  }
  else
	$msg_fails ="UNABLE TO DELETE...";
if($msg_succ)
	$msg = $msg_succ;
else
	$msg = $msg_fails;
	?>
	<script>window.location.href='category_list.php?catid=<?=$_REQUEST['p_id']?>&sublist=1&msg=<?=$msg?>';</script>
//redirect("category_list.php?catid=".$_REQUEST['p_id']."&sublist=1&msg=".$msg);
<?php	
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
									<a href="category_list.php" >
									<u>Category List</u>
									</a>
									<?php
									if($_REQUEST['sublist']!='' && $_REQUEST['catid']!='')
									{
										$sql_sub = mysql_fetch_array(mysql_query("select catname from list_cats where catid='".$_REQUEST['catid']."'"));
									
									echo "<b>".ucwords($sql_sub['catname'])."</b>";
									}?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="green"><?=$msg_succ?><?php if(isset($_REQUEST['msg'])) echo $_REQUEST['msg']; ?></font><font color="red"><?=$msg_fails?></font>
									</h4>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
<input type="hidden" name="p_id" value="<?=$_REQUEST['catid']?>">
                                <div class="panel-body">

                                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="dataTable">
                                                                         
                                        <thead>
                                        <tr class="gridcell">
										<?php
										if($_REQUEST['sublist']!='')
										{?>
										<td valign=top><b>Sub Catgory Name</b></td>
										<?php
										}else{
										?>
										<td valign=top><b>Catgory Name</b></td>
										
										<?php
										}?>
                                        	<?php
										if($_REQUEST['sublist']!='')
										{?>
                                        <td valign="top" align="center"><b>Popular Category</b></td>
                                        
                                        <?php
										}
										?>
										
								
                                        <td valign="top" align="center"><b>Icon</b></td>
										<td valign="top" align="center"><b>Position</b></td>
										<td valign="top" align="center"><b>Action</b></td></tr>
                                        </thead>
                                        
                                        <tbody>
<?php


if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}


$r=mysql_query("select count(*) as total from " . $prev . "cats  ");



$total=@mysql_result($r,0,"total");

if(!$total):

   echo"<tr class='lnkred'><td colspan='7' align='center'>No Record Found.</td></tr>";

endif;

$r=mysql_query("select * from " . $prev . "cats ORDER BY catname limit " . ($_REQUEST['limit']-1)*20 . ",20");


	$j=0;		$class="";

if($_REQUEST['catid']!='' && $_REQUEST['sublist']!='')
{
	$r=mysql_query("select * from ".$prev."subcats where catid = '".$_REQUEST['catid']."' order by pos asc");
}
else
{
	$r=mysql_query("select * from ".$prev."cats order by pos asc");
}
if(mysql_num_rows($r)>0)
{
while($d=@mysql_fetch_array($r)){
	
	if($total== 1)
{
		mysql_query("UPDATE ".$prev."cats SET enabled ='1' WHERE 	catid	 = '".$d['catid']."' ");
}

	if($d['icon']!="")
	{
		$image = $d['icon'];
	}
	else
	{
		$image = "images/image_not_found.jpg";
	}
	 

		if(!($j%2)){$class="even";}else{$class="odd";}
	
		if($_REQUEST['catid'])
		{
			echo "<tr bgcolor=#ffffff class='even gridcell'> <td style='font-size:13px;'>";
			echo" <b>" . ucwords($d['subcatname']) . "</b>
			</td>
			<td align=center>";
				if($d['popular_cat']=='1')
		{
			echo  "<font color='#0000FF'><b>Yes</b></font>";
		}
		else{
			echo "<font color='#FF0000'><b>No</b></font>";
		}
		
			echo "</td>
			<td align=center><img src='../".$image."' width='50' height='50' /></td>
			<td align=center>" . $d['pos'] . "</td>
			<td align=center>
				<a class=lnk ";
					//echo"href='#'"; 
					echo"href='add_sub_category.php?id=" . $d['subcatid'] . "&catid=".$d['catid']."'"; 
					echo"><u>".$main_icon_edit_img."</u>
				</a> |  
				
				<a class=lnk"; 
					echo" href=\"javascript:if(confirm('Do you want to Delete `" . $d[subcatname] . "`?')){window.location='" . $_SERVER[PHP_SELF] . "?p_id=".$d['catid']."&sublist=1&subcatid=" . $d['subcatid'] . "&del=1';}\""; 
					//echo" href='#'";
					echo"><u>".$main_icon_del_img."</u>
				</a>
			</td>
		</tr>";
		
		}else{
			echo "<tr bgcolor=#ffffff class='even gridcell'> <td style='font-size:13px;'>";
			echo"  <b>" . ucwords($d['catname']) . "&nbsp;<a class=lnk href='category_list.php?catid=" . $d['catid'] . "&sublist=1'>(SubCategory)</a></b>
						
			</td>
			<td align=center><img src='../".$image."' width='50' height='50' /></td>
			<td align=center>" . $d['pos'] . "</td>
			<td align=center>
				<a class=lnk ";
					//echo"href='#'"; 
					echo"href='add_category.php?id=" . $d['catid'] ."'"; 
					echo"><u>".$main_icon_edit_img."</u>
				</a> |  
				<a class=lnk "; 
					//echo"href='#'"; 
					echo"href='add_sub_category.php?catid=" . $d['catid'] . "'";
					echo"><u>".$main_icon_undersub_img."</u>
				</a> | 
				<a class=lnk"; 
					echo" href=\"javascript:if(confirm('Do you want to Delete `" . $d[catname] . "`?')){window.location='" . $_SERVER[PHP_SELF] . "?cat_id=" . $d['catid'] . "&del=1';}\""; 
					//echo" href='#'";
					echo"><u>".$main_icon_del_img."</u>
				</a>
			</td>
		</tr>";
		}
	
	
				
					
	}
	}
	else
	{
		if($_REQUEST['parent_id'])
			$colspan = 3;
		else
			$colspan = 4;
	?>
	
	<tr ><td colspan="<?=$colspan?>" align="center"><font color="red">No records found</font></td></tr>
	<?php
	}
	?>
    
    
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
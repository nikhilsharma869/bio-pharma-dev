<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
$msg="";
if($_POST[Update]):
   if(!$_REQUEST[status]){$status='Y';}else{$status=$_REQUEST[status];}
   if($_GET['id']==0):
      
	   
	   
	   $r = mysql_query("insert into ".$prev."sitemap 
						
						set `pagename`				=	'".$_POST['pagename']."',
							`status`				=	'".$status."',
							`url`					=	'".$_POST['url']."',
							`parent_id`				=   '".$_POST['parent_id']."',
							`ord`					=	'".$_POST['ord']."',
							`sitemap_desc`			=	'".$_POST['sitemap_desc']."',
							`meta_title`			=	'".$_POST['meta_title']."',
							`meta_keys`				=	'".$_POST['meta_keys']."',
							`meta_desc`				=	'".$_POST['meta_desc']."',
							`target_keywords` 		=	'".$_POST['target_keywords']."'
						
		
	   ");
	   
	 
	   
	   
	   $id=mysql_insert_id();
   else:
       $r=mysql_query("update " . $prev . "sitemap set pagename=\"" . $_REQUEST[pagename] . "\",status=\"" . $status . "\",url=\"" . $_REQUEST[url] . "\",parent_id=\"" . $_REQUEST[parent_id] . "\",ord=\"" . $_REQUEST[ord] . "\",sitemap_desc=\"".$_POST[sitemap_desc]."\",meta_title=\"".$_POST[meta_title]."\",meta_keys=\"".$_POST[meta_keys]."\",meta_desc=\"".$_POST[meta_desc]."\",target_keywords=\"".$_POST[target_keywords]."\" where id=" . $_REQUEST[id]);
	   
	   echo "update " . $prev . "sitemap set pagename=\"" . $_REQUEST[pagename] . "\",status=\"" . $status . "\",url=\"" . $_REQUEST[url] . "\",parent_id=\"" . $_REQUEST[parent_id] . "\",ord=\"" . $_REQUEST[ord] . "\",sitemap_desc=\"".$_POST[sitemap_desc]."\",title=\"".$_POST[title]."\",meta_keys=\"".$_POST[meta_keys]."\",meta_desc=\"".$_POST[meta_desc]."\",target_keywords=\"".$_POST[target_keywords]."\" where id=" . $_REQUEST[id];
   endif;
   if($r):
       $msg="<font face=verdana size=1 color=#ffffff><b>Update Successful.</b></font>";
       echo"<script>window.location.href='sitemap.list.php';</script>";
   else:
       $msg="<font face=verdana size=1 color=#ffffff><b>Update Failure.</b></font>";
   endif;		
elseif($DELT):   
      $r=mysql_query("delete from " . $prev . "sitemap where cat_id=\"" . $cat_id . "\"");
      echo"<script>window.location.href='category.list.php?tid=" . $_POST[tid] . "';</script>";  
endif;
if($_REQUEST[id]){$id=$_REQUEST[id];}
if($id && !$_REQUEST[DELT]):
   $r=mysql_query("select * from  " . $prev . "sitemap where id=" . $id);
   $d=@mysql_fetch_array($r);
endif;
if(!$d[status]){$d[status]="Y";}
?>


    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="sitemap.list.php">Sitemap Lists</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Sitemap Add Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='membership_plan_list.php' class="header">&nbsp;Sitemap :</a>&nbsp;&nbsp;<?=$data[membership_name]?> <?=$msg?>
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<br />

<form method="post" action="<?=$_SERVER['PHP_SELF']?>?id=<?=$_REQUEST['id']?>">
<input type="hidden" name="parent_id" value=<?=$_REQUEST[parent_id]?>>
<input type="hidden" name="id" value="<?=$_REQUEST[id]?>">
<input type="hidden" name="tid" value="<?=$_REQUEST[tid]?>">
<table width="100%" border="0" cellspacing="1" bgcolor="#e5e5e5" cellpadding="4" align="center" class="table">
<tr bgcolor="<?=$light?>" >
		<td  class=header  height=18><a href='sitemap.list.php' class="header">Site Map Management</a> >  </td>
	</tr></table><br>
<table width="100%" border="0" align="center" cellpadding=3 cellspacing=1 bgcolor="<?=$light?>" class="table">
<tr class="header"><td height=25 colspan=2 class="header"><b>Add/Modify <? if($d[parent_id]==0){echo"Site Map";}else{echo "Site Map Sub";}?> Page: <?=$d["pagename"]?></b></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top><? if($d[parent_id]==0){echo"Page";}else{echo "Sub Page";}?> Name</td><td><input type="text" style='width:400px;' name="pagename" value="<?=$d[pagename]?>" class=lnk></td></tr>

<tr class=lnk bgcolor=#ffffff><td valign=top>Title</td><td><input type="text" style='width:400px' name="meta_title" value="<?=$d[title]?>" class=lnk></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Meta Keys</td><td><textarea style='width:400px;height:50px' name="meta_keys" class=lnk><?=$d[meta_keys]?></textarea></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Meta Description</td><td><textarea style='width:400px;height:100px' name="meta_desc" class=lnk><?=$d[meta_desc]?></textarea></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Target Keywords</td><td><textarea style='width:400px;height:50px' name=target_keywords class=lnk><?=$d[target_keywords]?></textarea></td></tr>


<tr class=lnk bgcolor=#ffffff><td valign=top>Url</td><td><input type="text" style='width:400px;height:20px' name="url" value="<?=$d[url]?>" class=lnk></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Desc. <br>[<span class="lnkred">Only for Programmer</span>]</td><td><textarea style='width:400px;height:50px' name="sitemap_desc" class=lnk><?=$d[sitemap_desc]?></textarea></td></tr>
<tr class=lnk bgcolor=#ffffff><td valign=top>Order No.</td><td><input type="text" size=10 name="ord" value="<?=$d[ord]?>" class=lnk></td></tr>
<tr bgcolor=#ffffff class=lnk><td>Status</td><td ><input type=radio name=status value="Y" <? if($d["status"]=="Y"){echo" checked";}?> >Online <input type=radio name=status value="N" <? if($d["status"]=="N"){echo" checked";}?>> Offline </td></tr>
<tr><td align=center  colspan=2><input type="submit" name="Update" value="Update" class="button">&nbsp;&nbsp;<input type="submit" name="DELT" value="Delete" class="button">&nbsp;&nbsp;<input type="Button"  value="Back" onClick="JavaScript:window.location.href='sitemap.list.php';" class="button">&nbsp;&nbsp;<Blnk><?=$msg?></Blnk></td></tr>
</table><br>
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
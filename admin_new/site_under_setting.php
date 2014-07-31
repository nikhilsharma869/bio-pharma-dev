<?php
include("includes/header_dashbord.php");
include("includes/access.php");
$light2="#666666";
$light="#b7b5b5";

if($_POST[SBMT_REG]):

$maintenance_desc=htmlentities($_POST[maintenance_desc]);
   $r=mysql_query("update  " . $prev . "setting set 
   				
				maintenance_msg=\"" . $_REQUEST['maintenance_msg'] . "\",
				
				maintenance_desc=\"" . $maintenance_desc. "\",
				
				maintenance_status=\"" . $_REQUEST['maintenance_status'] . "\"
				
				where id=\"" . $_POST[id] . "\"");			
				


   if($r):


      $msg="Update Successful";


   else:


      $msg="Update Failure.";


   endif;	  


endif;


    $r=mysql_query("select * from " . $prev . "setting where id='1'");


    $d=@mysql_fetch_array($r);


	$class="lnk";


    ?>
	<script>
function display_alert()
  {
  alert("No update! It's a demo version.!!");
  }
</script>

<div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		

        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Site Under Setting</h1>
                    </div>
					
					        <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='site_under_setting.php' class="header">&nbsp;Site Under Setting</a>&nbsp;&nbsp;<?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
            
        
     <table border="0" align=center cellpadding="4" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="table"> 
    <tr bgcolor=<?=$light?>>
    	<td  height="20" align="center" <? if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}?>>
    	<a  href='site.setting.php' class=<?=$class?>>Site Setting</a>
        </td>
    	<td align=center <? if(substr_count($_SERVER[PHP_SELF],"account_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='account_setting.php' class=<?=$class?>>Account Setting</a>
        </td>
    	<td align=center <? if(substr_count($_SERVER[PHP_SELF],"transfer_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='transfer_setting.php' class=<?=$class?>>Transfer Setting</a>
        <td height="20" width="25%" align=center <?php if(substr_count($_SERVER[PHP_SELF],"site_under_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href="site_under_setting.php" class=<?=$class?>>Site Under Maintainance</a></td>
        </td>
    </tr>
    </table>
	
	
	<form name=register method=post action="" onSubmit="javscript:return ValidSet(this);">
	<input type="hidden" name="id" id="id" value="<?=$d['id']?>" />

    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?>>
		<tr bgcolor=#ffffff class=lnk>
			<td valign=top><b>Show messege :</b></td>
			<td><input type=text class=lnk name="maintenance_msg" value="<?=$d['maintenance_msg']?>" size=40></td>
		</tr>
		
		<!--<tr bgcolor=#ffffff class=lnk>
			<td valign=top width="25%"><b>Show description :</b></td>
			<td><textarea cols="37" rows="6" name="maintenance_desc" id="maintenance_desc"><?=$d['maintenance_desc']?></textarea></td>
		</tr>-->
		
		<tr bgcolor="#ffffff" class="lnk">
		<td  valign="top" colspan="2"><b>Show description :</b></td>
	</tr>

	<tr  bgcolor="#ffffff" class="lnk">
	<td colspan="2">
	<?php
	include_once '../ckeditor/ckeditor.php';
	include_once '../ckfinder/ckfinder.php';
	$ckeditor = new CKEditor();
	$ckeditor->basePath = '../ckeditor/';
	$ckfinder = new CKFinder();
	$ckfinder->BasePath = '../ckfinder/';
	$ckfinder->SetupCKEditorObject($ckeditor);
	echo $ckeditor->editor('maintenance_desc',html_entity_decode($d["maintenance_desc"]));

	?>
	</td>
	</tr>
		
		<tr bgcolor=#ffffff class=lnk>
			<td valign=top width="25%" colspan="2"><b>If site is Under Maintenance?Check here and update.</b><input type="checkbox" name="maintenance_status" id="maintenance_status" value="1" <?php if($d['maintenance_status']=='1'){?> checked="checked" <?php }?> /></td>
		</tr>
		
		<tr bgcolor=<?=$light?>>
			<td>&nbsp;</td>
			<td height=25 align="left"><input type=submit class="button" name='SBMT_REG' value='Update'></td>
		</tr>
	</table>
	</form>
	

</div>
</div>
</div>
</div>
			
			</div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div>


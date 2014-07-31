<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
				<!-----calender script add------>

<script src="calendar_new/js/jscal2.js" type="text/javascript"></script>
<script src="calendar_new/js/lang/en.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="calendar_new/css/jscal2.css" />

	<link type="text/css" rel="stylesheet" href="calendar_new/css/border-radius.css" />

	<link type="text/css" rel="stylesheet" href="calendar_new/css/steel/steel.css" />
    
	
	
	<!----calender script end----->

<script src="js/jquery.genyxAdmin.js"></script>
<script>
function Validsubadmin()
{
if(document.getElementById('countryname').value.search(/\S/)==-1)
	{
		alert("Please enter Country");
		document.getElementById('countryname').focus();
		return false;
	}
	
	if(document.getElementById('pos').value.search(/\S/)==-1)
	{
		alert("Please enter Position");
		document.getElementById('pos').focus();
		return false;
	}
}
</script>



<?php
$msg="";
$error="";
if(isset($_POST['Update']))
{
	   if($_GET['id']==0)
   {
     // 		countryid	countryname	pos	enabled	timestamp	icon
			
			$r = mysql_query("insert into ".$prev."countries set
			countryname = '".$_REQUEST['countryname']."',
			pos = '".$_REQUEST['pos']."',
			enabled = '".$_REQUEST['enabled']."',
			timestamp = NOW()");
			
			
		$succ=mysql_query($r);
		$id=mysql_insert_id();
		
   }
   
   else
   {
   
    
			$r = mysql_query("update ".$prev."countries set
			countryname = '".$_REQUEST['countryname']."',
			pos = '".$_REQUEST['pos']."',
			enabled = '".$_REQUEST['enabled']."'
			where countryid='".$_REQUEST['id']."'
			");
			
			$id=$_REQUEST[id];
				
			
		  $succ=mysql_query($r);
		  $id=$_POST['id'];
    
   }
   
   if($id)
   {
      $t=time();
	  $file_name=$_FILES['filename']['name'];
	  $tmp_name=$_FILES['filename']['tmp_name'];
	  if($file_name!='')
	  {
	      $ext=end(explode(".",$file_name));
		  if($ext=="jpeg" || $ext=="jpg" || $ext=="png")
		  {
		    $newname=$t.".".$ext;
		    $path = "country_flag/".$newname;
			if(move_uploaded_file($tmp_name,$path))
			{
			
  /*****check image if exisit delete it and update new image***/
			  $getimg=mysql_query("select `icon` from ".$prev."countries  where countryid='".$id."'
			  ");
			  $img_get=mysql_fetch_array($getimg);
			  $picture=$img_get['icon'];
			  if($picture!='')
			  {
			    @unlink("../".$picture);
				
			  }
 /*****check image if exisit delete it and update new image***/
			
			
						$r="UPDATE ".$prev."countries SET icon='".$path."' WHERE countryid='".$id."'";
						$succ=mysql_query($r);
						
			}
		  
		  }
		  
		  else
		  {
		    $delete=mysql_query("delete from ".$prev."countries where countryid='".$id."'");
		    $error='<div class="alert alert-error">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <strong><i class="icon24 i-close-4"></i>Warning!</strong> Update Failure .
                            </div>';
							
							
		  
		  }
	  
	  }
	  
	   
	  
   }

   if($r)
    {
		$msg="<font face=verdana size=2 color=green><b>Update Successful.</b></font>";
	}
   else
    {
	   $msg="<font face=verdana size=2 color=red><b>Update Failure.</b></font>";
	}   
   
   if($succ && $error=='')
   {
   
   ?>
   
   <script>
  function newDoc()
  {
  window.location.assign("country_list.php")
  }
   window.setTimeout("newDoc()",2000);
   </script>
 <?
      $msg = '<div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <strong><i class="icon24 i-checkmark-circle"></i>Successfully!</strong> Saved your records.
                            </div>';
							
							
	   
   
   }
   
   
 
  
}




?>


<?php
if($_GET['id']):
$sql=mysql_query("select * from ".$prev."countries where countryid='".$_GET['id']."'");
$d=mysql_fetch_array($sql);

endif;
?>






        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="country_list.php">Country Management</a></li>
                      <li class="active">Add Country</li>
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Country Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>Add Main Country</h4>&nbsp; &nbsp; <?php if($msg){echo  $msg ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
                                <form id="countryForm" name="countryForm" action="" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" onsubmit="return Validsubadmin();">
                                
                                    <!-------hidden fields---------->
                                    <input type="hidden" name="id" value="<?=$d['id']?>" />
                                    
                                    <!-------hidden fields---------->
                             
								
										<div class="form-group">
											<label class="col-lg-2 control-label" for="required">Country  <span style="color:red;">*</span></label>
											<div class="col-lg-6">
											<input type="text" id="countryname" name="countryname" value="<?=$d['countryname']?>"  class="form-control">
											</div>
                                        </div> 
										<input type="hidden" id="id" name="id" value="<?=$_REQUEST['id']?>"  class="form-control">
										<div class="form-group">
											<label class="col-lg-2 control-label" for="required">Flag  <span>&nbsp;</span></label>
											<div class="col-lg-6">
											<input type="file" id="filename" name="filename" class="form-control">&nbsp;&nbsp;
                                            
                                                     <?		                                       
                                        if($d['icon'])
										{
                                        
                                        ?>
                                                                         
                                        <img src="<?=$d[icon]; ?>" height="20" width="23" />
                                       <? 
									   } 
									 ?>
											</div>
                                        </div>
										
										<!-- End .control-group  -->
										
										
											<div class="form-group">
											<label class="col-lg-2 control-label" for="required">Position <span style="color:red;">*</span></label>
											<div class="col-lg-6">
											<input type="text" id="pos" name="pos" value="<?=$d['pos']?>"  class="form-control">

											</div>
                                        </div> 
                                
										<div class="form-group">
                                        <label class="col-lg-2 control-label" for="required">Status  <span>&nbsp;</span></label>
                                        <div class="col-lg-6">
                                        <input type="radio" name="enabled"  checked="checked" value="1" <? if($d["enabled"]=="1"){echo" checked";}?> >Online
                                         <input type="radio" name="enabled" value="0" <? if($d["enabled"]=="0"){echo" checked";}?>> Offline</td>
                                        </div>
                                        </div>
                                
                                
                                    <!-- End .control-group  -->
                                        
                                        <div class="form-group">
                                        <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                        <button type="submit" class="btn btn-primary" name="Update"  id="loginBtn">SAVE</button>
                                     <?php if(!$_REQUEST[id]){?>   <button type="reset" class="btn btn-warning" name="">CANCEL</button> <? } ?>
                                        <button type="button" class="btn btn-inverse" onClick="javascript:window.location.href='country_list.php'">BACK</button>
                                        </div>
                                        </div>
                                        </div><!-- End .form-group  -->
                                
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
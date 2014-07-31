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
if(document.getElementById('catname').value.search(/\S/)==-1)
	{
		alert("Please enter Category Name");
		document.getElementById('catname').focus();
		return false;
	}
	if(document.getElementById('pos').value.search(/\S/)==-1)
	{
		alert("Please enter position value");
		document.getElementById('pos').focus();
		return false;
	}
	var z=document.getElementById('pos').value;
		if(isNaN(z)||z.indexOf(" ")!=-1)
		    {
				alert("Please enter position as number.");
				return false;
			}

}

</script>

<?php 
	$msg="";
	if(isset($_POST['Update'])){
		 

			if($_GET['id']== 0){
			
			$r = mysql_query("insert into ".$prev."cats set
			catname = '".$_REQUEST['catname']."',
			pos = '".$_REQUEST['pos']."',
			enabled = '".$_REQUEST['enabled']."',
			timestamp = NOW()");
			
			
			$id = mysql_insert_id();
			}else{
			
			$r = mysql_query("update ".$prev."cats set
			catname = '".$_REQUEST['catname']."',
			pos = '".$_REQUEST['pos']."',
			enabled = '".$_REQUEST['enabled']."'
			where catid='".$_GET['id']."'
			");
			
			$id=$_POST[id];
				
			}	
			if($id){
				if($_FILES['filename']['name']!=''){
					$ext_allow = array('jpg','jpeg','png','gif');
					$temp = explode(".",$_FILES['filename']['name']);
					
					$ext = end($temp);
					if(in_array($ext,$ext_allow)){
						$new_name = "category_images/".$id.".".$ext;
						move_uploaded_file($_FILES['filename']['tmp_name'],'../'.$new_name);
						
						$update = mysql_query("update ".$prev."cats set icon = '".$new_name."' where catid='".$id."'");
						
					
					}
				}	
			}
		

			if($r){
				$msg="<font face=verdana size=2 color=green><b>Update Successful.</b></font>";
				
			}
			else{
			  $msg="<font face=verdana size=2 color=red><b>Update Failure.</b></font>";
			}
			
		
					
	
	}
	
	
				
	
	//if(!$d["enabled"]){$d["enabled"]="1";}
	
	
?>


<?php 

if($_GET['id']){
	
	$r=mysql_query("SELECT * FROM  ".$prev."cats WHERE catid='".$_GET['id']."'");
	$d=mysql_fetch_array($r);
	
	}
?>
        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="category_list.php">Category Management</a></li>
                      <li class="active">Add Category</li>
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Category Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="category_list.php"><u>Category List</u></a>&nbsp;
									Add/Edit Main Category
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
                                <form id="myForm" action="" class="form-horizontal" role="form" method="post" onsubmit="return Validsubadmin();" enctype="multipart/form-data">
                             
								<input type="hidden" id="id" name="id" value="<?=$d['catid']?>"  class="form-control">
										<div class="form-group">
											<label class="col-lg-2 control-label" for="required">Category Name <span style="color:red;">*</span></label>
											<div class="col-lg-6">
											<input type="text" id="catname" name="catname" value="<?=$d['catname']?>"  class="form-control">
											</div>
                                        </div> 
										
										<div class="form-group">
											<label class="col-lg-2 control-label" for="required">Icon </label>
											<div class="col-lg-6">
											<?php
											if($d['icon']!=''){
											?>
											<img src="../<?=$d['icon']?>" width="80" height="80"><br/><br/>
											<?php
											}?>
											<input type="file" id="filename" name="filename" class="form-control">
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
                                        <label class="col-lg-2 control-label" for="required">Status</label>
                                        <div class="col-lg-6">
                                        <input type="radio" name="enabled"  checked="checked" value="1" <?if($d["enabled"]=="1"){echo" checked";}?> >Online <input type="radio" name="enabled" value="0" <?if($d["enabled"]=="0"){echo" checked";}?>> Offline</td>
                                        </div>
                                        </div>
                                
                                
                                    <!-- End .control-group  -->
                                        
                                        <div class="form-group">
                                        <div class="col-lg-offset-2">
                                        <div class="pad-left15">
                                        <button type="submit" class="btn btn-primary" name="Update"  id="loginBtn">SAVE</button>
                                    
                                        <button type="button" class="btn btn-inverse" onClick="javascript:window.location.href='category_list.php'">BACK</button>
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
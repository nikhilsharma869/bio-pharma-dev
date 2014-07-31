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
?>
<script src="calendar_new/js/jscal2.js" type="text/javascript"></script>
<script src="calendar_new/js/lang/en.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="calendar_new/css/jscal2.css" />

	<link type="text/css" rel="stylesheet" href="calendar_new/css/border-radius.css" />

	<link type="text/css" rel="stylesheet" href="calendar_new/css/steel/steel.css" />
    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
<!--- Validation-------->
<script>
$(document).ready(function()
{ 
alert("hi");	
$( "#validate" ).validate({
rules: {
name: {
required: true

},
status: {
required: true

}
},

messages: {
name: {
required: "Please Enter Alarm Name "
},
status: {
required: "Please Select Radio Button"

},
}
});

});
</script>


<!----------- validation ------------->        

<script language="javascript" type="text/javascript">
<!--
function Validpersonal(register)
{
    var txt="";
	 if(!register.p_id.value)
	{
		txt+="     Personnel ID should not be empty.\n"
	}
	if(!register.sname.value)
	{
		txt+="     Surname should not be empty.\n"
	}
		if(!register.fname.value)
	{
		txt+="     Frst name should not be empty.\n"
	}
			if(!register.e_contact.value)
	{
		txt+="     Contact no should not be empty.\n"
	}
	

   	if(txt)
	{
   		alert("Sorry!! Following errors has been occured :\n\n"+ txt +"\n     Please Check");
  	 	return false
	}
    return true
}
  
</script>	   
<?
if($_GET[del]):

   $image_path=base64_decode($_GET[img_file]);	

   $r=mysql_query("update " . $prev . "personnel set personnel_pic = '' WHERE id='" . $_GET[id] ."'");

  if($r && $image_path) {
  unlink('../'.$image_path);}
endif;

?>



<?php
$msg= "";
if(isset($_POST['SBMT_REG'])){
    
	if(!$_POST['status']){$status="Y";}else{$status=$_POST['status'];}
	for($i=1;$i<=8;$i++)
	{
	 $checkbox .= $_POST['p_add'.$i].",";
	}
   	if($_POST['id'])
	 {
   		$r=mysql_query("UPDATE " . $prev . "personnel SET
		               `p_id` = '".$_POST['p_id']."',
					   `sname` = '".$_POST['sname']."',
					   `fname` = '".$_POST['fname']."',
					   `mname` = '".$_POST['mname']."',
					   `licence_no` = '".$_POST['licence_no']."',
					   `d_contact` = '".$_POST['d_contact']."',
					   `d_guarantor` = '".$_POST['d_guarantor']."',
					   `date` = '".$_POST['date']."',
					   `e_contact` = '".$_POST['e_contact']."',
					   `g_contact` = '".$_POST['g_contact']."',
					   `p_add` = '".rtrim($checkbox,', ')."',
					   `status` = '".$_POST['status']."' WHERE `id` = " . $_POST['id']);
		$id=$_POST['id'];
				if($_SESSION['admin_id']!='' && $_SESSION['admin_type']=='A'){
				loghistory($_SESSION['admin_id'],'Driver update<br /> id : '.$id.'<br />URL :<a href='.$vpath.'admincp/personnel_entry.php?id='.$id.'>'.$vpath."admincp/personnel_entry.php?id=".$id.'</a>');
			}

 	 }
	else
	 {
		$r=mysql_query("INSERT INTO " . $prev . "personnel SET
		               `p_id` = '".$_POST['p_id']."',
					   `sname` = '".$_POST['sname']."',
					   `fname` = '".$_POST['fname']."',
					   `mname` = '".$_POST['mname']."',
					   	`admin_id`=\"".$_SESSION['admin_id']."\",
			            `user_type`=\"".$_SESSION['admin_type']."\",
					   `licence_no` = '".$_POST['licence_no']."',
					   `d_contact` = '".$_POST['d_contact']."',
					   `d_guarantor` = '".$_POST['d_guarantor']."',
					   `date` = '".$_POST['date']."',
					   `e_contact` = '".$_POST['e_contact']."',
					   `g_contact` = '".$_POST['g_contact']."',
					   `p_add` = '".rtrim($checkbox,', ')."',
					   `status` = '".$_POST['status']."'");
		$id=mysql_insert_id();
				if($_SESSION['admin_id']!='' && $_SESSION['admin_type']=='A'){
				loghistory($_SESSION['admin_id'],'Driver Add id : '.$id.'<br /><a href='.$vpath.'admincp/personnel_entry.php?id='.$id.'>'.$vpath."admincp/personnel_entry.php?id=".$id.'</a>');
			}

	}
			if($r){
				    if($_FILES['pic']['name']!="")
					 {
	                  $ty=explode("/",$_FILES['pic']['type']);
	                  $ext=$ty[1];
		 	          // $ext=substr($_FILES[pic][name],-3,3);
			          if($ext=="jpg" || $ext=="jpeg" || $ext=="png" || $ext=="gif")
					   {
			            move_uploaded_file($_FILES['pic']['tmp_name'],"../images/personnel_" . $id . "." . $ext);
                        mysql_query("UPDATE " . $prev . "personnel SET personnel_pic = 'personnel_" . $id . "." . $ext . "' WHERE id=" . $id);
								if($_SESSION['admin_id']!='' && $_SESSION['admin_type']=='A'){
				            loghistory($_SESSION['admin_id'],'Driver image update');
			}
			               }
			         }
				
			?>
			 <script>
       function newDoc()
       {
       window.location.assign("personnel_list.php")
       }
       window.setTimeout("newDoc()",2000);
       </script>
			<?php
			 $msg = '<div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">×</button>
                                <strong><i class="icon24 i-checkmark-circle"></i>Successfully!</strong> saved your records.
                            </div>';
			
			}
			
}
if($_REQUEST['id'])
{ 
 $id=$_REQUEST['id'];
}
elseif($_REQUEST['id1'])
{
 $id=$_REQUEST['id1'];	
}


if($id):
if($_SESSION['admin_type']=='S'){
	$r=mysql_query("SELECT * FROM " . $prev . "personnel WHERE `id` = " . $id);
	}else {
	$r=mysql_query("SELECT * FROM " . $prev . "personnel WHERE admin_id='".$_SESSION['admin_id']."' AND user_type='".$_SESSION['admin_type']."' AND `id` = " . $id);
	}
   	$d=@mysql_fetch_array($r);

endif;

if(!$d['status']){$d['status']="Y";}

?>



       
        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="personnel_list.php">Personnel Management</a></li>
                      <li class="active">Add New Personnel</li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Personnel Management</h1>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>Add New Personnel</h4> &nbsp; &nbsp; <?php if($msg){echo  $msg ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
                                                                
                                <form method='post' name="validate" id="validate" action="" enctype="multipart/form-data" onSubmit="javascript:return Validpersonal(this);">>
<input type="hidden" name="id" value="<?=$d['id']?>">
    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="dataTable">
    <tr>
		<td valign="top" width="25%"><b>Personnel ID </b><span style="color:red;">*</span></td>
		<td width="75%"><input type="text" name='p_id' id="p_id"  size="30" value="<?=$d['p_id']?>" style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
	</tr>
    
	<tr>
		<td valign="top" width="25%"><b>Personnel Name </b> <span style="color:red;">*</span></td>
		<td width="75%">
         <input type="text" name='sname' id="sname"  size="10" value="<?=$d['sname']?>" style="width:25%;" <?php if($_GET['id1']){print 'readonly';}?> placeholder="Surname">
         <input type="text" name='fname' id="fname"  size="10" value="<?=$d['fname']?>" style="width:25%;" <?php if($_GET['id1']){print 'readonly';}?> placeholder="Firstname">
         <input type="text" name='mname' id="mname"  size="10" value="<?=$d['mname']?>" style="width:25%;" <?php if($_GET['id1']){print 'readonly';}?> placeholder="Middlename">
        </td>
	</tr>
    
    <tr>
        <td valign="top" width="25%"><b>Picture</b></td>
        <td width="75%">  
<?
  if($d['personnel_pic']!='' && file_exists("../images/".$d['personnel_pic']))
   {
	echo @resize("../images/". $d['personnel_pic'],100);
	if(!$_GET['id1']){
	echo "<br><a class=lnk  href=\"javascript:if(confirm('Are you sure you want to delete `".$d[personnel_pic]."`?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&del=1&img_file=".base64_encode("images/".$d[personnel_pic])."';}\">Remove Image</a><br><br> ";}
   }
  if($_GET['id1']){ }else{ 
?>
           <input type="file" name="pic" class="lnk" size="20">
<? } ?>
         </td>
   </tr>
   
   <tr>
		<td valign="top" width="25%"><b>Driver's License Number</b></td>
		<td width="75%"><input type="text" name='licence_no' id="licence_no"  size="30" value="<?=$d['licence_no']?>" style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
   </tr>
   
   <tr>
		<td valign="top" width="25%"><b>Driver's Contact</b></td>
		<td width="75%"><input type="text" name='d_contact' id="d_contact"  size="30" value="<?=$d['d_contact']?>" style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
   </tr>
   
   <tr>
		<td valign="top" width="25%"><b>Driver's Guarantor</b></td>
		<td width="75%"><input type="text" name='d_guarantor' id="d_guarantor"  size="30" value="<?=$d['d_guarantor']?>" style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
   </tr>
   
   <tr>
		<td valign="top" width="25%"><b>License Expiry Date</b></td>
		<td width="75%">
		<input type="text" name='date' id="date"  size="30" value="<?=$d['date']?>" Style="width:150px; float:left;" class="form-control" readonly >
		<img src="calendar_new/cal.gif" name="f_trigger_d1" id="f_trigger_d1" style="cursor:pointer;padding-left:10px; float:left;" title="From Date selector" alt="calender" border="0" align="absmiddle"  width="30"/></td>
   </tr>
   
   																				
<script type="text/javascript">
				
				var cal = Calendar.setup({
				
				   showTime      : 12,



				   onSelect: function(cal) { cal.hide(),cal.focus()



				    }



				 });



			     cal.manageFields("f_trigger_d1", "date", "%Y-%m-%d");



			     



				  </script>
   
   <tr>
		<td valign="top" width="25%"><b>Emergency Contact</b> <span style="color:red;">*</span></td>
		<td width="75%"><input type="text" name='e_contact' id="e_contact"  size="30" value="<?=$d['e_contact']?>" style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
   </tr>
   
   <tr>
		<td valign="top" width="25%"><b>Guarantor's Contact</b></td>
		<td width="75%"><input type="text" name='g_contact' id="g_contact"  size="30" value="<?=$d['g_contact']?>" style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
   </tr>
   
   <tr>
        <td valign="top" width="25%"><b>Proficiency Setting</b></td>
        <td>
<? 
  $query = mysql_query("SELECT id,prof_name FROM ".$prev."proficiency WHERE status = 'Y'");
  while($query_fetch = mysql_fetch_array($query))
   {
?>
                  <input type="checkbox" name="p_add<?=$query_fetch['id']?>" value="<?=$query_fetch['id']?>" class="chk_bokx" <? if (strpos($d['p_add'],$query_fetch['id']) !== false){echo"checked";} if($_GET['id1']){?> disabled="disabled"<? } ?>>  <?=$query_fetch['prof_name']?><br />
                
<? } ?>
        </td>
        

        
   </tr>
	<tr bgcolor="#ffffff" class="lnk">
		<td valign="top" width="25%"><b>Status</b></td>
		<td>
			<input name="status" type="radio" value='Y' <? if($d['status']=="Y"){echo"checked";} if($_GET['id1']){?> disabled="disabled"<? } ?>>Online
			<input type="radio" name="status" value='N' <? if($d['status']=="N"){echo"checked";} if($_GET['id1']){?> disabled="disabled"<? } ?>>Offline
		</td>
	</tr>
	<tr><td colspan="2" height="20" align="center" >
	<?php
	if($_REQUEST['id'])
	{
	?>
		<input type="submit"  name='SBMT_REG' value='Update' class="btn btn-primary" >
	<?php
	}
	elseif($_REQUEST['id1'])
	{
	?>
    <?
	}
	else
	{
	?>
		<input type="submit"  name='SBMT_REG' value='Add' class="btn btn-primary"  >
        <button type="reset" class="btn btn-warning" name="">CANCEL</button>
	<?php
	}
	?>
     <button type="button" class="btn btn-inverse" onClick="javascript:window.location.href='personnel_list.php'">BACK</button></td></tr>
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
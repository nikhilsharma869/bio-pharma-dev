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
if(document.getElementById('countryid').value.search(/\S/)==-1)
	{
		alert("Please select Country");
		document.getElementById('countryid').focus();
		return false;
	}
	
if(document.getElementById('cityid').value.search(/\S/)==-1)
	{
		alert("Please select State");
		document.getElementById('cityid').focus();
		return false;
	}

if(document.getElementById('areaname').value.search(/\S/)==-1)
	{
		alert("Please enter City");
		document.getElementById('areaname').focus();
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
  if($_GET['id1']=='')
   {
			$r = mysql_query("insert into ".$prev."areas set
			areaname = '".$_REQUEST['areaname']."',
			countryid = '".$_REQUEST['countryid']."',
			cityid = '".$_REQUEST['cityid']."',
			pos = '".$_REQUEST['pos']."',
			enabled = '".$_REQUEST['enabled']."',
			timestamp = NOW()");
			
			
		$succ=mysql_query($r);
		$id=mysql_insert_id();
			
			
			
   }
  
   else
   {
//	areaid	areaname	cityid	pos	enabled	timestamp	 
	 // areas
			$r = mysql_query("update ".$prev."areas set
			areaname = '".$_REQUEST['areaname']."',
			countryid = '".$_REQUEST['countryid']."',
			cityid = '".$_REQUEST['cityid']."',
			pos = '".$_REQUEST['pos']."',
			enabled = '".$_REQUEST['enabled']."'
			where areaid='".$_REQUEST['id1']."'
			");
			
			$id=$_REQUEST[id];
				
			
		  $succ=mysql_query($r);
		  $id=$_POST['id1']; 
		
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
  window.location.assign("city_list.php")
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
if($_GET['id1']):
$sql=mysql_query("select * from ".$prev."areas where areaid='".$_GET['id1']."'");
$d=mysql_fetch_array($sql);

endif;
?>

<?php
if($_GET['cid']):
$sql=mysql_query("select * from ".$prev."cities where cityid='".$_GET['cid']."'");
$d=mysql_fetch_array($sql);

endif;
?>




<!-----small cms validation start-------->







<script type="text/javascript">

    function statename() {

        var el = document.getElementById('countryid').value;
        //var territory_id = getSelectValues(el);
        $.ajax({
            type: "POST",
            url: "names.php",
            beforeSend: function() {

            },
            data: "state_id=" + el,
            success: function(msg) {
                $("#messagerep").html(msg);
            }
        });

    }

</script>

<!------------small cms validation end---->
        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="city_list.php">City Management</a></li>
                      <li class="active">Add City</li>
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>City Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>Add Main City</h4>&nbsp; &nbsp; <?php if($msg){echo  $msg ;} ?> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
                                <form id="cityForm" name="cityForm" action="" class="form-horizontal" role="form" method="post" onsubmit="return Validsubadmin();" enctype="multipart/form-data">
                                
                                    <!-------hidden fields---------->
                                    <input type="hidden" name="id" value="<?=$d['id']?>" />
                                    
                                    <!-------hidden fields---------->
                                      
                                      <div class="form-group">
                                        <label class="col-lg-2 control-label" for="required">Country  <span style="color:red;">*</span></label>
                                        <div class="col-lg-6">
                                        <select name="countryid" id="countryid" onclick="statename()">
                                        
                                        <option value="">Select Country</option>
                                        <?php
                                        $events=mysql_query("select countryid,countryname from ".$prev."countries ");
                                        $count=mysql_num_rows($events);
                                        
                                        while($events_row=mysql_fetch_assoc($events))
                                        {
                                        ?>
                                        <option value="<?=$events_row['countryid']?>" <? if($d['countryid']==$events_row['countryid']): echo "selected"; endif;?>><?=$events_row['countryname']?></option>
                                        <? }?>
                                        </select>
                                        </div>
                                        </div>
                                      
                                      
                                      
								
                                        <div class="form-group">
                                        <label class="col-lg-2 control-label" for="required">State  <span style="color:red;">*</span></label>
                                        <?php 
										if($_REQUEST['id1'])
										 {
										?>
                                        <div class="col-lg-6">
                                        <select name="cityid" id="cityid">
                                        
                                        <option value="">Select State</option>
                                        <?php
                                        $events=mysql_query("select cityid,cityname from ".$prev."cities ");
                                        $count=mysql_num_rows($events);
                                        
                                        while($events_row=mysql_fetch_assoc($events))
                                        {
                                        ?>
                                        <option value="<?=$events_row['cityid']?>" <? if($d['cityid']==$events_row['cityid']): echo "selected"; endif;?>><?=$events_row['cityname']?></option>
                                        <? }?>
                                        </select>
                                        </div>
                                        <?php 
										 }else{
										?>
                                        <div class="col-lg-6" id="messagerep"></div>
                                        <?php } ?>
                                        </div> 
										
										<div class="form-group">
											<label class="col-lg-2 control-label" for="required">City  <span style="color:red;">*</span></label>
											<div class="col-lg-6">
											<input type="text" id="areaname" name="areaname" value="<?=$d['areaname']?>"  class="form-control">
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
                                        <button type="button" class="btn btn-inverse" onClick="javascript:window.location.href='city_list.php'">BACK</button>
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
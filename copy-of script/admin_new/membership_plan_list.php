<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

?>
<?php
$msg='';      
if($_GET[del]){

$r=mysql_query("delete from " . $prev . "membership_plan where id=" . $_GET[id]);

if($r){
	?>

   <script>
   function newDoc()
   {
   window.location.assign("membership_plan_list.php")
   }
   window.setTimeout("newDoc()",2000);
   </script>
<?
$msg= '<strong>Successfully !</strong> Delete your records.';
		}
   }




if($_REQUEST['limit'])
	{
		$page = $_REQUEST['limit'];
	}
	else
	{
		$page = 1;
	}
	
	
$r=mysql_query("select count(*) as total from ".$prev."membership_plan ");
$total=@mysql_result($r,0,"total");



?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="membership_plan.php">Membership Plan Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Membership Plan Management</h1>
                  
				   </div>
<p align="right">
<button class="btn btn-default" type="button" onClick="javascript:window.location.href='add_new_membership.php'">Add New Membership</button>
</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="membership_plan.php" class="header">Membership Plan</a>&nbsp;&nbsp;&nbsp; (<?=$total?>)
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<!--<table width="100%" style="border:1px solid #999999;" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor=<?=$light?> class="table">
<tr bgcolor="#b7b5b5"><td width="47%" height="25" class=header><a href="membership_plan.php" class="header">Membership Plan</a>&nbsp;&nbsp;&nbsp; (<?=$total?>)
</td>
</tr></table>-->
<br />

<table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<thead>
<tr height="30">
	<td width="18%"><b>Plan Name </b></td>
	<td width="15%"><b>Plan Price </b></td>
	<td align="center"><b>No of Skill </b></td>
	<td align="center"><b>No of Bids </b></td>
	<td align="center"><b>No of Portfolio </b></td>
    <td align="center"><b>Days</b></td>
    <td align="center"><b>Status</b></td>
	<td width="10%" align="center"><b>Actions</b></td>
	</tr>
</thead><tbody>
	<?php
	$r=mysql_query("select * from  ".$prev."membership_plan limit " . ($page-1)*1 . ",5" );
	
	$j=0;
	
	while($d=@mysql_fetch_array($r)) 
		
		{
		
			if(!($j % 2)){$class="even";}else{$class="odd";}
		?>
	
	<tr class=<?=$class?> height="25">
	
		<td width="5%"><?php echo $d['name']; ?></td>
	
		<td width="18%"><?php echo "$"." ".$d['price']; ?></td>
	
		<td align="center"><?php echo $d['skills']; ?></td>
		
		<td align="center"><?php echo $d['bids']; ?></td>
		
		<td align="center"><?php echo $d['portfolio']; ?></td>
        
        
        <td align="center"><?php echo $d['date']; ?>	
        	<? 
/*		$now = time(); // or your date as well
     $your_date = strtotime($d['date']);
     $datediff = $your_date - $now;
     $date =  floor($datediff/(60*60*24));
	 echo $date." "."days";*/
		?> </td>
        
        <td align="center"><?php if ($d['status']=='Y'){ echo "<font color='green'>Active</font>"; } else{ echo "<font color='red'>Inactive</font>"; } ?></td>
		
		<td width="18%" align="center">
        <a class='lnk  tip' title='Edit Membership' href="add_new_membership.php?id=<?php echo $d['id']; ?>"><?=$main_icon_edit_img?></a> | 
		
       <a href="javascript:if(confirm('Do you want to Delete `<?=$d['name']?>`?')){window.location='<?=$_SERVER['PHP_SELF']?>?id=<?=$d['id']?>&del=1';}" class='lnk  tip' title='Delete Membership'><?=$main_icon_del_img?>
				</a></td>
	</tr>
	<?php
	
	$j++;
	
	}
	
	?>
</tbody>
</table>
         

<?
if($total>5):
?>
  <table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
  <tr bgcolor=<?=$light?>><td  align=center ><? echo paging($total,5)?></td></tr></table>
<?
endif;
?>



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
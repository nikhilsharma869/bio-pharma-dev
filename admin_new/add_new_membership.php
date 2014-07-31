<?php 

include("includes/header_dashbord.php");
include("includes/access.php");


$id = $_REQUEST['id'];
if(isset($_POST['SBMT']))

	{
		if($id){
			$r = "update ".$prev."membership_plan set 
		name='".mysql_real_escape_string($_POST[membership_name])."',
		price='".mysql_real_escape_string($_POST[price])."',
		skills='".mysql_real_escape_string($_POST[skills])."',
		bids='".mysql_real_escape_string($_POST[bids])."',
		portfolio='".mysql_real_escape_string($_POST[portfolio])."',
		date='".mysql_real_escape_string($_POST[days])."',
		status='".$_POST[status]."'
		where id= '".$id."'";
		$query=mysql_query($r);
		}
		else{
			$r = "insert ".$prev."membership_plan set 
		name='".mysql_real_escape_string($_POST[membership_name])."',
		price='".mysql_real_escape_string($_POST[price])."',
		skills='".mysql_real_escape_string($_POST[skills])."',
		bids='".mysql_real_escape_string($_POST[bids])."',
		portfolio='".mysql_real_escape_string($_POST[portfolio])."',
		date='".mysql_real_escape_string($_POST[days])."',
		status='".$_POST[status]."'";
		
	
			$query=mysql_query($r);
			
		
		}
		
		
   if($query )
   {
   
   ?>
   
   <script>
  function newDoc()
  {
  window.location.assign("membership_plan_list.php")
  }
   window.setTimeout("newDoc()",1000);
   </script>
 <?
      $msg = '<strong >Update Successfully !</strong> Saved your records.';
							
							
	   
   
       }
	  

	}

$r=mysql_query("select * from  ".$prev."membership_plan where id=".$_GET['id']);

$data=@mysql_fetch_array($r);

?>


    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


 

 
 
 
 
 
<!-------------------------- VALIDATION START ---------------------------------------------------->


<style>
.span{
color:red;
margin-left:5px;
}

</style>


<script>

function validateForm() {
    var x = document.forms["frm1"]["membership_name"].value;
    if (x == null || x == "") {
        alert("Plan Name must be filled out");
		document.forms["frm1"]["membership_name"].focus();
        return false;
    }
	
	
	var y = document.forms["frm1"]["price"].value;
    if (y == null || y == "") {
        alert("Price Field must be filled out");
		document.forms["frm1"]["price"].focus();
        return false;
    }
	
	var z = document.forms["frm1"]["days"].value;
    if (z == null || z == "") {
        alert("days Field must be filled out");
		document.forms["frm1"]["days"].focus();
        return false;
    }
}


</script>



<!-------------------------- VALIDATION END  ------------------------------------------------------>
 
 
 
 
        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="membership_plan_list.php">Membership Plan Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Membership Plan Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='membership_plan_list.php' class="header">&nbsp;Membership Plan:</a>&nbsp;&nbsp;<?=$data[membership_name]?> <?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<br />

<form action="" method="post" id="frm1" name="frm1" onsubmit="return validateForm()">

<table width="100%" border="0" cellspacing="1" bgcolor="#e5e5e5" style="border:1px solid #999999;" cellpadding="4" align="center" class="table">

<tr class="header" bgcolor=<?=$light?>>
	
	<td class="header"><b> Add/Edit Member Plan : </b></td>

	<td class="header"><b>  </b></td>

</tr>

	<tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Plan Name<span class="span">*</span> </b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="membership_name" id="membership_name" size=25 class=lnk  value="<?=$data[name]?>"></td>

	</tr>

	<tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Price <span class="span">*</span></b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="price" id="price" size=25 class=lnk  value="<?=$data[price]?>"></td>

	</tr>

	<tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left width=30%><b>Skill</b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="skills" id="skills" size=25 class=lnk  value="<?=$data[skills]?>"></td>

	</tr>

	<tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Bids</b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="bids" id="bids"  size=25 class=lnk  value="<?=$data[bids]?>"></td>

	</tr>

	<tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Portfolio</b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="portfolio" id="portfolio"  size=25 class=lnk  value="<?=$data[portfolio]?>"></td>

	</tr>
    
    <tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Days<span class="span">*</span></b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top>
       

        <input type="text" id="days" name="days"  size="15" style="margin-right: 6px;"value="<?php echo $data['date'];?>" />Days
     <? 
/*		$now = time(); // or your date as well
     $your_date = strtotime($_POST['date']);
     $datediff = $your_date - $now;
     $date =  floor($datediff/(60*60*24));
	 echo $date." "."days";
*/		?>      </td>         

	</tr>
    
    <tr class=lnk bgcolor=#ffffff>

		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Status</b></td>

		<td style="border-bottom:dotted 1px #e5e5e5" valign=top>
       <input type="radio" name="status" value="Y" <? if($data['status']=="Y"){ echo "checked" ; } ?>/>
	&nbsp;Active&nbsp;
	<input type="radio" name="status" value="N" <? if($data['status']=="N"){ echo "checked"; } ?>/>
	&nbsp;Inactive</td>

	</tr>

	<tr bgcolor="#e5e5e5">

		<td>* Fields are Mandatory</td>

		<td align=left>

	      <input type="submit" name="SBMT"  class="button" value="Update">

	      &nbsp;

	      <input type="button"  class="button" value="Back" onClick="javascript:window.location.href='membership_plan_list.php'">

		</td>

	</tr>

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
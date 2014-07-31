<?php 
include("includes/header_dashbord.php");
include("includes/access.php");

require_once("country.php");
#counter ========================================================================================	


#========================================================================================
if($_REQUEST[SBMT]):
$sql = "INSERT INTO ".$prev."transactions set
details = 'Fund added by admin',
user_id = '".$_POST['user_id']."',
amount = '".$_POST[amount]."',
add_date = now(),
balance = '".$_POST[amount]."',
date2 = '".time()."',
paypaltran_id = '".rand()."',
status = 'Y', amttype = 'CR'";
$r=mysql_query($sql);
if($r){

 $txt="<b><font color='#325f25'>Fund added successful</font></b>";?>
	  <meta http-equiv="refresh" content="2;URL=member.list.php">

	<?php 
   }else{
       $txt="<b><font color='red'>Error in fund add</font></b>";
   }
endif;
if($_REQUEST[user_id]):
    $rr   = mysql_query("select * from ".$prev."user  where user_id=".$_REQUEST[user_id]);
    $data = mysql_fetch_array($rr);
endif;
if($txt){echo"<p align=center class=lnk>" . $txt . "</p>";}

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_REQUEST[user_id]."' and status = 'Y' and amttype='CR'"));
			
			$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_REQUEST[user_id]."' and status = 'Y' and amttype='DR'"));
			
			$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
?>
<script language="javascript" type="text/javascript">
function isEmail(emailstr) {
	var dotchar = emailstr.indexOf(".");
	var atchar = emailstr.indexOf("@");
	var dotlast = emailstr.lastIndexOf(".");
	var spacechar = emailstr.indexOf(" ");
	var len = emailstr.length;
	if( (dotchar == -1) || (atchar == -1) || (spacechar != -1) || (dotlast < atchar) || (dotlast == len - 1) ) {
		return false;
	}
	else {
		return true;
	}
}

function validate(){
	if(document.getElementById('username').value==''){
		alert("Please Specify user name.");
		document.getElementById('username').focus();
		return false;
	}
	if(document.getElementById('password').value==''){
		alert("Please Specify password.");
		document.getElementById('password').focus();
		return false;
	}
	if(!isEmail(document.getElementById('email').value)){
		alert("Please Specify Valid Email.");
		document.getElementById('email').focus();
		return false;
	}
	if(document.getElementById('fname').value==''){
		alert("Please Specify First Name.");
		document.getElementById('fname').focus();
		return false;
	}
	if(document.getElementById('lname').value==''){
		alert("Please Specify Last Name.");
		document.getElementById('lname').focus();
		return false;
	}
	if(document.getElementById('country').value==''){
		alert("Please Specify country name.");
		document.getElementById('country').focus();
		return false;
	}
}
</script>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
				<!-----calender script add------>

	<!----calender script end----->



<!-----small cms validation start-------->


<!------------small cms validation end---->
        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="member.list.php">Member Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Member Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4><a href='member.list.php' class="header">&nbsp;Member :</a> <?=$data[fname]?>&nbsp;<?=$data[lname]?></h4>&nbsp; &nbsp; <?php if($msg){echo  $msg ;} ?> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<br>

<form name="frmuser" method=post action="<?=$_SERVER[PHP_SELF]?>" enctype='multipart/form-data' onSubmit="return validate();" />
<input type=hidden name="user_id" value="<?=$_REQUEST[user_id]?>">

		
<table width="100%" border="0" cellspacing="1" bgcolor="#e5e5e5" style="border:1px solid #999999;" cellpadding="4" align="center" class="table">

<tr class="header" bgcolor=<?=$light?>>

	<td class="header" height="30"><b>Add Fund To : </b><?=$data[fname]?>&nbsp;<?=$data[lname]?></td>
	
	<td class="header"><b>Current Balance $ <?=$balsum?>  </b></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Amount </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=number name="amount" id="amount" size=25 class=lnk  value=""></td>
	</tr>

	
	
	
	<tr bgcolor=#e5e5e5>
		<td></td>
		<td align=left>
	      <input type="submit" name="SBMT"  class="button" value="Update">
	      &nbsp;
	      <input type="button"  class="button" value="Back" onClick="javascript:window.location.href='member.list.php'">
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
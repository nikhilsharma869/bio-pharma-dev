<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

?>



    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="escrow.list.php">Fund Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Fund Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='escrow.list.php' class="header">&nbsp;Fund Management</a>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<br />


<? 
if($_REQUEST[escrow_id]):



    $r=mysql_query("select * from " . $prev . "escrow where escrow_id=" . $_REQUEST[escrow_id]);



    $d=@mysql_fetch_array($r);

	

	$rs = mysql_fetch_array(mysql_query("SELECT ".$prev."projects . * FROM ".$prev."projects, ".$prev."buyer_bids WHERE ".$prev."projects.id = ".$prev."buyer_bids.project_id AND ".$prev."buyer_bids.id ='".$d[bidid]."'"));



endif;

if($_REQUEST[SBMT])

{

		$rw1 = mysql_query("select * from ".$prev."escrow where escrow_id = '".$_POST['escrow_id']."' and (status = 'P' or status = 'D')");

		if(mysql_num_rows($rw1)>0)

		{

			$rw3 = mysql_fetch_array($rw1);

			$rw2 = mysql_query("update ".$prev."escrow set status = 'Y' ,released_by ='admin', release_reason='".$_POST[reason]."' where escrow_id = '".$_POST['escrow_id']."'");

			if($rw2)

			{

				$payment_id = rand(1000,9999).time();

				$rw4 = mysql_query("insert into ".$prev."transactions set 

				details = 'Milestone Payment Transfer',

				user_id = '".$rw3['bidder_id']."',

				balance = '".$rw3['amount']."',

				add_date = now(),

				date2 = '".time()."',

				paypaltran_id = '".$payment_id."',

				status = 'Y',amttype = 'CR'");

				if($rw4)

				{

					mysql_query("insert into ".$prev."notification set 

					user_id = '".$rw3['bidder_id']."',

					message = 'Milestone payment deposited in your account',

					date = now()");

					mysql_query("insert into ".$prev."notification set 

					user_id = '".$rw3['user_id']."',

					message = 'Milestone payment released to contractor',

					date = now()");

					$rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id ='".$rw3['bidder_id']."'"));

					$rw6 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw3['user_id']."'"));

					$rw7 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$_POST['hidep']."'"));

					$res2=mysql_query("select * from ".$prev."mailsetup where mail_type=\"registration\"");

					$row=mysql_fetch_array($res2);

					$to  = $rw5['email'];

					$subject = 'Milestone Payment Deposited';

					$message = '

					<html>

					<head>

					  <title>oOfficework Notification</title>

					</head>

					<body>

						<p>&nbsp;</p>

						<table cellpadding="0" cellspacing="0" border="0" width="100%">

						<tbody>

							<tr>

								<td>'.html_entity_decode($row['header']).'</td>

							</tr>

						</tbody>

						</table>

					<br />

					Hi '.ucwords($rw5['fname']).',<br />

					<br />

					<p>Recently a milestone payment is deposited in your account by ADMIN.</p>

					<table>

					<tr>

						<td>For the Project :</td>

						<td>&nbsp;</td>

						<td>'.ucwords($rw7['project']).'</td>

					</tr>

					<tr>

						<td>Employer Name :</td>

						<td>&nbsp;</td>

						<td>'.ucwords($rw6['fname']).' '.ucwords($rw6['lname']).'</td>

					</tr>

					<tr>

						<td>Amount :</td>

						<td>&nbsp;</td>

						<td>$'.$rw3['amount'].'&nbsp;(USD)</td>

					</tr>

					<tr>

						<td>Reason :</td>

						<td>&nbsp;</td>

						<td>'.$_POST['reason'].'</td>

					</tr>

					</table>

					<p>Please contact Customer Support if you did not authorize this change.</p>

			

					<p>Thanks,</p>

					<p>oOfficework Support</p>

					<br />

					'.html_entity_decode($row['footer']).'

					</body>

					</html>';

					//print $message;die();

					$headers  = 'MIME-Version: 1.0' . "\r\n";

					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					mail($to, $subject, $message, $headers);

					$to1  = $rw6['email'];

					$subject1 = 'Milestone Payment Withdrawn';

					$message1 = '

					<html>

					<head>

					  <title>oOfficework Notification</title>

					</head>

					<body>

						<p>&nbsp;</p>

						<table cellpadding="0" cellspacing="0" border="0" width="100%">

						<tbody>

							<tr>

								<td>'.html_entity_decode($row['header']).'</td>

							</tr>

						</tbody>

						</table>

					<br />

					Hi '.ucwords($rw6['fname']).',<br />

					<br />

					<p>Recently a milestone payment is withdrawn from your account by ADMIN and paid to Contractor.</p>

					<table>

					<tr>

						<td>For the Project :</td>

						<td>&nbsp;</td>

						<td>'.ucwords($rw7['project']).'</td>

					</tr>

					<tr>

						<td>Contractor Name :</td>

						<td>&nbsp;</td>

						<td>'.ucwords($rw5['fname']).' '.ucwords($rw5['lname']).'</td>

					</tr>

					<tr>

						<td>Amount :</td>

						<td>&nbsp;</td>

						<td>$'.$rw3['amount'].'&nbsp;(USD)</td>

					</tr>

					<tr>

						<td>Reason :</td>

						<td>&nbsp;</td>

						<td>'.$_POST['reason'].'</td>

					</tr>

					</table>

					<p>Please contact Customer Support if you did not authorize this change.</p>

			

					<p>Thanks,</p>

					<p>oOfficework Support</p>

					<br />

					'.html_entity_decode($row['footer']).'

					</body>

					</html>';

					//print $message;die();

					$headers  = 'MIME-Version: 1.0' . "\r\n";

					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

					mail($to1, $subject1, $message1, $headers);

				}

			}

		}		

}				        

if(!$_POST[SBMT_REG])

{

?>

<form method="post" action="<?=$_SERVER['PHP_SELF']?>" onsubmit="return ValidEditor();">

<input type="hidden" name="escrow_id" value="<?=$_REQUEST[escrow_id]?>">

<input type="hidden" name="hidep" value="<?php print $rs[id]?>">

<table width="100%" border="0" align="center" cellspacing="1" cellpadding="4" class="table table-striped table-bordered table-hover" id="dataTable">

<tr class=header>

	<td height=30 colspan="2">

    	<a href="escrow.list.php" class="header"><b><u>Escrow  Management</u></b></a> > <? echo"<u>Release to <strong>" . getusername($d[bidder_id]) . "</strong> Account</u >";?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Amount : <strong><?php print'$ '.$d[amount];?>&nbsp;&nbsp;(USD)</strong>

    </td>

</tr>

<tr bgcolor="#ffffff" class="lnk">

	<td ><strong>Reason</strong></td>

	<td width="80%"><textarea name='reason' id='reason'  cols=60  rows=5><?php if(($d[released_by]=='admin')) { print $d[release_reason]; }?></textarea></td>

</tr>

<tr>

	<td></td>

    <td height=20 ><input type="submit"   name='SBMT' value='Release' class= lnk <?php if($d[status]=='Y'||$d[status]=='C') { ?> disabled="disabled"<?php }?> >&nbsp;

    <input type="button" value="Back" onClick="javascript:window.location.href='escrow.list.php'"></td>

</tr>

</table>

</form>

<? }?>
<script language="javascript" type="text/javascript">
function ValidEditor()
{
 var iChars = "!@#$%^&*()+=-_[]\\\'`~;,./{}|\":<>?";
 var reason = document.getElementById('reason').value.substring(0,1);
 if(document.getElementById('reason').value==''){
  alert("Please enter reason .");
  document.getElementById('reason').focus();
  return false;
 }
 if(!isNaN(document.getElementById('reason').value)){
  alert("Please specify valid reason.");
  document.getElementById('reason').focus();
  return false;
 }
 if(!isNaN(document.getElementById('reason').value.substring(0,1)))
 {
  alert('Reason cannot start with a number');
  document.getElementById('reason').focus();
  return false;
 }
 if(iChars.indexOf(reason) != -1)
 {
  alert ("Reason cannot start with special characters");
  document.getElementById('reason').focus();
  return false;
 }
 
 return true;
 
}

</script>

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
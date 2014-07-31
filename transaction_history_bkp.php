<?php 

include "includes/header.php";

CheckLogin();

?>

<?php

$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$row=mysql_fetch_array($res);

$res1=mysql_query("select * from ".$prev."projects where user_id='".$_SESSION['user_id']."'");

$row1=mysql_fetch_array($res1);

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));

$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));

$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);

$sum=0;

$res4pend=mysql_query("select * from ".$prev."escrow where bidder_id='".$_SESSION['user_id']."' and status='P'");

while($row4pend=mysql_fetch_array($res4pend))

{

	$sum+=$row4pend['amount'];

}

$sum1=number_format($sum,2);

?>



<link rel="stylesheet" href="<?=$vpath?>jquery/jquery-ui-1/development-bundle/themes/base/jquery.ui.all.css">

	<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/jquery-1.6.2.js"></script>

	<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>

	<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>

	<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>

	<script>

	$(function() {

		$( "#datepicker_from" ).datepicker({

			showOn: "button",

			buttonImage: "<?=$vpath?>images/caln.png",

			buttonImageOnly: true

		});

	});

	$(function() {

		$( "#datepicker_to" ).datepicker({

			showOn: "button",

			buttonImage: "<?=$vpath?>images/caln.png",

			buttonImageOnly: true

		});

	});

	</script>


<!-----------Header End-----------------------------> 



<!-- content-->
<div class="browse_contract">
  <!--Profile-->
  <?php include 'includes/leftpanel1.php';?>
  <!-- left side-->
  <!--middle -->
  <div class="profile_right">
  
    <div id="wrapper_3">
      <div class="balence"><span>Balance :</span> $ <?php print $balsum;?></div>
      <!--<ul>

		<li ><a href="profile.php">Update Profile</a></li>

		<li ><a href="select-expertise.php">Update Expertise</a></li>

		<li><a href="upload-portfolio.php">Update Portfoolio</a></li>
		
	</ul>-->
	
    
            	
	 <ul class="tabs">      
			<li ><a href="<?=$vpath?>payment/dsp/" >Deposit Funds</a></li>
			<li><a href="<?=$vpath?>milestone.html" >Milestone</a></li>
			<li ><a  href="<?=$vpath?>withdraw.html" >Withdraw Fund</a></li>
			<li ><a class="selected" href="<?=$vpath?>transaction_history.html" >Transaction History</a></li>
		</ul>
		
		<div class="browse_tab-content"> 
            <div class="browse_job_middle">

      <table cellpadding="0" cellspacing="0" border="0" width="100%" align = "center" >

        <!--------------------------------------Middle Body------------------------------------------------->
        <tr >
          <td><!-------------------------------------------------------------------------------------------->
              <form action="" method="post" name="acount_activity_form" id="acount_activity_form">
                <table width="100%" cellpadding="8" cellspacing="0" border="0">
                  <tbody>
				  <tr class="tbl_bg_4"><td colspan="5">Select date for which you want your transaction history</td></tr>
                    <tr class="tbl_bg3">
                      <td>From :</td>
                      <td><input type="text" name="from_txt" id="datepicker_from" readonly="" size="10" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['from_txt'];?>"<?php }?>/>
                      </td>
                      <td>To :</td>
                      <td><input type="text" name="to_txt" id="datepicker_to" readonly="" size="10" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['to_txt'];?>"<?php }?>/>
                      </td>

                      <td><input type="submit" name="sub_go" value="Go" class="submit_bott" style="width:40px; height:30px;" />
                      </td>
                    </tr>
                  </tbody>
                </table>
              </form>
            <!----------------------------------------------------------------------------------------------------------->
          </td>
        </tr>
        <tr>
          <td><!----------------------------------------------------------------------------------------------------------->
              <?php

$tranbalance = number_format(0.00, 2);

if(isset($_POST['sub_go'])&&$_POST['sub_go']=='Go')

{

		$restrnid1 = mysql_query("SELECT * FROM ".$prev."transactions WHERE user_id = '".$_SESSION['user_id']."' and substring( add_date, 1, 10 ) < '".$_POST['from_txt']."' order by add_date");

	if(mysql_num_rows($restrnid1)>0)

	{

		while($rowtrnid1 = mysql_fetch_array($restrnid1))

		{

			if(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='CR'))

			{

				$tranbalance = number_format(($tranbalance + doubleval($rowtrnid1['balance'])),2);

			}

			elseif(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='DR'))

			{

				$tranbalance = number_format(($tranbalance - doubleval($rowtrnid1['balance'])),2);

			}

		}

	}

?>
              <table cellpadding="8" cellspacing="0" width="100%" border="0">
                <tbody>
                  <tr class="tbl_bg2">
                    <td ><strong>Statement Period:</strong></td>
                    <td ><em><?php print date('d M y',strtotime($_POST['from_txt']));?> to <?php print date('d M y',strtotime($_POST['to_txt']));?></em> </td>
                  </tr>
                  <tr class="tbl_bg2">
                    <td ><strong>Beginning Balance:</strong></td>
                    <td > $<?php print $tranbalance;?> </td>
                  </tr>
                  <?php

$totaldeb = number_format(0.00, 2);

$totalcred = number_format(0.00, 2);

$restrnid = mysql_query("SELECT * FROM ".$prev."transactions WHERE user_id = '".$_SESSION['user_id']."' and (substring( add_date, 1, 10 ) >= '".$_POST['from_txt']."' and substring( add_date, 1, 10 )<= '".$_POST['to_txt']."') order by add_date");

	if(mysql_num_rows($restrnid)>0)

	{

		while($rowtrnid = mysql_fetch_array($restrnid))

		{

			if(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='CR'))

			{

				$tranbalance = number_format(($tranbalance + doubleval($rowtrnid['balance'])),2);

				$totalcred = number_format(($totalcred + doubleval($rowtrnid['balance'])), 2);

			}

			elseif(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='DR'))

			{

				$tranbalance = number_format(($tranbalance - doubleval($rowtrnid['balance'])),2);

				$totaldeb = number_format(($totaldeb + doubleval($rowtrnid['balance'])), 2);

			}

        }

    }

?>
                  <tr class="tbl_bg2">
                    <td style="text-align:left;"><strong>Total Debits:</strong></td>
                    <td style="text-align:left;">$<?php print $totaldeb;?></td>
                  </tr>
                  <tr class="tbl_bg2">
                    <td style="text-align:left;"><strong>Total Credits:</strong></td>
                    <td style="text-align:left;">$<?php print $totalcred;?></td>
                  </tr>
                  <tr class="tbl_bg2">
                    <td style="text-align:left;border-top:2px solid #2f5b67;"><strong>Ending Balance:</strong></td>
                    <td style="text-align:left;border-top:2px solid #2f5b67;"> $<?php print $tranbalance;?> </td>
                  </tr>
                </tbody>
              </table>
            <?php 

	}

	else

	{

?>
              <table cellpadding="8" width="100%" cellspacing="0" border="0">
                <tr class="tbl_bg2">
                  <td><strong>Statement Period:</strong></td>
                  <td><em>&nbsp;</em></td>
                </tr>
                <tr class="tbl_bg2">
                  <td ><strong>Beginning Balance:</strong></td>
                  <td >&nbsp;</td>
                </tr>
                <tr class="tbl_bg2">
                  <td style="text-align:left;"><strong>Total Debits:</strong></td>
                  <td style="text-align:left;">&nbsp;</td>
                </tr>
                <tr class="tbl_bg2">
                  <td style="text-align:left;"><strong>Total Credits:</strong></td>
                  <td style="text-align:left;">&nbsp;</td>
                </tr>
                <tr class="tbl_bg2">
                  <td ><strong>Ending Balance:</strong></td>
                  <td>&nbsp;</td>
                </tr>
              </table>
            <?php

	}

?>
              <!----------------------------------------------------------------------------------------------------------->
          </td>
        </tr>
        <!------------------------------------------------Middle Body End---------------------------------------------------------->
      </table>
      <!------------------------------------------------MIDDLE DIV END------------------------------------------------------------>
      <!--end middle-->
      <!-- rightside-->
      <!-- end rightside-->
      <!---------------------------------------------------------------------------------------------------------------------------->
  <hr />
        <table width="100%" cellpadding="8" cellspacing="0" border="0">

          <tbody>
		   <tr class="tbl_bg2"><td colspan="7"><h2 style="padding-left:10px;">Transaction Details</h2></td></tr>
            <tr class="tbl_bg_4">
              <td>Date</td>
              <td>Transaction ID</td>
              <td>Description</td>
              <td>Credit/Debit</td>
              <td>Status</td>
              <td style="text-align: right;">Amount</td>
              <td style="text-align: right;">Balance</td>
            </tr>
            <?php

$tranbalance = 0;

if(isset($_POST['sub_go'])&&$_POST['sub_go']=='Go')

{

	$restrnid1 = mysql_query("SELECT * FROM ".$prev."transactions WHERE user_id = '".$_SESSION['user_id']."' and substring( add_date, 1, 10 ) < '".$_POST['from_txt']."' order by add_date");

	if(mysql_num_rows($restrnid1)>0)

	{

		while($rowtrnid1 = mysql_fetch_array($restrnid1))

		{

			if(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='CR'))

			{

				$tranbalance = number_format(($tranbalance + doubleval($rowtrnid1['balance'])),2);

			}

			elseif(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='DR'))

			{

				$tranbalance = number_format(($tranbalance - doubleval($rowtrnid1['balance'])),2);

			}

		}

	}

	$restrnid = mysql_query("SELECT * FROM ".$prev."transactions WHERE user_id = '".$_SESSION['user_id']."' and (substring( add_date, 1, 10 ) >= '".$_POST['from_txt']."' and substring( add_date, 1, 10 )<= '".$_POST['to_txt']."') order by add_date");

	if(mysql_num_rows($restrnid)>0)

	{

		while($rowtrnid = mysql_fetch_array($restrnid))

		{

			if(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='CR'))

			{

				$tranbalance = number_format(($tranbalance + doubleval($rowtrnid['balance'])),2);

			}

			elseif(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='DR'))

			{

				$tranbalance = number_format(($tranbalance - doubleval($rowtrnid['balance'])),2);

			}

?>
            <tr class="tbl_bg2">
              <td><?php print date('d-m-Y H:i:s',strtotime($rowtrnid['add_date']));?></td>
              <td><?php print $rowtrnid['paypaltran_id'];?></td>
              <td><?php print $rowtrnid['details'];?></td>
              <!--<td><?php //print $receivernm;?></td>-->
              <td><?php print $rowtrnid['amttype'];?></td>
              <td><?php if($rowtrnid['status']=='P'){print "<font color='#FF0000'><b>Pending</b></font>";}elseif($rowtrnid['status']=='Y'){print "<font color='#009900'><b>Completed</b></font>";}?></td>
              <td style="text-align: right;">$<?php print $rowtrnid['balance'];?></td>
              <td style="text-align: right;">$<?php print $tranbalance;?></td>
            </tr>
            <?php

		}

	}

	else

	{

?>
            <tr class="tbl_bg2">
              <td colspan="7" align="center"><strong>No transactions meet your selected criteria</strong></td>
            </tr>
            <?php

	}

}

?>
          </tbody>
        </table>
   </div>
  
   
<!---------------------------------------------------------------------------------------------------------------------------->
    </div>
  </div>
  <!--end content-->
</div>

</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?>


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
<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.core.js"></script>
<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.widget.js"></script>
<script src="<?=$vpath?>jquery/jquery-ui-1/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
  $(function() {
    $( "#datepicker_from" ).datepicker({
			showOn: "button",
			buttonImage: "<?=$vpath?>css/img/calender_icon.png",
			buttonImageOnly: true
		});
	});

	$(function() {
		$( "#datepicker_to" ).datepicker({
			showOn: "button",
			buttonImage: "<?=$vpath?>css/img/calender_icon.png",
			buttonImageOnly: true
		});
	});
</script>
<div class="spage-container">
  <div class="main_div2">
    <div class="inner-middle"> 
      <?php include 'includes/dashboard_menu.php';?>

      <div class="profile_right">
        <div class="select-date-form">
          <form action="" method="post" name="acount_activity_form" id="acount_activity_form">
            <span class="s-span-period"><?=$lang['FROM_H']?>:</span>
            <div class="s-period-date">              
              <input type="text" name="from_txt" id="datepicker_from" readonly="" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['from_txt'];?>"<?php }?>/>
            </div>
            <span class="s-span-period"><?=$lang['TO']?> :</span>
            <div class="s-period-date">
              <input type="text" name="to_txt" id="datepicker_to" readonly="" style="margin-right: 6px;" <?php if(isset($_POST['sub_go'])){?> value="<?php print $_POST['to_txt'];?>"<?php }?>/>
            </div>
            <input class="btn-submit-period btn-custom-blue" type="submit" name="sub_go" value="<?=$lang['GO']?>" />
          </form>
        </div>

        <div class="table-transaction-detail">
          <table width="100%" cellpadding="8" cellspacing="0" border="0">
            <tbody>
              <tr class="tbl_bg_4">
                <td><?=$lang['MESSAGE_DT']?></td>
                <td><?=$lang['TRANSACTION_ID']?></td>
                <td><?=$lang['DESCRIPTION']?></td>
                <td><?=$lang['CREDIT_DEBIT']?></td>
                <td style="text-align:center"><?=$lang['STATUS']?></td>
                <td style="text-align: right;"><?=$lang['AMOUNT']?></td>
                <td style="text-align: right;"><?=$lang['BALANCE']?></td>
              </tr>
            <?php
            $tranbalance = 0;
            if(isset($_POST['sub_go'])&&$_POST['sub_go']=='Go') {
              $restrnid1 = mysql_query("SELECT * FROM ".$prev."transactions WHERE user_id = '".$_SESSION['user_id']."' and substring( add_date, 1, 10 ) < '".$_POST['from_txt']."' order by add_date");
              if(mysql_num_rows($restrnid1)>0) {
                while($rowtrnid1 = mysql_fetch_array($restrnid1)) {
                  if(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='CR')) {
                    $tranbalance = number_format(($tranbalance + doubleval($rowtrnid1['balance'])),2);
                  } elseif(($rowtrnid1['status']=='Y')&&($rowtrnid1['amttype']=='DR')) {
                    $tranbalance = number_format(($tranbalance - doubleval($rowtrnid1['balance'])),2);
                  }
                }
              }
              $restrnid = mysql_query("SELECT * FROM ".$prev."transactions WHERE user_id = '".$_SESSION['user_id']."' and (substring( add_date, 1, 10 ) >= '".$_POST['from_txt']."' and substring( add_date, 1, 10 )<= '".$_POST['to_txt']."') order by add_date");
              if(mysql_num_rows($restrnid)>0) {
                while($rowtrnid = mysql_fetch_array($restrnid)) {
                  if(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='CR')) {
                    $tranbalance = number_format(($tranbalance + doubleval($rowtrnid['balance'])),2);
                  } elseif(($rowtrnid['status']=='Y')&&($rowtrnid['amttype']=='DR')) {
                    $tranbalance = number_format(($tranbalance - doubleval($rowtrnid['balance'])),2);
                  }

                ?>
                  <tr class="tbl_bg2">
                    <td align=left><?php print date('M d, Y H:i:s',strtotime($rowtrnid['add_date']));?></td>
                    <td><?php print $rowtrnid['paypaltran_id'];?></td>
                    <td align=left><?php print $rowtrnid['details'];?></td>
                    <!--<td><?php //print $receivernm;?></td>-->
                    <td style="text-align:center"><?php print $rowtrnid['amttype'];?></td>
                    <td><?php if($rowtrnid['status']=='P'){print "<font color='#FF0000'><b>".$lang['PENDING']."</b></font>";}elseif($rowtrnid['status']=='Y'){print "<font color='#009900'><b>".$lang['COMPLETED']."</b></font>";}?></td>
                    <td style="text-align: right;"><?=$curn?><?php print $rowtrnid['balance'];?></td>
                    <td style="text-align: right;"><?=$curn?><?php print $tranbalance;?></td>
                  </tr>
                  <tr class="tr-space"></tr>
                <?php
                }
              } else {
            ?>
              <tr class="tbl_bg2">
                <td colspan="7" align="center"><strong><?=$lang['NO_TRANSACTION']?></strong></td>
              </tr>
            <?php
              }
            }
            ?>
            </tbody>
          </table>
        </div>

        <div class="transaction-info">
           <table cellpadding="0" cellspacing="0" border="0" width="100%" align = "center" >

        
        <tr >
          <td>
              
    
          </td>
        </tr>
        <tr>
          <td>
              <?php

$tranbalance = number_format(0.00, 2);

if(isset($_POST['sub_go'])&&$_POST['sub_go']== $lang['GO'])

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
                    <td style="text-align:left;border-bottom:0;"><strong><?=$lang['STATEMENT_PERIOD']?>:</strong></td>
                    <td style="text-align:left;border-bottom:0;"><em><?php print date('d M y',strtotime($_POST['from_txt']));?> <?=$lang['TOO']?> <?php print date('d M y',strtotime($_POST['to_txt']));?></em> </td>
                  </tr>
                  <tr class="tbl_bg2">
                    <td style="text-align:left;"><strong><?=$lang['BEGINING_BALANCE']?>:</strong></td>
                    <td style="text-align:left;"> <?=$curn?><?php print $tranbalance;?> </td>
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
                    <td style="text-align:left;padding-left: 40px;"><?=$lang['TOTAL_DEBAITS']?>:</td>
                    <td style="text-align:left;"><?=$curn?><?php print $totaldeb;?></td>
                  </tr>
                  <tr class="tbl_bg2">
                    <td style="text-align:left;padding-left: 40px;"><?=$lang['TOTAL_CREDITS']?>:</td>
                    <td style="text-align:left;"><?=$curn?><?php print $totalcred;?></td>
                  </tr>
                  <tr class="tbl_bg2">
                    <td style="text-align:left;border-bottom:0;"><strong><?=$lang['ENDING_BALANCE']?>:</strong></td>
                    <td style="text-align:left;border-bottom:0;"> <?=$curn?><?php print $tranbalance;?> </td>
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
                  <td style="text-align:left;border-bottom:0;"><strong><?=$lang['STATEMENT_PERIOD']?>:</strong></td>
                  <td style="text-align:left;border-bottom:0;"><em>&nbsp;</em></td>
                </tr>
                <tr class="tbl_bg2">
                  <td style="text-align:left;"><strong><?=$lang['BEGINING_BALANCE']?>:</strong></td>
                  <td style="text-align:left;">&nbsp;</td>
                </tr>
                <tr class="tbl_bg2">
                  <td style="text-align:left;padding-left: 40px;"><?=$lang['TOTAL_DEBAITS']?>:</td>
                  <td style="text-align:left;">&nbsp;</td>
                </tr>
                <tr class="tbl_bg2">
                  <td style="text-align:left;padding-left: 40px;"><?=$lang['TOTAL_CREDITS']?>:</td>
                  <td style="text-align:left;">&nbsp;</td>
                </tr>
                <tr class="tbl_bg2">
                  <td style="text-align:left;border-bottom:0;"><strong><?=$lang['ENDING_BALANCE']?>:</strong></td>
                  <td style="text-align:left;border-bottom:0;">&nbsp;</td>
                </tr>
              </table>
            <?php

  }

?>
              
          </td>
        </tr>
        
      </table>
        </div>

      </div>
    </div>
  </div>
</div>
<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?>


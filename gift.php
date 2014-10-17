<?php
$current_page = "<p>Give Bonus</p>";
include "includes/header.php";

CheckLogin();
if($_POST['giftsend']!=''){
 $rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));
 $rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));
$balsum = $rwbal['balsum1'] - $rwbal2['baldeb'];
if ($_POST['tranamt_txt'] == "" || $_POST['tranamt_txt'] < 0) {
        $_SESSION['error'] = 'Amount is not correct.';
    } else {
		 if ($balsum > $_POST['tranamt_txt']) {
				 $payable_amm = (float)$_POST['tranamt_txt'];
				 $payment_id = rand(1000, 9999) . time();
				 mysql_query("INSERT INTO " . $prev . "transactions (amount,details,user_id,	balance,add_date,date2,paypaltran_id,status,amttype) values

			('" . mysql_real_escape_string($payable_amm) . "','" . mysql_real_escape_string($_POST['reason_txt']) . "','" . mysql_real_escape_string($_SESSION['user_id']) . "','" .mysql_real_escape_string($payable_amm) . "',now(),'" . time() . "','".$payment_id."','Y','DR')");
			
			if(mysql_insert_id()){
				 mysql_query("INSERT INTO " . $prev . "transactions (amount,details,user_id,	balance,add_date,date2,paypaltran_id,status,amttype) values

				('" . mysql_real_escape_string($payable_amm) . "','" . mysql_real_escape_string($_POST['reason_txt']) . "','" . mysql_real_escape_string($_POST['user']) . "','" .mysql_real_escape_string($payable_amm) . "',now(),'" . time() . "','".$payment_id."','Y','CR')");
			}
		 }
	
	
	}
}
$res1k = mysql_query("select * from " . $prev . "projects where user_id='" . $_SESSION['user_id'] . "'");
$row1k = mysql_fetch_array($res1k);
$prarr = array();
$cntpr = 0;
$errmsg = '';
$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$row = mysql_fetch_array($res);
$rwbal1 = mysql_fetch_array(mysql_query("select sum(balance) as balsum from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y'"));
if ($rwbal1['balsum'] > 0) {
//echo "select * from ".$prev."projects where user_id='".$_SESSION['user_id']."' and status = 'process'";
    $res1 = mysql_query("select * from " . $prev . "projects where user_id='" . $_SESSION['user_id'] . "' and status in( 'process','completed')");
    if (mysql_num_rows($res1) > 0) {
        while ($row1 = mysql_fetch_array($res1)) {
            $resbidpr = mysql_query("select * from " . $prev . "buyer_bids where project_id = '" . $row1['id'] . "' and chose='Y'");
            if (mysql_num_rows($resbidpr) > 0) {
                while ($rwbidpr = mysql_fetch_array($resbidpr)) {
                    $prarr[$cntpr] = $rwbidpr['id'];
                    $cntpr++;
                }
            }
            /* 		else
              {
              $errmsg.="There are no successful bids in your project";
              } */
        }
    } else {
        $errmsg.="No user found";
    }
} else {
    $errmsg.=$lang['ACCOUNT_TRANSFER'];
}
//print_r($prarr);
if ($_GET['err'] != '') {
    $errmsg.=$_SESSION['error'];
}
$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$row = mysql_fetch_array($res);

$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));
$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));

$balsum = $rwbal['balsum1'] - $rwbal2['baldeb'];

$sum = 0;
$res4pend = mysql_query("select * from " . $prev . "escrow where bidder_id='" . $_SESSION['user_id'] . "' and status='P'");
while ($row4pend = mysql_fetch_array($res4pend)) {
    $sum+=$row4pend['amount'];
}
$sum1 = number_format($sum, 2);
if ($errmsg != '') {
    $_SESSION['error'] = $errmsg;
}
?>

<script type="text/javascript">

    function valcheck() {
        var remain_hidd = parseFloat(document.getElementById('remain_hidd').value);

        if (parseFloat(document.getElementById('ammo').value) < 0)
        {
            document.getElementById('ammo').value = '';
            alert('<?= $lang['NEGATIVE_BALANCE'] ?>');
        }
        if (parseFloat(document.getElementById('ammo').value) > remain_hidd)
        {
            alert('<?= $lang['SURE_WANT_REMAINING_BALANCE'] ?>');
        }
        if (parseFloat(document.getElementById('ammo').value) > parseFloat(<?php echo $balsum; ?>))
        {
            document.getElementById('ammo').value = '';
            alert('<?= $lang['ENTER_AMOUNT_LESS_THAN_YOUR_BALANCE'] ?>');
        }

    }

    function catfun(catid)
    {
        if (catid == 'select')
        {
            //alert('Please Select A Category');
            document.getElementById('subcategory').disabled = true;
            $('#displabel').hide();
            return false;
        }
        else
        {
            $.ajax({
                type: "GET",
                url: "<?= $vpath ?>mybidajax.php",
                data: {addr: catid},
                dataType: "html",
                success: function(datas) {
                    $('#mysubcat').html(datas);
                }
            });
        }
    }

    function chkfrm()
    {
       
        if (document.milestonepayment_frm.tranamt_txt.value == '')
        {
            alert('<?= $lang['ENTER_AMOUNT_TRANSFER'] ?>');
            /*document.milestonepayment_frm.tranamt_txt.value='0.00';
             document.milestonepayment_frm.tranamt_txt.focus();*/
            return false;
        }

        if ($('#ammo').val() > $('#due').val())
        {
            alert('<?= $lang['EQUAL_LESS_THAN'] ?> $' + $('#due').val());
            /*document.milestonepayment_frm.tranamt_txt.value='0.00';
             document.milestonepayment_frm.tranamt_txt.focus();*/
            return false;
        }

       

        return true;
    }
    function actionfun(actval, cntid)
    {
        //alert(cntid);
        if (actval != 'select')
        {
            document.getElementById('actiondiv' + cntid).style.display = 'block';
            actionajax(actval, cntid);
        }
        else
        {
            document.getElementById('actiondiv' + cntid).style.display = 'none';
        }
    }
    function actionajax(actvall, cntid1)
    {
        var xmlHttp;
        try
        {
            // Firefox, Opera 8.0+, Safari
            xmlHttp = new XMLHttpRequest();
        }
        catch (e)
        {
            // Internet Explorer
            try
            {
                xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e)
            {
                try
                {
                    xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                catch (e)
                {
                    alert("Your browser does not support AJAX!");
                    return false;
                }
            }
        }
        xmlHttp.onreadystatechange = function()
        {
            if (xmlHttp.readyState == 4)
            {
                document.getElementById('actiondiv' + cntid1).innerHTML = xmlHttp.responseText;
            }
        }

        xmlHttp.open("POST", "mymileajax.php?addr=" + actvall + "&addrid=" + cntid1, true);
        xmlHttp.send(null);
    }
    function getprice() {

        var duration = document.getElementById('dutation').value;

        if (isNaN(duration) || duration < parseFloat(0.1) || duration == '') {
            document.getElementById('dutation').value = "0.0";
        } else {
            //alert(document.getElementById('biddamount_hidd').value);
            var tol = parseFloat(duration * parseFloat(document.getElementById('biddamount_hidd').value));
            document.getElementById('ammo').value = tol.toFixed(2);
        }
    }
</script>

<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">
<div class="inner-middle"> 
    <div class="dash_headding">
        <p><a href="<?= $vpath ?>"><?= $lang['HOME_LINK'] ?></a> | <a href="<?= $vpath ?>payment/dsp/"><?= $lang['My_finance'] ?></a> | <a href="javascript:void(0);" class="selected"><?= $lang['MILDSTONE'] ?></a></p></div>
    <div class="clear"></div>
    <?php include 'includes/dashboard_menu.php';?>
    <!-- left side-->
    <!--middle -->
    <div class="profile_right">
        <div id="wrapper_3">
            


            <!-- <ul class="tabs">      
                <li><a href="<?= $vpath ?>payment/dsp/" ><?= $lang['DEPOSIT_FUNDS'] ?></a></li>
                <li><a href="<?= $vpath ?>milestone.html" ><?= $lang['MILDSTONE'] ?></a></li>
                <li><a href="<?= $vpath ?>withdraw.html" ><?= $lang['WITHDRAW_FUND'] ?></a></li>
                <li><a href="<?= $vpath ?>transaction_history.html" ><?= $lang['TRANSACTION_HISTORY'] ?></a></li>
                <li><a href="<?= $vpath ?>membership.html" ><?= $lang['MEMBERSHIP'] ?></a></li>
				<li><a  href="<?= $vpath ?>gift.html"  class="selected"><?= $lang['GIVE_BONUS'] ?></a></li>
            </ul> -->


            <?php
            if ($_SESSION['error'] != "") {
                include('includes/err.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            if ($_SESSION['succ'] != "") {
                include('includes/succ.php');
                unset($_SESSION['error']);
                unset($_SESSION['succ']);
            }
            ?>
            <div class="box-title">
                <div class="latest_text latest_text_new"><h1><?= $lang['GIVE_BONUS'] ?></h1></div>
                <div class="balence"><span><?= $lang['BAL_H'] ?> :</span> <?= $curn ?> <?php echo number_format($balsum, 2, '.', ',') ?></div>
            </div>
            <div class="browse_tab-content"> 
                <div class="browse_job_middle">

                    <table cellpadding="0" cellspacing="0" border="0" width="100%" align = "center" >

                        <!------------------------------------------------Middle Body-------------------------------------------------------------->
                        <tr >
                            <td>
                                <!----------------------------------------------------------------------------------------------------------->



                                <form name="milestonepayment_frm" action="" method="post" onsubmit="return chkfrm();">
                                  
                                    <input type="hidden" name="balsum" value="<?= $balsum ?>" />
									

                                    <table width="100%" cellpadding="8" cellspacing="0" border="0" > 
                                        <tbody>

                                            <tr class="tbl_bg_4"> 
                                                <td colspan="3"><?= $lang['GIVE_BONUS'] ?>.</td>
                                            </tr>
                                            <tr ><td colspan="3">&nbsp;</td></tr>
                                           
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td><strong><?= $lang['PROVIDE_USER'] ?></strong></td>
                                                <td align=left><select name="user">
<? 
$res1 = mysql_query("select id from " . $prev . "projects where user_id='" . $_SESSION['user_id'] . "' and status in( 'process','completed')");
if (mysql_num_rows($res1) > 0) {
	while ($row1 = mysql_fetch_array($res1)) {
		$resbidpr = mysql_query("select b.bidder_id,u.username from " . $prev . "buyer_bids b left join ".$prev."user as u on b.bidder_id=u.user_id where b.project_id = '" . $row1['id'] . "' and b.chose='Y'");
		if (mysql_num_rows($resbidpr) > 0) {
			while ($rwbidpr = mysql_fetch_array($resbidpr)) {
				$prarr[$cntpr] = $rwbidpr['id'];
				?>
			<option value="<?php echo $rwbidpr['bidder_id'];?>"><?php echo  $rwbidpr['username'];?></option>	
				<?php
			}
		}

	}
}
?>
														
														</select>
                                                </td>
                                            </tr>
                                           
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td ><strong><?= $lang['MONEY_TRANSFER'] ?></strong><b style="text-align:left; margin-left:10px;"><?= $lang['USD'] ?></b></td>
                                                <td><input type="text" name="tranamt_txt"  size="15"  id="ammo" onblur="valcheck()" class="from_input_box1" />&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td valign="top"><strong><?= $lang['REASON'] ?></strong></td>
                                                <td><textarea name="reason_txt" rows="6" cols="30" class="from_input_box1">Bonus </textarea></td>
                                            </tr>
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td  align="left"><input type="submit" name="giftsend" class="submit_bott" value="<?= $lang['SUBMIT'] ?>"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>




                                <!----------------------------------------------------------------------------------------------------------->

                            </td>

                        </tr>

                        <!------------------------------------------------Middle Body End---------------------------------------------------------->

                    </table>







                </div>
                <!--Profile Right End-->
            </div></div></div>
</div>		
</div>  
</div>  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php'; ?>
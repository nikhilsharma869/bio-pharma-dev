<?php
include "includes/header.php";
CheckLogin();
?>
<?php
$succ_msg = "";
$res = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$row = mysql_fetch_array($res);
$res1 = mysql_query("select * from " . $prev . "projects where user_id='" . $_SESSION['user_id'] . "'");
$row1 = mysql_fetch_array($res1);
$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));
$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));
$balsum = number_format(($rwbal['balsum1'] - $rwbal2['baldeb']), 2);
$sum = 0;
$res4pend = mysql_query("select * from " . $prev . "escrow where bidder_id='" . $_SESSION['user_id'] . "' and status='P'");
while ($row4pend = mysql_fetch_array($res4pend)) {
    $sum+=$row4pend['amount'];
}
$sum1 = number_format($sum, 2);
if ($_POST['ccpay'] == $lang['SUBMIT']) {
    if ($_POST['bank_ac'] == "" || $_POST['ac_name'] == "" || $_POST['ifsc'] == "" || $_POST['address'] == "" || $_POST['address'] == "" || $_POST['country'] == "" || $_POST['email'] == "") {
        $_SESSION['error'] = "Please fill up all the details properly.";
    } else {
        if (@mysql_num_rows(mysql_query("select user_id from " . $prev . "wire_transfer where user_id='" . $_SESSION['user_id'] . "'")) > 0) {

            $insert_sql = mysql_query("update " . $prev . "wire_transfer set email='" . $_POST['email'] . "',bank_ac_no='" . $_POST['bank_ac'] . "',bank_ac_name='" . $_POST['ac_name'] . "',bank_ifsc='" . $_POST['ifsc'] . "',street_address='" . $_POST['address'] . "',city='" . $_POST['city'] . "',country='" . $_POST['country'] . "' where user_id='" . $_SESSION['user_id'] . "'");
        } else {

            $insert_sql = mysql_query("insert into " . $prev . "wire_transfer (user_id,email,bank_ac_no,bank_ac_name,bank_ifsc,street_address,city,country,add_date) values ('" . $_SESSION['user_id'] . "',  '" . $_POST['email'] . "',  '" . $_POST['bank_ac'] . "', '" . $_POST['ac_name'] . "', '" . $_POST['ifsc'] . "', '" . $_POST['address'] . "', '" . $_POST['city'] . "', '" . $_POST['country'] . "', now())");
        }
        if ($insert_sql) {
            $rs1 = mysql_query("update " . $prev . "user set user_wiredacc = '" . $_POST['bank_ac'] . "' where user_id = '" . $_SESSION['user_id'] . "'");
            $_SESSION['succ'] = "Your details is saved. Money will be transferred once your account will verified.";
        }
    }
}
?>
<script type="text/javascript">
    function chkfrm()
    {
        if ((document.getElementById('payAmount').value == '') || parseFloat(document.getElementById('payAmount').value) < 10.00)
        {
            alert('<?= $lang['ENT_DEPO_AMT_10'] ?>');
            document.getElementById('payAmount').focus();
            return false;
        }
        document.depositpayment_frm.submit();
    }
    function myamt(amt)
    {
        var m = parseFloat(amt);
        var fchrg = parseFloat(document.getElementById('chrgAmount').value);
        var pfee = parseFloat(document.getElementById('feAmount').value);
        if (isNaN(amt))
        {
            document.getElementById('payAmount').value = '0.00';
            if (document.getElementById('chrgAmounttype').value == 'P')
            {
                document.depositpayment_frm.pchargesp_txt.value = '0.00';
            }
            document.getElementById('pyplfee').value = '0.00';
            document.getElementById('depamt').value = '0.00';
        }
        else if (m > 0)
        {
            if (document.getElementById('chrgAmounttype').value == 'F')
            {
                var fee = ((m + fchrg) * pfee) / 100;
                var chrg = m + fchrg + fee + 0.10;
                document.getElementById('pyplfee').value = fee;
                document.getElementById('depamt').value = chrg.toFixed(2);
            }
            else if (document.getElementById('chrgAmounttype').value == 'P')
            {
                var temp = (m * fchrg) / 100;
                var fee = ((m + temp) * pfee) / 100;
                var chrg = m + temp + fee + 0.10;
                document.depositpayment_frm.pchargesp_txt.value = temp.toFixed(2);
                document.getElementById('pyplfee').value = fee;
                document.getElementById('depamt').value = chrg.toFixed(2);
            }
        }
        else if ((m < 1) || (amt == ''))
        {
            document.getElementById('payAmount').value = '0.00';
            if (document.getElementById('chrgAmounttype').value == 'P')
            {
                document.depositpayment_frm.pchargesp_txt.value = '0.00';
            }
            document.getElementById('pyplfee').value = '0.00';
            document.getElementById('depamt').value = '0.00';
        }
    }
</script>

<div class="browse_contract">
    <div class="inner-middle">
        <!--Profile-->
        <?php include 'includes/leftpanel1.php'; ?>
        <div class="profile_right">
            <div id="wrapper_3">
                <div class="balence"><span><?= $lang['BAL_H'] ?> :</span> <?= $curn ?> <?php echo number_format($balsum, 2, '.', ',') ?></div>
                <ul class="tabs">      
                    <li><a href="<?= $vpath ?>payment/dsp/" ><?= $lang['DEPOSIT_FUNDS'] ?></a></li>
                    <li><a  href="<?= $vpath ?>milestone.html" ><?= $lang['MILDSTONE'] ?></a></li>
                    <li><a href="<?= $vpath ?>withdraw.html" class="selected"><?= $lang['WITHDRAW_FUND'] ?></a></li>
                    <li><a href="<?= $vpath ?>transaction_history.html" ><?= $lang['TRANSACTION_HISTORY'] ?></a></li>
                    <li><a href="<?= $vpath ?>membership.html" >Membership</a></li>
                </ul>

                <div class="browse_tab-content"> 
                    <div class="browse_job_middle">
                        <?php
                        $res4pend = mysql_query("select * from " . $prev . "escrow where bidder_id='" . $_SESSION['user_id'] . "' and status='P'");
                        while ($row4pend = mysql_fetch_array($res4pend)) {
                            $sum+=$row4pend['amount'];
                        }
                        $sum1 = number_format($sum, 2);
                        ?>
                        <table cellpadding="0" cellspacing="0" border="0" style="color:#6d6d6d; font-size:12px;" width="100%" align = "center" >

                            <!------------------------------------------------Middle Body-------------------------------------------------------------->
                            <tr>
                                <td>
                                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr class="tbl_bg_4">
                                            <td  colspan=2 style="padding-left:20px;"><?= $lang['Financial_Account'] ?>: <?php print ucwords($row['fname']) . ' ' . ucwords($row['lname']) ?></td>

                                        </tr>

                                        <tr>
                                            <td valign="top" >

                                                <?php $rescc = @mysql_fetch_array(mysql_query("select * from " . $prev . "wire_transfer where 1")); ?>
                                                <?php $wrt = @mysql_fetch_array(mysql_query("select * from " . $prev . "wire_transfer where user_id='" . $_SESSION[user_id] . "'")); ?>
                                                <form name="depositpayment_frm"  method="post">
                                                    <input type="hidden" id="chrgAmount" name="charge_txt" value="<?php print $rescc['depositamt_txt']; ?>" />
                                                    <input type="hidden" id="feAmount" name="pfees_txt" value="<?php print $rescc['deposit_fee']; ?>" />
                                                    <input type="hidden" name="pmttype" value="Wire Deposit" />
                                                    <table  width="100%" cellpadding="8" cellspacing="0" border="0"> 
                                                        <tbody>
                                                            <tr > 
                                                                <td colspan="2">
                                                                    <?
                                                                    if ($_SESSION['error'] != "") {
                                                                        include('includes/err.php');
                                                                        unset($_SESSION['error']);
                                                                        unset($_SESSION['succ']);
                                                                    }
                                                                    if ($_SESSION['succ'] != "") {
                                                                        include('includes/succ.php');
                                                                        unset($_SESSION['error']);
                                                                        unset($_SESSION['succ']);
                                                                        ?>
                                                                        <META HTTP-EQUIV=REFRESH CONTENT="3; URL=<?= $vpath ?>withdraw.html">
                                                                    <? }
                                                                    ?>
                                                                </td>
                                                            </tr>

                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['Bank_AC_No'] ?></strong></td>
                                                                <td><input type="text" class="from_input_box1" id="bank_ac" name="bank_ac"  size="20" value="<?= $wrt[bank_ac_no] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['AC_Name'] ?></strong></td>
                                                                <td><input type="text" id="ac_name" class="from_input_box1" name="ac_name"  size="50" value="<?= $wrt[bank_ac_name] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['IFS_Code'] ?></strong></td>
                                                                <td><input type="text" id="ifsc" name="ifsc" class="from_input_box1" size="20"  value="<?= $wrt[bank_ifsc] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['Street_Address'] ?></strong></td>
                                                                <td><input type="text" id="address" class="from_input_box1" name="address"  size="50" value="<?= $wrt[street_address] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['City'] ?></strong></td>
                                                                <td><input type="text" id="city" name="city" class="from_input_box1" size="50" value="<?= $wrt[city] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['Country'] ?></strong></td>
                                                                <td><input type="text" id="country" name="country" class="from_input_box1" size="50" value="<?= $wrt[country] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"><strong><?= $lang['Email'] ?></strong></td>
                                                                <td><input type="text" id="email" name="email" class="from_input_box1" size="50" value="<?= $wrt[email] ?>" /></td>
                                                            </tr>
                                                            <tr class="tbl_bg2">
                                                                <td style="width:200px;"></td>
                                                                <td valign="bottom">
                                                                    <input type="submit" name="ccpay" class="submit_bott" value="<?= $lang['SUBMIT'] ?>" onclick="return chkfrm();" /></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </form> 
                                                <!----------------------------------------------------------------------------------------------------------->
                                            </td>
                                            <td valign="top" class="CellBody right_cell">

                                            </td>
                                        </tr>

                                    </table>
                                </td></tr></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </div>

</div>
<?php include "includes/footer.php"; ?>

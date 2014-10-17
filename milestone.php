<?php
$current_page = "<p>Milestone Payment</p>";
include "includes/header.php";

CheckLogin();

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
    $res1 = mysql_query("select * from " . $prev . "projects where user_id='" . $_SESSION['user_id'] . "' and status = 'process'");
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
        $errmsg.=$lang['POSTED_ANY_MI'];
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
        if (document.milestonepayment_frm.project_sel.value == 'select')
        {
            alert('<?= $lang['PLEASE_SELECT_PROJECT'] ?>');
            return false;
        }
        if (document.milestonepayment_frm.subcategory.value == 'select')
        {
            alert('<?= $lang['PLEASE_SELECT_CONTRACTOR'] ?>');
            return false;
        }
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

        /*if(isNaN(document.milestonepayment_frm.tranamt_txt.value)||parseFloat(document.milestonepayment_frm.tranamt_txt.value)<=0.00)
         {
         alert('Please enter a valid amount to transfer');
         document.milestonepayment_frm.tranamt_txt.value='0.00';
         document.milestonepayment_frm.tranamt_txt.focus();
         return false;
         }
         
         
         if(document.milestonepayment_frm.reason_txt.value=='')
         {
         alert('Please enter a reason for transfer');
         document.milestonepayment_frm.reason_txt.focus();
         return false;
         }*/

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
            <div class="balence"><span><?= $lang['BAL_H'] ?> :</span> <?= $curn ?> <?php echo number_format($balsum, 2, '.', ',') ?></div>


            <!-- <ul class="tabs">      
                <li><a href="<?= $vpath ?>payment/dsp/" ><?= $lang['DEPOSIT_FUNDS'] ?></a></li>
                <li><a class="selected" href="<?= $vpath ?>milestone.html" ><?= $lang['MILDSTONE'] ?></a></li>
                <li><a href="<?= $vpath ?>withdraw.html" ><?= $lang['WITHDRAW_FUND'] ?></a></li>
                <li><a href="<?= $vpath ?>transaction_history.html" ><?= $lang['TRANSACTION_HISTORY'] ?></a></li>
                <li><a href="<?= $vpath ?>membership.html" ><?= $lang['MEMBERSHIP'] ?></a></li>
				<li><a  href="<?= $vpath ?>gift.html" ><?= $lang['GIVE_BONUS'] ?></a></li>
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
            <div class="clear"></div>
    <div class="latest_text latest_text_new"><h1><?= $lang['MILDSTONE'] ?></h1></div>
            <div class="browse_tab-content"> 
                <div class="browse_job_middle">

                    <table cellpadding="0" cellspacing="0" border="0" width="100%" align = "center" >

                        <!------------------------------------------------Middle Body-------------------------------------------------------------->
                        <tr >
                            <td>
                                <!----------------------------------------------------------------------------------------------------------->



                                <form name="milestonepayment_frm" action="<?= $vpath ?>escrowtransfer.php" method="post" onsubmit="return chkfrm();">
                                    <input type="hidden" name="pmttype" value="Milestone Payment Transfer" />
                                    <input type="hidden" name="balsum" value="<?= $balsum ?>" />
									

                                    <table width="100%" cellpadding="8" cellspacing="0" border="0" > 
                                        <tbody>

                                            <tr class="tbl_bg_4"> 
                                                <td colspan="3"><?= $lang['SET_UP_MILESTONE'] ?>.</td>
                                            </tr>
                                            <tr ><td colspan="3">&nbsp;</td></tr>
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td ><strong><?= $lang['SELECT_PROJECT'] ?></strong></td>
                                                <td>

                                                    <select name="project_sel" onchange="return catfun(this.options[this.selectedIndex].value);" class="from_input_box1"  style="width:225px;">
                                                        <option value="select"><?= $lang['SELECT_PROJECT'] ?></option>
                                                        <?php
                                                        foreach ($prarr as $bidid) {
                                                            //echo "select * from ".$prev."buyer_bids where id = '".$bidid."'";
                                                            $rwbidd1 = mysql_fetch_array(mysql_query("select * from " . $prev . "buyer_bids where id = '" . $bidid . "'"));
                                                            $rwuser1 = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $rwbidd1['project_id'] . "'"));
                                                            ?>
																
                                                            <option value="<?php print $bidid; ?>"><?php print ucwords($rwuser1['project']); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td><strong><?= $lang['PROVIDE_USER'] ?></strong></td>
                                                <td align=left><div id="mysubcat">
                                                        <select id="subcategory" name="subcategory" disabled="disabled" class="from_input_box1"  style="width:225px;">
                                                            <option value="select"><?= $lang['SELECT_USER'] ?></option>
                                                        </select></div>
                                                </td>
                                            </tr>
                                            <!--
                                            <tr class="tbl_bg2">
                                                    <td>&nbsp;</td>
                                                    <td ><strong><?= $lang['TN_PASS'] ?></strong></td>
                                                <td><input type="password" name="trans_pass"  size="15" value="" class="from_input_box1" /></td>
                                            </tr>-->
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td ><strong><?= $lang['MONEY_TRANSFER'] ?></strong><b style="text-align:left; margin-left:10px;"><?= $lang['USD'] ?></b></td>
                                                <td><input type="text" name="tranamt_txt"  size="15"  id="ammo" onblur="valcheck()" class="from_input_box1" />&nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td valign="top"><strong><?= $lang['REASON'] ?></strong></td>
                                                <td><textarea name="reason_txt" rows="6" cols="30" class="from_input_box1"></textarea></td>
                                            </tr>
                                            <tr class="tbl_bg2">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td  align="left"><input type="submit" name="milesub" class="submit_bott" value="<?= $lang['SUBMIT'] ?>"/></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>




                                <!----------------------------------------------------------------------------------------------------------->

                            </td>

                        </tr>

                        <!------------------------------------------------Middle Body End---------------------------------------------------------->

                    </table>





                    <!---------------------------------------------------------------------------------------------------------------------------->


                    <?php
                    $no_of_records = 10;

                    $resout_mile1 = mysql_query("select * from " . $prev . "escrow where user_id = '" . $_SESSION['user_id'] . "' order by add_date desc");
                    $total = mysql_num_rows($resout_mile1);

                    if ($_GET['page']) {
                        $sql = "select * from " . $prev . "escrow where user_id = '" . $_SESSION['user_id'] . "' order by add_date desc limit " . ($_REQUEST['page'] - 1) * $no_of_records . "," . $no_of_records . "";
                    } else {
                        $sql = "select * from " . $prev . "escrow where user_id = '" . $_SESSION['user_id'] . "' order by add_date desc limit 0," . $no_of_records . "";
                    }
                    $resout_mile = mysql_query($sql);
                    ?>
                    <br  />


                    <table width="100%" cellpadding="5" cellspacing="0" border="0" > 
                        <tbody>
                            <tr ><td colspan="7" class="nheading"><?= $lang['MILESTONE_PAYMENT'] ?></td></tr>
                            <tr class="tbl_bg_4">  
                                <td width="11%"><?= $lang['DATE_TIME'] ?></td>
                                <td width="15%"><?= $lang['AMOUNT_USD'] ?></td> 
                                <td width="15%"><?= $lang['RECEIVER'] ?></td> 
                                <td width="30%"><?= $lang['PROJECT'] ?></td>
                                <td width="25%"><?= $lang['REASON'] ?></td> 
                                <td width="19%"><?= $lang['ACTIONS'] ?></td>
                                <td width="19%"><?= $lang['CONFIRM'] ?></td>
                            </tr> 
                            <?php
                            if (mysql_num_rows($resout_mile) > 0) {
                                $testcount = 1;
                                while ($rwout_mile = mysql_fetch_array($resout_mile)) {
                                    $respr1 = mysql_fetch_array(mysql_query("SELECT project_id FROM " . $prev . "buyer_bids WHERE  id='" . $rwout_mile['bidid'] . "'"));
                                    $respr2 = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $respr1['project_id'] . "'"));
                                    $respr3 = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = '" . $rwout_mile['bidder_id'] . "'"));
                                    ?>
                                    <tr class="tbl_bg2">
                                <form name="outmile_frm<?php print $testcount; ?>" action="<?= $vpath ?>outmilesql.html" method="post">  
                                    <td align=left><?php print date('M d, Y H:i:s', strtotime($rwout_mile['add_date'])); ?></td>
                                    <td align=left><? if ($rwout_mile['status'] == 'R') { ?><?= $lang['DISPUTE_AMT'] ?>:<?= $curn ?><?php print $rwout_mile['amount']; ?><br><?= $lang['RELEASE_AMT'] ?>:<?= $curn ?><?php print getrelaseamountfordispute($rwout_mile['escrow_id']); ?><? } else { ?><?= $curn ?><?php print $rwout_mile['amount']; ?><? } ?></td>
                                    <td align=left><?php print ucwords($respr3['fname']) . ' ' . ucwords($respr3['lname']); ?></td> 
                                    <td align=left><?php print ucwords($respr2['project']); ?></td> 
                                    <td align=left><?php print $rwout_mile['reason']; ?></td>
                                    <td>
                                        <?php
                                        if ($rwout_mile['status'] == 'Y') {
                                            echo "<font color='#009900'><b>" . $lang['PAID'] . "</b></font>";
                                        }
                                        /* 		elseif($rwout_mile['status']=='P')
                                          {echo "<font color='#FF0000'><b>Cancelled</b></font>";} */ elseif ($rwout_mile['status'] == 'D') {
                                            echo "<font color='#FF0000'><b>" . $lang['DISPUTED'] . "</b></font>";
                                        } elseif ($rwout_mile['status'] == 'R') {
                                            echo "<font color='green'><b>" . $lang['RESOLVED'] . "</b></font>";
                                        } elseif ($rwout_mile['status'] == 'P') {
                                            ?>
                                            <select name="action_select" class="from_input_box2" style="width:100px">
                                                <option value="select"><?= $lang['TAKE_ACTION'] ?></option>
                                                <option value="release"><?= $lang['RELEASE_PAYMENT'] ?></option>
                                                <option value="dispute"><?= $lang['DUPLICATE_MILESTONE'] ?></option>
                                            </select>
                                            <?php
                                        }
                                        //echo "SELECT * FROM ".$prev."messages m inner join ".$prev."buyer_bids b on m.project_id=b.project_id inner join ".$prev."escrow e on b.id=e.bidid WHERE  e.escrow_id='".$rwout_mile['escrow_id']."'";

                                        $pen_query = @mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "messages m inner join  " . $prev . "projects p on m.project_id=p.id  inner join " . $prev . "buyer_bids b on p.id=b.project_id inner join " . $prev . "escrow e on b.id=e.bidid WHERE  e.escrow_id='" . $rwout_mile['escrow_id'] . "' and e.status='P'"));
                                        echo '<br  /><font color="red">' . $pen_query['subject'] . '</font>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($rwout_mile['status'] == 'P') { ?>
                                            <input type="hidden" name="hidep" value="<?php print $respr1['project_id']; ?>"  />
                                            <input type="hidden" name="hides" value="<?php print $rwout_mile['escrow_id']; ?>" />
                                            <input type="submit" name="sub<?php print $testcount; ?>" value="<?= $lang[SUBMIT] ?>" class="submit_bott" />
                                        <?php } ?>
                                    </td>
                                </form>
                                </tr>
                                <?php
                                $testcount++;
                            }
                        } else {
                            ?>
                            <tr class="tbl_bg2"><td colspan="7" align="center"><strong><?= $lang['NO_REC_FOUND_H'] ?></strong></td></tr>
                            <?php
                        }
                        ?> 
                        <tr><td colspan="2">&nbsp;</td>
                            <td colspan="5">
                                <?php
                                if ($total > $no_of_records) {
                                    echo"<div align=right>" . new_pagingnew(0, $vpath . 'milestone/', '/', $no_of_records, $_REQUEST['page'], $total, $table_id = '', $tbl_name = '') . "</div>";
                                }
                                ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <br />
                    <?php
                    $resout_mile2 = mysql_query("select * from " . $prev . "escrow where bidder_id = '" . $_SESSION['user_id'] . "' order by add_date desc");
                    $total = mysql_num_rows($resout_mile2);

                    if ($_GET['page']) {
                        $sql = "select * from " . $prev . "escrow where bidder_id = '" . $_SESSION['user_id'] . "' order by add_date desc limit " . ($_REQUEST['page'] - 1) * $no_of_records . "," . $no_of_records . "";
                    } else {
                        $sql = "select * from " . $prev . "escrow where bidder_id = '" . $_SESSION['user_id'] . "' order by add_date desc limit 0," . $no_of_records . "";
                    }
                    $resout_mile1 = mysql_query($sql);
                    ?>
                    <br  />

                    <table cellpadding="5" cellspacing="0" border="0" width="100%" align = "center" >
                        <tbody>
                            <tr ><td colspan="7" class="nheading"><?= $lang['INCOMING_MILESTONE_PAYMENT'] ?></td></tr>
                            <tr class="tbl_bg_4" >  
                                <td width="11%" style="padding-left:5px;" align=left><?= $lang['DATE_TIME'] ?></td>
                                <td width="15%" align=left><?= $lang['AMT_H'] ?></td> 
                                <td width="15%" align=left><?= $lang['SENDER'] ?></td> 
                                <td width="30%" align=left><?= $lang['PROJECT'] ?></td>
                                <td width="25%" align=left><?= $lang['REASON'] ?></td> 
                                <td width="19%" align=left><?= $lang['ACTIONS'] ?></td>
                                <td width="19%" style="padding-right:5px;" align=left><?= $lang['CONFIRM'] ?></td>
                            </tr> 
                            <?php
                            if (mysql_num_rows($resout_mile1) > 0) {
                                $testcount1 = 1;
                                while ($rwout_mile1 = mysql_fetch_array($resout_mile1)) {
                                    $respr1 = mysql_fetch_array(mysql_query("SELECT project_id FROM " . $prev . "buyer_bids WHERE  id='" . $rwout_mile1['bidid'] . "'"));
                                    $respr2 = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id = '" . $respr1['project_id'] . "'"));
                                    $respr3 = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id = '" . $rwout_mile1['user_id'] . "'"));
                                    ?>

                                    <tr class="tbl_bg2">
                                <form name="inmile_frm<?php print $testcount1; ?>" action="inmilesql.php" method="post">
                                    <td style="padding-left:5px;" align=left><?php print date('M d, Y H:i:s', strtotime($rwout_mile1['add_date'])); ?></td>
                                    <td align=left><? if ($rwout_mile1['status'] == 'R') { ?><?= $lang['DISPUTE_AMT'] ?>:<?= $curn ?><?php print $rwout_mile1['amount']; ?><br><?= $lang['RELEASE_AMT'] ?>:<?= $curn ?><?php print getrelaseamountfordispute($rwout_mile1['escrow_id']); ?><? } else { ?><?= $curn ?><?php print $rwout_mile1['amount']; ?><? } ?></td>
                                    <td align=left><?php print ucwords($respr3['fname']) . ' ' . ucwords($respr3['lname']); ?></td> 
                                    <td align=left><?php print ucwords($respr2['project']); ?></td> 
                                    <td align=left><?php print $rwout_mile1['reason']; ?></td>
                                    <td align=left>
                                        <?php
                                        if ($rwout_mile1['status'] == 'Y') {
                                            echo "<font color='#009900'><b>" . $lang['RECEIVED'] . "</b></font>";
                                        } elseif ($rwout_mile1['status'] == 'C') {
                                            echo "<font color='#FF0000'><b>" . $lang['STAT_CNCL'] . "</b></font>";
                                        } elseif ($rwout_mile1['status'] == 'D') {
                                            echo "<font color='#FF0000'><b>" . $lang['DISPUTED'] . "</b></font>";
                                        } elseif ($rwout_mile1['status'] == 'R') {
                                            echo "<font color='green'><b>" . $lang['RESOLVED'] . "</b></font>";
                                        } else {
                                            ?>
                                            <select name="action_select" class="from_input_box1" style="width:100px;">
                                                <option value="select"><?= $lang['TAKE_ACTION'] ?></option>
                                                <option value="request"><?= $lang['REQUEST_TO_RELEASE'] ?></option>
                                                <!--<option value="dispute"><?= $lang['DUPLICATE_MILESTONE'] ?></option>
                                                <option value="cancel"><?= $lang['CANCEL_PAYMENT'] ?></option>-->
                                            </select>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if ($rwout_mile1['status'] == 'P') { ?>
                                            <input type="hidden" name="hidep" value="<?php print $respr1['project_id']; ?>"  />
                                            <input type="hidden" name="hides" value="<?php print $rwout_mile1['escrow_id']; ?>" />
                                            <input type="submit" class="submit_bott" name="sub<?php print $testcount1; ?>" value="Submit"  />
                                        <?php } ?>
                                    </td>
                                </form></tr>
                                <?php
                                $testcount1++;
                            }
                        } else {
                            ?>
                            <tr class="tbl_bg2"><td colspan="7" align="center"><strong><?= $lang['NO_REC_FOUND_H'] ?></strong></td></tr>
                            <?php
                        }
                        ?> 
                        <tr><td colspan="2">&nbsp;</td>
                            <td colspan="5">
                                <?php
                                if ($total > $no_of_records) {

                                    echo"<div align=right>" . new_pagingnew(0, $vpath . 'milestone/', '/', $no_of_records, $_REQUEST['page'], $total, $table_id = '', $tbl_name = '') . "</div>";
                                }
                                ?>
                            </td>
                        </tr> 
                        </tbody>
                    </table>





                </div>
                <!--Profile Right End-->
            </div></div></div>
</div>        
</div>        
</div>		  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php'; ?>
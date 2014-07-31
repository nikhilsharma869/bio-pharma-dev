<?php

include "configs/config.php";
include "configs/path.php";

function getTotalHR($d) {
    global $prev;
    $r = mysql_query("SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM " . $prev . "project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and start_time >= '" . ($d . " 00:00:00") . "' and `stop_time`<='" . ($d . " 23:59:59") . "' AND project_id=" . $_GET[pid]);
    $time = 0;
    while ($t = mysql_fetch_assoc($r)) {
        $time = $time + $t['wt'];
    }
    return $time;
}

function getTotalAMT($ts, $bid_amt) {
    return round((($bid_amt * $ts) / 3600), 2);
}

function getSubTotalHR($p) {
    global $prev;

// echo "SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM ".$prev."project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and project_id='".$p."'";

    $r = mysql_query("SELECT time_to_sec(TIMEDIFF(`stop_time`,`start_time`)) as wt FROM " . $prev . "project_tracker WHERE `note`='' and `stop_time`<>'0000-00-00 00:00:00' and project_id='" . $p . "'");
    $time = 0;
    while ($t = mysql_fetch_assoc($r)) {
        $time = $time + $t['wt'];
    }
    return $time;
}

function getPayAmount($bid) {
    global $prev;
    $r = mysql_fetch_assoc(mysql_query("select sum(amount) as tm from " . $prev . "escrow where bidid='" . $bid . "' and status='Y'"));
    if ($r['tm'] == "") {
        return 0;
    } else {
        return $r['tm'];
    }
}

if (isset($_GET['addr'])) {


    $res2 = mysql_fetch_array(mysql_query("select * from " . $prev . "buyer_bids where id='" . $_GET['addr'] . "'"));
    $res4 = mysql_fetch_array(mysql_query("select sum(amount) as escrsum from " . $prev . "escrow where bidid = '" . $_GET['addr'] . "' and status!='C'"));

    if ($res4['escrsum'] == null) {
        $escrw = '0.00';
    } else {
        $escrw = $res4['escrsum'];
    }
    $res3 = mysql_query("select * from " . $prev . "user where user_id='" . $res2['bidder_id'] . "'");
    if (mysql_num_rows($res3)) {
        while ($row3 = mysql_fetch_array($res3)) {

            echo '<input type="hidden" name="subcategory" value="' . $row3['user_id'] . '" />' . $row3['username'].'<br>';
        }
        if (getprojecttype($res2['project_id']) == "F") {
            //$paid = ($escrw*100)/97;
            $paid = $escrw;
            print "
	<label id=\"displabel\">Total Amount : " . $curn . $res2['bid_amount'] . "</label><br>
	<label id=\"displabel\">Remaining Payment : " . $curn . ($res2['bid_amount'] - $paid) . "</label>
	
	<input type=\"hidden\" name=\"biddamount_hidd\" value=" . $res2['bid_amount'] . " />
	<input type=\"hidden\" name=\"ecswamount_hidd\" value=" . $escrw . " />
	<input type=\"hidden\" name=\"project_id\" value=" . $res2['project_id'] . " />
	
	<input type='hidden' name='remain_hidd' value=" . ($res2['bid_amount'] - $paid) . " id='remain_hidd' />";
        } else {
            $tamt = floatval(getTotalAMT(getSubTotalHR($res2['project_id']), $res2['bid_amount']));
            $tamt = $res2['bid_amount'];
            //$payamt = getPayAmount($res2['id']);
            $damt = floatval(getTotalAMT(getSubTotalHR($res2['project_id']), $res2['bid_amount']));
            $ramt = floatval(getTotalAMT(getSubTotalHR($res2['project_id']), $res2['bid_amount'])) - floatval($escrw);
            print "
	<label id=\"displabel\">Total Amount : " . $curn . $damt . "</label><br>
	<label id=\"displabel\">Remaining Payment : " . $curn . $ramt . "</label>
	
	<input type=\"hidden\" name=\"biddamount_hidd\" value=" . $damt . " />
	<input type=\"hidden\" name=\"ecswamount_hidd\" value=" . $escrw . " />
	<input type=\"hidden\" name=\"project_id\" value=" . $res2['project_id'] . " />
	
	<input type='hidden' name='remain_hidd' value=" . $ramt . " id='remain_hidd' />";
        }
    }
}
?>
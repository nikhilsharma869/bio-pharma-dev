<?php

include "configs/config.php";
include "configs/path.php";
//echo $_GET['addr'];die();
if (isset($_GET['addr'])) {


    $res2 = mysql_fetch_array(mysql_query("select * from " . $prev . "buyer_bids where id='" . $_GET['addr'] . "'"));
   
    $res4 = mysql_fetch_array(mysql_query("select sum(amount) as escrsum from " . $prev . "escrow where bidid = '" . $_GET['addr'] . "' and status!='C'"));
//echo "select sum(amount) as escrsum from ".$prev."escrow where bidid = '".$_GET['addr']."' and status!='C'";die();

    if ($res4['escrsum'] == null) {
        $escrw = '0.00';
    } else {
        $escrw = $res4['escrsum'];
    }
    $res3 = mysql_query("select * from " . $prev . "user where user_id='" . $res2['bidder_id'] . "'");

    while ($row3 = mysql_fetch_array($res3)) {

        echo '<input type="hidden" name="subcategory" value="' . $row3['user_id'] . '" />' . ucwords($row3['fname']) . ' ' . ucwords($row3['lname']) . '<br>';
    }
    if (getprojecttype($res2['project_id']) == "F") {
        //$paid = ($escrw*100)/97;
        $paid = $escrw;
        print "
	<label id=\"displabel\">Total Bid Amount : " . $curn . $res2['emp_charge'] . "</label><br>
	<label id=\"displabel\">Remaining Payment : " . $curn . ($res2['emp_charge'] - $paid) . "</label>
	
	<input type=\"hidden\" name=\"biddamount_hidd\" value=" . $res2['emp_charge'] . " />
	<input type=\"hidden\" name=\"ecswamount_hidd\" value=" . $escrw . " />
	<input type=\"hidden\" name=\"project_id\" value=" . $res2['project_id'] . " />
	
	<input type='hidden' name='remain_hidd' value=" . ($res2['emp_charge'] - $paid) . " id='remain_hidd' />";
    } else {
        echo "<label id=\"displabel\">Amount per hour : " . $curn . $res2['emp_charge'] . "</label><br>"
                . "<input type=\"hidden\" name=\"biddamount_hidd\" id=\"biddamount_hidd\" value=" . $res2['emp_charge'] . " />
	<input type=\"text\" name=\"dutation\" id=\"dutation\" onblur='getprice()'  />
	<input type=\"hidden\" name=\"project_id\" value=" . $res2['project_id'] . " />";
    }
}
?>
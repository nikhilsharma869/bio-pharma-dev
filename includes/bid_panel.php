
<div class="browse_contract_right_box">
    <form method="POST" name="bidform" id="bidform" action="<?= $vpath ?>applybid.html" onsubmit="return bid_valid();">
        <?php
        $bid_comm = 0.00;
        $row_setting = mysql_fetch_assoc(mysql_query("select account_type from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
        if ($row_setting[account_type] == 'C') {
            if (trim($d['special']) != '') {
                if ($d['project_type'] == "F") {
                    $str_type = $paypal_settings['featured_company_charge'] . '%';
                    $bid_comm = $paypal_settings['featured_company_charge'];
                } else {
                    $str_type = $paypal_settings['featured_company_charge_hourly'] . '%';
                    $bid_comm = $paypal_settings['featured_company_charge_hourly'];
                }
            } else {
                if ($d['project_type'] == "F") {
                    $str_type = $paypal_settings['non_featured_company_charge'] . '%';
                    $bid_comm = $paypal_settings['non_featured_company_charge'];
                } else {
                    $str_type = $paypal_settings['non_featured_company_charge_hourly'] . '%';
                    $bid_comm = $paypal_settings['non_featured_company_charge_hourly'];
                }
            }
        } else {
            if (trim($d['special']) != '') {
                if ($d['project_type'] == "F") {
                    $str_type = $paypal_settings['featured_individual_charge'] . '%';
                    $bid_comm = $paypal_settings['featured_individual_charge'];
                } else {
                    $str_type = $paypal_settings['featured_individual_charge_hourly'] . '%';
                    $bid_comm = $paypal_settings['featured_individual_charge_hourly'];
                }
            } else {
                if ($d['project_type'] == "F") {
                    $str_type = $paypal_settings['non_featured_individual_charge'] . '%';
                    $bid_comm = $paypal_settings['non_featured_individual_charge'];
                } else {
                    $str_type = $paypal_settings['non_featured_individual_charge_hourly'] . '%';
                    $bid_comm = $paypal_settings['non_featured_individual_charge_hourly'];
                }
            }
        }

        $update_bid = @mysql_fetch_array(mysql_query("select * from " . $prev . "buyer_bids where project_id='" . $_REQUEST[id] . "' and bidder_id='" . $_SESSION['user_id'] . "'"));
        //echo "id :".$update_bid['id'];
        if ($update_bid['id'] != "") {
            echo '<input type="hidden" name="rev_bidid_hid" value="' . $update_bid['id'] . '" >';
            echo '<input type="hidden" name="submits" value="ReviseBid" >';
            $bid_place = $lang['Revise_Bid'];
        } else {
            echo '<input type="hidden" name="submits" value="PlaceBid" >';
            $bid_place = $lang['Place_Bid'];
        }
        ?>
        <input type="hidden" name="projectid_hid" id="projectid_hid_id" value="<?= $_REQUEST[id]; ?>"/>
        <input type="hidden" name="bid_commitype_hid" id="bid_commitype_hid_id" value="P" />
        <input type="hidden" name="bid_commission_hid" id="bid_commission_hid_id" value="<?php print $bid_comm; ?>" />
        <input type="hidden" name="site_fee_hid" id="site_fee_hid_id" value="" />


        <div class="browse_contract_right">
            <div class="browse_right_text">
                <h1>My Proposal</h1>
            </div>
            <br />
            <div class="cost_timing">
                <div class="cost_form_box">
                    <h1><?= $lang['COVER_LETTER_BID'] ?></h1>
                    <textarea id="details" name="details" cols="" rows=""><?= $update_bid['cover_letter'] ?></textarea>
                </div>
                <div class="cost_form_box">
                    <h1><?php
                        if ($d['project_type'] == "F") {
                            echo $lang['MY_EARNINGS'];
                        } else {
                            echo $lang['MY_EARNINGS_HOURLY'];
                        }
                        ?></h1>
                    <input type="text" name="bidamount1" id="bidamount1" maxlength="6" size="6" value="<?= $update_bid['bid_amount'] ?>" onblur="javascript:getbid(this.value);" />
                </div>
                <div class="cost_form_box">
                    <h1><?= $lang['BILLED_2_CLIENT'] ?> <b><?= $str_type ?></b></h1>
                    <input type="text" name="bidamount" id="bidamount" maxlength="6" size="6" value="<?= $update_bid['emp_charge'] ?>" readonly="readonly" />
                </div>
                <div class="cost_form_box">
                    <h1><?= $lang['DAYS_REQUIRED'] ?></h1>
                    <input type="text" id="delivery" name="delivery" maxlength="3" size="6" value="<?= $update_bid['duration'] ?>" />
                </div>
                <div class="submit_bott" style="text-decoration:none; margin:6px 7px;" onclick="bid_valid()"><?php echo $bid_place; ?></div>

            </div>
        </div>

    </form>
</div>

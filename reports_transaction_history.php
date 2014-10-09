<?php
include "includes/header.php";
?>
<div class="spage-container" id="reports_transactionHistory_after">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
              <?php
					$parent = 'client_report';
					$current = 'report_transaction_history';
					$current_sub = '';
					get_child_menu($parent, $current, $current_sub);
				?>
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">
                    <div class="sv-dropdown" id="current-active">
                        <div class="sv-dropSelect">Current Activity</div>
                        <ul>
                            <li>1</li>
                            <li>2</li>
                            <li>3</li>
                            <li>4</li>
                        </ul>
                    </div>
                    <div class="search" id="ds-team"> 
                        <div class="from-time">
                            <p class="t-from">From</p>
                            <div class="datetime">
                                <input type="text" id="form-time">
                                <img class="clander-img" src="css/img/calender_icon.png" alt="">
                            </div>
                        </div>
                        <div class="to-time">
                            <p class="t-to">To</p>
                            <div class="datetime">
                                <input type="text" id="to-time">
                                <img class="clander-img" src="css/img/calender_icon.png" alt="">
                            </div>
                        </div>               
                        <div class="sv-dropdown all-transactions">
                            <div class="sv-dropSelect">All Transactions</div>
                            <ul>
                                <li>1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                            </ul>
                        </div>  
                        <div class="sv-dropdown all-freelancers">
                            <div class="sv-dropSelect">All Freelancers</div>
                            <ul>
                                <li>1</li>
                                <li>2</li>
                                <li>3</li>
                                <li>4</li>
                            </ul>
                        </div>                           
                        <button class="bt-go">Go</button>
                    </div>
                    <div class="report-history-detail">
                        <div class="row-title">                            
                            <p class="j-col1 text-bold">Date</p>
                            <p class="j-col2 text-bold">Type</p>
                            <p class="j-col3 text-bold">Description</p>
                            <p class="j-col4 text-bold">Freelancer</p>
                            <p class="j-col5 text-bold">Amount</p>
                            <p class="j-col6 text-bold">Balance</p>
                            <p class="j-col7 text-bold">Ref Id</p>
                        </div>
                        <div class="row-content">
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Payment</p>
                                <p class="j-col3">American Express 1005</p>
                                <p class="j-col4">Payment</p>
                                <p class="j-col5">$223.00</p>
                                <p class="j-col6">$0.00</p>
                                <p class="j-col7 c-blue">45221545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Hourly</p>
                                <p class="j-col3">08/18/2014-08/24/2014 - 20:00 hrs @ 2.22/hr</p>
                                <p class="j-col4">Larry Cueto</p>
                                <p class="j-col5">$44.40</p>
                                <p class="j-col6">$223.80</p>
                                <p class="j-col7 c-blue">54654545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Hourly</p>
                                <p class="j-col3">08/18/2014-08/24/2014 - 20:00 hrs @ 2.22/hr</p>
                                <p class="j-col4">Larry Cueto</p>
                                <p class="j-col5">$44.40</p>
                                <p class="j-col6">$223.80</p>
                                <p class="j-col7 c-blue">54654545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Hourly</p>
                                <p class="j-col3">08/18/2014-08/24/2014 - 20:00 hrs @ 2.22/hr</p>
                                <p class="j-col4">Larry Cueto</p>
                                <p class="j-col5">$44.40</p>
                                <p class="j-col6">$223.80</p>
                                <p class="j-col7 c-blue">54654545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Payment</p>
                                <p class="j-col3">American Express 1005</p>
                                <p class="j-col4">Payment</p>
                                <p class="j-col5">$223.00</p>
                                <p class="j-col6">$0.00</p>
                                <p class="j-col7 c-blue">45221545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Hourly</p>
                                <p class="j-col3">08/18/2014-08/24/2014 - 20:00 hrs @ 2.22/hr</p>
                                <p class="j-col4">Larry Cueto</p>
                                <p class="j-col5">$44.40</p>
                                <p class="j-col6">$223.80</p>
                                <p class="j-col7 c-blue">54654545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Hourly</p>
                                <p class="j-col3">08/18/2014-08/24/2014 - 20:00 hrs @ 2.22/hr</p>
                                <p class="j-col4">Larry Cueto</p>
                                <p class="j-col5">$44.40</p>
                                <p class="j-col6">$223.80</p>
                                <p class="j-col7 c-blue">54654545</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Aug 25, 2014</p>
                                <p class="j-col2">Hourly</p>
                                <p class="j-col3">08/18/2014-08/24/2014 - 20:00 hrs @ 2.22/hr</p>
                                <p class="j-col4">Larry Cueto</p>
                                <p class="j-col5">$44.40</p>
                                <p class="j-col6">$223.80</p>
                                <p class="j-col7 c-blue">54654545</p>
                            </div>
                        </div>
                        <div class="statement-period">
                            <p><span class="text-bold">Statement Period</span><br/>Aug 1, 2014 to Aug 31, 2014</p>
                        </div>
                        <div class="beginning-balance">
                            <div class="wrap">
                            <div class="j-row">
                                <p class="j-col1 text-bold">Beginning Balance</p>
                                <p class="j-col2 text-bold">$0.00</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Total Debits</p>
                                <p class="j-col2">$1,404.60</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Total Debits</p>
                                <p class="j-col2">$1,404.60</p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1">Total Debits</p>
                                <p class="j-col2">$0.00/p>
                            </div>
                            <div class="j-row">
                                <p class="j-col1 text-bold">Ending Balance</p>
                                <p class="j-col2 text-bold">$0.00</p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>  
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>
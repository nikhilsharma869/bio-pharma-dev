<?php
include "includes/header.php";
?>

<div class="spage-container" id="UserSettings_PaymentMethods">
    <div class="main_div2">
        <div class="inner-middle">    
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                    <p class="billing text-bold">Billing</p>
                    <li  class="active"><a href="<?= $vpath ?>UserSettings_PaymentMethods.html">Payment Methods</a></li>                        
                    <P class="company-seting text-bold">Company Setting</P>
                    <li><a href="<?= $vpath ?>postjob.html">Company Info</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Teams</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Staff & Permissions</a></li>   
                    <P class="company-seting text-bold">User Settings</P>                     
                    <li><a href="<?= $vpath ?>postjob.html">Contact Info</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">My Freelancer Profile</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">My Teams</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Notification Settings</a></li>
                    <a href="#" class="create-companay">Create a Company</a>
                </ul>                
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">   
                    <p class="these-paymentmethod">In order to hire a freelancer on oDesk we require complete company information and at least one
payment method on file. Remember, you don't pay for anything until after the freelancer starts working.</p> 
                    <a class="btn-add-paymentmethod btn-add-blue" href="javascript:;">Add a Payment Method</a>
                    <div class="usersetting-paymentmethod"> 
                        <table class="table table-hover">
                        <!-- heading -->
                          <thead>
                            <tr>                              
                              <th>Payment Method</th>
                              <th>Actions</th>
                              <th>AutoPay Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- content loop -->
                            <tr>
                              <td>Credit Card - xxxx</td>
                              <td></td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Credit Card - xxxx</td>
                              <td></td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
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

<?php
include "includes/header.php";
?>

<div class="spage-container" id="UserSettings_StaffPermissions">
    <div class="main_div2">
        <div class="inner-middle">    
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                    <p class="billing text-bold">Billing</p>
                    <li ><a href="<?= $vpath ?>UserSettings_PaymentMethods.html">Payment Methods</a></li>                        
                    <P class="company-seting text-bold">Company Setting</P>
                    <li><a href="<?= $vpath ?>postjob.html">Company Info</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Teams</a></li>
                    <li class="active"><a href="<?= $vpath ?>UserSettings_StaffPermissions.html">Staff & Permissions</a></li>   
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
                    <div class="select-box">
                        <select class="selectyze2" name="select-my-team" id="select-my-team">
                            <option value="">Select Team</option>
                            <option value="Mycs">Mycs</option>
                            <option value="Mycs">Mycs</option>
                        </select> 
                    </div>
                    <a class="btn-invite-user-toteam btn-add-blue" href="javascript:;">Invite New User</a>
                    <div class="usersetting-csteams"> 
                        <table class="table table-hover">
                        <!-- heading -->
                          <thead>
                            <tr>                              
                              <th>User</th>
                              <th>Admin Privileges</th>
                              <th>Hiring Privileges</th>
                              <th>Work Diary Access</th>
                              <th>Chat Access</th>
                              <th>Remove from Team</th>
                            </tr>
                          </thead>
                          <tbody>
                            <!-- content loop -->
                            <tr>
                              <td>Raj Desai</td>
                              <td>Administrator</td>
                              <td>Hiring Manager</td>
                              <td>Full</td>
                              <td>Full</td>
                              <td></td>
                            </tr>
                            <tr>
                              <td>Raj Desai</td>
                              <td>Administrator</td>
                              <td>Hiring Manager</td>
                              <td>Full</td>
                              <td>Full</td>
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

<?php
include "includes/header.php";
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
if (!empty($row_user[logo])) {
    $temp_logo = $row_user[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}
?>

<div class="spage-container job_work_diary" id="userSettings_ContactInfo">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="<?=$vpath?>userSettings_ContactInfo.html">Contact Info</a></li>                        
                    <li><a href="<?=$vpath?>userSettings_TaxInformation.html">Tax Information</a></li>
                    <li><a href="<?=$vpath?>publicprofile/<?=$row_user['username']?>">My SME Profile</a></li>
                    <li><a href="<?=$vpath?>userSettings_GetPaid.html">Get Paid</a></li>                        
                    <li><a href="<?=$vpath?>userSettings_MyTeams.html">My Teams</a></li>
                    <li><a href="<?=$vpath?>userSettings_NotificationSettings.html">Notification Settings</a></li>
                    <a href="#" class="create-companay">Create a Company</a>
                </ul>                
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">    
                    <div class="user-wrap">                
                    <div class="user-info info-box">
                        <div class="u-account">
                            <h5>Account</h5>
                            <a href="#" class="u-edit">Edit</a>
                        </div>
                        <div class="u-info">    
                            <div class="p-row">                            
                                <p>UserID</p><p><?=$row_user['username']?></p>                                 
                            </div>
                            <div class="p-row">
                                <p>Name</p><p><?=$row_user['fname'].' '.$row_user['lname']?></p>
                            </div>
                            <div class="p-row">
                                <p class="tex">Protrait</p>
                                <p class="protrait">
                                    <span class="pro-img"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=130&height=130" alt="" /></span>
                                    <span class="dag-photo">Drag in a new photo, or: </span>
                                    <span class="u-control"><a href="" class="edit-photo">Edit photo</a>|<a href="#" class="delete-photo">Delete photo</a></span></p>
                            </div>
                            <div class="p-row">
                                <p>Email</p><p><?=$row_user['email']?></p>
                            </div>
                            <div class="p-row">
                                <p>Security (SMS) Email </p><p><?=$row_user['email']?></p>
                            </div>
                            <div class="p-row"><a href="#" class="close-account">Close Account</a></div>
                        </div>
                    </div>
                    <div class="location-info info-box">
                        <div class="u-account">
                            <h5>Location</h5>
                            <a href="#" class="u-edit">Edit</a>
                        </div>
                        <div class="u-info">    
                            <div class="p-row">
                                <p>Time Zone</p><p>UTC+08:00 Hong Kong SAR, Perth, Singapore, Taipei </p>                           
                            </div>
                            <div class="p-row">
                                <p>Address:</p>
                                <p>65 F Llamas Street<br/>
                                Labangon, Cebu City<br/>
                                6000 Philippines</p>
                            </div>
                            <div class="p-row">
                                <p>Phone</p><p><?=$row_user['phone']?></p>
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
</div>
</div>  
</div>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>

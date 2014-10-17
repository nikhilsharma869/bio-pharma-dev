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
            <?php include 'includes/dashboard_menu.php';?> 
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">    
                    <div class="user-wrap">                
                    <div class="user-info info-box">
                        <div class="u-account">
                            <h5>Account</h5>
                            
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

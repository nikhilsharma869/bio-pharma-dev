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
                    <p class="billing text-bold">Billing</p>
                    <li><a href="http://bio-pharma.dev/postjob.html">Payment Methods</a></li>                        
                    <P class="company-seting text-bold">Company Setting</P>
                    <li class="active"><a href="http://bio-pharma.dev/postjob.html">Company Info</a></li>
                    <li><a href="http://bio-pharma.dev/postjob.html">Teams</a></li>
                    <li><a href="http://bio-pharma.dev/postjob.html">Staff & Permissions</a></li>   
                    <P class="company-seting text-bold">User Settings</P>                     
                    <li><a href="http://bio-pharma.dev/postjob.html">Contact Info</a></li>
                    <li><a href="http://bio-pharma.dev/postjob.html">My Freelancer Profile</a></li>
                    <li><a href="http://bio-pharma.dev/postjob.html">My Teams</a></li>
                    <li><a href="http://bio-pharma.dev/postjob.html">Notification Settings</a></li>
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
                            <h5>Company Profile Info</h5>
                            <a href="#" class="u-edit">Edit</a>
                        </div>
                        <div class="u-info">    
                            <div class="p-row">                            
                                <p>Company Name</p><p>MyCS</p>                                 
                            </div>
                            <div class="p-row">
                                <p>Tagline</p><p>You can do it!</p>
                            </div>                            
                            <div class="p-row">
                                <p>Descripton</p><p>Company description here.</p>
                            </div>
                            <div class="p-row">
                                <p class="tex">Protrait</p>
                                <p class="protrait">
                                    <span class="pro-img"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=130&height=130" alt="" /></span>
                                    <span class="dag-photo"><a href="" class="edit-photo">Add logo now</a></span>
                            </div>
                            <div class="p-row">
                                <p>Company Website</p><p>www.myCS.com</p>
                            </div>
                            <div class="p-row">
                                <p>Show company info<br/>on job posts</p><p>No</p>
                            </div>
                        </div>
                    </div>
                    <div class="location-info info-box">
                        <div class="u-account">
                            <h5>Company Contact Info </h5>
                            <a href="#" class="u-edit">Edit</a>
                        </div>
                        <div class="u-info">    
                            <div class="p-row">
                                <p>Company Owner</p><p>Raj Desai</p>
                            </div>
                            <div class="p-row">
                                <p>Adress</p><p>My Address<br/>1111 California Street</p>
                            </div>
                            <div class="p-row">
                                <p>City</p><p>New Yourk</p>
                            </div>
                            <div class="p-row">
                                <p>Country</p><p>USA</p>
                            </div>
                            <div class="p-row">
                                <p>Postoal Code</p><p>185656</p>
                            </div>
                            <div class="p-row">
                                <p>Timezone</p><p>UTC-4:00 New York, USA</p>
                            </div>
                            <div class="p-row">
                                <p>Phone</p><p>+510 (925) 654-5198 </p>
                            </div>
                            <div class="p-row">
                                <p>Vat ID</p><p>551514864</p>
                            </div>
                            <div class="p-row">
                                <p>Address:</p>
                                <p>65 F Llamas Street<br/>
                                Labangon, Cebu City<br/>
                                6000 Philippines</p>
                            </div>
                            <div class="p-row pd-bt-20">
                                <p>Phone</p><p>+63 9399043376</p>
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

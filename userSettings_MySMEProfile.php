<?php
include "includes/header.php";
$row_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'"));
if (!empty($row_user[logo])) {
    $temp_logo = $row_user[logo];
} else {
    $temp_logo = "images/face_icon.gif";
}
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$cn=array('user_id','email','username','user_type','password','fname','lname','status','country','logo','profile','company','slogan','account_type');


$row=mysql_fetch_array($res);
if($row['gold_member']=='Y') {
    $mem=mysql_query("select * from ".$prev."membership where id=2");
    $rowmem=mysql_fetch_array($mem);
} else{
    $mem=mysql_query("select * from ".$prev."membership where id=1");
    $rowmem=mysql_fetch_array($mem);        
}

$contnu=0;

for($cn1=0;$cn1<=50;$cn1++) {
    if($row[$cn[$cn1]]!='') {
        $contnu++;  
    }
}

$prfcomplt = ($contnu*80)/count($cn)+10;
if($row[rate] > 0) {
    $prfcomplt =$prfcomplt+10;
}
?>

<div class="spage-container job_work_diary" id="userSettings_ContactInfo">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <?php
                    $parent = 'dashboard_sme';          
                    $current = 'sme_profile_setting';
                    $current_sub = '';
                    get_child_menu($parent, $current, $current_sub);
                ?>              
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">    
                    <div class="user-wrap">                
                        <div class="user-info info-box">
                            <div class="u-account">
                                <h5>My Account Summary</h5>
                                
                            </div>
                            <div class="u-info">    
                                <div class="p-row">                            
                                    <p>Title</p><p><?=ucfirst($row_user['slogan'])?></p>                                 
                                </div>
                                <div class="p-row">
                                    <p class="tex">Protrait</p>
                                    <p class="protrait">
                                        <span class="pro-img"><img src="<?= $vpath ?>viewimage.php?img=<?php echo $temp_logo; ?>&width=130&height=130" alt="" /></span>
                                    </div>
                                    <div class="p-row">
                                        <p>Personal Email</p><p><?=$row_user['email']?></p>
                                    </div>
                                    <div class="p-row">
                                        <p>Hourly Pay Rate</p><p id="rate2change">$<span class="val2change"><?=$row_user['rate']?></span> <a href="javascript:;" class="btn-change">Change</a></p>
                                    </div>
                                    <div class="p-row">
                                        <p>Profile Completeness</p><p><?=round($prfcomplt);?>%</p>
                                    </div>
                                </div>
                            </div>                      

                        <div class="user-info info-box">
                            <div class="u-account">
                                <h5>My Public Profile</h5>
                                
                            </div>      
                            <p class="view-profile"><a href="#">View My Profile as others see it</a></p>                                                  
                            <div class="u-info">                                    
                                <div class="p-row">                            
                                    <p>Profile Access</p><p>Public</p>                                 
                                </div>                                
                                    <div class="p-row">
                                        <p>Display Name</p><p><?=$row_user['fname'].' '.$row_user['lname']?></p>
                                    </div>
                                    <div class="p-row">
                                        <p>Title</p><p><?=ucfirst($row_user['slogan'])?></p>
                                    </div>
                                    <div class="p-row">
                                        <p>Years of Experience</p><p>12</p>
                                    </div>
                                    <div class="p-row">
                                        <p>Overview</p><p><?=$row_user['profile']?></p>
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
<script type="text/javascript">
    function cancelChange(id,cur_val) {
        var parent = $('#'+id);
        parent.find('.val2change').html(cur_val);
        parent.find('.btn-ch-cancel').remove();
        parent.find('.btn-change').text('Change');
    }
    $(document).ready(function(){
        $('.btn-change').on('click', function(){
            var parent = $(this).parent();
            var pid = parent.attr('id');
            if($(this).text() == "Change") {
                $(this).text('Update');
                var input_change = parent.find('.val2change');
                var cur_val = input_change.text();
                input_change.html('<input type="text" id="'+pid+'-input" value="'+cur_val+'" />');
                parent.append('<a href="javascript:;" onclick="cancelChange(\''+pid+'\',\''+cur_val+'\')" class="btn-ch-cancel">Cancel</a>')
            } else {
                var new_val = parent.find('#'+pid+'-input').val();
                $.ajax({
                   url: '<?= $vpath; ?>ajax_action.php',
                   data: {action: 'update_user_field', f2change: pid, user_id: '<?=$_SESSION['user_id']?>', new_val: new_val},
                   success: function(data) {
                         cancelChange(pid,new_val);
                   }
                });
            }
        });

    })
</script>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>  
<?php include 'includes/footer.php'; ?>

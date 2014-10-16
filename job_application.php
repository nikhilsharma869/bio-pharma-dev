<?php
include "includes/header.php";
CheckLogin();
?>

<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->

    <div class="spage-container job_application">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left">
                    <!-- tabs left -->
                    <?php
                        $parent = 'find_work';
                        $current = 'job_application';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
                    ?>
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div id="job_tabs">
                            <ul>
                                <li class="active"><a data-toggle="tab" href="#tabs-1">Active</a></li>
                                <li><a data-toggle="tab" href="#tabs-2">Archive</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="tabs-1" class="tab-pane fade in active tab-first">
                                    <div class="tab-item">
                                        <h4 class="j-title4">Active Candidacies</h4>
                                        <!-- Row Header -->
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Received</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <!-- End Row Header -->
                                         <!-- Row Content Loop -->
                                        <?php
                                            $list_hire = get_hire_job($_SESSION[user_id]);
                                            // echo "<pre>";
                                            // var_dump($list_inter);
                                            if(count($list_hire) == 0) { ?>
                                                <div class="alert alert-warning" role="alert" style="margin-top: 20px;"><?=$lang['NO_DATA']?></div>
                                            <?php }
                                            for ($i=0; $i < count($list_hire); $i++) :
                                                if($i == count($list_hire) - 1) {
                                                    $last_row = 'last';
                                                } else {
                                                    $last_row = '';
                                                }
                                                $received_date = date('M d', strtotime($list_hire[$i]['sent']));
                                                if($list_hire[$i]['date_diff'] == 0) {
                                                    $time = 'Today';
                                                } elseif ($list_hire[$i]['date_diff'] == 1) {
                                                    $time = 'Yesterday';
                                                } else {
                                                    $time = $list_hire[$i]['date_diff'].' days ago';
                                                }
                                            ?>
                                                <div class="j-row <?php echo $last_row; ?>">
                                                    <p class="j-col1"><?php echo $received_date; ?><br/><span class="small-text"><?php echo $time; ?></span></p>
                                                    <p class="j-col2"><a href="<? $vpath?>/project/<?php echo $list_hire[$i]['id'];?>"><?php echo $list_hire[$i]['project']; ?> (<?php echo $list_hire[$i]['id']; ?>) </a></p>
                                                    <p class="j-col3"><a href="<? $vpath?>/publicprofile/<?php echo $list_hire[$i]['username'];?>"><?php echo $list_hire[$i]['fname'].' '.$list_hire[$i]['lname']; ?> </a></p>
                                                </div>
                                            <?php
                                                
                                            endfor;
                                        ?>         
                                        <!-- End Row Content Loop -->    
                                    </div>
                                    <div class="tab-item">
                                        <h4 class="j-title4">Invitations to Interview</h4>
                                        <!-- Row Header -->
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Received</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <!-- End Row Header -->
                                        <!-- Row Content Loop -->
                                        <?php
                                            $list_inter = get_interview_list($_SESSION[user_id]);
                                            // echo "<pre>";
                                            // var_dump($list_inter);
                                            if(count($list_inter) == 0) { ?>
                                                <div class="alert alert-warning" role="alert" style="margin-top: 20px;"><?=$lang['NO_DATA']?></div>
                                            <?php }
                                            for ($i=0; $i < count($list_inter); $i++) :
                                                if($i == count($list_inter) - 1) {
                                                    $last_row = 'last';
                                                } else {
                                                    $last_row = '';
                                                }
                                                $received_date = date('M d', strtotime($list_inter[$i]['sent']));
                                                if($list_inter[$i]['date_diff'] == 0) {
                                                    $time = 'Today';
                                                } elseif ($list_inter[$i]['date_diff'] == 1) {
                                                    $time = 'Yesterday';
                                                } else {
                                                    $time = $list_inter[$i]['date_diff'].' days ago';
                                                }
                                            ?>
                                                <div class="j-row <?php echo $last_row; ?>">
                                                    <p class="j-col1"><?php echo $received_date; ?><br/><span class="small-text"><?php echo $time; ?></span></p>
                                                    <p class="j-col2"><a href="<? $vpath?>/project/<?php echo $list_inter[$i]['id'];?>"><?php echo $list_inter[$i]['project']; ?> (<?php echo $list_inter[$i]['id']; ?>) </a></p>
                                                    <p class="j-col3"><a href="<? $vpath?>/publicprofile/<?php echo $list_inter[$i]['username'];?>"><?php echo $list_inter[$i]['fname'].' '.$list_inter[$i]['lname']; ?> </a></p>
                                                </div>
                                            <?php
                                                
                                            endfor;
                                        ?>         
                                        <!-- End Row Content Loop -->          
                                    </div>  
                                    <div class="tab-item">
                                        <h4 class="j-title4">Sent Job Applications</h4>
                                        <!-- Row Header -->
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Sent</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <!-- End Row Header -->
                                        <!-- Row Content Loop -->
                                        <?php
                                            $list_sent_bid = get_sent_job($_SESSION[user_id]);
                                            if(count($list_sent_bid) == 0) { ?>
                                                <div class="alert alert-warning" role="alert" style="margin-top: 20px;"><?=$lang['NO_DATA']?></div>
                                            <?php }
                                            for ($i=0; $i < count($list_sent_bid); $i++) :
                                                if($i == count($list_sent_bid) - 1) {
                                                    $last_row = 'last';
                                                } else {
                                                    $last_row = '';
                                                }
                                                $received_date = date('M d', strtotime($list_sent_bid[$i]['add_date']));
                                                if($list_sent_bid[$i]['date_diff'] == 0) {
                                                    $time = 'Today';
                                                } elseif ($list_sent_bid[$i]['date_diff'] == 1) {
                                                    $time = 'Yesterday';
                                                } else {
                                                    $time = $list_sent_bid[$i]['date_diff'].' days ago';
                                                }
                                            ?>
                                                <div class="j-row <?php echo $last_row; ?>">
                                                    <p class="j-col1"><?php echo $received_date; ?><br/><span class="small-text"><?php echo $time; ?></span></p>
                                                    <p class="j-col2"><a href="<? $vpath?>/project/<?php echo $list_sent_bid[$i]['id'];?>"><?php echo $list_sent_bid[$i]['project']; ?> (<?php echo $list_sent_bid[$i]['id']; ?>) </a></p>
                                                    <p class="j-col3"><a href="<? $vpath?>/publicprofile/<?php echo $list_sent_bid[$i]['username'];?>"><?php echo $list_sent_bid[$i]['fname'].' '.$list_sent_bid[$i]['lname']; ?> </a></p>
                                                </div>
                                            <?php
                                                
                                            endfor;
                                            
                                        ?>         
                                        <!-- End Row Content Loop -->       
                                    </div>                     
                                </div>
                                <div id="tabs-2" class="tab-pane fade">
                                    
                                    <div class="tab-item">
                                        <h4 class="j-title4">Archive Sent Job Applications</h4>
                                        <!-- Row Header -->
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Sent</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <!-- End Row Header -->
                                        <!-- Row Content Loop -->
                                        <?php
                                            $list_archive_bid = get_archive_job($_SESSION[user_id]);
                                            if(count($list_archive_bid) == 0) { ?>
                                                <div class="alert alert-warning" role="alert" style="margin-top: 20px;"><?=$lang['NO_DATA']?></div>
                                            <?php }
                                            for ($i=0; $i < count($list_archive_bid); $i++) :
                                                if($i == count($list_archive_bid) - 1) {
                                                    $last_row = 'last';
                                                } else {
                                                    $last_row = '';
                                                }
                                                $received_date = date('M d', strtotime($list_archive_bid[$i]['add_date']));
                                                if($list_archive_bid[$i]['date_diff'] == 0) {
                                                    $time = 'Today';
                                                } elseif ($list_archive_bid[$i]['date_diff'] == 1) {
                                                    $time = 'Yesterday';
                                                } else {
                                                    $time = $list_archive_bid[$i]['date_diff'].' days ago';
                                                }
                                            ?>
                                                <div class="j-row <?php echo $last_row; ?>">
                                                    <p class="j-col1"><?php echo $received_date; ?><br/><span class="small-text"><?php echo $time; ?></span></p>
                                                    <p class="j-col2"><a href="<? $vpath?>/project/<?php echo $list_archive_bid[$i]['id'];?>"><?php echo $list_archive_bid[$i]['project']; ?> (<?php echo $list_archive_bid[$i]['id']; ?>) </a></p>
                                                    <p class="j-col3"><a href="<? $vpath?>/publicprofile/<?php echo $list_archive_bid[$i]['username'];?>"><?php echo $list_archive_bid[$i]['fname'].' '.$list_archive_bid[$i]['lname']; ?> </a></p>
                                                </div>
                                            <?php
                                                
                                            endfor;
                                            
                                        ?>         
                                        <!-- End Row Content Loop -->       
                                    </div>                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>  
    </div>
    <script>
        $(function() {
            $('#job_tabs li a').click(function (e) {
                e.preventDefault()
                $(this).tab('show');
            })
        });
    </script>
    <?php include 'includes/footer.php'; ?>
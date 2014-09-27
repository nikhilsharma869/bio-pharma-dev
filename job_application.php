<?php
include "includes/header.php";
?>

<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->

    <div class="spage-container job_application">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left">
                    <!-- tabs left -->
                    <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                        <li><a href="<?= $vpath ?>postjob.html">Job Postings</a></li>
                        <li class="active"><a href="<?= $vpath ?>postjob.html">Post a Job</a></li>
                        <li><a href="<?= $vpath ?>postjob.html">Find Freelancers</a></li>
                        <li><a href="<?= $vpath ?>postjob.html">Saved Freelancers</a></li>
                    </ul>
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
                                        <div class="j-row">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>   
                                        <div class="j-row last">
                                            <p class="j-col1 text-bold">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>             
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
                                                    $time = '1 day ago';
                                                } else {
                                                    $time = $list_inter[$i]['date_diff'].' days ago';
                                                }
                                            ?>
                                                <div class="j-row <?php echo $last_row; ?>">
                                                    <p class="j-col1"><?php echo $received_date; ?><br/><span class="small-text"><?php echo $time; ?></span></p>
                                                    <p class="j-col2"><?php echo $list_inter[$i]['project']; ?> (<?php echo $list_inter[$i]['id']; ?>) </p>
                                                    <p class="j-col3"><?php echo $list_inter[$i]['fname'].' '.$list_inter[$i]['lname']; ?></p>
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
                                            <p class="j-col1 text-bold">Received</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <!-- End Row Header -->
                                        <!-- Row Content Loop -->
                                        <div class="j-row">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>   
                                        <div class="j-row last">
                                            <p class="j-col1 text-bold">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>             
                                        <!-- End Row Content Loop -->      
                                    </div>                     
                                </div>
                                <div id="tabs-2" class="tab-pane fade">
                                    <div class="tab-item">
                                        <h4 class="j-title4">Active Candidacies</h4>
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Received</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <div class="j-row">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>
                                        <div class="j-row">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>
                                        <div class="j-row last">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>
                                    </div>
                                    <div class="tab-item">
                                        <h4 class="j-title4">Invitations to Interview</h4>
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Received</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <div class="j-row">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>   
                                        <div class="j-row last">
                                            <p class="j-col1 text-bold">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>                   
                                    </div>  
                                    <div class="tab-item">
                                        <h4 class="j-title4">Sent Job Applications</h4>
                                        <div class="j-row">
                                            <p class="j-col1 text-bold">Received</p>
                                            <p class="j-col2 text-bold">Job</p>
                                            <p class="j-col3 text-bold">Client</p>
                                        </div>
                                        <div class="j-row">
                                            <p class="j-col1">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
                                        </div>   
                                        <div class="j-row last">
                                            <p class="j-col1 text-bold">July 10<br/><span class="small-text">28 days ago</span></p>
                                            <p class="j-col2">G'day Philippines ebrochure design (274608860) </p>
                                            <p class="j-col3">G'day Philippines</p>
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
    <script>
        $(function() {
            $('#job_tabs li a').click(function (e) {
                e.preventDefault()
                $(this).tab('show');
            })
        });
    </script>
    <?php include 'includes/footer.php'; ?>
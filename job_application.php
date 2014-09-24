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
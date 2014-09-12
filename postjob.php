<?php
$current_page = "Post your job";
include "includes/header.php";
CheckLogin();
$expdays = 14; /* * *****Project Expire days********* */
$restest = mysql_query("select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'");
$rowtest = mysql_fetch_array($restest);
$_REQUEST['firstname'] = $rowtest['fname'];
$_REQUEST['lastname'] = $rowtest['lname'];
?>
<div class="spage-container">
    <div class="main_div2">
        <div class="inner-middle"> 
            <div class="profile_left">
                <ul id="up-tabs" class="nav nav-tabs" role="tablist">
                    <li><a href="<?= $vpath ?>postjob.html">Job Postings</a></li>
                    <li class="active"><a href="<?= $vpath ?>postjob.html">Post a Job</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Find Freelancers</a></li>
                    <li><a href="<?= $vpath ?>postjob.html">Saved Freelancers</a></li>
                </ul>
            </div>
            <div class="profile_right">
                <div class="form-post-a-job">
                    <form class="form-horizontal" role="form" id="postproject" name="postjob" method="post" action="<?= $vpath ?>postjob.html" enctype="multipart/form-data" >
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Give your job a title</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div>  
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Describe the work to be done</label>
                            <div class="col-sm-9">
                              <textarea class="form-control" rows="10"></textarea>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">What skills are needed?</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">How would you like to pay?</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Estimated Duration</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Estimated Workload</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Desired Experience Level</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Number of Hires</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Attached a document</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="project" id="project">
                            </div>
                        </div> 
                        <div class="screen-quest">
                            <h2>Screening Questions</h2>
                            <p>Add a few questions you'd like you candidates to answer when applying to your job.</p>
                            <input type="text" class="form-control" name="project" id="project">
                            <button type="button" class="btn btn-link"><i class="fa fa-plus"></i>&nbsp;Add Another Question</button>
                        </div>
                        <div>
                            <button type="button" class="btn btn-primary">Primary</button>
                            <button type="button" class="btn btn-default">Default</button>
                            <button type="button" class="btn btn-link">Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>
<?php 
$openjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='open'"));
$frozenjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='frozen'"));
$completedjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='complete'"));
$cancelledjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='cancelled'"));
$expiredjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status IN ('expire')"));
$processjobs = @mysql_num_rows(mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='process'"));

$alljobs = $openjobs+$frozenjobs+$completedjobs+$cancelledjobs+$processjobs+$expiredjobs;
?>
<ul id="up-tabs" class="nav nav-tabs" role="tablist">
	<li <?php if($cur_par_menu =='job_posting' ) echo "class='active'"?>>
		<a href="<?= $vpath ?>my-jobs.html">Job Postings</a>
	</li>
	<ul class="child_menu"  <?php if($cur_par_menu !='job_posting' ) echo "style='display:none'"?>>
		<li <?php if($cur_child_menu =='my_projects' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>my-jobs.html"  >My Projects (<?=$alljobs?>)</a>
		</li>		
		<li <?php if($cur_child_menu =='active_job' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>active_jobs.html"  >Active Jobs (<?=$openjobs?>)</a>
		</li>	
		<li <?php if($cur_child_menu =='frozen_project' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>frozen_project.html"  >Frozen Projects (<?=$frozenjobs?>)</a>
		</li>	
		<li <?php if($cur_child_menu =='running_jobs' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>running_jobs.html" >Working Projects (<?=$processjobs?>)</a>
		</li>
		<li <?php if($cur_child_menu =='expire_project' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>expire_project.html" >Expire Projects (<?=$expiredjobs?>)</a>
		</li>	
		<li <?php if($cur_child_menu =='complete_project' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>closed_jobs.html" >Completed Projects (<?=$completedjobs?>)</a>
		</li>
		<li>
			<a href="<?= $vpath ?>canceled_project.html" >Canceled Projects (<?=$cancelledjobs?>)</a>
		</li>	
	</ul>	
	<li <?php if($cur_par_menu =='post_job' ) echo "class='active'"?>><a href="<?= $vpath ?>postjob.html">Post a Job</a></li>
	<li <?php if($cur_par_menu =='find_freelancer' ) echo "class='active'"?>><a href="<?= $vpath ?>find-talents">Find Freelancers</a></li>
	<li <?php if($cur_par_menu =='save_freelancer' ) echo "class='active'"?>><a href="<?= $vpath ?>postjob.html">Saved Freelancers</a></li>
</ul>
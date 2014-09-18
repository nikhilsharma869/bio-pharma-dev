
<ul id="up-tabs" class="nav nav-tabs" role="tablist">
	<li <?php if($cur_par_menu =='job_posting' ) echo "class='active'"?>>
		<a href="<?= $vpath ?>active_jobs.html">Job Postings</a>
	</li>
	<ul class="child_menu"  <?php if($cur_par_menu !='job_posting' ) echo "style='display:none'"?>>
		<li <?php if($cur_child_menu =='active_job' ) echo "class='active'"?>>
			<a href="<?= $vpath ?>active_jobs.html"  >Active Jobs</a>
		</li>	
		<li>
			<a href="http://bio-pharma.com/myprofile.html" >Frozen Projects</a>
		</li>	
		<li>
			<a href="http://bio-pharma.com/myprofile.html" >Working Projects</a>
		</li>
		<li>
			<a href="http://bio-pharma.com/myprofile.html" >Expire Projects</a>
		</li>	
		<li>
			<a href="http://bio-pharma.com/myprofile.html" >Completed Projects</a>
		</li>
	</ul>	
	<li <?php if($cur_par_menu =='post_job' ) echo "class='active'"?>><a href="<?= $vpath ?>postjob.html">Post a Job</a></li>
	<li <?php if($cur_par_menu =='find_freelancer' ) echo "class='active'"?>><a href="<?= $vpath ?>find-talents">Find Freelancers</a></li>
	<li <?php if($cur_par_menu =='save_freelancer' ) echo "class='active'"?>><a href="<?= $vpath ?>postjob.html">Saved Freelancers</a></li>
</ul>
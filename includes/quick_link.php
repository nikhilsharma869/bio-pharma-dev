<div class="create_profile2_right"><div class="qucik_text">
  <h1><?=$lang['MY_QUICK_LINK']?></h1>
              <div class="profile_box_link">
              <ul>
			  <?php if($_SESSION['user_type']=='W')
			  {
			  ?>
			  		 <li><a href="<?=$vpath?>mybids.html"><span><img src="<?=$vpath?>images/1_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_BIDS']?></a></li>
					 <li><a href="<?=$vpath?>sear_all_jobs.html"><span><img src="<?=$vpath?>images/2_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['FIND_JOB']?></a></li>
					 <li><a href="<?=$vpath?>closedbids.html"><span><img src="<?=$vpath?>images/4_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_CONTRACT_JOBS']?></a></li>
			 <?php
			  }
			  else if($_SESSION['user_type']=='E')
			  {
			  ?>
                <li><a href="<?=$vpath?>my-jobs.html"><span><img src="<?=$vpath?>images/1_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_JOBS']?></a></li>
                <li><a href="<?=$vpath?>postjob.html"><span><img src="<?=$vpath?>images/2_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['POST_JOB']?></a></li>
                <li><a href="<?=$vpath?>active_jobs.html"><span><img src="<?=$vpath?>images/4_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_CONTRACT_JOBS']?></a></li>
			<?php
				}
				else
				{
				?>
					<li><a href="<?=$vpath?>my-jobs.html"><span><img src="<?=$vpath?>images/1_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_JOBS']?></a></li>
					<li><a href="<?=$vpath?>mybids.html"><span><img src="<?=$vpath?>images/1_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_BIDS']?></a></li>
					<li><a href="<?=$vpath?>sear_all_jobs.html"><span><img src="<?=$vpath?>images/2_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['FIND_JOB']?></a></li>
					<li><a href="<?=$vpath?>postjob.html"><span><img src="<?=$vpath?>images/2_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['POST_JOB']?></a></li>
					<li><a href="<?=$vpath?>closedbids.html"><span><img src="<?=$vpath?>images/4_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_CONTRACT_JOBS']?></a></li>
			<?php
			}
			?>
				
                <li><a href="<?=$vpath?>payment/dsp/"><span><img src="<?=$vpath?>images/5_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_ERNINGS']?> (<?=$balsum?><?=$curn?>)</a></li>
                <li><a href="<?=$vpath?>publicprofile/<?=$_SESSION['username']?>/"><span><img src="<?=$vpath?>images/6_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['PUBLIC_PROFILE']?></a></li>
				 <li><a href="<?=$vpath?>milestone.html"><span><img src="<?=$vpath?>images/3_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MILESTONES']?></a></li>
              </ul>
              <br />
            </div>
</div></div>
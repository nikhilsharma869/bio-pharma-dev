<div class="browse_contract_right">
   <div class="browse_right_text">
     <h1><?=$lang['INBOX']?></h1>
   </div><br>
<div>
<div class="profile_box_link" style="width:100%;">    
    <!--<ul>
		<li><a href="#">Notification : &nbsp;&nbsp;&nbsp;&nbsp; <span>6</span></a></li>
		<li><a href="#">Messages &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<span>2</span></a></li>
		<li><a href="#">Post a Job &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<span>4</span></a></li>
		<li><a href="#">Find a job &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<span>12</span></a></li> 
		<li><a href="#">Public Profile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<span>12</span></a></li> 
		<li><a href="#">Total Bids on this Project &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<span>12</span></a></li> 
     </ul>-->
	 <ul style="width:100%;">
			  <?php if($_SESSION['user_type']=='W')
			  {
			  ?>
			  		 <li><a href="mybids.php"><span><img src="images/1_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_BIDS']?></a></li>
					 <li><a href="sear_all_jobs.html"><span><img src="images/2_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['FIND_JOB']?></a></li>
					 <li><a href="closedbids.php"><span><img src="images/4_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_CONTRACT_JOBS']?></a></li>
			 <?php
			  }
			  else if($_SESSION['user_type']=='E')
			  {
			  ?>
                <li><a href="my-jobs.php"><span><img src="images/1_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_JOBS']?></a></li>
                <li><a href="postjob.html"><span><img src="images/2_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['POST_JOB']?></a></li>
                <li><a href="active_jobs.php"><span><img src="images/4_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_CONTRACT_JOBS']?></a></li>
			<?php
				}
				else
				{
				?>
					<li><a href="my-jobs.php"><span><img src="images/1_icon.png" alt="MyJobs" title="My Jobs" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_JOBS']?></a></li>
					<li><a href="mybids.php"><span><img src="images/1_icon.png" alt="MyBids" title="My Bids" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_BIDS']?></a></li>
					<li><a href="sear_all_jobs.html"><span><img src="images/2_icon.png" alt="FindaJob" title="Find a Job" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['FIND_JOB']?></a></li>
					<li><a href="postjob.html"><span><img src="images/2_icon.png" alt="Post a Job" title="Post a Job" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['POST_JOB']?></a></li>
					<li><a href="closedbids.php"><span><img src="images/4_icon.png" alt="MyContractJobs" title="My Contract Jobs" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_CONTRACT_JOBS']?></a></li>
			<?php
			}
			?>
				
                <li><a href="<?=$vpath?>payment/dsp/"><span><img src="<?=$vpath?>images/5_icon.png" alt="MyEarnings" title="My Earnings" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['MY_EARNINGS']?> (<?=$curn?><?=$balsum?>)</a></li>
                <li><a href="<?=$vpath?>publicprofile/<?=$_SESSION['username']?>/"><span><img src="<?=$vpath?>images/6_icon.png" alt="PublicProfile" title="Public Profile" width="18" height="15" /></span>&nbsp;&nbsp;<?=$lang['PUBLIC_PROFILE']?></a></li>
				 <!--<li><a href="payment.php?type=dsp"><span><img src="images/3_icon.png" width="18" height="15" /></span>&nbsp;&nbsp;Deposit Funds</a></li>-->
				 
				
              </ul>
			  
   </div>

	
   </div>

   </div>
<?php
include "includes/header.php";
$current_page = "Saved Freelancers";
$cur_par_menu = "saved_freelancers";
$cur_child_menu = "";



  $sql = "select * from  " . $prev . "user 
					left join " . $prev . "wishlist on " . $prev . "wishlist.uid=" . $prev . "user.user_id  
					
					left join ".$prev."user_profile on ".$prev."user_profile.user_id=".$prev."user.user_id
					
					where  status='Y' and " . $prev . "wishlist.uid=" . $prev . "user.user_id and " . $prev . "wishlist.user_id=" . $_SESSION['user_id'] . " ";
  
	$r = mysql_query($sql);

?>
<div class="spage-container recruit_savedFreelancers">
    <div class="main_div2">
        <div class="inner-middle"> 
            <!-- Sidebar left -->
            <div class="profile_left contracts_left">
                <!-- tabs left -->
                <?php require("includes/left_menu_job_client.php");?>
            </div>
            <!-- Content right -->
            <div class="profile_right">
                <!-- content data list -->
                <div class="content-right">                                                              
                    <div class="recruit_saved_content">    
						<?php
						
						while($d=@mysql_fetch_array($r))
						{

							$name = $d[fname]." ".$d[lname];
							if(!empty($d[logo]))
							{
								$temp_logo=$d[logo];
							}
							else
							{
							   $temp_logo="images/face_icon.gif";
							}	
						?>	
                        <div class="item">
                            <div class="left-item">
                                <img src="<?=$vpath?>viewimage.php?img=<?php echo $temp_logo;?>&amp;width=100&amp;height=100" alt=""/>
                            </div>
                            <div class="right-item">
                                <p class="bt-contact"><a href="<?=$vpath;?>publicprofile/<?=$d[username]?>/">Contact</a></p>
                                <h4 class="title-h4"><?=$name?></h4>
                                <p class="text-bold"><?=ucfirst($d['slogan'])?></p>
                                <p><? echo substr($d[profile],0,200);?></p>
                                    <div id="recruit_saved_tabs">
                                        <ul>
											<?
       
												$skill_q = "select skills from " . $prev . "user_profile where user_id=" . $d[user_id];

												$res_skill = mysql_query($skill_q);
												$data_skills = @mysql_result($res_skill,0,"skills");
												$data_skills = explode(',', $data_skills);

												foreach ($data_skills as $skill) {
													$data_skill_name.= "<li><a href='browse-freelancers.php?keyword=".$skill."' class='skils_links'>". $skill . '</a> </li> ';
												}
											   
												$skill_name = $data_skill_name;
												if($skill_name != ""){
													echo $skill_name;
												}
												
												$data_skill_name = "";
											?>	
                                       <!--     <li class="active"><a data-toggle="tab" href="#tabs-1">adobe-photoshop  </a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-2">adobe-illustrator</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-3">corel-draw</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-4">adobe-flash</a></li>-->
                                        </ul>
                                        <div class="tab-content">
                                            <div id="tabs-1" class="tab-pane fade tab-first active in">                                   
                                                <p>$<?=$d['rate']?> /hr  -  Hours: 15,272  -  Philippines  -  Last active:  15 hours ago</p>
												
                                                <p>Portfolio: 67 - <?=getrating($d[user_id])?></p> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
						<?php
							}
                        ?>
                        </div>                         
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>
<?php
include "includes/header.php";
include("country.php");
CheckLogin();
$current_page = "Saved Freelancers";
$cur_par_menu = "saved_freelancers";
$cur_child_menu = "";


	$no_of_records = 1;
	$sql = "select * from  " . $prev . "user 
					left join " . $prev . "wishlist on " . $prev . "wishlist.uid=" . $prev . "user.user_id  
					
					left join ".$prev."user_profile on ".$prev."user_profile.user_id=".$prev."user.user_id
					
					where  status='Y' and " . $prev . "wishlist.uid=" . $prev . "user.user_id and " . $prev . "wishlist.user_id=" . $_SESSION['user_id'] . " ";
	//Paging
	if($_REQUEST['page']){
		$page=$_REQUEST['page'];
	}else{
		$page=0;
	}
	
	$parr=array();
	$parr=paging_new($sql,$no_of_records,$page);
	
	$limitvalue  = $parr[1];
	$total_pages = $parr[2];
	$total_item  = $parr[3];
	
	$sql .= " LIMIT $limitvalue, $no_of_records";
	
	
	//Paging
	$r = mysql_query($sql);
	
	$portfolio = get_Count_Portfolio($user_id);
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
					<?php
						echo new_pagingnew(5,$vpath.'saved_smes/','/'.$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
					?>
					
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
										<?php
											$skill_q = "select skills from " . $prev . "user_profile where user_id=" . $d[user_id];

											$res_skill = mysql_query($skill_q);
											$data_skills = @mysql_result($res_skill,0,"skills");
											$data_skills = explode(',', $data_skills);
											if(count($data_skills)>1){
										?>
                                        <ul>
											<?php
												foreach ($data_skills as $skill) {
													if($count > 5 ) break;
													$data_skill_name.= "<li><a href='browse-freelancers.php?keyword=".$skill."' class='skils_links'>". $skill . '</a> </li> ';
												}
											   
												$skill_name = $data_skill_name;
												
												echo $skill_name;
												
												
												$data_skill_name = "";
											?>	
                                        <!-- <li class="active"><a data-toggle="tab" href="#tabs-1">adobe-photoshop  </a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-2">adobe-illustrator</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-3">corel-draw</a></li>
                                            <li class=""><a data-toggle="tab" href="#tabs-4">adobe-flash</a></li>-->
                                        </ul>
										<?php } ?>
                                        <div class="tab-content">
                                            <div id="tabs-1" class="tab-pane fade tab-first active in">                                   
                                                <p>$<?=$d['rate']?> /hr  -  Hours: 15,272  -  	<span><img src="<?=$vpath?>cuntry_flag/<?=strtolower($d['country']);?>.png" title="<?=$country_array[$d['country']];?>" width="16" height="11" > <?=$country_array[$d['country']];?></span>  -  Last active:  <?php print date('d-M-Y, h:i:s a', strtotime($d['ldate']));?></p>
												
                                                <p>Portfolio: <?=$portfolio?> - <?=getrating($d[user_id])?></p> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                        
						<?php
							}
                        ?>
                        </div>  
						<?php
							echo new_pagingnew(5,$vpath.'saved_smes/','/'.$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
						?>
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>
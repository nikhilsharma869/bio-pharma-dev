<?php
include "includes/header.php";
?>
    <div class="spage-container contracts">
        <div class="main_div2">
            <div class="inner-middle"> 
                <!-- Sidebar left -->
                <div class="profile_left contracts_left">
                    <!-- tabs left -->
                    <h3 class="title-page">Contracts</h3>
                    <?php
                        $parent = 'my_job';
                        $current = 'contracts';
                        $current_sub = '';
                        get_child_menu($parent, $current, $current_sub);
				
						// $my_jobs = get_my_job($_SESSION['user_id'],'*');
						$no_of_records = 1;
						$query1=" SELECT * FROM ".$prev."projects AS p
										LEFT JOIN ".$prev."buyer_bids AS b ON p.id=b.project_id 
										LEFT JOIN ".$prev."user AS u ON p.user_id=u.user_id 
										WHERE p.chosen_id='".$_SESSION['user_id']."'
									";
						
						if($_REQUEST['page']){
							$page=$_REQUEST['page'];
						}else{
							$page=0;
						}
						
						$parr=array();
						$parr=paging_new($query1,$no_of_records,$page);
						
						$limitvalue  = $parr[1];
						$total_pages = $parr[2];
						$total_item  = $parr[3];
						
						$query1 .= " LIMIT $limitvalue, $no_of_records";
						
						$result=mysql_query($query1);
					?>		
                </div>
                <!-- Content right -->
                <div class="profile_right">
                    <!-- content data list -->
                    <div class="content-right">
                        <div class="search">
                            <form name="search-frm" action="" method="post">
                                <input type='text' name="s" placeholder="Enter Name, Title or Team">
                                <span class="checkbox_icon"><input type="checkbox" class="sv-checkbox" value="" name="ended" />
                                <i class="fa"></i></span>
                                <label>Ended Contacts</label>
                            </form>
                        </div>
                        <!--<div class="page-nav">                        
                            <ul class="nav-top">
                                <li class="nav-prev"><a href="#">Previous</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">...</a></li>
                                <li><a href="#">9</a></li>
                                <li><a href="#">10</a></li>
                                <li class="nav-next"><a href="#">Next</a></li>
                            </ul>
                        </div>-->
						<?php
							echo new_pagingnew(5,$vpath.'contracts/','/'.$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
						?>
						
                        <div class="contract-title">                            
                            <p class="j-col1 text-bold">Contracts</p>
                            <p class="j-col2 text-bold">Time Period</p>
                            <p class="j-col3 text-bold">Terms</p>
                        </div>
                        <div class="contract-content">
                        <?php
							
                            if($result!=NULL){
                                while($job=@mysql_fetch_array($result))
								{
                        ?>
                            <div class="j-row">
								<a href='<?= $vpath ?>project/<?php echo $job['project_id'];?>'><p class="j-col1"><?php echo $job['project']?></p></a>
                                <p class="j-col2"><?php echo date('M d, Y',$job['date2']); ?> - Present</p>
								<?php if($job['project_type']=='H'){ ?>
									<p class="j-col3"><span>$<?php echo $job['bid_amount'];?>/hour 1 maximum hours/week</span>
								<?php }else{ ?>
									<p class="j-col3"><span>$<?php echo $job['bid_amount'];?> fixed</span>
								<?php } ?>
                                <a href="<?= $vpath ?>work_diary/<?= $job['project_id']?>">Work Diary</a></p>
                            </div>
                            <?php }
							
							}?>
                        </div>
                       
						<?php
						echo new_pagingnew(5,$vpath.'contracts/','/'.$param,$no_of_records,0,$total_pages,$table_id='',$tbl_name='');
						?>
                     
                    </div>
                </div>
            </div>

        </div>
    </div>  
</div>
<?php include 'includes/footer.php'; ?>
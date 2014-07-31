<?php 

$current_page="Portfolio";
include "includes/header.php"; 
include("country.php");


$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".base64_decode($_GET[id])."'"));
?>

<div class="browse_contract">
  <!--Profile Left Start-->
  <?php include 'includes/left_profile.php';?>
  <!--Profile Left End-->
  <!--Profile Right Start-->
  <div class="profile_right">
    <div class="create_profile">
       <p><?=ucwords($row_user['fname']).'&nbsp;'.ucwords($row_user['lname']);?></p>
      <br />
    </div>
    <div class="create_profile2">
      <div class="create_profile2_left">
        <div class="notification">
          <div class="notification_link1" style="width: 746px;">
            <h1>Portfolio</h1>
            
				<?php
				$rr=mysql_query("select *  from " . $prev . "portfolio where user_id=" . base64_decode($_GET[id]) . " order by id desc limit 20"); 
				$pro = mysql_num_rows($rr);
				if ($pro == ""){
					echo '<div style="width:736px;padding:5px;float:left;"  align="center">';
					echo '(No Portfolio Uploaded Yet.)';
					echo '</div>';
				}
				else{
					$j=0;
					while($f=mysql_fetch_array($rr)){
						$j++;		
						$date_up=explode('-',$f[add_date]);		
						$date=$date_up[2].'-'.$date_up[1].'-'.$date_up[0];	
				?>				
					 
				<div style="width:736px;padding:5px;float:left;">
					<div style="float:left;padding: 10px;">
						<a href="portfolio1.php?id=<?php print $_GET['id'];?>&port_id=<?php print $f['id'];?>">
							<img src='viewimage.php?img=<?=$f[image];?>&width=150&height=100' border=0 >
						</a>
						<br>Updated on  <?=$date;?>
					</div>
					<div style="padding:10px 0px;">
						<u><strong><?=$f[project_title];?></strong></u><br />
						<?=substr(nl2br($f[description]),0,400)." ....";?>
						
					</div>	
					
				</div>
				<div style="border-bottom: 1px dashed #D7D7D7;width:730px;"></div>
				
				
			<?php
				}

				}

				?>
				
			
          </div>
          
        </div>
      </div>
      
      
    </div>
  </div>
  <!--Profile Right End-->
</div>

<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 


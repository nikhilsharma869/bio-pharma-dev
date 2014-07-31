<?php 

$current_page="Portfolio";
include "includes/header.php"; 
include("country.php");

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where username = '".$_GET[username]."'"));
$_GET[id]=$row_user[user_id];
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
          <div class="notification_link1" style="width: 739px;">
            <h1><?=$lang['PRTFLO']?></h1>
            <div class="overview_text">
				<?php
				$rr=mysql_query("select *  from " . $prev . "portfolio where user_id=" . $_GET['id'] . " order by id desc limit 20"); 
				$pro = mysql_num_rows($rr);
				if ($pro == ""){
					echo '<div style="width:736px;padding:5px;float:left;"  align="center">';
					echo $lang['PORTF_NOT_UPD'];
					echo '</div>';
				}
				else{
					$j=0;
					while($f=mysql_fetch_array($rr)){
						$j++;		
						$date_up=explode('-',$f[add_date]);		
						$date=$date_up[2].'-'.$date_up[1].'-'.$date_up[0];	
				?>				
				 <div class="profile_comment_middle">
				<div style="width:736px;padding:5px;float:left;">
					<div style="float:left;padding: 10px; font-size:12px;">
						<a href="<?=$vpath?>view-portfolio/<?php print $_GET['username'];?>/<?php print $f['id'];?>/">
							<img src='<?=$vpath?>viewimage.php?img=<?=$f[image];?>&width=150&height=100' style="border:1px solid #CCCCCC; padding:3px;">
						</a>
						<br><?=$lang['UPDATED_ON']?>  <?=$date;?>
					</div>
					<div style="padding:10px 0px;">
						<a style="color:#000000; text-decoration:none;" href="<?=$vpath?>view-portfolio/<?php print $_GET['username'];?>/<?php print $f['id'];?>/"><strong><?=$f[project_title];?></strong></a><br />
						<?=substr(nl2br($f[description]),0,400)." ....";?>
						
					</div>	
					
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
  </div>
  <!--Profile Right End-->
</div>

<div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 


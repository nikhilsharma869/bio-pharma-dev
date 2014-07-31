<? 
if($_GET[profileid]==''){
$_GET[profileid]=$_GET[id];
}
//echo $newTime = strtotime( '+365 days', 1411472449);
//echo date( 'Y-m-d', $newTime);

?>
<div class="profile_left">
    <div class="profile_main">
      <div class="profile_edit_box">
        <div class="profile_edit_img">
		<?php	if($row_user['logo']!=""){	?>
		 <img src="<?=$vpath;?>viewimage.php?img=<?php echo $row_user['logo'];?>&width=155&height=150" title=""  alt=""/>
  		<?php	}else{ ?>
			<img src="<?=$vpath;?>images/user_pic.jpg" />
		<?php } ?>	
		</div>
      </div>
    </div>
    <div class="profile_main">
      <div class="overview_box">
        <div class="overview_link" style="border-top:1px dashed #D7D7D7;">
           <p><a href="<?=$vpath;?>publicprofile/<?=$_GET[username]?>/"><?=$lang['PR_OVR']?></a></p>
			<p><a href="<?=$vpath;?>reviews/<?=$_GET[username]?>/"><?=$lang['REVIEW']?></a></p>
			<?php 
				if($row_user['user_type']!='E'){
			?>
			<p><a href="<?=$vpath;?>portfolio/<?=$_GET[username]?>/"><?=$lang['PRTFLO']?></a></p>
			<p><a href="<?=$vpath;?>invite-provider/<?=$_GET[username]?>/"><?=$lang['INVITE']?></a></p>
			<?php } ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
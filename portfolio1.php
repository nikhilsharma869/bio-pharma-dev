<?php 

$current_page="Portfolio";
include "includes/header.php"; 
include("country.php");


$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where username = '".$_GET[username]."'"));
?>
<!--
<script type="text/javascript" src="<?=$vpath?>js/jquery_tab.js" ></script>

	
	<script src="<?=$vpath?>js/jquery.min.js"></script>--><link rel="stylesheet" href="css/global.css">
	<script src="<?=$vpath?>js/jquery.easing.min.js"></script>
	<script src="<?=$vpath?>js/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: '<?=$vpath?>img/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true
			});
		});
	</script>

<!-----------Header End-----------------------------> 



<!-- content-->

<div class="browse_contract">
  <!--Profile Left Start-->
  <?php include 'includes/left_profile.php';?>
  <!--Profile Left End-->
  <!--Profile Right Start-->
  <div class="profile_right">
    <div class="create_profile">
      <p><a href="<?=$vpath?>publicprofile/<?=getusername($row_user["user_id"])?>"><?=ucwords($row_user['fname']).'&nbsp;'.ucwords($row_user['lname']);?></a></p>
      <br />
    </div>
    <div class="create_profile2">
      <div class="create_profile2_left">
        <div class="notification">
          <div class="notification_link1" style="width: 746px;">
            <h1><?=$lang['PRTFLO']?></h1>
            <div class="overview_text">
				<?php
	$r1=mysql_query("select * from " . $prev . "portfolio where user_id=" . $row_user['user_id'] . " and id=".$_GET['port_id']." order by add_date desc");
			while($d1=@mysql_fetch_array($r1))
			{
			?>		               
		 <div id="container">
			<div id="example">			
				<div id="slides">
					<div class="slides_container">
					<?php if($d1[image]!="")
					{
					?>
							<img src="<?=$vpath?>viewimage.php?img=<?php echo $d1[image];?>&size=600" title=""  alt=""  width=570 height=280 />
					<?php 
					}
					if($d1[image1]!="")
					{
					?>
							<img src="<?=$vpath?>viewimage.php?img=<?php echo $d1[image1];?>&size=600" title=""  alt=""  width=570 height=280 />
					<?php 
					}
					if($d1[image2]!="")
					{
					?>
							<img src="<?=$vpath?>viewimage.php?img=<?php echo $d1[image2];?>&size=600" title=""  alt=""  width=570 height=280 />
					<?php 
					}
					if($d1[image3]!="")
					{
					?>
							<img src="<?=$vpath?>viewimage.php?img=<?php echo $d1[image3];?>&size=600" title=""  alt=""  width=570 height=280 />
					<?php 
					}
					if($d1[image4]!="")
					{
					?>
							<img src="<?=$vpath?>viewimage.php?img=<?php echo $d1[image4];?>&size=600" title=""  alt=""  width=570 height=280 />
					<?php 
					}
					?>
		
					  </div>
					<a href="javascript:void(0);" class="prev"><img src="<?=$vpath?>images/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
					<a href="javascript:void(0);" class="next"><img src="<?=$vpath?>images/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
				</div>
				<img src="<?=$vpath?>images/example-frame.png" width="739" height="341" alt="Example Frame" id="frame">
			</div>		
			<br />
			<div style="color: #699400;font-size:18px;"><?=$d1[project_title]?></div><br />
		<?=$d1[description]?>
	
          </div>
      
	<?php } ?>	
				
			
          </div>
          
        </div>
       </div>
	
	 <div class="notification">
          <div class="notification_link1" style="width: 746px;">
		  <h1><?=$lang['OTHER_PORT']?></h1>
		  <div class="overview_text">
        <?php
	$r1=mysql_query("select * from " . $prev . "portfolio where user_id=" . $row_user['user_id'] . " order by add_date desc"); 
	while($d1=@mysql_fetch_array($r1))
	{
	?>
        <div class="portfolio_box_pic_box">
          <div class="portfolio_box_pic">
            <?php



	if($d1[image]!="")



	{



	?>
            <a href="<?=$vpath?>view-portfolio/<?php print $_GET['username'];?>/<?php print $d1['id'];?>/"><img src="<?=$vpath?>viewimage.php?img=<?php echo $d1[image];?>&amp;width=135&amp;height=90" title=""  alt=""></a>
            <?php



	}



	else



	{



	?> <a href="<?=$vpath?>view-portfolio/<?php print $_GET['username'];?>/<?php print $d1['id'];?>/">
            <img src="<?=$vpath?>images/word_doc.jpg" height="90" width="90" /></a>
            <?php



	}



	?>
          </div>
          <h3> <a href="<?=$vpath?>view-portfolio/<?php print $_GET['username'];?>/<?php print $d1['id'];?>/">
            <?=$d1[project_title]?></a>
          </h3>
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
  <!--Profile Right End-->
</div>

 <div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 
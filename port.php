<?php 

$current_page="<p>Portfolio</p>";
include "includes/header.php"; 
include("country.php");


$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".base64_decode($_GET[id])."'"));
?>

<script type="text/javascript" src="js/jquery_tab.js" ></script>
<link rel="stylesheet" href="css/global.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="http://gsgd.co.uk/sandbox/jquery/easing/jquery.easing.1.3.js"></script>
	<script src="js/slides.min.jquery.js"></script>
	<script>
		$(function(){
			$('#slides').slides({
				preload: true,
				preloadImage: 'img/loading.gif',
				play: 5000,
				pause: 2500,
				hoverPause: true
			});
		});
	</script>




<div class="browse_contract">
  <!--Profile Left Start-->
  
  <?php include 'includes/left_profile.php';?>
  
  
   <div class="profile_right">
    <div class="create_profile">
      <p><?=$row_user['fname'].'&nbsp;'.$row_user['lname'];?></p>
      <br />
    </div>
  
  
  
  <div class="portf_box">
      <div class="portfolio_box">
        <?php

	$r1=mysql_query("select * from " . $prev . "portfolio where user_id=" . $row_user['user_id'] . " and id=".$_GET['port_id']." order by add_date desc"); 

	while($d1=@mysql_fetch_array($r1))

	{

	?>
        <!-- <div class="portfolio_box_pic_box">-->
        <!--  <div class="portfolio_box_pic">-->
        <div id="container">
          <div id="example">
            <div id="slides">
              <div class="slides_container">
                <?php if($d1[image]!="")
				{
				?>
                <img src="viewimage.php?img=<?php echo $d1[image];?>&amp;width=600&amp;height=280" title=""  alt=""  width="600" height="280" />
                <?php 
				}
				if($d1[image1]!="")
				{
				?>
                <img src="viewimage.php?img=<?php echo $d1[image1];?>&amp;width=600&amp;height=280" title=""  alt=""  width="600" height="280" />
                <?php 
				}
				if($d1[image2]!="")
				{
				?>
                <img src="viewimage.php?img=<?php echo $d1[image2];?>&amp;width=600&amp;height=280" title=""  alt=""  width="600" height="280" />
                <?php 
				}
				if($d1[image3]!="")
				{
				?>
                <img src="viewimage.php?img=<?php echo $d1[image3];?>&amp;width=600&amp;height=280" title=""  alt=""  width="600" height="280" />
                <?php 
				}
				if($d1[image4]!="")
				{
				?>
                <img src="viewimage.php?img=<?php echo $d1[image4];?>&amp;&amp;width=600&amp;height=280" title=""  alt=""  width="600" height="280" />
                <?php 
				}
				?>
              </div>
              <a href="#" class="prev"><img src="images/arrow-prev.png" width="24" height="43" alt="Arrow Prev" /></a> <a href="#" class="next"><img src="images/arrow-next.png" width="24" height="43" alt="Arrow Next" /></a> </div>
            <img src="images/example-frame.png" width="739" height="341" alt="Example Frame" id="frame" /> </div>
          <table width="100%">
            <tr>
              <td width="100%"><h1 style="font-family:Arial, Helvetica, sans-serif; font-size:14px;">
                <?=$d1[project_title]?>
              </h1></td>
            </tr>
            <tr>
              <td width="100%" style="font-family:Arial, Helvetica, sans-serif; font-size:14px;"><h1>
                <?=$d1[description]?>
              </h1></td>
            </tr>
          </table>
        </div>
        <?php

	}

	?>
      </div>
    </div>
	
	
	
	  </div>
  <!--Profile Right End-->
</div>


<?php include 'includes/footer.php';?> 

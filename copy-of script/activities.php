<?php 

include "includes/header.php"; 

CheckLogin();

	CheckLogin();

	include "country.php";

?>

<?php

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".base64_decode($_GET[id])."'"));



?>



<script type="text/javascript" src="js/jquery_tab.js" ></script>



<style type="text/css">

.bx_top {

    background: url("images/bx-top.jpg") no-repeat scroll left top transparent;

    height: 34px;

    width: 262px;

}

.bx_repeat {

    background-color: #E5F4F5;

    border-left: 1px solid #7AC9CC;

    border-right: 1px solid #7AC9CC;

}

.myaccviewprofile {

    background-color: #3B5998;

    border: 1px solid #CCCCCC;

    color: #FFFFFF;

    cursor: pointer;

	font-size:14px;

    font-weight: bold;

    padding: 4px 20px;

    text-shadow: 1px 1px 1px #CCCCCC;

}

.nav_profile{width:482px; height:29px; border-bottom:1px solid #235098;}

.nav_profile ul{margin:0px 0px 0px 10px;}

.nav_profile li{float:left; margin:0px 2px 0px 0px;}

.nav_profile li a{display:block; height:28px; border-left:1px solid #003399; border-right:1px solid #003399; border-top:1px solid #003399; text-decoration:none; padding:0px 10px 0px 10px; line-height:28px; font-size:14px; font-weight:bold; background:url(images/p_navbg.gif) repeat-x; color:#235098;}

.nav_profile li a:hover{background:url(images/p_navhover.gif) repeat-x;}







.rightside_box {

    background: url("images/bg_rigthboxhead.gif") repeat-x scroll center top #ECF3F8;

    border: 1px solid #CED5E5;

    border-radius: 5px 5px 5px 5px;

    margin: 20px 0 0 20px;

    padding: 0 0 15px;

    width: 260px;

}

.rightside_box ul {

    float: left;

	padding:0 0 0 5px;

}

style2.css (line 64)

.leftul {

    margin: 10px 0 10px 10px;

    width: 150px;

}

.leftul li {

    background: url("images/bullet3.png") no-repeat scroll 0 35% transparent;

    border-bottom: 1px dotted #0033FF;

    color: #1E5A6B;

    font-size: 13px;

    font-weight: bold;

    height: 30px;

    padding-top: 5px;

}

.leftul li span {

    line-height: 0;

    padding: 0 0 0 10px;

}

.rightside_box ul {

    float: left;

}

.rightul {

    margin: 10px 10px 0 0;

    width: 90px;

}

.leftul li span {

    line-height: 0;

    padding: 0 0 0 10px;

}

.leftul li span a {

    color: #1E5A6B;

    text-decoration: none;

}

.rightul li {

    border-bottom: 1px dotted #0033FF;

    color: #1E5A6B;

    font-size: 13px;

    height: 30px;

    line-height: 16px;

    padding-top: 5px;

    text-align: right;

}

.rightside_box ul {

    float: left;

}

.leftul {

    margin: 10px 0 10px 10px;

    width: 140px;

}

.singuptest {

    color: #3B5998;

    font-family: Arial,Verdana,Sans-serif;

    font-size: 26px;

    font-weight: normal;

    letter-spacing: -1px;

    margin-bottom: 20px;

    padding-bottom: 5px;

    width: 100%;

}

.link {

    color: #2F5B67;

    font-family: Arial,Helvetica,sans-serif;

    font-size: 12px;

    font-style: normal;

    font-weight: normal;

    text-decoration: none;

}

.red{

	font-family:Arial, Helvetica, sans-serif;

	font-size:12px;

	font-weight:normal;

	color:red;

	font-style:normal;



	text-decoration:none;

}

.button-small {

	color:#2f5b67;

    background-color: #E8F0F7 !important;

    border-color: #BFD7F5 #7FAEEA #7FAEEA #BFD7F5 !important;

    border-style: solid !important;

    border-width: 1px !important;

    font-size: 10px !important;

    padding: 1px 3px !important;

    text-decoration: none;

    white-space: nowrap !important;

}



.starsSmall{background:transparent url("images/group_icons.gif") no-repeat scroll -553px 0;vertical-align:top;display:inline-block;margin:.25em 5px 2px 0;width:50px;height:10px;}

.starsSmall.rating0{background-position:-553px 0;}

.starsSmall.rating1{background-position:-553px -70px;}

.starsSmall.rating2{background-position:-553px -140px;}

.starsSmall.rating3{background-position:-553px -210px;}

.starsSmall.rating4{background-position:-553px -280px;}

.starsSmall.rating5{background-position:-553px -350px;}

.starsMedium{background:transparent url("images/group_icons.gif") no-repeat scroll -433px 0;vertical-align:top;display:inline-block;margin:4px 5px 2px 0;width:70px;height:15px;}

.starsMedium.rating0{background-position:-433px 0;}

.starsMedium.rating1{background-position:-433px -70px;}

.starsMedium.rating2{background-position:-433px -140px;}

.starsMedium.rating3{background-position:-433px -210px;}

.starsMedium.rating4{background-position:-433px -280px;}

.starsMedium.rating5{background-position:-433px -350px;}

.starsLarge{background:transparent url("images/group_icons.gif") no-repeat scroll -280px 0;vertical-align:top;display:inline-block;margin:0 5px 2px 0;width:102px;height:20px;}

.starsLarge.rating0{background-position:-280px 0;}

.starsLarge.rating1{background-position:-280px -70px;}

.starsLarge.rating2{background-position:-280px -140px;}

.starsLarge.rating3{background-position:-280px -210px;}

.starsLarge.rating4{background-position:-280px -280px;}

.starsLarge.rating5{background-position:-280px -350px;}

</style>

<!-----------Header End-----------------------------> 



<!-- content-->

<div class="freelancer">





<!--Profile-->

<div class="profile_left">

<div class="profile_left_img_box">

 <div class="profile_left_img"> <?php

	if($row_user['logo']!="")

	{

	?>

	<img src="image.php?img=<?php echo $row_user['logo'];?>&x=190&y=265" height="150" width="149" />

	<?php

	}

	else

	{

	?>

	 <img src="images/face_icon.gif" height="150" width="149" />

	<?php

	}

	?>

	</div>

 

  <div class="hire_me_img"><a href="invite_provider.php?id=<?php print $_GET[id];?>"><img src="images/hire_me!.png" /></a></div>

 <div class="rate_hire_left"><h2> <?=$lang['RATE']?><strong>$ <?php echo $row_user['rate'];?> USD</strong><?=$lang['HOUR']?></h2></div>

 



 <div class="invite_bott"><a href="invite_provider.php?id=<?php print $_GET[id];?>"><img src="images/invite-to-bid_bott.png" /></a></div>

 

 </div>

 </div>

    <!-- left side-->

    <!--middle -->

	

    

    <!--end middle--> 

    <!-- rightside-->

<div class="profile_right">

   <div class="edit_profile">

     <div style="padding-left:5px;"><h3><?=$lang['PROFL']?>  <font color="#ff8000"><?=$row_user['fname'].'&nbsp;'.$row_user['lname'];?></font></h3></div>

     

     

    <div class="edit_profile_text_box"><h4><strong><?=$lang['USER_NAM']?>:</strong> <?=$row_user['username'] ;?></h4>

    </div>

    <div class="edit_profile_text_box"><h4><strong><?=$lang['LOCATION']?>:</strong> <?php print $country_array[$row_user[country]];?></h4>

    </div><br />



    <div class="edit_profile_text_box"><h4><?=$lang['HI']?><br />

	<?=$lang['FRLNCR_DET']?></h4>

    </div>

    

    

   </div>

   

   <div  class="overview">

                                                  

              <ul class="tabs">

                <li><a href="publicprofile.php?id=<?php print $_GET[id];?>"  rel="tabs1"><?=$lang['PROFL']?></a></li>

                <li><a  href="portfolio.php?id=<?php print $_GET[id];?>" rel="tabs2"><?=$lang['PRTFLO']?></a></li>

                <li><a class="selected" href="activities.php?id=<?php print $_GET[id];?>" rel="tabs3"><?=$lang['ACTIVITIES']?></a></li>

                <li><a  href="reviews.php?id=<?php print $_GET[id];?>" rel="tabs4"><?=$lang['REVIEWS']?></a></li>

                <li><a  href="invite_provider.php?id=<?php print $_GET[id];?>" rel="tabs5"><?=$lang['INVITE']?>&nbsp;<?=$row_user['fname'];?></a></li>

              </ul>

			  <div class="tab-content" id="tabs3"> 

              <div class="overview_text">

					

						<table cellpadding="0" cellspacing="0" border="0" style="" width="100%">

						<tr><td style="height:15px;"></td></tr>

						<tr>

							<td>

							<!--------------------------------------------------->

							<table width="98%">

							<tr>

							<td width="18%"><strong><?=$lang['USER_NAM']?> :</strong></td>

							<td><?php print $row_user[username];?></td>

							</tr>

							<tr>

							<td style="padding-left:5px;"><?=$lang['LST_LGGD']?>  : </td>

							<td> <strong><?php print date('F d, Y h:i:s a', strtotime($row_user[ldate]));?></strong></td>

							</tr>

							</table>

							<!--------------------------------------------------->

							</td>

						</tr>

						<tr><td style="height:20px;"></td></tr>

						</table>

				

			<!------------------------------------------Middle Div Body--------------------------------------------------------->

						<table border="0" cellspacing="1" align=center cellpadding="4" width="98%" >

						<tr>

							<td style="height:4px;" colspan=2></td>

						</tr>

						<tr style="background-color:#f6f6f6; ">

							<td colspan=2 ><b><?=$lang['EMP_ACT']?> </b></td>

						</tr>

						

						<?

						$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . base64_decode($_GET[id]) . "' ORDER BY id DESC");

						$tinyrows = @mysql_num_rows($tinyres);

						if($tinyrows==0):

						?>

							<tr class=red bgcolor=white><td colspan=2><br>(<?=$lang['NO_JOBS_DISPLAY']?>)</td></tr>

						<?php

						else:

							$i=0;

							

							while($kikrow=mysql_fetch_array($tinyres)):

						?>

									<tr class=link bgcolor=white>

										<td width=10><?php print ($i+1);?> </td>

										<td style='padding-left:10px'>

											<a class=link href="<?php print $vpath.'project-dtl.php?id=' . $kikrow[id] ;?> "><b><u><?php print $kikrow[project];?></u></b></a>

											<?php

											if($kikrow[special] == "featured"):

												//echo' <img src="images/featured.gif" alt="Featured Project!" border=0>';

											endif;

											?>

											&nbsp;&nbsp;<?php print Ucwords($kikrow[status]);?>

										</td>

									</tr>

						<?php

								$i++;	

							 endwhile;

						endif;

						?>

							<tr>

								<td colspan=2 style="height:4px;">&nbsp;</td>

							</tr>

							<tr style="background-color:#f6f6f6; ">

								<td colspan=2 ><b><?=$lang['WON_JOB']?> </b></td>

							</tr>

						<?php

						

						$r=mysql_query("SELECT * from " . $prev . "buyer_bids where bidder_id = '". base64_decode($_GET[id]) ."' and chose = 'Y'");
						

						if(!@mysql_num_rows($r)):

						?>

						

							<tr class=red bgcolor=white>

								<td>&nbsp;</td>

								<td style='padding-left:10px'><?=$lang['NO_JB_FND']?>.</td>

							</tr>

						<?php

						else:

							$i=1;

							while($d=mysql_fetch_array($r)):
							$rr=mysql_query("SELECT * from " .$prev ."projects where id='".$d[project_id]."'");
							$dd=mysql_fetch_array($rr);

						?>

								<tr class=link bgcolor=white>

									<td width=10><?php print ($i++); ?></td>

									<td>

										<a href="<?php print $vpath.'project-dtl.php?id=' . $d[project_id];?>" class=link><u><?php echo $dd[project]; ?></u></a>

									</td>

								</tr>

						<?php

							endwhile;	

						endif; 

						?>

							<tr>

								<td colspan=2 style="height:4px;">&nbsp;</td>

							</tr>

							<tr style="background-color:#f6f6f6; ">

								<td colspan=2 style=''><strong><?=$lang['CURR_BIDS']?></strong></td>

							</tr>

						<?

						$r=mysql_query("SELECT " . $prev . "buyer_bids.*," . $prev . "projects.* FROM " . $prev . "buyer_bids," . $prev . "projects WHERE " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $prev . "projects.user_id=" . base64_decode($_GET[id]) . " and  " . $prev . "projects.status='open'");

						if(!@mysql_num_rows($r)):

						?>

							<tr class=red bgcolor=white>

								<td ><br></td>

								<td style='padding-left:10px'><?=$lang['NO_JB_FND']?>.</td>

							</tr>

						<?php

						else:

						/*   $total=@mysql_num_rows($n);

						   if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}*/

						   $i=0;

						   while($d=mysql_fetch_array($r)):

							   

						?>

							   <tr class=link bgcolor=white>

									<td width=10><?php print ($i+1); ?></td>

									<td style='padding-left:10px'>

										<a href="<?php print $vpath.'project-dtl.php?id=' . $d[id];?>" class=link><u><b><?php print $d[project] ?></b></u></a>

									</td>

							   </tr>

						<?php $i++;

						  endwhile;

						endif;

						?>

							<tr>

								<td colspan=2 style="height:4px;">&nbsp;</td>

							</tr>

								<tr style="background-color:#f6f6f6; ">

									<td colspan=2 style=''><strong><?=$lang['JBS_LST']?></strong></td>

								</tr>

						<?

						$r=mysql_query("SELECT " . $prev . "buyer_bids.*," . $prev . "projects.* FROM " . $prev . "buyer_bids," . $prev . "projects WHERE " . $prev . "buyer_bids.project_id=" . $prev . "projects.id and " . $prev . "projects.user_id=" . base64_decode($_GET[id]) . " and  " . $prev . "projects.status='frozen' and " . $prev . "projects.chosen_id!=" . base64_decode($_GET[id]));

						if(!@mysql_num_rows($r)):

						?>

							<tr class=red bgcolor=white>

								<td></td>

								<td style='padding-left:10px'><?=$lang['NO_JB_FND']?>.</td>

							</tr>

						<?php

						else:

						/*   $total=@mysql_num_rows($n);

						   if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}*/

						   $i=0;

						   while($d=mysql_fetch_array($r)):

							   

							   if(!($j%2)){$bg="bgcolor=whitesmoke";}else{$bg="bgcolor=#ffffff";}

						?>

							   <tr class=link bgcolor=white>

									<td width=10><?php print ($i+1); ?></td>

									<td style='padding-left:10px'>

										<a href="project-dtl.php?id=<?php print $d[id];?>" class=link><u><?php $d[project] ;?></u></a>

									</td>

							   </tr>

						   

						<?php $i++;

						   endwhile;

						endif;

						?>

						</table>                

			<!------------------------------------------Middle Div Body End----------------------------------------------------->                

	   

   </div>

               

			  

    </div>

	   

  	</div>

   			<div class="portf_box">

			<div class="portfolio_box">

	<?php

	$r1=mysql_query("select * from " . $prev . "portfolio where user_id=" . $row_user['user_id'] . " order by add_date desc"); 

	while($d1=@mysql_fetch_array($r1))

	{

	?>		               

            <div class="portfolio_box_pic_box">

            <div class="portfolio_box_pic"><img src='image.php?img=<?=$d1[image]?>&x=134&y=113' border=0 /></div>

            <h3><?=$d1[project_title]?></h3>

            </div>

	<?php

	}

	?>            

            <!--<div class="portfolio_box_pic_box">

            <div class="portfolio_box_pic"><img src="images/profile_img1.jpg" /></div>

            <h3>Lorem ipsum</h3>

            </div>

            

            <div class="portfolio_box_pic_box">

            <div class="portfolio_box_pic"><img src="images/profile_img1.jpg" /></div>

            <h3>Lorem ipsum</h3>

            </div>

            

            <div class="portfolio_box_pic_box">

            <div class="portfolio_box_pic"><img src="images/profile_img1.jpg" /></div>

            <h3>Lorem ipsum</h3>

            </div>-->

            

            </div>

   </div>

</div> 

    <!-- end rightside-->



</div>

</div>

</div>

</div>

</div>

<?php include 'includes/footer.php';?> 

</body>

</html>
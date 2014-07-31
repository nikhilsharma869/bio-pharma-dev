<?php 
$current_page = "<p>Closed Jobs</p>";


include "includes/header.php";



CheckLogin();

?>

<?php

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_SESSION['user_id']."'"));

$type=$row_user['user_type'];
?>

<link rel="stylesheet" type="text/css" href="<?=$vpath?>highslide/highslide.css" />

<script type="text/javascript" src="<?=$vpath?>highslide/highslide-with-html.js"></script>

<script type="text/javascript">

hs.graphicsDir = '<?=$vpath?>highslide/graphics/';

hs.outlineType = 'rounded-white';

hs.wrapperClassName = 'draggable-header';

hs.minHeight =300 ;

hs.minWidth =450 ;

hs.creditsText = '<i>Feedback Rating</i>';

</script>


<div class="inner-middle"> 
<div class="dash_headding">
<p><a href="<?=$vpath?>"><?=$lang['HOME_LINK']?></a> | <a href="javascript:void(0);" class="selected"><?=$lang['COMPLETE_PROJECTS']?> </a></p></div>
<div class="clear"></div>

<?php include 'includes/leftpanel1.php';?> 
<div class="profile_right">
   <div id="wrapper_3">
              <? echo getprojecttab(5);?>
              <div class="browse_tab-content"> 
            	<div class="browse_job_middle">
				
			
        
          <table width="100%" cellpadding="8" cellspacing="0" border="0" align="left">
            <tbody>
              <tr class="tbl_bg_4">
                        <td width="290" align="left" class="space"><?=$lang['PROJECT_NAMEE']?></td>
                        <td width="54" align="center"><?=$lang['BIDS']?></td>
						
                      
                        <td width="170" align="center"><?=$lang['ACTION']?></td>
						<td width="185" align="center"><?=$lang['POST_DATE']?></td>
                      </tr>
              <?php

$no_of_records=10;

$all_row = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='complete' ORDER BY id DESC");

$total = mysql_num_rows($all_row);
if($_GET['page'])
{
	$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='complete' ORDER BY id DESC ");
}
else
{
	$tinyres = mysql_query("SELECT * FROM " . $prev . "projects WHERE user_id='" . $_SESSION[user_id] . "' and status='complete' ORDER BY id DESC" );
}

$i=0;



while($kikrow=mysql_fetch_array($tinyres))



{



?>
              <?php 

	if(!($i%2)){$bg="#ffffff";}else{$bg="whitesmoke";}

	?>
              <tr class="tbl_bg2" >
                <td align="left" class="space" style="border-right:none;"><?php



	echo '<a class=font_bold2 href="'.$vpath.'project/' . $kikrow[id] . '"><u>' . ucwords($kikrow[project]) . '</u></a>';



	if($kikrow[special] == "featured"):



	//echo' <img src="images/featured.png" alt="Featured Project!" border=0>';



	endif;



	?>
                </td>
                <td align="center" style="border-right:#e9e9e9 0px dotted; "><?php echo totalbid($kikrow[id]);?></td>
               <?php 


	echo ' <td align="center">You picked <a href="'.$vpath.'publicprofile/' .getusername( $kikrow[chosen_id] ). '/">' . getusername($kikrow[chosen_id]) . '</a> <br>';
	?>
                    <?php

         $rw6 = mysql_query("select * from ".$prev."feedback where project_id = '".$kikrow[id]."' and feedback_from = '".$_SESSION['user_id']."' and feedback_to = '".$kikrow['chosen_id']."'");
		
		
		 if(mysql_num_rows($rw6)>0)

		 {

			 $rw7 = mysql_fetch_array($rw6);

	   ?>
                    <span class="feedbackRating starsMedium rating<?php print $rw7['avg_rate'];?> __ppDone" title="" > </span>&nbsp;&nbsp;&nbsp; <a href="<?=$vpath?>employer_rating_view.php?rid=<?php print $rw7['id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" style="color:#0066FF"><?=$lang['View']?></a>
                    <?php

		 }

		 else

		 {

	   ?>
                    <a href="<?=$vpath?>employer_rating.php?pid=<?php print $kikrow[id];?>&amp;bid=<?php print $rw3['id'];?>&amp;cid=<?php print $kikrow['chosen_id'];?>&amp;eid=<?php print $_SESSION['user_id'];?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )" style="color:#0066FF"><?=$lang['GIVE_FEEDBACK']?></a>
                    <?php

		 }

		 ?>
                </td>
				<td align="center"><?php echo date("M d, Y",$kikrow[date2]); ?></td>
              </tr>
          
           
            <?php $i++;} ?>
<?php			
if($i==0)
{
?>
<tr class="tbl_bg2" >
			
              <td height="10px;" align="center" colspan="6"><strong><?=$lang['NO_COMP']?></strong></td>
            </tr>
			
<?php
}
?>
			
            
          </table>
         
	 
	
    </div>
	</div>
	</div>
   
  </div>


</div>		  

<div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?>
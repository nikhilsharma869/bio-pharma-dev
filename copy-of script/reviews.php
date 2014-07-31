<?php 
$current_page="Reviews";
include "includes/header.php"; 
include "country.php";

$row_user = mysql_fetch_array(mysql_query("select * from ".$prev."user where username = '".$_REQUEST[username]."'"));

$_GET[id]=$row_user[user_id];

?>
<?php /*?><link rel="stylesheet" href="<?=$vpath?>css/global.css">
<script type="text/javascript" src="<?=$vpath?>js/jquery_tab.js" ></script><?php */?>

<script type="text/javascript" src="<?=$vpath?>highslide/highslide-with-html.js"></script>

<script type="text/javascript">

hs.graphicsDir = 'highslide/graphics/';

hs.outlineType = 'rounded-white';

hs.wrapperClassName = 'draggable-header';

hs.minHeight =300 ;

hs.minWidth =450 ;

hs.creditsText = '<i>Feedback Rating</i>';

</script>

<script type="text/javascript">
/*
$(document).ready(function(){
$("#more").click(function(){
var currentId = $(this).attr('id');
$("#spichmore"+currentId).toggle();
});
});*/
function showhide(id)
{
	//alert(id);
	
		document.getElementById("spich"+id).style.display = 'none';
		document.getElementById("spichmore"+id).style.display = 'block';
		document.getElementById(id).style.display = 'none';
		
	
}

</script>



<!-----------Header End-----------------------------> 


<div class="browse_contract">
  <!--Profile Left Start-->
  <?php include 'includes/left_profile.php';?>
  
  
<div class="profile_right">

    <div class="create_profile">
      <p><a href="<?=$vpath?>publicprofile/<?=$row_user["username"]?>/"><?=ucwords($row_user['fname']).'&nbsp;'.ucwords($row_user['lname']);?></a></p>
      <br />
    </div>
	
	<div class="create_profile2">
      <div class="create_profile2_left">
	  <div class="notification">
          <div class="notification_link1" style="width: 739px;">
            <h1><?=$lang['REVIEWS']?></h1>
			
        <div class="overview_text">
          <?php
			$no_of_records=10;

			 $all = mysql_query("select * from ".$prev."feedback where feedback_to = '".$_GET[id]."'");
			$total = mysql_num_rows($all);
			 if($_GET['page'])

				{
			
					$sql="select * from ".$prev."feedback where feedback_to = '".$_GET[id]."' limit " . ($_REQUEST['page']-1)* $no_of_records. ",".$no_of_records;
			
				}
			
				else
			
				{	
			
				$sql="select * from ".$prev."feedback where feedback_to = '".$_GET[id]."' limit 0,".$no_of_records;
			
				}

			 $rw4 = mysql_query($sql);
			 $rw5 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$_GET[id]."'"));

			 

			?>
          <!------------------------------------------Middle Div Body--------------------------------------------------------->
          <?php

if($total>0)

{
	$cnt = 1;
	while($rw6 = mysql_fetch_array($rw4))

	{

		$rs1 = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = '".$rw6['feedback_from']."'"));

		

		$rs3 = mysql_fetch_array(mysql_query("select * from ".$prev."projects where id = '".$rw6['project_id']."'"));

		$rs4 = mysql_fetch_array(mysql_query("select * from ".$prev."buyer_bids where id = '".$rw6['bidid']."'"));

		$rs5 = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where project_id = '".$rw6['project_id']."' and bidid = '".$rw6['bidid']."' and feedback_from = '".$rw6['feedback_to']."'"));

	?>
          <div class="profile_right1">
            <!------start_feedback---->
            <div class="profile_comment_middle">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="389"><h2><?php print ucwords($rs3['project']);?></h2></td>
                  <td width="127"><span><?=$curn?> <?php print number_format($rs4['bid_amount'],2);?></span></td>
                  <td width="100"><div class="rating">
                    <?php
		$rw = mysql_fetch_array(mysql_query("select * from ".$prev."feedback where id = '".$rw6['id']."'"));
		$avg_rate=$rw['avg_rate'];
		
			for($i=0;$i<$avg_rate;$i++)
			{
			?>
                    <img src="<?=$vpath?>images/star_1.png"/>
                    <?php
			}
			for($j=5;$j>$avg_rate;$j--)
			{
			?>
                    <img src="<?=$vpath?>images/star_3.png"/>
                    <?php
			}
			?>
                  </div></td>
                  <td width="59"><span>
                    <?=$avg_rate?>
                  </span></td>
                </tr>
                <tr>
                  <td colspan="4"><div class="spich_box">
                    <div class="spich_person"> <img src="<?=$vpath?>viewimage.php?img=<?php echo $rs1['logo'];?>&amp;width=100&amp;height=100"> <br />
                          <p><a href="<?=$vpath?>publicprofile/<?=base64_encode($rs1["user_id"])?>"><?php print ucwords($rs1['fname']).' '.ucwords($rs1['lname']);?></a></p>
                    </div>
                    <div class="spich" id="spich<?=$cnt?>">
                      <div class="spich_icon"></div>
                      <p><font style="color:#CCCCCC;"><?php print date('d-M-Y',strtotime($rw6['add_date']));?></font><br />
                            <?php print substr($rw['comments'],0,50);?></p>
                    </div>
                    <div class="spich1" id="spichmore<?=$cnt?>" style="display:none">
                      <div class="spich_icon"></div>
                      <p><font style="color:#CCCCCC;"><?php print date('d-M-Y',strtotime($rw6['add_date']));?></font><br />
                            <?php print $rw['comments'];?></p>
                    </div>
                    <div class="more" id="<?=$cnt?>" onclick="showhide(this.id,'m')">More..</div>
                  </div></td>
                </tr>
              </table>
              <div class="clear"></div>
              <div class="clear"></div>
              <div class="clear"></div>
            </div>
            <!------end_feedback---->
          </div>
          <?php
$cnt++;
}

}
else
{
	echo "<div height='100px' align='middle'>No Record exist</div>";
}


if($total>$no_of_records)
{
   //echo"<div align=right>" .new_paging(0,'reviews.php','&id='.$_GET['id'],$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
   
    echo"<div align=right>" .new_pagingnew(0,'review/',$_GET['id']."/",$no_of_records,$_REQUEST['page'],$total,$table_id='',$tbl_name='') . "</div>";
}
?>
          <!------------------------------------------Middle Div Body End----------------------------------------------------->
        </div>
		
		</div>
		</div>

	</div>
	</div>
    
  </div>
  <!-- end rightside-->
</div>

 <div style="clear:both; height:10px;"></div>
<?php include 'includes/footer.php';?> 
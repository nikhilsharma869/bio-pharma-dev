   <?php

   $select_images="select * from ".$prev."user where user_id='".$_SESSION['user_id']."'";

   $rec_images=mysql_query($select_images);

   $row_images=mysql_fetch_array($rec_images);  

   

  

   

   /////////////////////////////////////////  current file name  ///////////////////////////////

$currentFile = $_SERVER["SCRIPT_NAME"];

$parts = Explode('/', $currentFile);

$currentFile = $parts[count($parts) - 1];

////////////////////////////////////////  end current file name  ///////////////////////////////

   
$res=mysql_query("select * from ".$prev."user where user_id='".$_SESSION['user_id']."'");

$cn=array('user_id','email','username','user_type','password','fname','lname','status','country','logo','profile','company','slogan','account_type');


$row=mysql_fetch_array($res);



			if($row['gold_member']=='Y')

			{

				$mem=mysql_query("select * from ".$prev."membership where id=2");

				$rowmem=mysql_fetch_array($mem);

			}

			else

			{

				$mem=mysql_query("select * from ".$prev."membership where id=1");

				$rowmem=mysql_fetch_array($mem);		

			}

			$contnu=0;

			for($cn1=0;$cn1<=50;$cn1++)

			{
 
				if($row[$cn[$cn1]]!='')

				{

					$contnu++;	

				}

			}
	
$prfcomplt = ($contnu*80)/count($cn);

$skillexp=@mysql_num_rows(mysql_query("select count(*) from ".$prev."user_cats where user_id='".$_SESSION['user_id']."'"));

if($skillexp>0){
$prfcomplt =$prfcomplt+10;
}
if($row[rate]>0){
$prfcomplt =$prfcomplt+10;
}
			//$prfcomplt = ($contnu*80)/count($cn);
			
   ?>

  <script>
  function showhideprt(){
  $('#prt').toggle();
  
  }
  </script> 

<div class="profile_left">

	<div class="user_box">
<div class="user_text"><h1><?=$lang['PROFILE_COMPLETE']?></h1></div>
<!--Improve-->
<div class="improve_icon"><div class="improvebox"><div class="imprbox" style="width: <?=$prfcomplt;?>%"></div></div> <p> <?=round($prfcomplt);?>%</p></div>
<!--Improve End-->
<div class="improve_bnt"><a href="<?=$vpath?>profile.html"> <?=$lang['EDIT_PROFILE']?></a></div>
</div><br />
	
	
	
    <div class="dashboard">

      <div class="overview_box">

       

        <div class="overview_link">

		 

          <ul>

        

	  		 <li><a   href="javascript:void(0);" ><?=$lang['MY_PROFILE']?></a> </li>
			 <ul id="prt" >
			  <li style="background:none;"> <a <?php if($currentFile=='profile.php' || $currentFile=='myprofile.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>myprofile.html"><?=$lang['PROFESSIONAL']?></a></li>
			   <li style="background:none;"> <a <?php if($currentFile=='client.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>client.html"><?=$lang['CLIENT']?></a></li>
			 
			 </ul>
			 
			

	 
<?php
$unreadmsg = mysql_fetch_array(mysql_query("SELECT count(mid) as unread from ".$prev."pmb where readyet=0 and private_id='$_SESSION[user_id]' order by mid DESC"));
?>
      		<li><a <?php if($currentFile=='message.php' || $currentFile=='showmessage.php' || $currentFile=='sent_message.php' || $currentFile=='show_sent_message.php' || $currentFile=='compose_message.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>message.html"><?=$lang['INBOX']?> ( <?=$unreadmsg[unread]?> )</a></li>           
			<li><a <?php if($currentFile=='notification.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>notification.html"><?=$lang['NOTIFICATION']?></a></li>
      		<li><a <?php if($currentFile=='feedback.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>feedback.html"><?=$lang['FEEDBACK_PN']?></a></li>

	  <li><a <?php if($currentFile=='my-favourite.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?>  href="<?=$vpath?>my-favourite.html"><?=$lang['MY_FAVOURITE']?></a></li>

			<!--<li><a <?php if($currentFile=='mybids.php'){?>style="color:#0B7398; font-weight:bold;"<?php };?> href="<?=$vpath?>mybids.html"><?=$lang['MY_BIDS']?></a></span></li>-->
          

			<li><a  href="javascript:void(0);" ><?=$lang['MY_ASS_JOBS']?></a></li>
			
			
			 <ul id="prt" >
			  <li style="background:none;"> <a <?php if($currentFile=='mybids.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?>  href="<?=$vpath?>mybids.html"><?=$lang['PROFESSIONAL']?></a></li>
			 
			  
			   <li style="background:none;"> <a <?php if($currentFile=='active_jobs.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>active_jobs.html"><?=$lang['CLIENT']?></a></li>
			   
			
			 </ul>
			 

		

			<li><a <?php if($_GET['type']=='dsp'){?>style="color:#ff9f00; font-weight:bold;"<?php };?> href="<?=$vpath?>payment/dsp/" title="Deposit Funds"><?=$lang['My_finance']?></a></li>

           

		

			<li><a href="<?=$vpath?>active_dispute.html"><?=$lang['ACTIVE_DISPUTE']?></a></li>

  <?php  if($row_images['gold_member']=='N' && $row['account_type']=='C'){  ?>

      		<li><span><a href="<?=$vpath?>membership_plan.html" <?php if($currentFile=='membership_plan.php'){?>style="color:#ff9f00; font-weight:bold;"<?php };?>><?=$lang['MEMBERSHIP']?></a></span></li>

	  <?php   } ?>
	 
	<li><a href="<?=$vpath?>setting.html"><?=$lang['setting']?></a></li>

          </ul>

          

        </div>

        

      </div>

    </div>

  </div>


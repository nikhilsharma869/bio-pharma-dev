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
<?php include 'alert_changepass.php';?>
<div class="profile_left">

	<div class="user_box">
<div class="user_text"><h1><?=$lang['PROFILE_COMPLETE']?></h1></div>
<!--Improve-->
<div class="improve_icon">
	<div class="improvebox">
		<!-- <div class="imprbox" style="width: <?=$prfcomplt;?>%"></div> -->
		<div class="progress">
		  <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?=$prfcomplt;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$prfcomplt;?>%;">
		    <?=round($prfcomplt);?>%
		  </div>
		</div>
	</div> 
	<!-- <p> <?=round($prfcomplt);?>%</p> -->
</div>
<!--Improve End-->
<div class="improve_bnt"><a class="btn-custom-blue" href="<?=$vpath?>profile.html"> <?=$lang['EDIT_PROFILE']?></a></div>
</div><br />
	<div class="clear-fix"></div>
	
	<?php
	// var_dump($currentFile);
	
	switch ($currentFile) {
		case 'active_dispute.php':
			$current = 'dispute';
	        $current_sub = '';
			break;
		case 'setting.php':
			$current = 'change_password';
	        $current_sub = '';
			break;
		case 'feedback.php':
			$current = 'feedback';
	        $current_sub = '';
			break;			
		case 'transaction_history.php':
			$current = 'my_finance';
	        $current_sub = 'transaction_history';
			break;
		case 'payment.php':
			$current = 'my_finance';
	        $current_sub = 'add_fund';
	        break;
	    case 'gift.php':
			$current = 'my_finance';
	        $current_sub = 'gift';
	        break;
	    case 'withdrawfund.php':
	    case 'withdraw.php':
	    	$current = 'my_finance';
	        $current_sub = 'withdraw';
	    	break;
	    case 'milestone.php':
	    	$current = 'my_finance';
	        $current_sub = 'milestone';
	    	break;
	    case 'membership.php':
	    	$current = 'my_finance';
	        $current_sub = 'membership';
	        break;
	    case 'userSettings_ContactInfo.php':
	    	$current = 'contact_info_setting';
	        $current_sub = '';
	        break;
	    case 'userSettings_MySMEProfile.php':
	    	$current = 'sme_profile_setting';
	        $current_sub = '';
	    	break;
	   	case 'notification.php':
	   		$current = 'notification';
	        $current_sub = '';
	    	break;
	    case 'userSettings_CompanyInfo.php':
	    	$current = 'company_info_setting';
	    	$current_sub = '';
	    	break;
		default:
			$current = '';
	        $current_sub = '';
			break;
	}
	if(isset($_GET['type']) && $_GET['type']=='dsp') {
		$current = 'my_finance';
	    $current_sub = 'add_fund';
	}

		if(check_Login_Worker($_SESSION['user_id'], $_SESSION['user_type'])) {
	        $parent = 'dashboard_sme';	        
	        get_child_menu($parent, $current, $current_sub);
	    } else {
	    	$parent = 'dashboard_client';
	        get_child_menu($parent, $current, $current_sub);
	    }
    ?>

  </div>


<?php 

include "includes/header.php"; 

CheckLogin();

	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));

?>

<?php

//if(!$link){header("Location: ./index.php"); exit();}





//echo $user_id;





include("country.php");

$e=mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]); 

$data=@mysql_fetch_array($e);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="keywords" content="<?php print $row_settings[meta_keys];?>" />

<meta name="description" content="<?php print $row_settings[meta_desc];?>" /> 

<title><?php print $row_settings[site_title];?></title>

<link rel="stylesheet" href="css/style2.css"/>



<link rel="shortcut icon" href="images/favicon.ico">



<script>

function ValidateForm(form1) {

	



	if (form1.elements['rate'].value == '') {

		alert('Please enter your rate/hour.');

		form1.elements['rate'].focus();

		return false;

	}

	if (form1.elements['profile'].value == '') {

		alert('Please enter profile details.');

		form1.elements['profile'].focus();

		return false;

	}

	

	return true;

}

</script>	





<script type="text/javascript" src="domcollapse.js"></script>

<style type="text/css">

		@import "ottools.css";

		/* domCollapse styles */

		@import "domcollapse.css";

</style>

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

</style>

</head>



<body>

<div id="container">

<!-----------Header----------------------------->

	<?php include 'includes/header1.php';?> 

<!-----------Header End-----------------------------> 

<div class="clear"></div>

<!-- content-->

<div id="content">

	<div id="profile_content">

		<script type="text/javascript" src="domcollapse.js"></script>

<style type="text/css">

		@import "ottools.css";

		/* domCollapse styles */

		@import "domcollapse.css";

</style>

<style type="text/css">

.link_txt

{

color:#000000;

text-decoration:none;

}

</style>

<div style='padding-left:10px;padding-right:10px'>

<table width="100%" border="0" cellspacing="0" cellpadding="0" >

<tr><td valign=top class="bid_heading_txt"><?=$lang['TERMS_CONDITION']?></td></tr>

<tr><td  style="border-top:1px solid #87b0b1;" height=3>&nbsp;</td></tr></table>	

<table width="100%">

<tr><td class=link>

<?	

//getcontent_title('Terms of Service');

?>

<span class=h2><b><?=$dotcom?></b> <?=$lang['TERMS_SERVICE']?></h2>



<h3><?=$lang['ACCEPTANCE_AND_AGREEMENT']?></h3><p class=link>

				<?=$lang['CONTRACT_B2N']?><strong>Oneoutsource.com</strong><?=$lang['ITS_MANDATE']?>
                </p>

				<h3><?=$lang['AMENDMENT_AGREEMENT']?></h3>

				<p class=link>

				<strong>Oneoutsource.com</strong> <?=$lang['RESERVE_AGREEMENT']?>

				</p>

				<h3><?=$lang['N_1']?>&nbsp;&nbsp;<?=$lang['ELIGIBILITY']?></h3>

				<p class=link>

				<?=$lang['WE']?><strong><?=$lang['YOU_WILL_FIND']?>Oneoutsource.com</strong> <?=$lang['PROVIDE_SERVICE']?>
                </p>

				<h3><?=$lang['N_2']?>&nbsp;&nbsp;<?=$lang['USERS']?></h3><p class=link><br>

				<?=$lang['TERMS_LIKE']?>
				</p>

				<h3><?=$lang['N_3']?>&nbsp;&nbsp;<?=$lang['LEGAL_B2_N']?>Oneoutsource.com </h3>

				

				<h3><?=$lang['N_3_1']?>&nbsp;&nbsp;<?=$lang['TERMINATION']?></h3>

				<p class=link>

				<strong>Outsonesource.com</strong> <?=$lang['RESERVE_RIGHT']?>
                </p>

				<h3><?=$lang['N_3_2']?>&nbsp;&nbsp;<?=$lang['REL_B2N_USERSS']?></h3><p class=link> 

				

				<p class=link>

				<?=$lang['T_C_TO_OFFER_PROTECTION']?>
				<br>

				<?=$lang['MEMBER_CONTRACT']?>
                </p>

				<h3><?=$lang['N_3_3']?>&nbsp;&nbsp;<?=$lang['USERS_RESPONSIBILITY']?></h3>

				<p class=link><br>

				<?=$lang['THE_SET_RES']?>
				<br><br>

				<?=$lang['YOU_ALSO_TAKE_RES']?>
				<br><br>

				<?=$lang['YOU_ALSO_MAKE_RIGHT']?>
				</p>

				<h3><?=$lang['N_3_4']?>&nbsp;&nbsp;<?=$lang['NO_INSURANCE']?></h3>

				<p class=link><br>

				<strong>Oneoutsource.com</strong> <?=$lang['DOESNOT_PRO_INSURANCE']?>

				</p>

				<h3><?=$lang['N_3_5']?>&nbsp;&nbsp;<?=$lang['IND_CONTRACTOR']?></h3>

				<p class=link>

				<?=$lang['WE_TREAT']?>
				</p>

				<h3><?=$lang['N_3_6']?>&nbsp;&nbsp;<?=$lang['SERV_OFFER']?> Oneoutsource.com  </h3>

				<p class=link>

				<strong>Oneoutsource.com</strong> <?=$lang['OFFER_VARITY']?>

				<br><br>

				<?=$lang['FEEDBACK_QUESTION']?>
				</p>

				<h3><?=$lang['N_3_7']?>&nbsp;&nbsp;<?=$lang['TERMS_USE']?></h3>

				<p class=link><?=$lang['USER_EXP_TERMS']?>

				<strong>Oneoutsource.com</strong> <?=$lang['THIS_ONLINE_PLATFORM']?>
				<br><br>

				<?=$lang['CONTENT_PERTAINING_FINANCIAL']?>				
				
				<br><br>

				<?=$lang['THIS_DYNAMIC_WEB_SITE']?>
				<br><br>

				<?=$lang['WE_PROVIDE_UNMENTIONED']?>
				<br><br>

				<strong>Oneoutsource.com</strong> <?=$lang['IS_NOT_EQUIPED']?>

				</p>

				<h3><?=$lang['N_3_8']?>&nbsp;&nbsp;<?=$lang['ROMOTION']?></h3>

				<p class=link>

				<?=$lang['IN_ABSENCE']?>
				</p>

				<h3><?=$lang['N_3_9']?>&nbsp;&nbsp;<?=$lang['TRANSFER_B2N_SITES']?></h3>

				<p class=link>

				<?=$lang['AFTER_20_SEP']?>
				</p>

				<h3><?=$lang['N_4']?>&nbsp;&nbsp;<?=$lang['FEES']?></h3>

				<p class=link>

				<?=$lang['CHARGES_4_FEES']?>
				<br><br><?=$lang['CHARGES_4_FEES_1']?> oneoutsource.com

				<br><br><?=$lang['CHARGES_4_FEES_2']?>
				</p>

				<h3><?=$lang['N_5']?>&nbsp;&nbsp;<?=$lang['AFFILIATE_PROG']?></h3>

				

				<h3><?=$lang['N_5_1']?>&nbsp;&nbsp;<?=$lang['GENERAL']?></h3>

				<p class=link>

				<?=$lang['AFFILIATE_PROG_PROVIDER']?>

				</p>

				<h3><?=$lang['N_5_2']?>&nbsp;&nbsp;<?=$lang['REQ_REFF_USERS']?> </h3>

				<p class=link>

				<?=$lang['REF_AFFILIATE_1']?>

				</p>

				<h3><?=$lang['N_5_3']?>&nbsp;&nbsp;<?=$lang['BONUS_AMT']?></h3>

				<p class=link>

				<?=$lang['BONUS_AMT_1']?>
				</p>

				<h3><?=$lang['N_5_4']?>&nbsp;&nbsp;<?=$lang['PAYOUT_PERIOD']?></h3>

				<p class=link><?=$lang['USERS_ENABLED']?></p>

				<h3><?=$lang['N_5_5']?>&nbsp;&nbsp;<?=$lang['REQMENT']?></h3>

				<p class=link>

				<?=$lang['INORDER_2_AVL_BONUS']?>

				</p>

				<h3><?=$lang['N_5_6']?>&nbsp;&nbsp;<?=$lang['DISCOUNT_MODIFICATION']?></h3>

				<p class=link>

				<?=$lang['DISCOUNT_MODIFICATION_1']?>
				</p>

				<h3><?=$lang['N_5_7']?>&nbsp;&nbsp;<?=$lang['NON_COMPILANCE']?> </h3>

				<p class=link>

				

				<?=$lang['FALIURE_FULLFILLING']?>

                </p>

				<h3><?=$lang['N_6']?>&nbsp;&nbsp;<?=$lang['MILESTONE_PAYMENTTT']?></h3>

				<h3><?=$lang['N_6_1']?>&nbsp;&nbsp;<?=$lang['NOT_ESCW_SERV']?></h3>

				<p class=link>

				<strong>Oneoutsource.com</strong> <?=$lang['IS_NOT_OPERATING']?>

				<br><br><?=$lang['HOWEVER_EXP_PAYMENT']?>
				</p>

				<h3><?=$lang['N_6_2']?>&nbsp;&nbsp;<?=$lang['INCENTIVES_USERS']?> </h3>

				<p class=link>

				<?=$lang['TO_HANDLE_ODE']?>

				</p>

				<h3><?=$lang['N_7']?>&nbsp;&nbsp;<?=$lang['ACCOUNTS_H']?></h3>

				<h3><?=$lang['N_7_1']?>&nbsp;&nbsp;<?=$lang['OPENING_ACC']?> </h3>

				<p class=link><?=$lang['OPENING_ACC_1']?> <strong>Oneoutsource.com</strong><?=$lang['OPENING_ACC_2']?> 

				</p>

				<h3><?=$lang['N_7_2']?>&nbsp;&nbsp;<?=$lang['ACCOUNTS_H']?>  </h3>

				<p class=link>

				<?=$lang['YOU_NEED_2AGREE']?>
				<br><br><?=$lang['YOU_NEED_2AGREE_1']?>
				<br><br><?=$lang['YOU_NEED_2AGREE_2']?>
				<br><br><?=$lang['YOU_NEED_2AGREE_3']?>
				</p>

				<h3><?=$lang['N_7_3']?>&nbsp;&nbsp;<?=$lang['ACK']?> </h3>

				<p class=link>

				<?=$lang['ACK_1']?>

				</p>

				<h3><?=$lang['N_7_4']?>&nbsp;&nbsp;<?=$lang['ACK_2']?> </h3>

				<p class=link>

				<?=$lang['ACK_3']?>
				</p>

				<h3><?=$lang['N_7_5']?>&nbsp;&nbsp;<?=$lang['CHAR_BACKS']?>  </h3>

				<p class=link>

				<?=$lang['ACK_4']?>
				</p>

				<h3><?=$lang['N_7_6']?>&nbsp;&nbsp;<?=$lang['IN_SUFFI_FUND']?> </h3>

				<p class=link>

				<strong>Oneoutsource.com</strong><?=$lang['MAKE_USE_LEGAL']?> 

				</p>

				<h3><?=$lang['N_7_7']?>&nbsp;&nbsp;<?=$lang['TAXES']?> </h3>

				<p class=link>

				<?=$lang['ACK_5']?>
				</p>

				<h3><?=$lang['N_8']?>&nbsp;&nbsp;<?=$lang['AVOD_COMISSION']?></h3>

				

				<h3><?=$lang['N_8_1']?><?=$lang['N_8_1']?> </h3>

				<p class=link>

				<?=$lang['IN_ALL_CIRCUM']?>
				<br><br><?=$lang['IN_ALL_CIRCUM_1']?>']?>
				<?=$lang['IN_ALL_CIRCUM_2']?>
				</p>

				<h3><?=$lang['N_8_2']?>&nbsp;&nbsp;<?=$lang['EMAIL']?> </h3>

				<p class=link>

				<?=$lang['YOU_REQ_POST']?>
				</p>

				<h3><?=$lang['N_8_3']?></h3>

				<p class=link>

				<?=$lang['YOU_R_TO_MAKE_DIRECT']?>
                <h3><?=$lang['N_9']?>&nbsp;&nbsp;<?=$lang['USER_CONTENT']?></h3>

				 

				<h3><?=$lang['N_9_1']?>&nbsp;&nbsp;<?=$lang['CONTENT']?> </h3>

				<p class=link> 

				<?=$lang['CONTENT_1']?>
				</p>

				<ul class=link style='padding-left:20px'>

				<li><?=$lang['CONTENT_2']?></li>

				<li><?=$lang['CONTENT_3']?> </li>

				<li><?=$lang['CONTENT_4']?></li>

				</ul>

				

				<h3><?=$lang['N_9_2']?>&nbsp;&nbsp;<?=$lang['GNT_LICENCE']?>  </h3>

				<p class=link> 

				<?=$lang['GNT_LICENCE_1']?>

				</p>

				<h3><?=$lang['N_9_3']?> <?=$lang['FEEDBACK_REPU_REV']?> </h3>

				<p class=link> 

				<?=$lang['GNT_LICENCE_2']?>

				<br><br><?=$lang['TO_ENSURE_ACTIVITY']?>

				<br><strong>Oneoutsource.com</strong> <?=$lang['TO_ENSURE_ACTIVITY_1']?>

				</p>

				<h3><?=$lang['N_10']?>&nbsp;&nbsp;<?=$lang['USER_RESTRICTION']?> </h3>

			

			

				<h3><?=$lang['N_10_1']?>&nbsp;&nbsp;<?=$lang['ADVERTISING']?>  </h3>

				<p class=link> 

				<?=$lang['NO_PERMISSION']?>

				</p>

				<h3><?=$lang['N_10_2']?>&nbsp;&nbsp;<?=$lang['BDINGG']?></h3>

				<p class=link> 

				<?=$lang['SERV_PROVIDER_FULL_TIME']?>

				</p>

				<h3><?=$lang['N_10_3']?>&nbsp;&nbsp;<?=$lang['HIRE_SH']?>  </h3>

				<p class=link> 

				<?=$lang['HIRE_SH_1']?></p>

				<ul class=link style='padding-left:20px'>

				<li><?=$lang['HIRE_SH_2']?> </li>

				<li><?=$lang['HIRE_SH_3']?> </li>

				<li><?=$lang['HIRE_SH_4']?><strong>Oneoutsource.com</strong>. </li>

				<li><?=$lang['HIRE_SH_5']?> </li>

				<li><?=$lang['HIRE_SH_6']?> </li>

				<li><?=$lang['HIRE_SH_7']?> </li>

				</ul>

				<h3><?=$lang['N_10_4']?>&nbsp;&nbsp; <?=$lang['HIRRED']?></h3>

				<p class=link><?=$lang['HIRRED_1']?> </p>

				<ul class=link style='padding-left:20px'>

				

				<li><?=$lang['HIRRED_2']?></li>

				<li><?=$lang['HIRRED_3']?> </li>

				<li><?=$lang['HIRRED_4']?> </li>

				</ul>

				<h3><?=$lang['N_10_5']?>&nbsp;&nbsp;<?=$lang['PROHI_USE_SC']?></h3>

				<p class=link> 

				<?=$lang['HIRRED_5']?>

				<br><?=$lang['COMMERCIAL_PUR']?>

				</p>

				<ul class=link style='padding-left:20px'> 

				<li><?=$lang['MONITOR_ACC_WITHOUT_PER']?></li>

				<li><?=$lang['TAKING_ACTION_INSECURE']?></li>

				<li><?=$lang['DEEP_LINKING_PRIOR_PER']?></li>

				<li><?=$lang['INCORPORATE_COMMER']?></li>

				<li><?=$lang['MOD_OR_CHN_SERV']?></li>

				</ul>

				<h3><?=$lang['N_10_6']?>&nbsp;&nbsp;<?=$lang['GEN_RESTICTION']?> </h3>

				<p class=link> 

				<?=$lang['GEN_RESTICTION_1']?></p>

				<ul class=link style='padding-left:20px'>

				<li><?=$lang['GEN_RESTICTION_2']?></li>

				<li><?=$lang['GEN_RESTICTION_3']?></li>

				<li><?=$lang['GEN_RESTICTION_4']?> </li>

				<li><?=$lang['GEN_RESTICTION_5']?></li>

				<li><?=$lang['GEN_RESTICTION_6']?></li>

				</ul>

				<h3><?=$lang['N_10_7']?>&nbsp;&nbsp;<?=$lang['CONS_TERMINATION']?> </h3>

				<p class=link> 

				<?=$lang['IN_CASE_TERMINATION']?> oneoutsource.com.

				<br><br> <?=$lang['IN_CASE_VIOLATION']?>

				<?=$lang['IN_CASE_VIOLATION_1']?>

				<br><br><?=$lang['IN_CASE_VIOLATION_2']?>

				</p>

				<h3><?=$lang['N_11']?>&nbsp;&nbsp; <?=$lang['DISP_RESOLU_SERV']?> </h3>

	

	

				<h3><?=$lang['N_11_1']?>&nbsp;&nbsp;<?=$lang['DISP_RESOLU_SERV']?>  </h3>

				<p class=link> 

				<?=$lang['DISP_RESOLU_SERV_1']?>

				<br><br><?=$lang['DISP_RESOLU_SERV_2']?>
				</p>

				<h3><?=$lang['N_11_2']?>&nbsp;&nbsp; <?=$lang['DISP_RESOLU_PROCESS']?> </h3>

				<p class=link> 

				<?=$lang['TO_AVAIL_DISP_RESOLU_PROCESS']?>

				<br><br><?=$lang['RND_1']?>

				<?=$lang['PROCESS_PRO_PARTIES_3_OPPOR']?>

				<br><br><?=$lang['RND_2']?>

				

				<br><br><?=$lang['PARTIES_HAVE_7_DAYS']?>

				

				<br><br><?=$lang['RND_3']?>

				<br><br>

				<strong>Oneoutsource.com</strong> <?=$lang['WILL_SERVING__ROLE']?>

				</p>

				<h3><?=$lang['N_11_3']?>&nbsp;&nbsp;<strong>Oneoutsource.com</strong> 
				<?=$lang['NOT_PARTY_DISPUTE']?></h3>

				<p class=link> 

				<?=$lang['DISP_THAT_RES_ARGU']?> 

				</p>

				<h3><?=$lang['N_12']?>&nbsp;&nbsp;<?=$lang['REG_PRO_PER_DATA']?><h3>

				<p class=link> <?=$lang['REG_PRO_PER_DATA_1']?>
				</p>

				<h3><?=$lang['N_13']?> <?=$lang['TRD_MARK']?> <h3>

				<strong>Oneoutsource.com</strong> <?=$lang['ALSO_FOLLOW_POLICY']?>

				<h3><?=$lang['N_14']?>&nbsp;&nbsp;<?=$lang['COPYRIGHT']?> <h3>

				<h3><?=$lang['N_14_1']?>&nbsp;&nbsp;<?=$lang['COPYRIGHT_OF']?> <strong>Oneoutsource.com</strong></h3> 

				<p class=link><?=$lang['CONTENT_PROTECTED']?></p>

				<h3><?=$lang['N_14_2']?>&nbsp;&nbsp;<?=$lang['COPYRIGHT_OF_INFRINGEMENT']?></h3> 

				<p class=link><?=$lang['COPYRIGHT_OF_INFRINGEMENT_1']?></p>

				<h3><?=$lang['N_15']?> <?=$lang['WARRENTY_NO']?><h3>

				<p class=link>

				<strong>Oneoutsource.com</strong><?=$lang['DMG_YOUR_PROG']?> 

				<br><br><?=$lang['DOMESTIC_LAWS_TO_FAIR_TRADING']?> 

				<br><br><strong>Onoutsource.com</strong><?=$lang['LIMIT_LIABILITY']?> 

				</p>

				<h3><?=$lang['N_16']?>&nbsp;&nbsp;<?=$lang['LIMIT_LIABILITY_1']?></h3>

				

				<h3><?=$lang['N_16_1']?>&nbsp;&nbsp;<?=$lang['LIMIT_LIABILITY_1']?> </h3>

				<p class=link> 

				<?=$lang['LIMIT_LIABILITY_MAIN']?>

				</p>

				<h3><?=$lang['N_16_2']?>&nbsp;&nbsp;<?=$lang['JURIDICATION_LIMI']?></h3>

				<p class=link> 

				<?=$lang['JURIDICATION_LIMI_1']?>

				</p>

				<h3><?=$lang['N_16_3']?>&nbsp;&nbsp;<?=$lang['BAR_2_ACTION']?></h3>

				<p class=link> 

				<?=$lang['USER_AGREE_CURVS_CLAIM']?>

				</p>

				<h3><?=$lang['N_17']?><?=$lang['INDEMINITY']?>  </h3>

				<p class=link><?=$lang['THIRD_PARTY_VIOLATING']?> 

				</p>

				<h3><?=$lang['N_18']?> <?=$lang['LAW_APPLICABLE']?> </h3>

				

				<p class=link><?=$lang['LAW_APPLICABLE_1']?>  </p>

				<h3><?=$lang['N_19']?><?=$lang['GENERAL']?>  </h3>

				<p class=link> 

				<?=$lang['PROVISION_USER_AGREEMENT']?>

                <p ><?=$lang['Please']?><a href="#" onclick="javascript:window.parent.location='index.php?mode=contact-us';"><?=$lang['CONTACT_US']?></a> <?=$lang['REPORT_2_VIOL_TERM_COND']?></p>

                </p> 

</td></tr></table>

</div>









	</div>

  

    <div class="clear"></div>



<!-----------Footer----------------------------->

	<?php include 'includes/footer.php';?> 

<!-----------Footer End----------------------------->

     <div class="clear"></div>

      <!-- end job listing chart-->

</div>

<!--end content-->

<div class="clear"></div>

</div>

 </body>

</html>

<script type="text/javascript">



var countries=new ddajaxtabs("countrytabs", "countrydivcontainer")

countries.setpersist(true)

countries.setselectedClassTarget("link") //"link" or "linkparent"

countries.init()



</script>
<?php 
include "configs/path.php"; 
if($_REQUEST['SBMT_LANG']==1)
{
	$_SESSION[lang_id] = $_POST[lang_id];

}
if($_SESSION[lang_id]){

$lang_file=mysql_fetch_array(mysql_query("select * from  " . $prev . "language where lang_id='".$_SESSION[lang_id]."'"));
	$lang_file['short_code'];
$ln=$lang_file['short_code'];
include("lang/".$lang_file['short_code'].".inc.php");

}
else{
$ln="fr";
    $_SESSION[lang_id] = 0;
	include("lang/fr.inc.php");
}
include "function.php"; 
?>
<?php 
//include("country.php");
if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
{//echo $_REQUEST['categoryinput'];die();
	if($_REQUEST['categoryinput']!=0)
	{
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:index.php?cat_id=$categoryinput&#top_cat");
	}
	else
	{
		$categoryinput=$_REQUEST['categoryinput'];
		header("location:index.php?categoryform#");
	}	
}

/*updateautomenbership();*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?=$site_title?>
</title>
<meta name="keywords" content="<?=$site_keys?>" />
<meta name="description" content="<?=$site_desc?>" />
<meta name="title" content="<?=$site_title?>" />
<base href="<?=$vpath?>" />
<meta name="subject" content="<?=$site_desc?>" />
<meta name="submission" content="<?=$vpath?>" />
<meta name="abstract" content="<?=$vpath?>" />
<meta name="alias" content="<?=$vpath?>" />
<meta name="type" content="Internet" />
<meta name="source" content="Internet Service" />
<meta http-equiv="Content-Language" content="en" />
<meta name="use" content="Business" />
<meta name="distribution" content="GLOBAL" />
<meta name="rating" content="General" />
<meta name="cc" content="int" />
<meta name="revisit-after" content="5 days" />
<meta name="robots" content="index, follow" />
<meta name="pragma" content="no-cache" />
<meta name="copyright" content="Copyright <?=date("Y")?> of <?=$dotcom?>. All rights reserved." />
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
<meta name="document-class" content="Published" />
<meta name="document-classification" content="Website Buy Sale, Domain Buy Sale, Browse Jobs,Post Jobs" />
<meta name="document-rights" content="Copyrighted Work" />
<meta name="document-type" content="Public" />
<meta name="document-rating" content="General" />
<meta name="document-distribution" content="Global" />
<meta name="document-state" content="Dynamic" />
<link rel="shortcut icon" href="<?=$vpath?>favicon.ico" />
<script language="javascript" src="<?=$vpath;?>js/jquery.js" ></script>
<script language="javascript" src="<?=$vpath;?>js/jquery-1.6.2.js" ></script>
<script type="text/javascript">
function funonchangecategory(val)
{
	document.getElementById("categoryinput").value = val;
	if(document.getElementById("categoryinput").value != "")
	{
		document.categoryform.submit();	
	}
}
</script>
<!--<script src="<?=$vpath;?>js/jquery-1.7.2.js"></script>-->
<script src="<?=$vpath;?>js/jquery.ui.core.js"></script>
<script src="<?=$vpath;?>js/jquery.ui.widget.js"></script>
<script src="<?=$vpath;?>js/jquery.ui.accordion.js"></script>
<script>
	$(function() {
		$( "#accordion" ).accordion();
	});
	</script>
    
    
    <!--
 ////////////////Facebook login/////////////////
 -->
 <?php
 
//define('YOUR_APP_ID', '604291476262621');
//define('YOUR_APP_SECRET', '76dc12c53e571a474cfbceac43a505bf');

define('YOUR_APP_ID', '383175038456321');
define('YOUR_APP_SECRET', '3b6c771c3686051781bba1fb9008c01a');
function get_facebook_cookie($app_id, $app_secret) { 
   $signed_request = parse_signed_request(@$_COOKIE['fbsr_' . $app_id], $app_secret);
    $signed_request['uid'] = $signed_request['user_id']; // for compatibility 
    if (!is_null($signed_request)) {
      $access_token_response = @file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code={$signed_request['code']}");
       parse_str($access_token_response);
        $signed_request['access_token'] = $access_token;
        $signed_request['expires'] = time() + $expires;
    }
    return $signed_request;
}
function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);
  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }
  return $data;
}
function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}
if (isset($_COOKIE['fbsr_' . YOUR_APP_ID]))
{

$cookie = get_facebook_cookie(YOUR_APP_ID, YOUR_APP_SECRET);
$user = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token=' . $cookie['access_token']));
 $first_name = $user->first_name;
 $last_name = $user->last_name;
$username= $user->username;
 $emailid = $user->email;
$gender = $user->gender;

 if($gender=='male'){
 $gender='M';
 }
 if($gender=='female'){
 $gender='F';
 }
  $token = $cookie['access_token'];
 if($token) { $graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=" . $token;
    $result = json_decode(@file_get_contents($graph_url));
// unset($_COOKIE['fbsr_' . YOUR_APP_ID]);
  }
  if($emailid!='')
  {
  $count=0;
  $count1=0;
$query="select * from ".$prev."user where email='".$emailid."' ";
 
$result1=mysql_query($query); 
$rowfacebook=mysql_fetch_array($result1);
$count1=mysql_num_rows($result1);
//die("----------");
     	if($count1==0)
    {
	mysql_query("insert into ".$prev."user set username='".$username."',fname='".$first_name."',lname='".$last_name."',email='".$emailid."',reg_date=now()");
	$id=mysql_insert_id();
	if($id){
	$_SESSION['user_id']=$id;
$_SESSION['first_name']=$first_name;
$_SESSION['last_name']=$last_name;
$_SESSION['emailid']=$emailid;
$_SESSION['username']=$username;
$_SESSION['gender']=$gender;
$_SESSION['dob']=$dob;
$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);
//header("location: choose.php");
?>
 <script>parent.window.location = "dashboard.html";</script>
 <?php
 }else{
 echo "Error In facebook Login";
 }
}
else {
$_SESSION['user_id'] =	$rowfacebook["user_id"];
$_SESSION['email']	 =	$rowfacebook["email"];
$fname=txt_value_output($rowfacebook["fname"]);
$lname=txt_value_output($rowfacebook["lname"]);
$_SESSION['fullname'] = $fname.' '.$lname;	
$_SESSION['username']	=txt_value_output($rowfacebook["username"]);
$_SESSION['fname']	 =	$fname;
$_SESSION['user_type']	=	$rowfacebook["user_type"];
 $r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);
 
 
 
 

 ?>
<script>parent.window.location = "dashboard.html";</script>
 <?php
}
 }}
?>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<script>



window.fbAsyncInit = function() {

FB.init({

appId: '<?=YOUR_APP_ID?>',

cookie: true,

xfbml: true,

oauth: true

});

FB.Event.subscribe('auth.login', function(response) {

//window.location.reload();

});

FB.Event.subscribe('auth.logout', function(response) {

//window.location.reload();

});

};

(function() {

var e = document.createElement('script'); e.async = true;

e.src = document.location.protocol +

'//connect.facebook.net/en_US/all.js';

document.getElementById('fb-root').appendChild(e);

}());

function facebookLogin() { //called by login button onclick event

FB.login(function(response) {

window.location.reload();

}, {scope: 'email,user_birthday'});

}



</script>
 <!--
 ////////////////End Facebook login////////////////
 -->

    
    
<script type="text/javascript" src="<?=$vpath;?>highslide/highslide-with-html.js"></script>
<link rel="stylesheet" href="<?=$vpath?>css/Selectyze.jquery.css" type="text/css" />
<script type="text/javascript">

hs.graphicsDir = '<?=$vpath;?>highslide/graphics/';

hs.outlineType = 'rounded-white';

hs.wrapperClassName = 'draggable-header';

minWidth = 450;
</script>

<!--<link href="<?=$vpath;?>css/style.css" rel="stylesheet" type="text/css" />-->
<link rel="stylesheet" href="<?=$vpath;?>css/landing_narrow_banner.css" type="text/css">
<link rel="stylesheet" href="<?=$vpath;?>css/demo_table.css" type="text/css">
<?php
if($_SESSION[lang_id]){
?>
<link href="<?=$vpath?>css/style_<?=$lang_file['short_code']?>.css" rel="stylesheet" type="text/css" />
<?php
}else{
?>
<link href="<?=$vpath?>css/style_fr.css" rel="stylesheet" type="text/css" />
<?php
}
?>
</head>
<script type="text/javascript">
function changelang(val) {    
	document.getElementById("frm").submit();
    }

</script>
<?php
if($_SESSION[user_id]):
	$rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='CR'"));
	
	$rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from ".$prev."transactions where user_id = '".$_SESSION['user_id']."' and status = 'Y' and amttype='DR'"));
	
	$balsum = number_format(($rwbal['balsum1']-$rwbal2['baldeb']),2);
	
	$inbox_data="select * from  ".$prev."messages where receiver='".$_SESSION['user_id']."' and sender_id!='".$_SESSION['user_id']."' and status='Y' and user_type='reciver' and read_status='N'";
	$rec_date=mysql_query($inbox_data);
	$num_date=mysql_num_rows($rec_date);
endif;

if($_SESSION['user_id']!='')
{
	$select_user_type="select * from ".$prev."user where user_id='".$_SESSION['user_id']."'";
	$rec_user_type=mysql_query($select_user_type);
	$num_user_type=mysql_num_rows($rec_user_type);
	$row_user_type=mysql_fetch_array($rec_user_type);
}
?>
<?php
	
		function currentPageName($page){
			global $lang;
	switch(trim($page)){
		case 'Search Jobs':
				$pagename=$lang[FIND_JOBB];
				break;
		case 'View Freelancers / Contractors':
				$pagename=$lang['FIND_TALENT'];
				break;
		case 'View Buyers / Employers':
				$pagename=$lang['BUYER_EMPLOYER'];
				break;
		case 'How it Works':
				$pagename=$lang['WORKS'];
				break;
		case 'Browse Jobs by Categories':
				$pagename=$lang['BROWSE_CAT'];
				break;
		case 'Sign In':
				$pagename=$lang['s_g_n'];
				break;
		case 'Create an Account':
				$pagename=$lang['CREATE_ACCOUNT']. "<h1> ".$lang['ALREADY_HAVE_ACCOUNT']." <a href='login.php'>".$lang['s_g_n']."</a></h1>";;
				break;
		case 'Mailbox':
				$pagename=$lang['INBOX'];
				break;
		case 'My Profile':
				$pagename=$lang['MY_PROFILE'];
				break;
		case 'User Dashboard':
				$pagename=$lang['DASH_PGNM'];
				break;
		case 'Post your job':
				$pagename=$lang['POSTJOB_DIV_1'];
				break;
		case 'Bid on Projects of Top Categories':
				$pagename=$lang['BID_TOP'];
				break;
		case 'About Us':
				$pagename=$lang['ABOUT_US'];
				break;
		case 'Terms and conditions':
				$pagename=$lang['TERMS_AND_CONDITION'];
				break;
		default :
				$pagename="";
				break;
	}
	return $pagename;
}
?>
<body>
<?php



	if($current_page=='home')
	{	
	echo('<div id="main">');
	}
	else
	{
	echo('<div id="main2">');
	}
?>
<!--start_main_containt-->
<div class="main_containt">
<!--start_header-->
<div class="header">
  <div class="logo"><a href="<?=$vpath;?>index.html"><img src="<?=$vpath;?>images/logo.png" alt="" title="Revolujob" border="0" /></a></div>
  <div class="header_right">
    <!--<div class="search_pannel_top_002" style="  float: left;
    margin-left: 191px;
    margin-top: 6px;
    width: 201px;">
      <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#024981; list-style:none; width:74px; margin-top:4px; float:left; ">
        <?=$lang['LANGUAGE_NAME']?>
        : </div>
      <div style="list-style:none; float:right; width:120px;"> 
        
      </div>
    </div>-->
    <div class="link_bnt">
      <?php
					if($_SESSION['user_id'])
					{
						?>
      <a href="<?=$vpath;?>dashboard.html" title="<?=$lang['MYACCOUNT']?>"><img src="<?=$vpath;?>images/settings_icon.png" /></a> <a href="<?=$vpath;?>message.html" title="<?=$lang['INBOX']?>"><img src="<?=$vpath;?>images/Inbox_icon.png" /></a> <a href="<?=$vpath;?>logout.html" title="<?=$lang['LOG_OUT']?>"><img src="<?=$vpath;?>images/logout_icon.png" /></a>
      <?php
					}
					else
					{
						?>
      <a href="javascript: void(0);" onclick="facebookLogin(); " title="Login with facebook" style="float: left;"><img src="<?=$vpath;?>images/<?=$ln?>faclog_icon.png" alt="facebook-login" title="Facebook-login"/></a> 
      <!--			<a href="<?=$vpath;?>singup.html"><img src="<?=$vpath;?>images/resister_bnt.png" border="0" /></a>
						<a href="<?=$vpath;?>login.html"><img src="<?=$vpath;?>images/sinein_bnt.png" border="0" /></a>-->
      				<div class="topmenu">
        <ul>
          <li>
            <label style="float:left; margin-top:4px;"> <img src="images/register_icon.png" /></label>
            <a href="<?=$vpath;?>singup.html"><?=$lang['Reg']?></a></li>
          <li class="last">
            <label style="float:left; margin-top:4px;"><img src="images/login_icon.png" /></label>
            <a href="<?=$vpath;?>login.html"><?=$lang['LOGIN_LANG']?></a></li>
        </ul>
      </div>
	  <?php
					}
					?>
      
    </div>
    <div style="clear:both"></div>
    <?php
				if($_SESSION['user_id']!="")
				{
				$cur_page1=$_SERVER["SCRIPT_NAME"];
				$parts = Explode('/', $cur_page1);
				$cur_page = $parts[count($parts) - 1];
				//echo $cur_page;
                ?>
    <div style="clear:both"></div>
    <div class="topnav_1">
      <div id="access_1">
        <div class="menu_1">
          <ul>
            <li><a <?php if($cur_page=="postjob.php" || $cur_page=="bid_on_projects.php") echo 'class="select"'; ?> href="javascript:void(0);">
              <?=$lang['BID_ON_PROJECT']?>
              </a>
              <ul>
                <li><a  href="<?=$vpath;?>postjob.html">
                  <?=$lang['POST_PROJECT']?>
                  </a></li>
                <li><a href="<?=$vpath;?>bid_on_projects.html">
                  <?=$lang['BID_ON_PROJECT']?>
                  </a></li>
              </ul>
            </li>
            <li><a <?php if($cur_page=="browse-freelancers.php" || $cur_page=="browse-members.php" || $cur_page=="topuser.php") echo 'class="select"'; ?> href="javascript:void(0);">
              <?=$lang['PROJECT']?>
              </a>
              <ul>
                <?php
							/*if($num_user_type > 0)
							{
							if($row_user_type['user_type']=='E')
							{
							?>
								<li><a href="browse-freelancers.php?user=W">Browse Freelancers</a></li>
								<li><a href="topuser_list.html?user=W">Top Users</a></li>
							<?php
							}
							if($row_user_type['user_type']=='W')
							{
							?>
								 <li><a href="browse-members.php?user=E">BROWSE_EMPLOYERS</a></li>
								 <li><a href="topuser_list.html?user=W"><?=$lang['TOP_USERS']?></a></li>
							<?php
							}
							if($row_user_type['user_type']=='B')
							{*/
							?>
                <!--<li><a href="<?=$vpath;?>browse-freelancers.php?user=W">Browse Freelancers</a></li>-->
                <li><a href="<?=$vpath;?>browse-freelancers/">
                  <?=$lang['BROWSE_FREELANCERS']?>
                  </a></li>
                <!--<li><a href="<?=$vpath;?>browse-members.php?user=E">Browse Employers</a></li>-->
                <li><a href="<?=$vpath;?>browse-employers/">
                  <?=$lang['BROWSE_EMPLOYERS']?>
                  </a></li>
                <li><a href="<?=$vpath;?>topuser.html">
                  <?=$lang['TOP_USERS']?>
                  </a></li>
                <?php
							/*}
							}*/
							?>
              </ul>
            </li>
            <li><a <?php if($cur_page=="sear_all_jobs.php" || $cur_page=="sear_all_jobs.php" || $cur_page=="sear_all_jobs.php" || $cur_page=="category.php") echo 'class="select"'; ?> href="<?=$vpath;?>sear_all_jobs.html">
              <?=$lang['BROWSE_PROJECT']?>
              </a>
              <ul>
                <li><a href="<?=$vpath;?>all_jobs.html">
                  <?=$lang['ALL_JOBS']?>
                  </a></li>
                <li><a href="<?=$vpath;?>latest_jobs.html">
                  <?=$lang['LATEST_JOBS']?>
                  </a></li>
                <li><a href="<?=$vpath;?>featured_jobs.html">
                  <?=$lang['FEATURED_JOBS']?>
                  </a></li>
                <li><a href="<?=$vpath;?>category.html">
                  <?=$lang['BROWSE_CATEGORY']?>
                  </a></li>
              </ul>
            </li>
            <li><a <?php if($cur_page=="about_us.php") echo 'class="select"'; ?> href="<?=$vpath;?>about_us.html">
              <?=$lang['ABOUT_US']?>
              </a></li>
            <li class="last"><a <?php if($cur_page=="view_faq.php" || $cur_page=="contact_us.php") echo 'class="select"'; ?> href="javascript:void(0);" >
              <?=$lang['WORKS']?>
              </a>
              <ul>
                <li><a href="<?=$vpath;?>view_faq.html">
                  <?=$lang['FAQ']?>
                  </a></li>
                <li><a href="<?=$vpath;?>contact_us.html">
                  <?=$lang['CONTACT_US']?>
                  </a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <?php
				}
				else
				{
				?>
    <div class="topnav" style="margin-top:38px">
      <div id="access" role="navigation">
        <div class="menu" style="width:auto;">
          <ul>
            <!-- <li><a <?php if($current_page=="View Freelancers / Contractors") echo 'class="select"'; ?> id="talent" href="<?=$vpath;?>browse-freelancers.php?user=W"><?=$lang['FIND_TALENT']?> </a></li> -->
            <li><a <?php if($current_page=="View Freelancers / Contractors") echo 'class="select"'; ?> id="talent" href="<?=$vpath;?>find-talents/">
              <?=$lang['FIND_TALENT']?>
              </a></li>
            <li><a <?php if($current_page=="Search Jobs") echo 'class="select"'; ?> id="findwork" href="<?=$vpath;?>sear_all_jobs.html">
              <?=$lang[FIND_JOBB]?>
              </a></li>
            <li><a <?php if($current_page=="How it Works") echo 'class="select"'; ?>id="howitwork" href="<?=$vpath;?>howitworks.html">
              <?=$lang['WORKS']?>
              </a></li>
          </ul>
        </div>
      </div>
    </div>
    <?php
				}
				?>
  </div>
</div>

<!--end_header-->
<?php

	if($current_page!='home')
	{	
	?>
<!--Top Browse Start-->
<div class="browse_cont_top">
  <div class="browse_text_box">
    <p><?php echo currentPageName($current_page); ?></p>
  </div>
  <form action="sear_all_jobs.php" method="POST" name="myform" id="myform">
    <div class="search_contr">
      <div class="search_box2">
        <input type="text" name="keyword" id="keyword" placeholder=<?=$lang['SEARCH_JOB']?> onblur="if(this.value=='')this.value='Search Job';" onfocus="if(this.value=='Search Job')this.value='';"/>
        <div class="search_box_img"> <a href="javascript:document.getElementById('myform').submit();"><img src="images/search_icon.png" /></a> </div>
      </div>
    </div>
    <?php 
	if($current_page=='Search Jobs')
	{
	?>
    <a href="<?=$vpath;?>all_jobs.html">
    <input name="reset" type="button" value=<?=$lang['RESET_SEARCH']?> class="reset_bnt" />
    </a>
    <?php 
	}
	?>
  </form>
  <a href="<?=$vpath;?>postjob.html">
  <div class="post_job_bott">
    <h1>
      <?=$lang['FEATUTE_TAB4']?>
      <br />
      <span>
      <?=$lang['RIGHT_MENU3']?>
      </span></h1>
  </div>
  </a> </div>
<!--Top Browse End-->
<?php }else{ ?>
<div style="clear:both; height:1px;"></div>
<?php } ?>

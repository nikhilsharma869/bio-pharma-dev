<?php 
include "configs/path.php"; 
include "function.php"; 
//include("country.php");
$row_settings=@mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));/*if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")
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
*/
?>

<?php

if($_REQUEST['SBMT_LANG']==1)
{
$_SESSION[lang_id] = $_POST[lang_id];

}

if($_SESSION[lang_id]){

$lang_file=mysql_fetch_array(mysql_query("select * from  " . $prev . "language where lang_id='".$_SESSION[lang_id]."'"));
	$lang_file['short_code'];

include("lang/".$lang_file['short_code'].".inc.php");

}else{
    $_SESSION[lang_id] = 0;
	include("lang/en.inc.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?=$site_title?></title>
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="document-class" content="Published" />
<meta name="document-classification" content="Website Buy Sale, Domain Buy Sale, Browse Jobs,Post Jobs" />
<meta name="document-rights" content="Copyrighted Work" />
<meta name="document-type" content="Public" />
<meta name="document-rating" content="General" />
<meta name="document-distribution" content="Global" />
<meta name="document-state" content="Dynamic" />
<link rel="shortcut icon" href="<?=$vpath?>favicon.ico" /><script language="javascript" src="<?=$vpath;?>js/jquery.js" ></script>
<!--<script language="javascript" src="<?=$vpath;?>js/jquery-1.6.2.js" ></script>
<script type="text/javascript">
function funonchangecategory(val)
{
	document.getElementById("categoryinput").value = val;
	if(document.getElementById("categoryinput").value != "")
	{
		document.categoryform.submit();	
	}
}</script>-->
<!--<script src="<?=$vpath;?>js/jquery-1.7.2.js"></script>-->
<script src="<?=$vpath;?>js/jquery.ui.core.js"></script>
<script src="<?=$vpath;?>js/jquery.ui.widget.js"></script>
<script src="<?=$vpath;?>js/jquery.ui.accordion.js"></script>
<script>
	$(function() {
		$( "#accordion" ).accordion();
	});
	</script>

	
<script type="text/javascript" src="<?=$vpath;?>highslide/highslide-with-html.js"></script>
<link rel="stylesheet" href="<?=$vpath?>css/Selectyze.jquery.css" type="text/css" />
<script type="text/javascript">

hs.graphicsDir = '<?=$vpath;?>highslide/graphics/';

hs.outlineType = 'rounded-white';

hs.wrapperClassName = 'draggable-header';

minWidth = 450;
</script>

<link href="<?=$vpath;?>css/style.css" rel="stylesheet" type="text/css" />
<?php
if($_SESSION[lang_id]){
?>
<link href="<?=$vpath?>css/style_<?=$lang_file['short_code']?>.css" rel="stylesheet" type="text/css" />
<?php
}else{
?>
<link href="<?=$vpath?>css/style_en.css" rel="stylesheet" type="text/css" />
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
        	<div class="logo"><a href="<?=$vpath;?>index.html"><img src="<?=$vpath;?>images/logo.png" border="0" /></a></div>
            <div class="header_right">
	
            	<div class="link_bnt">
						 <div class="search_pannel_top_002">
        	<ul>
            <li><?=$lang['LANGUAGE_NAME']?>: </li>
            <li>
            	<!--<div id="google_translate_element"></div>-->
				<form name="frm" id="frm" method="post" action="">
				
				<input type="hidden" id="SBMT_LANG" name="SBMT_LANG" value="1">
				
				<select name="lang_id" id="lang_id" onchange="changelang(this.value)">
					<option value="0">English</option>
					<?php
					$l=mysql_query("select * from  " . $prev . "language where status='Y'");
					while($lng=mysql_fetch_array($l)){
					?>
					<option value="<?=$lng['lang_id']?>" <?php if($lng['lang_id']==$_SESSION['lang_id']){ echo "selected=selected";}?>><?=$lng['lang_name']?></option>
					<?php
					}
					?>
				</select>
				</form>
				
            </li>
            </ul>
        </div>
					<?php
					if($_SESSION['user_id'])
					{
						?>
						<a href="<?=$vpath;?>dashboard.html" title="My Account"><img src="<?=$vpath;?>images/settings_icon.png" /></a>
						<a href="<?=$vpath;?>message.html" title="Inbox"><img src="<?=$vpath;?>images/Inbox_icon.png" /></a>
						<a href="<?=$vpath;?>logout.html" title="Log Out"><img src="<?=$vpath;?>images/logout_icon.png" /></a>
						<?php
					}
					else
					{
						?>
						<a href="#" title="Login with facebook"><img src="<?=$vpath;?>images/faclog_icon.png" alt="facebook-login" title="Facebook-login"/></a>
						<a href="<?=$vpath;?>singup.html"><img src="<?=$vpath;?>images/resister_bnt.png" border="0" /></a>
						<a href="<?=$vpath;?>login.html"><img src="<?=$vpath;?>images/sinein_bnt.png" border="0" /></a>
						<?php
					}
					?>
                </div>
                <div class="clear"></div>
				<?php
				if($_SESSION['user_id']!="")
				{
				$cur_page1=$_SERVER["SCRIPT_NAME"];
				$parts = Explode('/', $cur_page1);
				$cur_page = $parts[count($parts) - 1];
				//echo $cur_page;
                ?>
				<div class="clear" style="height:22px;"></div>
				<div class="topnav_1">
				<div id="access_1">       
					<div class="menu_1">
						<ul>
						<li><a <?php if($cur_page=="postjob.php" || $cur_page=="bid_on_projects.php") echo 'class="select"'; ?> href="javascript:void(0);">PROJECTs</a>
							<ul>
								 <li><a  href="<?=$vpath;?>postjob.html">Post Project</a></li>
								 <li><a href="<?=$vpath;?>bid_on_projects.html">Bid on Projects </a></li>
							</ul>
						</li>
						<li><a <?php if($cur_page=="browse-freelancers.php" || $cur_page=="browse-members.php" || $cur_page=="topuser.php") echo 'class="select"'; ?> href="javascript:void(0);">FIND MEMBERS</a>
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
								 <li><a href="browse-members.php?user=E">Browse Employers</a></li>
								 <li><a href="topuser_list.html?user=W">Top Users</a></li>
							<?php
							}
							if($row_user_type['user_type']=='B')
							{*/
							?>
								<!--<li><a href="<?=$vpath;?>browse-freelancers.php?user=W">Browse Freelancers</a></li>-->								<li><a href="<?=$vpath;?>browse-freelancers/">Browse Freelancers</a></li>
								<!--<li><a href="<?=$vpath;?>browse-members.php?user=E">Browse Employers</a></li>-->								<li><a href="<?=$vpath;?>browse-employers/">Browse Employers</a></li>
								<li><a href="<?=$vpath;?>topuser.html">Top Users</a></li>
							<?php
							/*}
							}*/
							?>
							</ul>
						</li>
						<li><a <?php if($cur_page=="sear_all_jobs.php" || $cur_page=="sear_all_jobs.php" || $cur_page=="sear_all_jobs.php" || $cur_page=="category.php") echo 'class="select"'; ?> href="<?=$vpath;?>sear_all_jobs.html">BROWSE PROJECTS</a>
							<ul>
								 <li><a href="<?=$vpath;?>all_jobs.html">All Jobs</a></li>
								 <li><a href="<?=$vpath;?>latest_jobs.html">Latest Jobs</a></li>
								 <li><a href="<?=$vpath;?>featured_jobs.html">Featured Jobs</a></li>
								 <li><a href="<?=$vpath;?>category.html">Browse Category</a></li>
							</ul>
						</li>
						<li><a <?php if($cur_page=="about_us.php") echo 'class="select"'; ?> href="<?=$vpath;?>about_us.html">ABOUT US</a></li>
						<li class="last"><a <?php if($cur_page=="view_faq.php" || $cur_page=="contact_us.php") echo 'class="select"'; ?> href="javascript:void(0);" >HOW IT WORKS</a>
							<ul>
								 <li><a href="<?=$vpath;?>view_faq.html">FAQ</a></li>
								 <li><a href="<?=$vpath;?>contact_us.html">Contact Us</a></li>
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
                <div class="topnav">
                    <div id="access" role="navigation">       
                        <div class="menu">
                            <ul>
                          <!-- <li><a <?php if($current_page=="View Freelancers / Contractors") echo 'class="select"'; ?> id="talent" href="<?=$vpath;?>browse-freelancers.php?user=W">FIND TALENTS </a></li> -->														    <li><a <?php if($current_page=="View Freelancers / Contractors") echo 'class="select"'; ?> id="talent" href="<?=$vpath;?>find-talents/">FIND TALENTS </a></li> 	
							<li><a <?php if($current_page=="Search Jobs") echo 'class="select"'; ?> id="findwork" href="<?=$vpath;?>sear_all_jobs.html">World FIND WORKS</a></li>
                            <li><a <?php if($current_page=="How it Works") echo 'class="select"'; ?>id="howitwork" href="<?=$vpath;?>howitworks.html">HOW IT WORKS</a></li>						    						
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
		<p><?php echo $current_page; ?></p>
    </div>
	<form action="sear_all_jobs.php" method="POST" name="myform" id="myform">
    <div class="search_contr"><div class="search_box2">
       <input type="text" name="keyword" id="keyword" value="Search Job" onblur="if(this.value=='')this.value='Search Job';" onfocus="if(this.value=='Search Job')this.value='';"/>
      <div class="search_box_img"> <a href="javascript:document.getElementById('myform').submit();"><img src="images/search_icon.png" /></a>
       </div></div>
    </div>
	<?php 
	if($current_page=='Search Jobs')
	{
	?>
	<a href="<?=$vpath;?>all_jobs.html"><input name="reset" type="button" value="Reset Search" class="reset_bnt" /></a>
	<?php 
	}
	?>
	</form>

    <a href="<?=$vpath;?>postjob.html"><div class="post_job_bott"><h1>Post Your Job<br /><span>Its Free</span></h1>    </div></a>
    </div>
<!--Top Browse End-->
<?php }else{ ?>
<div style="clear:both; height:1px;"></div>
<?php } ?>
<?php
include "configs/path.php";
include "function.php";
?>
<?php
//include("country.php");
if (isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput'] != "") {//echo $_REQUEST['categoryinput'];die();
    if ($_REQUEST['categoryinput'] != 0) {
        $categoryinput = $_REQUEST['categoryinput'];
        header("location:index.php?cat_id=$categoryinput&#top_cat");
    } else {
        $categoryinput = $_REQUEST['categoryinput'];
        header("location:index.php?categoryform#");
    }
}

/* updateautomenbership(); */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>
            <?= $site_title ?>
        </title>
        <meta name="google-site-verification" content="TrAg3O3Gq_H3fsEx6RiviUgE9FZs_M60VCqmTKAjwz4" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="keywords" content="<?= $site_keys ?>" />
            <meta name="description" content="<?= $site_desc ?>" />
            <meta name="title" content="<?= $site_title ?>" />
            <base href="<?= $vpath ?>" />
            <meta name="subject" content="<?= $site_desc ?>" />
            <meta name="submission" content="<?= $vpath ?>" />
            <meta name="abstract" content="<?= $vpath ?>" />
            <meta name="alias" content="<?= $vpath ?>" />
            <meta name="type" content="Internet" />
            <meta name="source" content="Internet Service" />
            <meta http-equiv="Content-Language" content="en" />
            <meta name="use" content="Business" />
            <meta name="distribution" content="GLOBAL" />
            <meta name="rating" content="General" />
            <meta name="cc" content="int" />
            <meta name="revisit-after" content="5 days" />
            <meta name="robots" content="noindex, follow" />
            <meta name="pragma" content="no-cache" />
            <meta name="copyright" content="Copyright <?= date("Y") ?> of <?= $dotcom ?>. All rights reserved." />
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
                <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
                    <script language="javascript" src="<?= $vpath; ?>js/jquery.js" ></script>
                    <script language="javascript" src="<?= $vpath; ?>js/jquery-1.6.2.js" ></script>
                    <script type="text/javascript">
                        function funonchangecategory(val)
                        {
                            document.getElementById("categoryinput").value = val;
                            if (document.getElementById("categoryinput").value != "")
                            {
                                document.categoryform.submit();
                            }
                        }
                    </script>
                            <!--<script src="<?= $vpath; ?>js/jquery-1.7.2.js"></script>-->
                    <script src="<?= $vpath; ?>js/jquery.ui.core.js"></script>
                    <script src="<?= $vpath; ?>js/jquery.ui.widget.js"></script>
                    <script src="<?= $vpath; ?>js/jquery.ui.accordion.js"></script>
                    <script>
                        $(function() {
                            $("#accordion").accordion();
                        });
                    </script>
                    <script type="text/javascript" src="<?= $vpath; ?>highslide/highslide-with-html.js"></script>
                    <link rel="stylesheet" href="<?= $vpath ?>css/Selectyze.jquery.css" type="text/css" />
                    <script type="text/javascript">

                        hs.graphicsDir = '<?= $vpath; ?>highslide/graphics/';

                        hs.outlineType = 'rounded-white';

                        hs.wrapperClassName = 'draggable-header';

                        minWidth = 450;
                    </script>

                            <!--<link href="<?= $vpath; ?>css/style.css" rel="stylesheet" type="text/css" />-->
                    <link rel="stylesheet" href="<?= $vpath; ?>css/landing_narrow_banner.css" type="text/css">
                        <link rel="stylesheet" href="<?= $vpath; ?>css/demo_table.css" type="text/css">
                            <?php
                            if ($_SESSION[lang_id]) {
                                ?>
                                <link href="<?= $vpath ?>css/style_<?= $lang_file['short_code'] ?>.css" rel="stylesheet" type="text/css" />
                                <?php
                            } else {
                                ?>
                                <link href="<?= $vpath ?>css/style_en.css" rel="stylesheet" type="text/css" />
                                <?php
                            }
                            ?>
                            <script type="text/javascript" src="<?= $vpath ?>js/Selectyze.jquery.js"></script>
                            <script type="text/javascript">
                        $(document).ready(function() {
                            $('.selectyze1').Selectyze({
                                theme: 'skype'
                            });

                            $('.selectyze2').Selectyze({
                                theme: 'mac'
                            });

                            $('.selectyze3').Selectyze({
                                theme: 'grey'
                            });

                            $('.selectyze4').Selectyze({
                                theme: 'firefox'
                            });

                            $('.selectyze5').Selectyze({
                                theme: 'css3'
                            });

                        });
                            </script>
                            </head>
                            <script type="text/javascript">
                                function changelang(val) {
                                    document.getElementById("frm").submit();
                                }

                            </script>
                            <?php
                            if ($_SESSION[user_id]):
                                $rwbal = mysql_fetch_array(mysql_query("select sum(balance) as balsum1 from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='CR'"));

                                $rwbal2 = mysql_fetch_array(mysql_query("select sum(balance) as baldeb from " . $prev . "transactions where user_id = '" . $_SESSION['user_id'] . "' and status = 'Y' and amttype='DR'"));

                                $balsum = number_format(($rwbal['balsum1'] - $rwbal2['baldeb']), 2);

                                $inbox_data = "select * from  " . $prev . "messages where receiver='" . $_SESSION['user_id'] . "' and sender_id!='" . $_SESSION['user_id'] . "' and status='Y' and user_type='reciver' and read_status='N'";
                                $rec_date = mysql_query($inbox_data);
                                $num_date = mysql_num_rows($rec_date);
                            endif;

                            if ($_SESSION['user_id'] != '') {
                                $select_user_type = "select * from " . $prev . "user where user_id='" . $_SESSION['user_id'] . "'";
                                $rec_user_type = mysql_query($select_user_type);
                                $num_user_type = mysql_num_rows($rec_user_type);
                                $row_user_type = mysql_fetch_array($rec_user_type);
                            }
                            ?>
                            <?php

                            function currentPageName($page) {
                                global $lang;
                                switch (trim($page)) {
                                    case 'Search Jobs':
                                        $pagename = $lang[FIND_JOBB];
                                        break;
                                    case 'View Freelancers / Contractors':
                                        $pagename = $lang['FIND_TALENT'];
                                        break;
                                    case 'View Buyers / Employers':
                                        $pagename = $lang['BUYER_EMPLOYER'];
                                        break;
                                    case 'How it Works':
                                        $pagename = $lang['WORKS'];
                                        break;
                                    case 'Browse Jobs by Categories':
                                        $pagename = $lang['BROWSE_CAT'];
                                        break;
                                    case 'Sign In':
                                        $pagename = $lang['s_g_n'];
                                        break;
                                    case 'Create an Account':
                                        $pagename = $lang['CREATE_ACCOUNT'] . "<h1> " . $lang['ALREADY_HAVE_ACCOUNT'] . " <a href='login.php'>" . $lang['s_g_n'] . "</a></h1>";
                                        ;
                                        break;
                                    case 'Mailbox':
                                        $pagename = $lang['INBOX'];
                                        break;
                                    case 'My Profile':
                                        $pagename = $lang['MY_PROFILE'];
                                        break;
                                    case 'User Dashboard':
                                        $pagename = $lang['DASH_PGNM'];
                                        break;
                                    case 'Post your job':
                                        $pagename = $lang['POSTJOB_DIV_1'];
                                        break;
                                    case 'Bid on Projects of Top Categories':
                                        $pagename = $lang['BID_TOP'];
                                        break;
                                    case 'About Us':
                                        $pagename = $lang['ABOUT_US'];
                                        break;
                                    case 'Terms and conditions':
                                        $pagename = $lang['TERMS_AND_CONDITION'];
                                        break;
                                    default :
                                        $pagename = "";
                                        break;
                                }
                                return $pagename;
                            }
                            ?>
                            <body>
                                <?php
                                if ($current_page == 'home') {
                                    echo('<div id="main">');
                                } else {
                                    echo('<div id="main2">');
                                }
                                ?>
                                <!--start_main_containt-->
                                <div class="main_containt" <? if ($current_page == 'home') {
                                    ?>style="-moz-box-shadow:  0px 0px 5px -1px #747474;
                                         -webkit-box-shadow: 0px 0px 5px -1px #747474;
                                         box-shadow:         0px 0px 5px -1px #747474;background: none;"<? } ?>>
                                    <div class="topnav">
                                        <div class="main_div">
                                            <div class="logo"><a href="<?= $vpath; ?>"><img src="<?= $vpath; ?>images/logo.png" alt="" title="Freelancer4less" border="0" /></a></div>
                                            <!--add new div 21-03-14-->

                                            <div class="TopRhtSec">
                                                <div class="hdr_top_rht" style="width:auto;"><!--add_21-03-14_headertopright-->

                                                    <div style="<?php if ($_SESSION['user_id'] != "") {
                                    ?>min-width:240px;<?php } else { ?>min-width:402px;<?php } ?>">
                                                        
                                                        <?php
                                                                //echo $current_page;
                                                        if ($_SESSION['user_id'] != "") {
                                                            ?>
                                                        <div class="register_bnt"><a <?php if($current_page == "Dashboard"){?>class="active"<?php }?> href="<?= $vpath; ?>dashboard.html">Home</a></div>
                                                            <div class="register_bnt"><a <?php if($current_page == "Search Jobs"){?>class="active"<?php }?> href="<?= $vpath; ?>Jobs/">
                                                                    <?= $lang['FIND_PROJECT'] ?>
                                                                </a></div>
                                                            <div class="register_bnt"><a <?php if($current_page == "Post your job"){?>class="active"<?php }?> href="<?= $vpath; ?>postjob/">Post Project</a></div>
                                                            <div class="sign_bnt"><a <?php if($current_page == "View Freelancers / Contractors"){?>class="active"<?php }?> href="<?= $vpath; ?>find-talents/">
                                                                    <?= $lang['FIND_USER'] ?>
                                                                </a></div>
                                                            <div style="float: left; margin-left: 20px;">
                                                                <ul class="menu1">
                                                                    <li><a href="javascript:void(0)" style="padding:5px;">
                                                                            <?= substr($_SESSION['username'], 0, 10) ?>
                                                                            &nbsp;<img src="<?= $vpath ?>images/white_arrow.png" alt="" /></a>
                                                                        <ul class="sub-menu">
                                                                            <li> <a href="<?= $vpath; ?>dashboard.html">&nbsp;&nbsp;
                                                                                    <?= $lang['MY_ACCOUNT'] ?>
                                                                                </a> </li>
                                                                            <li> <a href="<?= $vpath; ?>logout.html">&nbsp;&nbsp;
                                                                                    <?= $lang['LOG_OUT'] ?>
                                                                                </a> </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <div class="register_bnt"><a href="<?= $vpath; ?>Jobs/">
                                                                    <?= $lang['FIND_PROJECT'] ?>
                                                                </a></div>
                                                            <div class="sign_bnt"><a href="<?= $vpath; ?>find-talents/">
                                                                    <?= $lang['FIND_USER'] ?>
                                                                </a></div>
                                                            <div class="register_bnt"><a href="<?= $vpath; ?>singup.html">
                                                                    <?= $lang['Reg'] ?>
                                                                </a></div>
                                                            <div class="sign_bnt"><a href="<?= $vpath; ?>login.html">
                                                                    <?= $lang['s_g_n'] ?>
                                                                </a></div>
                                                            <?php
                                                        }
                                                        ?>
                                                        <div class="menu" style="width:auto;">
                                                            <ul>
                                                                <?php
                                                                if ($_SESSION['user_id'] == "") {
                                                                    ?>
                                                                    <li><a <?php if ($current_page == "How it Works") echo 'class="select"'; ?>id="howitwork" href="<?= $vpath; ?>howitworks.html">
                                                                            <?= $lang['WORKS'] ?>
                                                                        </a></li>
                                                                    <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="clr"></div>   
                                                    </div>
                                                    <div class="clr"></div>   
                                                </div>
                                            </div>
                                            <div class="clr"></div>                          
                                        </div>
                                    </div>
                                    <!--start_header-->
                                    <div class="header">
                                        <?php /* ?>  <div class="logo"><a href="<?=$vpath;?>index.html"><img src="<?=$vpath;?>images/logo.png" alt="" title="Freelancer4less" border="0" /></a></div><?php */ ?>
                                    </div>
                                    <!--end_header-->
                                    <?php
                                    if ($current_page != 'home') {
                                        ?>
                                        <!--Top Browse Start-->
                                        <div class="browse_cont_top">
                                            <div class="browse_text_box">
                                                <p><?php echo currentPageName($current_page); ?></p>
                                            </div>
                                            <form action="sear_all_jobs.php" method="POST" name="myform" id="myform">
                                                <div class="search_contr">
                                                    <div class="search_box2">
                                                        <input type="text" name="keyword" id="keyword" placeholder=<?= $lang['SEARCH_JOB'] ?> onblur="if(this.value=='')this.value='Search Job';" onfocus="if(this.value=='Search Job')this.value='';"/>
                                                               <div class="search_box_img"> <a href="javascript:document.getElementById('myform').submit();"><img src="images/search_icon.png" /></a> </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($current_page == 'Search Jobs') {
                                                    ?>
                                                    <a href="<?= $vpath; ?>all_jobs.html">
                                                        <input name="reset" type="button" value=<?= $lang['RESET_SEARCH'] ?> class="reset_bnt" />
                                                    </a>
                                                    <?php
                                                }
                                                ?>
                                            </form>
                                            <a href="<?= $vpath; ?>postjob.html">
                                                <div class="post_job_bott">
                                                    <h1>
                                                        <?= $lang['FEATUTE_TAB4'] ?>
                                                        <br />
                                                        <span>
                                                            <?= $lang['RIGHT_MENU3'] ?>
                                                        </span></h1>
                                                </div>
                                            </a> </div>
                                        <!--Top Browse End-->
                                    <?php } else { ?>
                                        <div style="clear:both; height:1px;"></div>
                                    <?php }
                                    ?>

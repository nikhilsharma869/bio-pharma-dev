<?php
if($_COOKIE['remmeber']==1){echo "<script>window.location='".$vpath.$admin_folder."/dashboard.php'; /script>";}
if(empty($_SESSION['logged_in'])){echo "<script>window.location='".$vpath.$admin_folder."/index.php'; </script>";}


$main_icon_active_img	= '<img src="images/icon/active.png" width="20px" height="20px" align="absmiddle" border="0" alt="active" title="Active" />';
$main_icon_inactive_img = '<img src="images/icon/inactive.png" width="20px" height="20px" align="absmiddle" border="0" alt="inactive" title="Inactive" />';
$main_icon_edit_img		= '<img src="images/icon/edit.png" width="25px" height="25px" align="absmiddle" border="0" alt="edit" title="Edit" />';
$main_icon_del_img		= '<img src="images/icon/del.png" width="20px" height="20px" align="absmiddle" border="0" alt="del" title="Delete" />';
$main_icon_scrshot_img	= '<img src="images/icon/icon_screenshot.gif" align="absmiddle" border="0" alt="screenshot" />';
$main_icon_sub_img	= '<img src="images/sub.jpg" align="absmiddle" border="0" alt="add subcategory" />';
$main_icon_undersub_img	= '<img src="images/icon/sub.png" width="20px" height="20px" align="absmiddle" border="0" alt="add subcategory" />';
$main_icon_commission_img	= '<img src="images/commission.jpg" align="absmiddle" border="0" alt="View Commission" />';
$main_icon_fund_img	= '<img src="images/icon/fund.png" width="30px" height="30px" align="absmiddle" border="0" alt="Add Fund" title="Add Fund" />';
$main_icon_suspen_img	= '<img src="images/icon/suspen.png" width="30px" height="30px" align="absmiddle" border="0" alt="Suspended" title="Suspended" />';
$main_icon_close_img		= '<img src="images/icon/close.png" width="20px" height="20px" align="absmiddle" border="0" alt="Close" title="Close" />';
$main_icon_view_img		= '<img src="images/icon/view.png" width="25px" height="25px" align="absmiddle" border="0" alt="View" title="View" />';
$main_icon_add_img		= '<img src="images/icon/addi.png" width="20px" height="20px" align="absmiddle" border="0" alt="Add" title="Add" />';


 ?>

<?php 
ini_set("error_reporting","Off");
include "image.class.php";
//echo $_GET['width'];die();
if(!file_exists($_GET['img']))
{//echo "aa";die();
$_GET['img']='images/nopic.jpg';}
$image = new thumbnail($_GET['img']);
//echo $_GET['width'];die();
if(!empty($_GET['width'])){$size=(int) $_GET['width'];}else{$size=500;}
if(!empty($_GET['height'])){$size_h=(int) $_GET['height'];}else{$size_h=500;}
if($_REQUEST[width]):
	$image->size_width($_REQUEST[width]);   
endif;
if($_REQUEST[height]):
	$image->size_height($size_h); 
endif;
if($_REQUEST[size]):
	$image->size_height($size); 
endif;
//$image->size_auto($size);   
//$image->size_crop($size);
if($_REQUEST[width] && $_REQUEST[height]):    
$image->size_width_height($size,$size_h);
endif;
if($_GET['add_logo']==1)
{ 
	$image->add_logo("images/logo.png"); 
}
$image->show();

?>
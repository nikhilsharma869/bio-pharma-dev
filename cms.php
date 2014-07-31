<?php 
$pagetype="cms"; 
include "includes/header.php"; 
//if($_SESSION[lang_id]){
  //  $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=43 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
	
	//echo "select * from ".$prev."language_content where content_field_id=22 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'";
	
	//$row_content['contents']=$row_content_lang[content]; 
//}else{
//echo "select * from ".$prev."contents where id=".$_GET[id]."";
	//$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=".$_GET[id]."") );
//}
//$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='About Us'"));
//echo "select * from ".$prev."contents where id='".$_GET[id]."' AND cont_title = '".$_GET[cont_title]."'";

/*
.containt h1 {
	border-bottom: 1px solid #A8D4EA;
	color: #0073A3;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
	margin: 10px 0 0 12px;
	padding: 0 0 9px 0px;/*width: 96%;
}*/


$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=".$_GET[cms_id]));
?>
<style type="text/css">
.cont{
	font-size:24px;
	font-family:Arial;
	color:#143256;
	background-color:#ffffff;
	font-weight:normal;
	font-style:normal;
	font-variant:normal;
	text-decoration:none;
	vertical-align:baseline;
}
</style>
<!-----------Header End-----------------------------> 

<div class="container" style=" width: 1000px; margin: 0 auto; ">

    
   <!--Howitworks Start-->
     <div class="containt">
     <h1 ><span class="cont"><?=ucwords($row_content['cont_title'])?></span></h1>
     <div style="clear:both">&nbsp;</div>
    	<?php echo html_entity_decode($row_content['contents']);?>
     </div>

    <!-- left side-->
    <!-- rightside-->
	

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	
	
	
    
    <!-- end rightside-->

</div>
<div style="clear:both"></div>

<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->
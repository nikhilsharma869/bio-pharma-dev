<?php 
$current_page="Privacy Policy"; 
include "includes/header.php"; 
if($_SESSION[lang_id]){
    $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=32 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
	
	//echo "select * from ".$prev."language_content where content_field_id=22 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'";
	
	$row_content['contents']=$row_content_lang[content]; 
}else{
	$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='Privacy Policy'"));
}
//$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='About Us'"));
?>

<!-----------Header End-----------------------------> 

<div class="container" style=" width: 1000px; margin: 0 auto; ">

    
   <!--Howitworks Start-->
     <div class="containt">
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
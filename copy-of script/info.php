<?php 
$current_page="Informations"; 
include "includes/header.php";
$id=$_GET['id']; 
if($_SESSION[lang_id]){
    $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id='$id' and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));
	
	//echo "select * from ".$prev."language_content where content_field_id='$id' and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'";
	
	$row_content['contents']=$row_content_lang[content]; 
}else{
	
$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where id=".$id));
}

?>

<!-----------Header End-----------------------------> 

<div class="browse_contract">

    
   <!--Howitworks Start-->
   <div class="howitworks_box">
     <div class="howitworks_text">
	 
    	<?php echo html_entity_decode($row_content['contents']);?>

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
</div>
</div>
 <div style="clear:both; height:10px;"></div>
<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->
<?php 
include "includes/header.php"; 
$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='codeofconduct'"));
?>

<div class="how_works">

<div class="how_works_left">
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
	
	
	
    <div class="left rightside">
    <div>
	
	<div class="fb-like-box" data-href="http://www.facebook.com/platform" data-width="292" data-show-faces="true" data-stream="false" data-header="false"></div>
	
	
	</div>
    
    </div>
    <!-- end rightside-->
</div>

</div>
<!--CONTAINER MAIN END-->

</div>

</div>
</div>
<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->

</body>
</html>
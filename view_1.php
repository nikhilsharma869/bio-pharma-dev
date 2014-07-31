<?php 

include "includes/header.php"; 



?>

<script type="text/javascript" src="js/jquery-1.6.2.js"></script>

<script src="js/jquery.ui.core.js"></script>

<script src="js/jquery.ui.widget.js"></script>

<script src="js/jquery.ui.accordion.js"></script>

<!--<link rel="stylesheet" href="../demos.css">-->

<script type="text/javascript"> 

$(document).ready(function(){

$('p').click(function(){

	var currentId = $(this).attr('id');

	document.getElementById(currentId).style.fontWeight = 'bold';

    $('#'+currentId+'a').slideToggle("slow");

  });

});

</script>

 



 

<!-----------Header End----------------------------->

<div class="browse_contract">
<div class="howitworks_box">
     <div class="howitworks_text">

    <!--leftside-->
<?php 

	$query = mysql_query("select * from ".$prev."faq_category where status = 'Y' and id=".$_GET['id']." order by ord");
	$res_q=mysql_fetch_array($query);
    
?>
	<h1><?php echo $res_q['name']; ?></h1>
	<hr style="border:none; border-bottom:1px dotted #666666; margin-left:30px; margin-right:30px;" />


    <!--<p style="margin-left:30px;font-family:Arial, Helvetica, sans-serif; font-size:12px;">Alternatively browse our &nbsp;&nbsp;&nbsp;<a href="articles.php" style="color:#DA3E26; text-decoration:underline;">How-tos and Articles</a></p><br />-->

<?php 

	$rs1 = mysql_query("select * from ".$prev."faq_category where status = 'Y' and parent_id=".$_GET['id']." order by ord");

	if(mysql_num_rows($rs1)>0)

	{

		$count_question = 1;

		while($rw1 = mysql_fetch_array($rs1))

		{

		?>

			<h5><?php print $rw1[name];?></h5>

            <hr style="border:none; border-bottom:1px dotted #666666; margin-left:30px; margin-right:30px;" />

		<?php

			$rs2 = mysql_query("select * from ".$prev."faq where faq_cat = '".$rw1[id]."' and status = 'Y' order by ord");

			if(mysql_num_rows($rs2)>0)

			{

				while($rw2 = mysql_fetch_array($rs2))

				{

				?>

					 <p id="<?php print $count_question;?>" class="flip"><?php print $rw2[question];?></p><br />

                        <div id="<?php print $count_question;?>a" class="panel">

                        	<p><?php print nl2br(html_entity_decode($rw2[answers]));?>.</p>

                        </div>

				<?php

					$count_question++;

				}

			}

		}

	}

?>



   </div>

  </div>

</div>

<!--CONTAINER MAIN END-->




 <div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?> 
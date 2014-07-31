<?php $current_page = "Frequently Asked Questions"; ?>
<?php ob_start();?>
<?php
include("includes/header.php");
?>



    <!----Start Menu----->
       

<!------Start-middle-------->


<div class="container" style=" width: 1000px; margin: 0 auto; ">
  <h3 lang="en">FAQ</h3>
               <?php 

	$rs1 = mysql_query("select * from ".$prev."faq_category where status = 'Y' and parent_id=0 order by ord");

	if(mysql_num_rows($rs1)>0)

		{

			while($rw1 = mysql_fetch_array($rs1))

				{

				?>

					<a class="font_bold2" href="view_faq.html?id=<?php echo $rw1['id']; ?>" ><p class="link_class"><b><img src="images/inbox_arrow.png" class="space"  /> <?php print $rw1[name];?></b></p> </a>

			

		<?php



		}



	}



?>



</div>
<!------end_middle-------->
<?php
include("includes/footer.php");
?>
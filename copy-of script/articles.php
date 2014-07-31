<?php 

include "includes/header.php"; 

CheckLogin();

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

	/*alert('aa = '+currentId);*/

    $('#'+currentId+'a').slideToggle("slow");

  });

});

</script>

 

<style type="text/css"> 

p.flip

{

	margin-left:35px;

	font-family:Arial, Helvetica, sans-serif; 

	font-size:12px;

	border:none;

	color:#3b5998; 

	cursor:pointer;

}

div.panel

{

	margin-left: 50px;

	margin-top: 5px;

	margin-bottom: 5px;

	font-family:Arial, Helvetica, sans-serif;

	font-size:12px;

	text-align:justify;

	padding:8px 8px 8px 8px;

	height:auto;

	display:none;

	background-color:#e9f3fb;

	border:1px solid #8abde5;

	width:850px;

}

</style>



<!-----------Header End----------------------------->

<div class="recent_projects">

    <!--leftside-->

    

    <p style="font-family:Arial, Helvetica, sans-serif; font-size:32px;color:#a1282c; margin-left:30px; margin-top:20px;"><?=$lang['RD_THE']?> <?php print $dotcom;?> <?=$lang['ARTCL']?></p>

    <!--<p style="margin-left:30px;font-family:Arial, Helvetica, sans-serif; font-size:12px;">Alternatively browse our &nbsp;&nbsp;&nbsp;<a href="view.php" style="color:#DA3E26; text-decoration:underline;">Frequently Asked Questions.</a></p><br />-->

<?php 

	$rs1 = mysql_query("select * from ".$prev."article_category where status = 'Y' order by cat_id");

	if(mysql_num_rows($rs1)>0)

	{

		$count_question = 1;

		while($rw1 = mysql_fetch_array($rs1))

		{

		?>

			<p style=" margin-left:30px;font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;color:#3b5998;"><?php print $rw1[cat_name];?></p>

            <hr style="border:none; border-bottom:1px dotted #3b5998;margin-left:30px; margin-right:30px;" />

		<?php

			$rs2 = mysql_query("select * from ".$prev."article where status = 'Y' and ( cat_id like '".$rw1[cat_id].",%' or cat_id like '%,".$rw1[cat_id].",%' or cat_id like '%,".$rw1[cat_id]."')");

			if(mysql_num_rows($rs2)>0)

			{

				while($rw2 = mysql_fetch_array($rs2))

				{

					/*if(strcmp($rw1[cat_id], $rw2[cat_id]))

					{*/				

				?>

					 <p id="<?php print $count_question;?>" class="flip"><?php print $rw2[title];?></p>

                        <div id="<?php print $count_question;?>a" class="panel">

                        	<p><?php print nl2br($rw2[contents]);?>.</p>

                        </div>

				<?php

					$count_question++;

					/*}*/



				}

			}

			else

			{

				echo "<i><p style=\" margin-left:50px;font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;color:#cccccc;\">".$lang['NO_ARTICLES_POST']."</p></i>";

			}

		}

	}

?>





    <!-- left side-->

    <!-- rightside-->

    

    <!-- end rightside-->

    <div class="clear"></div>

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
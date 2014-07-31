<?php 

include "includes/header.php"; 

CheckLogin();

	$row_settings=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings where 1"));





	if(isset($_REQUEST['categoryinput']) && $_REQUEST['categoryinput']!="")

	{//echo $_REQUEST['categoryinput'];die();

		if($_REQUEST['categoryinput']!=0)

		{

			$categoryinput=$_REQUEST['categoryinput'];

			header("location:index.php?cat_id=$categoryinput&categoryform#");

		}

		else

		{

			$categoryinput=$_REQUEST['categoryinput'];

			header("location:index.php?categoryform#");

		}	

	}



?>




<!-----------Header End----------------------------->





<!--BANNER BOX-->

<?php include 'includes/banner.php';?> 



<!--BANNER BOX END-->



	

	

 <div class="recent_projects">   

            

    <!-- category sec-->

	

	<?php

	if($_REQUEST['cat_id']!="")

	{

		$r=mysql_query("select * from " . $prev . "categories  where cat_id=".$_REQUEST['cat_id']." and status='Y' order by cat_name");

	}

	else

	{

		//$r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");

	}

	?>

	

	

    <div id="category">

    <table width="980" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td colspan="5" style="border-bottom:1px solid #d1d1d1; color:#A1282C; padding:0px; margin:0px;"><h3>Jobs Category</h3></td>

    

  </tr>
    <tr>

    <td colspan="5" height="10"></td>

    

  </tr>

   <?php

    while($d=mysql_fetch_array($r))

    {

	?>

 <tr>

    <td colspan="5" height="2"></td>

    

  </tr>

  	<?php

	//	$rr=mysql_query("select * from " . $prev . "categories where parent_id='".$d['cate_id']."' and status='Y' order by cat_name");

	?>

  <tr valign="top">

    <td>

	

		<?php

					

					$select_skills="select * from " . $prev . "categories where cat_id='".$d['cat_id']."' and status='Y' order by cat_name";

					//echo $select_skills;

					$rec_skills=mysql_query($select_skills);

					$num_skills=mysql_num_rows($rec_skills);

					if($num_skills > 0)

					{

						$a=1;

						?>

						

						<div style="width:242px; float:left;">

							<table border="0" width="100%" cellpadding="0" cellspacing="0">

						<?php

							if($num_skills >= 4)

							{

								$cou=$num_skills/4;

								$a1=(int)$cou;

							}

							else

							{

								$a1=1;

							}

						while($row_skills=mysql_fetch_array($rec_skills))

						{

							$select_count_project="select freelan_projects_cats.*,freelan_projects.* from freelan_projects_cats,freelan_projects where freelan_projects_cats.cat_id='".$row_skills['cat_id']."' and freelan_projects_cats.id=freelan_projects.id and freelan_projects.status='open'";

							//echo $select_count_project;

							$rec_count_project=mysql_query($select_count_project);

							$num_count_project=mysql_num_rows($rec_count_project);

							//$fetch=mysql_fetch_array($select_count_project);

                           

							 

							

						?>

							 <tr>

                            

								<td  valign="top"><a href="details.php?cat_id=<?php echo $row_skills['cat_id'] ?>" style="font-weight:normal; text-decoration:none; color:#6d6d6d; font-weight:bold;"><?php echo $row_skills['cat_name'];?>.&nbsp;(<?php echo $num_count_project;?>)</a></td>
							  </tr>

						<?php

							if($a == $a1)

							{

								echo "</table>";

								echo "</div>";

								echo "<div style=\"width:242px; float:left;\">

							<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">";

							$a=0;	

							}

						$a++;	

						}

						?>
						</table>

		  </div>

					<?php

					}

					else

					{

					?>

		  <td style="padding:2px 9px 2px 2px;">

							<div style=" width:242px; margin:0 8px 0 0;  float:left; border:1px solid #CCCCCC;  line-height:25px;  font-weight:bold;">

							<div style="height:20px;">

							</div>

							<div align="center" style="color:#999999; font-size:10px;">

							Category not found..

							</div>

							<div style="height:20px;">

							</div>

							</div>

		  </td>

					<?php

					

					}

					?>		

	

	

		<!--<table cellpadding="0" cellspacing="0" border="0" width="100%">

		<tr>

			<td width="196">

				<table width="196" border="0" cellspacing="0" cellpadding="0">

		  <tr>

			<td width="20" class="cblt">&nbsp;</td>

			<td width="176" class="ctxt">Article Writing(1)</td>

		  </tr>

		  <tr>

			<td width="20" class="cblt">&nbsp;</td>

			<td width="176" class="ctxt">Blogs(1)</td>

		  </tr>

		  <tr>

			<td width="20" class="cblt">&nbsp;</td>

			<td width="176" class="ctxt">Bulk Mailing(2)</td>

		  </tr>

		  <tr>

			<td width="20" class="cblt">&nbsp;</td>

			<td width="176" class="ctxt">Event Planning(1)</td>

		  </tr>

		  <tr>

			<td width="20" class="cblt">&nbsp;</td>

			<td width="176" class="ctxt">Medical Billing/Coding(1)</td>

		  </tr>

		</table>

		

			</td>

		</tr>

		</table>-->

	</td>

  </tr>

  <?php

  }

  ?>

</table>

<!--end first table-->



<!-- end second table-->



<!-- end third table-->



<!-- end four table-->



<!-- end four table-->

    </div>

     <!--end category sec-->

     <!-- job listing chart-->

     <div>

     <div class="pbsection4">

       <div id="description" class="content1">

			<table width="930" border="0" cellspacing="0" cellpadding="0"  >

            <tr><td colspan="6" class="btbrd"></td></tr>

			

<!--///////////////////////////////////////////////////////// start latest jobs ////////////////////////////////////////////////////////////////-->			

		

 

 <tr>

    <td colspan="6" >

	<br/>

	<?php

	$_SESSION['browse_by_cat'] = $select_count_project;

	include("job_under_category.php");

	unset($_SESSION['browse_by_cat']);

	?>

	

	</td>

  </tr>



<!--///////////////////////////////////////////////////////// end latest jobs ////////////////////////////////////////////////////////////////-->	



  

  <tr><td colspan="6" class="btbrd2"></td></tr>

</table>



        </div>

		<p>&nbsp;</p>

		<p>&nbsp;</p>

		<div id="usage3" class="content1"></div>



		

     	<script src="js/jquery.js" type="text/javascript" charset="utf-8"></script>

		<script src="js/jquery.tabify.js" type="text/javascript" charset="utf-8"></script>

		<script type="text/javascript">

			// <![CDATA[

				

			$(document).ready(function () {

				$('#tab').tabify();

				

			});

					

			// ]]>

		</script>

          

          

       </div>	

     </div>

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
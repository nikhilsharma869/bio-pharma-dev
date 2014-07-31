<?php 

include "includes/headermenusimple.php"; 



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



<style type="text/css">

.alertbox1 {

	background-color: #E5F6FD;

	border: 1px solid #7FD7F7; 

	width:95%; height:25px;

	-webkit-border-radius:4px;

	-moz-border-radius:4px;

	padding:10px;

	line-height:25px;

}

.alertbox2 {

	background-color: #F2F6FE;

	border: 1px solid #647EB6; 

	width:95%; height:auto;

	-webkit-border-radius:4px;

	-moz-border-radius:4px;

	padding:10px;

	line-height:25px;

}

.errorboxdiv {

	background-color: #FCC;

	border: 1px solid #F00; 

	width:95%; height:25px;

	-webkit-border-radius:4px;

	-moz-border-radius:4px;

	padding:10px;

	line-height:25px;

	color:#F00;

	font-weight:bold;

}

</style>



 

    <!-- left side-->

    <!--middle -->

	<div class="recent_projects">

   <div class="edit_profile1">

     



<!--<div align="right">

Balance  :  $ <strong><?php print $balsum;?></strong><br />

Pending Transactions  :  $ <strong><?php print $sum1;?></strong>

</div>-->

<ul>

<li ><a href="latest_job.php">Latest Job</a></li>

<li class="selected" ><a href="featured_job.php">Featured Job</a></li>

<li ><a href="sear_all_jobs.php">All Jobs</a></li>

  



</ul>

   </div>



 <div class="how_works" align="center">

 

			<table width="935" border="0" cellspacing="0" cellpadding="0" style="font-size:14px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >

            <tr><td colspan="6" class="btbrd"></td></tr>

<tr>

    <td class="thtxt" width="285">Project Name</td>

    <td class="thtxt" width="80">Bid</td>

    <td class="thtxt" width="210">Job Type</td>

    <td class="thtxt"  width="130">Avg Bid</td>

    <td class="thtxt"  width="150">Time Left</td>

    <td class="thtxt" width="100" align="center">Action</td>
</tr>

   <tr>
     <td colspan="6" height="10"></td>
   </tr>
   <tr>

    <td colspan="6" >

	

	<?php

	include("featuredjobs.php");

	?>	</td>
  </tr>

<tr><td colspan="6" height="20"></td></tr>

<tr><td colspan="6" height="20" ></td></tr>
</table>



      </div>

		



<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->



    <!--end middle--> 

    <!-- rightside-->

    <!-- end rightside-->

</div>





   </div>

<!--end content-->





</div>

</div>

</div>



<?php include 'includes/footer.php';?> 

</body>

</html>
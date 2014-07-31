<?php

include_once("includes/header.php");



CheckLogin();



?>

<!-- content-->

<div class="freelancer">





<!--Profile-->

<?php include ("includes/leftpanel1.php");?> 



<script type="text/javascript" src="js/general_functions.js"></script>





<style type="text/css">

#process_waiting_dialog

{

  width:640px;

  height:100px;

  background:#eee;

  border:2px solid #aaa;

  position: absolute;

  margin-left: -170px; 

 }

</style>

<div class="profile_right">



<div class="edit_profile">

	<h2><span style="color:#6d6d6d; font-size:22px;"><?=$lang['WELCOME']?></span> <?php print $_SESSION['fullname'];?><br />

	<span><?=$lang['World_p1']?> <?=mysqldate_show($_SESSION[ldate],1)?></span></h2>

	

	<div align="right" style="padding-right:10px;">

	<?=$lang['BALANCE']?>  :  $ <strong><?php print $balsum;?></strong><br />

	<?=$lang['B_MSG']?>  :  $ <strong><?php print $sum1;?></strong>

	</div>

	<!--<ul>

	<li ><a href="profile.php">Update Profile</a></li>

	<li ><a href="select-expertise.php">Update Expertise</a></li>

	<li ><a href="upload-portfolio.php">Update Portfoolio</a></li>

	

	

	</ul>-->

	</div>

   

    

	

	

<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->

<div class="edit_form_box">

   





<table width="100%" border="0" cellspacing="0" cellpadding="0" >

<tr><td valign=top style='padding-left:15px;'>

<h2><?=$lang['DISP_RES']?></h2>

<table width="651" border="0" align="center" cellpadding="0" cellspacing="0">


    <tr>

    	<td align="left" valign="top" class="bx-border">&nbsp;<?=$lang['ABT_DESC']?> </td>
	</tr>

	

	<tr>

		<td align="left" valign="top" class="inner_bx-bottom">

		<table align="center" width="100%" cellpadding="0" cellspacing="0">

			<tr class="lnk">

			<td align="center">

			<br />			</td>
			</tr>
		</table>		</td>
	</tr>
</table>



</td><td width=20><p>&nbsp;</p>

</div>

<div id="process_waiting_dialog" style="display:none; "><br><img src="images/rotating_arrow.gif">&nbsp;&nbsp;<?=$lang['PL_WT_DATA']?></div>



</td><td valign=top>



</td></tr></table>



</div>



</div>

</div>





</div>

</div>

</div>

</div>

<?php include("includes/footer.php");?> 

</body>

</html>
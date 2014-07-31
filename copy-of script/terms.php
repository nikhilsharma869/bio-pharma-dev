<?php 


$current_page="Terms and conditions"; 


include "includes/header.php"; 

//$r = mysql_query("select * from ".$prev."paypal_settings where 1");

	//$row_settings=mysql_fetch_array($r);


?>


<?php


//if(!$link){header("Location: ./index.php"); exit();}








//echo $user_id;







/*
include("country.php");


$e=mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]); 


$data=@mysql_fetch_array($e);
*/

?>

<script>


function ValidateForm(form1) {

if (form1.elements['rate'].value == '') {


		alert('Please enter your rate/hour.');


		form1.elements['rate'].focus();


		return false;


	}


	if (form1.elements['profile'].value == '') {


		alert('Please enter profile details.');


		form1.elements['profile'].focus();


		return false;


	}


	


	return true;


}


</script>	


<div id="container" style=" width: 1000px; margin: 0 auto; ">

<div class="clear"></div>


<!-- content-->


<div id="content">


	<div id="profile_content">


		<script type="text/javascript" src="domcollapse.js"></script>


<style type="text/css">


		@import "ottools.css";


		/* domCollapse styles */


		@import "domcollapse.css";


</style>


<style type="text/css">


.link_txt


{


color:#000000;


text-decoration:none;


}


</style>


<div style='padding-left:10px;padding-right:10px'>


<table width="100%" border="0" cellspacing="0" cellpadding="0" >


<tr><td valign=top class="bid_heading_txt" style="font-size: 22px;"><?=$lang['TERMS_AND_CONDITION']?></td></tr>


<tr><td  style="border-top:1px solid #87b0b1;" height=3>&nbsp;</td></tr></table>	


<table width="100%">



<td>
<?php

if($_SESSION[lang_id]){

    $row_content_lang=mysql_fetch_array(mysql_query("select * from ".$prev."language_content where content_field_id=26 and table_name='contents' and field_name='contents' and lang_id='".$_SESSION[lang_id]."'"));



	$row_content['contents']=$row_content_lang[content];

} else {

	$row_content=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title='Terms'"));

	}

?>
      <?php echo html_entity_decode($row_content['contents']);?>
</td>
</tr></table>


</div>














	</div>


  


    <div class="clear"></div>

</div></div>



<!-----------Footer----------------------------->


	<?php include 'includes/footer.php';?> 


<!-----------Footer End----------------------------->


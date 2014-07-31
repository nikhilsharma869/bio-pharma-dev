<?php 
$current_page="Bid on Projects of Top Categories"; 
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


<script type="text/javascript">
function funonchangecategory(val)
{
	document.getElementById("categoryinput").value = val;
	if(document.getElementById("categoryinput").value != "")
	{
		document.categoryform.submit();	
	}
}


</script>


<!--RECENT PROJECTS-->
<div class="browse_contract">

  <div class="howitworks_box">
     <div class="howitworks_text">
	 <h1><?=$lang['TOP_CATEGORIES']?> </h1><br /><br />

	 
<?php include 'includes/top-category1.php';?> 




</div>
</div>
</div>
 <div style="clear:both; height:10px;"></div>
<!--FOOTER BOX-->
<?php include 'includes/footer.php';?> 
<!--FOOTER BOX END-->
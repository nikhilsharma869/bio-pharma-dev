<?php $ln="";
$current_page = "Frequently Asked Questions";
include "includes/header.php"; 

?>

<div class="container" style=" width: 1000px; margin: 0 auto; ">
<div class="howitworks_box">
     <div class="howitworks_text" style="min-height:525px">
     
<style type="text/css">
.cont{
	font-size:20px;
	font-family:Arial;
	color:#143256;
	background-color:#ffffff;
	font-weight:normal;
	font-style:normal;
	font-variant:normal;
	text-decoration:none;
	vertical-align:baseline;
	background: none repeat scroll 0 0 #FFFFFF;
	border-bottom: #0073A3 1px solid;
	float:left;
	width:100%;
}
</style>   
	<span class="cont">FAQ</span>  
    <div style="clear:both">&nbsp;</div>
  <h1 >Frequently Asked Questions on Topics :</h1>

  <hr style="border:none; border-bottom:1px dotted #666666; margin-left:30px; margin-right:30px;" />
  
<p>&nbsp;</p>
<?php 
	$rs1 = mysql_query("select * from ".$prev."faq_category where status = 'Y' and parent_id=0 order by ord");
	if(mysql_num_rows($rs1)>0)
		{
			while($rw1 = mysql_fetch_array($rs1))
				{
				?>
					<a class="font_bold2" href="<?=$vpath?>faq-details/<?php echo $rw1['id']; ?>/<?php echo strtolower(str_replace("&","+",str_replace(" ","-",$rw1[name])));?>/" ><p class="link_class"><b><img src="images/inbox_arrow.png" class="space"  /> <?php print $rw1[name];?></b></p> </a>
			
		<?php

		}

	}

?>


</div>





</div>



</div>



<!--FOOTER BOX-->

 <div style="clear:both; height:10px;"></div>

<?php include 'includes/footer.php';?> 
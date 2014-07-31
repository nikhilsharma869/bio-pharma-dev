<?php 

include("includes/header_dashbord.php");

include("includes/access.php");
ini_set("display_errors","1");
?>


<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="js/jquery.flot.min.js"></script>

<script>$.noConflict();</script>



	

	

<div class="main">

<?php include("includes/left_side.php"); ?>

<!-- End #sidebar  -->

<section id="content">

<div class="wrapper">



<!---- breadcrumb ---->

<div class="crumb">

<ul class="breadcrumb">

<li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>

<!--   <li><a href="#">Library</a></li>

<li class="active">Data</li>-->

</ul>



</div>

<!---- breadcrumb ---->



<div class="container-fluid">

<div id="heading" class="page-header">

<h1><i class="icon20 i-file-7"></i>FBO Import</h1>

</div>



<div class="row">

<?php

function edustat($table,$table_id,$type="")

{

global $db,$dbh,$prev;



if($type){$type2="where ".$type;}else{$type2="";}

   $q="select count(".$table_id.") from ".$prev.$table." ".$type2;

$r=mysql_query($q);

$total=@mysql_result($r,0);



return $total;

}

function edustat_deposite($table,$amt,$type="")

{

global $db,$dbh,$prev;

if($type){$type2="where ".$type;}else{$type2="";}

 $q="select sum(".$amt.") from ".$prev."".$table." ".$type2;

$r=mysql_query($q);

$total=@mysql_result($r,0);



return $total;

}

$main_bg_color="#a6d2ff";


		

?>



<div class="col-lg-12">


<div class="panel panel-default">

	<div class="panel-heading">

		<div class="icon"><i class="icon20 file"></i></div>

		<h4>FBO Import</h4>

		<a class="minimize" href="#"></a>

	</div><!-- End .panel-heading -->



	<div class="panel-body">
    	<?php
		function FBO_dateToTime($close_dt){
				$close_date_arr = explode('T',$close_dt);
				list($y,$m,$d) = explode('-',$close_date_arr[0]);
			
				$close_time = str_replace('Z','',$close_date_arr[1]);
				$close_time_arr = explode(':',$close_time);
				list($h,$i,$s) = $close_time_arr;
				$close_date = mktime($h,$i,$s,$m,$d,$y);
				return $close_date;
		}
			
		$message = '';
		
		if(isset($_POST['importRecords']) && $_POST['importRecords'] <> ''){
			ini_set('max_execution_time', 3000); 
			$start = 0;
			$api_key = "Tj6cK5J41iBC75LvJFsFRC1pOBYOCQZxNJoAWdr1";
			$category_id = 364;
			$recordCount = 0;
			
			
			
			$url = "https://api.data.gov/gsa/fbopen/v0/opps?q=Research+and+Development+in+Biotechnology&start=$start&data_source=FBO&&api_key=$api_key";
			$json = file_get_contents($url);
			$data = json_decode($json);
			//print'<pre>'; print_r($data->docs);exit;

			//Delete OLD FBO data
			mysql_query("Delete from serv_projects where main_cat_id='$category_id'");
			mysql_query("Delete from serv_projects_fbo ");
			mysql_query("Delete from serv_projects_cats where cat_id='$category_id'");
			
			$totalLoop = intval( ($data->numFound) / 10);
			for($loop=0;$loop<=$totalLoop;$loop++){
				if($loop>0){
					$start = ($loop*10);
					$url = "https://api.data.gov/gsa/fbopen/v0/opps?q=Research+and+Development+in+Biotechnology&start=$start&data_source=FBO&&api_key=$api_key";
					$json = file_get_contents($url);
					$data = json_decode($json);
				}
				
				for($i=0;$i<count($data->docs);$i++){
					$project_title = $data->docs[$i]->title;
					$chosen_id = $data->docs[$i]->id;
					$solnbr = $data->docs[$i]->solnbr;
					$notice_type = $data->docs[$i]->notice_type;
					$agency = $data->docs[$i]->agency;
					$office = $data->docs[$i]->office;
					$location = $data->docs[$i]->location;
					$zipcode = $data->docs[$i]->zipcode;
					$FBO_OFFADD = $data->docs[$i]->FBO_OFFADD;
					$FBO_CONTACT = $data->docs[$i]->FBO_CONTACT;
					$listing_url = $data->docs[$i]->listing_url;
					$FBO_SETASIDE = $data->docs[$i]->FBO_SETASIDE;
					$FBO_ARCHDATE_dt = $data->docs[$i]->FBO_ARCHDATE_dt;
					$FBO_POPCOUNTRY = $data->docs[$i]->FBO_POPCOUNTRY;
					$FBO_EMAIL_ADDRESS = $data->docs[$i]->FBO_EMAIL_ADDRESS;
					$FBO_EMAIL_DESC = $data->docs[$i]->FBO_EMAIL_DESC;
					$FBO_POPCOUNTRY = $data->docs[$i]->FBO_POPCOUNTRY;
					$FBO_POPZIP = $data->docs[$i]->FBO_POPZIP;
					$FBO_POPADDRESS = $data->docs[$i]->FBO_POPADDRESS;
					
					//if(isset($data->docs->description))
						$description = strval($data->docs[$i]->description);
					//else
						//$description = implode('',$data->docs[$i]->highlights->description);
					$description = str_replace("'",'',$description);
						
					$zipcode = $data->docs[$i]->zipcode;
					
					$expires = FBO_dateToTime($data->docs[$i]->close_dt);
					$creation = FBO_dateToTime($data->docs[$i]->posted_dt);
					if(isset($data->docs[$i]->FBO_ARCHDATE_dt))
						$fbo_archive_dt = FBO_dateToTime($data->docs[$i]->FBO_ARCHDATE_dt);
					$date2 = explode('T',$data->docs[$i]->posted_dt);
					
					//Insert Project
					$query = "Insert into serv_projects (chosen_id,date2,status,project,categories,expires,budgetmin,creation,user_id,description,zip,main_cat_id,project_type) 
													values('$chosen_id','$creation','open','$project_title',$category_id,'$expires','not sure','$creation',0,'$description','$zipcode','$category_id','F')";
					mysql_query($query);
					$project_id = mysql_insert_id();
					
					//Add project Category
					$query = "Insert into serv_projects_cats (id,cat_id) values('$project_id','$category_id')";
					mysql_query($query);
					
					//Additional Projectd Details
					$query = "INSERT INTO `serv_projects_fbo` (`project_id`, `solnbr`, `agency`, `office`, `location`, `zipcode`, `notice_type`, `fbo_offadd`, `fbo_contact`, `listing_url`, `fbo_setaside`, `fbo_email_address`, `fbo_email_desc`, `fbo_pop_country`, `fbo_pop_zip`, `fbo_pop_address`, `fbo_archive_dt`) 
														VALUES ('$project_id', '$solnbr', '$agency', '$office', '$location', '$zipcode', '$notice_type', '$FBO_OFFADD', '$FBO_CONTACT', '$listing_url', '$FBO_SETASIDE', '$FBO_EMAIL_ADDRESS', '$FBO_EMAIL_DESC', '$FBO_POPCOUNTRY', '$FBO_POPZIP', '$FBO_POPADDRESS', '$fbo_archive_dt');";
					mysql_query($query);
					$recordCount++;
				}
			
			}//Main Loop
			echo '<h3>Total Projects Imported : '.$recordCount.'</h3>';
		
		}
		else{
		?>
		
		<form action="" method="post">
			<h3>Import projects from FBO.GOV. It may take few minutes to complete this proccess. Please do not close the window or refresh the page.</h3>
			<br />
			<input type="submit" name="importRecords" class="" value="submit" />
		</form>
		<?php }?>
    </div>
    <!-- End .panel-body -->

</div>













</div>





</div><!-- End .col-lg-12  -->   







</div><!-- End .row-fluid  -->

</div> <!-- End .container-fluid  -->

</div> <!-- End .wrapper  -->

</section>

</div><!-- End .main  -->

</body>

</html>
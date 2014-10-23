<?php
if($_SESSION['user_type'] == 'W') {
$data = mysql_fetch_array(mysql_query("select * from ".$prev."user where user_id = ".$_SESSION['user_id']));
	if(md5($data['email'].$data['fname'].$data['lname']) == $data['password']) {
?>
		<div class="alert alert-success apllybid-success-page" role="alert">
			<div class="apllybid-success">
				<span><i class="fa fa-remove"></i></span>
				<p class="succ-job-info">
					Require change your Sercurity PIN please click <a href="<?=$vpath?>setting.html">here</a>
				</p>
			</div>
		</div>
<?php
	}
}
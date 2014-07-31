<?php
include("../configs/path.php");
  $sql="SELECT `password` FROM `".$prev."admin` WHERE `admin_id`='".$_SESSION['admin_id']."'";
 $result=mysql_query($sql);
 $row=mysql_fetch_assoc($result);
 if(strcmp($row['password'],md5($_POST['oldpass']))==0){
	if(strcmp($_POST['newpass'], $_POST['confirmpass']) == 0){
		 $sql="UPDATE `".$prev."admin` SET `password`='".md5($_POST['newpass'])."' WHERE `admin_id`='".$_SESSION['admin_id']."'";
		$r=mysql_query($sql);
		if( $r ) {
			$_SESSION['succ_msg'] = 'password successfullychange';	?>			             <script>window.location.href="<?=$vpath?>admin_new/changepassword.php";</script>			<?php
		  }
	}
	else{
		$_SESSION['error_msg'] ='newpassword and confirm password not match';
		?>			             <script>window.location.href="<?=$vpath?>admin_new/changepassword.php";</script>			<?php
	}
} 
else{
	$_SESSION['error_msg'] = 'old password wrong';
		?>			          <script>window.location.href="<?=$vpath?>admin_new/changepassword.php";</script>			<?php
}
 ?>

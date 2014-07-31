<?php
require_once("configs/path.php");
?>

    <?
    if ((!empty($_REQUEST['username'])) && (!empty($_REQUEST['user_id'])) && (!empty($_REQUEST['email']))) {
        $username = txt_value($_REQUEST['username']);
		$user_id = txt_value($_REQUEST['user_id']);
		$email = txt_value($_REQUEST['email']);
		
        $r = mysql_query("select * from " . $prev . "user where (md5(user_id)='" . $user_id . "' or md5(username)='" . $username . "' or md5(email)='" . $user_id . "' ) and status='Y' and v_stat='Y'");

      
        if (@mysql_num_rows( $r)==1) {
		$d = @mysql_fetch_assoc($r);
            
                session_regenerate_id();

                $fname = $d["fname"];

                $lname = $d["lname"];

                $_SESSION['fullname'] = $fname . ' ' . $lname;

                $_SESSION['user_id'] = $d["user_id"];

                $_SESSION['username'] = $d["username"];

                $_SESSION['email'] = $d["email"];

                $_SESSION['user_type'] = $d["user_type"];

                $_SESSION['ldate'] =$d["ldate"];

                $_SESSION['gold_member'] = $d["gold_member"];

                $_SESSION['ip'] = $d["ip"];

                $user_type = $d["user_type"];

                $profile = $d["profile"];



                $r3 = mysql_query("update " . $prev . "user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=" . $_SESSION['user_id']);

             

                if ($_REQUEST['returnpage']) {
                    redirect($vpath . txt_value($_REQUEST['returnpage']));
                } else {
                    header('Location: ' . $vpath . 'dashboard.php');
                }
            } else {
                header('Location: ' . $vpath . 'login.php');
            }
        
    
}
?>
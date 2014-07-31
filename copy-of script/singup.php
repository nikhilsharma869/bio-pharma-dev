<?php 

$current_page="Create an Account"; 

include ('includes/header.php');

include("country.php");

?>
 <?php

define('YOUR_APP_ID', '681291001903083');
define('YOUR_APP_SECRET', 'd8e6b5a82a588bf9ce293d8fee15d044');
function get_facebook_cookie($app_id, $app_secret) { 
   $signed_request = parse_signed_request(@$_COOKIE['fbsr_' . $app_id], $app_secret);
    $signed_request['uid'] = $signed_request['user_id']; // for compatibility 
    if (!is_null($signed_request)) {
      $access_token_response = @file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=&client_secret=$app_secret&code={$signed_request['code']}");
       parse_str($access_token_response);
        $signed_request['access_token'] = $access_token;
        $signed_request['expires'] = time() + $expires;
    }
    return $signed_request;
}
function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);
  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }
  return $data;
}
function base64_url_decode($input) {
  return base64_decode(strtr($input, '-_', '+/'));
}
if (isset($_COOKIE['fbsr_' . YOUR_APP_ID]))
{

$cookie = get_facebook_cookie(YOUR_APP_ID, YOUR_APP_SECRET);

$user = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token=' . $cookie['access_token']));

 $first_name = $user->first_name;
 $last_name = $user->last_name;
$username= $user->username;
$emailid = $user->email;
$gender = $user->gender;

 if($gender=='male'){
 $gender='M';
 }
 if($gender=='female'){
 $gender='F';
 }
  $token = $cookie['access_token'];
 if($token) { $graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=" . $token;
    $result = json_decode(@file_get_contents($graph_url));

  }
  if($emailid!='')
  {
  
  $count=0;
  $count1=0;
 $query="select * from ".$prev."user where email='".$emailid."' ";
 
$result1=mysql_query($query); 
$rowfacebook=mysql_fetch_array($result1);
$count1=mysql_num_rows($result1);
     	if($count1==0)
    {
	
	mysql_query("insert into ".$prev."user set username='".$username."',fname='".$first_name."',lname='".$last_name."',email='".$emailid."',reg_date=now(),user_type='".$_SESSION[userty]."'");
	$id=mysql_insert_id();
	if($id){
	$_SESSION['user_id']=$id;
$_SESSION['first_name']=$first_name;
$_SESSION['last_name']=$last_name;
$_SESSION['emailid']=$emailid;
$_SESSION['username']=$username;
$_SESSION['gender']=$gender;
$_SESSION['dob']=$dob;
$_SESSION['user_type']	=$_SESSION[userty];
$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);
unset($_SESSION[userty]);
?>
<script>parent.window.location = "dashboard.html";</script>
 <?php
 }else{
 echo "Error In facebook Login";
 }
}
else {
$_SESSION['user_id'] =	$rowfacebook["user_id"];
$_SESSION['email']	 =	$rowfacebook["email"];
$fname=txt_value_output($rowfacebook["fname"]);
$lname=txt_value_output($rowfacebook["lname"]);
$_SESSION['fullname'] = $fname.' '.$lname;	
$_SESSION['username']	=txt_value_output($rowfacebook["username"]);
$_SESSION['fname']	 =	$fname;
$_SESSION['user_type']	=	$rowfacebook["user_type"];
 $r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);
unset($_SESSION[userty]);
 ?>
<script>parent.window.location = "dashboard.html";</script>
 <?php
}
 }}
?>
<script src="http://connect.facebook.net/en_US/all.js"></script>

<script>

window.fbAsyncInit = function() {

FB.init({

appId: '<?=YOUR_APP_ID?>',

cookie: true,

xfbml: true,

oauth: true

});

FB.Event.subscribe('auth.login', function(response) {

//window.location.reload();

});

FB.Event.subscribe('auth.logout', function(response) {

//window.location.reload();

});

};

(function() {

var e = document.createElement('script'); e.async = true;

e.src = document.location.protocol +

'//connect.facebook.net/en_US/all.js';

document.getElementById('fb-root').appendChild(e);

}());

function facebookLogin(usertype) { //called by login button onclick event
 $.ajax({
       type: "POST",
	   data:"usertype="+usertype,
       url: "<?=$vpath?>/setuser.php",
	    
       success: function(msg){
	  
	  FB.login(function(response) {

window.location.reload();

}, {scope: 'email,user_birthday'});
	  
	  
       }
		});




}

</script>

<div style="width:100%; float:left; background:#FFF;">
<div class="main_div2">

<div class="inner-middle">

<div class="page_headding">

	<h2><?=$lang['NEW_TO_FREELANCELESS']?> <a href="javascript:void(0)"><?=$lang['SIGN_UP_NOW']?></a></h2>

    <p><?=$lang['ARE_YOU_READY_TO_REGISTER']?> <a href="<?=$vpath?>login.html"><?=$lang['s_g_n']?></a>	</p>

</div>

<div class="clear"></div>

<div class="register_panel">

	<div class="register_box">

    	<h2><?=$lang['DO_YOU_POST_PROJECT_HIRE']?></h2>

	<div class="register_bnt1"><a href="<?=$vpath?>signup-employer.html"><?=$lang['Reg']?></a></div>

    <p> <?=$lang['OR_LOGIN_USING']?></p>

    <div class="link_icon">

    <a href="javascript:void(0)" onclick="facebookLogin('E')"><img src="images/facebook_icon.png" align="left" style="margin-right:90px;" /></a>

  

    

    </div>

    

    </div>

    <div class="register_box1">

    	<h2><?=$lang['DO_YOU_WANT_TO_JOIN_AND_FIND_WORK']?></h2>

	<div class="register_bnt2"><a href="<?=$vpath?>signup-worker.html"><?=$lang['Reg']?></a></div>

   <p><?=$lang['OR_LOGIN_USING']?> <a href="javascript:void(0)" onclick="facebookLogin('W')" style="padding-left:25px;"><img src="images/facebook_icon.png"
    align="right" valign="" style="margin-right:95px;" /></a>


   
</p>
    

    </div>

    

    <div class="clear"></div>

    <div class="comitment"><?=$lang['WE_BELIEVE_INDUVIDUAL_FREELANCER']?></div>

</div>



</div>

</div></div>



<?php include 'includes/footer.php';?>


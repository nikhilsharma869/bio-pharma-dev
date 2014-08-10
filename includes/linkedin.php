<?php
session_start();
// Change these
define('API_KEY',      '75l1h2cajk93eu'                                          );
define('API_SECRET',   'eQQLZ3C3Lm5qDbEl'                                       );
define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
define('SCOPE',        'r_fullprofile r_emailaddress rw_nus'                        );
 
// You'll probably use a database
// session_name('linkedin');


require_once("../configs/config.php");
require_once("../configs/path.php");
require_once("linkedin_api.php");
 
// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {
    // User authorized your application
    if ($_SESSION['state'] == $_GET['state']) {
        // Get token so you can make API calls
        getAccessToken();
    } else {
        // CSRF attack? Or did you mix up your states?
        exit;
    }
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        getAuthorizationCode();
    }
}
 
// Congratulations! You have a valid token. Now fetch your profile 
$fields = 'id,email-address,firstName,lastName,headline,location:(name),industry,summary,specialties,positions,public-profile-url,proposal-comments,associations,interests,publications,patents,languages,skills,certifications,educations,courses,volunteer,three-current-positions,three-past-positions,num-recommenders,recommendations-received,following,job-bookmarks,suggestions,date-of-birth';
$user = fetch('GET', '/v1/people/~:('.$fields.')');
// echo "<pre>";
// var_dump($user);

for($i=0;$i<count($user->positions->values);$i++){
    $positions .= $user->positions->values[$i]->title.' at '.$user->positions->values[$i]->company->name.' from '.$user->positions->values[$i]->startDate->year.', ';
}
$datetime = date('Y-m-d H:i:s');
$r=mysql_query("select * from  ".$prev."user where  email='".$user->emailAddress."'");
$n=@mysql_num_rows($r);

if($n>0){        
    $query2 = "update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate='".$datetime."', profile='".$user->summary."', work_experience='".$positions."' where user_id=".@mysql_result($r,0,"user_id");
    $r2=mysql_query($query2);  
} else {
    $query = "Insert into ".$prev."user (email,username,password,fname,lname,status,reg_date,ldate,profile,ip,work_experience) values ('".$user->emailAddress."','".$user->emailAddress."','".md5($user->emailAddress)."','".$user->firstName."','".$user->lastName."','Y','".$datetime."','".$datetime."','".$user->summary."','".$_SERVER['REMOTE_ADDR']."','".$positions."')";
    $r3 = mysql_query($query);      
}
    $r4=mysql_query("select * from  ". $prev . "user where  (email=\"".txt_value($user->emailAddress). "\")");
    session_regenerate_id();
    
    $fname=txt_value_output(@mysql_result($r4,0,"fname"));
    $lname=txt_value_output(@mysql_result($r4,0,"lname"));
    $_SESSION['fullname'] = $fname.' '.$lname;                  
    $_SESSION['user_id']    =@mysql_result($r4,0,"user_id");
    $_SESSION['username']   =txt_value_output(@mysql_result($r4,0,"username"));
    $_SESSION['email']      =txt_value_output(@mysql_result($r4,0,"email"));
    $_SESSION['user_type']  =txt_value_output(@mysql_result($r4,0,"user_type"));
    $_SESSION['ldate']      =@mysql_result($r4,0,"ldate");
    $_SESSION['gold_member']=@mysql_result($r4,0,"gold_member");
    $_SESSION['ip']         =@mysql_result($r4,0,"ip");
?>
 
<script type="text/javascript">
window.close();
window.opener.location = '/dashboard.php';
</script>

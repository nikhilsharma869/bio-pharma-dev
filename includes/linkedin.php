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
 
function insertSkillLinkedin($skills, $user_id, $prev) {
    for($i=0;$i<count($skills);$i++){
        $skill_linkedin = mysql_real_escape_string($skills[$i]->skill->name);
        $skill_linkedin = ucwords($skill_linkedin);
        $rss=mysql_query("select * from  ".$prev."skill_linkedin where  skill_name='".$skill_linkedin."' and user_id='".$user_id."'");
        $nss=@mysql_num_rows($rss);
        if (!$nss) {
            $url_skill = strtolower(trim($skill_linkedin));
            $url_skill = preg_replace('/[^a-z0-9-]/', '-', $url_skill);
            $url_skill = preg_replace('/-+/', "-", $url_skill);
            $query_insert_skill_linkedin = "Insert into ".$prev."skill_linkedin (skill_name,url_skill,user_id,created_time) values ('" . $skill_linkedin . "','".$url_skill."','".$user_id."','".date('Y-m-d H:i:s')."')";
            $risl=mysql_query($query_insert_skill_linkedin);
        }        
    }
}

$user_login_type = $_SESSION['user_login_type'];
// Congratulations! You have a valid token. Now fetch your profile 
$fields = 'id,email-address,firstName,lastName,headline,location:(name),industry,summary,specialties,positions,public-profile-url,proposal-comments,associations,interests,publications,patents,languages,skills,certifications,educations,courses,volunteer,three-current-positions,three-past-positions,num-recommenders,recommendations-received,following,job-bookmarks,suggestions,date-of-birth,picture-urls::(original),honors-awards';
$user = fetch('GET', '/v1/people/~:('.$fields.')');

// echo "<pre>";
// var_dump($user);
// exit();

//Experience
for($i=0;$i<count($user->positions->values);$i++){
    $positions .= $user->positions->values[$i]->title.' at '.$user->positions->values[$i]->company->name.' from '.$user->positions->values[$i]->startDate->year.', ';
}
$positions = substr($positions,0,-2);

//Publications
for($i=0;$i<count($user->publications->values);$i++){
    $publications .= $user->publications->values[$i]->title.' from '.$user->publications->values[$i]->date->year.', ';
}
$publications = substr($publications,0,-2);

//Languages
for($i=0;$i<count($user->languages->values);$i++){
    $languages .= $user->languages->values[$i]->language->name.', ';
}
$languages = substr($languages,0,-2);

//Skills
for($i=0;$i<count($user->skills->values);$i++){
    $skills .= $user->skills->values[$i]->skill->name.', ';
}
$skills = substr($skills,0,-2);


if(isset($user->dateOfBirth)) {
    $dateOfBirth = $user->dateOfBirth;
} else {
    $dateOfBirth = array();
}
 


$datetime = date('Y-m-d H:i:s');
$r=mysql_query("select * from  ".$prev."user where  email='".$user->emailAddress."'");
$n=@mysql_num_rows($r);
  
if($n>0){        

    $query_update_user = "update ".$prev."user set user_type='" . strtoupper($user_login_type) . "', ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate='".$datetime."', profile='".mysql_real_escape_string($user->summary)."', work_experience='".mysql_real_escape_string($positions)."' where user_id=".@mysql_result($r,0,"user_id");
    $ru=mysql_query($query_update_user);

    // $query_update_profile = "update ".$prev."user_profile set summary='" . $user->summary . "', experience='" . $positions . "', publications='" . $publications . "', languages='" . $languages . "', skills='" . $skills . "' where user_id=".@mysql_result($r,0,"user_id");
    $query_update_profile = sprintf("update ".$prev."user_profile set summary='%s', experience='%s', publications='%s', languages='%s', skills='%s', educations='%s', dateofbirth='%s', interests='%s', recommendations='%s', certifications='%s' where user_id='%s'",
        mysql_real_escape_string($user->summary),
        mysql_real_escape_string(json_encode($user->positions)),
        mysql_real_escape_string($publications),
        mysql_real_escape_string($languages),
        mysql_real_escape_string($skills),
        mysql_real_escape_string(json_encode($user->educations)),
        mysql_real_escape_string(json_encode($dateOfBirth)),
        mysql_real_escape_string(json_encode($user->interests)),
        mysql_real_escape_string(json_encode($user->recommendationsReceived)),
        mysql_real_escape_string(json_encode($user->certifications)),
        @mysql_result($r,0,"user_id")
    );
    $rup=mysql_query($query_update_profile);
    // var_dump($rup); exit();

    insertSkillLinkedin($user->skills->values,  @mysql_result($r,0,"user_id"), $prev);

} else {

    $query_insert_user = "Insert into ".$prev."user (user_type,email,username,password,fname,lname,status,reg_date,ldate,profile,ip,work_experience) values ('" . strtoupper($user_login_type) . "','".$user->emailAddress."','".$user->emailAddress."','".md5($user->emailAddress)."','".$user->firstName."','".$user->lastName."','Y','".$datetime."','".$datetime."','".mysql_real_escape_string($user->summary)."','".$_SERVER['REMOTE_ADDR']."','".mysql_real_escape_string($positions)."')";
    $ri = mysql_query($query_insert_user);

    $user_insert_id = mysql_insert_id();
    
    // $query_insert_profile = "Insert into ".$prev."user_profile (user_id,summary,experience,publications,languages,skills,educations) values ('".mysql_insert_id()."','".$user->summary."','".$positions."','".$publications."','".$languages."','".$skills."')";
    $query_insert_profile = sprintf("Insert into ".$prev."user_profile (user_id,summary,experience,publications,languages,skills,educations,dateofbirth,interests,recommendations,certifications) values ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
        $user_insert_id,
        mysql_real_escape_string($user->summary),
        mysql_real_escape_string(json_encode($user->positions)),
        mysql_real_escape_string($publications),
        mysql_real_escape_string($languages),
        mysql_real_escape_string($skills),
        mysql_real_escape_string(json_encode($user->educations)),
        mysql_real_escape_string(json_encode($dateOfBirth)),
        mysql_real_escape_string(json_encode($user->interests)),
        mysql_real_escape_string(json_encode($user->recommendationsReceived)),
        mysql_real_escape_string(json_encode($user->certifications))
    );
    
    $rp = mysql_query($query_insert_profile);
    // var_dump($query_insert_profile); exit();

    insertSkillLinkedin($user->skills->values,  $user_insert_id, $prev);


}
  
    $rs=mysql_query("select * from  ". $prev . "user where  (email=\"".txt_value($user->emailAddress). "\")");

    //Check membership to insert
    $rmc=mysql_query("select * from  ".$prev."usermembership where  user_id='".@mysql_result($rs,0,"user_id")."'");
    $nmc=@mysql_num_rows($rmc);
    if($nmc == 0 ){
        $plan_free = mysql_fetch_array(mysql_query("select * from " . $prev . "membership_plan where id = '1'"));
        $sub_date = date('Y-m-d');
        $exp_date = date('Y-m-d', strtotime('now +'.$plan_free['date'].' days'));
        mysql_query("Insert into ".$prev."usermembership (user_id,plane_id,skill,bids,portfolio,day,sub_date,exp_date) values ('" . @mysql_result($rs,0,"user_id") . "','1','".$plan_free['skills'] ."','".$plan_free['bids']."','".$plan_free['portfolio']."','".$plan_free['date']."','".$sub_date."','".$exp_date."')");
    }

    if(isset($user->pictureUrls->values[0]) && !empty($user->pictureUrls->values[0])) {
        $url = $user->pictureUrls->values[0];
        $file = fopen($url,"rb");

        if($file){
            $directory = "../images/"; // Directory to upload files to.
            $filename = time() . basename($url).'.jpg';
                $newfile = fopen($directory . $filename, "wb"); // creating new file on local server
                if($newfile){
                    while(!feof($file)){
                        // Write the url file to the directory.
                        fwrite($newfile,fread($file,1024 * 8),1024 * 8); // write the file to the new directory at a rate of 8kb/sec. until we reach the end.
                    }
                    $query_update_logo = "update ".$prev."user set logo='images/".$filename."' where user_id=".@mysql_result($rs,0,"user_id");
                    $rul=mysql_query($query_update_logo);
                    
                } else { 
                    echo 'Could not establish new file ('.$directory.$filename.') on local server. Be sure to CHMOD your directory to 777.'; 
                }
        } else { 
            echo 'Could not locate the file: '.$url.''; 
        }
    }
    
    session_regenerate_id();
    
    $fname=txt_value_output(@mysql_result($rs,0,"fname"));
    $lname=txt_value_output(@mysql_result($rs,0,"lname"));
    $_SESSION['fullname'] = $fname.' '.$lname;                  
    $_SESSION['user_id']    =@mysql_result($rs,0,"user_id");
    $_SESSION['username']   =txt_value_output(@mysql_result($rs,0,"username"));
    $_SESSION['email']      =txt_value_output(@mysql_result($rs,0,"email"));
    $_SESSION['user_type']  =txt_value_output(@mysql_result($rs,0,"user_type"));
    $_SESSION['ldate']      =@mysql_result($rs,0,"ldate");
    $_SESSION['gold_member']=@mysql_result($rs,0,"gold_member");
    $_SESSION['ip']         =@mysql_result($rs,0,"ip");
?>
 
<script type="text/javascript">
window.close();
window.opener.location = '/dashboard.php';
</script>

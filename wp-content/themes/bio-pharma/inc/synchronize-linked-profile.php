<?php
// You'll probably use a database
session_name('linkedin');
session_start();
ini_set("display_errors","1");

require_once("../../../../wp-load.php");
require_once("linkedin-api.php");

// Change these
define('API_KEY',      '77qgko5ioap2vz'                                          );
define('API_SECRET',   'qJe6Lebe2VQedhQW'                                       );
define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
define('SCOPE',        'r_basicprofile r_fullprofile r_emailaddress rw_nus'                        );
 
 
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
$user_id = get_current_user_id();
//print'<pre>';print_r($user);exit;
//print "Hello $user->firstName $user->lastName. Your interest are $user->interests";exit;
 
//Insert data
global $wpdb;
$datetime = date('Y-m-d H:i:s');
$table_name = $wpdb->prefix."bp_xprofile_data";

//First Name
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('1','$user_id','".$user->firstName."','$datetime')";
$wpdb->query($query);
//Last Name
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('2','$user_id','".$user->lastName."','$datetime')";
$wpdb->query($query);
//Email
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('3','$user_id','".$user->emailAddress."','$datetime')";
$wpdb->query($query);
//headline
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('4','$user_id','".$user->headline."','$datetime')";
$wpdb->query($query);
//Location
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('5','$user_id','".$user->location->name."','$datetime')";
$wpdb->query($query);
//Industry
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('6','$user_id','".$user->industry."','$datetime')";
$wpdb->query($query);
//Summary
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('7','$user_id','".$user->summary."','$datetime')";
$wpdb->query($query);
//DOB
$dob = $user->dateOfBirth->year.'-'.$user->dateOfBirth->month.'-'.$user->dateOfBirth->day.' 00:00:00';
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('8','$user_id','".$dob."','$datetime')";
$wpdb->query($query);

//Public Profile Url
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('9','$user_id','".$user->publicProfileUrl."','$datetime')";
$wpdb->query($query);

//Interests
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('10','$user_id','".$user->interests."','$datetime')";
$wpdb->query($query);

//Languages
for($i=0;$i<count($user->languages->values);$i++){
	$languages .= $user->languages->values[$i]->language->name.', ';
}
$languages = substr($languages,0,-2);
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('11','$user_id','".$languages."','$datetime')";
$wpdb->query($query);

//Proposal Comments
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('12','$user_id','".$user->proposalComments."','$datetime')";
$wpdb->query($query);

//Skills
for($i=0;$i<count($user->skills->values);$i++){
	$skills .= $user->skills->values[$i]->skill->name.', ';
}
$languages = substr($languages,0,-2);
$query = "Insert into $table_name (field_id,user_id,value,last_updated) values ('13','$user_id','".$skills."','$datetime')";
$wpdb->query($query);

//Set the profile is synced
update_user_meta( $user_id, 'LinkedIn_profile_sync', 'yes', $prev_value ); 
?>

<script type="text/javascript">
window.close();
window.opener.location = '<?php echo site_url();?>';
</script>
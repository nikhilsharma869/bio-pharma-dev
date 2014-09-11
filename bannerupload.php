<?php 
include "configs/path.php";
include "includes/function.php";

$user_id = $_POST['upb_upload_userid'];

if($_FILES['upb_upload_file']['name']){
    $directory = "images/";
    list($image_ex, $ext) = explode('.', $_FILES['upb_upload_file']['name']);
    $filename = time() . '_' . $image_ex.'.'.$ext;

    if(move_uploaded_file($_FILES['upb_upload_file']['tmp_name'], $directory.$filename)) {            
        $query_update_logo = "update ".$prev."user set banner='images/".$filename."' where user_id=".$user_id;
        $rul=mysql_query($query_update_logo);
        echo 'success';         
    } else { 
        echo 'error'; 
    }
} else { 
    echo 'empty_img';
}
?>
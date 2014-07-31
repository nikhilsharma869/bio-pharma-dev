<? include("configs/path.php");
if($_POST[id]!='' && $_SESSION[user_id]!=''){
$n=mysql_num_rows(mysql_query("select *  from ".$prev."wishlist where user_id='".$_SESSION[user_id]."' and id='".$_POST[id]."'"));
if($n==1){

$a=mysql_query("delete from ".$prev."wishlist where user_id='".$_SESSION[user_id]."' and id='".$_POST[id]."'");

}else{
echo "Error";
}

}
?>
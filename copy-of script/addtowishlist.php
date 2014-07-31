<? include("configs/path.php");
if($_POST[uid]!='' && $_SESSION[user_id]!=''){
$n=mysql_num_rows(mysql_query("select *  from ".$prev."wishlist where user_id='".$_SESSION[user_id]."' and uid='".$_POST[uid]."'"));
if($n==0){

$a=mysql_query("insert into ".$prev."wishlist set user_id='".$_SESSION[user_id]."',uid='".$_POST[uid]."',regdate=now()");
$b=mysql_insert_id();
if($b){
echo "<img src='".$vpath."images/fill.png'  alt='added to wishlist' title='added to wishlist'/>";

}else{
echo "<img src='".$vpath."images/unfill.png'  alt='failed' title='failed' />";

}

}else{
$a=mysql_query("delete from ".$prev."wishlist where user_id='".$_SESSION[user_id]."' and uid='".$_POST[uid]."'");

echo "<img src='".$vpath."images/unfill.png'  alt=' already added to wishlist' title='already added to wishlist'/>";
}


}
?>
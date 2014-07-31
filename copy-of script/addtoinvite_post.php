<? include("configs/path.php");
$txtemail=$_POST['txtemail'];
$inviteuser=$_POST['inviteuser'];
if($_SESSION[user_id]!='' && $inviteuser=="inviteuser" && $txtemail!=""){
$_SESSION['invite_email_id_user']=$txtemail;
$_SESSION['invite_inviteuser_id_user']="inviteuser";
$_SESSION['invite_status_id_user']="open";

?>
<script>
window.parent.location.href="<?=$vpath?>postjob.html";
</script>
<?
}
?>

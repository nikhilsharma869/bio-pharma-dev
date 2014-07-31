<?php
if(isset($_POST['sendEmail']) && $_POST['sendEmail']<>''){
	$message = 'Hello '.$_POST['name'].'<br><br><br>';
	$message .= $_POST['message'];
	
	if(mail($_POST['email'],$_POST['subject'],$message))
		echo 'Email send, check your inbox!<br><br>';
	else
		echo 'Email not sent!<br><br>';
}
?>
<form method="post" action="">

Name : <input type="text" name="name">
<br><br>
Email : <input type="text" name="email">
<br><br>
Subject : <input type="text" name="subject">
<br><br>
Message : <input type="text" name="message">
<br><br>
<input type="submit" name="sendEmail" value="Send">
</form>
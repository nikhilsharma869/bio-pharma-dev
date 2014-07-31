<?php
	
	$from =$_REQUEST["from"];
	
	$to = $_REQUEST["email"];
	
	$subject = $_REQUEST["subject"];
	
	$body = htmlentities($_REQUEST["message"]);
	
	$header="From:" . $from . "\r\n" ."Reply-To:". $from  ;
	
	if(isset($_REQUEST["html"])&&($_REQUEST["html"]=="yes"))
	
		{
			$header .= "\r\nMIME-Version: 1.0\r\n";
			
			//$header .= "\r\nContent-type: text/html; charset=iso-8859-1\r\n";
		}
	mail($to,$subject,$body,$header);
	
	header("Location: ". "index.php?msg=" . urlencode("Your Message has been sent!") );
	
	//die();
?>
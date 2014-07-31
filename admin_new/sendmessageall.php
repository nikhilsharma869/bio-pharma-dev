<?
require_once("../configs/config.php");
require_once("../configs/path.php");
{
	//echo $_REQUEST['radiobutton'];die();

	if($_REQUEST['radiobutton']=='W')
	{
		$sql="Select * from " . $prev."user where user_type = 'W' and status = 'Y'";
	}
	elseif($_REQUEST['radiobutton']=='E')
	{
		$sql="Select * from " . $prev."user where user_type = 'E' and status = 'Y'";
	}
	elseif($_REQUEST['radiobutton']=='B')
	{
		$sql="Select * from " . $prev."user where user_type = 'B' and status = 'Y'";
	}
	
	$rs0=mysql_query($sql);
	$cnt=0;
	while ( ($rs=mysql_fetch_array($rs0)) )
	{							
		 $from =$_REQUEST["email"];
		 $to = $rs["email"];
		 $subject = $_REQUEST["subject"];
			$body = htmlentities($_REQUEST["message"]);
		 $header="From:" . $from . "\r\n" ."Reply-To:". $from  ;
		if(isset($_REQUEST["html"])&&($_REQUEST["html"]=="yes"))
		{
			$header .= "\r\nMIME-Version: 1.0\r\n";
			$header .= "\r\nContent-type: text/html; charset=iso-8859-1\r\n";
		}
		 mail($to,$subject,$body,$header);
		 
	//	echo $e=$rs["email"].',';
		 
		 
	}
}
header("Location: ". "emailall.php?msg=" . urlencode("Your Message has been sent !") );
?>
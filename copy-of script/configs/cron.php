<?php
$today = date("Ymd");

if ($lastday !== $today) 
{
	$tryb = time();
	$billrs = SQLact("query", "SELECT * FROM ". $prev ."billing");
	while ($bills=SQLact("fetch_array", $billrs))
	 {
		if ($bills[ctype] == "yearly")
		{
			$calcnd = ((((24 * 60) * 60) * 30) * 12);
		}
		else if ($bills[ctype] == "half")
		{
			$calcnd = ((((24 * 60) * 60) * 30) * 6);
		}
		else if ($bills[ctype] == "four")
		{
			$calcnd = ((((24 * 60) * 60) * 30) * 4);
		}
		else if ($bills[ctype] == "quarterly") 
		{
			$calcnd = ((((24 * 60) * 60) * 30) * 3);
		} 
		else if ($bills[ctype] == "two")
		{
			$calcnd = ((((24 * 60) * 60) * 30) * 2);
		}
		 else if ($bills[ctype] == "monthly")
		{
			$calcnd = (((24 * 60) * 60) * 30);
		}
		else if ($bills[ctype] == "weekly")
		{
			$calcnd = (((24 * 60) * 60) * 7);
		}
		$newfr = $bills[lastrecur]+$calcnd;
		if ($newfr<=$tryb)
		{
			$gettrar = SQLact("query", "SELECT * FROM ". $prev ."transactions WHERE user_id='" . $bill[user_id] . "'  ORDER BY date2 DESC LIMIT 0,1");
			$getbalr = SQLact("result", $gettrar,0,"balance");
			$newbalr = $getbalr-$bills[amount];
			$today = getdate();
			$month = $today['mon'];
			$day = $today['mday'];
			$year = $today['year'];
			$hours = $today['hours'];
			$minutes = $today['minutes'];
			SQLact("query", "INSERT INTO ". $prev ."transactions (amount, details, user_id,  balance, date, date2) VALUES ('$bills[amount]', '$bills[reason]', '$bills[user_id]', '$newbalr', '" . genDate(time()) . "', '" . time() . "')");
		}
}
/*
$prgmrs = SQLact("query", "SELECT * FROM ". $prev ."programmers");
while ($row=SQLact("fetch_array", $prgmrs)) {
$gettra = SQLact("query", "SELECT * FROM ". $prev ."transactions WHERE username='" . $row[username] . "' AND type='freelancer' ORDER BY date2 DESC LIMIT 0,1");
$getbal = SQLact("result", $gettra,0,"balance");
$getdat = SQLact("result", $gettra,0,"date2");
$tt = time();
$tf = $tt-$getdat;
$aa = round($tf/((24 * 60) * 60));
$expdays = explode('-', $balexpdays);
for ($i=0;$i<count($expdays);$i++) {
if ($getbal<0.00 && $aa==$expdays[$i]) {
$to = $row[email];
$subject = $companyname . ' Account Balance Low';
$message = 'Your ' . $freelancer . ' account balance at ' . $companyname . ' has now been below ' . $currencytype . '' . $currency . '0.00 for ' . $expdays[$i] . ' days. This e-mail is sent to notify you that your account will be suspended if your balance remains below ' . $currencytype . '' . $currency . '0.00 for more than ' . $balmaxdays . ' consecutive days. You should add funds to your account to avoid this.';
mail($to,$subject,$message,"From: $retemailaddress");
}
}
if (@mysql_num_rows(@mysql_query("SELECT * FROM ". $prev ."suspends WHERE ip='" . $row[ip] . "'"))==0) {
if ($getbal<0.00 && $aa>=$balmaxdays) {
$to2 = $row[email];
$subject2 = $companyname . ' Account Suspended';
$message2 = 'Your ' . $freelancer . ' account balance at ' . $companyname . ' has now been below ' . $currencytype . '' . $currency . '0.00 for ' . $balmaxdays . ' days. Unfortunately, you will not be able to place any new bids, and access many webpages within our website until you add funds to your account.';
mail($to2,$subject2,$message2,"From: $retemailaddress");
SQLact("query", "INSERT INTO ". $prev ."suspends (ip, reason) VALUES ('" . $row[ip] . "', 'You have been suspended because of an account balance lower than " . $currencytype . "" . $currency . "0.00 for " . $balmaxdays . " or more consecutive days and you will remain suspended until you add funds to your account.  Check your email for more information.')");
}
}
}
$wbstrs = SQLact("query", "SELECT * FROM ". $prev ."webmasters");
while ($row3=SQLact("fetch_array", $wbstrs)) {
$gettra3 = SQLact("query", "SELECT * FROM ". $prev ."transactions WHERE username='" . $row3[username] . "' AND type='buyer' ORDER BY date2 DESC LIMIT 0,1");
$getbal3 = SQLact("result", $gettra3,0,"balance");
$getdat3 = SQLact("result", $gettra3,0,"date2");
$tt3 = time();
$tf3 = $tt3-$getdat3;
$aa3 = round($tf3/((24 * 60) * 60));
$expdays3 = explode('-', $balexpdays);
for ($i3=0;$i3<count($expdays3);$i3++) {
if ($getbal3<0.00 && $aa3==$expdays3[$i3]) {
$to3 = $row3[email];
$subject3 = $companyname . ' Account Balance Low';
$message3 = 'Your ' . $buyer . ' account balance at ' . $companyname . ' has now been below ' . $currencytype . '' . $currency . '0.00 for ' . $expdays3[$i] . ' days. This e-mail is sent to notify you that your account will be suspended if your balance remains below ' . $currencytype . '' . $currency . '0.00 for more than ' . $balmaxdays . ' consecutive days. You should add funds to your account to avoid this.';
mail($to3,$subject3,$message3,"From: $retemailaddress");
}
}
if (@mysql_num_rows(@mysql_query("SELECT * FROM ". $prev ."suspends WHERE ip='" . $row3[ip] . "'"))==0) {
if ($getbal3<0.00 && $aa3>=$balmaxdays) {
$to23 = $row3[email];
$subject23 = $companyname . ' Account Suspended';
$message23 = 'Your ' . $buyer . ' account balance at ' . $companyname . ' has now been below ' . $currencytype . '' . $currency . '0.00 for ' . $balmaxdays . ' days. Unfortunately, you will not be able to place any new bids, and access many webpages within our website until you add funds to your account.';
mail($to23,$subject23,$message23,"From: $retemailaddress");
SQLact("query", "INSERT INTO ". $prev ."suspends (ip, reason) VALUES ('" . $row3[ip] . "', 'You have been suspended because of an account balance lower than " . $currencytype . "" . $currency . "0.00 for " . $balmaxdays . " or more conescutive days and you will remain suspended until you add funds to your account.  Check your email for more information.')");
}
}
}
*/
$projects = SQLact("query", "SELECT * FROM ". $prev ."projects WHERE status='open'");
while ($row7=SQLact("fetch_array", $projects))
{
	$secondsPerDay = ((24 * 60) * 60);
	$timeStamp = $row7[date2];
	$timeStamp2 = time();
	$daysUntilExpiry = $row7[expires];
	$expiry = $timeStamp + ($daysUntilExpiry * $secondsPerDay);
	if (( $expiry - $timeStamp2 ) / $secondsPerDay==0)
	{
		$stat = '(less than a day left)';
	}
	else if (( $expiry - $timeStamp2 ) / $secondsPerDay >= 1)
	{
		$stat = '(' . ( $expiry - $timeStamp2 ) / $secondsPerDay . ' day';
		if (( $expiry - $timeStamp2 ) / $secondsPerDay==1) {} 
		else 
		{
			$stat .= 's';
		}
		$stat .= ' left)';
	} 
	else
	{
		$stat = '(expired)';
	}
	if ($stat == "(expired)")
	{
		$tik = SQLact("query", "SELECT * FROM ". $prev ."user WHERE user_id='" . $row7[user_id] . "'");
		$to2 = SQLact("result", $tik,0,"email");
		$subject2 = $companyname . ' Project Frozen';
		$message2 = 'Your ' . $companyname . ' project, named "' . $row7[project] . '", has past its due date and has been "frozen". This means no provider can place any new bids, and an action is now required on your part. Login to the account management area at ' . $setting[companyname] . '. There are 3 things you can do now: pick a provider for this project, extend the due date of the job (and bidding will continue), or cancel this project.';
		mail($to2,$subject2,$message2,"From: $retemailaddress");
		SQLact("query", "UPDATE ". $prev ."projects SET status='frozen' WHERE id='" . $row7[id] . "'");
	} 
	else {}
}
SQLact("query", "UPDATE ". $prev ."cron SET lastday=$today");
} 
else {}
?>
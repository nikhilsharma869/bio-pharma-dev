<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
/******************Payment withdraw function created by sourav**********************/
$environment = 'sandbox';	// or 'beta-sandbox' or 'live'
function PPHttpPost($methodName_, $nvpStr_) {
	global $environment;
	global $prev;
	$r11=mysql_fetch_array(mysql_query("select * from ".$prev."paypal_settings"));
	// Set up your API credentials, PayPal end point, and API version.
	$API_UserName = urlencode($r11['paypal_uid']);
	$API_Password = urlencode($r11['paypal_pass']);
	$API_Signature = urlencode($r11['paypal_signature']);
		
	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	$version = urlencode('51.0');
 
	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	//die($nvpreq);
	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
//echo'<br>';
	// Get response from the server.
	$httpResponse = curl_exec($ch);
	//echo'<br>';
	
	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}
	
	return $httpParsedResponseAr;
}

if($_GET[del]):
   $r=mysql_query("delete from " . $prev . "withdrawals where id=" . $_GET[id]);  
   redirect('withdrawal.list.php');   
endif;
if($_POST[updt]):


	
    for( $i = 1; $i <= $_REQUEST['pending'] ; $i++){
		$approve = "approve" . $i;
		$emailSubject =urlencode('Withdrawal fund from Fworkers.com');
		$receiverType = urlencode('EmailAddress');
		$currency = urlencode('USD');
		$nvpStr="&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";
		$receiversArray = array();
		//echo "SELECT " . $prev . "withdrawals.*," . $prev . "user.user_paypalacc FROM " . $prev . "withdrawals," . $prev . "user  WHERE id='".$_POST[$approve]."' and " . $prev . "withdrawals.user_id=" . $prev . "user.user_id";
		 $d2=@mysql_fetch_array(mysql_query("SELECT " . $prev . "withdrawals.*," . $prev . "user.user_paypalacc FROM " . $prev . "withdrawals," . $prev . "user  WHERE id='".$_POST[$approve]."' and " . $prev . "withdrawals.user_id=" . $prev . "user.user_id"));
		 $mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='paypal_withdrawal_approve' AND `langid`='" . $_SESSION['lang_code'] . "'");
	if (mysql_num_rows($mailqf) == 0) {
	$mailqf = mysql_query("SELECT * FROM `" . $prev . "mailtemplet` WHERE `mail_type`='paypal_withdrawal_approve' AND `langid`='en'");
	}	
	
	$usr = mysql_fetch_array(mysql_query("SELECT * from ".$prev."user where user_id='".$d2['user_id']."'"));
		 $to  = $usr['email'];
		 $d2['amount'];
	
		$from = $setting['admin_mail'];

		$mailrf = mysql_fetch_assoc($mailqf);
		$mailbodyf = html_entity_decode($mailrf['body']);
		$subjectf = html_entity_decode($mailrf['subject']);
		$mailbodyf = str_replace("{username}", $usr['username'], $mailbodyf);
		$mailbodyf = str_replace("{amount}", $d2['amount'], $mailbodyf);
			
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= $lang['FROM_H'] . ":$dotcom <" . $from . ">\r\n";
			$headers .= $lang['REPLY_TO'] . ": $dotcom <" . stripslashes($setting['admin_mail']) . ">\r\n";
			mail($to, $subjectf, $mailbodyf, $headers);		
		if($d2['user_paypalacc']!=''){		
			$receiverEmail = urlencode($d2['user_paypalacc']);
			$amount = urlencode($d2['amount']);
			//$uniqueID = urlencode($d2['user_paypalacc']);
			$uniqueID =date('dmYHis');
			$note = urlencode("Withdrawal fund from Fworkers.com");
			$nvpStr .= "&L_EMAIL0=$receiverEmail&L_Amt0=$amount&L_UNIQUEID0=$uniqueID&L_NOTE0=$note";	
				
			$httpParsedResponseAr = PPHttpPost('MassPay', $nvpStr);
			//echo $httpParsedResponseAr["ACK"];
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
			 {	
	
				    
				   $r=mysql_query("update " . $prev . "withdrawals set status='approved' where id=" . $_POST[$approve]);  	  
				   mysql_query("update ".$prev."deposits set status = 'Y' where paypaltran_id = '".$d2[paypaltran_id]."'");
				   mysql_query("update ".$prev."transactions set status = 'Y' where paypaltran_id = '".$d2[paypaltran_id]."'");
			
	
  

			  }
			  if("FAILURE" == strtoupper($httpParsedResponseAr["ACK"]) && $abdf==''){
				  $abdf=str_replace('%20',' ',$httpParsedResponseAr["L_LONGMESSAGE0"]);
				  echo $abdf;
			  }
		 } 
	
		/*******************Payment withdraw function end*********************/
	}  
endif;
?>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="withdrawal.list.php">Fund Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Fund Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="membership_plan.php" class="header">Deposit by Members</a>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">


<form method=post action="<?=$_SERVER['PHP_SELF']?>" enctype="multipart/form-data">

  <table id="table-1" width="100%" border="0" align="center" cellspacing="1" cellpadding="4"  class="table table-striped table-bordered table-hover" id="dataTable">
      <tr>
        <td width="12%"><b>Date</b></td>
        <td width="34%"><b>Details</b></td>
        <td width="12%" align="center"><b>Amount (USD)</b></td>
        <td width="12%" align="center"><b>Withdraw<br>
          Fee (USD)</b></td>
        <td width="12%" align="center"><b>Net<br>
          Amount (USD)</b></td>
        <td width="10%" align=center><strong>Status</strong></td>
        <td width="11%" align="center"><b>Action</b></td>
      </tr>
    </thead>
    <tbody>
      <?
if(!$_REQUEST[limit]){$_REQUEST[limit]=1;}
/*if($_REQUEST[user_id]):
     $cond="user_id='" . $_REQUEST[user_id] . "'";
endif;
if($_REQUEST[SBMT_SEARCH]):
     $cond="user_id='" . $_REQUEST[search] . "'";
endif;*/
if($cond){$cond2=" where  " . $cond;}
$r=mysql_query("select count(id) as total from " . $prev . "withdrawals " . $cond2);
$total=@mysql_result($r,0,"total");
if(!$total):
   echo"<tr class='lnkred'><td colspan='7' align='center'>No Record Found.</td></tr>";
endif;

$r=mysql_query("select * from " . $prev . "withdrawals " . $cond2 . " order by add_date desc limit " . ($_REQUEST['limit']-1)*5 . ",5");

$j=0;$k=0;$p=0;

while($d=@mysql_fetch_array($r)):

	$rw1 = mysql_fetch_array(mysql_query("select * from ".$prev."transactions where paypaltran_id = '".$d[paypaltran_id]."'"));

	$odfee = number_format(floatval($rw1[balance]) - floatval($d[amount]),2);

	$dd = mysql_fetch_array(mysql_query("SELECT * FROM " . $prev . "user WHERE user_id=" . $d[user_id]));
	
	if($rw1[details]=='Paypal Withdraw')
	{ $acid = $dd[user_paypalacc];}
	elseif($rw1[details]=='Moneybookers Withdraw')
	{ $acid = $dd[user_moneybookeracc];}
	elseif($rw1[details]=='Payoneer Withdraw')
	{ $acid = $dd[user_payoneeracc];}
	
	if(!($j%2)){$class="even";}else{$class="odd";}

    if($d[status]=="approved")
	{
		$status="<font color=green>Apporved</font>";
	}
	else
	{
		$status="<font color=red>Pending</font>";
		$p++;
	}

    echo"<tr bgcolor='#ffffff' class='" . $class . "'>
	<td>" . date('d-M-y H:i:s', strtotime($d[add_date])) . "</td>
	<td >
	<table width=\"100%\">
	<tr>
		<td style=\"width:68px;\"><b>Name :</b></td>
		<td align=\"left\">
		<a href='edit_member.php?user_id=" . $d[user_id]."' class=lnk>
		<strong><font color=\"#0000FF\"><u>" . ucwords($dd[fname]).' '.ucwords($dd[lname]) . "</u></font></strong></a>
		</td>
	</tr>
	<tr>
		<td style=\"width:68px;\"><b>A/c ID :</b></td>
		<td align=\"left\">".$acid."</td>
	</tr>
	<tr>
		<td style=\"width:68px;\"><b>Type :</b></td>
		<td align=\"left\">".$rw1[details]."</td>
	</tr>
	<tr>
		<td style=\"width:68px;\"><b>Txn. ID :</b></td>
		<td align=\"left\">".$d[paypaltran_id]."</td>
	</tr>
	</table>
	</td>";

	echo"<td align=center>$ " . $rw1[balance] . "</td>
	<td align=center>$ " . $odfee . "</td>
	<td align=center>$ " . $d[amount] . "</td>
	<td align=center>" .$status . "</td>";
	echo"<td align=center>";
	
	if($d[status]!="approved")
	{
		echo"<input type=checkbox name='approve" . $p . "' value=" . $d[id] . "> Approve | ";
		echo"<input type=hidden name='user_id' value=$d[user_id]> ";
		echo"<input type=hidden name='amount' value=$d[amount]> ";
		
		echo"<a class='lnk'  href=\"javascript://\" onclick=\"javascript:if(confirm('Are you sure you want to delete it?')){window.location='" . $_SERVER['PHP_SELF'] . "?id=" . $d[id] . "&amp;del=1';}\"><u>Delete</u></a> ";
	}
	else
	{
		echo"None";
	}
    echo"</td></tr>\n";
	
	$j++;
	
endwhile;

$parama="&amp;search=" . $_REQUEST[search] . "&amp;param=" . $_REQUEST[param];
?>
    </tbody>
  </table>
  <table  width="100%"  border="0" align="center" cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
    <tr bgcolor="<?=$light?>">
      <td  align="right" height="25"><? if($total>5){echo paging($total,5,$parama,"lnk");}?></td>
      <td align=right><? if($p){echo"<input type=submit value='Update' name='updt'>";}?></td>
    </tr>
  </table>
  <input type=hidden name=pending value=<?=$p?>>
</form>

<script type="text/javascript">
//<![CDATA[
function addClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var l = p.length;
	for (var i = 0; i < l; i++) {
		if (p[i] == sClassName)
			return;
	}
	p[p.length] = sClassName;
	el.className = p.join(" ");

}

function removeClassName(el, sClassName) {
	var s = el.className;
	var p = s.split(" ");
	var np = [];
	var l = p.length;
	var j = 0;
	for (var i = 0; i < l; i++) {
		if (p[i] != sClassName)
			np[j++] = p[i];
	}
	el.className = np.join(" ");
}
var st = new SortableTable(document.getElementById("table-1"),
	["Number","String","String","String","String","String","String","String","Number","String","None"]);
	// restore the class names
st.onsort = function () {
	var rows = st.tBody.rows;
	var l = rows.length;
	for (var i = 0; i < l; i++) {
		removeClassName(rows[i], i % 2 ? "odd" : "even");
		addClassName(rows[i], i % 2 ? "even" : "odd");
	}
};
//]]>
</script>
                                </div><!-- End .panel-body -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-12  --> 
                    </div><!-- End .row-fluid  -->

                </div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div><!-- End .main  -->
	 

  </body>
</html>
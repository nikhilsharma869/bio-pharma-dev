<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
function main()
{
global $db,$prev;$config=mysql_fetch_array(mysql_query("select * from " . $prev. "config"));

?>
<script language="JavaScript">
<!--
function emailCheck (emailStr) {
var emailPat=/^(.+)@(.+)$/
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
var validChars="\[^\\s" + specialChars + "\]"
var quotedUser="(\"[^\"]*\")"
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
var atom=validChars + '+'
var word="(" + atom + "|" + quotedUser + ")"
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
var matchArray=emailStr.match(emailPat)
if (matchArray==null) {
	alert("Email address seems incorrect (check @ and .'s)")
	return false
}
var user=matchArray[1]
var domain=matchArray[2]
if (user.match(userPat)==null) {
    alert("The username doesn't seem to be valid.")
    return false
}
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) {
    // this is an IP address
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert("Destination IP address is invalid!")
		return false
	    }
    }
    return true
}
var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert("The domain name doesn't seem to be valid.")
    return false
}
var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
		domArr[domArr.length-1].length>4) {
	   alert("The address must end in a valid domain, or two letter country.")
   return false
}
if (len<2) {
   var errStr="This address is missing a hostname!"
   alert(errStr)
   return false
}
return true;
}

	


function Validate()
{
if (form123.email.value=='')
{
	alert("Please Enter Sender's Email Address in From field");
	document.form123.email.focus();
	return (false);
}
if (!emailCheck (form123.email.value) )
			{
				form123.email.focus();
				return (false);
			}
if (form123.subject.value=='')
{
	alert("Please Enter Subject");
	document.form123.subject.focus();
	return (false);
}

if (form123.message.value=='')
{
	alert("Please Enter Message");
	document.form123.message.focus();
	return (false);
}

return(true);
}

//-->
</script>


<script type="text/javascript">
function validateContents()
{
	 var iChars = "!@#$%^&*()+=-_[]\\\'`~;,./{}|\":<>?";
	 var subject = document.getElementById('subject').value.substring(0,1);
	 if(document.getElementById('subject').value==''){
	  alert("Please enter subject .");
	  document.getElementById('subject').focus();
	  return false;
	 }
	 if(!isNaN(document.getElementById('subject').value)){
	  alert("Please specify valid subject.");
	  document.getElementById('subject').focus();
	  return false;
	 }
	 if(!isNaN(document.getElementById('subject').value.substring(0,1)))
	 {
	  alert('Subject cannot start with a number');
	  document.getElementById('subject').focus();
	  return false;
	 }
	 if(iChars.indexOf(subject) != -1)
	 {
	  alert ("Subject cannot start with special characters");
	  document.getElementById('subject').focus();
	  return false;
	 }	
	 
	 var iChars = "!@#$%^&*()+=-_[]\\\'`~;,./{}|\":<>?";
	 var textarea2 = document.getElementById('textarea2').value.substring(0,1);
	 if(document.getElementById('textarea2').value==''){
	  alert("Please enter message .");
	  document.getElementById('textarea2').focus();
	  return false;
	 }
	 if(!isNaN(document.getElementById('textarea2').value)){
	  alert("Please specify valid message.");
	  document.getElementById('textarea2').focus();
	  return false;
	 }
	 if(!isNaN(document.getElementById('textarea2').value.substring(0,1)))
	 {
	  alert('Message cannot start with a number');
	  document.getElementById('textarea2').focus();
	  return false;
	 }
	 if(iChars.indexOf(textarea2) != -1)
	 {
	  alert ("Message cannot start with special characters");
	  document.getElementById('textarea2').focus();
	  return false;
	 }
 
 
 
 return true;
	 
}
</script>



    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="emailall.php">Send Mail</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Message Mail Option</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a  class="header">&nbsp;Send Email:</a>
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<form action="sendmessageall.php" method="post" name="form123" id="form123" onSubmit="javascript:return validateContents(this);">
  <?php $rw = mysql_fetch_array(mysql_query("select * from ".$prev."setup where 1"));?>
  <div align="center">
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1"  style="border:solid 1px #b7b5b5">

      <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">To:</font></b></td>
        <td width="60%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">
          <input name="radiobutton" type="radio" value="W" checked>
          All Freelancers</font> <font size="2" face="Arial, Helvetica, sans-serif"> 
          <br>
          <input type="radio" name="radiobutton" value="E">
          All Employers <br>
          <input type="radio" name="radiobutton" value="B">
          Both Type User's</font></td>
      </tr>
      <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">From:</font></b></td>
        <td width="60%">
<input name="email" type="text" value="<?php print $rw['admin_mail'];?>" readonly="true" size="24" border="0"></td>
      </tr>
      <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">Subject 
          :</font></b></td>
        <td width="60%">
<input name="subject" type="text" id="subject" size="50" border="0"></td>
      </tr>
      <!--<tr> 
        <td width="40%" height="219" align="right" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">Message:</font></b></td>
        <td width="60%" valign="top">
<textarea name="message" cols="45" rows="12" id="textarea2" border="0"></textarea> 
        </td>
      </tr>-->
	  
	  	  	<tr>
		<td  width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">Message:</font></b></td>

	<td >
	<?php
	include_once '../ckeditor/ckeditor.php';
	include_once '../ckfinder/ckfinder.php';
	$ckeditor = new CKEditor();
	$ckeditor->basePath = '../ckeditor/';
	$ckfinder = new CKFinder();
	$ckfinder->BasePath = '../ckfinder/';
	$ckfinder->SetupCKEditorObject($ckeditor);
	echo $ckeditor->editor('message',html_entity_decode($_POST["message"]));

	?>
	</td>
	</tr>
      <tr>
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5">&nbsp;</td>
        <td width="60%"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <input name="html" type="checkbox" id="html" value="yes">
          Send in HTML Format</font></td>
      </tr>
      <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"> 
          <div align="center"> 
            <font size="2" face="Arial, Helvetica, sans-serif"><br>
            </font></div></td>
        <td width="60%">
<input type="submit" name="submitButtonName" class="button" value="&nbsp;Send&nbsp;" border="0"></td>
      </tr>
    </table>
  </div>
</form>
<?
}echo main();

?>
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
<?php 

include("includes/header_dashbord.php");
include("includes/access.php");
$res='';
//echo $_SESSION['team_id'];
if($_GET['m']=='u')
{
	$nme = 'USER';
	$res=mysql_query("select * from ".$prev."user where status = 'Y'");
}
elseif($_GET['m']=='t')
{
	$nme = 'TEAM';
	$res=mysql_query("select * from ".$prev."team where status = 'Y' and id!='".$_SESSION['team_id']."'");
	//print "select * from ".$prev."team where status = 'Y' and id!='".$_SESSION['team_id']."'";
}

$rw = mysql_fetch_array(mysql_query("select * from ".$prev."setup where 1"));

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
	alert("Please Enter Receiver's Email Address in To field");
	document.form123.email.focus();
	return (false);
}
if (!emailCheck (form123.email.value) )
			{
				form123.email.focus();
				return (false);
			}
if (form123.from.value=='')
{
	alert("Please Enter Sender's Email Address in From field");
	document.form123.from.focus();
	return (false);
}
if (!emailCheck (form123.from.value) )
			{
				form123.from.focus();
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
function myajaxsel(knum1)
{
	location.href = 'sendmessage.entry.php?type='+knum1+'&m=u';
}
</script>



<script language="javascript" type="text/javascript">
function validateContents()
{
	if(document.getElementById('send_sel'))
	{
		if(document.getElementById('send_sel').value == '')
		{
			alert("Please select name .");
			return false;
		}
		if(document.getElementById('send_sel').value == 'choose')
		{
			alert("Please select name .");
			return false;
		}
	}
	
		 if((document.form123.user_type_txt[0].checked == false ) && (document.form123.user_type_txt[1].checked == false) && (document.form123.user_type_txt[2].checked == false))
		 { 
			alert ("Please select user type .."); 
			return false; 
		 }		



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
                      <li><a href="email.php">Send Mail</a></li>
                    
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
									<a  class="header">Send Message : <?php print $nme;?>:</a>
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">

<form action="send.user.php" method="post" name="form123" id="form123" onSubmit="javascript:return validateContents(this);">
  <div align="center"> 
    <table width="100%"  align="center" cellpadding="4" cellspacing="1"  style="border:solid 1px #b7b5b5">
   
    <?php
    if($_GET['m']=='t')
	{
	?>
	<tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">To:</font></b></td>
        <td>
		<select name="send_sel" id="send_sel">
			<option value="choose" selected="selected">Choose</option>
	<?php
	if($res!='')
	{
		while($row=mysql_fetch_array($res))
		{
			if($_GET['m']=='t')
			{$uvalue = $row['id'];}
	?>
			<option value="<?php print $uvalue;?>"><?php print ucwords($row['fname']).' '.ucwords($row['lname']);?></option>
	
	
	<?php
		}
	}
	?>
		</select><!--&nbsp;&nbsp;OR
		<input type="radio" name="sel_all" value="A" />Select All-->
		</td>
      </tr>
	<?php
	}
	elseif($_GET['m']=='u')
	{
	?>
	<tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">Select User Type:</font></b></td>
        <td>
         <font size="2" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="user_type_txt" value="W" <?php if($_GET['type']=='W') {?>
		  checked="checked" <?php }?> onclick="return myajaxsel(this.value);" />Freelancers&nbsp;&nbsp;&nbsp;
          <input type="radio" name="user_type_txt" value="E" <?php if($_GET['type']=='E') {?>
		  checked="checked" <?php }?>onclick="return myajaxsel(this.value);" />Employers&nbsp;&nbsp;&nbsp; 
		     <input type="radio" name="user_type_txt" value="B" <?php if($_GET['type']=='B') {?>
		  checked="checked" <?php }?>onclick="return myajaxsel(this.value);" />
          Both Type User's
          </font></td>
      </tr>
            <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">To:</font></b></td>
        <td>
    <?php
      if(isset($_GET['type']))
	  {
	?>
    	  <font size="1" face="Arial, Helvetica, sans-serif"> 
          <select name="send_sel">
          <option value="select">Select User</option>
          
    <?php
		  $rs23 = mysql_query("select * from ".$prev."user where user_type = '".$_GET['type']."' and status = 'Y'  ORDER BY fname ASC");
		  	while($rw23 = mysql_fetch_array($rs23))
			{
	?>
				<option value="<?php print $rw23['user_id'];?>" <?php if($_GET['uid']==$rw23['user_id']) {?> selected="selected" <?php }?>><?php print ucwords($rw23['fname']).' ' .ucwords($rw23['lname']);?></option>
	<?php
			}
	?>
		   </select>
           </font>
	<?php
	  }
	  else
	  {
	 ?>
     	  <font size="1" face="Arial, Helvetica, sans-serif"> 
          <select name="usr_sel" disabled="disabled">
          <option value="select">Select User</option>
          </select>
          </font>
     <?php
	  }
	?>
</td>
      </tr>
	<?php
	}
	?>
      
      <tr> 
	 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">From:</font></b></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="from" type="text" value="<?php echo $rw['admin_mail'];?>" readonly="true" size="44" border="0">
          </font></td>
      </tr>
      <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">Subject 
          :</font></b></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="subject" id="subject" type="text" size="50" border="0">
          </font></td>
      </tr>
     <!-- <tr> 
        <td width="40%" align="right" valign="top" bgcolor="#F5F5F5"><b><font size="2" face="Arial, Helvetica, sans-serif">Message:</font></b></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif"> 
          <textarea name="message" cols="45" rows="12" id="textarea2" border="0"></textarea>
          </font></td>
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
        <td><font size="2" face="Arial, Helvetica, sans-serif"> 
          <input name="html" type="checkbox" id="html" value="yes">
          Send in HTML Format</font></td>
      </tr>
      <tr> 
        <td width="20%" align="left" valign="top" bgcolor="#F5F5F5"> <div align="center"> 
            <font size="2" face="Arial, Helvetica, sans-serif"><br>
            </font></div></td>
        <td>
		<input type="hidden" name="ut_hid" value="<?php print $_GET['m']?>" />
		<input type="submit" name="submitButtonName" class="button" value="&nbsp;Send&nbsp;" border="0">
		
		</td>
      </tr>
    </table>
  </div>
</form>
<p>&nbsp; </p>
<p><br>

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
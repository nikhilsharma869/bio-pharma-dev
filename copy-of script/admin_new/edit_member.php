<?php 
include("includes/header_dashbord.php");
include("includes/access.php");
require_once("country.php");
#counter ========================================================================================	

 
		

#========================================================================================
if($_REQUEST[SBMT]):
   if(!$_REQUEST[user_id]):
       $r=mysql_query("insert into ".$prev."user set 
	   									username=\"".$_REQUEST[username]."\",
										slogan=\"".$_REQUEST[slogan]."\",
										password=\"".md5($_REQUEST[password])."\",
										fname=\"".$_REQUEST[fname]."\",
										lname=\"".$_REQUEST[lname]."\",
										status='".$_REQUEST[status]."',
										account_type='".$_REQUEST[account_type]."',
										user_type='".$_REQUEST[user_type]."',
										email=\"".$_REQUEST[email]."\",
										about_us='".$_REQUEST[about]."',
										profile=\"".$_REQUEST[profile]."\",
										work_experience=\"".$_REQUEST[work_experience]."\",
										rate=\"".$_REQUEST[rate]."\",
										country=\"".$_REQUEST[country]."\",
										gold_member=\"".$_REQUEST[gold_member]."\",
										reg_date=NOW()");
        
        $_REQUEST[user_id]=mysql_insert_id();
   else:
       if(!empty($_REQUEST['status']))
	   {
	     $q1=mysql_query("select * from ".$prev."mail_template where id=1");
		  $mem_activate_email=@mysql_result($q1,0,"mem_activate_email");
		  $mem_inactivate_email=@mysql_result($q1,0,"mem_inactivate_email");
		  $mem_noticed_email=@mysql_result($q1,0,"mem_noticed_email");
		  $mem_suspend_email=@mysql_result($q1,0,"mem_suspend_email");
		  //$mem_delete_email=mysql_result($q1,0,"mem_delete_email");
		 $q=@mysql_query("select * from ".$prev."user where user_id=".$_REQUEST[user_id]);
		 $staus=@mysql_result($q,0,"status");
		 $to=@mysql_result($q,0,"email");
		 if($status!=$_REQUEST['status'])
		 	{
		       if($_REQUEST['status']=='Y')
			   {
				  //echo "test";
				   //$to=getusername($_REQUEST['user_id']);
				   $subj="Yor account is activated";
				   $body=$mem_activate_email;
				   $mail_type='edit_admin';
				   $f=genMailing($to, $subj, $body, $from = '', $reply = true, $mail_type);
				  //echo "flag=".$f;
				}
				if($_REQUEST['status']=='N')
			      {
				   //echo "test";
				   //echo $to=getusername($_REQUEST['user_id']);
				   $subj="Yor account is inactivated";
				   $body=$mem_inactivate_email;
				    $mail_type='edit_admin';
				   $f=genMailing($to, $subj, $body, $from = '', $reply = true, $mail_type);
				   //mail($to,$subj,$body);
				   //echo "flag=".$f;
				  }
				  if($_REQUEST['status']=='S')
			   		{
				  //echo "test";
				   //$to=getusername($_REQUEST['user_id']);
				   $subj="Yor account is suspended";
				   $body=$mem_suspend_email;
				    $mail_type='edit_admin';
				   $f=genMailing($to, $subj, $body, $from = '', $reply = true, $mail_type);
				   //echo "flag=".$f;
					}
		 
		 	}
	   
	   }
	   
	   
	   $r=mysql_query("update ".$prev."user set 
	   									slogan=\"".$_REQUEST[slogan]."\",
										fname=\"".$_REQUEST[fname]."\",
										edit_date=NOW(),
										lname=\"".$_REQUEST[lname]."\",
										profile=\"".$_REQUEST[profile]."\",
										work_experience=\"".$_REQUEST[work_experience]."\",
										rate=\"".$_REQUEST[rate]."\",
										status='".$_REQUEST[status]."',
										account_type='".$_REQUEST[account_type]."',
										about_us='".$_REQUEST[about]."',
										user_type='".$_REQUEST[user_type]."',
										country=\"".$_REQUEST[country]."\",gold_member=\"".$_REQUEST[gold_member]."\",
										email=\"".$_REQUEST[email]."\" where user_id=".$_REQUEST[user_id]);
			if($_REQUEST[password]!='')
			{
				
				//echo "select * from  ". $prev . "user where strcmp(\"" . md5($_POST['password']) . "\", password)=0 and status='Y'";
				//echo "select * from  ". $prev . "user where password='".$_REQUEST[password]."'  and user_id=".$_REQUEST[user_id];
				$r=mysql_query("select * from  ". $prev . "user where password='".$_REQUEST[password]."'  and user_id=".$_REQUEST[user_id]);
				$f=mysql_num_rows($r);
				// echo "flag=".$f;
				if(mysql_num_rows($r)==0 || $_REQUEST[password]!=''){
				mysql_query("update ".$prev."user set password=\"".md5($_REQUEST[password])."\" where user_id=".$_REQUEST[user_id]);
			    }
			}
			
   endif;
   if($r):
       $tmp_name=$_FILES['logo']['tmp_name'];
	   if(!empty($_FILES['logo']['name'])):
	      
		     $ext=substr($_FILES['logo']['name'],-3,3);
			echo $newname="logo_" .$_REQUEST[user_id] . "." . $ext;

		   echo $path = "../portfolio/".$newname;
			if(move_uploaded_file($tmp_name,$path)):
			echo 'kjdghiue';
		       //echo "update ".$prev."user set logo='portfolio/".$newname."' where user_id=".$_REQUEST[user_id];
				$r=mysql_query("update ".$prev."user set logo='portfolio/".$newname."' where user_id=".$_REQUEST[user_id]);
		   endif;
	   endif;
       ?>
	 	   <script>

  function newDoc()

  {

  window.location.assign("member.list.php")

  }

   window.setTimeout("newDoc()",2000);

   </script>

	<?php 
   else:
       $txt="<b><font color='red'>Update failure</font></b>";
   endif;
endif;
if($_REQUEST[user_id]):
    $rr   = mysql_query("select * from ".$prev."user  where user_id=".$_REQUEST[user_id]);
    $data = mysql_fetch_array($rr);
endif;
if($txt){echo"<p align=center class=lnk>" . $txt . "</p>";}
?>
<script language="javascript" type="text/javascript">
function isEmail(emailstr) {
	var dotchar = emailstr.indexOf(".");
	var atchar = emailstr.indexOf("@");
	var dotlast = emailstr.lastIndexOf(".");
	var spacechar = emailstr.indexOf(" ");
	var len = emailstr.length;
	if( (dotchar == -1) || (atchar == -1) || (spacechar != -1) || (dotlast < atchar) || (dotlast == len - 1) ) {
		return false;
	}
	else {
		return true;
	}
}

function validate(){
	/* if(document.getElementById('username').value==''){
		alert("Please Specify user name.");
		document.getElementById('username').focus();
		return false;
	} 
	if(document.getElementById('password').value==''){
		alert("Please Specify password.");
		document.getElementById('password').focus();
		return false;
	}
	*/
	if(document.getElementById('slogan').value==''){
		alert("Please Specify slogan.");
		document.getElementById('slogan').focus();
		return false;
	}
	
	if(!isEmail(document.getElementById('email').value)){
		alert("Please Specify Valid Email.");
		document.getElementById('email').focus();
		return false;
	}
	if(document.getElementById('fname').value==''){
		alert("Please Specify First Name.");
		document.getElementById('fname').focus();
		return false;
	}
	if(document.getElementById('lname').value==''){
		alert("Please Specify Last Name.");
		document.getElementById('lname').focus();
		return false;
	}
	if(document.getElementById('country').value==''){
		alert("Please Specify country name.");
		document.getElementById('country').focus();
		return false;
	}
}
</script>

    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		



<!-----small cms validation start-------->


<!------------small cms validation end---->
        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="city_list.php">Member Management</a></li>
                 
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Member Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;Edit Member :</a> <?=$data[fname]?>&nbsp;<?=$data[lname]?></h4>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
   <form name="frmuser" method=post action="<?=$_SERVER[PHP_SELF]?>" enctype='multipart/form-data' onSubmit="return validate();" />
<input type=hidden name="user_id" value="<?=$_REQUEST[user_id]?>">

		
<table width="100%" border="0" cellspacing="1" bgcolor="#e5e5e5" style="border:1px solid #999999;" cellpadding="4" align="center" class="table">

<!--<tr class="header" bgcolor=<?=$light?>>

	<td class="header" height="30"><b> Edit Member : </b></td>
	
	<td class="header"><b>  </b></td>
	</tr>-->
<tr class="header" bgcolor=<?=$light?>>

	<td class="header" height="30"><b> Professional : </b></td>
	
	<td class="header"><b>  </b></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>User Name </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><?=$data[username]?></td>
	</tr>
    <tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Slogan </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="slogan" id="slogan" size=25 class=lnk  value="<?=$data[slogan]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Password </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=password name="password" id="password" size=25 class=lnk  ></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left width=30%><b>Email *</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="email" id="email" size=25 class=lnk  value="<?=$data[email]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>First Name *</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="fname" id="fname"  size=25 class=lnk  value="<?=$data[fname]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Last Name *</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="lname" id="lname"  size=25 class=lnk  value="<?=$data[lname]?>"></td>
	</tr>
	<?
	$arr=array_keys($country_array);
	//print_r($arr);
	?>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align="left"><b>Country *</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign="top">
		<select id="country" name="country">
		<option value="">Select Country</option>
		<?
		for($i=0;$i<count($arr);$i++):
		    if($data[country]==$arr[$i]):
				echo"<option value='" . $arr[$i] . "' selected>" . $country_array[$arr[$i]] . "</option>\n";
			else:
			   	echo"<option value='" . $arr[$i] . "'>" . $country_array[$arr[$i]] . "</option>\n";
			endif;
		endfor;
		?>
		</select>
		</td>
	</tr>
	<tr class="lnk" bgcolor="#ffffff">
		<td class="lnk" style="border-bottom:dotted 1px #e5e5e5" align="left"><b>Logo</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign="top">
		<?
		if($data[logo]):
		   //echo $data[logo];
		    echo"<img src='".$vpath."viewimage.php?img=".$data[logo]."&height=60&width=60>' border=0<br>";
		endif;
		?>
		<input type="file" name="logo" id="logo"  size="25" class="lnk"></td>
	</tr>
	<tr class="lnk" bgcolor="#ffffff">
		<td class="lnk" style="border-bottom:dotted 1px #e5e5e5" align="left"><b>Expertise</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign="top">
	   <?
	   
	 
		 $rr=mysql_query("select c.cat_name from ".$prev."categories c inner 
				join ".$prev."user_cats u on c.cat_id=u.cat_id where user_id=".$data[user_id]);
				
				
		$txt="";
		while($cat=@mysql_fetch_array($rr))
		{
			$txt2.=$cat[cat_name] . " , ";
		}
		
		if(substr($txt2,0,-2)){echo substr($txt2,0,-2);}else{echo "None";}
		?>
		</td></tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Overview </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="profile" id="profile" size=25 class=lnk  value="<?=$data[profile]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Work Experience </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="work_experience" id="work_experience" size=25 class=lnk  value="<?=$data[work_experience]?>"></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Avg. Hourly Rate </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type=text name="rate" id="rate" size=25 class=lnk  value="<?=$data[rate]?>"></td>
	</tr>
	
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Profile Type</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type="radio" name="account_type" id="account_type" value='I'<?php if($data[account_type]=='I') {echo ' checked="checked"';} ?>>Individual&nbsp;<input type="radio" name="account_type" id="account_type" value='C'<?php if($data[account_type]=='C') {echo ' checked="checked"';} ?>>Company</td>
	</tr>
	<!--<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Work As</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type="radio" name="user_type" id="user_type" value='E'<?php if($data[user_type]=='E') {echo ' checked="checked"';} ?>>Client&nbsp;<input type="radio" name="user_type" id="user_type" value='W'<?php if($data[user_type]=='W') {echo ' checked="checked"';} ?>>Professional<input type="radio" name="user_type" id="user_type" value='B'<?php if($data[user_type]=='B') {echo ' checked="checked"';} ?>>Both</td>
	</tr>-->
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>Status</b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><input type="radio" name="status" id="status" value='Y'<?php if($data[status]=='Y') {echo ' checked="checked"';} ?>>Active&nbsp;<input type="radio" name="status" id="status" value='N'<?php if($data[status]=='N') {echo ' checked="checked"';} ?>>Inactive<input type="radio" name="status" id="status" value='S'<?php if($data[status]=='S') {echo ' checked="checked"';} ?>>Suspended</td>
	</tr>
<tr class="header" bgcolor=<?=$light?>>

	<td class="header" height="30"><b> Client : </b></td>
	
	<td class="header"><b>  </b></td>
	</tr>
	<tr class=lnk bgcolor=#ffffff>
		<td class=lnk style="border-bottom:dotted 1px #e5e5e5" align=left><b>About Us </b></td>
		<td style="border-bottom:dotted 1px #e5e5e5" valign=top><textarea name="about" id="about" class="lnk" style="height: 60px; width: 75%;"><?=$data[about_us]?></textarea></td>
	</tr>

	<tr bgcolor=#e5e5e5>
		<td>* Fields are Mandatory</td>
		<td align=left>
	      <input type="submit" name="SBMT"  class="button" value="Update">
	      &nbsp;
	      <input type="button"  class="button" value="Back" onClick="javascript:window.location.href='member.list.php'">
		</td>
	</tr>
</table>



</form>
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
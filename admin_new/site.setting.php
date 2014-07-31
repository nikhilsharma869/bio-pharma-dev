<?php
include("includes/header_dashbord.php");
include("includes/access.php");
$light2="#666666";
$id=1;
if($_POST[SBMT_REG]):
   $r=mysql_query("update  " . $prev . "setup set 
   site_title=\"" . $_REQUEST[site_title] . "\",
   site_url=\"" . $_REQUEST[site_url] . "\",
   meta_keys=\"" . $_REQUEST[meta_keys] . "\",
  facebook_uid = \"" . $_REQUEST[facebook_uid] . "\",
   facebook_pass = \"" . $_REQUEST[facebook_pass] . "\",
   facebook_signature = \"" . $_REQUEST[facebook_signature] . "\",
   meta_desc=\"" . $_REQUEST[meta_desc] . "\",
   admin_mail=\"" . $_REQUEST[admin_mail] . "\",
   support_mail=\"" . $_REQUEST[support_mail] . "\",
   twitter_url=\"" . $_REQUEST[twitter_url_txt] . "\",
   facebook_url=\"" . $_REQUEST[facebook_url_txt] . "\",
   youtube_url=\"" . $_REQUEST[youtube_url_txt] . "\",
   flickr_url=\"" . $_REQUEST[flickr_url_txt] . "\",
   linkdin_url=\"" . $_REQUEST[linkdin_url] . "\",
   google_url=\"" . $_REQUEST[google_url] . "\",
   bad_words=\"" . $_REQUEST[bad_words] . "\",
   companyname=\"" . $_REQUEST[companyname] . "\",
    emailheader=\"" . $_REQUEST[emailheader] . "\",
	 emailfooter=\"" . $_REQUEST[emailfooter] . "\",
   vidtutorial=\"" . $_REQUEST[vidtutorial_txt] . "\"
   where id=\"".$id."\"");      
   
   $r=mysql_query("update  ".$prev."admin set email=\"" . $_REQUEST[admin_mail] . "\" where admin_id=3");
   if($r):
      $msg="Update Successful.";
   else:
      $msg="Update Failure.";
   endif;	  
endif;
    $r=mysql_query("select * from " . $prev . "setup where id='".$id."'");
    $d=@mysql_fetch_array($r);
	$class="lnk";
    ?>
<div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		<script src="js/jquery.genyxAdmin.js"></script>

        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Site Setting</h1>
                    </div>
					
					        <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='site.setting.php' class="header">&nbsp;Site Setting</a>&nbsp;&nbsp;<?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
            
           <table border="0" align=center cellpadding="4" cellspacing="3" style="border-collapse: collapse" bordercolor="#111111" width="100%" class="table"> 
    <tr bgcolor=<?=$light?>>
    	<td  height="20" align="center" <? if(substr_count($_SERVER[PHP_SELF],"site.setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}?>>
    	<a  href='site.setting.php' class=<?=$class?>>Site Setting</a>
        </td>
    	<td align=center <? if(substr_count($_SERVER[PHP_SELF],"account_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='account_setting.php' class=<?=$class?>>Account Setting</a>
        </td>
    	<td align=center <? if(substr_count($_SERVER[PHP_SELF],"transfer_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>>
        <a href='transfer_setting.php' class=<?=$class?>>Transfer Setting</a>
        <td height="20" width="25%" align=center <?php if(substr_count($_SERVER[PHP_SELF],"site_under_setting.php")){echo"bgcolor=" . $light2; $class="lnk_white_m";}else{$class="lnk";}?>><a href="site_under_setting.php" class=<?=$class?>>Site Under Maintainance</a></td>
        </td>
    </tr>
    </table>
       <br>
	
    <form name=register method=post action="<?=$_SERVER['PHP_SELF']?>" onSubmit="javscript:return ValidSet(this);">
    <table width="100%" border="1" align="center" cellspacing="0" cellpadding="0" class="table">
    <tr bgcolor="#b7b5b5" class=header_tr><td height=25 >&nbsp;Site Setting</td></tr>
    <tr><td align=center valign=top>
    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?> >
    <tr bgcolor=#ffffff class=lnk>
    	<td valign=top width=20%><b>Site Title :</b></td>
        <td ><input type=text class=lnk name=site_title value="<?=$d[site_title]?>" size=40><br>
      Description: This is the title of landing page of the website.<br>
      Example: MyWebsite - Changing how the world works.</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td valign=top width="25%"><b>Site URL :</b></td>
        <td ><input type=text class=lnk name=site_url value="<?=$d[site_url]?>" size=40><br>
      Description: This is the url of the website.<br>
      Example: http://www.mywebsite.com</td>
    </tr>
	<tr  bgcolor=#ffffff class=lnk>
    	<td valign=top width="25%"><b>Meta Keys :</b></td>
        <td ><textarea name=meta_keys cols=70 rows=5 class=lnk><?=$d[meta_keys]?></textarea></td>
    </tr>
	<tr  bgcolor=#ffffff class=lnk>
    	<td valign=top width="25%"><b>Meta Description :</b></td>
        <td ><textarea name=meta_desc cols=70 rows=5 class=lnk><?=$d[meta_desc]?></textarea></td>
    </tr>
	<tr  bgcolor=#ffffff class=lnk>
    	<td valign=top width="25%"><b>Email Header :</b></td>
        <td ><textarea name=emailheader cols=70 rows=5 class=lnk><?=$d[emailheader]?></textarea></td>
    </tr>
	<tr  bgcolor=#ffffff class=lnk>
    	<td valign=top width="25%"><b>Email Footer :</b></td>
        <td ><textarea name=emailfooter cols=70 rows=5 class=lnk><?=$d[emailfooter]?></textarea></td>
    </tr>
	<tr  bgcolor=#ffffff class=lnk>
    	<td valign=top width="25%"><b>Company Name :</b></td>
        <td ><input type=text class=lnk name=companyname value="<?=$d[companyname]?>" size=40>
		</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Admin Email :</b></td>
        <td ><input type=text class=lnk name=admin_mail value="<?=$d[admin_mail]?>" size=40><br>
      Description: This is the mail id where users will contact the administrator.<br>
      </td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Support Email :</b></td>
        <td ><input type=text class=lnk name=support_mail value="<?=$d[support_mail]?>" size=40><br>
      Description: This is the support mail id where users will contact support team.<br>
      </td>
    </tr>
	
		<tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Facebook API user id :</b></td>
        <td>
     		<input type="text" name="facebook_uid" size="45" value="<?=$d[facebook_uid]?>"> 
    
    	</td>
    </tr>
	<tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Facebook API password :</b></td>
        <td>
     		<input type="text" name="facebook_pass" size="45" value="<?=$d[facebook_pass]?>"> 
    
    	</td>
    </tr>
	<tr class=lnk bgcolor="#ffffff">
    	<td valign="top" width="25%"><b> Facebook API paypal_signature :</b></td>
        <td>
     		<input type="text" name="facebook_signature" size="45" value="<?=$d[facebook_signature]?>">
    	</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Twitter URL :</b></td>
        <td ><input type=text class=lnk name="twitter_url_txt" value="<?=$d[twitter_url]?>" size=40><br>
      Example: www.twitter.com/admin</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Facebook URL :</b></td>
        <td ><input type=text class=lnk name="facebook_url_txt" value="<?=$d[facebook_url]?>" size=40><br>
      Example: www.facebook.com/admin</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>YouTube URL :</b></td>
        <td ><input type=text class=lnk name="youtube_url_txt" value="<?=$d[youtube_url]?>" size=40><br>
      Example: www.youtube.com/admin</td>
    </tr> <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>linkdin URL :</b></td>
        <td ><input type=text class=lnk name="linkdin_url" value="<?=$d[linkdin_url]?>" size=40><br>
      Example: www.linkdin.com/admin</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Google+ URL :</b></td>
        <td ><input type=text class=lnk name="google_url" value="<?=$d[google_url]?>" size=40><br>
      Example: www.google.com/admin</td>
    </tr>
    <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Site Tutorial-Video Code :</b></td>
        <td ><input type=text class=lnk name="vidtutorial_txt" value="<?=$d[vidtutorial]?>" size=40><br>
      Example: http://www.youtube.com/embed/<b style="color:#F00">a0qMe7Z3EYg</b> <i>(only the highlighted part is required)</i></td>
    </tr>
	 <tr bgcolor=#ffffff class=lnk>
    	<td width="25%"><b>Restricted Words/Letters :</b></td>
        <td ><textarea name="bad_words" cols="70" rows="5" class="lnk"><?=$d[bad_words]?></textarea><br>
     Put the restricted words/letters seperated by commas.</td>
    </tr>
    
    <tr bgcolor=<?=$light?>><td></td><td height=25 align="left">
      <input type=submit class="button" name='SBMT_REG' value='Update'>
    </td></tr>

    </table></td></tr>
	    
		</table>
		</form>

</div>
</div>
</div>
</div>
			
			</div> <!-- End .container-fluid  -->
            </div> <!-- End .wrapper  -->
        </section>
    </div>


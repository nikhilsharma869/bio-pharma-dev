<?php $current_page="How it works"; ?>
<?php ob_start();?>
<?php
include("include/header.php");
?>
<?php
include("include/header_menu.php");
?>
<?php
$rwc=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='How It Works'"))
?>
<?php
$rwc1=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='Post  Project'"))
?>
<?php
$rwc2=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='Select Proposal'"))
?>
<?php
$rwc3=mysql_fetch_array(mysql_query("select * from ".$prev."contents where cont_title ='Hire Professional'"))
?>
<!------Start-middle-------->
<div class="inner-middle">
<div class="page_headding">
<table align="left" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" height="25" border="0" cellspacing="0" cellpadding="0" class="registab">
     <tr>
        <td width="25%"><h4><a class="selected" lang="en">How it works for clients</a></h4></td>
        <td width="0%">&nbsp;</td>
        <td width="30%"><h4><a href="how-itworks-professionals.php" lang="en">How it works for professionals</a></h4></td>
        <td width="45%">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="97%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="28%"><div class="create1">
          <h1><span lang="en">Post<span> <br />
           <span lang="en">Project</span></h1>
        </div></td>
        <td width="4%"><img src="images/divider-line.png" width="28" height="49" /></td>
        <td width="28%"><div class="win1">
          <h1><span lang="en">Select</span><br /> 
         <span lang="en">Proposal</span></h1>
        </div></td>
        <td width="4%"><img src="images/divider-line.png" width="28" height="49" /></td>
        <td width="31%"><div class="work1">
         
              <h1><span lang="en">Hire</span><br />
                <span lang="en">Professional</span></h1>
           
        </div></td>
        </tr>
      <tr>
        <td height="15"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td align="left" valign="top"><p><?php print html_entity_decode($rwc1['contents']);?></p></td>
        <td>&nbsp;</td>
        <td align="left" valign="top"><p><?php print html_entity_decode($rwc2['contents']);?></p></td>
        <td>&nbsp;</td>
        <td align="left" valign="top"><p><?php print html_entity_decode($rwc3['contents']);?></p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="105">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="60%" border="0" cellspacing="0" cellpadding="0" align="right" style="background:#f4f4f4;" class="registab"  >
      <tr>
        <td height="12"></td>
      </tr>
      <tr>
        <td><p><?php print html_entity_decode($rwc['contents']);?></p></td>
      </tr>
      <tr>
        <td height="12"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div class="clear"></div>
    </div>
<div class="register_panel">


<!--Register Form Start-->
   
<!--Register Form End-->

</div>

</div>


<!------end_middle-------->
<?php
include("include/footer.php");
?>
		
		<div class="testing_box">
  <table align="center" width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="15" align="center"></td>
  </tr>
  <tr>
    <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr class="tab_box">
        <td width="16%"><p><?=$lang['LAST_LOGIN' ]?> :</p> </td>
        <td width="34%"><p><?php print date('d-M-Y, h:i:s a', strtotime($_SESSION['ldate']));?></p></td>
        <td width="40%"><p><?=$lang['BALANCE_AMOUNT' ]?>:</p></td>
        <td width="10%"><p><strong><?php print $balsum;?><?=$lang['EUR']?></strong></p></td>
      </tr>
    </table></td>
  </tr>
 

  <tr>

  
  
    <td height="15" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr class="tab_box">
        <td width="16%"></td>
        <td width="34%"></td>
        <td width="40%"><p> <?=$lang['YOUR_PROFILE']?> <?=round($prfcomplt);?><?=$lang['COMPLETE']?></p></td>
        <td width="10%"><p>&nbsp;</p></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0" >
      <tr class="tab_box">
        <td width="16%" height="34"></td>
        <td width="34%"></td>
        <td width="40%" valign="bottom">&nbsp;</td>
        <td width="10%"></td>
      </tr>
      <tr class="tab_box">
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" align="center"></td>
  </tr>
</table>
           
  </div>
	  
   
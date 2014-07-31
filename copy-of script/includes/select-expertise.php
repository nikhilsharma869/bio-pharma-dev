<?php 

include "includes/header.php";

CheckLogin();

?>

<?php

//if(!$link){header("Location: ./index.php"); exit();}



if($_SESSION['user_id']){$user_id=$_SESSION['user_id'];}else{$user_id=$_SESSION['usre_id'];}

if(empty($user_id)){header("Location: ".$vpath."login.php"); exit();}



if($_REQUEST['SBMT']=='Submit'):

	mysql_query("delete from  " . $prev . "user_cats where user_id=" . $_SESSION[user_id]);  

	$k=0;

	for($i=0;$i<=$_REQUEST['num'];$i++):

    	$ids="cat_ids" . $i;

		if(isset($_REQUEST[$ids])):		

		$arr = explode(',',$_POST[$ids]);

		//mysql_query("insert into " . $prev . "user_cats set user_id=" . $_SESSION[user_id] . ",cat_id=" . $_REQUEST[$ids]);  

        	mysql_query("insert into " . $prev . "user_cats set user_id=" . $_SESSION[user_id] . ",cat_id=" . $arr[0]. ",parent_cat_id=".$arr[1]);  

    	  //  echo"insert into " . $prev . "user_cats set user_id=" . $_SESSION[user_id] . ",cat_id=" . $_REQUEST[$ids]. "<br>";

		//	echo $_REQUEST[$ids]."<br>";die();

			$k++;   

		endif;	  

	endfor;

	if($k):

	   $msg="<h3 >* ".$lang['EXPERT_AREA']."</h3>";	

	endif;

	//if($r):

	  // $msg.="<br><h3 >Profile  updated successfully</h3>";	

	//endif;   					

endif;

$e=mysql_query("select * from  " . $prev . "user_cats where user_id=" . $_SESSION[user_id]); 

$usercats=array();

while($dd=@mysql_fetch_array($e)):

    $usercats[]=$dd[cat_id];

endwhile;

$e=mysql_query("select * from  " . $prev . "user where user_id=" . $_SESSION[user_id]); 

$d=@mysql_fetch_array($e);

?>



<script>

function  check()

{

var count = 0;

var str = '';

alert (document.exp_form.elements["cat_ids[]"].length);

    for(x=0; x<document.exp_form.elements["cat_ids[]"].length; x++){

        if(document.exp_form.elements["cat_ids[]"][x].checked==true){

            str += document.exp_form.elements["cat_ids[]"][x].value + ',';

            count++;

        }

    }

 

    if(count==0){

        alert("You must choose at least 1");

        return false;

    }

    else if(count>3){

        alert("You can choose a maximum of 3");

        return false;

    }

    else {

    alert("You chose " + count + ": " + str.substring(0,str.length-1));

    document.exp_form.submit();

    }

}

</script>



	<script>

function ValidateForm(form1) {

	



	if (form1.elements['rate'].value == '') {

		alert('Please enter your rate/hour.');

		form1.elements['rate'].focus();

		return false;

	}

	if (form1.elements['profile'].value == '') {

		alert('Please enter profile details.');

		form1.elements['profile'].focus();

		return false;

	}

	

	return true;

}

</script>



<style type="text/css">

.profilebutton {

    background-color: #58AFDE;

    border: 1px solid #388bb5;

    color: #FFFFFF;

    cursor: pointer;

   

    padding: 2px 4px;

    text-shadow: 1px 1px 1px #CCCCCC;

	-webkit-border-radius:4px;-moz-border-radius:4px;

}



</style>





<!-----------Header End-----------------------------> 



<!-- content-->

<div class="freelancer">





<!--Profile-->

<?php include 'includes/leftpanel1.php';?> 

    <!-- left side-->

    <!--middle -->

    <div class="profile_right">

   <div class="edit_profile">

     <h2><?=$lang['PH_WELCOME']?> <?php print $_SESSION['fullname'];?><br />

	 <span><?=$lang['LAST_LOGIN_TIME']?> <?=mysqldate_show($_SESSION[ldate],1)?></span></h2>



<!--<div align="right">

Balance  :  $ <strong><?php print $balsum;?></strong><br />

Pending Transactions  :  $ <strong><?php print $sum1;?></strong>

</div>-->

<ul>

<li ><a href="profile.php"><?=$lang['UPDATE_PROFILE']?></a></li>

<li class="selected" ><a href="select-expertise.php"><?=$lang['UPDATE_EXPERTISE']?></a></li>

<li ><a href="upload-portfolio.php"><?=$lang['UPDATE_PORTFOOLIO']?></a></li>

  



</ul>

   </div>

   

 <div class="edit_form_box">

<!----------------------------------------------MIDDLE DIV--------------------------------------------------------------------->



            <table cellpadding="0" cellspacing="0" border="0" width="90%" align="center" style="color:#4E4D4D; font-size:12px; font-family:Tahoma,Arial,Verdana,Sans-serif;" >

            <tr><td height="10px;"></td></tr>

<!------------------------------------------------Middle Body-------------------------------------------------------------->

            <tr>

            	<td>

<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->	



										

        <table align="center" width="100%">

        <tr>

        <td align="left" width="50%"></td>

		<td align="right" width="50%">

		<button class="submit_bott" onclick="javascript: window.location='profile.php'" > <?=$lang['SKIP']?> </button></td>

        </tr>

        </table>

        <form method="POST" name="exp_form" onsubmit="return Validform(this)" action="">

        <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">

        <tr>

        <td align="left" valign="top"></td>

        </tr>

        <tr>

        <td align="left" valign="top" class="bx-border">

        <table width="100%" border="0" cellpadding="10" cellspacing="0" align="center">

        

        <?php

        if($msg)

        {

        ?>

        <tr><td colspan="2" align="center" style="color:#C60000; font-size:11px; font-weight:normal;"><?=$msg?></td></tr>

        <?php

        }

		if($d['gold_member']!='Y')

		{

		?>

			<tr><td colspan="3"><table bgcolor="#F5F5F5" width="100%">

			<tr><td >

			<?=$lang['UPDATE_MEMBERSHIP']?></td>

			<td><a href="membership_plan.php" ><img src="images/gold-member.png"  /></a>

			</td></tr>

			</table></td></tr>

		<?php

		}

        ?>

        <tr style="background-color:#a1282c;"><td valign='top' class='link' ><font color="#FFFFFF"><strong><?=$lang['SELECT_AREA_EXPERTISE']?> : *</strong></font></td><td class=boldfont_con align=right><font color="#FFFFFF"><?=$lang['POSTJOB_DIV_13']?></font></td></tr>

        <tr class='link'>

        <td colspan='2'>

        <?

        $r=mysql_query("select * from " . $prev . "categories  where parent_id=0 and status='Y' order by cat_name");

        $j=0;$n=0;

        while($da=mysql_fetch_array($r)):

        if(!$j){$cls="expanded";}else{$cls="trigger";}

        ?>

		<h3 style="padding:10px;"><?php echo  $da[cat_name];?></h3>

        <!--<div id="typelink" class=expanded>&nbsp;&nbsp; </div>-->

        <div style="width:100%;" id=content>

        

        <table border="0" cellpadding=2 cellspacing=0 align=center width=100%>

        <tr class=link>

        <?php

        

        //	 echo "select * from " . $prev . "categories where parent_id=" . $da[cat_id] . " and status='Y' order by cat_name";

        

        

        $rr=mysql_query("select * from " . $prev . "categories where parent_id=" . $da[cat_id] . " and status='Y' order by cat_name");

        $i=1;

        while($row=mysql_fetch_array($rr))

        {

        // echo $i;

        if(@in_array($row[cat_id],$usercats))

        {

        $chk="checked";

        }

        else

        {

        $chk=" ";

        }

        // echo $chk;

        

        

        

        ?>

        <td width="50%" style="font-size:11;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		<INPUT type="checkbox" <?=$chk?> id="cat_ids[]" name="cat_ids<?=$n?>" value="<?=$row[cat_id].','.$da[cat_id];?>" > <?=$row[cat_name];?></td>

        <?

        

        if($i==2)

        {

        ?>

        </tr><tr class=link>

        <?php

        $i=0;

        }

        $i++;$n++; }

        ?>

        </tr>

        </table>

        </div>

        <?php

        $j++;

        endwhile;

        ?>

        <input type="hidden" name="num" value="<?=$n?>" />

        </td>

        </tr>

        

        <input type="hidden" name='SBMT' value='Submit'  onclick="return check()" />

        </table>

        

        

        </td>

        </tr>

        

        <tr>

        <td align="left" valign="top" class="inner_bx-bottom">

        <table align="center" width="100%" cellpadding="0" cellspacing="0">

        <tr class="lnk"><td width=32%></td>

        <td >

        

        <input type="submit" name="update"  class="submit_bott" value="Update"  />

       <!-- <input type="image" src="images/update.jpg"   />-->

        <input type="hidden" name="hiddProfileSubmit" value="1"> 

        

        </td>

        </tr>

        </table>

        </td>

        <td valign="top" align="left">

        </td>

        </tr>

        <tr>

        <td colspan="2" style="height:50px;">

        </td>

        </tr>

        </table>

        </form>

										

										

										

<!--//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->			

                </td>

            </tr>

<!------------------------------------------------Middle Body End---------------------------------------------------------->

            </table>

       

  </div>

<!------------------------------------------------MIDDLE DIV END------------------------------------------------------------->

</div>



   

   </div>

<!--end content-->





</div>

</div>

</div>

</div>

<?php include 'includes/footer.php';?> 

</body>

</html>
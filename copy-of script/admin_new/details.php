<?php 

include("includes/header_dashbord.php");
include("includes/access.php");


if($_REQUEST['id'])

{

	$dspt_prj = mysql_fetch_array(mysql_query("select * from " . $prev . "disputes where disput_id='".$_REQUEST['id']."'"));

    $prj = mysql_fetch_array(mysql_query("select * from " . $prev . "projects where id='".$dspt_prj['claim_proj_id']."'"));	
	
	$prj_user = mysql_fetch_array(mysql_query("select * from " . $prev . "user where user_id='".$prj['user_id']."'"));	

}

$postdate = date("d-m-Y", strtotime($prj['creation']));

//$ttoy = time();

//$tsec = (($prj[expires]-$ttoy)/((24 * 60) * 60));

if($prj[budgetmin]!=''){$price="Min $".$prj[budgetmin]." ";}
if($prj[budgetmax]!=''){$price.="Max $".$prj[budgetmax];}

?>
<?php

 $dispue_sql="select d.*,p.project,u.username,u.logo,u.user_id from " . $prev . "user u," . $prev . "disputes d inner join  " . $prev . "projects p on d.claim_proj_id=p.id where (d.disput_by='".$prj_user['user_id']."' or d.disput_for='".$prj_user['user_id']."') and  d.status='Y' and u.user_id=d.disput_by and d.disput_id='".$_GET['id']."'";

$dispue_res=mysql_query($dispue_sql);

$disputes=mysql_fetch_array($dispue_res);

$dispute_for=mysql_fetch_array(mysql_query("select u.* from  ". $prev ."user u, " . $prev . "disputes d  where u.user_id=d.disput_for and u.user_id=".$disputes['disput_for']));


$dreply="select * from " . $prev . "disput_reply where disput_id='".$_REQUEST['id']."'";
$dres=mysql_query($dreply);

$dreply1="select * from " . $prev . "disputes where disput_id='".$_REQUEST['id']."'";
$dres1=mysql_fetch_array(mysql_query($dreply1));

$newDate = date("d-m-Y", strtotime($dres1['date']));
?>
<?php
if($_POST['submit']=='Update')
{   
	if(($disputes['claim_amount'] >= $_POST['amount1']) && ($disputes['claim_amount'] >= $_POST['amount2'])){
	$t=time();
	$addamountsql=mysql_query("INSERT INTO ".$prev."transactions set
			amount ='".$_POST['amount2']."',			
			details ='".$_POST['details']."',		
			user_id ='".$_POST['dispute_for_user_id']."',		
			balance ='".$_POST['amount2']."',
			add_date =now(),
			date2 ='".$t."',
			status ='Y',
			amttype ='CR'");
			
	$addamountsql1=mysql_query("INSERT INTO ".$prev."transactions set
			amount ='".$_POST['amount1']."',			
			details ='".$_POST['details']."',		
			user_id ='".$_POST['dispute_user_id']."',		
			balance ='".$_POST['amount1']."',
			add_date =now(),
			date2 ='".$t."',
			status ='Y',
			amttype ='CR'");
	
	$statussql=mysql_query("update ".$prev."projects set 
			status='".$_POST['status']."' 
			where id='".$prj['id']."'");
	
	$sql=mysql_query("update " . $prev . "disputes set 
			resolve='Y',
			amt_disput_by='".$_POST['amount2']."',
			amt_other_disput_by='".$_POST['amount1']."',
			amt_disput_for='".$_POST['amount1']."',
			resolve_date = now(),
			amt_other_disput_for='".$_POST['amount2']."'
			where disput_id=".$_POST['d_id']);
	}else{
		$errmsg = "<font color=red>Please check dispute amount.You can not enter more then dispute amount.</font>";
	}
}
?>
<link rel="stylesheet" type="text/css" href="../highslide/highslide.css" />
<script type="text/javascript" src="../highslide/highslide-with-html.js"></script>
<script type="text/javascript">
hs.graphicsDir = '../highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
minWidth = 450;
</script>
<script language="javascript">
function changeamount1()
	{
		var a=document.getElementById("amount1").value;		
		var b=document.getElementById("dispute_amount").value;
		var x=Number(b)-Number(a);	
		document.getElementById("amount2").value=x;		
	}
function changeamount()
	{
		var a=document.getElementById("amount2").value;		
		var b=document.getElementById("dispute_amount").value;
		var x=Number(b)-Number(a);	
		document.getElementById("amount1").value=x;		
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
                      <li><a >Dispute Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Dispute Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='membership_plan_list.php' class="header">&nbsp;Dispute Project ::</a>&nbsp;&nbsp;<?=$prj['project']?>									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">




<table width="100%" border="0" cellspacing="0" cellpadding="5" class="table table-striped table-bordered table-hover" id="dataTable">
  <tr>
    <td colspan="3" align="left" bgcolor="whitesmoke" class="blue_bg"><strong>Dispute project Details</strong></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Name of project :<br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke"><input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px; border:none;"value="<?=$prj['project']?>" size="40"  readonly="true"/></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Posted date :<br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke"><input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=$postdate?>" size="40"  readonly="true"/></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Posted By :<br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke"><input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=$prj_user[fname]?> <?=$prj_user[lname]?>" size="40"  readonly="true"/></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Project price :<br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke"><input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=$price?>" size="40"  readonly="true"/></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Disput By :<br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke"><input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=ucwords($disputes['username'])?>" size="40"  readonly="true"/></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Total Disput Amount<br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke">$
      <input name="dispute_amount" type="text" id="dispute_amount" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=$disputes['claim_amount']?>" size="39" readonly="true" /></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Amount offered by <b>
      <?=ucwords($disputes['username'])?>
      </b> <br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke">$
      <input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=$disputes['amt_other_disput_by']?>" size="39" readonly="true" /></td>
  </tr>
  <tr>
    <td width="5%" align="right" valign="top" bgcolor="whitesmoke"><span class="required">*</span></td>
    <td width="35%" align="left" valign="top" bgcolor="whitesmoke">Amount offered by <b>
      <?=ucwords($dispute_for['username'])?>
      </b><br />
      <span class="text10 color_red"></span></td>
    <td width="60%" align="left" valign="top" bgcolor="whitesmoke">$
      <input name="pr_title" type="text" id="pr_title" style="width:<?=$width_box_gen?>px;height:20px;border:none;"value="<?=$disputes['amt_other_disput_for']?>" size="39" readonly="true" /></td>
  </tr>
  <tr>
    <td width="5%" align="center" colspan=3><form name="dspt" id="" method="post">
        <input type="hidden" name="dispute_user_id" value="<?=$disputes['user_id']?>">
        <input type="hidden" name="dispute_for_user_id" value="<?=$dispute_for['user_id']?>">
        <input type="hidden" name="d_id" value="<?=$disputes['disput_id']?>">
        <input type="hidden" name="details" value="Dispute decision by Administrater">
        <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#FBEFEF"style="border:1px solid silver;" >
          <tr>
            <td align="center" colspan=2><b>-: <u>Admin decision amount & Status</u> :-</b>
              <?php if($errmsg){ echo "<br>".$errmsg;} ?></td>
          </tr>
          <tr>
            <td align="right"><?=ucwords($disputes['username'])?></td>
            <td align="left" valign="top"><input name="amount1" type="text" id="amount1" value="" size="20" onclick="changeamount();" /></td>
          </tr>
          <tr>
            <td align="right"><?=ucwords($dispute_for['username'])?></td>
            <td align="left"><input name="amount2" type="text" id="amount2" value="" size="20" onclick="changeamount1();" /></td>
          </tr>
          <tr>
            <td align="right">Project Status :</td>
            <td align="left"><input name="status" type="radio" id="open" value="open"<?php if($prj['status']=='open'){ echo "checked='checked'";}?> />
              Open
              <input name="status" type="radio" id="status" value="frozen" <?php if($prj['status']=='frozen'){ echo "checked='checked'";}?> />
              Frozen
              <input name="status" type="radio" id="status" value="complete" <?php if($prj['status']=='complete'){ echo "checked='checked'";}?>/>
              Complete
              <input name="status" type="radio" id="status" value="process" <?php if($prj['status']=='process'){ echo "checked='checked'";}?>/>
              Process
              <input name="status" type="radio" id="status" value="expired" <?php if($prj['status']=='expired'){ echo "checked='checked'";}?>/>
              Expired </td>
          </tr>
          <tr>
            <td>&nbsp;<span class="text10 color_red"></span></td>
            <td width="60%" align="left"><input name="submit" type="submit" id="submit" class="button" value="Update" /></td>
          </tr>
          
        </table>
      </form></td>
  </tr>
</table>
<br />
<form name="proj_frm1" action="" method="post" enctype="multipart/form-data" onsubmit=" return myfun();">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" class="blue_bg_table" style="border: 1px silver solid">
    <tr>
      <td colspan="3" align="left" bgcolor="whitesmoke" class="blue_bg"><strong>
        <?=ucwords($prj_user['username'])?>
        </strong></td>
    </tr>
    <tr>
      <td width="5%" align="center"><img src="../viewimage.php?img=<?=$prj_user['logo']?>&amp;width=70&amp;height=70" /></td>
      <td align="left" valign="top" ><b>
        <?=$dres1['claim_title']?>
        :</b>&nbsp;
        <?=$dres1['claim_desc']?>
        <br>
        <br>
        <b>Date :</b>
        <?=$newDate?></td>
    </tr>
  </table>
</form>
<br>
<?php

while($dispute_reply=mysql_fetch_array($dres))
	{
	$newDate1 = date("d-m-Y", strtotime($dispute_reply['reply_on']));
	
	$rplyuser=mysql_fetch_array(mysql_query("select * from  ". $prev ."user where username='".$dispute_reply['reply_by']."'"));
?>
<form name="proj_frm1" action="" method="post" enctype="multipart/form-data" onsubmit=" return myfun();">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" class="blue_bg_table" style="border: 1px silver solid">
    <tr>
      <td colspan="3" align="left" bgcolor="whitesmoke" class="blue_bg"><strong>
        <?=ucwords($dispute_reply['reply_by'])?>
        </strong></td>
    </tr>
    <tr>
      <td width="5%" align="center"><?php
			if($dispute_reply['reply_by']!='Admin user'){
			?>
        <img src="../viewimage.php?img=<?=$rplyuser['logo']?>&amp;width=70&amp;height=70" />
        <?php
			}else{
			?>
        <img src="images/administrator.png" width=70 height=64 />
        <?php
			}
			?></td>
      <td align="left" valign="top" >&nbsp;
        <?=$dispute_reply['reply_desc']?>
        <br>
        <br>
        <b>Date :</b>
        <?=$newDate1?></td>
    </tr>
    <?php
			if($dispute_reply['reply_by']!='Admin user'){
		?>
    <tr>
      <td width="5%" align="right">&nbsp;</td>
      <td align="right"><a href="reply.php?disput_id=<?=$dispute_reply[disput_id]?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )"><b>Reply</b></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <?php
		}else{
		?>
    <tr>
      <td width="5%" align="right">&nbsp;</td>
      <td align="right"><a href="reply.php?id=<?=$dispute_reply[reply_id]?>&disput_id=<?=$dispute_reply[disput_id]?>" onclick="return hs.htmlExpand(this, { objectType: 'iframe'} )"><b>Edit</b></a>&nbsp;&nbsp;&nbsp;&nbsp;</td>
    </tr>
    <?php
		}
		?>
  </table>
</form>
<br>
<?php
}
?>
<script type="text/javascript">

function myfun()

{

	if(confirm('Are you sure you want to delete ?'))

	{

		return true;

	}

	else

	{

		return false;

	}

}

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
<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

?>

<script>
$(document).ready(function(){
alert('jquery ache');
});
</script>
<!--	<script>
 function approved()
  {
     var suburb = $('#suburb').val();
  var jobDesc = $('#jobDesc').val();
  var name = $('#yourname').val();
  var email = $('#youremail').val();
  var contact = $('#contact').val();
  var noquotes = $('#tech4').val();
  var urgentjob = $('#urgentjob').val();
  var SELECTOR_SUCCESS = $('.success_box');
     var dataString = 'suburb='+suburb+'&jobDesc='+jobDesc+'&name='+name+'&email='+email+'&contact='+contact+'&noquotes='+noquotes+'&urgentjob='+urgentjob;
  $.ajax({
     type:"POST",
     data:dataString,
     url:"ajax/ajax_approve.php",
     success:function(return_data)
     {
      if(return_data== '1')
    {
      $('#quoteFrm').hide();
   $('.success_box123').show();
    }
     }
    });
  }
</script>-->
<script type='text/javascript' src="js/jquery-1.4.3.min.js"></script>
<!--<script type="text/javascript">
$(document).ready(function(){
    $(":checkbox").change(function(){
        if($(this).attr("checked"))
        {
            //call the function to be fired
            //when your box changes from
            //unchecked to checked
        }
        else
        {
            //call the function to be fired
            //when your box changes from
            //checked to unchecked
        }
    });
});
</script>-->
    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			


 

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="project.list.php">Project Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Project Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href="bid_list.php" class="header">Bid List</a>
									
									</h4> &nbsp; &nbsp; <?php if($msg){echo  "<blink>".$msg."</blink>" ;} ?>
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#b7b5b5">
<tr class="header_tr" bordercolor="#b7b5b5"><td height=25 colspan=2><a href='project.list.php' class=header_tr><b><u>Project List</u></b></a> > <b>Bid List</b>&nbsp; &nbsp;&nbsp; &nbsp; <span style="color:#AA0000; font-size:12px;"><?php if($_REQUEST['msg']!=""){echo $_REQUEST['msg'];}?></span> </td></tr>
<tr class="lnk" bgcolor="#ffffff">
	<td>
	<!--*********************main table start***********************-->
<table cellpadding="4" cellspacing="0" align="center" width="100%">
<tr><td valign=top width=80%>

<table cellpadding="4" cellspacing="0" align="center" border="0"  width="100%">

<form method=post action="<?=$_SERVER[PHP_SELF]?>">

<?
$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.creation='".date("Y-m-d") . "' group by ".$prev ."projects.id");
$total=@mysql_num_rows($r);

$r=mysql_query("select *  from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='open' group by ".$prev ."projects.id");
$total_open=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where  ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='frozen' group by ".$prev ."projects.id");
$total_frozen=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='complete' group by ".$prev ."projects.id");
$total_delevered=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='expired' group by ".$prev ."projects.id");
$total_expired=@mysql_num_rows($r);

$r=mysql_query("select * from " . $prev . "projects," .$prev ."projects_cats where ". $prev ."projects.id=" .$prev ."projects_cats.id and ". $prev ."projects.status='cancelled' group by ".$prev ."projects.id");
$total_cancelled=@mysql_num_rows($r);



$r=mysql_query("select * from " . $prev . "projects," .$prev ."buyer_bids where ". $prev ."projects.id=" .$prev ."buyer_bids.project_id");
$total_bids=@mysql_num_rows($r);

?>

<table id="table-1" width="100%"  border="0" align="center" cellspacing="1" cellpadding="4"   class="table table-striped table-bordered table-hover" id="dataTable">
<thead>
<tr >

<td width="24%"><b>Creator</b></td>
<td width="13%" align="center"><b>Bid Amount</b></td>

<td width="12%"  align=center><b>Date</b></td>

<td width="10%"  align=center><b>Status</b></td>
<td width="10%"  align=center><b>Action</b></td>

</tr>
</thead><tbody>
<?
if(!$_GET[limit]){$_GET[limit]=1;}
$cond=array();
if($_POST[param]):
  
   $cond[]=$prev . "projects.".$_POST[param]  . " rlike '" . addslashes($_POST[search]) . "'";
   $param="&" .$_POST[param] . "=" . $_POST[search];
endif;
$cond[]=$prev ."projects.id=" .$prev ."projects_cats.id";
if($_REQUEST['status'])
{
	$cond[]=$prev . "projects.status='".$_REQUEST['status']."'";
}
if($_REQUEST['user_id'])
{
	$cond[]=$prev . "projects.user_id='".$_REQUEST['user_id']."'";
}
if($_REQUEST['id'])
{
	$cond[]=$prev . "projects.id='".$_REQUEST['id']."'";
}
if($_REQUEST['creation'])
{
	$cond[]=$prev ."projects.creation='".$_REQUEST['creation']."'";
}
if($_REQUEST['cat_id'])
{
	$cond[]=$prev ."projects_cats.cat_id='".$_REQUEST['cat_id']."'";
}


if(count($cond)){$cond2= " where " . implode (" and ",$cond);}

$r=mysql_query("select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats  " . $cond2 . " group by ".$prev ."projects.id");
$total=@mysql_num_rows($r);
if(!$total):
   echo"<tr><td align=center colspan=7 align=center class=lnkred>No project found</td></tr>";
endif;
$r=mysql_query("select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats " . $cond2 . " group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20");
//echo"select " . $prev . "projects.* from " . $prev . "projects,".$prev ."projects_cats " . $cond2 . " group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20";
//echo "select " . $prev . "projects.*,".$prev ."buyer_bids.* from " . $prev . "projects,".$prev ."buyer_bids where ". $prev . "projects.id=".$prev ."buyer_bids.project_id group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20";
//exit;
//echo "select " . $prev . "projects.*,".$prev ."buyer_bids.* from " . $prev . "projects,".$prev ."buyer_bids where ". $prev . "projects.id=".$prev ."buyer_bids.project_id group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20";
//exit;
//echo "select " . $prev . "projects.*,".$prev ."buyer_bids.* from " . $prev . "projects,".$prev ."buyer_bids where ". $prev . "projects.id=".$prev ."buyer_bids.project_id  AND ".$prev ."buyer_bids.project_id='".$_REQUEST['id']."' group by ".$prev ."projects.id";
$dr=mysql_query("select " . $prev . "projects.*,".$prev ."buyer_bids.* from " . $prev . "projects,".$prev ."buyer_bids where ". $prev . "projects.id=".$prev ."buyer_bids.project_id  AND ".$prev ."buyer_bids.project_id='".$_REQUEST['id']."' group by ".$prev ."projects.id limit " . ($_GET[limit]-1)*20 . ",20");
$dd=@mysql_fetch_array($dr);
$j=0;$k=0;
while($d=@mysql_fetch_array($r)){

	if(!($j%2)){$class="even";}else{$class="odd";}
    $rr=mysql_query("select * from " . $prev . "user where user_id=" . $d[user_id]);
	$buyer=@mysql_result($rr,0,"username");
	if($d[status]=="cancelled" || $d[status]=="expired")
		{$cl="class='lnkred'";}
	elseif($d[status]=="complete")
		{$cl="class='lnkgreen'";}
	else{$cl="";}
	
	
	
    echo"<tr  class=" . $class . ">
		<td align=left><a href='edit_member.php?user_id=".$d[user_id]."' class=lnk>" . $buyer. "</a></td>
		<td align=center>" ."$".$dd['emp_charge']  . "</td>
		
		<td align=center>" .date('jS F, Y',$d[date2]). "</td>
		<td align=center " . $cl . ">" . $d[status] . "</td>";
		?>
		<td align=center>Bid Won<input type='checkbox' name='my_checkbox' id="stat" onclick="showInhome();" value="<?php echo $dd['chose']; ?>" <?php if($dd['chose']=='P'){ echo 'checked="checked"';}?> ></td>
		<input type="hidden" id="user_id" value=<?=$d[user_id]?>>
		<input type="hidden" id="project_id" value=<?=$dd[project_id]?>>
	    <?php
		$j++;
		}
?>
</tbody>
</table>
<?
if($total>20):
?>
  <table  width="100%"  border="0" align="center" HEIGHT=25 cellspacing="0" cellpadding="4" style="border:solid 1px <?=$dark?>">
  <tr bgcolor=<?=$light?>><td  align=center ><? echo paging($total,20,"$param")?></td></tr></table>
<?
endif;
?>
</form>
</table>
</td></tr>
</table>
<!--*********************main table end*************************-->
</td>
</tr>
</table>

<script>
/* function showInhome(id) {

	if(parseInt(id) > 0){
	
	
	   $.ajax({
	 	url: "<?=$vpath?>admin_new/updateads.php?id="+id
		}).done(function(data) {
		alert(data);
			$("#lstbx").html(data);
		});
	}
	else {
		alert('error');
	}
} */
var stat='';
	if ($("#stat").attr("checked")) {
			stat = 'P';
        }else{
		stat = 'N';
		}
function showInhome() {
	var id = $("#project_id").val();
	alert(id);
    var user_id = $("#user_id").val();
	alert(user_id);
        var url = "<?=$vpath?>admin_new/updateads.php?id="+id+'&user_id='+user_id+'&stat='+stat;;
        $.ajax({
            type: "POST",
            url: url,
            beforeSend: function() {
               //$("#feedloader").show();
            },
            success: function(dd) {
                //$("#feedloader").hide();
                $("#lstbx").html(dd);
				alert(dd);
				
            }

        });

        //window.location.href = url;
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
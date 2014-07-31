<?php 
include("includes/header_dashbord.php");include("includes/access.php");?>


<script>
function validateForm()
{
  if(document.getElementById("oldpass").value=="")
      {
        alert("please enter old password");
        document.getElementById("oldpass").focus();
        return false;
      }

 if(document.getElementById("newpass1").value=="")
       {
        alert("please enter new password");
        document.getElementById("newpass1").value="";
        document.getElementById("newpass1").focus();
        return false;
       }
       if(document.getElementById("confirmpass").value=="")
       {
        alert("please enter confirm password");
		document.getElementById("confirmpass").value="";
        document.getElementById("confirmpass").focus();
        return false;
       }
       if(document.getElementById("newpass1").value!=document.getElementById("confirmpass").value)
       {
        alert("password not match");
        document.getElementById("confirmpass").value="";
        document.getElementById("newpass1").value="";
        document.getElementById("confirmpass").focus();
        document.getElementById("newpass").focus();
        return false;
       }
   
}
</script>


<div class="main">
        <? include("includes/left_side.php"); ?>
       
        <section id="content">
            <div class="wrapper">
                <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="changepassword.php">Change Password</a></li>
                      
                    </ul>
                </div>
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Change Password</h1>
                    </div>
<?php  if($_SESSION['succ_msg']!=''){ ?>    		   <div class="alert alert-success">                                            <button type="button" class="close" data-dismiss="alert">&times;</button>                                            <strong><i class="icon24 i-checkmark-circle"></i> Well done!</strong> <?php echo $_SESSION['succ_msg'];$_SESSION['succ_msg']=''; ?>                                        </div>		   			<?php	    }   ?>      <?php  if($_SESSION['error_msg']!=''){ ?>    		   <div class="alert alert-error">                                            <button type="button" class="close" data-dismiss="alert">&times;</button>                                            <strong><i class="icon24 i-checkmark-circle"></i> </strong> <?php echo $_SESSION['error_msg'];$_SESSION['error_msg']=''; ?>                                        </div>		   			<?php	    }   ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>Change Password</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->								
                            
                                <div class="panel-body">
								
                                                                
                                <form method='post' name="validate" id="validate" action="pwd_change1.php" onsubmit="return validateForm()">

    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover" id="dataTable">
	<tr>
		<td valign="top" width="25%"><b>Old Password</b><font color="#CC3300">*</font></td>
		<td width="75%"><input name="oldpass" id="oldpass" type="password"  size="30"  style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
	</tr>
	
		<tr>
		<td valign="top" width="25%"><b>New Password</b><font color="#CC3300">*</font></td>
		<td width="75%"><input name="newpass" id="newpass1" type="password"  size="30"  style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
	</tr>
	
		<tr>
		<td valign="top" width="25%"><b>Confirm Password</b><font color="#CC3300">*</font></td>
		<td width="75%"><input  name="confirmpass" id="confirmpass" type="password"   size="30"  style="width:50%;" <?php if($_GET['id1']){print 'readonly';}?>></td>
	</tr>


	<tr><td colspan="2" height="20" align="center" >

		<input type="submit"  name='SBMT_REG' value='CHANGE' class="btn btn-primary"  >
        <button type="reset" class="btn btn-warning" name="">CANCEL</button>

     <button type="button" class="btn btn-inverse" onClick="javascript:window.location.href='changepassword.php'">BACK</button></td></tr>
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
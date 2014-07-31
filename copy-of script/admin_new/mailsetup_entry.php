<?php 

include("includes/header_dashbord.php");
include("includes/access.php");

$light2="#16559c";



if($_POST[SBMT_REG]):

   $r=mysql_query("update " . $prev . "mailsetup set 

   header=\"". htmlentities($_REQUEST[contents]) . "\",

   footer=\"". htmlentities($_REQUEST[contents1]) . "\" where id=$_GET[id]");

   $msg="Update Successful.";

endif;

    $r=mysql_query("select * from " . $prev . "mailsetup where id=$_GET[id]");

    $d=@mysql_fetch_array($r);

	$class="lnk";

    ?>



    <div class="main">
        <? include("includes/left_side.php"); ?>
        <!-- End #sidebar  -->
		
			

        
        <section id="content">
            <div class="wrapper">
          <div class="crumb">
                    <ul class="breadcrumb">
                      <li><a href="dashboard.php"><i class="icon16 i-home-4"></i>Home</a></li>
                      <li><a href="mailsetup.php">Mail Template Management</a></li>
                    
                    </ul>
                  
                </div>
                
                
                <div class="container-fluid">
                    <div id="heading" class="page-header">
                        <h1><i class="icon20 i-list-4"></i>Mail Template Management</h1>
                  
				   </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="icon"><i class="icon20 i-stack-checkmark"></i></div> 
                                    <h4>&nbsp;
									<a href='mailsetup.php' class="header">&nbsp;Mail Template List:</a>&nbsp;&nbsp;<?=$data[membership_name]?> <?=$msg?>
									
									</h4> 
                                    <a href="#" class="minimize"></a>
                                </div><!-- End .panel-heading -->
                            
                                <div class="panel-body">
  <form name=register method=post  onSubmit="javscript:return ValidSet(this);">

    <table width="100%" border="1" align="center" cellspacing="0" cellpadding="0" class="table">

    <tr bgcolor="#b7b5b5" class=header_tr><td height=25 >&nbsp;Email Setting for <?=$d['mail_type']?></td></tr>

    <tr><td align=center valign=top>

    <table border=0 cellpadding=4 cellspacing=1 width=100% bgcolor=<?=$light?>>

    <tr bgcolor=#ffffff class=lnk><td valign=top width=20%><b>Email Header :</b></td>

	<td ><?php

			require_once($fckapath."fckeditor.php") ;			

			$sBasePath =$fckbasepath;

			$oFCKeditor = new FCKeditor('contents') ;

			$oFCKeditor->BasePath = $sBasePath ;

			$oFCKeditor->ToolbarSet = "Default";

			$oFCKeditor->Width = "100%";

			$oFCKeditor->Height = "400";

			$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/' ;

			

			$oFCKeditor->Value =stripslashes(html_entity_decode($d[header]));

			$oFCKeditor->Create() ;

			?>

<br>

    Description: The contents of the header which will be placed on the top of all emails.</td></tr>

    <tr bgcolor="#ffffff" class=lnk><td valign=top><b>Email Footer :</b></td>

	<td><?php

			require_once($fckapath."fckeditor.php") ;			

			$sBasePath =$fckbasepath;

			$oFCKeditor = new FCKeditor('contents1') ;

			$oFCKeditor->BasePath = $sBasePath ;

			$oFCKeditor->ToolbarSet = "Default";

			$oFCKeditor->Width = "100%";

			$oFCKeditor->Height = "400";

			$oFCKeditor->Config['SkinPath'] = $sBasePath . 'editor/skins/silver/' ;

			

			$oFCKeditor->Value =stripslashes(html_entity_decode($d[footer]));

			$oFCKeditor->Create() ;

			?><br>

    Description: The contents of the footer which will be placed on the bottom of all emails.<br></td></tr>



    <tr bgcolor=<?=$light?>><td></td><td  height="25" align="left">

      <input type=submit class="button" name='SBMT_REG' value='Update'>
	  
	  &nbsp;

	      <input type="button"  class="button" value="Back" onClick="javascript:window.location.href='mailsetup.php'">

    </td></tr>

   

    </table></td></tr>

	

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
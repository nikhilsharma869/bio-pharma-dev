<?php
require_once("configs/path.php");
//if(!$link){header("Location: ./index.php"); exit();}
?>
<div style='padding-left:10px;padding-right:10px'>
<?
if((!empty($_REQUEST['v_key'])) && (!empty($_REQUEST['user'])))
{
	$user=txt_value($_REQUEST['user']);
	$temp="select * from ".$prev."user where v_key='".txt_value($_REQUEST['v_key'])."' and status='Y' and v_stat='Y'";
	$r=mysql_query("select * from ".$prev."user where v_key='".txt_value($_REQUEST['v_key'])."' and status='Y' and v_stat='Y'");
	
	//echo mysql_num_rows($r);
	
	/*if(@mysql_num_rows($r)>0)
	{*/
		$d=@mysql_fetch_array($r);

		if($d['v_stat']=="Y")
		{
		?>
			<!--<div>
			<h2>Your email address already verified</h2>
			<p>
			<h2 style="color:#FF0000">Please wait this page will be redirected to login page.</h2>		
			</p>
			<p align="center"><img src="images/rotating_arrow.gif" alt="Loading" border="0" align="middle" /></p>
			</div>-->
			
			<?php
			$r2=mysql_query("select * from  ". $prev . "user where  (username=\"" . $d['username'] . "\" or email=\"".$d['username'] . "\") and  strcmp(\"" . $d['password']  . "\", password)=0 and status='Y'");
		//echo "<br>";
		//echo "select * from  ". $prev . "user where  (username=\"" . $d['username'] . "\" or email=\"".$d['username'] . "\") and  strcmp(\"" . $d['password']  . "\", password)=0 and status='Y'";
		
			$n=@mysql_num_rows($r2);

				if($n)
			
				{	
			
					session_regenerate_id();
			
					$fname=txt_value_output(@mysql_result($r2,0,"fname"));
			
					$lname=txt_value_output(@mysql_result($r2,0,"lname"));
			
					$_SESSION['fullname'] = $fname.' '.$lname;					
			
					$_SESSION['user_id']	=@mysql_result($r2,0,"user_id");
			
					$_SESSION['username']	=txt_value_output(@mysql_result($r2,0,"username"));
			
					$_SESSION['email']		=txt_value_output(@mysql_result($r2,0,"email"));
			
					$_SESSION['user_type']	=txt_value_output(@mysql_result($r2,0,"user_type"));
			
					$_SESSION['ldate']	    =@mysql_result($r2,0,"ldate");
			
					$_SESSION['gold_member']	    =@mysql_result($r2,0,"gold_member");
			
					$_SESSION['ip']	        =@mysql_result($r2,0,"ip");
			
					$user_type              =txt_value_output(@mysql_result($r2,0,"user_type"));
			
					$profile                =txt_value_output(@mysql_result($r2,0,"profile"));		
			
					
			
					$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);													
			
					if($user_type=="W" || $user_type=="B")
					{
						$n=@mysql_num_rows(mysql_query("select user_id from ".$prev."user_cats  where user_id=".$_SESSION['user_id']." limit 1"));	   
			
						if(!$n || !$profile){ header('Location: dashboard.php');} 
					}	
			
					if($_REQUEST['referer'])
					{
					   redirect($vpath.txt_value($_REQUEST['referer']));
					}
					else
					{
					   header('Location: dashboard.php');
					}
			
				}	
				else
				{
					$msg="<h3 style='color:red;'>".$lang['PLEASE_ENTER_VALID_EMAIL']."</h3>";
				}
	
	
		}
		else
		{
		//echo "aa";
			//echo $temp="update ".$prev."user set status='Y', v_stat='Y' where user_id=".$user;
			//echo "update ".$prev."user set status='Y', v_stat='Y' where user_id='".$_REQUEST['user']."'";
			$r3=mysql_query("update ".$prev."user set status='Y', v_stat='Y' where user_id=".$_REQUEST['user']);
			$r=mysql_query("select * from ".$prev."user where v_key='".txt_value($_REQUEST['v_key'])."' and status='Y' and v_stat='Y'");
	
	//echo mysql_num_rows($r);
	
	/*if(@mysql_num_rows($r)>0)
	{*/
		$d=@mysql_fetch_array($r);
			?>
			<!--<div>
			<h2>Your email address verified</h2>
			<p>
			<h2 style="color:#FF0000">Please wait this page will be redirected to login page.</h2>		
			</p>
			<p align="center"><img src="images/rotating_arrow.gif" alt="Loading" border="0" align="middle" /></p>
			</div>-->
			
			
			<?php
			$r2=mysql_query("select * from  ". $prev . "user where  (username=\"" . $d['username'] . "\" or email=\"".$d['username'] . "\") and  strcmp(\"" . $d['password']  . "\", password)=0 and status='Y'");
		
		
			$n=@mysql_num_rows($r2);

				if($n)
			
				{	
			
					session_regenerate_id();
			
					$fname=txt_value_output(@mysql_result($r2,0,"fname"));
			
					$lname=txt_value_output(@mysql_result($r2,0,"lname"));
			
					$_SESSION['fullname'] = $fname.' '.$lname;					
			
					$_SESSION['user_id']	=@mysql_result($r2,0,"user_id");
			
					$_SESSION['username']	=txt_value_output(@mysql_result($r2,0,"username"));
			
					$_SESSION['email']		=txt_value_output(@mysql_result($r2,0,"email"));
			
					$_SESSION['user_type']	=txt_value_output(@mysql_result($r2,0,"user_type"));
			
					$_SESSION['ldate']	    =@mysql_result($r2,0,"ldate");
			
					$_SESSION['gold_member']	    =@mysql_result($r2,0,"gold_member");
			
					$_SESSION['ip']	        =@mysql_result($r2,0,"ip");
			
					$user_type              =txt_value_output(@mysql_result($r2,0,"user_type"));
			
					$profile                =txt_value_output(@mysql_result($r2,0,"profile"));		
			
					
			
					$r3=mysql_query("update ".$prev."user set ip='" . $_SERVER['REMOTE_ADDR'] . "', ldate=NOW() where user_id=".$_SESSION['user_id']);													
			
					if($user_type=="W" || $user_type=="B")
					{
						$n=@mysql_num_rows(mysql_query("select user_id from ".$prev."user_cats  where user_id=".$_SESSION['user_id']." limit 1"));	   
			
						if(!$n || !$profile){ header('Location: dashboard.php');} 
					}	
			
					if($_REQUEST['referer'])
					{
					   redirect($vpath.txt_value($_REQUEST['referer']));
					}
					else
					{
					   header('Location: dashboard.php');
					}
			
				}	
				else
				{
					$msg="<h3 style='color:red;'>".$lang['PLEASE_ENTER_VALID_EMAIL']."</h3>";
				}
	
		
		}
		
/*	}*/
	/*else
	{
	?>
	<div>
		<h2>Wrong key</h2>
		<p>
		<h2 style="color:#FF0000">Please wait this page will be redirected to login page.</h2>
		</p>
		<p align="center"><img src="images/rotating_arrow.gif" alt="Loading" border="0" align="middle" /></p>
		
	</div>
	<?php
	/*}*/
}
else
{
?>
<div>
		<h2><?=$lang['WRNG_KY']?></h2>
		<p>
		<h2 style="color:#FF0000"><?=$lang['WAIT_RDIRCT']?></h2>
		<img src="images/rotating_arrow.gif" align="Loading" border="0" />
		</p>
</div>
</div>
<?php

//require_once("includes/right.php");
pageRedirect($vpath."login.php",'refresh',5);
}
?>
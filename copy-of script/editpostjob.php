<?php 
	include "configs/path.php"; 
	include("country.php");
	session_start();

?>
<?php
$edit=$_REQUEST['edit'];
	if(count($_REQUEST[select])):
	    $attach="";
		for($i=0;$i<count($_REQUEST[select]);$i++):
		   $attach.= $_REQUEST[select][$i] . ",";
		endfor;
		$rud=substr($attach,0,-1);
	endif;
	$secondsPerDay = ((24 * 60) * 60);
	$ttoy = time();
	$tttoy = genDate(time());
	$expires=$ttoy+($secondsPerDay*$_REQUEST[cdays]);
	$txt="";
	for($i=0;$i<$_REQUEST[num];$i++):
	    $catsid="cat_ids" . $i;
		if($_REQUEST[$catsid]):
			$txt.=$_REQUEST[$catsid] . ",";
			mysql_query("insert into " . $prev . "projects_cats set id=" . $ttoy . ",cat_id=" . $_REQUEST[$catsid]);
		endif;
	endfor;
	if($txt){$txt=substr($txt,0,-1);}

////////////////////////////////////////////////// start  insert project ///////////////////////////////////////////////

	$select_project="select * from " . $prev . "projects where id='".$_REQUEST['edit']."'";
	$rec_project=mysql_query($select_project);
	$row_project=mysql_fetch_array($rec_project);


	if($rud!="")
	{
		if($row_project['attachment']!="")
		{
			$att=$row_project['attachment'].','.$rud;
		}
		else
		{
			$att=$rud;
		}
	}
	else
	{
		$att=$row_project['attachment'];
	}
	
	
if($_REQUEST[info]!='' || $att!=''){

	$sql_inser_project=mysql_query("insert into " . $prev . "projects_additional set project_id='".$_REQUEST[edit]."',info='".mysql_real_escape_string($_REQUEST[info])."',attached_file='".$att."' ,`date`=now(),user_id='".$_SESSION['user_id']."'");
	

	if($sql_inser_project)
	{	
		$bidder_query="select u.fname,u.lname,u.email from " . $prev . "user u inner join " . $prev . "buyer_bids b on u.user_id=b.bidder_id where project_id = ".$_REQUEST['edit'];
		$bidder_res=mysql_query($bidder_query);
		$query="select u.fname,u.lname from " . $prev . "user u inner join " . $prev . "projects p on u.user_id=p.user_id where id = ".$_REQUEST['edit'];
		$res=mysql_query($query);
		$info_bid=mysql_fetch_array($res);
		$subj=$lang['PROJECT_CHANGE_NOTIFICATION'];
		while($bidders=mysql_fetch_array($bidder_res))
		{
			$fname=$bidders['fname'];
			$lname=$bidders['lname'];
			$to=$bidders['email'];
			
			$mail_msg=$info_bid[fname].' '.$info_bid[lname].$lang['PROJECT_CHANGE_NOTIFICATION_BODY'].$_REQUEST[project].' .<br>'.$lang['PROJECT_CHANGE_NOTIFICATION_BODY1'].'<br>
		<a href="'.$vpath.'project/' . $_REQUEST['edit']. '">' . $d[project] . '</a>';
			$body=$mail_msg;
			$mail_type = 'edit_postproject';
			genMailing($to, $subj, $body, $from = '', $reply = true, $mail_type,$fname,$lname);
		}
	
				$edit=$_REQUEST['edit'];
				$_SESSION['succ']=$lang['DATA_UPDATED'];
				//$msg='* Data updated successfully..';
				header("location:postjob.php?edit=".$edit);			
	}
	else
	{
		$_SESSION['error']=$lang['PROBLEM_STORE'];
	}
	
}else{
$_SESSION['error']=$lang['NOT_UPDATE'];
}
	
header("location:postjob.php?edit=".$edit);	
	
//}	

?>
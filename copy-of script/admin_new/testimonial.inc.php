<?php
$parent_page_name = 'testimonial_list.php';
$back_page_name = $parent_page_name;
if( isset( $_SERVER['HTTP_REFERER'] ) && !empty( $_SERVER['HTTP_REFERER'] ) && substr_count( $_SERVER['HTTP_REFERER'], $parent_page_name ) ) {
	$back_page_name = $_SERVER['HTTP_REFERER'];
}

$page_header_link = '<a href="'.$parent_page_name.'" class="header">Testimonial Management</a>';
$show_parent_page_details = false;
if( substr_count(basename( $_SERVER['REQUEST_URI'] ), $parent_page_name) ) {
	$page_header_link = strip_tags( $page_header_link );
	$show_parent_page_details = true;
}

$no_delete_ids = array();
if($_GET['del'] && !in_array($_GET['id'], $no_delete_ids) ) {
	$q = mysql_query("DELETE FROM " . $prev . "testimonial WHERE testi_id = " . $_GET['id']);

	$_SESSION['succ_msg'] = '<span class="success"><b>Testimonial Deleted successfully.</b></span>';
	pageRedirect( $back_page_name );
}
?>

<script type="text/javascript">
function delConfirm(arg) {
	if(confirm('Are you sure want to delete this testimonial ?')) {
		window.location.href = '<?php echo basename( $_SERVER['PHP_SELF'] )."?id="; ?>' + arg + '&del=1';
	}
}
</script>

<form method="post" action="<?php echo $parent_page_name; ?>" name="frmContents" id="frmContents">
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="4" bgcolor="<?=$light?>" class="table">
  <tr bgcolor="<?=$light?>">
	<td height="25" class="header"><?php echo $page_header_link; ?>&nbsp;
	</td>
	<td width="45%" bgcolor="<?=$light?>" align="right"><table border="0" cellpadding="0" cellspacing="0">
	  <tr class="lnk">
		<td align="right"><select name="param" size="1" class="lnk">
			<option value='fullname'<?php if($_REQUEST['param'] == "fullname") echo ' selected="selected"';?>>Fullname</option>
		</select></td>
		<td>&nbsp;==&nbsp;
		<input type="text" size="8" name="search" id="search" class="lnk" value="<?php echo $_REQUEST['search']; ?>" />&nbsp;
		<input type="submit" class="button" name='SBMT_SEARCH' value='Search &raquo;' /></td>
	  </tr>
	</table></td>
  </tr>
</table>
</form>

<?php
if( $show_parent_page_details ) {
?>
<p class="lnk" align="right">
	<?php echo $main_icon_active_img; ?>&nbsp;= Active
	&nbsp;|&nbsp;
	<?php echo $main_icon_inactive_img; ?>&nbsp;= Inactive
	&nbsp;|&nbsp;
	<?php echo $main_icon_edit_img; ?>&nbsp;= Edit
	&nbsp;|&nbsp;
	<?php echo $main_icon_del_img; ?>&nbsp;= Delete
</p>
<?php } else { ?>
<br />
<?php
	if( isset( $_GET['id'] ) && !empty( $_GET['id'] ) ) {
		$id = $_GET['id'];
?>
<table cellpadding="4" border="0">
  <tr>
	<td class="lnk_header_selected">Edit Page</td>
	<?php if( !in_array($id, $no_delete_ids) ) { ?>
	<td><a onClick="javascript:delConfirm('<?php echo $id; ?>');" href="javascript:void(0);" class="lnk_header">Delete</a></td>
	<?php } ?>
  </tr>
</table>
<?php
	}
}

if( isset( $_SESSION['succ_msg'] ) && !empty( $_SESSION['succ_msg'] ) ) {
	echo '<p align="center">'.$_SESSION['succ_msg'].'</p>';
	unset($_SESSION['succ_msg']);
}
?>
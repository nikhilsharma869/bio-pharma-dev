<script type="text/javascript" src="mymodal/jquery-latest.pack.js"></script>
<script type="text/javascript" src="highslide/highslide-with-html.js"></script>
<link rel="stylesheet" type="text/css" href="highslide/highslide.css" />
<script type="text/javascript">
hs.graphicsDir = 'highslide/graphics/';
hs.outlineType = 'rounded-white';
hs.wrapperClassName = 'draggable-header';
hs.creditsText = '<i></i>';
minWidth = 450;
</script>

<div class="top_link">
<?php
if($_SESSION['user_id'])
{
?>
<ul>
<li><a href="dashboard.php"><?=$lang['MY_ACCOUNT']?></a></li>
<li><a href="logout.php"><?=$lang['LOG_OUT']?></a></li>
</ul>
<?php
}
else
{
?>
<ul>
<li><a href="singup.php"><?=$lang['SIGN_UP']?>&nbsp;!</a></li>
<li><a href="login.php"><?=$lang['USER_LOGIN']?></a></li>
</ul>
<?php
}
?>
</div>
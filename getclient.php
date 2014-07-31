<? session_start();
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
?>

		<script type="text/javascript" src="<?=bloginfo("template_url")?>/js/jquery.elastislide.js"></script>
<div id="client_slide2" class="slider_div_client"  >
						 <ul id="carousel" class="elastislide-list">
						 <? 
						 if($_POST['id']){
						 $cn="client".$_POST['id'];
						 }
						
			$pf_cat = mysql_fetch_assoc(mysql_query("SELECT $cn from ".$wpdb->prefix."category where cat_id='".$_POST['cat_id']."'"));	
if($pf_cat[$cn]){

		
						 $pfs = mysql_query("SELECT client_id,client_pic,client_name from ".$wpdb->prefix."client where status='Y' and client_id in ('".$pf_cat[$cn]."') order by client_id asc");
						while($pfs_res = @mysql_fetch_assoc($pfs)){
						
						?>
					<li><a href="javascript:void(0)" onclick="getcliecntcontent(<?=$pfs_res[client_id]?>)" title="<?=$pfs_res[client_name]?>" onmouseover="getname('<?=$pfs_res[client_name]?>')"  onmouseout="getname('')"><img src="<?=$pfs_res[client_pic]?>" alt="image01" title="<?=$pfs_res[client_name]?>" height=57/></a></li>
					
					<? }
					}?>
						
				</ul>
				<br>
                       <div id="clientname" style="height:20px"> </div>
						</div>
						<script type="text/javascript">
			
			$( '#carousel' ).elastislide();
				
			
			
		</script>
                         
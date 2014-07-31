<?php
function is_login($tken){
		$r=false;
		$p =array_decode($tken);	
		$DB=rqDB();
		$sq="SELECT * FROM  `admin_user` WHERE  `user_un` =  '".$p->user_un."' AND  `user_pass` =  '".$p->user_pass."'";
		$dr=$DB->select($sq);		
		if(isset($dr[0][0])){
			$r=true;
		}
		return $r;
	}
	
	function is_login_client($tken){
		$r=false;
		$p =array_decode($tken);	
		$DB=rqDB();
		$sq="SELECT * FROM  `user` WHERE `user_email`='".$p->useremail."' AND  `user_password`='".$p->password."'";
		$dr=$DB->select($sq);		
		if(isset($dr[0][0])){
			$r=true;
		}
		return $r;
	}
	
	function rq_login(){
		$option = array('msg'=>'Token Invalid !','url'=>_url());
		$url=WEB.ADMINFOLDER."/ap_login.php?token=".array_encode($option);
		_e($url);
		_gourl($url);
		die();	
	}
	
	function ck_login($R){
		$ISV='false';
		$MSG='';
		$URL="ap_dashboard.php";
		if(isset($R['token'])){
			$token = array_decode($R['token']);
			if(isset($token->url)){	
				$URL=$token->url;
			}
		}	
		$un=isset($R['aduser'])?$R['aduser']:'';
		$up=isset($R['adpass'])?$R['adpass']:'';
		if($un !="" && $up !=""){
			$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `admin_user` WHERE  `user_un` =  '".$un."' AND  `user_pass` =  '".$up."'");		
			if(isset($r[0][0])){
				$uinfo=array_encode($r[0]);
				setcookie("utoken",$uinfo,time()+"10800");
				$MSG="Login please wait.";
				$ISV="true";
				
			}else{
				$MSG='Invalid User Name or Password !'; 
			}
		}else{
				$MSG='Enter User Name / Password !'; 
		}			
	return '{"ISV":"'.$ISV.'","MSG":"'.$MSG.'","URL":"'.$URL.'"}';
		
}
	function logout_url(){
		$option = array('msg'=>'Successfully Logout.','logout'=>'1');
		$url=WEB.ADMINFOLDER."/ap_login.php?token=".array_encode($option);
		return $url;
	}
	function user_info($v){
		return array_decode($v);
	}
	
function get_admin_users($v=""){
	$DB=rqDB();
	$r=$DB->select('SELECT * FROM `admin_user` WHERE 1 '.$v );		
	if(!isset($r[0][0])){
		$r="";
	}else{
		$r=$r ;	
	}
	return $r;
 }
 
 	function get_user($v=""){
		$DB=rqDB();
		$r=$DB->select('SELECT * FROM `user` Where 1 '.$v );		
		if(!isset($r[0][0])){
			$r="";
		}else{
			$r=$r ;	
		}
		return $r;
	}
	
	
	function get_Category(){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `categories_description` ");		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_shipping_charge($s=""){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `shipping_charge` ".$s);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_Mainbanar($s){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `cms_mainbanar` Where 0=0 ".$s);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}

	function get_ltproduct($s){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `cms_ltporduct` Where 0=0 ".$s);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_options(){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `products_options` ");		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_page($id){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `mm_page` Where `page_id`='".$id."'");		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_options_value($s){
		$DB=rqDB();
		$sql="";
		if($s!=""){
			$sql="SELECT * FROM  `products_options_values` Where `products_options_id` in(".$s.");";
		}else{
			$sql="SELECT * FROM  `products_options_values` ";
			}
			$r=$DB->select($sql);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	function get_quantity_value(){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM  `products_quantity` ");		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	function get_product_item($s=""){
		$DB=rqDB();
			$r=$DB->select("SELECT * FROM (SELECT * FROM `products_item`,`categories_description`  WHERE `products_item`.`cid`=`categories_description`.`categories_id`) AS `td` ".$s);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_template($s=""){
		$DB=rqDB();
		$sql="SELECT * FROM  `item_template` ,  `products_item` WHERE  `item_template`.`item_id` =  `products_item`.`item_id` 	".$s;
			$r=$DB->select($sql);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
		
	}
	
	function get_price($s){
		$sql="SELECT `pricing`.*,`products_quantity`.`products_quantity_value`,`products_options`.`products_options_name`,`products_options_values`.`products_options_values_name` 
		FROM `pricing`,`products_quantity`,`products_options`,`products_options_values` 
		WHERE `pricing`.`quantity_id`=`products_quantity`.`products_quantity_id` 
		AND `products_options`.`products_options_id`=`pricing`.`option_id` 
		AND `products_options_values`.`products_options_values_id`= `pricing`.`option_value_id` ".$s	;
		$DB=rqDB();
			$r=$DB->select($sql);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_temord($s){
		$sql="SELECT * FROM  `temp_order`,`item_template` ,  `products_item` WHERE  `item_template`.`item_id` =  `products_item`.`item_id`  and `temp_order`.`tid`=`item_template`.`template_id` ".$s	;
		$DB=rqDB();
			$r=$DB->select($sql);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	function get_ord($s){
		$sql="SELECT *,(SELECT Count( price ) FROM  `tm_invoice` WHERE   `tm_invoice`.`invoice_id` =`invoice`.`invoice_id`) as `noi`,(SELECT SUM( price ) FROM  `tm_invoice` WHERE   `tm_invoice`.`invoice_id` =`invoice`.`invoice_id`)as `total` FROM  `invoice` left join   `user` on `invoice`.`invoice_uid`= `user`.`user_id`  Where 0=0  ".$s	;
		$DB=rqDB();
			$r=$DB->select($sql);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	function get_ord_sub($s){
		$sql="	SELECT *,`temp_order`.`tid` as `O_tid` FROM `v_tm_invoice` LEFT JOIN `temp_order` ON `v_tm_invoice`.`to_id`=`temp_order`.`toid` Where 0=0 ".$s;
		$DB=rqDB();
			$r=$DB->select($sql);		
			if(!isset($r[0][0])){
				$r="";
			}else{
				$r=$r ;	
			}
			return $r;
	}
	
	
	function invoice_pdf($id){	
					$sr=" and invoice_id=".$id;
					$ORD_LIST=get_ord($sr);
					$ORD=$ORD_LIST[0];
 
$html='<div style="font-family:Arial; font-size: 12px; "><table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-family:Arial; font-size: 13px; ">
    	<tr>
        	<td width="50%"></td>
            <td width="50%"></td>
        </tr>
        <tr>
        	<td colspan="2" style="text-align:center">Print Order: #'.$ORD['invoice_id'].'</td>
        </tr>
        <tr>
        	<td colspan="2" style="padding-bottom:20px"><img src="'.WEB.'images/logo.png"  style="width:150px!important" /></td>
        </tr>
        <tr>
        	<td colspan="2" style="font-size:16px; font-weight:bold">Order: #'.$ORD['invoice_id'].'</td>
        </tr>
        <tr>
        	<td colspan="2">Order Date: '.$ORD['invoice_date'].'</td>
        </tr>
        <tr>
        	<td colspan="2" style="padding-bottom:16px"></td>
        </tr>
        <tr>
        	<td><b>Shipping Address</b></td>
            <td><b>Billing Address</b></td>
        </tr>
		<tr>';
		$sphtc=	'<td>'.$ORD['invoice_name'].'<br/>'.$ORD['invoice_lnd'].'<br/>'.$ORD['invoice_address'].' ,'.$ORD['invoice_city'].' ,'.$ORD['invoice_pin'].'<br/>T: '.$ORD['invoice_ph'].'</td>
		';
		$html=$html.$sphtc;
		if($ORD['invoice_uid']=='-1'){
			$html=$html.$sphtc;
		}else{
			$html=$html.	'<td>'.$ORD['user_name'].'<br/>'.$ORD['user_landmark'].'<br/>'.$ORD['user_address'].' ,'.$ORD['user_city'].' ,'.$ORD['user_pincode'].'<br/>T: '.$ORD['user_phone'].'</td>';
		}
		$html=$html.'
		</tr>
		<tr>
        	<td colspan="2" style="padding-bottom:20px"></td>
        </tr>
        <tr>
        	<td><b>Shipping Method</b></td>
            <td><b>Payment Method</b></td>
        </tr>
		<tr><td></td><td>Cash on Delivery</td></tr>
        <tr>
        	<td colspan="2" style="padding-top:20px"><b>Item Order</b></td>            
        </tr>
		<tr>
        	<td colspan="2">
			<table   style="border:1px solid #ccc;font-family:Arial; font-size: 13px;" cellspacing="0" cellpadding="0" width="100%" >
				<tr >
					<td style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px"><b>Product Name</b></td>
					<td style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px"><b>SKU</b></td>
					<td style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px"><b>Price</b></td>
					<td style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px"><b>Qty</b></td>
					<td style="border-bottom:1px solid #ccc;padding:4px"><b>Subtotal</b></td>
				</tr>';
				
  					$subT=0;
					$STAT_LIST=get_ord_sub(" and  `invoice_id`=".$ORD['invoice_id']);
					if($STAT_LIST!=""){
					foreach($STAT_LIST as $STR){
						
                   $html=$html.'<tr>     
                            <td style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px"><b>'.$STR['template_name'].'</b><br/>';
					
					$rd=(array)json_decode($STR['option']);
					$qid= substr($rd['qtyid'],0,strrpos($rd['qtyid'],"$"));
					$optt="-1";
					foreach($rd as $okey => $od){
						$pos = strrpos($okey, "d_");
						if($pos!=false && $od>0){
							$optt=$optt.",".$od;
						}
							
					}
					$ST=get_price(" And `quantity_id`='".$qid."'   AND `item_id` in(SELECT `item_id`  FROM `item_template` WHERE `template_id` = ".$rd['tid'].") AND `option_value_id` in(".$optt.")");
					if(isset($ST[0][0])){
						foreach($ST as $SR){
						 $html=$html.'<br/><span><b>'.$SR['products_options_name'].'</b><br/>'.$SR['products_options_values_name'].'</span>';
						}
					}
  					$html=$html.'</td>
						 <td  style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px">'.$STR['item_name'].'</td>
						 <td  style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px">Rs '.($STR['price']/$rd['qty']).'</td>
						 <td  style="border-right:1px solid #ccc;border-bottom:1px solid #ccc;padding:4px">'.$rd['qty'].'</td>
						 <td  style="border-bottom:1px solid #ccc;padding:4px">Rs '.$STR['price'].'</td>
						 </tr>';
					$subT=$subT+($STR['price']);
					}}
					$html=$html.'
					<tr><td  colspan="4" style="text-align: right;padding:4px ">Sub Total : </td>
					<td>Rs '.$subT.'</td>
					</tr>';
					$html=$html.'
					<tr><td  colspan="4" style="text-align: right;padding:4px">Shipping Charges : </td>
					<td>Rs '.$ORD['sp_rs'].'</td>
					</tr>';
					$html=$html.'
					<tr><td  colspan="4" style="text-align: right;padding:4px"><b>Grand Total :</b></td>
					<td><b>Rs '.($ORD['total']+$ORD['sp_rs']).'</b></td>
					</tr>';
				
			$html=$html.'</table>
			</td>            
        </tr>
    </table></div>';
 return $html;
}
?>
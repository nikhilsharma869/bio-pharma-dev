<?php

/**
 * @package SiteWit
 */

/*
Plugin Name: SiteWit Website Analytics and Search Engine Marketing
Plugin URI: http://www.sitewit.com
Description: SiteWit is a DIY online marketing platform. Start with FREE website analytics and SEO keyword ranking. Then utilize SiteWit’s step by step set up to launch search campaigns across Google, Bing and Yahoo. Maximize your search budgets and advertise online with confidence by leveraging SiteWit’s automated management and optimization tools.
Version: 0.5
Author: SiteWit
Author URI: http://www.sitewit.com
*/
	
	$API_TOKEN_OPTION_NAME = 'sw_api_token';
	$API_TOKEN_OPTION_DISPLAY_NAME = 'SiteWit API Token';
	$USER_TOKEN_OPTION_NAME = 'sw_user_token';
	$USER_TOKEN_OPTION_DISPLAY_NAME = 'SiteWit User Token';
	$TRACKING_CODE_OPTION_NAME = 'sw_tracking_code';
	$MASTERID_OPTION_NAME = 'sw_master_id';
	$AFFILIATE_ID_OPTION_NAME = 'sw_affiliate';
	
	$AFFILIATE_ID = ''; 

	sw_plugin_activate();

	 $api_token = NULL;
	 $user_token	= NULL;
	 $tracking_code = NULL;

	 $mnow = date('omd');
	 $mbefore = date('omd', strtotime('-1 month'));
	 $mliteral = date('F n, Y', strtotime('-1 month')) . ' - ' . date('F n, Y');

	 if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST["sw_source"] != null){
		$api_token = $_POST[$API_TOKEN_OPTION_NAME];
		$user_token = $_POST[$USER_TOKEN_OPTION_NAME];
		$action = $_POST["submit"];

		if($api_token != NULL && $user_token != NULL && ($action=="Save Tokens" || $action == "Link my SiteWit account" )){
			update_option($API_TOKEN_OPTION_NAME, $api_token);
			update_option($USER_TOKEN_OPTION_NAME, $user_token);
			$tracking_code = sw_get_tracking_code($api_token, $user_token);
		}else if($action=="Remove Tokens"){
			$api_token = null;
			$user_token = null;
			update_option($API_TOKEN_OPTION_NAME, "");
			update_option($USER_TOKEN_OPTION_NAME, "");
			$tracking_code = null;
		}

		update_option($TRACKING_CODE_OPTION_NAME, $tracking_code);



		//display success message when both token are entered and API returns results		/
		if($api_token != NULL && $user_token != NULL && $tracking_code != NULL){

			if($action == "Save Settings"){
				add_action('admin_notices', 'sw_api_success_notice');
			}else if($action == "Link my SiteWit account"){
				//display update confirmation
				add_action('admin_notices', 'sw_update_notice');
			}
		}

	 }
	 else{
		 
		 $api_token = get_option($API_TOKEN_OPTION_NAME);
		 $user_token = get_option($USER_TOKEN_OPTION_NAME);
		 $tracking_code = get_option($TRACKING_CODE_OPTION_NAME);
		 
	 }

	 //init the configuration page
	 add_action('admin_menu','sw_add_config_page');

	 //display the instructional message if one of the tokens is still missing
	 if($api_token == NULL || $user_token == NULL){
		 add_action('admin_notices', 'sw_notice');
	 }


	 if($api_token != NULL && $user_token != NULL){
		 //display warning message if both tokens are entered but API returns no result
		 if($tracking_code == NULL){
			add_action('admin_notices', 'sw_api_error_notice');
		 }
		 //hook onto Gravity forms if the the Gravity forms plugin is installed
		 add_action("gform_post_submission", "sw_gravity_form_submission", 10, 2);
	 }

	 //performed each time any Gravity form is submitted. The title of the form is used to create a new goal and register a conversion
	 //if the goal already exists, the existing goal is taken and converted
	 function sw_gravity_form_submission($entry, $form){
		 $api_token = get_option('sw_api_token');
		 $user_token = get_option('sw_user_token');
		 $form_title = $form["title"];
		 $goal = sw_get_goal($api_token, $user_token, $form_title);
		 if($goal == null){
			 //a new goal has to be created
			 //else an existing goal can be used for conversion
			 $goal = sw_create_goal($api_token, $user_token, $form_title);
		 }

		 ?>
		 <script type="text/javascript">
			var loc = (("https:" == document.location.protocol) ? "https://analytics." : "http://analytics.");
			document.write(unescape("%3Cscript src='" + loc + "sitewit.com/sw.js' type='text/javascript'%3E%3C/script%3E"));
		</script>
		 <script type="text/javascript">
			var sw = new _sw_analytics();
			sw.id= "<?php echo get_option('sw_master_id'); ?>";
			sw.set_goal(<?php echo $goal->GoalNumber; ?>);
			sw.register_page_view();
		 </script>

		 <?php
	 }

	 function sw_get_goal($api_token, $user_token, $form_title){
		 $res = null;
		 $params = array('AccountToken' => $api_token, 'UserToken' => $user_token, 'IncludeJSCode' => false);
		 $client	= new SoapClient('https://api.sitewit.com/account/accountinfo.asmx?WSDL');
		 $response = $client->GetGoals($params);
		 $goals = $response->GetGoalsResult->Goals->Goal;
		 if(is_array($goals)){
			foreach($goals as $goal){
					$goal_name = $goal->GoalName;
					if($form_title == $goal_name){
						$res = $goal;
					}
		 		}
		 }
		 else{
			$goal_name = $goals->GoalName;
			 if($form_title == $goal_name){
				$res = $goals;
			}
		 }
		 return $res;
	 }

	 function sw_create_goal($api_token, $user_token, $form_title){
		 $res = null;
		 $params = array('AccountToken' => $api_token, 'UserToken' => $user_token, 'IncludeJSCode' => false, 'GoalName' => $form_title, 'GoalRevenue' => 10.00, 'PageURL' => '', 'GoalType' => 'LeadGeneration', 'IncludeJSCode' => false);
		 $client	= new SoapClient('https://api.sitewit.com/account/accountinfo.asmx?WSDL');
		 $response = $client->CreateGoal($params);
		 $res = $response->CreateGoalResult;
		 return $res;
	 }


	 function sw_get_tracking_code($api_token, $user_token){
		 
		 $tracking_code = null;
		 
		 $getaccount_parameters = array("AccountToken" => $api_token, "UserToken" => $user_token);
		 if(PHP_MAJOR_VERSION >= 5){
			try{
				$client	= new SoapClient('https://api.sitewit.com/account/accountinfo.asmx?WSDL');
				$response = $client->GetAccountProperties($getaccount_parameters);
				$account_number = $response->GetAccountPropertiesResult->AccountNumber;
				update_option('sw_master_id', $account_number);
				$tracking_code = '<script type="text/javascript">var loc = (("https:" == document.location.protocol) ? "https://analytics." : "http://analytics.");document.write(unescape("%3Cscript src=\'" + loc + "sitewit.com/sw.js\' type=\'text/javascript\'%3E%3C/script%3E"));</script><script type="text/javascript">var sw = new _sw_analytics();sw.id="'.$account_number.'";sw.register_page_view();</script>';
			}
			catch(SoapFault $fault){
				//nothing left to do
			}
		 }
		
		 return $tracking_code;

	 }


	//SiteWit configuration page definition. Goes under the Plugins top menu
	function sw_config_page(){
		global $AFFILIATE_ID_OPTION_NAME;
		$SETUP_FINISHED = false;
	?>

	 <style type="text/css">

		.swbutton
		{
			font-family:helvetica, Arial, Verdana;
			text-decoration:none;
		}
		
		.green {
			background: #44dd00;
			background: -webkit-gradient(linear, left top, left bottom, from(#33ee00), to(#33cc00)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #44ff00,  #44dd00) !important;
			background: -o-linear-gradient(top,  #44ff00,  #44dd00) !important;
			background: linear-gradient(top,  #44ff00,  #44dd00) !important;
			border: solid 1px #33bb00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #22cc00 !important;
			font-weight:bold !important;
		
		}
					
		.green:hover {
			background: -webkit-gradient(linear, left top, left bottom, from(#44ff00), to(#44ee00)); /* for webkit browsers */
			background: -moz-linear-gradient(top,  #44ff00,  #44ee00) !important;
			background: -o-linear-gradient(top,  #44ff00,  #44ee00) !important;
			background: linear-gradient(top,  #44ff00,  #44ee00) !important;
			border: solid 1px #44dd00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #22dd00 !important;
			font-weight:bold !important;
		
		}
					
		.green:active {
			background: #44ee00 !important;
			border: solid 1px #44dd00 !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #44dd00 !important;
			font-weight:bold !important;
		
		}
					
		.gray
		{
			background-image: url("/images/backgrounds/grey.svg") !important;
			background-color:#e5e5e5 !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#e0e0e0)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #f5f5f5,  #e0e0e0) !important;
			background: -o-linear-gradient(top,  #f5f5f5,  #e0e0e0) !important;
			background: linear-gradient(top,  #f5f5f5,  #e0e0e0) !important;
			border: solid 1px #ccc !important;
			color:#555 !important;
			text-shadow: 1px 1px 0px #fff !important;
			font-weight:bold !important;
		
		}
					
		.gray:hover {
			background-image: url("/images/backgrounds/grey_hover.svg") !important;
			background-color:#f0f0f0 !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#e0e0e0)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #fff,  #e0e0e0) !important;
			background: -o-linear-gradient(top,  #fff,  #e0e0e0) !important;
			background: linear-gradient(top,  #fff,  #e0e0e0) !important;
			border: solid 1px #ccc !important;
			color:#555 !important;
			text-shadow: 1px 1px 0px #fff !important;
			font-weight:bold !important;
		
		}
					
		.gray:active 
		{
			background-color:#f0f0f0 !important;
			border: solid 1px #ddd !important;
			color:#555 !important;
			text-shadow:  -1px -1px 0px #fff !important;
			font-weight:bold !important;
		
		}
					
		.gold {
			background-image: url("/images/backgrounds/gold.svg") !important;
			background-color: #ffdd00 !important;
			background-image: -moz-linear-gradient(bottom, #FFAF00, #FFee00) !important;
			background-image: -webkit-linear-gradient(bottom, #FFAF00, #FFee00) !important;
			background-image: -o-linear-gradient(bottom, #FFAF00, #FFee00) !important;
			background-image: linear-gradient(bottom, #FFAF00, #FFee00) !important;
			border: solid 1px #ddbb00 !important;
			color:#886600 !important;
			text-shadow: 0px 1px 0px #ffee00 !important;
			font-weight:bold !important;
		
		}
					
		.gold:hover {
			background-image: url("/images/backgrounds/gold_hover.svg") !important;
			background-color: #ffee00 !important;
			background-image: -moz-linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			background-image: -webkit-linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			background-image: -o-linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			background-image: linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			border: solid 1px #ddbb00 !important;
			color:#886600 !important;
			text-shadow: 0px 1px 0px #ffee00 !important;
			font-weight:bold !important;
		
		}
					
		.gold:active {
			background: #ffdd00 !important;
			border: solid 1px #ddbb00 !important;
			color:#886600 !important;
			font-weight:bold !important;
		
		}
					
		.blue 
		{
			background-color:#81a8cb !important;
			background-image: url("/images/backgrounds/blue.svg") !important;
			background: -moz-linear-gradient(top,  #81b8db,  #4477a1) !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#81b8db), to(#4477a1)) !important; /* for webkit browsers */
			background: -o-linear-gradient(top,  #81b8db,  #4477a1) !important;
			background: linear-gradient(top,  #81b8db,  #4477a1) !important;
			border: solid 1px #4477a1 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #4477a1 !important;
			font-weight:bold !important;
		}
					
		.blue:hover {
			background-color:#85b3d0 !important;
			background-image: url("/images/backgrounds/blue_hover.svg") !important;
			background: -moz-linear-gradient(top,  #81c8fb,  #4477a1) !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#81c8fb), to(#4477a1)) !important; /* for webkit browsers */
			background: -o-linear-gradient(top,  #81c8fb,  #4477a1) !important;
			background: linear-gradient(top,  #81c8fb,  #4477a1) !important;
			border: solid 1px #4477aa !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #4477cc !important;
			font-weight:bold !important;
		
		}
					
		.blue:active {
			background: #4477a1 !important;
			border: solid 1px #4477aa !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #4477cc !important;
			font-weight:bold !important;
		
		}
					
		.orange {
			background-color:#ff8800 !important;
			background-image: url("/images/backgrounds/orange.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ff8800), to(#ff3300)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ff8800,  #ff3300) !important;
			background: -o-linear-gradient(top,  #ff8800,  #ff3300) !important;
			background: linear-gradient(top,  #ff8800,  #ff3300) !important;
			border: solid 1px #ff3300 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #ff3300 !important;
			font-weight:bold !important;
		
		}
					
		.orange:hover {
			background-color:#ffaa00 !important;
			background-image: url("/images/backgrounds/orange_hover.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ffcc00), to(#ff4400)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ffcc00,  #ff4400) !important;
			background: -o-linear-gradient(top,  #ffcc00,  #ff4400) !important;
			background: linear-gradient(top,  #ffcc00,  #ff4400) !important;
			border: solid 1px #ff6600 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #ff3300 !important;
			font-weight:bold !important;
		}
					
		.orange:active {
			background-color:#ff8800 !important;
			border: solid 1px #ff8800 !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #ff3300 !important;
			font-weight:bold !important;
		}
		
		.red {
			background-color:#ee3300 !important;
			background-image: url("/images/backgrounds/red.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ff5500), to(#cc0000)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ff5500,  #cc0000) !important;
			background: -o-linear-gradient(top,  #ff5500,  #cc0000) !important;
			background: linear-gradient(top,  #ff5500,  #cc0000) !important;
			border: solid 1px #b00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #b00 !important;
			font-weight:bold !important;
		
		}
					
		.red:hover {
			background-color:#ee5500 !important;
			background-image: url("/images/backgrounds/red_hover.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ff8800), to(#CC0000)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ff8800,  #CC0000) !important;
			background: -o-linear-gradient(top,  #ff8800,  #CC0000) !important;
			background: linear-gradient(top,  #ff8800,  #CC0000) !important;
			border: solid 1px #b00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #b00 !important;
			font-weight:bold !important;
		}
					
		.red:active {
			background: #ff3300 !important;
			border: solid 1px #b00 !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #b00 !important;
			font-weight:bold !important;
		}
		
		.inset
		{
			 font-family: Lucida Grande !important;
			background-color: #666666 !important;
			-webkit-background-clip: text !important;
			-moz-background-clip: text !important;
			background-clip: text !important;
			color: transparent !important;
			text-shadow: rgba(255,255,255,0.5) 0px 3px 3px !important;
		}			
					
		.button{
			border-radius:3px !important;
			padding: 10px;
			font-size:12pt;
			background-repeat:repeat;
			line-height:14pt !important;
			text-decoration:none;
		}
					
		.round{
			border-radius:20px !important;
			padding: 10px 20px !important;
			font-size:12pt !important;
		}
			
		.right-round{
			border-top-right-radius:20px !important;
			border-bottom-right-radius:20px !important;
			font-size:12pt !important;
			margin-left: -5px !important;
			box-shadow: none !important;
			padding: 12px 15px 8px !important;
		}
				
		.float-right
		{
			float:right !important;
		}
			
		.float-left
		{
			float:left !important;
		}
		
		.light-shadow
		{
			box-shadow:1px 1px 3px #ddd;
		}
					
		.small{
			font-size:10pt !important;
			padding:5px 10px !important;
			-webkit-box-shadow:none !important;
			-moz-box-shadow:none !important;
			box-shadow:none !important;
						
		}
					
		.small:hover{
			font-size:10pt !important;
			padding:4px 8px !important;
			padding:5px 10px !important;
			-webkit-box-shadow:none !important;
			-moz-box-shadow:none !important;
			box-shadow:none !important;
		}
					
		.big{
			font-size:18pt !important;
		}
					
		.big:hover{
			font-size: 18pt !important;
		}
					
		.miniscule{
			padding:2px 6px !important;
			font-size:6pt !important;
		}
					
		.miniscule:hover{
			padding:2px 6px !important;
			font-size:6pt !important;
		}
					
		.button_example{
			display:inline-block !important;
		}
		
		.button span
		{
			padding:0 !important;
		}


	 </style>

	 <script type="text/javascript">
	 	function yesAccount(){
		 	document.getElementById("swFrame").src = "http://login.sitewit.com/plugins/wordpress";
		 	document.getElementById("yesAccountDesc").style.display = "inline";
		 	document.getElementById("noAccountDesc").style.display = "none";
		 	document.getElementById("divTokens").style.display = "inline";
		 	document.getElementById("divAccount").style.display = "none";
		}

		function noAccount(){
			document.getElementById("swFrame").src = "http://login.sitewit.com/auth/newaccount-wp.aspx";
		 	document.getElementById("yesAccountDesc").style.display = "none";
		 	document.getElementById("noAccountDesc").style.display = "inline";
		 	document.getElementById("divTokens").style.display = "inline";
		 	document.getElementById("divAccount").style.display = "none";
		}

		function toggleSettings(el){
			var divTokens = document.getElementById("divTokens");
			if(divTokens.style.display == "inline"){
				divTokens.style.display = "none";
				el.value = "Show Settings";
			}
			else{
				divTokens.style.display = "inline";
				el.value = "Hide Settings";
			}
		}
	 </script>
	 
	 <div class="wrap">
		<h2>SiteWit</h2>
		<form method="post" action="">
		<input type="hidden" name="sw_source" id="sw_source" value="1" />
		
		<?php
			$affiliate=get_option($AFFILIATE_ID_OPTION_NAME);
			if(get_option('sw_api_token') == null || get_option('sw_user_token') == null){
		?>
			<!-- IFrame -->

			<iframe id="swFrame" width="800px" height="520px" scrolling="no" seamless="seamless" src="http://login.sitewit.com/auth/newaccount-wp.aspx?aff=<?php echo $affiliate ?>&u=<?php echo urlencode(bloginfo('url')) ?>">
			</iframe>

			<script type="text/javascript" defer="defer">

				window.addEventListener('message', receiver, false);
				function receiver(e) {

					var data = e.data.split('####');
					var func = data[0];

					if(func=='tok'){
	      					var appToken = data[1];
						var usrToken = data[2];
						document.getElementById('sw_api_token').value = appToken;
						document.getElementById('sw_user_token').value = usrToken;

						if(document.getElementById("swFrame")){
							document.getElementById("divTokens").style.display='inline';
							document.getElementById("swFrame").height = '250px';
						}
					}else if(func=='sz'){
						var size = data[1];
						if(document.getElementById("swFrame")){
							document.getElementById("divTokens").style.display='none';
							document.getElementById("swFrame").height = size;
						}
					}

				}

				function getKeys(){
					document.getElementById('swFrame').contentWindow.postMessage(document.location.protocol + '//' + document.location.host,'http://login.sitewit.com');
				}

				_interval_keys = setInterval(getKeys,500);


			</script>

			<div id="divTokens" style="display:none;">
			
				<table id="tokenTable" class="form-table" style="width: 800px;text-align:center;">
					 <tr>
						<td>
							<input type="hidden" id="sw_api_token" name="sw_api_token" value="<?php echo get_option('sw_api_token')?>" style="width:230px;"/>
							<input type="hidden" id="sw_user_token" name="sw_user_token" value="<?php echo get_option('sw_user_token')?>" style="width:230px;"/>
							<input type="submit" name="submit" value="Link my SiteWit account" class="swbutton blue big round" style="color:#fff;padding:18px 30px !important;" />
						</td>
					</tr>
				</table><br/>

			 </div>

			 <?php
				}
				else{
					$SETUP_FINISHED = true;
				}
			 ?>

			 <?php 
			 if($SETUP_FINISHED){ 
				?>
				<br />
				<table>
					<tr>
						<td>
							<a class="swbutton orange round" style="padding:15px;" href="https://login.sitewit.com/smb/signup/?load=new">Build a campaign</a>
						</td>
						<td>
							<a class="swbutton blue round" style="padding:15px;" href="https://login.sitewit.com/smb/source/">View reports</a>
						</td>
						<td>
							<a class="swbutton gray round" style="padding:15px;" href="https://login.sitewit.com/smb/dashboard/">Go to SiteWit</a>
						</td>
					</tr>
				</table>
				
				<?php 
			 	$source_engagement = sitewit_get_source_engagement();
				$url_engagement = sitewit_get_url_engagement();
				//$campaigns = sitewit_get_campaigns();
				$goals = sitewit_get_goals();
				$seo = sitewit_get_seo();
				
				$has_array = (is_array($source_engagement) || is_array($campaigns) || is_array($goals) || is_array($seo));
				
				if( !$has_array ) {

			?>
			
					<div style="width:900px;margin:10% auto;text-align:center;">
						<h1 style="font-size:25pt;">Congratulations, SiteWit is properly installed!</h1>
	
						<p style="font-size:12pt;margin-top:50px;">It takes 24 hours or less to see your data and it will
						automatically display here as soon as it is ready.</p>
						
						<p style="font-size:12pt;">In the meantime, you can start marketing your
						website right away.<p> 
						
						<p style="font-size:12pt;margin-bottom:50px;">It takes 5 minutes or less to
						build a campaign and it is fun!</p> 
						
						<a class="swbutton round blue" href="http://login.sitewit.com/smb/signup/?load=new"> 
							Start marketing my website
						</a>
						
					</div>
			<?php
				
			 	}else{
			 
			 ?>
			 	<p style="margin-bottom:20px;">
					<?php sitewit_draw_source_engagement($source_engagement);?>
				</p>
				<p>
					<?php sitewit_draw_url_engagement($url_engagement);?>
				</p>
				<p style="margin-bottom:20px;">
					<?php sitewit_draw_goals($goals);?>
				</p>
				<p style="margin-bottom:20px;">
					<?php sitewit_draw_seo($seo);?>
				</p>
				
			<?php } ?>
				
				<input type="button" value="Show Settings" onclick="toggleSettings(this)" class="swbutton gray round"/>
				<div id="divTokens" style="display: none;">

				<table id="tokenTable" class="form-table" style="width: 600px; bgcolor:#cccccc;">
					<tr>
						<th scope="row" style="font-size:16px;font-weight:bold;width:120px; color:#464646;" >API Token:</th>
						<td><input type="text" id="sw_api_token" name="sw_api_token" value="<?php echo get_option('sw_api_token')?>" style="width:320px;"/></td>
					</tr>
					<tr>
						<th scope="row" style="font-size:16px;font-weight:bold;width:120px;color:#464646;">User Token:</th>
						<td><input type="text" id="sw_user_token" name="sw_user_token" value="<?php echo get_option('sw_user_token')?>" style="width:320px;"/></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" name="submit" value="Save Tokens" class="swbutton green round" />
							&nbsp;
							<input type="submit" name="submit" value="Remove Tokens" class="swbutton gray round" />
						</td>
					</tr>
				</table><br/>

				</div>

			 <?php } ?>


	 </div>


		</form>

<?php

	 }


	 function sw_add_config_page(){
	 	add_submenu_page('plugins.php',__('SiteWit'), __('SiteWit'), 'manage_options', 'sitewit-config','sw_config_page');
	 }


	function sw_print_tracking_code(){

		$val = get_option("sw_tracking_code");

		if($val != NULL){

		 echo $val;

		}

	 }

	 function sw_notice(){
		echo	 "<div id='sw-warning' class='updated fade'><p><strong>".__('SiteWit is almost ready.')."</strong> ".sprintf(__('You must <a href="%1$s">link your SiteWit account</a> in order for it to work.'), "plugins.php?page=sitewit-config")."</p></div>";
	 }

	 function sw_update_notice(){
		echo	 "<div id='sw-update-warning' class='updated fade'><p>".__('Your SiteWit account has been successfully linked.')."</p></div>";
	 }

	 function sw_api_error_notice(){
		echo	 "<div id='sw-update-warning' class='updated fade'><p>".__('Your SiteWit accoutn is linked, but the API has returned <strong>no result</strong>.')."</p></div>";
	 }

	 function sw_api_success_notice(){
		echo	 "<div id='sw-update-warning' class='updated fade'><p>".__('SiteWit has been set up successfully. <strong>You are all set!</strong>')."</p></div>";
	 }

	 //adds the settings link to the plugin action links
	 function sw_plugin_action_links( $links, $file ) {

		if ( $file == plugin_basename( dirname(__FILE__).'/sitewit.php' ) ) {
		$links[] = '<a href="plugins.php?page=sitewit-config">'.__('Settings').'</a>';
	}

	return $links;
}

// Create the function to output the contents of our Dashboard Widget

function sitewit_dashboard_widget_function() {
	// Display whatever it is you want to show
	//Check if API is correct
		?>
		
				 <style type="text/css">

		.swbutton
		{
			font-family:helvetica, Arial, Verdana;
			text-decoration:none;
		}
		
		.green {
			background: #44dd00;
			background: -webkit-gradient(linear, left top, left bottom, from(#33ee00), to(#33cc00)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #44ff00,  #44dd00) !important;
			background: -o-linear-gradient(top,  #44ff00,  #44dd00) !important;
			background: linear-gradient(top,  #44ff00,  #44dd00) !important;
			border: solid 1px #33bb00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #22cc00 !important;
			font-weight:bold !important;
		
		}
					
		.green:hover {
			background: -webkit-gradient(linear, left top, left bottom, from(#44ff00), to(#44ee00)); /* for webkit browsers */
			background: -moz-linear-gradient(top,  #44ff00,  #44ee00) !important;
			background: -o-linear-gradient(top,  #44ff00,  #44ee00) !important;
			background: linear-gradient(top,  #44ff00,  #44ee00) !important;
			border: solid 1px #44dd00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #22dd00 !important;
			font-weight:bold !important;
		
		}
					
		.green:active {
			background: #44ee00 !important;
			border: solid 1px #44dd00 !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #44dd00 !important;
			font-weight:bold !important;
		
		}
					
		.gray
		{
			background-image: url("/images/backgrounds/grey.svg") !important;
			background-color:#e5e5e5 !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#e0e0e0)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #f5f5f5,  #e0e0e0) !important;
			background: -o-linear-gradient(top,  #f5f5f5,  #e0e0e0) !important;
			background: linear-gradient(top,  #f5f5f5,  #e0e0e0) !important;
			border: solid 1px #ccc !important;
			color:#555 !important;
			text-shadow: 1px 1px 0px #fff !important;
			font-weight:bold !important;
		
		}
					
		.gray:hover {
			background-image: url("/images/backgrounds/grey_hover.svg") !important;
			background-color:#f0f0f0 !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#e0e0e0)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #fff,  #e0e0e0) !important;
			background: -o-linear-gradient(top,  #fff,  #e0e0e0) !important;
			background: linear-gradient(top,  #fff,  #e0e0e0) !important;
			border: solid 1px #ccc !important;
			color:#555 !important;
			text-shadow: 1px 1px 0px #fff !important;
			font-weight:bold !important;
		
		}
					
		.gray:active 
		{
			background-color:#f0f0f0 !important;
			border: solid 1px #ddd !important;
			color:#555 !important;
			text-shadow:  -1px -1px 0px #fff !important;
			font-weight:bold !important;
		
		}
					
		.gold {
			background-image: url("/images/backgrounds/gold.svg") !important;
			background-color: #ffdd00 !important;
			background-image: -moz-linear-gradient(bottom, #FFAF00, #FFee00) !important;
			background-image: -webkit-linear-gradient(bottom, #FFAF00, #FFee00) !important;
			background-image: -o-linear-gradient(bottom, #FFAF00, #FFee00) !important;
			background-image: linear-gradient(bottom, #FFAF00, #FFee00) !important;
			border: solid 1px #ddbb00 !important;
			color:#886600 !important;
			text-shadow: 0px 1px 0px #ffee00 !important;
			font-weight:bold !important;
		
		}
					
		.gold:hover {
			background-image: url("/images/backgrounds/gold_hover.svg") !important;
			background-color: #ffee00 !important;
			background-image: -moz-linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			background-image: -webkit-linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			background-image: -o-linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			background-image: linear-gradient(bottom, #FFAF00, #FFFF00) !important;
			border: solid 1px #ddbb00 !important;
			color:#886600 !important;
			text-shadow: 0px 1px 0px #ffee00 !important;
			font-weight:bold !important;
		
		}
					
		.gold:active {
			background: #ffdd00 !important;
			border: solid 1px #ddbb00 !important;
			color:#886600 !important;
			font-weight:bold !important;
		
		}
					
		.blue 
		{
			background-color:#81a8cb !important;
			background-image: url("/images/backgrounds/blue.svg") !important;
			background: -moz-linear-gradient(top,  #81b8db,  #4477a1) !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#81b8db), to(#4477a1)) !important; /* for webkit browsers */
			background: -o-linear-gradient(top,  #81b8db,  #4477a1) !important;
			background: linear-gradient(top,  #81b8db,  #4477a1) !important;
			border: solid 1px #4477a1 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #4477a1 !important;
			font-weight:bold !important;
		}
					
		.blue:hover {
			background-color:#85b3d0 !important;
			background-image: url("/images/backgrounds/blue_hover.svg") !important;
			background: -moz-linear-gradient(top,  #81c8fb,  #4477a1) !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#81c8fb), to(#4477a1)) !important; /* for webkit browsers */
			background: -o-linear-gradient(top,  #81c8fb,  #4477a1) !important;
			background: linear-gradient(top,  #81c8fb,  #4477a1) !important;
			border: solid 1px #4477aa !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #4477cc !important;
			font-weight:bold !important;
		
		}
					
		.blue:active {
			background: #4477a1 !important;
			border: solid 1px #4477aa !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #4477cc !important;
			font-weight:bold !important;
		
		}
					
		.orange {
			background-color:#ff8800 !important;
			background-image: url("/images/backgrounds/orange.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ff8800), to(#ff3300)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ff8800,  #ff3300) !important;
			background: -o-linear-gradient(top,  #ff8800,  #ff3300) !important;
			background: linear-gradient(top,  #ff8800,  #ff3300) !important;
			border: solid 1px #ff3300 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #ff3300 !important;
			font-weight:bold !important;
		
		}
					
		.orange:hover {
			background-color:#ffaa00 !important;
			background-image: url("/images/backgrounds/orange_hover.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ffcc00), to(#ff4400)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ffcc00,  #ff4400) !important;
			background: -o-linear-gradient(top,  #ffcc00,  #ff4400) !important;
			background: linear-gradient(top,  #ffcc00,  #ff4400) !important;
			border: solid 1px #ff6600 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #ff3300 !important;
			font-weight:bold !important;
		}
					
		.orange:active {
			background-color:#ff8800 !important;
			border: solid 1px #ff8800 !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #ff3300 !important;
			font-weight:bold !important;
		}
		
		.red {
			background-color:#ee3300 !important;
			background-image: url("/images/backgrounds/red.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ff5500), to(#cc0000)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ff5500,  #cc0000) !important;
			background: -o-linear-gradient(top,  #ff5500,  #cc0000) !important;
			background: linear-gradient(top,  #ff5500,  #cc0000) !important;
			border: solid 1px #b00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #b00 !important;
			font-weight:bold !important;
		
		}
					
		.red:hover {
			background-color:#ee5500 !important;
			background-image: url("/images/backgrounds/red_hover.svg") !important;
			background: -webkit-gradient(linear, left top, left bottom, from(#ff8800), to(#CC0000)) !important; /* for webkit browsers */
			background: -moz-linear-gradient(top,  #ff8800,  #CC0000) !important;
			background: -o-linear-gradient(top,  #ff8800,  #CC0000) !important;
			background: linear-gradient(top,  #ff8800,  #CC0000) !important;
			border: solid 1px #b00 !important;
			color:#fff !important;
			text-shadow: -1px -1px 0px #b00 !important;
			font-weight:bold !important;
		}
					
		.red:active {
			background: #ff3300 !important;
			border: solid 1px #b00 !important;
			color:#fff !important;
			text-shadow: 1px 1px 0px #b00 !important;
			font-weight:bold !important;
		}
		
		.inset
		{
			 font-family: Lucida Grande !important;
			background-color: #666666 !important;
			-webkit-background-clip: text !important;
			-moz-background-clip: text !important;
			background-clip: text !important;
			color: transparent !important;
			text-shadow: rgba(255,255,255,0.5) 0px 3px 3px !important;
		}			
					
		.button{
			border-radius:3px !important;
			padding: 10px;
			font-size:12pt;
			background-repeat:repeat;
			line-height:14pt !important;
			text-decoration:none;
		}
					
		.round{
			border-radius:20px !important;
			padding: 10px 20px !important;
			font-size:12pt !important;
		}
			
		.right-round{
			border-top-right-radius:20px !important;
			border-bottom-right-radius:20px !important;
			font-size:12pt !important;
			margin-left: -5px !important;
			box-shadow: none !important;
			padding: 12px 15px 8px !important;
		}
				
		.float-right
		{
			float:right !important;
		}
			
		.float-left
		{
			float:left !important;
		}
		
		.light-shadow
		{
			box-shadow:1px 1px 3px #ddd;
		}
					
		.small{
			font-size:10pt !important;
			padding:5px 10px !important;
			-webkit-box-shadow:none !important;
			-moz-box-shadow:none !important;
			box-shadow:none !important;
						
		}
					
		.small:hover{
			font-size:10pt !important;
			padding:4px 8px !important;
			padding:5px 10px !important;
			-webkit-box-shadow:none !important;
			-moz-box-shadow:none !important;
			box-shadow:none !important;
		}
					
		.big{
			font-size:18pt !important;
		}
					
		.big:hover{
			font-size: 18pt !important;
		}
					
		.miniscule{
			padding:2px 6px !important;
			font-size:6pt !important;
		}
					
		.miniscule:hover{
			padding:2px 6px !important;
			font-size:6pt !important;
		}
					
		.button_example{
			display:inline-block !important;
		}
		
		.button span
		{
			padding:0 !important;
		}


	 </style>
		
		<?php
		$source_engagement = sitewit_get_source_engagement();
		
		if( is_array($source_engagement) ) {
			sitewit_draw_source_engagement($source_engagement);
		}else{
			?>
			
				<div style=";margin:10% auto;text-align:center;">
					<h1 style="font-size:20pt;line-height:20pt;">Congratulations, SiteWit is installed!</h1>
	
					<p style="font-size:10pt;margin-top:10px;margin-bottom:20px;">It takes 24 hours or less to see your data and it
						will automatically display here as soon as it is ready. In the meantime, you can start marketing your
					website right away.<p>  
					
					<a class="swbutton round blue small" style="padding:20px;" href="http://login.sitewit.com/smb/signup/?load=new"> 
						Build a marketing campaign
					</a>
					
				</div>
			
			<?php	
		}
}

// Create the function use in the action hook

function sitewit_add_dashboard_widgets() {
	wp_add_dashboard_widget('sitewit_dashboard_widget', 'SiteWit', 'sitewit_dashboard_widget_function');
}

function sitewit_get_goals() {
	// MY GOALS
	global $mnow; global $mbefore;
	$api_token = get_option('sw_api_token');
	$user_token = get_option('sw_user_token');

	try {
		$client = new SoapClient('https://api.sitewit.com/reporting/goaldata.asmx?WSDL');
		$params = array('AccountToken' => $api_token, 'UserToken' => $user_token, 'StartDate' => $mbefore, 'EndDate' => $mnow);
		$response = $client->GetOverview($params);
		$goals = $response->GetOverviewResult->Goals->GoalSummary;
		
		return $goals;

	}catch(SoapFault $fault){
		return null;
	}

}

function sitewit_draw_goals($goal_arr){
		
	$x=0;
	
	if(!is_array($goal_arr) && $goal_arr!=null){
		$goal_arr = array($goal_arr);
	}
	
	if(is_array($goal_arr)){
	
		if(count($goal_arr)>0){
				
			echo '<h2>Goals</h2>';
			echo '<table class="widefat"><thead><tr>';
			echo '<th>Name</th><th>Conversions</th><th>Revenue</th></tr></thead>';

			foreach($goal_arr as $goal){
				$x++;
				echo '<tr><td>'.$goal->GoalName.'</td>';
				echo '<td>'.$goal->Goals.'</td>';
				echo '<td>'.number_format($goal->Revenue,2).'</td></tr>';
				
				if($x>4)
					break;
			}
		
			echo '</table>';
					
		
		} else {
			//no errors, but no goals
		}
	}
}

//Specific Functions to call for displaying results...
function sitewit_get_source_engagement(){
	
	// Engaggement
	$api_token = get_option('sw_api_token');
	$user_token = get_option('sw_user_token');
	$look_back_days = 30; 
	
	try {
		$client = new SoapClient('https://api.sitewit.com/reporting/engagementdata.asmx?WSDL');
		$params = array('AccountToken' => $api_token, 'UserToken' => $user_token, "LookBackDays" => $look_back_days);
		$response = $client->GetSourceEngagementOverview($params);
		$engagement = $response->GetSourceEngagementOverviewResult->Data->SourceEngagementMetric;
		
		return $engagement;
		
	}catch (Exception $e){
		//echo $e->getMessage();
		return null;
	}
	
}


function sitewit_draw_source_engagement($se_arr){
		
	$x=0;
	
	if(!is_array($se_arr) && $se_arr!=null){
		$se_arr = array($se_arr);
	}
	
	if(is_array($se_arr)){
	
		if(count($se_arr)>0){
			
			echo '<h2>Source engagement</h2>';
			echo '<table class="widefat"><thead><tr>';
			echo '<th>Source</th><th>Visitors</th><th>Time on site</th><th>Repeats</th><th>Researchers</th><th>Prospects</th><th>Fans</th><th>SWei</th></tr></thead>';
	
			foreach($se_arr as $se){
				$x++;
				
				 $visitors =$se->Visitors;
				 
				 if($visitors>0){
                    $repeats = round(($se->Repeats / $visitors * 100),1);
                    $researchers = round(($se->Researchers / $visitors * 100),1);
                    $prospects = round(($se->Prospects / $visitors * 100),1);
                    $fans = round(($se->Fans / $visitors * 100),1);
				}
				
				echo '<tr><td>'.$se->VisitType.'</td>';
				echo '<td>'.$se->Visitors.'</td>';
				echo '<td>'.sw_format_time($se->TimeOnSite).'</td>';
				echo '<td>'.$repeats.'%</td>';
				echo '<td>'.$researchers.'%</td>';
				echo '<td>'.$prospects.'%</td>';
				echo '<td>'.$fans.'%</td>';
				echo '<td>'.round($se->EngagementIndex,1).'</td></tr>';
				
				if($x>4)
					break;
				
			}
		 
			echo '</table>';
		 
		}else{
			
		}
	
	 }
}

function sitewit_get_url_engagement(){
	
	// Engaggement
	$api_token = get_option('sw_api_token');
	$user_token = get_option('sw_user_token');
	$look_back_days = 30; 
	
	try {
		$client = new SoapClient('https://api.sitewit.com/reporting/engagementdata.asmx?WSDL');
		$params = array('AccountToken' => $api_token, 'UserToken' => $user_token, "LookBackDays" => $look_back_days);
		$response = $client->GetUrlEngagementOverview($params);
		$engagement = $response->GetUrlEngagementOverviewResult->Data->UrlEngagementMetric;
		
		return $engagement;
		
	}catch (Exception $e){
		//echo $e->getMessage();
		return null;
	}
	
}


function sitewit_draw_url_engagement($ue_arr){
		
	$x=0;
	
	if(!is_array($ue_arr) && $ue_arr!=null){
		$ue_arr = array($ue_arr);
	}
	
	if(is_array($ue_arr)){
	
		if(count($ue_arr)>0){
			
			echo '<h2>Pages</h2>';
			echo '<table class="widefat"><thead><tr>';
			echo '<th>Source</th><th>Visitors</th><th>Time on site</th><th>Repeats</th><th>Researchers</th><th>Prospects</th><th>Fans</th><th>SWei</th></tr></thead>';
	
			foreach($ue_arr as $ue){
				$x++;
				
				 $visitors =$ue->Visitors;
				 
				 if($visitors>0){
                    $repeats = round(($ue->Repeats / $visitors * 100),1);
                    $researchers = round(($ue->Researchers / $visitors * 100),1);
                    $prospects = round(($ue->Prospects / $visitors * 100),1);
                    $fans = round(($ue->Fans / $visitors * 100),1);
				}
				
				echo '<tr><td>'.$ue->PageUrl.'</td>';
				echo '<td>'.$ue->Visitors.'</td>';
				echo '<td>'.sw_format_time($ue->TimeOnSite).'</td>';
				echo '<td>'.$repeats.'%</td>';
				echo '<td>'.$researchers.'%</td>';
				echo '<td>'.$prospects.'%</td>';
				echo '<td>'.$fans.'%</td>';
				echo '<td>'.round($ue->SWei,1).'</td></tr>';
				
				if($x>4)
					break;
				
			}
		 
			echo '</table>';
		 
		}else{
			
		}
	
	 }
}

function sitewit_get_seo(){
	
	// SEO RANKINGS
	$api_token = get_option('sw_api_token');
	$user_token = get_option('sw_user_token');
	
	try {
		$client = new SoapClient('https://api.sitewit.com/reporting/seorankingdata.asmx?WSDL');
		$params = array('AccountToken' => $api_token, 'UserToken' => $user_token);
		$response = $client->GetSEORankings($params);
		$seo = $response->GetSEORankingsResult->Google->SEORanking;
		
		return $seo;
		
	}catch (Exception $e){
		//echo $e->getMessage();
		return null;
	}
	
}

function sitewit_draw_seo($seo_arr){
		
	$x=0;
	
	if(!is_array($seo_arr) && $seo_arr!=null){
		$seo_arr = array($seo_arr);
	}
	
	if(is_array($seo_arr)){
	
		if(count($seo_arr)>0){
			
			echo '<h2>SEO Rankings</h2>';
			echo '<table class="widefat"><thead><tr>';
			echo '<th width="50%">Search Phrase</th><th>Rank</th><th>Visitors</th><th>Visits</th><th>Revenue</th><th>Conversion Rate</th></tr></thead>';
	
			foreach($seo_arr as $seo){
				$x++;		
				
				echo '<tr><td>'.$seo->SearchPhrase.'</td>';
				echo '<td>'.$seo->Rank.'</td>';
				echo '<td>'.$seo->Visitors.'</td>';
				echo '<td>'.$seo->Visits.'</td>';
				echo '<td>'.number_format($seo->Revenue,2).'</td>';
				echo '<td>'.round($seo->ConversionRate,2)."%".'</td></tr>';
				
				if($x>4)
					break;
				
			}
		 
			echo '</table>';
		 
		}else{
			
		}
	
	 }
}

function sitewit_get_traffic(){
	//MY TRAFFIC
	global $mnow; global $mbefore;
	$api_token = get_option('sw_api_token');
	$user_token = get_option('sw_user_token');

	try{
		
		$client = new SoapClient('https://api.sitewit.com/reporting/trafficdata.asmx?WSDL');
		$params = array('AccountToken' => $api_token, 'UserToken' => $user_token, 'StartDate' => $mbefore, 'EndDate' => $mnow);
		$response = $client->GetOverview($params);
		$traffic = $response->GetOverviewResult->Data->TrafficType;
		return $traffic;
		
	}catch(Exception $e){
		return null;
	}
	
}

function sitewit_draw_traffic($traffic_arr){
	global $mliteral;
	 
	$x=0;
	
	if(!is_array($traffic_arr) && $traffic_arr!=null){
		$traffic_arr = array($traffic_arr);
	}
	
	if(is_array($traffic_arr)){
	
		if(count($traffic_arr)>0){
	
			echo '<h2>Traffic Sources <span style="font-size: 14px; color: #111;">('.$mliteral.')</span></h2>';
			echo '<table class="widefat"><thead><tr>';
			echo '<th>Source</th><th>Visitors</th><th>Visits</th><th>Revenue</th><th>Profit</th><th>ROI</th><th>Conversion rate</th></tr></thead>';
	
			foreach($traffic_arr as $traffic){
				
				$x++;	
				echo '<tr><td><strong>'.$traffic->Description.'</strong></td>';
				echo '<td>'.$traffic->Visitors.'</td>';
				echo '<td>'.$traffic->Visits.'</td>';
				echo '<td>'.number_format($traffic->Revenue,2).'</td>';
				echo '<td>'.number_format($traffic->Profit,2).'</td>';
				echo '<td>'.round($traffic->ROI,2).'%</td>';
				echo '<td>'.round($traffic->ConversionRate,2).'%</td></tr>';
				
				if($x>4)
					break;
				
			 }
			 
			 echo '</table>';
			 
		 }else{
			//no traffic		 	
		 }
	 
	 }		
	
}

function sitewit_get_campaigns(){
	// MY CAMPAIGNS
	global $mnow; global $mbefore;
	$api_token = get_option('sw_api_token');
	$user_token = get_option('sw_user_token');

	try{
		$client = new SoapClient('https://api.sitewit.com/reporting/campaigndata.asmx?WSDL');
		$params = array('AccountToken' => $api_token, 'UserToken' => $user_token, 'StartDate' => $mbefore, 'EndDate' => $mnow);
		$response = $client->GetOverview($params);
		$campaigns = $response->GetOverviewResult;
		return $campaigns;
	}catch(Exception $e){
		print $e->GetMessage();
		return null;
	}
}

function sitewit_draw_campaigns($campaigns_arr){
	
	$x=0;
	
	if(!is_array($campaigns_arr) && $campaigns_arr!=null){
		$campaigns_arr = array($campaigns_arr);
	}
	
	if(is_array($campaigns_arr)){
		
		if(count($campaigns_arr)>0){

			echo '<h2>Campaign Overview</h2>';
			echo '<table class="widefat"><thead><tr>';
			echo '<th>Total Clicks</th><th>Goals</th><th>Conversion</th><th>Revenue</th><th>Cost</th><th>ROI</th></tr></thead>';
		
			foreach($campaigns_arr as $campaign){
				$x++;
				echo '<tr><td>'.$campaign->Clicks.'</td>';
				echo '<td>'.$campaign->Goals.'</td>';
				echo '<td>'.round($campaign->ConversionRate,2).'%</td>';
				echo '<td>'.number_format($campaign->Revenue,2).'</td>';
				echo '<td>'.number_format($campaign->Cost,2).'</td>';
				echo '<td>'.round($campaign->ROI,2).'%</td></tr>';
				
				if($x>4)
					break;
				
			}

		
			echo '</tr></table>';
		}
		
	}
		
}

function sw_plugin_activate(){
	global $AFFILIATE_ID_OPTION_NAME;
	global $AFFILIATE_ID;
	if(get_option($AFFILIATE_ID_OPTION_NAME)==NULL){
		update_option($AFFILIATE_ID_OPTION_NAME, $AFFILIATE_ID);
	}

}

function sw_format_time($sec){
	
    // start with a blank string
    $hms = "";
    
    // do the hours first: there are 3600 seconds in an hour, so if we divide
    // the total number of seconds by 3600 and throw away the remainder, we're
    // left with the number of hours in those seconds
    $hours = intval(intval($sec) / 3600); 

    // add hours to $hms (with a leading 0 if asked for)
    $hms .= $hours>0?$hours. "h " : "";
    
    // dividing the total seconds by 60 will give us the number of minutes
    // in total, but we're interested in *minutes past the hour* and to get
    // this, we have to divide by 60 again and then use the remainder
    $minutes = intval(($sec / 60) % 60); 

    // add minutes to $hms (with a leading 0 if needed)
    $hms .= $minutes>0?$minutes."m ":"";

    // seconds past the minute are found by dividing the total number of seconds
    // by 60 and using the remainder
    $seconds = intval($sec % 60); 

    // add seconds to $hms (with a leading 0 if needed)
    $hms .= $seconds>0?$seconds."s":"";

    // done!
    return $hms;
    
	
}

// Hook into the 'wp_dashboard_setup' action to register our other functions
if(get_option('sw_api_token') != null && get_option('sw_user_token') != null){
	add_action('wp_dashboard_setup', 'sitewit_add_dashboard_widgets' );
}

add_action('wp_footer', 'sw_print_tracking_code');
add_filter( 'plugin_action_links', 'sw_plugin_action_links', 10, 2 );
register_activation_hook( __FILE__, 'sw_plugin_activate');

?>

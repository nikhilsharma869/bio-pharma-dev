<?php

/*
 * Tell WP about the Admin page
 */
add_action('admin_menu', 'jfb_add_admin_page', 99);
function jfb_add_admin_page()
{ 
    global $jfb_name;
    add_options_page("$jfb_name Options", 'WP-FB AutoConn' . (defined('JFB_PREMIUM')?"+":""), 'administrator', "wp-fb-autoconnect", 'jfb_admin_page');
}


/**
  * Link to Settings on Plugins page 
  */
add_filter('plugin_action_links', 'jfb_add_plugin_links', 10, 2);
function jfb_add_plugin_links($links, $file)
{
    if( dirname(plugin_basename( __FILE__ )) == dirname($file) )
        $links[] = '<a href="options-general.php?page=' . "wp-fb-autoconnect" .'">' . __('Settings','sitemap') . '</a>';
    return $links;
}

/**
 * Styles
 */
add_action('admin_head', 'jfb_admin_styles');
function jfb_admin_styles()
{
    echo '<style type="text/css">'.
            '.jfb-admin_warning     {background-color: #FFEBE8; border:1px solid #C00; padding:0 .6em; margin:10px 0 15px; -khtml-border-radius:3px; -webkit-border-radius:3px; border-radius:3px;}'.
            '.jfb-admin_wrapper     {clear:both; background-color:#FFFEEB; border:1px solid #CCC; padding:0 8px; }'.
    	    '.jfb-admin_wrapper dfn {border-bottom:1px dotted #0000FF; cursor:help; font-style:italic; font-size:80%;}'.
    		'.jfb-admin_tabs        {width:100%; clear:both; float:left; margin:0 0 -0.1em 0; padding:0;}'.
            '.jfb-admin_tabs li     {list-style:none; float:left; margin:0; padding:0.2em 0.5em 0.2em 0.5em; }'.
            '.jfb-admin_tab_selected{background-color:#FFFEEB; border-left:1px solid #CCC; border-right:1px solid #CCC; border-top:1px solid #CCC;}'.
            '.jfb-greybox           {width:600px; padding:5px; margin:2px 0; background-color:#EEEDDA; border:1px solid #CCC;}'.
         '</style>';
    //Simple 'lightbox' for showing pop-up 'more info' descriptions.  From http://stephenmcintyre.net/blog/simple-css-lightbox
    echo '<style type="text/css">'.
           '.wpfb-moreinfo-bg{display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:#000; -moz-opacity:0.5; opacity:.50; filter:alpha(opacity=50); }' .
           '.wpfb-moreinfo-box{display:none; position:fixed; top:100px; left:25%; width:50%; background-color:#fff; padding:5px; }'.
           '.wpfb-moreinfo-lnk{text-decoration:none;font-size:80%;border-bottom: 1px dotted #0000FF;color:inherit;cursor: help;font-style: italic;}'.
         '</style>';
}


/**
  * Admin warning notices (shown globally; warnings only shown on this page are below)
  */
add_action('admin_notices', 'jfb_admin_notices');
function jfb_admin_notices()
{
	//Version 2.1.0 moved to a new version of the Facebook API that required changes on both the free and premium plugins;
 	//warn Premium users who have upgraded their free plugin, but not their addon.
	if( defined('JFB_PREMIUM') && version_compare(JFB_PREMIUM_VER, 30) == -1 )
	{
	    ?><div class="error"><p><strong>Warning:</strong> This version of WP-FB-AutoConnect is only compatible with Premium addon version 30 or better (you're currently using version <?php echo JFB_PREMIUM_VER; ?>).  If you haven't done so already, please read the important information in <a target="store" href="http://www.justin-klein.com/projects/wp-fb-autoconnect/#faq46">FAQ46</a> of the plugin documentation.</p><p>If you'd like to revert to the previous version of the free plugin until you're ready to update the addon, previous versions can be downloaded from <a href="http://wordpress.org/extend/plugins/wp-fb-autoconnect/developers/">here</a>.</p></div><?php
	}
	
	//Warn if the user's server doesn't have json_decode
	if (!function_exists('json_decode'))
	{
  	 	?><div class="error"><p><strong>Warning:</strong> WP-FB-AutoConnect requires the JSON PHP extension to work.  Please install / enable it before attempting to use this plugin.</p></div><?php
	}
    
    //Warn if w3 total cache is enabled
    global $opt_jfb_hidew3warning;
    if( isset($_REQUEST[$opt_jfb_hidew3warning]) ) update_option($opt_jfb_hidew3warning, 1);
    if (!get_option($opt_jfb_hidew3warning) && is_plugin_active("w3-total-cache/w3-total-cache.php"))
    {?>
        <div class="error">
            <p><strong>Warning:</strong> In some situations, W3-Total-Cache has been reported to cause problems with WP-FB-AutoConnect's Facebook logins.  If you're experiencing issues with WP-FB-AutoConnect (for instance, the Widget doesn't properly show the logged-in state immediately after a login), please try temporarily disabling W3-Total-Cache.  If that fixes it, you may re-enable W3-Total-Cache and try selectively enabling its various caching/CDN options until you find a combination that works for you.</p>
            <?php echo '<a href="?' . http_build_query(array_merge($_GET, array($opt_jfb_hidew3warning => "1"))) . '">Hide this message</a>'; ?>
        </div>
    <?php
    }
    
    //Warn if it looks like we're on wpengine
    global $opt_jfb_hidewpenginewarning;
    if( isset($_REQUEST[$opt_jfb_hidewpenginewarning]) ) update_option($opt_jfb_hidewpenginewarning, 1);
    if (!get_option($opt_jfb_hidewpenginewarning) && defined('WPMU_PLUGIN_DIR') && file_exists(WPMU_PLUGIN_DIR . "/wpengine-common/plugin.php"))
    {?>
        <div class="error">
            <p><strong>Warning:</strong> It looks like your site is running on WPEngine.  Some users have reported that WPEngine's built-in caching causes problems with WP-FB-AutoConnect's Facebook logins.  If you're experiencing issues with WP-FB-AutoConnect (for instance, the Widget doesn't properly show the logged-in state immediately after a login), please contact WPEngine support and ask them to add a cache exclusion for the WP-FB-AutoConnect plugin folder (and for the Premium addon, if you're using it).</p>
            <?php echo '<a href="?' . http_build_query(array_merge($_GET, array($opt_jfb_hidewpenginewarning => "1"))) . '">Hide this message</a>'; ?>
        </div>
    <?php
    }
} 



/*
 * Output the Admin page
 */
function jfb_admin_page()
{
    global $jfb_name, $jfb_version, $opt_jfb_app_token;
    global $opt_jfb_app_id, $opt_jfb_api_key, $opt_jfb_api_sec, $opt_jfb_email_to, $opt_jfb_email_logs, $opt_jfb_email_logs_missingpost, $opt_jfb_delay_redir, $jfb_homepage;
    global $opt_jfb_ask_perms, $opt_jfb_mod_done, $opt_jfb_ask_stream, $opt_jfb_stream_content;
    global $opt_jfb_bp_avatars, $opt_jfb_wp_avatars, $opt_jfb_valid, $opt_jfb_fulllogerr, $opt_jfb_disablenonce, $opt_jfb_show_credit;
    global $opt_jfb_username_style, $opt_jfb_hidesponsor, $opt_jfb_reportstats;
    ?>
    <div class="wrap">
     <h2><?php echo $jfb_name; ?> Options</h2>
    <?php
    
    //Show applicable warnings (only on this panel's page; global warnings are above)
    if( class_exists('Facebook') )
    {
        ?><div class="error"><p><strong>Warning:</strong> Another plugin has included the Facebook API throughout all of Wordpress.  I suggest you contact that plugin's author and ask them to include it only in pages where it's actually needed.<br /><br />Things may work fine as-is, but *if* the API version included by the other plugin is older than the one required by WP-FB AutoConnect, it's possible that the login process could fail.</p></div><?php
    }
    if(version_compare('5', PHP_VERSION, ">"))
    {
        ?><div class="error"><p>Sorry, but as of v1.3.0, WP-FB AutoConnect requires PHP5.</p></div><?php
        die();
    }
    if( function_exists('is_multisite') && is_multisite() && !jfb_premium() )
    {
        ?><div class="error"><p><strong>Warning:</strong> Wordpress MultiSite is only fully supported by the premium version of this plugin; please see <a href="<?php echo $jfb_homepage ?>#premium"><b>here</b></a> for details.</p></div><?php
    }
    if( file_exists(realpath(dirname(__FILE__))."/WP-FB-AutoConnect-Premium.php" ) )
    {
        ?><div class="error"><p><strong>Notice:</strong> You seem to've uploaded the premium addon to the wrong directory.<br/><br/>
            As per the <a target="instructs" href="<?php echo $jfb_homepage ?>#premium"><b>setup instructions</b></a>, the "WP-FB-AutoConnect-Premium.php" file goes in your <i>plugins</i> directory (i.e. wp-content/plugins/WP-FB-AutoConnect-Premium.php), not the WP-FB-AutoConnect directory (i.e. wp-content/plugins/wp-fb-autoconnect/WP-FB-AutoConnect-Premium.php). This is to prevent it from getting overwritten when you auto-update the core plugin.</p></div>
        <?php
    }
	
    do_action('wpfb_admin_messages');
    
    //Which tab to show by default
    $shownTab = get_option($opt_jfb_valid)?1:0;
      
    //Update options
    if( isset($_POST['fb_opts_updated']) )
    {
        //When saving the Facebook options, make sure the key and secret are valid...
        update_option( $opt_jfb_valid, 0 );
        $shownTab = 0;
        $result = jfb_api_get("https://graph.facebook.com/" . $_POST[$opt_jfb_api_key]);
        if(!$result):
            ?><div class="error"><p>Error: Failed to validate your App ID and Secret.  Response: Empty Reply.<br />Are you sure you entered your App ID correctly?</p></div><?php
        elseif (isset($result['error'])):
            ?><div class="error"><p>Error: Failed to validate your App ID and Secret.  Response: <?php echo (isset($result['error']['message'])?$result['error']['message']:"Unknown"); ?>.<br />Are you sure you entered your App ID correctly?</p></div><?php
        elseif($result['id'] != $_POST[$opt_jfb_api_key]):
            ?><div class="error"><p>Error: Failed to validate your App ID and Secret.  Response: ID Mismatch.</p></div><?php
        else:
			//If we got here, we know the App ID is correct.  Now try to get an app token and store it in the options table; if this works we know the secret is correct too.  
			//Note: this plugin doesn't actually use the app-token; I simply cache it so it can be accessible to users wishing to further interact with Facebook via hooks & filters.
			//Note: App tokens never expire unless the app secret is refreshed.
			$response = wp_remote_get("https://graph.facebook.com/oauth/access_token?client_id=" . $_POST[$opt_jfb_api_key] . "&client_secret=" . $_POST[$opt_jfb_api_sec] . "&grant_type=client_credentials", array( 'sslverify' => false ));
			if( is_array($response) && strpos($response['body'], 'access_token=') !== FALSE )
			{
                //We're valid!
                $shownTab = 1;
                update_option( $opt_jfb_valid, 1 );
                update_option( $opt_jfb_app_token, substr($response['body'], 13) );
				?><div class="updated"><p><strong>Successfully connected with "<?php echo $result['name'] ?>" (ID <?php echo $result['id']; ?>)</strong></p></div><?php
			}
			else
			{
                ?><div class="error"><p>Error: Failed to validate your App ID and Secret.<br />Are you sure you entered your App Secret correctly?</p></div><?php
			}
        endif;

        //We can save these either way, because if "valid" isn't set, a button won't be shown.
        update_option( $opt_jfb_app_id, ( isset($result['id']) ? $result['id'] : "") );
        update_option( $opt_jfb_api_key, $_POST[$opt_jfb_api_key] );
        update_option( $opt_jfb_api_sec, $_POST[$opt_jfb_api_sec] );
    }
    if( isset($_POST['main_opts_updated']) )
    {
        $shownTab = 1;
        update_option( $opt_jfb_ask_perms, ( isset( $_POST[$opt_jfb_ask_perms] ) ? $_POST[$opt_jfb_ask_perms] : 0 ) );
        update_option( $opt_jfb_ask_stream, ( isset( $_POST[$opt_jfb_ask_stream] ) ? $_POST[$opt_jfb_ask_stream] : 0 ) );
        update_option( $opt_jfb_wp_avatars, ( isset( $_POST[$opt_jfb_wp_avatars] ) ? $_POST[$opt_jfb_wp_avatars] : 0 ) );
        update_option( $opt_jfb_stream_content, ( isset( $_POST[$opt_jfb_stream_content] ) ? $_POST[$opt_jfb_stream_content] : '' ) );        
        update_option( $opt_jfb_show_credit, ( isset( $_POST[$opt_jfb_show_credit] ) ? $_POST[$opt_jfb_show_credit] : 0 ) );
        update_option( $opt_jfb_email_to, ( isset( $_POST[$opt_jfb_email_to] ) ? $_POST[$opt_jfb_email_to] : '' ) );
        update_option( $opt_jfb_email_logs, ( isset( $_POST[$opt_jfb_email_logs] ) ? $_POST[$opt_jfb_email_logs] : 0 ) );
		update_option( $opt_jfb_email_logs_missingpost, ( isset( $_POST[$opt_jfb_email_logs_missingpost] ) ? $_POST[$opt_jfb_email_logs_missingpost] : 0 ) );
        update_option( $opt_jfb_delay_redir, ( isset( $_POST[$opt_jfb_delay_redir] ) ? $_POST[$opt_jfb_delay_redir] : 0 ) );
        update_option( $opt_jfb_fulllogerr, ( isset( $_POST[$opt_jfb_fulllogerr] ) ? $_POST[$opt_jfb_fulllogerr] : 0 ) );
        update_option( $opt_jfb_disablenonce, ( isset( $_POST[$opt_jfb_disablenonce] ) ? $_POST[$opt_jfb_disablenonce] : 0 ) );
        update_option( $opt_jfb_username_style, ( isset( $_POST[$opt_jfb_username_style] ) ? $_POST[$opt_jfb_username_style] : 0 ) );
        update_option( $opt_jfb_reportstats, ( isset( $_POST[$opt_jfb_reportstats] ) ? $_POST[$opt_jfb_reportstats] : 0 ) );
        ?><div class="updated"><p><strong>Options saved.</strong></p></div><?php         
    }
    if( isset($_POST['prem_opts_updated']) && function_exists('jfb_update_premium_opts'))
    {
        $shownTab = 2;
        jfb_update_premium_opts();
    }
    if( isset($_POST['remove_all_settings']) )
    {
        $shownTab = 0;
        delete_option($opt_jfb_api_key);
        delete_option($opt_jfb_api_sec);
        delete_option($opt_jfb_email_to);
        delete_option($opt_jfb_email_logs);
		delete_option($opt_jfb_email_logs_missingpost);
        delete_option($opt_jfb_delay_redir);
        delete_option($opt_jfb_ask_perms);
        delete_option($opt_jfb_ask_stream);
        delete_option($opt_jfb_stream_content);
        delete_option($opt_jfb_mod_done);
        delete_option($opt_jfb_valid);
		delete_option($opt_jfb_app_token);
        delete_option($opt_jfb_bp_avatars);
        delete_option($opt_jfb_wp_avatars);
        delete_option($opt_jfb_fulllogerr);
        delete_option($opt_jfb_disablenonce);
        delete_option($opt_jfb_show_credit);
        delete_option($opt_jfb_username_style);
        delete_option($opt_jfb_hidesponsor);
        delete_option($opt_jfb_hidew3warning);
        delete_option($opt_jfb_hidewpenginewarning);
        delete_option($opt_jfb_reportstats);
        if( function_exists('jfb_delete_premium_opts') ) jfb_delete_premium_opts();
        ?><div class="updated"><p><strong><?php _e('All plugin settings have been cleared.' ); ?></strong></p></div><?php
    }
    ?>
    
    <?php 
     if( isset($_REQUEST[$opt_jfb_hidesponsor]) )
          update_option($opt_jfb_hidesponsor, $_REQUEST[$opt_jfb_hidesponsor]);
     if(!get_option($opt_jfb_hidesponsor) && !defined('JFB_PREMIUM')): ?>
      	<!-- Sponsorship message *was* here, until Automattic demanded they be removed from all plugins - see http://gregsplugins.com/lib/2011/11/26/automattic-bullies/ -->
     <?php endif; ?>
     

    <!-- Tab Navigation -->
    <?php 
    //Define some variables that'll be used for our tab-switching
    $allTabsClass    = "jfb_admin_tab";
    $allTabBtnsClass = "jfb_admin_tab_btn";
    $tabIds          = array("jfb_admin_fbsetup", "jfb_admin_basicoptions", "jfb_admin_premiumoptions", "jfb_admin_uninstall", "jfb_admin_supportinfo");
    $tabNames        = array("Facebook Setup",    "Basic Options",          "Premium Options",          "Uninstall",           "Support Info");
    ?>
    
    <script type="text/javascript">
        function jfb_swap_tabs(show_tab_num) 
        {
            //Find the ID of the tab we want to show
            var tabIds = <?php echo json_encode($tabIds);?>;
            var show_tab_id = tabIds[show_tab_num];
            
            //Hide all the tabs, then show just the one specified
        	jQuery(".<?php echo $allTabsClass ?>").hide();
        	jQuery("#" + show_tab_id).show();

        	//Unhighlight all the tab buttons, then highlight just the one specified
        	jQuery(".<?php echo $allTabBtnsClass?>").attr("class", "<?php echo $allTabBtnsClass?>");
        	jQuery("#" + show_tab_id + "_btn").addClass("jfb-admin_tab_selected");
		}
		
		//When the page is loaded, if there's a hash like "#1, #2, etc" in the URL, switch to that tab.
		//This handles restoring the previously-displayed tab after a page refresh.
		jQuery(document).ready(function() 
		{
    		if(window.location.hash)
    		{
    		    var num = parseInt(window.location.hash.substr(1));
    		    if( !isNaN(num) )
    		      jfb_swap_tabs(num);
    		}
        });
	</script>
	        
    <div>     
         <ul class="jfb-admin_tabs"><?php
             for($i=0; $i < count($tabIds); $i++)
             {
                 ?><li id="<?php echo $tabIds[$i]?>_btn" class="<?php echo $allTabBtnsClass?> <?php echo ($shownTab==$i?"jfb-admin_tab_selected":"")?>"><a href="#<?php echo $i;?>" onclick="jfb_swap_tabs('<?php echo $i?>');"><?php echo $tabNames[$i];?></a></li><?php
             }
       ?></ul>
     </div>
     
    <div class="jfb-admin_wrapper">
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[0]?>" style="display:<?php echo ($shownTab==0?"block":"none")?>">
        	<h3>Setup Instructions</h3>
            To allow your users to login with their Facebook accounts, you must first setup a Facebook Application for your website:<br /><br />
            <ol>
			  <li>Visit <a href="http://developers.facebook.com/apps" target="lnk">developers.facebook.com/apps</a> and select "Create a New App" from the "Apps" menu at the top.</li>
			  <li>Type in a name (i.e. the name of your site), select a category, and click "Create App."</li>
			  <li>Go to the "Settings" page and click "Add Platform," then "Website," then fill in your "Site URL."<br/>
			  	  Note: http://example.com/ and http://www.example.com/ are <i>not</i> the same.</li>
			  <li>Also on the "Settings" page, enter a Contact EMail and save changes.</li>
			  <li>Go to the "Status &amp; Review" page and make the app live (flip the switch at the top).</li>
			  <li>Copy the App ID and App Secret to the boxes below, and click the "Connect" button.</li>
            </ol>
            <br />That's it!  Now you can add this plugin's <a href="<?php echo admin_url('widgets.php')?>">sidebar widget</a>, or if you're using BuddyPress, a Facebook button will be automatically added to its built-in login panel.<br /><br />
            For more complete documentation and help, visit the <a href="<?php echo $jfb_homepage?>">plugin homepage</a>.<br />
             
            <br />
            <hr />
            
            <h3>Facebook Connect</h3>
            <form name="formFacebook" method="post" action="">
                <input type="text" size="40" name="<?php echo $opt_jfb_api_key?>" value="<?php echo get_option($opt_jfb_api_key) ?>" /> App ID<br />
                <input type="text" size="40" name="<?php echo $opt_jfb_api_sec?>" value="<?php echo get_option($opt_jfb_api_sec) ?>" /> App Secret
                <input type="hidden" name="fb_opts_updated" value="1" />
                <div class="submit"><input type="submit" name="Submit" value="Connect" /></div>
            </form>
        </div> <!-- End Tab -->
        
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[1]?>" style="display:<?php echo ($shownTab==1?"block":"none")?>">
            <?php
            if(!get_option($opt_jfb_valid))
                echo "<div class=\"jfb-admin_warning\"><i><b>You must enter a valid APP ID and Secret under the \"Facebook Setup\" tab before this plugin will function.</b></i></div>";    
            ?>
            <h3>Basic Options</h3>
            <form name="formMainOptions" method="post" action="">
                <b>Autoregistered Usernames:</b><br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="0" <?php echo (get_option($opt_jfb_username_style)==0?"checked='checked'":"")?> >Based on Facebook ID (i.e. FB_123456)<br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="1" <?php echo (get_option($opt_jfb_username_style)==1?"checked='checked'":"")?> >Based on real name with prefix (i.e. FB_John_Smith)<br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="3" <?php echo (get_option($opt_jfb_username_style)==3?"checked='checked'":"")?> >Based on real name without prefix (i.e. John_Smith) <i><b>(Recommended for BuddyPress)</b></i><br />
                <input type="radio" name="<?php echo $opt_jfb_username_style; ?>" value="2" <?php echo (get_option($opt_jfb_username_style)==2?"checked='checked'":"")?> >Legacy Format (i.e. John.Smith) 
                <i><b>(Not Recommended,</b></i> <?php jfb_output_simple_lightbox("Click for more info", "Although the original 'BuddyPress-friendly' username format included a period, I later learned that this creates issues with author links in Wordpress.  I've left the option here for legacy support, but advise against using it (unless you have only one author on your blog, in which case Facebook-connected users won't have author links and so it doesn't matter).  If you do have multiple authors and are experiencing broken author links, changing this option will fix it for all NEW users, but you may want to consider fixing your existing users by replacing all of the '.'s with '_'s in the 'user_nicename' field of the 'wp_users' database table."); ?><i><b>)</b></i><br /><br />
            
                <b>E-Mail:</b><br />
                <input type="checkbox" name="<?php echo $opt_jfb_ask_perms?>" value="1" <?php echo get_option($opt_jfb_ask_perms)?'checked="checked"':''?> /> Request permission to get the connecting user's email address<br />
        
                <br /><b>Announcement:</b><br />
        		<?php add_option($opt_jfb_stream_content, "has connected to " . get_option('blogname') . " with WP-FB AutoConnect."); ?>
        		<input type="checkbox" name="<?php echo $opt_jfb_ask_stream?>" value="1" <?php echo get_option($opt_jfb_ask_stream)?'checked="checked"':''?> /> Request permission to post the following announcement on users' Facebook walls when they connect for the first time:<br />
        		<input type="text" size="100" name="<?php echo $opt_jfb_stream_content?>" value="<?php echo get_option($opt_jfb_stream_content) ?>" /><br />
        		<small><i><b>*Note:</b> In order to use this feature, you'll need to submit your app for review by Facebook.</i></small>  <?php jfb_output_simple_lightbox("(Click for more info)", "As a new requirement Facebook introduced in 2014, asking for anything more than a user's basic profile, e-mail, and friends list requires you to submit your app for review.  For more information, see <a target='app-review' href='https://developers.facebook.com/docs/apps/review/login'>here</a>.<br/><br/>In order to post to your users' timelines, your app will need the 'publish_actions' extended permission.  To request it:<br/>1) Visit to your app's configuration page on <a target='appconsole' href='https://developers.facebook.com/apps'>developers.facebook.com/apps</a><br />2) Go to 'Status &amp; Review-&gt;Start a Submission'<br/>3) Check 'publish_actions,' and proceed with the submission<br/><br/>Facebook claims the review process will take 7-14 days, after which this feature will work properly.") ?><br/>
        
        		<br /><b>Avatars:</b><br />
                <input type="checkbox" name="<?php echo $opt_jfb_wp_avatars?>" value="1" <?php echo get_option($opt_jfb_wp_avatars)?'checked="checked"':''?> /> Use Facebook profile pictures as avatars<br />
        
                <br /><b>Appreciation:</b><br />
                <input type="checkbox" name="<?php echo $opt_jfb_show_credit?>" value="1" <?php echo get_option($opt_jfb_show_credit)?'checked="checked"':''?> /> Display a "Powered By" link in the blog footer (would be appreciated! :))<br />
                <input type="checkbox" name="<?php echo $opt_jfb_reportstats?>" value="1" <?php echo get_option($opt_jfb_reportstats)?'checked="checked"':''?> /> Periodically report usage stats to the plugin author.  <?php jfb_output_simple_lightbox("(Click for more info)", "Reports include some very basic server info & a login count, to help me understand how & where the plugin is most used, and how I should focus my development.  No names or e-mail addresses are sent.");?><br />
        
        		<br /><b>Debug:</b><br />
        		<?php add_option($opt_jfb_email_to, get_bloginfo('admin_email')); ?>
        		<input id="log_mainoption" type="checkbox" name="<?php echo $opt_jfb_email_logs?>" value="1" <?php echo get_option($opt_jfb_email_logs)?'checked="checked"':''?> /> Send event logs to <input type="text" size="40" name="<?php echo $opt_jfb_email_to?>" value="<?php echo get_option($opt_jfb_email_to) ?>" /> <?php jfb_output_simple_lightbox("(Click for more info)", "Event logs show detailed information about the login process, and are useful for debugging various types of issues.  However, note that this option will send you an e-mail <i>every time</i> the login form is submitted - whether it's by a person or an automated spambot probing your site for vulnerabilities.  The latter type of submission is very common and is nothing to worry about, as both Wordpress and this plugin have various types of security to prevent the bots from getting in.  To avoid these spambot-generated messages, you may disable the suboption below.");?><br />
        		<input id="log_suboption" style="margin-left:20px;" type="checkbox" name="<?php echo $opt_jfb_email_logs_missingpost?>" value="1" <?php echo get_option($opt_jfb_email_logs_missingpost)?'checked="checked"':''?> /> ...Including "Missing POST Data" error events<br />
        		<input type="checkbox" name="<?php echo $opt_jfb_disablenonce?>" value="1" <?php echo get_option($opt_jfb_disablenonce)?'checked="checked"':''?> /> Disable nonce security check (Not recommended)<br />
                <input type="checkbox" name="<?php echo $opt_jfb_delay_redir?>" value="1" <?php echo get_option($opt_jfb_delay_redir)?'checked="checked"':''?> /> Delay redirect after login (<i><u>Not for production sites!</u></i>)<br />
                <input type="checkbox" name="<?php echo $opt_jfb_fulllogerr?>" value="1" <?php echo get_option($opt_jfb_fulllogerr)?'checked="checked"':''?> /> Show full log on error (<i><u>Not for production sites!</u></i>)<br />
                <script type="text/javascript">
	                jQuery('#log_suboption').change(function()
	                {
					  if(jQuery(this).is(':checked'))
					    jQuery('#log_mainoption').prop('checked', true);
					});
					jQuery('#log_mainoption').change(function()
	                {
					  if(!jQuery(this).is(':checked'))
					    jQuery('#log_suboption').prop('checked', false);
					});
				</script>

                <input type="hidden" name="main_opts_updated" value="1" />
                <div class="submit"><input type="submit" name="Submit" value="Save" /></div>
            </form>
    	</div><!-- End Tab -->
    
    	<div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[2]?>" style="display:<?php echo ($shownTab==2?"block":"none")?>">
            <?php
            if(!get_option($opt_jfb_valid))
                echo "<div class=\"jfb-admin_warning\"><i><b>You must enter a valid APP ID and Secret under the \"Facebook Setup\" tab before this plugin will function.</b></i></div>";    
            if( function_exists('jfb_output_premium_panel')) 
                jfb_output_premium_panel(); 
            else
                jfb_output_premium_panel_tease(); 
            ?>
        </div> <!-- End Tab -->
        
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[3]?>" style="display:<?php echo ($shownTab==3?"block":"none")?>">
            <h3>Delete All Plugin Options</h3>
            The following button will <i>permanently</i> delete all of this plugin's options from your Wordpress database, as if it had never been installed.  Use with care!
            <form name="formDebugOptions" method="post" action="">
                <input type="hidden" name="remove_all_settings" value="1" />
                <div class="submit"><input type="submit" name="Submit" value="Delete" /></div>
            </form>
        </div> <!-- End Tab -->
        
        <div class="<?php echo $allTabsClass ?>" id="<?php echo $tabIds[4]?>" style="display:<?php echo ($shownTab==4?"block":"none")?>">
            <h3>Support Information</h3>
            <div style="width:600px;">
            Before submitting a support request, please make sure to carefully read all the documentation and FAQs on the <a href="<?php echo $jfb_homepage; ?>#faq" target="_support">plugin homepage</a>.  Every problem that's ever been reported has a solution posted there.<br /><br />                        
            If you do choose to submit a request, please do so via the <a href="<?php echo $jfb_homepage; ?>#feedback" target="_support">plugin homepage</a>, <i><b><u>not</u></b></i> on Wordpress.org (which I rarely check).  Also, please <i><u>specifically mention</u></i> that you've tried it with all other plugins disabled and the default theme (see <a href="<?php echo $jfb_homepage ?>#faq100" target="_faq100">FAQ100</a>) and include the following information about your Wordpress environment:<br /><br />            
            </div>
            <div class="jfb-greybox">
                Host URL: <b><?php echo $_SERVER["HTTP_HOST"] ?></b><br />
                Site URL: <b><?php echo get_bloginfo('url') ?></b><br />
                Wordpress URL: <b><?php echo get_bloginfo('wpurl') ?></b><br />
            	Wordpress Version: <b><?php echo $GLOBALS['wp_version']; ?></b><br />
            	BuddyPress Version: <b><?php echo defined('BP_VERSION')?BP_VERSION:"Not Detected"; ?></b><br />
            	MultiSite Status: <b> <?php echo (defined('WP_ALLOW_MULTISITE')?"Allowed":"Off") . " / " . (function_exists('is_multisite')?(is_multisite()?"Enabled":"Disabled"):"Undefined"); ?></b><br />
            	Browser Version: <b><?php $browser = jfb_get_browser(); echo $browser['shortname'] . " " . $browser['version'] . " for " . $browser['platform']; ?></b><br />
            	Plugin Version: <b><?php echo $jfb_version ?></b><br />
    			Addon Version: <b><?php echo defined('JFB_PREMIUM_VER')?JFB_PREMIUM_VER:"Not Detected";?></b><br />
				Facebook API: <b><?php echo class_exists('Facebook')?"Already present!":"OK" ?></b><br />
				Facebook App: <b><?php echo get_option($opt_jfb_app_id)?get_option($opt_jfb_app_id):"&lt;Unset&gt;"?></b><br/>
				Facebook Reachable: 
                <b><?php 
                $result = jfb_api_get("https://graph.facebook.com/platform");
                if(!$result)                       echo "NO (Empty Reply)";
                else if (isset($result['error']))  echo "NO (" . isset($result['error']['message'])?$result['error']['message']:"Unknown" . ")";
                else if (!$result['is_published']) echo "NO (is_published=false)";
                else                               echo "OK";
                ?></b><br/>
				Facebook Validated: <b><?php echo get_option($opt_jfb_valid)?"OK":"NO"?></b><br/>
                Theme: <b><?php echo get_current_theme(); ?></b><br />
                Server: <b><?php echo substr($_SERVER['SERVER_SOFTWARE'], 0, 45) . (strlen($_SERVER['SERVER_SOFTWARE'])>45?"...":""); ?></b><br />
                Active Plugins: 
                <?php $active_plugins = get_option('active_plugins');
                      $plug_info=get_plugins();
                      echo "<b>" . count($active_plugins) . "</b><small> (";
        	          foreach($active_plugins as $name) echo $plug_info[$name]['Title']. " " . $plug_info[$name]['Version']."; ";
        	          echo "</small>)<br />"
                ?><br />
            </div>
        </div> <!-- End Tab -->
    
    </div><!-- div jfb-admin_wrapper -->  
   </div> <!-- div wrap -->
<?php
}


/*
 * Simple helper to output my "simple lightbox" for "click for more info" links.
 * Based on http://stephenmcintyre.net/blog/simple-css-lightbox
 */
function jfb_output_simple_lightbox($linkCaption, $contents)
{
    global $jfbLbID;
    if(!isset($jfbLbID)) $jfbLbID = 0;
    else                 $jfbLbID++;
    ?>
    <a class="wpfb-moreinfo-lnk" href="javascript:void(0)" title="<?php echo $contents?>" onclick="document.getElementById('wpfb-moreinfo-bg<?php echo $jfbLbID?>').style.display='block'; document.getElementById('wpfb-moreinfo-box<?php echo $jfbLbID?>').style.display='block';"><?php echo $linkCaption; ?></a>
    <div class="wpfb-moreinfo-bg" id="wpfb-moreinfo-bg<?php echo $jfbLbID?>" onclick="document.getElementById('wpfb-moreinfo-bg<?php echo $jfbLbID?>').style.display='none'; document.getElementById('wpfb-moreinfo-box<?php echo $jfbLbID?>').style.display='none';"></div>
    <div class="wpfb-moreinfo-box" id="wpfb-moreinfo-box<?php echo $jfbLbID?>">
      <a href="javascript:void(0)" onclick="document.getElementById('wpfb-moreinfo-bg<?php echo $jfbLbID?>').style.display='none'; document.getElementById('wpfb-moreinfo-box<?php echo $jfbLbID?>').style.display='none';">Close</a><br />
      <div style="padding:5px;">
        <?php echo $contents; ?>
      </div>
    </div>
    <?php
}


/*********************************************************************************/
/**********************Premium Teaser - show the premium options******************/
/*********************************************************************************/

/*
 * This is an exact copy of jfb_output_premium_panel() from the premium addon; it of course just doesn't include implementation...
 */
function jfb_output_premium_panel_tease()
{
    global $jfb_homepage;
    global $opt_jfbp_notifyusers, $opt_jfbp_notifyusers_subject, $opt_jfbp_notifyusers_content, $opt_jfbp_commentfrmlogin, $opt_jfbp_wploginfrmlogin, $opt_jfbp_registrationfrmlogin, $opt_jfbp_bpregistrationfrmlogin, $opt_jfbp_cache_avatars, $opt_jfbp_cache_avatars_fullsize, $opt_jfbp_cache_avatar_dir, $opt_jfbp_cachedir_changetoblog;
    global $opt_jfbp_buttonstyle, $opt_jfbp_buttonsize, $opt_jfbp_buttontext, $opt_jfbp_buttonimg, $opt_jfbp_requirerealmail;
    global $opt_jfbp_redirect_new, $opt_jfbp_redirect_new_custom, $opt_jfbp_redirect_existing, $opt_jfbp_redirect_existing_custom, $opt_jfbp_redirect_logout, $opt_jfbp_redirect_logout_custom;
    global $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url, $opt_jfbp_restrict_reg_uid, $opt_jfbp_restrict_reg_pid, $opt_jfbp_restrict_reg_gid;
    global $opt_jfbp_show_spinner, $opt_jfbp_allow_link, $opt_jfbp_allow_disassociate, $opt_jfbp_autoregistered_role, $jfb_data_url;
    global $opt_jfbp_wordbooker_integrate, $opt_jfbp_signupfrmlogin, $opt_jfbp_localize_facebook;
    global $opt_jfbp_xprofile_map, $opt_jfbp_xprofile_mappings, $jfb_xprofile_field_prefix;
    global $opt_jfbp_bpstream_login, $opt_jfbp_bpstream_logincontent, $opt_jfbp_bpstream_register, $opt_jfbp_bpstream_registercontent;
    function disableatt() { echo (defined('JFB_PREMIUM')?"":"disabled='disabled'"); }
    ?>
    <!--Show the Premium version number along with a link to immediately check for updates-->
    <form name="formPremUpdateCheck" method="post" action="">
        <h3>Premium Options <?php echo (defined('JFB_PREMIUM_VER')?"<span style='font-size:x-small;'>(<a href=\"javascript:document.formPremUpdateCheck.submit();\">Check for Updates</a>)</span>":""); ?></h3>
        <input type="hidden" name="VersionCheckNow" value="1" />
    </form>
    
    <?php 
    if( !defined('JFB_PREMIUM') )
        echo "<div class=\"jfb-admin_warning\"><i><b>The following options are available to Premium users only.</b><br />For information about the WP-FB-AutoConnect Premium Add-On, including purchasing instructions, please visit the plugin homepage <b><a href=\"$jfb_homepage#premium\">here</a></b></i>.</div>";
    ?>
    
    <form name="formPremOptions" method="post" action="">
    
        <b>MultiSite Support:</b><br/>
        <input disabled='disabled' type="checkbox" name="musupport" value="1" <?php echo ((defined('JFB_PREMIUM')&&function_exists('is_multisite')&&is_multisite())?"checked='checked'":"")?> >
        Automatically enabled when a MultiSite install is detected
        <?php jfb_output_simple_lightbox("(Click for more info)", "The free plugin is not aware of users registered on other sites in your WPMU installation, which can result in problems i.e. if someone tries to register on more than one site.  The Premium version will actively detect and handle existing users across all your sites.")?><br /><br />

        <b>Button Style:</b><br />
        <?php add_option($opt_jfbp_buttontext, "Login with Facebook");
        add_option($opt_jfbp_buttonsize, "2");
        $btnDefault = $jfb_data_url . "/assets/btn01.png";
        add_option($opt_jfbp_buttonimg, $btnDefault);
        $btnPreview = get_option($opt_jfbp_buttonimg);
        if(!$btnPreview) $btnPreview = $btnDefault;
        ?>

        <input <?php disableatt() ?> type="radio" style="float:left;" name="<?php echo $opt_jfbp_buttonstyle; ?>" value="0" <?php echo (get_option($opt_jfbp_buttonstyle)==0?"checked='checked'":"")?>>
        <div class="jfb-greybox" style="float:left;">
            <b>Original (xfbml):</b><br/>
            Text: <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_buttontext; ?>" value="<?php echo get_option($opt_jfbp_buttontext); ?>" /><br />
            Style: 
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="2" <?php echo (get_option($opt_jfbp_buttonsize)==2?"checked='checked'":"")?>>Small
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="3" <?php echo (get_option($opt_jfbp_buttonsize)==3?"checked='checked'":"")?>>Medium
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="4" <?php echo (get_option($opt_jfbp_buttonsize)==4?"checked='checked'":"")?>>Large
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="5" <?php echo (get_option($opt_jfbp_buttonsize)==5?"checked='checked'":"")?>>X-Large<br />
        </div><br clear="all"/>
        <input <?php disableatt() ?> type="radio" style="float:left;" name="<?php echo $opt_jfbp_buttonstyle; ?>" value="1" <?php echo (get_option($opt_jfbp_buttonstyle)==1?"checked='checked'":"")?>>
        <div class="jfb-greybox" style="float:left;">
            <b>Image (styleable):</b><br/>
            URL: <input <?php disableatt() ?> type="text" size="80" name="<?php echo $opt_jfbp_buttonimg; ?>" value="<?php echo get_option($opt_jfbp_buttonimg); ?>" /><br/>
            Preview: <img style="vertical-align:middle;margin-top:5px;" src="<?php echo $btnPreview?>" alt="(Login Button)" />
        </div><br clear="all"/><br/>
        
        <b>Additional Buttons:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_commentfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_commentfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button below the comment form<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_wploginfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_wploginfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button to the standard Login page (wp-login.php)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_registrationfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_registrationfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button to the Registration page (wp-login.php)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_bpregistrationfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_bpregistrationfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button to the BuddyPress Registration page (/register)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_signupfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_signupfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button to the Signup page (wp-signup.php) (WPMU Only)<br /><br />
                        
        <!-- Facebook's OAuth 2.0 migration BROKE my ability to localize the XFBML-generated dialog.  I've reported a bug, and will do my best to fix it as soon as possible.
         <b>Facebook Localization:</b><br />
        <?php add_option($opt_jfbp_localize_facebook, 1); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_localize_facebook?>" value="1" <?php echo get_option($opt_jfbp_localize_facebook)?"checked='checked'":""?> >
        Translate Facebook prompts to the same locale as your Wordpress blog (Detected locale: <i><?php echo ( (defined('WPLANG')&&WPLANG!="") ? WPLANG : "en_US" ); ?></i>)
        <dfn title="The Wordpress locale is specified in wp-config.php, where valid language codes are of the form 'en_US', 'ja_JP', 'es_LA', etc.  Please see http://codex.wordpress.org/Installing_WordPress_in_Your_Language for more information on localizing Wordpress, and http://developers.facebook.com/docs/internationalization/ for a list of locales supported by Facebook.">(Mouseover for more info)</dfn><br /><br />
         -->
                        
        <b>Avatar Caching:</b><br />  
        <?php add_option($opt_jfbp_cache_avatars_fullsize, get_option($opt_jfbp_cache_avatars)); ?>       
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_cache_avatars?>" value="1" <?php echo get_option($opt_jfbp_cache_avatars)?'checked="checked"':''?> />
        Cache Facebook avatars locally (thumbnail) <?php jfb_output_simple_lightbox("(Click for more info)", "This will make a local copy of Facebook avatars, so they'll always load reliably, even if Facebook's servers go offline or if a user deletes their photo from Facebook. They will be fetched and updated whenever a user logs in.");?><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_cache_avatars_fullsize?>" value="1" <?php echo get_option($opt_jfbp_cache_avatars_fullsize)?'checked="checked"':''?> />
        Cache Facebook avatars locally (fullsize) <?php jfb_output_simple_lightbox("(Click for more info)", "Because most themes only utilize thumbnail-sized avatars, caching full-sized images is often unnecessary.  If you're not actually using full-sized avatars I recommend disabling this option, as doing so will speed up logins and save space on your server (there's a small per-login performance cost to copying the files locally).")?><br />
        
        <?php add_option($opt_jfbp_cache_avatar_dir, 'facebook-avatars'); ?>
        Cache dir:
            <?php
            //If this is multisite, we'll allow the use of the uploaddir of *any* blog in the network (not just the current one).
            //This way, all the blogs can share the same avatar cache if desired.
            if(function_exists('is_multisite') && is_multisite())
            {
                global $wpdb;
                $blogs = $wpdb->get_results( $wpdb->prepare("SELECT blog_id, domain, path FROM $wpdb->blogs WHERE site_id = %d AND public = '1' AND archived = '0' AND mature = '0' AND spam = '0' AND deleted = '0' ORDER BY registered ASC", $wpdb->siteid), ARRAY_A );
                echo "<select name='".$opt_jfbp_cachedir_changetoblog."'>";
                foreach ($blogs AS $blog)
                {
                    switch_to_blog($blog['blog_id']);
                    $path = wp_upload_dir();
                    restore_current_blog();
                    $selectedBlogID = get_option($opt_jfbp_cachedir_changetoblog);
                    if($selectedBlogID == 0) $selectedBlogID = get_current_blog_id();
                    $selected = ($selectedBlogID == $blog['blog_id'])?" selected='true' ":'';
                    echo '<option '.$selected.' value="'.$blog['blog_id'].'">'.$path['basedir'].'</option>';
                }
                echo "</select>\\";
            }
            //If this is NOT multisite, we'll always use the current blog's upload_dir as the basedir for our avatar cache
            else
            {
                $path = wp_upload_dir();
                update_option($opt_jfbp_cachedir_changetoblog, 0);
                ?><span style="background-color:#FFFFFF; color:#aaaaaa; padding:2px 0;"><i><?php echo $path['basedir']; ?>/</i></span><?php
            }
            ?>
        <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_cache_avatar_dir; ?>" value="<?php echo get_option($opt_jfbp_cache_avatar_dir); ?>" />
        <?php jfb_output_simple_lightbox("(Click for more info)", "Changing the cache directory will not move existing avatars or update existing users; it only applies to subsequent logins.  It's therefore recommended that you choose a cache directory once, then leave it be.")?><br /><br />

        <b>Manual Linking &amp; Unlinking:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_allow_link?>" value="1" <?php echo get_option($opt_jfbp_allow_link)?'checked="checked"':''?> /> Allow users to manually link their Wordpress/Buddypress accounts to Facebook
        <?php jfb_output_simple_lightbox("(Click for more info)", "This will add a button to each non-Facebook-connected user's Wordpress (and Buddypress) profile page, allowing them to manually link their blog account to their Facebook profile.  Although this plugin does try to match connecting Facebook users to existing Wordpress accounts by e-mail, this option provides a way for users to explicitly identify their local blog account - even if their e-mails don't match.")?><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_allow_disassociate?>" value="1" <?php echo get_option($opt_jfbp_allow_disassociate)?'checked="checked"':''?> /> Allow users to disassociate their Wordpress/Buddypress accounts from Facebook
        <?php jfb_output_simple_lightbox("(Click for more info)", "This will add a button to each connected user's Wordpress (and Buddypress) profile page, allowing them to disassociate their blog account from their Facebook profile.  User accounts which are not connected to Facebook will display 'Not Connected' in place of a button.")?><br />
        <input disabled='disabled' type="checkbox" name="admindisassociate" value="1" <?php echo (defined('JFB_PREMIUM')?"checked='checked'":"")?> /> Allow administrators to disassociate Wordpress/Buddypress user accounts from Facebook
        <?php jfb_output_simple_lightbox("(Click for more info)", "This option is always enabled for administrators.")?><br /><br />

        <b>Shortcode Support:</b><br />
        <input disabled='disabled' type="checkbox" name="shortcodesupport" value="1" <?php echo (defined('JFB_PREMIUM')?"checked='checked'":"")?> />
        Enable shortcode for rendering Facebook buttons to your posts and pages
        <?php jfb_output_simple_lightbox("(Click for more info)", "Shortcode support will allow you to manually place Facebook login buttons in your posts or pages, simply by inserting the tag <b>[jfb_facebook_btn]</b> in their content. The Facebook button will only be shown when nobody is logged into the site; otherwise, nothing is shown.  If you'd like to specify something to output for logged-in users, you can use the 'loggedin' parameter, like <b>[jfb_facebook_btn loggedin='Welcome!']</b>.<br/><br/>With the Premium addon installed, shortcode support is always enabled.  For general information on Wordpress shortcode, please see <a href='http://codex.wordpress.org/Shortcode' target='shortcode'>here</a>.")?><br /><br />
            
        <b>Double Logins:</b><br />
        <input disabled='disabled' type="checkbox" name="doublelogin" value="1" <?php echo (defined('JFB_PREMIUM')?"checked='checked'":"")?> />
        Automatically handle double logins 
        <?php jfb_output_simple_lightbox("(Click for more info)", "If a visitor opens two browser windows, logs into one, then logs into the other, the security nonce check will fail.  This is because in the second window, the current user no longer matches the user for which the nonce was generated.  The free version of the plugin reports this to the visitor, giving them a link to their desired redirect page.  The premium version will transparently handle such double-logins: to visitors, it'll look like the page has just been refreshed and they're now logged in.  For more information on nonces, please visit http://codex.wordpress.org/WordPress_Nonces.")?><br /><br />

        <b>E-Mail Permissions:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_requirerealmail?>" value="1" <?php echo get_option($opt_jfbp_requirerealmail)?'checked="checked"':''?> /> Enforce access to user's real (unproxied) email
        <?php jfb_output_simple_lightbox("(Click for more info)", "The basic option to request user emails will prompt your visitors, but they can still hide their true addresses by using a Facebook proxy (click 'change' in the permissions dialog, and select 'xxx@proxymail.facebook.com').  This option performs a secondary check to enforce that they allow access to their REAL e-mail.  Note that the check requires several extra queries to Facebook's servers, so it could result in a slightly longer delay before the login initiates.")?><br /><br />
        
        <b>Wordbooker Avatar Integration:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_wordbooker_integrate?>" value="1" <?php echo get_option($opt_jfbp_wordbooker_integrate)?'checked="checked"':''?> /> Use Facebook avatars for <a href="http://wordpress.org/extend/plugins/wordbooker/">Wordbooker</a>-imported comments
        <?php jfb_output_simple_lightbox("(Click for more info)", "The Wordbooker plugin allows you to push blog posts to your Facebook wall, and also to import comments on these posts back to your blog.  This option will display real Facebook avatars for imported comments, provided the commentor logs into your site at least once.")?><br /><br />
        
        <b>Autoregistered User Role:</b><br />
        <?php
        add_option($opt_jfbp_autoregistered_role, get_option('default_role'));
        $currSelection = get_option($opt_jfbp_autoregistered_role);
        $editable_roles = get_editable_roles();
        if ( empty( $editable_roles[$currSelection] ) ) $currSelection = get_option('default_role');
        ?>
        Users who are autoregistered with Facebook will be created with the role: 
        <select <?php disableatt() ?> name="<?php echo $opt_jfbp_autoregistered_role?>" id="<?php echo $opt_jfbp_autoregistered_role?>">
            <?php wp_dropdown_roles( $currSelection ); ?>
        </select><br /><br />

        <b>Widget Appearance:</b><br />
        Please use the <a href="<?php echo admin_url('widgets.php') ?>" target="widgets">WP-FB AutoConnect <b><i>Premium</i></b> Widget</a> if you'd like to:<br />
        &bull; Customize the Widget's text <?php jfb_output_simple_lightbox("(Click for more info)", "You can customize the text of: User, Pass, Login, Remember, Forgot, Logout, Edit Profile, Welcome.")?><br />
        &bull; Show/Hide any of the Widget's links, checkboxes, or textfields  <?php jfb_output_simple_lightbox("(Click for more info)", "You can show or hide:<ul style='list-style-type:disc;list-style-position:inside;'><li>The User/Pass fields (leaving Facebook as the only way to login)</li><li>The 'Register' link (only applicable if registration is enabled on the site/network)</li><li>The 'Remember' tickbox</li><li>The 'Edit Profile' link</li><li>The 'Forgot Password' link</li></ul>")?><br />      
        &bull; Show the user's avatar next to their username (when logged in)<br />
        &bull; Point the "Edit Profile" link to the BP profile, rather than WP<br/>
        &bull; Point the "Forgot Password" link to a custom URL of your choosing<br />
        &bull; Allow the user to simultaneously logout of your site <i>and</i> Facebook<br /><br />
            
        <b>AJAX Spinner:</b><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="0" <?php echo (get_option($opt_jfbp_show_spinner)==0?"checked='checked'":"")?> >Don't show an AJAX spinner<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="1" <?php echo (get_option($opt_jfbp_show_spinner)==1?"checked='checked'":"")?> >Show a white AJAX spinner to indicate the login process has started (<img src=" <?php echo $jfb_data_url ?>/assets/spinner_white.gif" alt="spinner" />)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="2" <?php echo (get_option($opt_jfbp_show_spinner)==2?"checked='checked'":"")?> >Show a black AJAX spinner to indicate the login process has started (<img src=" <?php echo $jfb_data_url ?>/assets/spinner_black.gif" alt="spinner" />)<br /><br />
                
        <b>AutoRegistration Restrictions:</b><br />
        <?php add_option($opt_jfbp_restrict_reg_url, '/') ?>
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="0" <?php echo (get_option($opt_jfbp_restrict_reg)==0?"checked='checked'":"")?>>Open: Anyone can login (Default)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="1" <?php echo (get_option($opt_jfbp_restrict_reg)==1?"checked='checked'":"")?>>Closed: Only login existing blog users<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="2" <?php echo (get_option($opt_jfbp_restrict_reg)==2?"checked='checked'":"")?>>Invitational: Only login users who've been invited via the <a href="http://wordpress.org/extend/plugins/wordpress-mu-secure-invites/">Secure Invites</a> plugin <?php jfb_output_simple_lightbox("(Click for more info)", "For invites to work, the connecting user's Facebook email must be accessible, and it must match the email to which the invitation was sent.")?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="3" <?php echo (get_option($opt_jfbp_restrict_reg)==3?"checked='checked'":"")?>>Friendship: Only login users who are friends with uid <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_restrict_reg_uid?>" value="<?php echo get_option($opt_jfbp_restrict_reg_uid) ?>" /> on Facebook <?php jfb_output_simple_lightbox("(Click for more info)", "To find your Facebook uid, login and view your Profile Pictures album.  The URL will be something like 'http://www.facebook.com/media/set/?set=a.123.456.789'.  In this example, your uid would be 789 (the numbers after the last decimal point).")?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="4" <?php echo (get_option($opt_jfbp_restrict_reg)==4?"checked='checked'":"")?>>Membership: Only login users who are members of group id <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_restrict_reg_gid?>" value="<?php echo get_option($opt_jfbp_restrict_reg_gid); ?>" /> on Facebook <?php jfb_output_simple_lightbox("(Click for more info)", "To find a groups's id, view its URL.  It will be something like 'http://www.facebook.com/group.php?gid=12345678'.  In this example, the group id would be 12345678.")?><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="5" <?php echo (get_option($opt_jfbp_restrict_reg)==5?"checked='checked'":"")?>>Fanpage: Only login users who are fans of page id <input <?php disableatt() ?> type="text" size="15" name="<?php echo $opt_jfbp_restrict_reg_pid?>" value="<?php echo get_option($opt_jfbp_restrict_reg_pid); ?>" /> on Facebook <?php jfb_output_simple_lightbox("(Click for more info)", "To find a page's id, view one of its photo albums.  The URL will be something like 'http://www.facebook.com/media/set/?set=a.123.456.789'.  In this example, the id would be 789 (the numbers after the last decimal point).")?><br />
        Redirect URL for denied logins: <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_restrict_reg_url?>" value="<?php echo get_option($opt_jfbp_restrict_reg_url) ?>" /><br /><br />
                
        <b>Custom Redirects:</b><br />
        <?php add_option($opt_jfbp_redirect_new, "1"); ?>
        <?php add_option($opt_jfbp_redirect_existing, "1"); ?>
        <?php add_option($opt_jfbp_redirect_logout, "1"); ?>
        When a new user is autoregistered on your site, redirect them to:<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_new; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_new)==1?"checked='checked'":"")?> >Default (refresh current page)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_new; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_new)==2?"checked='checked'":"")?> >Custom URL:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_new_custom?>" value="<?php echo get_option($opt_jfbp_redirect_new_custom) ?>" /> <small>(Supports %username% variables)</small><br /><br />
        When an existing user returns to your site, redirect them to:<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_existing; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_existing)==1?"checked='checked'":"")?> >Default (refresh current page)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_existing; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_existing)==2?"checked='checked'":"")?> >Custom URL:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_existing_custom?>" value="<?php echo get_option($opt_jfbp_redirect_existing_custom) ?>" /> <small>(Supports %username% variables)</small><br /><br />
        When a user logs out of your site, redirect them to:<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_logout; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_logout)==1?"checked='checked'":"")?> >Default (refresh current page)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_logout; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_logout)==2?"checked='checked'":"")?> >Custom URL:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_logout_custom?>" value="<?php echo get_option($opt_jfbp_redirect_logout_custom) ?>" /><br /><br />

        <b>Welcome Message:</b><br />
        <?php add_option($opt_jfbp_notifyusers_content, "Thank you for logging into " . get_option('blogname') . " with Facebook.\nIf you would like to login manually, you may do so with the following credentials.\n\nUsername: %username%\nPassword: %password%"); ?>
        <?php add_option($opt_jfbp_notifyusers_subject, "Welcome to " . get_option('blogname')); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_notifyusers?>" value="1" <?php echo get_option($opt_jfbp_notifyusers)?'checked="checked"':''?> /> Send a custom welcome e-mail to users who register via Facebook <small>(*If we know their address)</small><br />
        <input <?php disableatt() ?> type="text" size="102" name="<?php echo $opt_jfbp_notifyusers_subject?>" value="<?php echo get_option($opt_jfbp_notifyusers_subject) ?>" /><br />
        <textarea <?php disableatt() ?> cols="85" rows="5" name="<?php echo $opt_jfbp_notifyusers_content?>"><?php echo get_option($opt_jfbp_notifyusers_content) ?></textarea><br /><br />

        <b>BuddyPress Activity Stream:</b><br />
        <?php add_option($opt_jfbp_bpstream_logincontent, "%user% logged in with Facebook"); ?>
        <?php add_option($opt_jfbp_bpstream_registercontent, "%user% registered with Facebook"); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_bpstream_register?>" value="1" <?php echo get_option($opt_jfbp_bpstream_register)?'checked="checked"':''?> /> When a new user autoconnects to your site, post to the BP Activity Stream:
        <input <?php disableatt() ?> type="text" size="50" name="<?php echo $opt_jfbp_bpstream_registercontent?>" value="<?php echo get_option($opt_jfbp_bpstream_registercontent) ?>" /><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_bpstream_login?>" value="1" <?php echo get_option($opt_jfbp_bpstream_login)?'checked="checked"':''?> /> When an existing user returns to your site, post to the BP Activity Stream:
        <input <?php disableatt() ?> type="text" size="50" name="<?php echo $opt_jfbp_bpstream_logincontent?>" value="<?php echo get_option($opt_jfbp_bpstream_logincontent) ?>" /><br /><br />
 
        <b>BuddyPress X-Profile Mappings</b><br />
        This section will let you automatically fill in your Buddypress users' X-Profile data from their Facebook profiles.<br />
        <small>&bull; Facebook fields marked with an asterisk (i.e. Birthday*) require the user to approve extra permissions during login.</small><br />
        <small>&bull; Some limitations exist regarding which X-Profile fields can be populated</small> <?php jfb_output_simple_lightbox("(Click for more info)", "Only 'Text Box,' 'Multi-Line Text Box,' and 'Date Selector'-type profile fields can be mapped at this time.  Due to unpredictability in matching freeform values from Facebook to pre-defined values on BuddyPress, support for dropdowns, radiobuttons, and checkboxes MAY be added in the future.")?><br />
        <small>&bull; Some limitations exist regarding which Facebook fields can be imported</small> <?php jfb_output_simple_lightbox("(Click for more info)", "Because some Facebook fields are formatted differently, each one needs to be explicitly implemented.  I've included an initial selection of fields (i.e. Name, Gender, Birthday, Bio, etc), but if you need another field to be available, please request it on the support page and I'll do my best to add it to the next update.")?><br /><br />
        
         <?php
         //If people report problems with Buddypress detection, use this more robust method: http://codex.buddypress.org/plugin-development/checking-buddypress-is-active/
         if( !function_exists('bp_has_profile') ) echo "<i>BuddyPress Not Found.  This section is only available on BuddyPress-enabled sites.</i>";
         else if ( !bp_has_profile() )            echo "Error: BuddyPress Profile Not Found.  This should never happen - if you see this message, please report it on the plugin support page.";
         else
         {
            //Present the 3 mapping options: disable mapping, map new users, or map new and returning users ?> 
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_xprofile_map; ?>" value="0" <?php echo (get_option($opt_jfbp_xprofile_map)==0?"checked='checked'":"")?> >Disable Mapping
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_xprofile_map; ?>" value="1" <?php echo (get_option($opt_jfbp_xprofile_map)==1?"checked='checked'":"")?> >Map New Users Only
            <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_xprofile_map; ?>" value="2" <?php echo (get_option($opt_jfbp_xprofile_map)==2?"checked='checked'":"")?> >Map New And Returning Users<br /><?php
            
            //Make a list of which Facebook fields may be mapped to each type of xProfile field.  Omitted types (i.e. checkbox) are treated as "unmappable."
            //The format is "xprofile_field_type"->"(fbfieldname1, fbfieldDisplayname1), (fbfieldname2, fbfieldDisplayname2), ..."
            //(Available FB fields are documented at: https://developers.facebook.com/docs/reference/api/user/)
            $allowed_mappings = array(
                'textbox' =>array('id'=>"ID", 'name'=>"Name", 'first_name'=>"First Name", 'middle_name'=>"Middle Name", 'last_name'=>"Last Name",
                                  'username'=>"Username", 'gender'=>"Gender", 'link'=>"Profile URL", "website"=>"Website*", 'bio'=>"Bio*", 
                                  'political'=>"Political*", "religion"=>"Religion*", 'relationship_status'=>"Relationship*", "location"=>"City*",
                                  'hometown'=>"Hometown*", 'languages'=>"Languages*", 'music'=>'Music*', 'interests'=>'Interests*'),
                'textarea'=>array('id'=>"ID", 'name'=>"Name", 'first_name'=>"First Name", 'middle_name'=>"Middle Name", 'last_name'=>"Last Name", 
                                  'username'=>"Username", 'gender'=>"Gender", 'link'=>"Profile URL", "website"=>"Website*", 'bio'=>"Bio*",
                                  'political'=>"Political*", "religion"=>"Religion*", 'relationship_status'=>"Relationship*", "location"=>"City*", 
                                  'hometown'=>"Hometown*", 'languages'=>"Languages*", 'music'=>'Music*', 'interests'=>'Interests*'),
                'datebox' =>array('birthday'=>'Birthday*'));
            $allowed_mappings = apply_filters('wpfb_xprofile_allowed_mappings', $allowed_mappings);

            //Go through all of the XProfile fields and offer possible Facebook mappings for each (in a dropdown).
            //(current_mappings is used to set the initial state of the panel, i.e. based on what mappings are already in the db)
            $current_mappings = get_option($opt_jfbp_xprofile_mappings);
            while ( bp_profile_groups() )
            {
                //Create a "box" for each XProfile Group
                global $group;
                bp_the_profile_group();
                ?><div style="width:420px; padding:5px; margin:2px 0; background-color:#EEEDDA; border:1px solid #CCC;"><?php
                echo "Group \"$group->name\":<br />";
                
                //And populate the group box with Textarea(xprofile field)->Dropdown(possible facebook mappings)
                while ( bp_profile_fields() )
                {
                    //Output the X-Profile field textarea
                    global $field;
                    bp_the_profile_field();
                    ?><input disabled='disabled' type="text" size="20" name="<?php echo $field->name ?>" value="<?php echo $field->name; ?>" /> -&gt;
                    
                    <?php 
                    //If there aren't any available Facebook mappings, just put a disabled textbox and "hidden" field that sets this option as '0' 
                    if( !$allowed_mappings[$field->type] )
                    {
                        echo "<input disabled='disabled' type='text' size='30' name='$field->name"."_unavail"."' value='(No Mappings Available)' />";
                        echo "<input type='hidden' name='$field->id' value='0' />";
                        continue;
                    }
                    
                    //Otherwise, list all of the available mappings in a dropdown.
                    ?><select name="<?php echo $jfb_xprofile_field_prefix . $field->id?>">
                        <option value="0">(No Mapping)</option><?php
                        foreach($allowed_mappings[$field->type] as $fbname => $userfriendlyname)
                            echo "<option " . ($current_mappings[$field->id]==$fbname?"selected":"") . " value=\"$fbname\">$userfriendlyname</option>";
                    ?></select><br /><?php
                }
                ?></div><?php
            }
        }?>
                                        
        <input type="hidden" name="prem_opts_updated" value="1" />
        <div class="submit"><input <?php disableatt() ?> type="submit" name="Submit" value="Save Premium" /></div>
    </form>
    <?php    
}


?>
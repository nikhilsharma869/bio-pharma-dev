<?php
/*
 Plugin Name: UppSite - Go Mobile
 Plugin URI: http://www.uppsite.com/learnmore/
 Description: Uppsite is a fully automated plugin to transform your blog into native smartphone apps. <strong>**** DISABLING THIS PLUGIN WILL PREVENT YOUR APP USERS FROM USING THE APPS! ****</strong>
 Author: UppSite
 Version: 4.1
 Author URI: https://www.uppsite.com
 */
require_once( dirname(__FILE__) . '/fbcomments_page.inc.php' );
if (!defined('MYSITEAPP_AGENT')):
define('MYSITEAPP_PLUGIN_VERSION', '4.1');
define('MYSITEAPP_WEBAPP_PREF_THEME', 'uppsite_theme_select');
define('MYSITEAPP_WEBAPP_PREF_TIME', 'uppsite_theme_time');
define('MYSITEAPP_WEBAPP_PREVIEW', 'uppsite_preview');
define('MYSITEAPP_OPTIONS_DATA', 'uppsite_data');
define('MYSITEAPP_OPTIONS_OPTS', 'uppsite_options');
define('MYSITEAPP_OPTIONS_PREFS', 'uppsite_prefs');
define('MYSITEAPP_AGENT','MySiteApp');
require_once( dirname(__FILE__) . '/env_helper.php' );
define('MYSITEAPP_TEMPLATE_ROOT', mysiteapp_get_template_root() );
define('MYSITEAPP_TEMPLATE_APP', MYSITEAPP_TEMPLATE_ROOT.'/mysiteapp');
define('MYSITEAPP_TEMPLATE_WEBAPP', MYSITEAPP_TEMPLATE_ROOT.'/webapp');
define('MYSITEAPP_TEMPLATE_LANDING', MYSITEAPP_TEMPLATE_ROOT.'/landing');
define('MYSITEAPP_WEBSERVICES_URL', 'http://api.uppsite.com');
define('MYSITEAPP_PUSHSERVICE', MYSITEAPP_WEBSERVICES_URL.'/push/notification.php');
define('MYSITEAPP_APP_DOWNLOAD_SETTINGS', MYSITEAPP_WEBSERVICES_URL.'/settings/options_response.php');
define('MYSITEAPP_APP_NATIVE_URL', MYSITEAPP_WEBSERVICES_URL.'/getapplink.php?v=2');
define('MYSITEAPP_AUTOKEY_URL', MYSITEAPP_WEBSERVICES_URL.'/autokeys.php');
define('MYSITEAPP_PREFERENCES_URL', MYSITEAPP_WEBSERVICES_URL . '/preferences.php?ver=' . MYSITEAPP_PLUGIN_VERSION);
define('MYSITEAPP_WEBAPP_MINISITE', MYSITEAPP_WEBSERVICES_URL.'/webapp/minisite.php?website=');
define('MYSITEAPP_WEBAPP_RESOURCES', 'http://static.uppsite.com/v3/webapp');
define('MYSITEAPP_FACEBOOK_COMMENTS_URL','http://graph.facebook.com/comments/?ids=');
define('MYSITEAPP_VIDEO_WIDTH', 270);
define('MYSITEAPP_ONE_DAY', 86400); 
define('MYSITEAPP_BUFFER_POSTS_COUNT', 5);
define('MYSITEAPP_HOMEPAGE_POSTS', 5);
define('MYSITEAPP_HOMEPAGE_MAX_CATEGORIES', 10);
define('MYSITEAPP_HOMEPAGE_DEFAULT_MIN_POSTS', 2);
define('MYSITEAPP_HOMEPAGE_FRESH_COVER', 'http://static.uppsite.com/plugin/cover.png');
if (!defined('MYSITEAPP_PLUGIN_BASENAME'))
    define('MYSITEAPP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if (!defined( 'WP_CONTENT_URL' ))
    define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
if (!defined('WP_CONTENT_DIR'))
    define('WP_CONTENT_DIR', ABSPATH.'wp-content');
if (!defined( 'WP_PLUGIN_URL'))
    define( 'WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
if (!defined('WP_PLUGIN_DIR'))
    define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');
function mysiteapp_should_preview_webapp() {
    if (isset($_COOKIE[MYSITEAPP_WEBAPP_PREVIEW]) && $_COOKIE[MYSITEAPP_WEBAPP_PREVIEW]) {
        return true;
    }
    if (isset($_REQUEST['uppPreview'])) {
        $previewRequest = $_REQUEST['uppPreview'];
        $hash = md5(get_bloginfo('pingback_url'));
        if ($previewRequest == $hash) {
                        setcookie(MYSITEAPP_WEBAPP_PREVIEW, true, time() + 60*60*24*30);
            return true;
        }
    }
    return false;
}
function mysiteapp_should_show_webapp() {
    $os = MySiteAppPlugin::detect_specific_os();
    if ($os == "wp") {
                return false;
    }
    $options = get_option(MYSITEAPP_OPTIONS_OPTS);
    return (isset($options['activated']) && $options['activated'] && isset($options['webapp_mode']) &&
        ($options['webapp_mode'] == "all" || $options['webapp_mode'] == "webapp_only")) || mysiteapp_should_preview_webapp();
}
function uppsite_get_native_app($type = "url", $os = null) {
    if (is_null($os)) {
        $os = MySiteAppPlugin::detect_specific_os();
    }
    if (!in_array($type, array("url", "identifier", "store_url", "banner"))) {
                return;
    }
    $options = get_option(MYSITEAPP_OPTIONS_DATA);
    if (!isset($options['native_apps'])) {
        return null;
    }
    $apps = $options['native_apps'];
    return isset($apps[$os]) && array_key_exists($type, $apps[$os]) ? $apps[$os][$type] : null;
}
function mysiteapp_should_show_landing() {
    $options = get_option(MYSITEAPP_OPTIONS_OPTS);
    $showLanding = isset($options['activated']) && $options['activated'] && isset($options['webapp_mode']) &&
        ($options['webapp_mode'] == "all" || $options['webapp_mode'] == "landing_only");
    if ($showLanding && !mysiteapp_should_show_webapp()) {
                $showLanding = $showLanding && !is_null(uppsite_get_native_app());
    }
    return $showLanding;
}
class MySiteAppPlugin {
    var $is_mobile = false;
    var $is_app = false;
    var $new_template = null;
    static $_mobile_ua_os = array(
        "ios" => array(
            "iPhone",
            "iPad",
            "iPod"
        ),
        "android" => array(
            "Android"
        ),
        "wp" => array(
            "Windows Phone"
        )
    );
    static $os = null;
    static $_mobile_ua = array(
        "WebTV",
        "AvantGo",
        "Blazer",
        "PalmOS",
        "lynx",
        "Go.Web",
        "Elaine",
        "ProxiNet",
        "ChaiFarer",
        "Digital Paths",
        "UP.Browser",
        "Mazingo",
        "Mobile",
        "T68",
        "Syncalot",
        "Danger",
        "Symbian",
        "Symbian OS",
        "SymbianOS",
        "Maemo",
        "Nokia",
        "Xiino",
        "AU-MIC",
        "EPOC",
        "Wireless",
        "Handheld",
        "Smartphone",
        "SAMSUNG",
        "J2ME",
        "MIDP",
        "MIDP-2.0",
        "320x240",
        "240x320",
        "Blackberry8700",
        "Opera Mini",
        "NetFront",
        "BlackBerry",
        "PSP"
    );
    function MySiteAppPlugin() {
        if (is_admin()) {
            require_once( dirname(__FILE__) . '/uppsite_options.php' );
        }
        $this->detect_user_agent();
        if ($this->is_mobile || $this->is_app) {
            if (function_exists('add_theme_support')) {
                                add_theme_support( 'post-thumbnails');
            }
            do_action('uppsite_is_running');
        }
    }
    function detect_user_agent() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], MYSITEAPP_AGENT) !== false) {
                        $this->is_app = true;
            $this->new_template = MYSITEAPP_TEMPLATE_APP;
        } elseif (mysiteapp_should_show_landing() || mysiteapp_should_show_webapp()) {
            if (preg_match('/('.implode('|', self::$_mobile_ua).')/i', $_SERVER['HTTP_USER_AGENT']) || mysiteapp_should_preview_webapp()) {
                                $this->is_mobile = true;
                $this->new_template = $this->get_webapp_template();
            }
        }
    }
    function get_webapp_template() {
        $ret = mysiteapp_should_show_landing() ? "landing" : ( mysiteapp_should_show_webapp() ? "webapp" : "normal" );
        if (isset($_COOKIE[MYSITEAPP_WEBAPP_PREF_THEME]) && isset($_COOKIE[MYSITEAPP_WEBAPP_PREF_TIME])) {
            $ret = $_COOKIE[MYSITEAPP_WEBAPP_PREF_THEME];
            $saveTime = $_COOKIE[MYSITEAPP_WEBAPP_PREF_TIME];
                        setcookie(MYSITEAPP_WEBAPP_PREF_THEME, $ret, time() + $saveTime);
        }
        switch ($ret) {
            case "webapp":
                if (mysiteapp_should_show_webapp()) {
                    return MYSITEAPP_TEMPLATE_WEBAPP;
                }
                break;
            case "landing":
                if (mysiteapp_should_show_landing()) {
                    return MYSITEAPP_TEMPLATE_LANDING;
                }
                break;
        }
                $this->is_mobile = false;         return null;
    }
    function has_custom_theme() {
        return !is_null($this->new_template);
    }
    static function detect_specific_os() {
        if (is_null(self::$os)) {
            foreach (self::$_mobile_ua_os as $osName => $ua) {
                if (preg_match('/(' . implode('|', $ua) . ')/i', $_SERVER['HTTP_USER_AGENT'])) {
                    self::$os = $osName;
                    break;
                }
            }
        }
        return self::$os;
    }
}
foreach (MySiteAppPlugin::$_mobile_ua_os as $osName => $osUA) {
    MySiteAppPlugin::$_mobile_ua = array_merge(MySiteAppPlugin::$_mobile_ua, $osUA);
}
class MysiteappXmlParser {
    public static function array_to_xml($data, $rootNodeName = 'data', $xml=null)
    {
                if (ini_get('zend.ze1_compatibility_mode') == 1) {
            ini_set ('zend.ze1_compatibility_mode', 0);
        }
        if ($xml == null) {
            $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
        }
        $childNodeName = substr($rootNodeName, 0, strlen($rootNodeName)-1);
                foreach($data as $key => $value) {
                        if (is_numeric($key)) {
                                $key = $childNodeName;
            }
                        if (is_array($value)) {
                $node = $xml->addChild($key);
                                self::array_to_xml($value, $key, $node);
            } else  {
                                if (is_string($value)) {
                    $value = htmlspecialchars($value);
                    $xml->addChild($key,$value);
                } else {
                    $xml->addAttribute($key,$value);
                }
            }
        }
                return $xml->asXML();
    }
    public static function print_xml($parsed_xml) {
        header("Content-type: text/xml");
        print $parsed_xml;
    }
}
global $msap;
$msap = new MySiteAppPlugin();
function mysiteapp_filter_template($newValue) {
    global $msap;
    return $msap->has_custom_theme() ? $msap->new_template : $newValue;
}
add_filter('option_template', 'mysiteapp_filter_template'); add_filter('option_stylesheet', 'mysiteapp_filter_template'); 
function mysiteapp_get_plugin_name() {
    return trim( dirname( MYSITEAPP_PLUGIN_BASENAME ), '/' );
}
function mysiteapp_fix_youtube_helper(&$matches) {
    $new_width = MYSITEAPP_VIDEO_WIDTH;
    $toreturn = $matches['part1']."%d".$matches['part2']."%d".$matches['part3'];
    $height = is_numeric($matches['objectHeight']) ? $matches['objectHeight'] : $matches['embedHeight'];
    $width = is_numeric($matches['objectWidth']) ? $matches['objectWidth'] : $matches['embedWidth'];
    $new_height = ceil(($new_width / $width) * $height);
    return sprintf($toreturn, $new_width, $new_height);
}
function mysiteapp_fix_helper(&$matches) {
    if (strpos($matches['url1'], "youtube.com") !== false) {
        return mysiteapp_fix_youtube_helper($matches);
    }
    return $matches['part1'].$matches['objectWidth'].$matches['part2'].$matches['objectHeight'].$matches['part3'];
}
function mysiteapp_logout_url_wrapper() {
    if (function_exists('wp_logout_url')) {
        return wp_logout_url();
    }
        $logout_url = site_url('wp-login.php') . "?action=logout";
    if (function_exists('wp_create_nonce')) {
                        $logout_url .= "&amp;_wpnonce=" . wp_create_nonce('log-out');
    } 
    return $logout_url;
}
function mysiteapp_fix_videos(&$subject) {
    $matches = preg_replace_callback("/(?P<part1><object[^>]*width=['\"])(?P<objectWidth>\d+)(?P<part2>['\"].*?height=['\"])(?P<objectHeight>\d+)(?P<part3>['\"].*?value=['\"](?P<url1>[^\"]+)['|\"].*?<\/object>)/ms", "mysiteapp_fix_helper", $subject);
    return $matches;
}
function mysiteapp_print_post($iterator = 0, $posts_layout = 'full') {
    global $msap;
    set_query_var('mysiteapp_should_show_post', mysiteapp_should_show_post_content($iterator, $posts_layout));
    if ($msap->is_app) {
        get_template_part('post');
    }
}
function mysiteapp_list($thelist, $nodeName, $idParam = "") {
    global $msap;
    if ($msap->is_app) {
        preg_match_all('/(?:class="[^"]*'.$idParam.'-(\d+)[^"]*".*?)?href=["\'](.*?)["\'].*?>(.*?)<\/a>/ms', $thelist, $result);
        $total = count($result[1]);
        $thelist = "";
        for ($i=0; $i<$total; $i++) {
            $curId = $result[1][$i];
            $thelist .= "\t<" . $nodeName . ( $curId ? " id=\"" . $curId ."\"" : "" ) .">\n\t\t";
            $thelist .= "<title><![CDATA[" . $result[3][$i] . "]]></title>\n\t\t";
            $thelist .= "<permalink><![CDATA[" . $result[2][$i] ."]]></permalink>\n\t";
            $thelist .= "</" . $nodeName .">\n";
        }
    }
    return $thelist;
}
function mysiteapp_list_cat($thelist){
    return mysiteapp_list($thelist, 'category', 'cat-item');
}
function mysiteapp_list_tags($thelist){
    return mysiteapp_list($thelist, 'tag');
}
function mysiteapp_list_archive($thelist){
    return mysiteapp_list($thelist, 'archive');
}
function mysiteapp_list_pages($thelist){
    return mysiteapp_list($thelist, 'page', 'page-item');
}
function mysiteapp_list_links($thelist){
    return mysiteapp_list($thelist, 'link');
}
function mysiteapp_navigation($thelist){
    return mysiteapp_list($thelist, 'navigation');
}
function mysiteapp_print_error($wp_error){
    ?><mysiteapp result="false">
    <?php foreach ($wp_error->get_error_codes() as $code): ?>
        <error><![CDATA[<?php echo $code ?>]]></error>
    <?php endforeach; ?>
    </mysiteapp><?php
    exit();
}
function mysiteapp_login($user, $username, $password){
    global $msap;
    if ($msap->is_app) {
        $user = wp_authenticate_username_password($user, $username, $password);
        if (is_wp_error($user)) {
            mysiteapp_print_error($user);
        } else {
            set_query_var('mysiteapp_user', $user);
            get_template_part('user');
        }
        exit();
    }
}
function mysiteapp_error_handler($message, $title = '', $args = array()) {
    ?><mysiteapp result="false">
    <error><![CDATA[<?php echo $message ?>]]></error>
    </mysiteapp>
    <?php
    die();
}
function mysiteapp_call_error( $function ) {
    global $msap;
    if($msap->is_app){
        return 'mysiteapp_error_handler';
    }
    return $function;
}
function uppsite_extract_src_url($html) {
    if (preg_match("/src=[\"']([\s\S]+?)[\"']/", $html, $match)) {
        return $match[1];
    }
    return null;
}
function uppsite_nullify_thumb(&$content, &$thumb) {
        if (preg_match("/(.*?)(?:-)(\\d{1,4})([_x\\-]?\\d{0,4})(\\.[a-zA-Z]{1,4}.*)/", $thumb, $imgParts)) {
                        $sizeModifier = $imgParts[2];
        if (is_numeric($sizeModifier) && intval($sizeModifier) < 50) {
                                                        } else {
                        $thumb = $imgParts[1] . $imgParts[4];
        }
    }
    $content = preg_replace("/<img[^>]*src=\"". str_replace("/", "\\/", $thumb) ."[^>]*>/ms", "", $content);
}
function uppsite_extract_image_from_post_content(&$content) {
    if (!preg_match("/<img[^>]*src=\"([^\"]+)\"[^>]*>/", $content, $matches)) {
        return null;
    }
    if (strpos($matches[0], "uppsite-youtube-video") !== false) {
                return null;
    }
    $content = str_replace($matches[0], "", $content);
    return $matches[1];
}
function mysiteapp_extract_thumbnail(&$content = null) {
    $thumb_url = null;
    if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
                $thumb_url = get_the_post_thumbnail();
    }
    if (empty($thumb_url) && function_exists('the_attached_image')) {
                $temp_thumb = the_attached_image('img_size=thumb&echo=false');
        if (!empty($temp_thumb)) {
            $thumb_url = $temp_thumb;
        }
    }
    if (empty($thumb_url) && function_exists('get_the_image')) {
                $temp_thumb = get_the_image(array('size' => 'thumbnail', 'echo' => false, 'link_to_post' => false));
        if (!empty($temp_thumb)) {
            $thumb_url = $temp_thumb;
        }
    }
    if (empty($thumb_url)) {
        if (mysiteapp_is_fresh_wordpress_installation()) {
                        $thumb_url = MYSITEAPP_HOMEPAGE_FRESH_COVER;
        } else {
            if (is_null($content)) {
                ob_start();
                the_content();
                $content = ob_get_contents();
                ob_get_clean();
            }
            $thumb_url = uppsite_extract_image_from_post_content($content);
        }
    } else {
                $thumb_url = uppsite_extract_src_url($thumb_url);
        if (!is_null($content)) {
                        uppsite_nullify_thumb($content, $thumb_url);
        }
    }
    return $thumb_url;
}
function mysiteapp_print_xml($arr) {
    $result = MysiteappXmlParser::array_to_xml($arr, "mysiteapp");
    MysiteappXmlParser::print_xml($result);
}
function mysiteapp_post_new() {
    global $msap;
    global $temp_ID, $post_ID, $form_action, $post, $user_ID;
    if ($msap->is_app) {
        if (!$post) {
            remove_action('save_post', 'mysiteapp_post_new_process');
            $post = get_default_post_to_edit( 'post', true );
            add_action('save_post', 'mysiteapp_post_new_process');
            $post_ID = $post->ID;
        }
        $arr = array(
            'user'=>array('ID'=>$user_ID),
            'postedit'=>array()
        );
        if ( 0 == $post_ID ) {
            $form_action = 'post';
        } else {
            $form_action = 'editpost';
        }
        $arr['postedit'] = array(
            'wpnonce' => wp_create_nonce( 0 == $post_ID ? 'add-post' : 'update-post_' .  $post_ID ),
            'user_ID' => (int)$user_ID,
            'original_post_status'=>esc_attr($post->post_status),
            'action'=>esc_attr($form_action),
            'originalaction'=>esc_attr($form_action),
            'post_type'=>esc_attr($post->post_type),
            'post_author'=>esc_attr( $post->post_author ),
            'referredby'=>esc_url(stripslashes(wp_get_referer())),
            'hidden_post_status'=>'',
            'hidden_post_password'=>'',
            'hidden_post_sticky'=>'',
            'autosavenonce'=>wp_create_nonce( 'autosave'),
            'closedpostboxesnonce'=>wp_create_nonce( 'closedpostboxes'),
            'getpermalinknonce'=>wp_create_nonce( 'getpermalink'),
            'samplepermalinknonce'=>wp_create_nonce( 'samplepermalink'),
            'meta_box_order_nonce'=>wp_create_nonce( 'meta-box-order'),
            'categories'=>array(),
        );
        if ( 0 == $post_ID ) {
            $arr['postedit']['temp_ID'] = esc_attr($temp_ID);
        } else {
            $arr['postedit']['post_ID'] = esc_attr($post_ID);
        }
        mysiteapp_print_xml($arr);
        exit();
    }
}
function mysiteapp_post_new_process($post_id) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;
    if ( wp_is_post_revision( $post_id ) )
        return;
    global $msap;
    if ($msap->is_app) {
        $arr = array(
                'user' => array('ID' => get_current_user_id()),
                'postedit' => array(
                    'success'=>true,
                    'post_ID'=>$post_id,
                    'is_revision' => var_export(wp_is_post_revision($post_id), true),
                    'permalink' => get_permalink($post_id)
                ),
            );
        mysiteapp_print_xml($arr);
        exit();
    }
}
function mysiteapp_logout() {
    global $msap;
    global $user_ID;
    if ($msap->is_app) {
        $arr = array(
            'user'=>array('ID'=>$user_ID),
            'logout'=>array('success'=> !empty($user_ID))
        );
        mysiteapp_print_xml($arr);
        exit();
    }
}
function mysiteapp_comment_author($comment_ID = 0) 
{
    $author = html_entity_decode($comment_ID) ;
    $stripped = strip_tags($author);
    echo $stripped;
}
function mysiteapp_comment_form() {
    ob_start();
    do_action('comment_form');
    $dump = ob_get_clean();
    if (preg_match_all('/name="([a-zA-Z0-9\_]+)" value="([a-zA-Z0-9\_\'&@#]+)"/', $dump, $matches)) {
        $total = count($matches[1]);
        for ($i=0; $i<$total; $i++) {
            echo "<".$matches[1][$i]."><![CDATA[".$matches[2][$i]."]]></".$matches[1][$i].">\n";
        }
    }
}
function mysiteapp_sign_message($message){
    $options = get_option(MYSITEAPP_OPTIONS_DATA);
    $str = $options['uppsite_secret'].$message;
    return md5($str);
}
function mysiteapp_is_need_new_link(){
    $dataOptions = get_option(MYSITEAPP_OPTIONS_DATA);
    $lastCheck = isset($dataOptions['last_native_check']) ? $dataOptions['last_native_check'] : 0;
        return time() > $lastCheck + MYSITEAPP_ONE_DAY;
}
function mysiteapp_needs_prefs_update() {
    $dataOptions = get_option(MYSITEAPP_OPTIONS_DATA);
    $lastCheck = isset($dataOptions['prefs_update']) ? $dataOptions['prefs_update'] : 0;
        return time() > $lastCheck + (MYSITEAPP_ONE_DAY / 2);
}
function mysiteapp_prefs_init($forceUpdate = false) {
        $dataOptions = get_option(MYSITEAPP_OPTIONS_DATA);
    if ($dataOptions === false || !isset($dataOptions['uppsite_key'])) {
        $uppData = wp_remote_post(MYSITEAPP_AUTOKEY_URL,
            array(
                'body' => 'pingback=' . get_bloginfo('pingback_url'),
                'timeout' => 5
            )
        );
        if (!is_wp_error($uppData)) {
            $data = json_decode($uppData['body'], true);
            if (isset($data['key'])) {
                $dataOptions = array(
                    'appId' => $data['appId'],
                    'uppsite_key' => $data['key'],
                    'uppsite_secret' => $data['secret'],
                    'prefs_update' => 0,
                    'last_native_check' => 0
                );
                update_option(MYSITEAPP_OPTIONS_DATA, $dataOptions);
                $opts = get_option(MYSITEAPP_OPTIONS_OPTS);
                if (!is_array($opts)) {
                    $opts = array();
                }
                $opts['activated'] = $data['activated'];
                if ($opts['activated']) {
                    $opts['webapp_mode'] = "all";
                    $opts['visited_minisite'] = true;
                }
                update_option(MYSITEAPP_OPTIONS_OPTS, $opts);
            }
        }
    }
    if ($dataOptions === false) {
                return;
    }
    $prefsOptions = get_option(MYSITEAPP_OPTIONS_PREFS);
    if (empty($prefsOptions) || $forceUpdate) {
        $uppPrefs = wp_remote_post(MYSITEAPP_PREFERENCES_URL,
            array(
                'body' => 'os_id=4&json=1&key=' . $dataOptions['uppsite_key'],
                'timeout' => 5
            )
        );
        if (!is_wp_error($uppPrefs)) {
            $prefsOptions = json_decode($uppPrefs['body'], true);
            $dataOptions['app_id'] = $prefsOptions['preferences']['id'];
            update_option(MYSITEAPP_OPTIONS_PREFS, $prefsOptions['preferences']);
            $dataOptions['prefs_update'] = time();
            update_option(MYSITEAPP_OPTIONS_DATA, $dataOptions);
        }
                $opts = get_option(MYSITEAPP_OPTIONS_OPTS);
        if (!is_array($opts)) {
            $opts = array();
        }
        if (!isset($opts['activated'])) {
            $uppData = wp_remote_post(MYSITEAPP_AUTOKEY_URL,
                array(
                    'body' => 'meta_only=1&pingback=' . get_bloginfo('pingback_url'),
                    'timeout' => 5
                )
            );
            if (!is_wp_error($uppData)) {
                $data = json_decode($uppData['body'], true);
                if (isset($data['activated'])) {
                    $opts['activated'] = $data['activated'];
                    if ($opts['activated']) {
                        $opts['webapp_mode'] = "all";
                        $opts['visited_minisite'] = true;
                        update_option(MYSITEAPP_OPTIONS_OPTS, $opts);
                    }
                }
            }
        }
    }
}
function mysiteapp_admin_init() {
    $forcePrefsUpdate = mysiteapp_needs_prefs_update();
    $options = get_option(MYSITEAPP_OPTIONS_OPTS);
    if (!isset($options['uppsite_plugin_version']) ||
        $options['uppsite_plugin_version'] != MYSITEAPP_PLUGIN_VERSION) {
        $options['uppsite_plugin_version'] = MYSITEAPP_PLUGIN_VERSION;
        update_option(MYSITEAPP_OPTIONS_OPTS, $options);
        $forcePrefsUpdate = true;
    }
    mysiteapp_prefs_init($forcePrefsUpdate);
    mysiteapp_get_app_links();
    $options = get_option(MYSITEAPP_OPTIONS_OPTS);     if (!isset($options['minisite_shown'])) {
        $options['minisite_shown'] = isset($options['visited_minisite']);
        update_option(MYSITEAPP_OPTIONS_OPTS, $options);
        if (!$options['minisite_shown']) {
                        wp_safe_redirect(menu_page_url('uppsite-settings', false));
            exit;
        }
    }
}
function mysiteapp_get_app_links(){
    if (!mysiteapp_is_need_new_link()) {
        return false;
    }
    $options = get_option(MYSITEAPP_OPTIONS_DATA);
    if (empty($options['uppsite_key']))
        return false;
    $hash = mysiteapp_sign_message($options['uppsite_key']);
    $get = '&api_key='.$options['uppsite_key'].'&hash='.$hash;
    $response = wp_remote_get(MYSITEAPP_APP_NATIVE_URL.$get);
    if (is_wp_error($response)) {
        return false;
    }
    $data = json_decode($response['body'],true);
    if ($data) {
        $options['native_apps'] = $data;
                $options['last_native_check'] = time();
        update_option(MYSITEAPP_OPTIONS_DATA, $options);
    }
}
function mysiteapp_get_plugin_version() {
    return MYSITEAPP_PLUGIN_VERSION;
}
function mysiteapp_get_pic_from_fb_id($fb_id){
    return 'http://graph.facebook.com/'.$fb_id.'/picture?type=small';
}
function mysiteapp_get_pic_from_fb_profile($fb_profile){
    if(stripos($fb_profile,'facebook') === FALSE) {
            return false;
    }
    $user_id = basename($fb_profile);
    return mysiteapp_get_pic_from_fb_id($user_id);
}
function mysiteapp_get_member_for_comment(){
    $need_g_avatar = true;
    $user = array();
    $user['author'] = get_comment_author();
    $user['link'] = get_comment_author_url();
    $options = get_option('uppsite_options');
        if (isset($options['disqus'])){
        $user['avatar'] = mysiteapp_get_pic_from_fb_profile($user['link']);
        if ($user['avatar']) {
            $need_g_avatar = false;
        }
    }
    if ($need_g_avatar){
        if(function_exists('get_avatar') && function_exists('htmlspecialchars_decode')){
            $user['avatar']  = htmlspecialchars_decode(uppsite_extract_src_url(get_avatar(get_comment_author_email())));
        }
    }?>
<member>
    <name><![CDATA[<?php echo $user['author'] ?>]]></name>
    <member_link><![CDATA[<?php echo $user['link'] ?>]]></member_link>
    <avatar><![CDATA[<?php echo $user['avatar'] ?>]]></avatar>
</member><?php
}
function mysiteapp_print_single_facebook_comment($fb_comment){
    $avatar_url = mysiteapp_get_pic_from_fb_id($fb_comment['from']['id']);
?><comment ID="<?php echo $fb_comment['id'] ?>" post_id="<?php echo get_the_ID() ?>" isApproved="true">
    <permalink><![CDATA[<?php echo get_permalink() ?>]]></permalink>
    <time><![CDATA[<?php echo $fb_comment['created_time'] ?>]]></time>
    <unix_time><![CDATA[<?php echo strtotime($fb_comment['created_time']) ?>]]></unix_time>
    <member>
        <name><![CDATA[<?php echo $fb_comment['from']['name'] ?>]]></name>
        <member_link><![CDATA[]]></member_link>
        <avatar><![CDATA[<?php echo $avatar_url ?>]]></avatar>
    </member>
    <text><![CDATA[<?php echo $fb_comment['message'] ?>]]> </text>
</comment><?php
}
function mysiteapp_print_facebook_comments(&$comment_counter){
    $permalink = get_permalink();
    $comments_url = MYSITEAPP_FACEBOOK_COMMENTS_URL.$permalink;
    $res = '';
    $comment_counter = 0;
        $comment_json = wp_remote_get($comments_url);
    $avatar_url = htmlspecialchars_decode(uppsite_extract_src_url(get_avatar(0)));
        if($comment_json){
        $comments_arr = json_decode($comment_json['body'],true);
                if ($comments_arr == NULL||
            !array_key_exists($permalink,$comments_arr) ||
            !array_key_exists('data',$comments_arr[$permalink])) {
            return;
        }
        $comments_list = $comments_arr[$permalink]['data'];
        foreach($comments_list as $comment){
            $res .= mysiteapp_print_single_facebook_comment($comment,$avatar_url);
                        if (array_key_exists('comments', $comment)){
                foreach($comment['comments']['data'] as $inner_comment){                    
                    $res .= mysiteapp_print_single_facebook_comment($inner_comment);
                    $comment_counter++;
                }
            }
            $comment_counter++;
        }
    }
    return $res;
}
function mysiteapp_comment_to_facebook(){
    $options = get_option('uppsite_options');
    $val = isset($_REQUEST['msa_facebook_comment_page']) ? $_REQUEST['msa_facebook_comment_page'] : NULL;
    if ($val) {
        if (isset($options['fbcomment']) && !isset($_POST['comment'])) {
             print mysiteapp_facebook_comments_page();
             exit;
        }
    }
}
function mysiteapp_comment_to_disq($location, $comment=NULL){
    global $msap;
    if ($msap->is_app) {
        $shortname  = strtolower(get_option('disqus_forum_url'));
        $disq_thread_url = '.disqus.com/thread/';
        $options = get_option('uppsite_options');
            if ($comment==NULL)
                $comment = $location;
        if(isset($options['disqus']) && strlen($shortname)>1){
            $post_details = get_post($comment->comment_post_ID, ARRAY_A);
            $fixed_title = str_replace(' ', '_', $post_details['post_title']);
            $fixed_title = strtolower($fixed_title);
            $str = 'author_name='.$comment->comment_author.'&author_email='.$comment->comment_author_email.'&subscribe=0&message='.$comment->comment_content;
            $post_data = array('body' =>$str);
            $url = 'http://'.$shortname.$disq_thread_url.$fixed_title.'/post_create/';
            $result = wp_remote_post($url,$post_data);
        }
    }
    return $location;
}
function mysiteapp_fix_content_more($more){
    global $msap;
    if ($msap->is_app) {
        return '(...)';
    }
    return $more;
}
function mysiteapp_get_posts_layout() {
    $posts_list_view = isset($_REQUEST['posts_list_view']) ? esc_html(stripslashes($_REQUEST['posts_list_view'])) : "";
        switch ($posts_list_view) {
        case "full":
        case "ffull_rexcerpt":
        case "ffull_rtitle":
        case "title":
        case "excerpt":
        case "homepage":
            return $posts_list_view;
    }
    return "";
}
function mysiteapp_should_show_post_content($iterator = 0, $posts_layout = null) {
    if ($posts_layout == null)
        $posts_layout = mysiteapp_get_posts_layout();
    if (
            empty($posts_layout) ||             $posts_layout == 'full' ||             ( $iterator < MYSITEAPP_BUFFER_POSTS_COUNT && ($posts_layout == 'ffull_rexcerpt' || $posts_layout == 'ffull_rtitle'))         ) {
        return true;
    }
    return false;
}
function mysiteapp_should_hide_posts() {
    return isset($_REQUEST['posts_hide']) && $_REQUEST['posts_hide'] == '1';
}
function mysiteapp_should_hide_sidebar() {
    return isset($_REQUEST['sidebar_hide']) && $_REQUEST['sidebar_hide'] == '1';
}
function mysiteapp_clean_output($func) {
    ob_start();
    $ret = call_user_func($func);
    ob_end_clean();
    return $ret;
}
function mysiteapp_set_webapp_theme() {
    $templateType = isset($_REQUEST['msa_theme_select']) ? esc_html(stripslashes($_REQUEST['msa_theme_select'])) : "";
    $templateSaveForever = isset($_REQUEST['msa_theme_save_forever']) ? esc_html(stripslashes($_REQUEST['msa_theme_save_forever'])) : "";
    if (empty($templateType)) {
        return;
    }
        if (!in_array($templateType, array("webapp", "normal"))) {
        return;
    }
    $cookieTime = $templateSaveForever ? 60*60*24*7 : 60*60;     setcookie(MYSITEAPP_WEBAPP_PREF_THEME, $templateType, time() + $cookieTime);
        setcookie(MYSITEAPP_WEBAPP_PREF_TIME, $cookieTime, time() + 60*60*24*30);
        $cleanUrl = remove_query_arg(array("msa_theme_select","msa_theme_save_forever"));
    wp_safe_redirect($cleanUrl);
    exit;
}
function mysiteapp_remote_activation() {
    $query_var = isset($_REQUEST['msa_remote_activation']) ? $_REQUEST['msa_remote_activation'] : "";
    if (empty($query_var)) {
        return;
    }
    $decoded = json_decode(base64_decode($query_var), true);
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA);
    $signKey = 1;
    $signVal = get_bloginfo('pingback_url');
    if (isset($dataOpts['uppsite_secret'])) {
        $signKey = 2;
        $signVal = $dataOpts['uppsite_secret'];
    }
    $signVal = md5($signVal);
    if (md5($decoded['data'].$decoded['secret' . $signKey]) != $decoded['verify' . $signKey]
        || $decoded['secret' . $signKey] != $signVal) {
                return;
    }
    $data = json_decode($decoded['data'], true);
        $opts = get_option(MYSITEAPP_OPTIONS_OPTS);
    $refreshPrefs = false;
    foreach ($data as $key=>$val) {
        switch ($key) {
            case "app_id":
            case "uppsite_key":
            case "uppsite_secret":
            case "last_native_check":
                $dataOpts[$key] = $val;
                break;
            case "update_prefs":
                $refreshPrefs = true;
                break;
            case "activated":
            case "webapp_mode":
            case "visited_minisite":
                $opts[$key] = $val;
                break;
        }
    }
    update_option(MYSITEAPP_OPTIONS_DATA ,$dataOpts);
    update_option(MYSITEAPP_OPTIONS_OPTS, $opts);
    if ($refreshPrefs) {
        mysiteapp_prefs_init(true);
    }
}
function mysiteapp_get_ads() {
    $prefs = get_option(MYSITEAPP_OPTIONS_PREFS);
    if ($prefs === false ||
        $prefs['ad_display'] == false || $prefs['ad_display'] == "false") {
        return "{active: false}";
    }
    $ret = array(
        "active" => true,
        "html" => $prefs['ads']
    );
    if (isset($prefs['matomy_site_id']) && isset($prefs['matomy_zone_id'])) {
        $ret['matomy_site_id'] = $prefs['matomy_site_id'];
        $ret['matomy_zone_id'] = $prefs['matomy_zone_id'];
    }
    $state_arr = array(
        '0' => 'none',
        '1' => 'top',
        '2' => 'bottom'
    );
    $ret['ad_state'] = array_key_exists($prefs['ad_state'], $state_arr) ? $state_arr[$prefs['ad_state']] : 1;
    return json_encode($ret);
}
function mysiteapp_get_prefs_value($key, $default = null) {
    $prefs = get_option(MYSITEAPP_OPTIONS_PREFS);
    if ($prefs === false || !array_key_exists($key, $prefs)) {
        return $default ? $default : null;
    }
    if (!is_null($default) && empty($prefs[$key])) {
        return $default;
    }
    return $prefs[$key];
}
function mysiteapp_visited_minisite() {
    $opts = get_option(MYSITEAPP_OPTIONS_OPTS);
    print $opts != null && isset($opts['visited_minisite']) ? 'true' : 'false';
    exit;
}
function mysiteapp_convert_datetime($datetime) {
    $values = explode(" ", $datetime);
    $dates = explode("-", $values[0]);
    $times = explode(":", $values[1]);
    return mktime($times[0], $times[1], $times[2], $dates[1], $dates[2], $dates[0]);
}
function mysiteapp_can_send_push() {
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA);
    return isset($dataOpts['uppsite_key']) && isset($dataOpts['uppsite_secret']);
}
function mysiteapp_send_push($post_id, $post_details = NULL) {
    if (!mysiteapp_can_send_push()) { return; }
    if (is_null($post_details)) {
                $post_details = get_post($post_id, ARRAY_A);
    }
    $dataOpts = get_option(MYSITEAPP_OPTIONS_DATA);
    $data = array();
    $data['title'] = $post_details['post_title'];
    $data['post_id'] = $post_details['ID'];
    $data['utime'] = mysiteapp_convert_datetime($post_details['post_date']);
    $data['api_key'] = $dataOpts['uppsite_key'];
    $json_str = json_encode($data);
    $hash = mysiteapp_sign_message($json_str);
    wp_remote_post(MYSITEAPP_PUSHSERVICE, array(
        'body' => 'data='.$json_str.'&hash='.$hash,
        'timeout' => 5,
    ));
}
function mysiteapp_new_post_push($post_id) {
    if ($_POST['post_status'] != 'publish') { return; }
    if ( (isset($_POST['original_post_status']) && $_POST['original_post_status'] != $_POST['post_status']) ||         (isset($_POST['_status']) && $_POST['_status'] != $_POST['post_status']) ) {         mysiteapp_send_push($post_id);
    }
}
function mysiteapp_future_post_push($post_id) {
    $post_details = get_post($post_id, ARRAY_A);
    if ($post_details['post_status'] != 'publish') { return; }
    if (!$_POST &&
        false == (isset($post_details['sticky']) && $post_details['sticky'] == 'sticky')) {
                mysiteapp_send_push($post_id, $post_details);
    }
}
function mysiteapp_append_native_link() {
    global $msap, $wp;
    if ($msap->has_custom_theme()) {
                return;
    }
    $appleId = uppsite_get_native_app("identifier", "ios");
    if (!is_null($appleId) && uppsite_get_native_app("banner", "ios")) {
        $currentUrl = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
        print '<meta name="apple-itunes-app" content="app-id=' . $appleId . ', app-argument=' . esc_attr($currentUrl) . '"/>';
    }
}
function mysiteapp_get_current_query() {
    global $mysiteapp_cur_query, $wp_query;
    return !is_null($mysiteapp_cur_query) ? $mysiteapp_cur_query : $wp_query;
}
function mysiteapp_set_current_query($query) {
    global $mysiteapp_cur_query;
    $mysiteapp_cur_query = new WP_Query($query);
    return $mysiteapp_cur_query;
}
function mysiteapp_should_show_homepage() {
    return mysiteapp_get_posts_layout() == "homepage";
}
function uppsite_homepage_get_settings() {
    $hpSettings = mysiteapp_get_prefs_value('homepage_settings');
    return !is_null($hpSettings) ? json_decode($hpSettings, true) : array();
}
function mysiteapp_homepage_carousel_posts_num() {
    $num = MYSITEAPP_HOMEPAGE_POSTS;
    $homepageSettings = uppsite_homepage_get_settings();
    if (isset($_REQUEST['homepage_post']) && is_numeric($_REQUEST['homepage_post'])) {
        $num = $_REQUEST['homepage_post'];
    } elseif (isset($homepageSettings['homepage_post']) && is_numeric($homepageSettings['homepage_post'])) {
        $num = $homepageSettings['homepage_post'];
    }
    return min( abs($num), 15 );
}
function mysiteapp_homepage_cat_posts() {
    $num = MYSITEAPP_HOMEPAGE_DEFAULT_MIN_POSTS;
    $homepageSettings = uppsite_homepage_get_settings();
    if (isset($_REQUEST['posts_num']) && is_numeric($_REQUEST['posts_num'])) {
        $num = $_REQUEST['posts_num'];
    } elseif (isset($homepageSettings['posts_num']) && is_numeric($homepageSettings['posts_num'])) {
        $num = $homepageSettings['posts_num'];
    }
    return min( abs($num), 15 );
}
function mysiteapp_homepage_carousel_rotate_interval() {
    $num = 5;
    $homepageSettings = uppsite_homepage_get_settings();
    if (isset($homepageSettings['rotate_interval']) && is_numeric($homepageSettings['rotate_interval'])) {
        $num = $homepageSettings['rotate_interval'];
    }
    return min( abs($num), 30 );
}
function mysiteapp_homepage_is_only_show_posts() {
    return isset($_REQUEST['onlyposts']);
}
function mysiteapp_homepage_add_post($post_id){
    global $homepage_post_ids;
    if (!is_array($homepage_post_ids)) {
        $homepage_post_ids = array();
    }
    array_push($homepage_post_ids, $post_id);
}
function mysiteapp_homepage_get_excluded_posts() {
    global $homepage_post_ids;
    return !is_array($homepage_post_ids) ? array() : $homepage_post_ids;
}
function mysiteapp_is_fresh_wordpress_installation(){
     return wp_count_posts()->publish == 1;
}
function mysiteapp_homepage_get_popular_categories() {
    $pop_cat = get_categories( 'order=desc&orderby=count&number=' . MYSITEAPP_HOMEPAGE_MAX_CATEGORIES );
    $result = array();
    foreach($pop_cat as $cat){
        $result[] = $cat->term_id;
    }
    return $result;
}
add_action('wp', 'mysiteapp_set_webapp_theme');
add_action('init', 'mysiteapp_remote_activation');
add_filter('wp_die_handler','mysiteapp_call_error');
add_filter('the_category','mysiteapp_list_cat');
add_filter('the_tags','mysiteapp_list_tags');
add_filter('wp_list_categories','mysiteapp_list_cat');
add_filter('get_archives_link','mysiteapp_list_archive');
add_filter('wp_list_pages','mysiteapp_list_pages');
add_filter('wp_list_bookmarks','mysiteapp_list_links');
if ( function_exists('wp_tag_cloud') )
    add_filter('wp_tag_cloud','mysiteapp_list_tags');
add_filter('next_posts_link','mysiteapp_navigation');
add_filter('authenticate', 'mysiteapp_login', 2, 3);
add_action('wp_logout', 'mysiteapp_logout', 30);
add_action('comment_author', 'mysiteapp_comment_author');
add_action('load-post-new.php', 'mysiteapp_post_new');
add_action('save_post', 'mysiteapp_post_new_process');
add_action('admin_init','mysiteapp_admin_init');
add_action('template_redirect','mysiteapp_comment_to_facebook', 10);
add_filter('the_content_more_link','mysiteapp_fix_content_more', 10, 1);
add_action('wp_ajax_uppsite_visited_minisite', 'mysiteapp_visited_minisite');
add_action('publish_post','mysiteapp_new_post_push', 10, 1);
add_action('publish_future_post','mysiteapp_future_post_push', 10, 1);
add_action('wp_head', 'mysiteapp_append_native_link');
endif; 

<?php
/*
Plugin Name: Captain Slider
Plugin URI: http://captaintheme.com/plugins/captain-slider/
Description: Allows you to easily create multiple jQuery sliders.
Author: Captain Theme
Author URI: http://captaintheme.com
Version: 1.0.6
Text Domain: ctslider
License: GNU GPL v2
*/


/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/

// Plugin Folder Path
if ( !defined( 'CTSLIDER_PLUGIN_DIR' ) ) {
	define( 'CTSLIDER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder URL
if ( !defined( 'CTSLIDER_PLUGIN_URL' ) ) {
	define( 'CTSLIDER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Plugin Version
if ( !defined( 'CTSLIDER_VERSION' ) ) {
	define( 'CTSLIDER_VERSION', '1.0.6' );
}


/*
|--------------------------------------------------------------------------
| I18N - LOCALIZATION
|--------------------------------------------------------------------------
*/
load_plugin_textdomain( 'ctslider', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/*
|--------------------------------------------------------------------------
| REGISTER & ENQUEUE SCRIPTS/STYLES
|--------------------------------------------------------------------------
*/

function ctslider_load_scripts() {
	wp_register_style( 'flexslider-style',  CTSLIDER_PLUGIN_URL . 'includes/css/flexslider.css', array(  ), CTSLIDER_VERSION );

	wp_register_script( 'flexslider',  CTSLIDER_PLUGIN_URL .  'includes/js/jquery.flexslider-min.js', array( 'jquery' ), CTSLIDER_VERSION, false );
	wp_register_script( 'fitvids',  CTSLIDER_PLUGIN_URL . 'includes/js/jquery.fitvids.js', array( 'jquery' ), CTSLIDER_VERSION, false );
	
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'fitvids' );
		
	wp_enqueue_style( 'flexslider-style' );	
}
add_action( 'wp_enqueue_scripts', 'ctslider_load_scripts' );


function ctslider_load_admin_scripts( $hook ) {
	global $post;

	wp_register_style( 'admin-styles', CTSLIDER_PLUGIN_URL . 'includes/css/admin-styles.css', false, CTSLIDER_VERSION );

	if ( 'edit.php' === $hook && 'slides' === $post->post_type ) {
		wp_enqueue_style( 'admin-styles' );
	}
}
add_action( 'admin_enqueue_scripts', 'ctslider_load_admin_scripts' );


/**
 * Load Slider
 *
 * Add the jQuery for the slider to wp_head
 *
 * @access      private
 * @uses        add_filter()
 * @uses        ob_start()
 * @uses        ob_get_clean()
 * @since       1.0.0
 * @return      void
 */

function ctslider_slider_load() {
	$effect = ctslider_options_each( 'effect' );
	$automatic = ctslider_options_each( 'automatic' );
	$controlnav = ctslider_options_each( 'bullets' );
	$arrownav = ctslider_options_each( 'arrows' );
	$slidespeed = ctslider_options_each( 'slidelength' );
	$anispeed = ctslider_options_each( 'animationlength' );
	
	ob_start(); ?>
		<script type="text/javascript">
		/* Slider Parameters */
		jQuery(window).load(function() {
			jQuery(".flexslider")
				.fitVids()
				.flexslider({
				animation: '<?php if ( $effect == 'fade' ) { echo 'fade'; } else { echo 'slide'; } ?>', // Specify sets like: 'fade' or 'slide'
				direction: '<?php if ( $effect == 'slideh' ) { echo 'horizontal'; } else { echo 'vertical'; } ?>',
				slideshow: <?php if ( 1 == $automatic ) { echo 'false'; } else { echo 'true'; } ?>,
				controlNav: <?php if ( 1 == $controlnav ) { echo 'false'; } else { echo 'true'; } ?>,
				directionNav: <?php if ( 1 == $arrownav  ) { echo 'false'; } else { echo 'true'; } ?>,
				slideshowSpeed: <?php echo $slidespeed; ?>,
				animationSpeed: <?php echo $anispeed; ?>,
				useCSS: false,
				animationLoop: true,
				smoothHeight: true,
				//controlNav: "thumbnails"
			});
		});
		</script>
	<?php echo ob_get_clean();	
}
add_action( 'wp_head', 'ctslider_slider_load' );


/*
|--------------------------------------------------------------------------
| MISC FUNCTIONS
|--------------------------------------------------------------------------
*/

/**
 * Settings Link
 *
 * Add the jQuery for the slider to wp_head
 *
 * @access      private
 * @uses        add_filter()
 * @uses        array_unshift()
 * @since       1.0.0
 * @return      string $link
 */

function ctslider_settings_link( $link, $file ) {
	static $this_plugin;
	
	if ( !$this_plugin )
		$this_plugin = plugin_basename( __FILE__ );

	if ( $file == $this_plugin ) {
		$settings_link = '<a href="' . admin_url( 'edit.php?post_type=slides&page=ctslider_all_options' ) . '">' . __( 'Settings', 'ctslider' ) . '</a>';
		array_unshift( $link, $settings_link );
	}
	
	return $link;
}
add_filter( 'plugin_action_links', 'ctslider_settings_link', 10, 2 );


/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/

/* Admin Scripts */
if ( is_admin() ) {
	include_once( CTSLIDER_PLUGIN_DIR . 'includes/admin/sorter.php' );
	include_once( CTSLIDER_PLUGIN_DIR . 'includes/admin/ui.php' );
}
include_once( CTSLIDER_PLUGIN_DIR . 'includes/admin/settings.php' );
include_once( CTSLIDER_PLUGIN_DIR . 'includes/admin/post-types.php' );
include_once( CTSLIDER_PLUGIN_DIR . 'includes/admin/taxonomy.php' );
include_once( CTSLIDER_PLUGIN_DIR . 'includes/admin/meta-box.php' );

/* Front End Scripts */
include_once( CTSLIDER_PLUGIN_DIR . 'includes/front-end/template.php' );
include_once( CTSLIDER_PLUGIN_DIR . 'includes/front-end/shortcode.php' );
include_once( CTSLIDER_PLUGIN_DIR . 'includes/front-end/custom-size.php' );
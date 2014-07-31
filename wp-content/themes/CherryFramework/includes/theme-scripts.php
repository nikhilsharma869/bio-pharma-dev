<?php
/*	Register and load javascript
/*-----------------------------------------------------------------------------------*/
function my_script() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', get_template_directory_uri().'/js/jquery-1.7.2.min.js', false, '1.7.2');
		wp_enqueue_script('jquery');
	
		wp_enqueue_script('modernizr', get_template_directory_uri().'/js/modernizr.js', array('jquery'), '2.0.6');
		wp_enqueue_script('superfish', get_template_directory_uri().'/js/superfish.js', array('jquery'), '1.4.8');
		wp_enqueue_script('easing', get_template_directory_uri().'/js/jquery.easing.1.3.js', array('jquery'), '1.3');
		wp_enqueue_script('prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js', array('jquery'), '3.1.3');
		wp_enqueue_script('elastislide', get_template_directory_uri().'/js/jquery.elastislide.js', array('jquery'), '1.0');
		wp_enqueue_script('swfobject', home_url().'/wp-includes/js/swfobject.js', array('jquery'), '2.2');
		wp_enqueue_script('mobilemenu', get_template_directory_uri().'/js/jquery.mobilemenu.js', array('jquery'), '1.0');
		wp_enqueue_script('twitter', get_template_directory_uri().'/js/jquery.twitter.js', array('jquery'), '1.0');
		//wp_enqueue_script('flexslider', get_template_directory_uri().'/js/jquery.flexslider.js', array('jquery'), '2.1');
		wp_enqueue_script('jflickrfeed', get_template_directory_uri().'/js/jflickrfeed.js', array('jquery'), '1.0');
		wp_enqueue_script('si_files', get_template_directory_uri().'/js/si.files.js', array('jquery'), '1.0');
		wp_enqueue_script('camera', get_template_directory_uri().'/js/camera.js', array('jquery'), '1.3.3');
		wp_enqueue_script('playlist', get_template_directory_uri().'/js/jplayer.playlist.min.js', array('jquery'), '2.1.0');
		wp_enqueue_script('jplayer', get_template_directory_uri().'/js/jquery.jplayer.js', array('jquery'), '2.2.0');
		wp_enqueue_script('custom', get_template_directory_uri().'/js/custom.js', array('jquery'), '1.0');		
		wp_enqueue_script('debouncedresize', get_template_directory_uri().'/js/jquery.debouncedresize.js', array('jquery'), '1.0');
		wp_enqueue_script('isotope', get_template_directory_uri().'/js/jquery.isotope.js', array('jquery'), '1.5.19');
		
		// Bootstrap Scripts
		wp_enqueue_script('bootstrap-affix', get_template_directory_uri().'/bootstrap/js/bootstrap-affix.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-alert', get_template_directory_uri().'/bootstrap/js/bootstrap-alert.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-button', get_template_directory_uri().'/bootstrap/js/bootstrap-button.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-carousel', get_template_directory_uri().'/bootstrap/js/bootstrap-carousel.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-collapse', get_template_directory_uri().'/bootstrap/js/bootstrap-collapse.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-dropdown', get_template_directory_uri().'/bootstrap/js/bootstrap-dropdown.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-modal', get_template_directory_uri().'/bootstrap/js/bootstrap-modal.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-tooltip', get_template_directory_uri().'/bootstrap/js/bootstrap-tooltip.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-popover', get_template_directory_uri().'/bootstrap/js/bootstrap-popover.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-scrollspy', get_template_directory_uri().'/bootstrap/js/bootstrap-scrollspy.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-tab', get_template_directory_uri().'/bootstrap/js/bootstrap-tab.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-transition', get_template_directory_uri().'/bootstrap/js/bootstrap-transition.js', array('jquery'), '1.0');
		wp_enqueue_script('bootstrap-typeahead', get_template_directory_uri().'/bootstrap/js/bootstrap-typeahead.js', array('jquery'), '1.0');
		
	}
}
add_action('init', 'my_script');


/*	Register and load admin javascript
/*-----------------------------------------------------------------------------------*/

function tz_admin_js($hook) {
	if ($hook == 'post.php' || $hook == 'post-new.php') {
		wp_register_script('tz-admin', get_template_directory_uri() . '/js/jquery.custom.admin.js', 'jquery');
		wp_enqueue_script('tz-admin');
	}
}
add_action('admin_enqueue_scripts','tz_admin_js',10,1);
?>
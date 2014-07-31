<?php
//if uninstall not called from WordPress, exit
if ( ! defined( 'WP_UNINSTALL_PLUGIN' )  ) {
	exit();
}
$loginRadiusSettings = get_option( 'LoginRadius_settings' );
if ( ! isset( $loginRadiusSettings['delete_options'] ) || $loginRadiusSettings['delete_options'] == 1 ) {
	global $wpdb;
	$loginRadiusOptions = array( 'LoginRadius_settings', 'loginradius_version' );
	// For Single site
	if ( ! is_multisite() ) {
		foreach ( $loginRadiusOptions as $option ) {
			delete_option( $option );
		}
		$wpdb->query( "delete from $wpdb->usermeta where meta_key like 'loginradius%'" );
	}else {
		// For Multisite
		$login_radius_blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
		$original_blog_id = get_current_blog_id();
		foreach ( $blog_ids as $blog_id ) {
			switch_to_blog( $blog_id );
			foreach ( $loginRadiusOptions as $option ) {
				delete_site_option( $option );
			}
		}
		switch_to_blog( $original_blog_id );
	}
}
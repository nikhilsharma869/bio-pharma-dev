<?php

/*------------------------------------*\
	 Add Custom Taxonomy Filter (via yoast.com)
\*------------------------------------*/

// Filter the request to just give posts for the given taxonomy, if applicable.
function ctslider_taxonomy_filter_restrict_manage_posts() {
	global $typenow;

	$post_types = get_post_types( array( '_builtin' => false ) );

	if ( in_array( $typenow, $post_types ) ) {
		$filters = get_object_taxonomies( $typenow );

		foreach ( $filters as $tax_slug ) {
			$tax_obj = get_taxonomy( $tax_slug );
			wp_dropdown_categories( array(
					'show_option_all' => __('Show All '.$tax_obj->label ),
					'taxonomy' 	  => $tax_slug,
					'name' 		  => $tax_obj->name,
					'orderby' 	  => 'name',
					'selected' 	  => $_GET[$tax_slug],
					'hierarchical' 	  => $tax_obj->hierarchical,
					'show_count' 	  => false,
					'hide_empty' 	  => true
			) );
		}
	}
}

add_action( 'restrict_manage_posts', 'ctslider_taxonomy_filter_restrict_manage_posts' );


function ctslider_taxonomy_filter_post_type_request( $query ) {
	global $pagenow, $typenow;

	if ( 'edit.php' == $pagenow ) {
		$filters = get_object_taxonomies( $typenow );
		foreach ( $filters as $tax_slug ) {
			$var = &$query->query_vars[$tax_slug];
			if ( isset( $var ) ) {
				$term = get_term_by( 'id', $var, $tax_slug );
				$var = $term->slug;
			}
		}
	}
}
add_filter( 'parse_query', 'ctslider_taxonomy_filter_post_type_request' );


/*------------------------------------*\
	 Add Slider Images as Column for Slider Post Type
\*------------------------------------*/

// Create Image Size for Thumbnails
add_image_size( 'admin-list-thumb', 50, 50, true );


// Add the column
function ctslider_add_remove_column( $cols ) {
	
	// Custom Column Position
	$colsstart = array_slice( $cols, 0, 1, true );
	$colsend   = array_slice( $cols, 1, null, true );
	
	// Add Thumbnail Column
	$cols = array_merge(
		$colsstart,
		array( 'ctslider_post_thumb' => __( 'Slide Image', 'ctslider' ) ),
		$colsend
	);
	//$cols['ctslider_post_thumb'] = __( 'Slide Image' );
	
	// Remove Date Column
	unset( $cols['date'] );

	return $cols;
}
add_filter('manage_slides_posts_columns', 'ctslider_add_remove_column', 5);


// Grab featured-thumbnail size post thumbnail and display it.
function ctslider_display_post_thumbnail_column( $col, $id ) {
	switch($col){
		case 'ctslider_post_thumb':
			if( function_exists('the_post_thumbnail') )
				echo the_post_thumbnail( 'admin-list-thumb' );
			else
				echo 'Enable Thumbnails!';
			break;
	}
}
add_action('manage_slides_posts_custom_column', 'ctslider_display_post_thumbnail_column', 5, 2);


/*------------------------------------*\
	 Add Order Column (menu_order)
\*------------------------------------*/

// Add The Column
function ctslider_add_new_slides_column( $slides_columns ) {
	$slides_columns['menu_order'] = "Order";
	return $slides_columns;
}
add_action( 'manage_edit-slides_columns', 'ctslider_add_new_slides_column' );


// Show Custom Order Values
function ctslider_show_order_column( $name ) {
	global $post;

	switch ($name) {
		case 'menu_order':
			$order = $post->menu_order;
			echo $order;
		break;
	 default:
		break;
	 }
}
add_action( 'manage_slides_posts_custom_column','ctslider_show_order_column' );


// Make It Sortable
function ctslider_order_column_register_sortable( $columns ) {
	$columns['menu_order'] = 'menu_order';
	return $columns;
}
add_filter( 'manage_edit-slides_sortable_columns','ctslider_order_column_register_sortable' );


// Presets Slides Order to be menu_order
function ctslider_set_custom_post_types_admin_order( $wp_query ) {
	if ( is_admin() ) {
		// Get the post type from the query
		$post_type = $wp_query->query['post_type'];
		// if it's one of our custom ones
		if ( $post_type == 'slides' ) {
			$wp_query->set( 'orderby', 'menu_order' );
			$wp_query->set( 'order', 'ASC' );
		}
	}
}
add_filter( 'pre_get_posts', 'ctslider_set_custom_post_types_admin_order' );
<?php

/*------------------------------------*\
   Register Slider Taxonomy
\*------------------------------------*/

function ctslider_register_slider_tax() {
	$labels = array(
		'name' 					=> _x( 'Sliders', 'taxonomy general name' ),
		'singular_name' 		=> _x( 'Slider', 'taxonomy singular name' ),
		'add_new' 				=> _x( 'Add New Slider', 'Slider'),
		'add_new_item' 			=> __( 'Add New Slider' ),
		'edit_item' 			=> __( 'Edit Slider' ),
		'new_item' 				=> __( 'New Slider' ),
		'view_item' 			=> __( 'View Slider' ),
		'search_items' 			=> __( 'Search Sliders' ),
		'not_found' 			=> __( 'No Slider found' ),
		'not_found_in_trash' 	=> __( 'No Slider found in Trash' ),
		'menu_name'				=> __( 'Slider Manager' )
	);
	
	$pages = array( 'slides' );
				
	$args = array(
		'labels' 			=> $labels,
		'singular_label' 	=> __( 'Slider', 'ctslider' ),
		'public' 			=> true,
		'show_ui' 			=> true,
		'query_var'			=> true,
		'hierarchical' 		=> false,
		'show_tagcloud' 	=> false,
		'show_in_nav_menus' => false,
		'rewrite' 			=> array( 'slug' => 'slider', 'with_front' => false ),
	 );
	register_taxonomy( 'slider', $pages, $args );
}
add_action( 'init', 'ctslider_register_slider_tax' );


/*------------------------------------*\
   Modify Slider Taxonomy Page - Adding Column for ID
\*------------------------------------*/

function ctslider_slider_columns( $defaults ) {
	$defaults['ctslider_slider_ids'] = __( 'ID', 'ctslider' );
	return $defaults;
}
add_filter( 'manage_edit-slider_columns', 'ctslider_slider_columns', 5 );


function ctslider_slider_custom_columns( $value, $column_name, $id ) {
	if ( $column_name == 'ctslider_slider_ids' ) {
		return (int)$id;
	}
}
add_action( 'manage_slider_custom_column', 'ctslider_slider_custom_columns', 5, 3 );

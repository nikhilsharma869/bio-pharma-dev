<?php

// Slider Shortcode
function ctslider_slider_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id' => ''
	), $atts ) );
	
	ob_start();

	ctslider_slider_template( $id );
	$output = ob_get_clean();

	return $output;
}
add_shortcode( 'slider', 'ctslider_slider_shortcode' );
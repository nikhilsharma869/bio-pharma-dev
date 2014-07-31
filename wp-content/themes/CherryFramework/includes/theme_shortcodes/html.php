<?php
/**
 *
 * HTML Shortcodes
 *
 */

// Frames
function frame_shortcode($atts, $content = null) {

    $output = '<figure class="thumbnail aligncenter clearfix">';
        $output .= do_shortcode($content);
    $output .= '</figure>';

    return $output;
}
add_shortcode('frame', 'frame_shortcode');

function frame_left_shortcode($atts, $content = null) {

    $output = '<figure class="thumbnail alignleft">';
        $output .= do_shortcode($content);
    $output .= '</figure>';

    return $output;
}
add_shortcode('frame_left', 'frame_left_shortcode');

function frame_right_shortcode($atts, $content = null) {

    $output = '<figure class="thumbnail alignright">';
        $output .= do_shortcode($content);
    $output .= '</figure>';

    return $output;
}
add_shortcode('frame_right', 'frame_right_shortcode');

// Button
function button_shortcode($atts, $content = null) {
	extract(shortcode_atts(
        array(
            'link' => 'http://www.google.com',
            'text' => 'Button Text',
			'size' => 'normal',
			'style' => '',
			'target' => '_self',
            'display' => '',
            'class' => '',
            'icon' => 'no'
    ), $atts));
    
    $output =  '<a href="'.$link.'" title="'.$text.'" class="btn btn-'.$style.' btn-'.$size.' btn-'.$display.' '.$class.'" target="'.$target.'">';
    if ($icon != 'no') {
        $output .= '<i class="icon-'.$icon.'"></i>';
    }    
	$output .= $text;
	$output .= '</a><!-- .btn -->';

    return $output;
}
add_shortcode('button', 'button_shortcode');


// Map
function map_shortcode($atts, $content = null) {

	extract(shortcode_atts(
        array(
				'src' => '',
				'width' => '',
				'height' => ''
    ), $atts));
    
    $output =  '<div class="google-map">';
			$output .= '<iframe src="'.$src.'" frameborder="0" width="'.$width.'" height="'.$height.'" marginwidth="0" marginheight="0" scrolling="no">';
			$output .= '</iframe>';
		$output .= '</div>';

    return $output;
}
add_shortcode('map', 'map_shortcode');


// Dropcaps
function dropcap_shortcode($atts, $content = null) {

    $output = '<span class="dropcap">';
    $output .= do_shortcode($content);
    $output .= '</span><!-- .dropcap (end) -->';

    return $output;
}
add_shortcode('dropcap', 'dropcap_shortcode');


// Horizontal Rule
function hr_shortcode($atts, $content = null) {

    $output = '<div class="hr"><!-- .hr (end) --></div>';

    return $output;
}
add_shortcode('hr', 'hr_shortcode');


// Small Horizontal Rule
function sm_hr_shortcode($atts, $content = null) {

    $output = '<div class="sm_hr"></div>';

    return $output;
}
add_shortcode('sm_hr', 'sm_hr_shortcode');


// Spacer
function spacer_shortcode($atts, $content = null) {

    $output = '<div class="spacer"><!-- .spacer (end) --></div>';

    return $output;
}
add_shortcode('spacer', 'spacer_shortcode');


// Blockquote
function blockquote_shortcode($atts, $content = null) {

    $output = '<blockquote>';
    $output .= do_shortcode($content);
    $output .= '</blockquote><!-- blockquote (end) -->';

    return $output;
}
add_shortcode('blockquote', 'blockquote_shortcode');


// Row
function row_shortcode($atts, $content=null) {

	// add divs to the content	
	$output = '<div class="row">';
	$output .= do_shortcode($content);
	$output .= '</div> <!-- .row (end) -->';
   
	return $output;
}
add_shortcode('row', 'row_shortcode');


// Row Inner
function row_inner_shortcode($atts, $content=null) {

    // add divs to the content  
    $output = '<div class="row">';
    $output .= do_shortcode($content);
    $output .= '</div> <!-- .row (end) -->';
   
    return $output;
}
add_shortcode('row_in', 'row_inner_shortcode');


// Row Fluid
function row_fluid_shortcode($atts, $content=null) {

    // add divs to the content  
    $output = '<div class="row-fluid">';
    $output .= do_shortcode($content);
    $output .= '</div> <!-- .row-fluid (end) -->';
   
    return $output;
}
add_shortcode('row_fluid', 'row_fluid_shortcode');

// Clear
function clear_shortcode($atts, $content = null) {

    $output = '<div class="clear"></div>';

    return $output;
}
add_shortcode('clear', 'clear_shortcode');


// Address
function address_shortcode($atts, $content = null) {
	
	$output = '<address>';
	$output .= do_shortcode($content);
	$output .= '</address> <!-- address (end) -->';
   
	return $output;
}
add_shortcode('address', 'address_shortcode');


// Lists

// Unstyled
function list_un_shortcode($atts, $content = null) {
    $output = '<div class="list unstyled">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('list_un', 'list_un_shortcode');

// Check List
function check_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled check-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('check_list', 'check_list_shortcode');

// Check2 List
function check2_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled check2-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('check2_list', 'check2_list_shortcode');

// Arrow List
function arrow_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled arrow-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('arrow_list', 'arrow_list_shortcode');

// Arrow2 List
function arrow2_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled arrow2-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('arrow2_list', 'arrow2_list_shortcode');

// Star List
function star_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled star-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('star_list', 'star_list_shortcode');

// Plus List
function plus_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled plus-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('plus_list', 'plus_list_shortcode');

// Minus List
function minus_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled minus-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('minus_list', 'minus_list_shortcode');

// Custom List
function custom_list_shortcode($atts, $content = null) {
    $output = '<div class="list styled custom-list">';
    $output .= do_shortcode($content);
    $output .= '</div>';
    return $output;
}
add_shortcode('custom_list', 'custom_list_shortcode');


// Vertical Rule
function vr_shortcode($atts, $content = null) {
	
	$output = '<div class="vertical-divider">';
	$output .= do_shortcode($content);
	$output .= '</div> <!-- divider (end) -->';
   
	return $output;
}
add_shortcode('vr', 'vr_shortcode');


// Label
function label_shortcode($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'style' => '',
            'icon' => ''
    ), $atts));

    $output = '<span class="label label-'.$style.'">';
    if ($icon != "") {
        $output .= '<i class="'.$icon.'"></i>';
    }
    $output .= $content .'</span>';

    return $output;
}
add_shortcode('label', 'label_shortcode');


// Text Highlight
function highlight_shortcode($atts, $content = null) {

    $output = '<span class="text-highlight">';
    $output .= do_shortcode($content);
    $output .= '</span><!-- .highlight (end) -->';

    return $output;
}
add_shortcode('highlight', 'highlight_shortcode');


// Icon
function icon_shortcode($atts, $content = null) {

    extract(shortcode_atts(
        array(
            'image' => '',
            'align' => ''
    ), $atts));

    $template_url = get_stylesheet_directory_uri();

    if ($image != '') {
        $output = '<figure class="align'. $align .'"><img src="'. $template_url  .'/images/iconSweets/'. $image .'.png" alt=""></figure>';
        return $output;
    }    
}
add_shortcode('icon', 'icon_shortcode');

// Template URL
function template_url_shortcode($atts, $content = null) {

    $template_url = home_url();
    return $template_url;
}
add_shortcode('template_url', 'template_url_shortcode');
?>
<?php
/**
 * Banner
 *
 */

function banner_shortcode($atts, $content = null) {
 
    extract(shortcode_atts(
        array(
			'img' => '',
			'banner_link' => '',
			'title' => '',
			'text' => '',
			'btn_text' => '',
			'target' => ''
    ), $atts));
 
	$output =  '<div class="banner-wrap">'; 
	if ($img !="") {
		$output .= '<figure class="featured-thumbnail">';
		if ($banner_link != "") {
			$output .= '<a href="'. $banner_link .'" title="'. $title .'"><img src="'. $img .'" title="'. $title .'" alt="" />';
		} else {
			$output .= '<a href="#" title="'. $title .'"><img src="'. $img .'" title="'. $title .'" alt="" />';
		}
		$output .= '</a></figure>';
	}
 
	if ($title!="") {
		$output .= '<h5>';
		$output .= $title;
		$output .= '</h5>';
	}
	
	if ($text!="") {
		$output .= '<p>';
		$output .= $text;
		$output .= '</p>';
	}
	
	if ($btn_text!="") {	
		$output .=  '<div class="link-align"><a href="'.$banner_link.'" title="'.$btn_text.'" class="btn btn-link" target="'.$target.'">';
		$output .= $btn_text;
		$output .= '</a></div>';
	}
 
	$output .= '</div><!-- .banner-wrap (end) -->';
 
    return $output;
 
}
 
add_shortcode('banner', 'banner_shortcode');
?>
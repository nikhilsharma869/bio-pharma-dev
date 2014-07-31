<?php
/**
 * Post Grid
 *
 */

function posts_grid_shortcode($atts, $content = null) {
	extract(shortcode_atts(array(
		'type' => '',
		'columns' => '3',
		'rows' => '3',
		'order_by' => 'date',
		'order' => 'DESC',
		'thumb_width' => '370',
		'thumb_height' => '250',
		'excerpt_count' => '15',
		'link' => 'yes',
		'link_text' => 'read more'
	), $atts));


	$spans = $columns;

	// columns
	switch ($spans) {
		case '1':
			$spans = 'span12';
			break;
		case '2':
			$spans = 'span6';
			break;
		case '3':
			$spans = 'span4';
			break;
		case '4':
			$spans = 'span3';
			break;
	}

	// check what order by method user selected
	switch ($order_by) {
		case 'date':
			$order_by = 'post_date';
			break;
		case 'title':
			$order_by = 'title';
			break;
		case 'popular':
			$order_by = 'comment_count';
			break;
		case 'random':
			$order_by = 'rand';
			break;
	}

	// check what order method user selected (DESC or ASC)
	switch ($order) {
		case 'DESC':
			$order = 'DESC';
			break;
		case 'ASC':
			$order = 'ASC';
			break;
	}

	// show link after posts?
	switch ($link) {
		case 'yes':
			$link = true;
			break;
		case 'no':
			$link = false;
			break;
	}

		global $post;
		global $my_string_limit_words;

		$numb = $columns * $rows;
						
		$args = array(
			'post_type' => $type,
			'numberposts' => $numb,
			'orderby' => $order_by,
			'order' => $order
		);		

		$posts = get_posts($args);
		$i = 0;
		$count = 1;
		$output_end = '';
		if ($numb > count($posts)) {
			$output_end = '</ul>';
		}

		$output = '<ul class="posts-grid row-fluid unstyled">';

		for ($j=0; $j < count($posts); $j++) { 
			setup_postdata($posts[$j]);
			$excerpt = get_the_excerpt();
			$attachment_url = wp_get_attachment_image_src( get_post_thumbnail_id($posts[$j]->ID), 'full' );
			$url = $attachment_url['0'];
			$image = aq_resize($url, $thumb_width, $thumb_height, true);
			$mediaType = get_post_meta($posts[$j]->ID, 'tz_portfolio_type', true);
			$prettyType = 0;

				if ($count > $columns) {
					$count = 1;
					$output .= '<ul class="posts-grid row-fluid">';					
				}

				$output .= '<li class="'. $spans .'">';
					if(has_post_thumbnail($posts[$j]->ID) && $mediaType == 'Image') {
											
						$prettyType = 'prettyPhoto';									

						$output .= '<figure class="featured-thumbnail thumbnail">';
						$output .= '<a href="'.$url.'" title="'.get_the_title($posts[$j]->ID).'" rel="' .$prettyType.'">';
						$output .= '<img  src="'.$image.'" alt="'.get_the_title($posts[$j]->ID).'" />';
						$output .= '<span class="zoom-icon"></span></a></figure>';
					} elseif ($mediaType != 'Video' && $mediaType != 'Audio') {					

						$thumbid = 0;
						$thumbid = get_post_thumbnail_id($posts[$j]->ID);
										
						$images = get_children( array(
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'post_type' => 'attachment',
							'post_parent' => $posts[$j]->ID,
							'post_mime_type' => 'image',
							'post_status' => null,
							'numberposts' => -1
						) ); 

						if ( $images ) {

							$k = 0;
							//looping through the images
							foreach ( $images as $attachment_id => $attachment ) {
								$prettyType = "prettyPhoto[gallery".$i."]";								
								//if( $attachment->ID == $thumbid ) continue;

								$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
								$img = aq_resize( $image_attributes[0], $thumb_width, $thumb_height, true ); //resize & crop img
								$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
								$image_title = $attachment->post_title;

								if ( $k == 0 ) {
									$output .= '<figure class="featured-thumbnail thumbnail">';
									$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($posts[$j]->ID).'" rel="' .$prettyType.'">';
									$output .= '<img  src="'.$img.'" alt="'.get_the_title($posts[$j]->ID).'" />';
								} else {
									$output .= '<figure class="featured-thumbnail thumbnail" style="display:none;">';
									$output .= '<a href="'.$image_attributes[0].'" title="'.get_the_title($posts[$j]->ID).'" rel="' .$prettyType.'">';
									$output .= '<img  src="'.$img.'" alt="'.get_the_title($posts[$j]->ID).'" />';
								}
								$output .= '<span class="zoom-icon"></span></a></figure>';
								$k++;
							}					
						} elseif (has_post_thumbnail($posts[$j]->ID)) {
							$prettyType = 'prettyPhoto';
							$output .= '<figure class="featured-thumbnail thumbnail">';
							$output .= '<a href="'.$url.'" title="'.get_the_title($posts[$j]->ID).'" rel="' .$prettyType.'">';
							$output .= '<img  src="'.$image.'" alt="'.get_the_title($posts[$j]->ID).'" />';
							$output .= '<span class="zoom-icon"></span></a></figure>';
						}
					} else {

						// for Video and Audio post format - no lightbox
						$output .= '<figure class="featured-thumbnail thumbnail"><a href="'.get_permalink($posts[$j]->ID).'" title="'.get_the_title($posts[$j]->ID).'">';
						$output .= '<img  src="'.$image.'" alt="'.get_the_title($posts[$j]->ID).'" />';
						$output .= '</a></figure>';
					}

					$output .= '<h5><a href="'.get_permalink($posts[$j]->ID).'" title="'.get_the_title($posts[$j]->ID).'">';
						$output .= get_the_title($posts[$j]->ID);
					$output .= '</a></h5>';

					if($excerpt_count >= 1){
						$output .= '<p class="excerpt">';
							$output .= my_string_limit_words($excerpt,$excerpt_count);
						$output .= '</p>';
					}
					if($link){
						$output .= '<a href="'.get_permalink($posts[$j]->ID).'" class="btn btn-primary" title="'.get_the_title($posts[$j]->ID).'">';
						$output .= $link_text;
						$output .= '</a>';
					}
					$output .= '</li>';
					if ($j == count($posts)-1) {
						$output .= $output_end;
					}
				if ($count % $columns == 0) {
					$output .= '</ul><!-- .posts-grid (end) -->';
				}
			$count++;
			$i++;		

		} // end for
		
		return $output;
}
 
add_shortcode('posts_grid', 'posts_grid_shortcode'); ?>
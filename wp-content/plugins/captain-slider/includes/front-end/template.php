<?php

// Create Slider
	
function ctslider_slider_template( $id ) {
	
	// Query Arguments
	$args = array(
		'post_type' => 'slides',
		'posts_per_page' => -1,
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	
	$array2 = array(
		array(
			'taxonomy' 	=> 'slider',
			'field'		=> 'id',
			'terms'		=>  $id
		)
	);
			
	if ( $id )
		$args['tax_query'] = $array2;
	
	// The Query
	$the_query = new WP_Query( $args );
	
	// Check if the Query returns any posts
	if ( $the_query->have_posts() ) {
		ob_start(); ?>
		
		<div class="flexslider">
			<ul class="slides">
			
				<?php		
				//$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
				//data-thumb="<?php echo $thumb; ? >"

				while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

					<!--<li <?php //post_class(); ?>>-->
                                        element.style

					<?php // Check if there's a Slide URL given and if so let's a link to it

					if ( get_post_meta( get_the_id(), 'ctslider_slidelink', true ) != '' ) { ?>
						<a href="<?php echo esc_url( get_post_meta( get_the_id(), 'ctslider_slidelink', true ) ); ?>">
					<?php
					}

					if ( get_post_meta( get_the_id(), 'ctslider_videoembedcode', true ) != '' ) {
						// Slide Video
						?>
						<?php echo get_post_meta( get_the_id(), 'ctslider_videoembedcode', true ); ?>
					<?php } else {
						// The Slide's Image
						$width = ctslider_options_each( 'width' );
						$height = ctslider_options_each( 'height' );

						// Check custom width/height for slider has been set. If so, display a thumbnail with that size. If not, display normal thumbnail.
						if ( $width && $height !== 0 ) {
							echo the_post_thumbnail( 'ctslider_slide' );
						} else {
							echo the_post_thumbnail();
						}
					}

					// Close off the Slide's Link if there is one
					if ( get_post_meta( get_the_id(), 'ctslider_slidelink', true ) != '' ) { ?>
						</a>
					<?php } ?>
					
					<?php
					// Slide Caption
					if ( get_post_meta( get_the_id(), 'ctslider_captiontext', true) != '' ) { ?>
					<p class="flex-caption"><?php echo get_post_meta( get_the_id(), 'ctslider_captiontext', true ); ?></p>
					<?php } ?>
					
					</li>
				<?php endwhile; ?>
		
			</ul><!-- .slides -->
		</div><!-- .flexslider -->

		<?php
		echo ob_get_clean();

	}

	wp_reset_postdata();
}
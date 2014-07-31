<?php

$width = ctslider_options_each( 'width' );
$height = ctslider_options_each( 'height' );

// Check custom width/height for slider has been set before adding the image size. If not, do nothing.
if ( $width && $height != 0 ) {
	add_image_size( 'ctslider_slide', $width, $height, true );
}

// Omit that damn closing PHP tag
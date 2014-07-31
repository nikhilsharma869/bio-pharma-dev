<?php
// include sharing script in head section
if ( login_radius_scripts_in_footer_enabled() ) {
	add_action( 'wp_footer', 'login_radius_get_sharing_code' );
}else {
	add_action( 'wp_enqueue_scripts', 'login_radius_get_sharing_code' );
}
$loginRadiusVerticalInterfaceContentcount = 0;
$loginRadiusVerticalInterfaceExcerptcount = 0;
function login_radius_share_content( $content ) {
	global $post, $loginRadiusLoginIsBpActive;
	$lrMeta = get_post_meta( $post->ID, '_login_radius_meta', true );
	// if sharing disabled on this page/post, return content unaltered
	if ( isset( $lrMeta['sharing'] ) && $lrMeta['sharing'] == 1 && ! is_front_page() ) {
		return $content;
	}
	global $loginRadiusSettings;
	$loginRadiusSettings['LoginRadius_sharingTitle'] = isset( $loginRadiusSettings['LoginRadius_sharingTitle'] ) ? trim( $loginRadiusSettings['LoginRadius_sharingTitle'] ) : '';
	if ( isset( $loginRadiusSettings['horizontal_shareEnable'] ) && $loginRadiusSettings['horizontal_shareEnable'] == '1' ) {
		if ( isset( $loginRadiusSettings['horizontalSharing_theme'] ) && ( $loginRadiusSettings['horizontalSharing_theme'] == '32' || $loginRadiusSettings['horizontalSharing_theme'] == '16' || $loginRadiusSettings['horizontalSharing_theme'] == 'single_large' || $loginRadiusSettings['horizontalSharing_theme'] == 'single_small' )  ) {
			$loginRadiusHorizontalSharingDiv = '<div class="loginRadiusHorizontalSharing"';
			if ( ! isset( $loginRadiusSettings['sharingCount'] ) || $loginRadiusSettings['sharingCount'] == 'page' ) {
				$loginRadiusHorizontalSharingDiv .= ' data-share-url="'.get_permalink( $post->ID ) .'"';
			}
			$loginRadiusHorizontalSharingDiv .= ' ></div>';
		}elseif ( isset( $loginRadiusSettings['horizontalSharing_theme'] ) && ( $loginRadiusSettings['horizontalSharing_theme'] == 'counter_horizontal' || $loginRadiusSettings['horizontalSharing_theme'] == 'counter_vertical' )  ) {
			$loginRadiusHorizontalSharingDiv = '<div class="loginRadiusHorizontalSharing"';
			if ( ! isset( $loginRadiusSettings['sharingCount'] ) || $loginRadiusSettings['sharingCount'] == 'page' ) {
				$loginRadiusHorizontalSharingDiv .= ' data-share-url="'.get_permalink( $post->ID ) .'" data-counter-url="'.get_permalink( $post->ID ) .'"';
			}
			$loginRadiusHorizontalSharingDiv .= ' ></div>';
		}else {
			$loginRadiusHorizontalSharingDiv = '<div class="loginRadiusHorizontalSharing"';
			if ( ! isset( $loginRadiusSettings['sharingCount'] ) || $loginRadiusSettings['sharingCount'] == 'page' ) {
				$loginRadiusHorizontalSharingDiv .= ' data-share-url="'.get_permalink( $post->ID ) .'"';
			}
			$loginRadiusHorizontalSharingDiv .= ' ></div>';
		}
		$horizontalDiv = "<div style='margin:0'><b>" . ucfirst( $loginRadiusSettings['LoginRadius_sharingTitle'] ) . '</b></div>' . $loginRadiusHorizontalSharingDiv;
		if (  (  (  ( isset( $loginRadiusSettings['horizontal_sharehome'] ) && current_filter() == 'the_content' ) || ( isset( $loginRadiusSettings['horizontal_shareexcerpt'] ) &&  current_filter() == 'get_the_excerpt' )  ) && is_front_page() ) || ( isset( $loginRadiusSettings['horizontal_sharepost'] ) && is_single() ) || ( isset( $loginRadiusSettings['horizontal_sharepage'] ) && is_page() )  ) {	
			if ( isset( $loginRadiusSettings['horizontal_shareTop'] ) && isset( $loginRadiusSettings['horizontal_shareBottom'] )  ) {
				$content = $horizontalDiv.'<br/>'.$content.'<br/>'.$horizontalDiv;
			}else {
				if ( isset( $loginRadiusSettings['horizontal_shareTop'] )  ) {
					$content = $horizontalDiv.$content;
				}
				elseif ( isset( $loginRadiusSettings['horizontal_shareBottom'] )  ) {
					$content = $content.$horizontalDiv;
				}
			}
		}
	}
	if ( isset( $loginRadiusSettings['vertical_shareEnable'] ) && $loginRadiusSettings['vertical_shareEnable'] == '1' ) {
		$loginRadiusVerticalSharingDiv = '<div class="loginRadiusVerticalSharing" style="z-index: 10000000"></div>';
		// show vertical sharing	
		if (  (  (  ( isset( $loginRadiusSettings['vertical_sharehome'] ) && current_filter() == 'the_content' ) || ( isset( $loginRadiusSettings['vertical_shareexcerpt'] ) &&  current_filter() == 'get_the_excerpt' )  ) && is_front_page() ) || ( isset( $loginRadiusSettings['vertical_sharepost'] ) && is_single() ) || ( isset( $loginRadiusSettings['vertical_sharepage'] ) && is_page() )  ) {
			if ( is_front_page() ) {
				global $loginRadiusVerticalInterfaceContentCount, $loginRadiusVerticalInterfaceExcerptCount;
				if ( current_filter() == 'the_content' ) {
					$compareVariable = 'loginRadiusVerticalInterfaceContentCount';
				}elseif ( current_filter() == 'get_the_excerpt' ) {
					$compareVariable = 'loginRadiusVerticalInterfaceExcerptCount';
				}
				if ( $$compareVariable == 0 ) {
					$content = $content.$loginRadiusVerticalSharingDiv;
					$$compareVariable++;
				}
			}else {
				$content = $content.$loginRadiusVerticalSharingDiv;
			}
		}
	}
	return $content;
}
add_filter( 'the_content', 'login_radius_share_content' );
add_filter( 'get_the_excerpt', 'login_radius_share_content' );
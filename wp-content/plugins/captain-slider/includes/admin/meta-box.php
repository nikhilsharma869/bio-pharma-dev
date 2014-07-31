<?php
/**
 * Metabox Functions
 *
 * @package     Captain Slider
 * @subpackage  Metabox Functions
 * @copyright   Copyright (c) 2012, Bryce Adams
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */


/**
 * Setup Metabox
 *
 * Creates the array to setup the metabox as well all the metabox fields
 *
 * @since      1.0.0
 */

$ctslider_slidecaption_1_metabox = array( 
	'id' => 'slidecaption',
	'title' => __( 'Slider Settings', 'ctslider' ),
	'page' => array( 'slides' ),
	'context' => 'normal',
	'priority' => 'default',
	'fields' => array(
		array(
			'name' 			=> __( 'Slide Link', 'ctslider' ),
			'desc' 			=> __( "Where you'd like the slide to link to. If you leave this field blank the slide will not link anywhere.", 'ctslider' ),
			'id' 			=> 'ctslider_slidelink',
			'class' 		=> 'ctslider_slidelink',
			'type' 			=> 'text',
			'rich_editor' 	=> 0,			
			'max' 			=> 0				
		),
					
		array(
			'name' 			=> __( 'Caption Text', 'ctslider' ),
			'desc' 			=> __( "If you'd like to have a caption displayed with the slide, enter it here. If you leave this field blank, there will be no caption.", 'ctslider' ),
			'id' 			=> 'ctslider_captiontext',
			'class' 		=> 'ctslider_captiontext',
			'type' 			=> 'textarea',
			'rich_editor' 	=> 0,			
			'max' 			=> 0				
		),
					
		array(
			'name' 			=> __( 'Video Embed Code', 'ctslider' ),
			'desc' 			=> __( "Paste here the iFrame Video Embed code. It will replace the image if you've set one. If you're copying from Vimeo, make sure you don't include the text link below.", 'ctslider' ),
			'id' 			=> 'ctslider_videoembedcode',
			'class' 		=> 'ctslider_videoembedcode',
			'type' 			=> 'textarea',
			'rich_editor' 	=> 0,			
			'max' 			=> 0				
		),
	)
);					


/**
 * Register all metaboxes for sliders.
 *
 * @access      private
 * @since       1.0.0
 * @return      void
 */

function ctslider_add_slidecaption_1_meta_box() {
	global $ctslider_slidecaption_1_metabox;		

	foreach ( $ctslider_slidecaption_1_metabox['page'] as $page ) {
		add_meta_box( $ctslider_slidecaption_1_metabox['id'], $ctslider_slidecaption_1_metabox['title'], 'ctslider_show_slidecaption_1_box', $page, 'normal', 'default', $ctslider_slidecaption_1_metabox );
	}
}
add_action('admin_menu', 'ctslider_add_slidecaption_1_meta_box');

	
/**
 * Display the meta boxes
 *
 * @access      private
 * @since       1.0.0
 * @return      void
 */ 

function ctslider_show_slidecaption_1_box()	{
	global $post, $ctslider_slidecaption_1_metabox, $ctslider_prefix, $wp_version;
	
	// Use nonce for verification
	echo '<input type="hidden" name="ctslider_slidecaption_1_meta_box_nonce" value="'. wp_create_nonce( basename( __FILE__ ) ) .'" />';
	echo '<table class="form-table">';

	foreach ( $ctslider_slidecaption_1_metabox['fields'] as $field ) {
		$meta = get_post_meta( $post->ID, $field['id'], true );
		
		echo '<tr>',
				'<th style="width:20%"><label for="', $field['id'], '">', stripslashes( $field['name'] ), '</label></th>',
				'<td class="ctslider_field_type_' . str_replace( ' ', '_', $field['type'] ) . '">';

		switch( $field['type'] ) {
			case 'text':
				echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta : $field['std'], '" size="30" style="width:97%" /><br/>', '', __( stripslashes( $field['desc'] ), 'ctslider' );
			break;

			case 'textarea':
				if ( $field['rich_editor'] == 1 ) {
					if ( $wp_version >= 3.3 ) {
						echo wp_editor( $meta, $field['id'], array( 'textarea_name' => $field['id'] ) );
					} else {
						$editor = '';
						if( !post_type_supports( $post->post_type, 'editor' ) ) {
							$editor = wp_tiny_mce( true, array( 'editor_selector' => $field['class'], 'remove_linebreaks' => false ) );
						}
						$field_html = '<div style="width: 97%; border: 1px solid #DFDFDF;"><textarea name="' . $field['id'] . '" class="' . $field['class'] . '" id="' . $field['id'] . '" cols="60" rows="8" style="width:100%">'. $meta . '</textarea></div><br/>' . __( stripslashes( $field['desc'] ), 'ctslider' );
						echo $editor . $field_html;
					}
				} else {
					echo '<div style="width: 100%;"><textarea name="', $field['id'], '" class="', $field['class'], '" id="', $field['id'], '" cols="60" rows="8" style="width:97%">', $meta ? $meta : $field['std'], '</textarea></div>', '', __( stripslashes( $field['desc'] ), 'ctslider' );
				}
			break;
		}

		echo     '<td>',
			'</tr>';
	}

	echo '</table>';
}


/**
 * Save Meta Box Data
 *
 * @access      private
 * @since       1.0.0.
 * @return      void
 */

function ctslider_slidecaption_1_save( $post_id ) {
	global $post, $ctslider_slidecaption_1_metabox;
	
	if ( !wp_verify_nonce( $_POST['ctslider_slidecaption_1_meta_box_nonce'], basename(__FILE__) ) )
		return $post_id;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
		return $post_id;

	// Check Capabilities
	if ( 'page' == $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	
	foreach ( $ctslider_slidecaption_1_metabox['fields'] as $field ) {
		$old = get_post_meta( $post_id, $field['id'], true );
		$new = $_POST[$field['id']];

		if ( $new && $new != $old ) {
			if ( $field['type'] == 'date' ) {
				$new = ctslider_format_date( $new );
				update_post_meta( $post_id, $field['id'], $new );
			} else {
				if ( is_string( $new ) )
					$new = $new;
				update_post_meta( $post_id, $field['id'], $new );
			}
		} elseif ('' == $new && $old) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}
add_action('save_post', 'ctslider_slidecaption_1_save');


/**
 * Rename Post Thumbnail Meta Box
 *
 * @access      private
 * @since       1.0.0
 * @return      void
 */

function ctslider_change_image_box() {
	remove_meta_box( 'postimagediv', 'slides', 'side' );
	add_meta_box('postimagediv', __( 'Slide Image', 'ctslider' ), 'post_thumbnail_meta_box', 'slides', 'normal', 'high');
}
add_action('do_meta_boxes', 'ctslider_change_image_box');
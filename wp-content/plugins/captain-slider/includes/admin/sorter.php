<?php

// Custom Drag/Drop Ordering Interface

function ctslider_register_slides_menu() {
	add_submenu_page(
		'edit.php?post_type=slides',
		'Slider Sorter',
		'Sorter',
		'edit_pages', 'slides-order',
		'ctslider_slides_order_page'
	);
}
add_action( 'admin_menu', 'ctslider_register_slides_menu' );


function ctslider_slides_order_page() {
	ob_start();
?>
	<div class="wrap">
		<h2>Sort Slides</h2>
		<p>Simply drag the slides up or down and they will be saved in that order.</p>
	<?php $slides = new WP_Query( array( 'post_type' => 'slides', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order' ) ); ?>
	<?php if( $slides->have_posts() ) : ?>

		<table class="wp-list-table widefat fixed posts" id="sortable-table">
			<thead>
				<tr>
					<th class="column-order"><?php _e('Order', 'ctslider'); ?></th>
					<th class="column-thumbnail"><?php _e('Slide Image', 'ctslider'); ?></th>
					<th class="column-title"><?php _e('Title', 'ctslider'); ?></th>
				</tr>
			</thead>
			<tbody data-post-type="slide">
			<?php while ( $slides->have_posts() ): $slides->the_post(); ?>
				<tr id="post-<?php the_ID(); ?>">
					<td class="column-order"><img src="<?php echo CTSLIDER_PLUGIN_URL . 'assets/images/move.svg'; ?>" title="" alt="<?php _e('Move Icon', 'ctslider'); ?>" width="20" height="20" class="" /></td>
					<td class="column-thumbnail"><?php the_post_thumbnail( 'admin-list-thumb' ); ?></td>
					<td class="column-title"><strong><?php the_title(); ?></strong><div class="excerpt"><em><?php echo get_post_meta( get_the_id(), 'ctslider_captiontext', true); ?></em></div></td>
				</tr>
			<?php endwhile; ?>
			</tbody>
			<tfoot>
				<tr>
					<th class="column-order"><?php _e('Order', 'ctslider'); ?></th>
					<th class="column-thumbnail"><?php _e('Slide Image', 'ctslider'); ?></th>
					<th class="column-title"><?php _e('Title', 'ctslider'); ?></th>
				</tr>
			</tfoot>

		</table>

	<?php else: ?>
		<p><?php printf( __('No slides found, why not %screate one%s?	', 'ctslider'), '<a href="post-new.php?post_type=slides">', '</a>'); ?></p>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>

	<style type="text/css">
		/* Dodgy CSS ^_^ */
		#sortable-table td { background: white; }
		#sortable-table .column-order { padding: 3px 10px; width: 50px; }
			#sortable-table .column-order img { cursor: move; }
		#sortable-table td.column-order { vertical-align: middle; text-align: center; }
		/*#sortable-table td.column-title {vertical-align: middle; }*/
		#sortable-table .column-thumbnail { width: 100px; }
	</style>

	</div><!-- .wrap -->
	<?php echo ob_get_clean();
}


// jQuery UI
function ctslider_admin_enqueue_scripts() {
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_script( 'ctslider-admin-scripts', CTSLIDER_PLUGIN_URL . 'includes/js/admin-scripts.js' );
}
add_action( 'admin_enqueue_scripts', 'ctslider_admin_enqueue_scripts' );


// AJAX Callbacks
function ctslider_update_post_order() {
	global $wpdb;

	$post_type    = $_POST['postType'];
	$order        = $_POST['order'];

	/**
	*    Expect: $sorted = array(
	*                menu_order => post-XX
	*            );
	*/
	foreach ( $order as $menu_order => $post_id ) {
		$post_id    = intval( str_ireplace( 'post-', '', $post_id ) );
		$menu_order = intval( $menu_order );
		wp_update_post( array( 'ID' => $post_id, 'menu_order' => $menu_order ) );
	}

	die( '1' );
}
add_action( 'wp_ajax_ctslider_update_post_order', 'ctslider_update_post_order' );
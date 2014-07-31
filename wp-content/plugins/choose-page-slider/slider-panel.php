<?php
   
add_action('admin_menu', 'slider_add_box');

$meta_box_slider = array(
	'id' => 'top-slider',
	'title' => 'Slider shortcode',
	'page' => 'page',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
	)
);

// Add meta box
function slider_add_box() {
	global $meta_box_slider;
	add_meta_box($meta_box_slider['id'], $meta_box_slider['title'], 'slider_show_box', $meta_box_slider['page'], $meta_box_slider['context'], $meta_box_slider['priority']);
}

// Callback function to show fields in meta box
function slider_show_box() {
	global $post,$wpdb;
	$post_id = $post->ID;
	
	$args= array('role'=>'player');
	$players = get_users( $args );
	//print'<pre>';print_r($players);exit;
	?>
    <table width="100%">
    	<tr>
        	<td><strong>Enter Slider shortcode</strong></td>
        	<td>
            	<input type="text" name="slider_shortcode" value="<?php echo get_post_meta($post_id,'slider_shortcode',true);?>" />
            	<a target="_blank" href="<?php echo site_url();?>/wp-admin/admin.php?page=metaslider">Click here</a> for slider short code.
            </td>
        </tr>
        <tr><td></td><td>If you want just image as top banner. Then leave it blank and choose Featured image.</td></tr>
        
        
     </table>

<?php
}

add_action('save_post', 'slider_save_data');

// Save data from meta box
function slider_save_data($post_id) {
	global $post;
	$post_id = $post->ID;
	
	update_post_meta($post_id, 'slider_shortcode', $_POST['slider_shortcode'], $prev_value);
}

?>
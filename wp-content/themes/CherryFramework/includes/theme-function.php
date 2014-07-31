<?php

 // Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 900;

// The excerpt based on words
function my_string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words).'... ';
}


// The excerpt based on character
function my_string_limit_char($excerpt, $substr=0)
{

	$string = strip_tags(str_replace('...', '...', $excerpt));
	if ($substr>0) {
		$string = substr($string, 0, $substr);
	}
	return $string;
		}


add_action( 'after_setup_theme', 'my_setup' );


// Remove invalid tags
function remove_invalid_tags($str, $tags) 
{
    foreach($tags as $tag)
    {
    	$str = preg_replace('#^<\/'.$tag.'>|<'.$tag.'>$#', '', trim($str));
    }

    return $str;
}

// Generates a random string (for embedding flash)
function gener_random($length){

	srand((double)microtime()*1000000 );
	
	$random_id = "";
	
	$char_list = "abcdefghijklmnopqrstuvwxyz";
	
	for($i = 0; $i < $length; $i++) {
		$random_id .= substr($char_list,(rand()%(strlen($char_list))), 1);
	}
	
	return $random_id;
}


// Remove Empty Paragraphs
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content)
{   
	$array = array (
			'<p>[' => '[', 
			']</p>' => ']', 
			']<br />' => ']'
	);

	$content = strtr($content, $array);

return $content;
}




// For embedding video file
function mytheme_video($file, $image, $width, $height, $color){

	//Template URL
	$template_url = get_template_directory_uri();
	
	//Unique ID
	$id = "video-".gener_random(15);
	
	$object_height = $height + 39;

	//JS
	$output  = '<script type="text/javascript">'."\n";
	$output .= 'var flashvars = {};'."\n";
	$output .= 'flashvars.player_width="'.$width.'";'."\n";
	$output .= 'flashvars.player_height="'.$height.'"'."\n";
	$output .= 'flashvars.player_id="'.$id.'";'."\n";
	$output .= 'flashvars.thumb="'.$image.'";'."\n";
	$output .= 'flashvars.colorTheme="'.$color.'";'."\n";
	$output .= 'var params = { "wmode": "transparent" };'."\n";
	$output .= 'params.wmode = "transparent";'."\n";
	$output .= 'params.quality = "high";';
	$output .= 'params.allowFullScreen = "true";'."\n";
	$output .= 'params.allowScriptAccess = "always";'."\n";
	$output .= 'params.quality="high";'."\n";
	$output .= 'var attributes = {};'."\n";
	$output .= 'attributes.id = "'.$id.'";'."\n";
	$output .= 'swfobject.embedSWF("'.$template_url.'/flash/video.swf?fileVideo='.$file.'", "'.$id.'", "'.$width.'", "'.$object_height.'", "9.0.0", false, flashvars, params, attributes);'."\n";
	$output .= '</script>'."\n\n";
	
	$output .= '<div class="video-bg" style="width:'.$width.'px; height:'.$height.'px; background-image:url('.$image.')">'."\n";
	$output .= '</div>'."\n";
	
	//HTML
	$output .= '<div id="'.$id.'">'."\n";
		$output .= '<a href="http://www.adobe.com/go/getflashplayer">'."\n";
				$output .= '<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />'."\n";
		$output .= '</a>'."\n";
	$output .= '</div>';

	return $output;
    
}



// Add Thumb Column
if ( !function_exists('fb_AddThumbColumn') && function_exists('add_theme_support') ) {
// for post and page
add_theme_support('post-thumbnails', array( 'post', 'page' ) );
function fb_AddThumbColumn($cols) {
$cols['thumbnail'] = __('Thumbnail', 'cherry');
return $cols;
}
function fb_AddThumbValue($column_name, $post_id) {
$width = (int) 35;
$height = (int) 35;
if ( 'thumbnail' == $column_name ) {
// thumbnail of WP 2.9
$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
// image from gallery
$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
if ($thumbnail_id)
$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
elseif ($attachments) {
foreach ( $attachments as $attachment_id => $attachment ) {
$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
}
}
if ( isset($thumb) && $thumb ) {
echo $thumb;
} else {
echo __('None', 'cherry');
}
}
}
// for posts
add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
// for pages
add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
}



// Show filter by categories for custom posts
function my_restrict_manage_posts() {
	global $typenow;
	$args=array( 'public' => true, '_builtin' => false ); 
	$post_types = get_post_types($args);
	if ( in_array($typenow, $post_types) ) {
	$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			wp_dropdown_categories(array(
				'show_option_all' => __('Show All '.$tax_obj->label, 'cherry' ),
				'taxonomy' => $tax_slug,
				'name' => $tax_obj->name,
				'orderby' => 'term_order',
				'selected' => $_GET[$tax_obj->query_var],
				'hierarchical' => $tax_obj->hierarchical,
				'show_count' => false,
				'hide_empty' => true
			));
		}
	}
}
function my_convert_restrict($query) {
	global $pagenow;
	global $typenow;
	if ($pagenow=='edit.php') {
		$filters = get_object_taxonomies($typenow);
		foreach ($filters as $tax_slug) {
			$var = &$query->query_vars[$tax_slug];
			if ( isset($var) ) {
				$term = get_term_by('id',$var,$tax_slug);
				$var = $term->slug;
			}
		}
	}
}
add_action('restrict_manage_posts', 'my_restrict_manage_posts' );
add_filter('parse_query','my_convert_restrict');



// Add to admin_init function
add_action('manage_portfolio_posts_custom_column' , 'custom_portfolio_columns', 10, 2);
add_filter('manage_edit-portfolio_columns', 'my_portfolio_columns');
//Add columns for portfolio posts
function my_portfolio_columns($columns) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Title",
		"portfolio_categories" => "Categories",
		"comments" => "<span><span class=\"vers\"><img src=\"".get_admin_url()."images/comment-grey-bubble.png\" alt=\"Comments\"></span></span>",
		"date" => "Date",
		"thumbnail" => "Thumbnail"
	);
	return $columns;
}
function custom_portfolio_columns( $column, $post_id ) {
	switch ( $column ) {
	case 'portfolio_categories':
		$terms = get_the_term_list( $post_id , 'portfolio_category' , '' , ',' , '' );
		if ( is_string( $terms ) ) {
			echo $terms;
		} else {
			echo 'Uncategorized';
		}
		break;
	}
}



/*-----------------------------------------------------------------------------------*/
/* Output image */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tz_image' ) ) {
    function tz_image($postid, $imagesize) {
        // get the featured image for the post
        if( has_post_thumbnail($postid) ) {
						$thumb = get_post_thumbnail_id();
						$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
						$image = aq_resize( $img_url, 700, 460, true ); //resize & crop img
						
						
						echo '<img src="'. $image .'" alt="'. get_the_title() .'" />';
						
        }
        
    }
}


/*-----------------------------------------------------------------------------------*/
/* Output gallery */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tz_grid_gallery' ) ) {
    function tz_grid_gallery($postid, $imagesize) { ?>
				
				<!--BEGIN .slider -->
					<div class="grid_gallery clearfix">
					
						<div class="grid_gallery_inner">
							
						<?php 
								$args = array(
										'orderby'		 => 'menu_order',
										'order' => 'ASC',
										'post_type'      => 'attachment',
										'post_parent'    => get_the_ID(),
										'post_mime_type' => 'image',
										'post_status'    => null,
										'numberposts'    => -1,
								);
								$attachments = get_posts($args);
						?>
								
								<?php if ($attachments) : ?>
								
								<?php foreach ($attachments as $attachment) : ?>
										
										<?php 
											$attachment_url = wp_get_attachment_image_src( $attachment->ID, 'full' );
											$url = $attachment_url['0'];
											$image = aq_resize($url, 260, 160, true);
										?>
										
										<div class="gallery_item">
											<figure class="featured-thumbnail single-gallery-item">
												<a href="<?php echo $attachment_url['0'] ?>" class="image-wrap" rel="prettyPhoto[gallery]">
												<img 
												alt="<?php echo apply_filters('the_title', $attachment->post_title); ?>"
												src="<?php echo $image ?>"
												width="260"
												height="160"
												/>
												<span class="zoom-icon"></span>
												</a>
											</figure>
										</div>
								
								<?php endforeach; ?>
								
								<?php endif; ?>
							
						</div>

					<!--END .slider -->
					</div>
				
				
        
    <?php }
}

/*-----------------------------------------------------------------------------------*/
/* Output gallery slideshow */
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tz_gallery' ) ) {
    function tz_gallery($postid, $imagesize) { ?>
        <?php $random = gener_random(10); ?>
				<script type="text/javascript">
					// Can also be used with $(document).ready()
					$(window).load(function() {
						$('#flexslider_<?php echo $random ?>').flexslider({
							animation: "slide",
							smoothHeight : true
						});
					});
				</script>


				<!-- Place somewhere in the <body> of your page -->
				<div id="flexslider_<?php echo $random ?>" class="flexslider thumbnail">
					<ul class="slides">
						
						<?php 
						$args = array(
							'orderby'		 => 'menu_order',
							'order' => 'ASC',
							'post_type'      => 'attachment',
							'post_parent'    => get_the_ID(),
							'post_mime_type' => 'image',
							'post_status'    => null,
							'numberposts'    => -1,
						);
						$attachments = get_posts($args); ?>
						
						<?php if ($attachments) : ?>
						
						<?php foreach ($attachments as $attachment) : ?>
						
						<?php 
							$attachment_url = wp_get_attachment_image_src( $attachment->ID, 'full' );
							$url = $attachment_url['0'];
							$image = aq_resize($url, 650, 400, true);
						?>
						
						<li><img src="<?php echo $image; ?>" alt="<?php echo apply_filters('the_title', $attachment->post_title); ?>"/></li>
						
						<?php endforeach; ?>
						<?php endif; ?>
						
					</ul>
				</div>
			
    <?php }
}

/*-----------------------------------------------------------------------------------*/
/*	Output Audio
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tz_audio' ) ) {
    function tz_audio($postid) {
	
		// get audio attribute
		$audio_title = get_post_meta($postid, 'tz_audio_title', true);
		$audio_artist = get_post_meta($postid, 'tz_audio_artist', true);		
		$audio_format = get_post_meta($postid, 'tz_audio_format', true);
		$audio_url = get_post_meta($postid, 'tz_audio_url', true);
	?>
				
		<script type="text/javascript">
			$(document).ready(function(){
				var myPlaylist_<?php the_ID(); ?> = new jPlayerPlaylist({
				  jPlayer: "#jquery_jplayer_<?php the_ID(); ?>",
				  cssSelectorAncestor: "#jp_container_<?php the_ID(); ?>"
				}, [
				  {
					title:"<?php echo $audio_title; ?>",
					artist:"<?php echo $audio_artist; ?>",
					<?php echo $audio_format; ?>: "<?php echo stripslashes(htmlspecialchars_decode($audio_url)); ?>" <?php if(has_post_thumbnail()) {?>,
					poster: "<?php echo $image; ?>" <?php } ?>
				  }
				], {
				  playlistOptions: {
					enableRemoveControls: false
				  },
				  ready: function () {
					$(this).jPlayer("setMedia", {
						<?php echo $audio_format; ?>: "<?php echo stripslashes(htmlspecialchars_decode($audio_url)); ?>"
						});
					},
				  swfPath: "<?php echo get_template_directory_uri(); ?>/flash",
				  wmode: "window",
				  supplied: "mp3, all"
				});
			});
		</script>
		
		<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer"></div>
		<div id="jp_container_<?php the_ID(); ?>" class="jp-audio">
			<div class="jp-type-single">
				<div class="jp-gui">
					<div class="jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-duration"></div>
						<div class="jp-time-sep"></div>
						<div class="jp-current-time"></div>
						<div class="jp-controls-holder">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-previous" tabindex="1" title="Previous"><span>Previous</span></a></li>
								<li><a href="javascript:;" class="jp-play" tabindex="1" title="Play"><span>Play</span></a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1" title="Pause"><span>Pause</span></a></li>
								<li><a href="javascript:;" class="jp-next" tabindex="1" title="Next"><span>Next</span></a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1" title="Stop"><span>Stop</span></a></li>
							</ul>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="Mute"><span>Mute</span></a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="Unmute"><span>Unmute</span></a></li>
							</ul>
						</div>
					</div>
					<div class="jp-no-solution">
						<span>Update Required. </span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
					</div>
				</div>
			</div>
			<div class="jp-playlist">
				<ul>
					<li></li>
				</ul>
			</div>
		</div>
    	<?php 
    }
}



/*-----------------------------------------------------------------------------------*/
/*	Output Video
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tz_video' ) ) {
    function tz_video($postid) {
	
		// get video attribute
		$video_title = get_post_meta($postid, 'tz_video_title', true);
		$video_artist = get_post_meta($postid, 'tz_video_artist', true);
		$embed = get_post_meta(get_the_ID(), 'tz_video_embed', true);
		$m4v_url = get_post_meta($postid, 'tz_m4v_url', true);
		$ogv_url = get_post_meta($postid, 'tz_ogv_url', true);

		// get thumb (poster image)
		$thumb = get_post_thumbnail_id( $postid );
		$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
		$image = aq_resize( $img_url, 770, 380, true ); //resize & crop img
	
		if ($embed != '') {
			echo stripslashes(htmlspecialchars_decode($embed));
		} else { ?>				
			<script type="text/javascript">
				$(document).ready(function(){
					var myPlaylist_<?php the_ID(); ?> = new jPlayerPlaylist({
					  jPlayer: "#jquery_jplayer_<?php the_ID(); ?>",
					  cssSelectorAncestor: "#jp_container_<?php the_ID(); ?>"
					}, [
					  {
						title:"<?php echo $video_title; ?>",
						artist:"<?php echo $video_artist; ?>",
						m4v: "<?php echo stripslashes(htmlspecialchars_decode($m4v_url)); ?>",
						ogv: "<?php echo stripslashes(htmlspecialchars_decode($ogv_url)); ?>" <?php if(has_post_thumbnail()) {?>,
						poster: "<?php echo $image; ?>" <?php } ?>
					  }
					], {
					  playlistOptions: {
						enableRemoveControls: false
					  },
					  ready: function () {
						$(this).jPlayer("setMedia", {
							m4v: "<?php echo stripslashes(htmlspecialchars_decode($m4v_url)); ?>",
							ogv: "<?php echo stripslashes(htmlspecialchars_decode($ogv_url)); ?>"
							});
						},
					  swfPath: "<?php echo get_template_directory_uri(); ?>/flash",
					  supplied: "m4v, ogv, all",
					  wmode:"window",
					  size: {
						width: "100%",
						height: "100%"
						}
					});
				});
			</script>
			
			<div id="jp_container_<?php the_ID(); ?>" class="jp-video fullwidth playlist">
				<div class="jp-type-list-parent">
					<div class="jp-type-single">
						<div id="jquery_jplayer_<?php the_ID(); ?>" class="jp-jplayer"></div>
						<div class="jp-gui">
							<div class="jp-video-play">
								<a href="javascript:;" class="jp-video-play-icon" tabindex="1" title="Play">Play</a>
							</div>
							<div class="jp-interface">
								<div class="jp-progress">
									<div class="jp-seek-bar">
										<div class="jp-play-bar"></div>
									</div>
								</div>
								<div class="jp-duration"></div>
								<div class="jp-time-sep"></div>
								<div class="jp-current-time"></div>
								<div class="jp-controls-holder">
									<ul class="jp-controls">
										<li><a href="javascript:;" class="jp-previous" tabindex="1" title="Previous"><span>Previous</span></a></li>
										<li><a href="javascript:;" class="jp-play" tabindex="1" title="Play"><span>Play</span></a></li>
										<li><a href="javascript:;" class="jp-pause" tabindex="1" title="Pause"><span>Pause</span></a></li>
										<li><a href="javascript:;" class="jp-next" tabindex="1" title="Next"><span>Next</span></a></li>
										<li><a href="javascript:;" class="jp-stop" tabindex="1" title="Stop"><span>Stop</span></a></li>
									</ul>
									<div class="jp-volume-bar">
										<div class="jp-volume-bar-value"></div>
									</div>
									<ul class="jp-toggles">
										<li><a href="javascript:;" class="jp-mute" tabindex="1" title="Mute"><span>Mute</span></a></li>
										<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="Unmute"><span>Unmute</span></a></li>
									</ul>
								</div>
							</div>
							<div class="jp-no-solution">
								<span>Update Required. </span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
							</div>	
						</div>
					</div>			
				</div>
				<div class="jp-playlist">
					<ul>
						<li></li>
					</ul>
				</div>
			</div>
    	<?php }
    }
}




/*-----------------------------------------------------------------------------------*/
/*	Pagination
/*-----------------------------------------------------------------------------------*/
function pagination($pages = '', $range = 1)
{ 
     $showitems = ($range * 2)+1; 
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }  
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination pagination__posts\"><ul>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li class='first'><a href='".get_pagenum_link(1)."'>First</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<li class='prev'><a href='".get_pagenum_link($paged - 1)."'>Prev</a></li>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class=\"active\"><a href=''>".$i."</a></li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<li class='next'><a href=\"".get_pagenum_link($paged + 1)."\">Next</a></li>"; 
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li class='last'><a href='".get_pagenum_link($pages)."'>Last</a></li>";
         echo "</ul></div>\n";
     }
}


/*-----------------------------------------------------------------------------------*/
/* Custom Comments Structure
/*-----------------------------------------------------------------------------------*/
function mytheme_comment($comment, $args, $depth) {
     $GLOBALS['comment'] = $comment;

?> 
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" class="clearfix">
     	<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
      		<div class="wrapper">
      			<div class="comment-author vcard">
  	         		<?php echo get_avatar( $comment->comment_author_email, 65 ); ?>
  	  				<?php printf(__('<span class="author">%1$s</span>' ), get_comment_author_link()) ?>
  	      		</div>
  		      	<?php if ($comment->comment_approved == '0') : ?>
  		        	<em><?php _e('Your comment is awaiting moderation.', 'cherry') ?></em>
  		      	<?php endif; ?>	      	
  		     	<div class="extra-wrap">
  		     		<?php comment_text() ?>	     	
  		     	</div>
  		    </div>
	     	<div class="wrapper">
			  	<div class="reply">
			    	<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			   	</div>
		   		<div class="comment-meta commentmetadata"><?php printf(__('%1$s', 'cherry' ), get_comment_date('F j, Y')) ?></div>
		 	</div>
    	</div>
<?php }


/*-----------------------------------------------------------------------------------*/
/*	Breadcrumbs
/*-----------------------------------------------------------------------------------*/

function breadcrumbs() {

  $showOnHome = 0; // 1 - show "breadcrumbs" on home page, 0 - hide
  $delimiter = '<li class="divider">/</li>'; // divider
  $home = 'Home'; // text for link "Home"
  $showCurrent = 1; // 1 - show title current post/page, 0 - hide
  $before = '<li class="active">'; // open tag for active breadcrumb
  $after = '</li>'; // close tag for active breadcrumb

  global $post;
  $homeLink = home_url();

  if (is_front_page()) {

    if ($showOnHome == 1) echo '<ul class="breadcrumb breadcrumb__t"><li><a href="' . $homeLink . '">' . $home . '</a><li></ul>';

  } else {

    echo '<ul class="breadcrumb breadcrumb__t"><li><a href="' . $homeLink . '">' . $home . '</a></li> ' . $delimiter . ' ';
	
	if ( is_home() ) {
		echo $before . 'Blog' . $after;
	} elseif ( is_category() ) {
      $thisCat = get_category(get_query_var('cat'), false);
      if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
      echo $before . 'Category Archives: "' . single_cat_title('', false) . '"' . $after;

    } elseif ( is_search() ) {
      echo $before . 'Search for: "' . get_search_query() . '"' . $after;

    } elseif ( is_day() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
      echo '<li><a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ' . $delimiter . ' ';
      echo $before . get_the_time('d') . $after;

    } elseif ( is_month() ) {
      echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li> ' . $delimiter . ' ';
      echo $before . get_the_time('F') . $after;

    } elseif ( is_year() ) {
      echo $before . get_the_time('Y') . $after;

    } elseif ( is_single() && !is_attachment() ) {
      if ( get_post_type() != 'post' ) {
      	$post_name = get_post_type();
        $post_type = get_post_type_object(get_post_type());
        $slug = $post_type->rewrite;
        echo '<li><a href="' . $homeLink . '/' . $post_name . '/">' . $post_type->labels->singular_name . '</a></li>';
        if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
      } else {
        $cat = get_the_category(); $cat = $cat[0];
        $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
        if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
        echo $cats;
        if ($showCurrent == 1) echo $before . get_the_title() . $after;
      }

    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
      $post_type = get_post_type_object(get_post_type());
      echo $before . $post_type->labels->singular_name . $after;

    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_page() && !$post->post_parent ) {
      if ($showCurrent == 1) echo $before . get_the_title() . $after;

    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      for ($i = 0; $i < count($breadcrumbs); $i++) {
        echo $breadcrumbs[$i];
        if ($i != count($breadcrumbs)-1) echo ' ' . $delimiter . ' ';
      }
      if ($showCurrent == 1) echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

    } elseif ( is_tag() ) {
      echo $before . 'Tag Archives: "' . single_tag_title('', false) . '"' . $after;

    } elseif ( is_author() ) {
      global $author;
      $userdata = get_userdata($author);
      echo $before . 'by ' . $userdata->display_name . $after;

    } elseif ( is_404() ) {
      echo $before . '404' . $after;
    }
	/*
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __(' Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
	*/

    echo '</ul>';

  }
} // end breadcrumbs() ?>
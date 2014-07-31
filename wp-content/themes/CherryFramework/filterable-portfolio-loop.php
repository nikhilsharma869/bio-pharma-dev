<?php // Isotope Portfolio Init ?>

<?php // Theme Options vars
$layout_mode = of_get_option('layout_mode');
$items_count2 = of_get_option('items_count2');

$items_count4 = of_get_option('items_count4');
?>

<script>
	jQuery(document).ready(function($) {
		var $container = jQuery('#portfolio-grid');
		
		$container.imagesLoaded( function(){	
			setColumnWidth();
			$container.isotope({
				itemSelector : '.portfolio_item',
				resizable : false,
				transformsEnabled : true,
				layoutMode: '<?php echo $layout_mode; ?>'
			});		
		});
		
		function getNumColumns(){
			
			var $folioWrapper = jQuery('#portfolio-grid').data('cols');
			
			if($folioWrapper == '1col') {
				var winWidth = jQuery("#portfolio-grid").width();		
				var column = 1;		
				return column;
			}
			
			if($folioWrapper == '2cols') {
				var winWidth = jQuery("#portfolio-grid").width();		
				var column = 2;		
				if (winWidth<380) column = 1;
				return column;
			}
			
			else if ($folioWrapper == '3cols') {
				var winWidth = jQuery("#portfolio-grid").width();		
				var column = 3;		
				if (winWidth<380) column = 1;
				else if(winWidth>=380 && winWidth<788)  column = 2;
				else if(winWidth>=788 && winWidth<1160)  column = 3;
				else if(winWidth>=1160) column = 3;
				return column;
			}
			
			else if ($folioWrapper == '4cols') {
				var winWidth = jQuery("#portfolio-grid").width();		
				var column = 4;		
				if (winWidth<380) column = 1;
				else if(winWidth>=380 && winWidth<788)  column = 2;
				else if(winWidth>=788 && winWidth<1160)  column = 3;
				else if(winWidth>=1160) column = 4;		
				return column;
			}
		}
		
		function setColumnWidth(){
			var columns = getNumColumns();		
		
			var containerWidth = jQuery("#portfolio-grid").width();		
			var postWidth = containerWidth/columns;
			postWidth = Math.floor(postWidth);
	 		
			jQuery(".portfolio_item").each(function(index){
				jQuery(this).css({"width":postWidth+"px"});				
			});
		}
			
		function arrange(){
			setColumnWidth();		
			$container.isotope('reLayout');	
		}
			
		jQuery(window).on("debouncedresize", function( event ) {	
			arrange();		
		});
		
		
		// Filter projects
		var $itemsFilter = $('#filters')
		
		$itemsFilter.on('click', 'a', function(e) {
			var $this = $(this).parent('li');

			$itemsFilter.find('li').removeClass('active');
			$this.addClass('active');
			
			var selector = $(this).attr('data-filter');
			$container.isotope({ filter: selector });
			
			e.preventDefault();
		});
	});
</script>

<?php 
	$i=1;
	if ( have_posts() ) while ( have_posts() ) : the_post(); 
	
	$portfolio_terms = wp_get_object_terms($post->ID, 'portfolio_category');
	$portfolio_class = "folioItem " . $portfolio_terms[0]->slug;
	$portfolio_sort = $portfolio_terms[0]->slug . '[1][0]';
	$portfolio_type = $portfolio_terms[0]->slug;

	// Theme Options vars
	$folio_filter = of_get_option('folio_filter');
	$folio_title = of_get_option('folio_title');
	$folio_btn = of_get_option('folio_btn');
	$folio_excerpt = of_get_option('folio_excerpt');
	$folio_excerpt_count = of_get_option('folio_excerpt_count');
	
	$custom = get_post_custom($post->ID);
	
	$thumb = get_post_thumbnail_id();
	$img_url = wp_get_attachment_url( $thumb,'full'); //get img URL
	$image = aq_resize( $img_url, 600, 380, true ); //resize & crop img
	
	//mediaType init
	$mediaType = get_post_meta($post->ID, 'tz_portfolio_type', true);
	?>
	
	<li class="portfolio_item <?php foreach( $portfolio_terms as $portfolio_class ) { echo $portfolio_class->slug.' ';} ?>" data-sort="<?php echo $portfolio_sort; ?>" data-type="<?php echo $portfolio_type; ?>">
		<div class="portfolio_item_holder">
		
			<?php
			//check thumb and media type
			if(has_post_thumbnail($post->ID) && $mediaType != 'Video' && $mediaType != 'Audio'){ 
			
				//Disable overlay_gallery if we have Image post
				$prettyType = 0;
				if($mediaType != 'Image') { 
					$prettyType = "prettyPhoto[gallery".$i."]";
				} else { 
					$prettyType = 'prettyPhoto';
				}
			?>
		
			<figure class="thumbnail thumbnail__portfolio">
				<a class="image-wrap" href="<?php echo $img_url;?>" rel="<?php echo $prettyType; ?>" title="<?php the_title();?>"><img src="<?php echo $image ?>" alt="<?php the_title(); ?>" /><span class="zoom-icon"></span></a>
			</figure>
			
			
			<?php
			$thumbid = 0;
			$thumbid = get_post_thumbnail_id($post->ID);
		
			$images = get_children( array(
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'post_type' => 'attachment',
				'post_parent' => $post->ID,
				'post_mime_type' => 'image',
				'post_status' => null,
				'numberposts' => -1
						) ); 
						
				/* $images is now a object that contains all images (related to post id 1) and their information ordered like the gallery interface. */
				if ( $images ) {
					//looping through the images
					foreach ( $images as $attachment_id => $attachment ) {
					 if( $attachment->ID == $thumbid ) continue;
						$image_attributes = wp_get_attachment_image_src( $attachment_id, 'full' ); // returns an array
						$alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
						$image_title = $attachment->post_title;
						?>
							
						<a href="<?php echo $image_attributes[0]; ?>" title="<?php the_title(); ?>" rel="<?php echo $prettyType; ?>" style="display:none;"><img src="<?php echo $image_attributes[0]; ?>" alt="<?php echo $alt; ?>"/></a>

					<?php
					}
				} 
			} else { ?>
				
			<figure class="thumbnail thumbnail__portfolio">
				<a class="image-wrap" href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to', 'cherry');?> <?php the_title_attribute(); ?>" ><img src="<?php echo $image ?>" alt="<?php the_title(); ?>" /></a>
			</figure>
				
			<?php } ?>		
			
			<!-- Caption -->
			<div class="caption caption__portfolio">
				
				<?php if($folio_title == "yes") { ?>
				<h3><a href="<?php the_permalink(); ?>"><?php $title = the_title('','',FALSE); echo substr($title, 0, 40); ?></a></h3>
				<?php } ?>
				
				<?php if($folio_excerpt == "yes") { ?>
				<p class="excerpt"><?php $excerpt = get_the_excerpt(); echo my_string_limit_words($excerpt,$folio_excerpt_count);?></p>
				<?php } ?>
				
				<?php if($folio_btn == "yes") { ?>
				<p><a href="<?php the_permalink() ?>" class="btn btn-primary"><?php _e('Read more', 'cherry'); ?></a></p>
				<?php } ?>
			</div>
			<!-- /Caption -->
			
		</div>
	</li>
	
	<?php $i++; endwhile; ?>
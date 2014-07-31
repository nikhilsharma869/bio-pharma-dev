<?php
/**
 * Template Name: Managemenet Consulting
 */

get_header(); ?>

<div class="management_consult_full">

	<div class="row">
		
		<div class="span12">
		
			<div class="mc_banner_cont"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mc-banner1.png" alt="image" /></div>
			<div class="mc_banner_cont"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mc-banner2.png" alt="image" /></div>
			<div class="mc_banner_cont"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mc-banner3.png" alt="image" /></div>
			<div class="mc_banner_cont"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mc-banner4.png" alt="image" /></div>
			<div class="mc_banner_cont"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mc-banner5.png" alt="image" /></div>
		
		</div>
		
	</div>
	
</div><!--//management_consult_full-->

<div class="container">
	<div id="content">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('page fullwidth-page'); ?>>
			<?php if(has_post_thumbnail()) {
				echo '<a href="'; the_permalink(); echo '">';
			  	echo '<figure class="featured-thumbnail"><span class="img-wrap">'; the_post_thumbnail(); echo '</span></figure>';
			  	echo '</a>';
			}
			//the_content(); ?>
				
				<div class="spacer"></div>
				
				<div class="row">
				
					<div class="span3 home_post_box">
						<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image1-big.png" rel="prettyPhoto" title=" "><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image1.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5>Audio post format</h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>
					
					<div class="span3 home_post_box">
						<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image2-big.png" rel="prettyPhoto" title=" "><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image2.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5>Audio post format</h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>

					<div class="span3 home_post_box">
						<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image3-big.png" rel="prettyPhoto" title=" "><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image3.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5>Audio post format</h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>
					
					<div class="span3 home_post_box">
						<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image4-big.png" rel="prettyPhoto" title=" "><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image4.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5>Audio post format</h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>					
				
				</div><!--//row-->
				
				<div class="spacer"></div>
			
			<div class="pagination">
				<?php wp_link_pages('before=<div class="pagination">&after=</div>'); ?>
			</div><!--.pagination-->
		</div><!--#post-->
	  	<?php endwhile; ?>
	</div><!--#content-->
</div><!--.container-->   
<?php get_footer(); ?>
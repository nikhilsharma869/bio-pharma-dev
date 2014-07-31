<?php get_header(); ?>
	<?php get_template_part('title'); ?>
	<div class="container">
		<div class="row">
			<div class="span12">
						
			  <!--BEGIN #primary .hfeed-->
				<div id="primary" class="hfeed">
					
					<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
							
						<!--BEGIN .hentry -->
						<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">				
						<div class="row">		
							<div class="span7">
								
								<?php // get the media elements
									$mediaType = get_post_meta($post->ID, 'tz_portfolio_type', true);
									
									switch( $mediaType ) {
										case "Image":
											tz_image($post->ID, 'portfolio-main');
											break;

										case "Slideshow":
											tz_gallery($post->ID, 'portfolio-main');
											break;
											
										case "Grid Gallery":
											tz_grid_gallery($post->ID, 'portfolio-main');
											break;

										case "Video":
											tz_video($post->ID);
											break;

										case "Audio":
											tz_audio($post->ID);
											break;

										default:
											break;
									}
								?>
								
								
								<!--BEGIN .pager .single-pager -->
								<ul class="pager single-pager">
									
									<?php if( get_previous_post() ) : ?>
									<li class="previous"><?php previous_post_link('%link', __('&laquo; Previous post', 'cherry')) ?></li>
									<?php endif; ?>
									
									<?php if( get_next_post() ) : ?>
									<li class="next"><?php next_post_link('%link', __('Next Post &raquo;', 'cherry')) ?></li>
									<?php endif; ?>

								<!--END .pager .single-pager -->
								</ul>
								
								
							</div>
							
							

							<!-- BEGIN .entry-content -->
							<div class="entry-content span5">
											
								<!-- BEGIN .entry-meta -->
								<div class="entry-meta">

									<?php 
										// get the meta information and display if supplied
										$portfolioClient = get_post_meta($post->ID, 'tz_portfolio_client', true);
										$portfolioDate = get_post_meta($post->ID, 'tz_portfolio_date', true); 
										$portfolioInfo = get_post_meta($post->ID, 'tz_portfolio_info', true); 
										$portfolioURL = get_post_meta($post->ID, 'tz_portfolio_url', true);
										
										
										if (!empty($portfolioClient) || !empty($portfolioDate) || !empty($portfolioInfo) || !empty($portfolioURL)){
											echo '<ul class="portfolio-meta-list">';
											}
											
										if( !empty($portfolioClient) ) {
												echo '<li>';
												echo '<strong class="portfolio-meta-key">' . __('Client:', 'framework') . '</strong>';
												echo '<span>' . $portfolioClient . '</span><br />';
												echo '</li>';
											}

										if( !empty($portfolioDate) ) {
												echo '<li>';
												echo '<strong class="portfolio-meta-key">' . __('Date:', 'framework') . '</strong>';
												echo '<span>' . $portfolioDate . '</span><br />';
												echo '</li>';
										}
										
										if( !empty($portfolioInfo) ) {
												echo '<li>';
												echo '<strong class="portfolio-meta-key">' . __('Info:', 'framework') . '</strong>';
												echo '<span>' . $portfolioInfo . '</span><br />';
												echo '</li>';
										}

										if( !empty($portfolioURL) ) {
												echo '<li>';
												echo "<a href='$portfolioURL'>" . __('Launch Project', 'framework') . "</a>";
												echo '</li>';
										}
										
										if (!empty($portfolioClient) || !empty($portfolioDate) || !empty($portfolioInfo) || !empty($portfolioURL)){
											echo '</ul>';
										}
									?>

								<!-- END .entry-meta -->
								</div>
									
								<?php the_content(); ?>
								
								<?php get_template_part( 'includes/post-formats/share-buttons' ); ?>

							<!-- END .entry-content -->
							</div>                
							<!--END .hentry-->  
								
							</div><!-- .row -->	
							</div>

							<?php endwhile; endif; ?>
							

				<!--END #primary .hfeed-->
				</div>
			</div>
		</div><!-- .row -->
	</div><!--.container-->  
<?php get_footer(); ?>
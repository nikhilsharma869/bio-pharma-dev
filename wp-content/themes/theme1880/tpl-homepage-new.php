<?php
/**
 * Template Name: Home Page New
 */

get_header(); ?>
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
			
				<div class="row" style="DISPLAY: NONE;">
					
					<div class="span6">
					
						<div class="home_half_box home_half_box_left">
							<div class="home_half_box_title">
								<span class="home_half_box_title_num">1</span> About Us
							</div><!--//home_half_box_title-->
							<div class="left">
								<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/home-about-us-image-big.png" rel="prettyPhoto" title="About Us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-about-us-image.png" alt="image" /></a>
							</div>
							<div class="right">
								<p>In an environment of competing interests, demanding timescales and ever-tighter budgets, projects of all size, type and complexity require a dedicated team to ensure success.  Our management consultants can take full responsibility for overall project delivery from design space through commercial production.  Our strength lies in the ability of our consultants to take an integrated team based approach throughout the project life cycle.  They understand and excel in taking the risk based approach particularly with regards to the use of technological advances in pharmaceutical manufacturing, as well as in the implementation of modern risk management and quality system tools that build quality, safety, and efficacy right into the products at all stages of the product lifecycle.</p>
							</div>
							<div class="clear"></div>
						</div><!--//home_half_box-->
					
					</div>
					
					<div class="span6">
					
						<div class="home_half_box">
							<div class="home_half_box_title">
								<span class="home_half_box_title_num">2</span> Core Competencies
							</div><!--//home_half_box_title-->
							<div class="left">
								<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/core-image-big.png" rel="prettyPhoto" title="Core Competencies"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/core-image.png" alt="image" /></a>
							</div>
							<div class="right">
								<p>Our services can be tailored to suit the needs of the project and client. Our primary focus is on the following areas:</p>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/core-text-table.png" alt="image" />
							</div>
							<div class="clear"></div>
						</div><!--//home_half_box-->					
						
					</div>
					
				</div><!-- DISPLAY NONE -->
				
				<div class="row">
				
					<div class="span12">
					
						<div class="home_full_box home_full_box_about">
							<!--<div class="home_half_box_title">
								<span class="home_half_box_title_num">1</span> About Us
							</div>--><!--//home_half_box_title-->						
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/about-us-image.png" alt="image" class="about_us_img" />
						
							<div class="left">
								<!--<p><span class="white_bg">We add value by utilizing a powerful mix of industry experience, innovation, research and a rigorous, risk-based approach from design space through commercial production.  Our management consultants can easily manage complex multiproject programs, providing essential oversight, assurance, management, information and control processes.  Our value proposition rests on an unrivalled package of Project Management, Management Consulting, Commissioning, Validation, Compliance and Regulatory Submissions services, uniquely linked with independent judgment and deep industrial/commercial insight. We work closely with management and other advisors, such as Industry Subject Metter Experts, to leverage and complement their knowledge and ensure maximum impact.  Our reward is not "transaction-based", so we can maintain genuine objectivity in our client's long-term interest. In carrying out an engagement for a client, we participate fully in the client's corporate thinking, and take into account not just the immediate value and impact of the project, but its context and implications over a longer period of time. </span></p>

								<p><span class="white_bg">In summary, our mission is simple.  We want to develop and deliver effective, competitive and practical business solutions - for small, medium, and large organizations specializing in Biotechnology, Medical Device and Pharmaceutical Industries - that  allow these organizations to optimize their operational efficiency and maximize Return on Investment in time and under budget.</span></p>-->
								
								<p><span class="white_bg">In an environment of competing interests, demanding timescales and ever-tighter budgets, projects of all size, type and complexity require a dedicated team to ensure success. Our management consultants can take full responsibility for overall project delivery from design space through commercial production. Our strength lies in the ability of our consultants to take an integrated team based approach throughout the project life cycle. They understand and excel in taking the risk based approach particularly with regards to the use of technological advances in pharmaceutical manufacturing, as well as in the implementation of modern risk management and quality system tools that build quality, safety, and efficacy right into the products at all stages of the product lifecycle.</span></p>							
							</div>
							
							<div class="right">
								<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/home-about-us-image-big.png" rel="prettyPhoto" title="About Us"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/home-about-us-image.png" alt="image" /></a>
							</div>
							<div class="clear"></div>
						
						</div><!--//home_full_box-->					
					
					</div>
				
				</div>
				
				<div class="spacer"></div>
				
				<div class="row">
				
					<div class="span12">
					
						<div class="home_full_box home_full_box_core">
							<!--<div class="home_half_box_title">
								<span class="home_half_box_title_num">2</span> Core Competencies
							</div>--><!--//home_half_box_title-->						
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/core-comp-header.png" alt="Core Competencies" class="core_comp_img" />
						
							<div class="left">
								<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/core-image-big.png" rel="prettyPhoto" title="Core Competencies"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/core-image.png" alt="image" /></a>
							</div>
							
							<div class="right">
								<p><span class="white_bg">Our services can be tailored to suit the needs of the project and client. Our primary focus is on the following areas:</span></p>
								<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/core-text-table.png" alt="image" />
							</div>
							<div class="clear"></div>
						
						</div><!--//home_full_box-->					
					
					</div>
				
				</div>				
				
				<div class="spacer"></div>
				
				<div class="row">
				
					<div class="span12">
				
						<div class="home_full_box home_full_box_value">
<!--							<div class="home_half_box_title">
								<span class="home_half_box_title_num">3</span> Value Proposition
							</div>--><!--//home_half_box_title-->						
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-prop-header-image.png" alt="image" class="value_prop_img" />
							
							<div align="center" class="home_full_box_value_img_cont">
								<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/value-prop-image-big.png" rel="prettyPhoto" title="Value Proposition"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-prop-image.png" alt="image" /></a>
							</div>
						
							<div class="home_full_box_value_cont">
								<div class="left">
									<p>We add value by utilizing a powerful mix of industry experience, innovation, research and a rigorous, risk-based approach from design space through commercial production.  Our management consultants can easily manage complex multiproject programs, providing essential oversight, assurance, management, information and control processes.  Our value proposition rests on an unrivalled package of Project Management, Management Consulting, Commissioning, Validation, Compliance and Regulatory Submissions services, uniquely linked with independent judgment and deep industrial/commercial insight. We work closely with management and other advisors, such as Industry Subject Metter Experts, to leverage and complement their knowledge and ensure maximum impact.  Our reward is not "transaction-based", so we </p>
								</div>
								
								<div class="right">
									<p>maintain genuine objectivity in our client's long-term interest. In carrying out an engagement for a client, we participate fully in the client's corporate thinking, and take into account not just the immediate value and impact of the project, but its context and implications over a longer period of time. </p>

									<p>In summary, our mission is simple.  We want to develop and deliver effective, competitive and practical business solutions - for small, medium, and large organizations specializing in Biotechnology, Medical Device and Pharmaceutical Industries - that  allow these organizations to optimize their operational efficiency and maximize Return on Investment in time and under budget.</p>
								</div>
								<div class="clear"></div>
							</div><!--//home_full_box_value_cont-->
						
						</div><!--//home_full_box-->
						
					</div>
				
				</div><!--//row-->
				
				<div class="spacer"></div>
				
				<div class="row">
				
					<div class="span3 home_post_box">
						<!--<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image1-big.png" rel="prettyPhoto" title=" ">--><a href="http://bio-pharma.com/uncategorized/sample-post-1/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image1.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5><a href="http://bio-pharma.com/uncategorized/sample-post-1/">Audio post format</a></h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>
					
					<div class="span3 home_post_box">
						<!--<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image2-big.png" rel="prettyPhoto" title=" ">--><a href="http://bio-pharma.com/uncategorized/sample-post-2/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image2.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5><a href="http://bio-pharma.com/uncategorized/sample-post-2/">Audio post format</a></h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>

					<div class="span3 home_post_box">
						<!--<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image3-big.png" rel="prettyPhoto" title=" ">--><a href="http://bio-pharma.com/uncategorized/sample-post-3/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image3.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5><a href="http://bio-pharma.com/uncategorized/sample-post-3/">Audio post format</a></h5>
						
						<p>Suspendisse id mi eget diam condimentum aliquet. Ut ante nunc, eleifend sed...</p>
						
						<div class="clear"></div>
					</div>
					
					<div class="span3 home_post_box">
						<!--<a href="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image4-big.png" rel="prettyPhoto" title=" ">--><a href="http://bio-pharma.com/uncategorized/sample-post-4/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/post-image4.jpg" class="home_post_img" alt="image" /></a>
						
						<div class="post_details_left">
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gray-box.jpg" alt="image" />
							
							<div>May<br />
							22</div>
						</div><!--//post_details_left-->
						
						<h5><a href="http://bio-pharma.com/uncategorized/sample-post-4/">Audio post format</a></h5>
						
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
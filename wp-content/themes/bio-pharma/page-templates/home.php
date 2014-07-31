<?php
/**
Template Name: Home Page 
*/

get_header(); ?>

<div id="main-content" class="main-content">
	<div class="borderBg"></div>
	<div class="banner">
    <?php 
	if ( get_post_meta(get_the_ID(),'slider_shortcode',true) <> ''){
		    echo do_shortcode( get_post_meta(get_the_ID(),'slider_shortcode',true) ); 
	}
	//echo do_shortcode("[metaslider id=28]"); 
	?>
    	<!--<img src="<?php //echo get_template_directory_uri();?>/images/home-banner.jpg" width="100%;">-->
    </div>
    
    <div class="logoStrip">
    	<div id="logoStripPanel">
            <div class="responsiveView">
            <div id="logoLeftPanel">
	    		<div id="loved_by"><img src="<?php echo get_template_directory_uri();?>/images/loved_by.png"></div>
                <div id="logos">
                    <ul>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/logos/saic.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/logos/nih.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/logos/medimmune.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/logos/bd.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/logos/pda.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/logos/ispe.png"></a></li>
                    </ul>
                </div>
            </div>
            </div>    

            <div class="responsiveView">
            <div id="logoRightPanel">
                <div id="be_our_buddy"><img src="<?php echo get_template_directory_uri();?>/images/be-our-buddy.png"></div>
                <div id="social">
                    <ul>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/rss.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/twitter.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/fb.png"></a></li>
                        <li><a href="#"><img src="<?php echo get_template_directory_uri();?>/images/windows.png"></a></li>
                    </ul>
                </div>
            </div>
			</div>            
    	</div>
    </div>

	<div class="centerPanel">
        <div id="primary">
            <fieldset>
                <legend><span>1</span>About Us:</legend>
                <p>In an environment of competing interests, demanding timescales and ever-tighter budgets, projects of all size, type and complexity require a dedicated team to ensure success.  Our management consultants can take full responsibility for overall project delivery from design space through commercial production.  Our strength lies in the ability of our consultants to take an integrated team based approach throughout the project life cycle.  They understand and excel in taking the risk based approach particularly with regards to the use of technological advances in pharmaceutical manufacturing, as well as in the implementation of modern risk management and quality system tools that build quality, safety, and efficacy right into the products at all stages of the product lifecycle.</p>
            </fieldset>
            
            <fieldset>
                <legend><span>2</span>Core Competencies:</legend>
                <div id="CoreCompetenciesLeft">
                	<img src="<?php echo get_template_directory_uri();?>/images/Core-Competencies1.jpg" style="float:left;" width="100%">
                </div>
                <div id="CoreCompetenciesRight">
                	<p>Our services can be tailored to suit the needs of the project and client. Our  primary focus is on the following areas:</p>
                	<img src="<?php echo get_template_directory_uri();?>/images/Core-Competencies2.jpg" width="100%">
                </div>
                
            </fieldset>
            
            <fieldset>
                <legend><span>3</span>Value Proposition:</legend>
                <img src="<?php echo get_template_directory_uri();?>/images/Value-Proposition.jpg" width="100%">
                <p>We add value by utilizing a powerful mix of industry experience, innovation, research and a rigorous, risk-based approach from design space through commercial production.  Our management consultants can easily manage complex multiproject programs, providing essential oversight, assurance, management, information and control processes.  Our value proposition rests on an unrivalled package of Project Management, Management Consulting, Commissioning, Validation, Compliance and Regulatory Submissions services, uniquely linked with independent judgment and deep industrial/commercial insight.</p>
                <br />
                <p>We work closely with management and other advisors, such as Industry Subject Metter Experts, to leverage and complement their knowledge and ensure maximum impact.  Our reward is not "transaction-based", so we can maintain genuine objectivity in our client's long-term interest. In carrying out an engagement for a client, we participate fully in the client's corporate thinking, and take into account not just the immediate value and impact of the project, but its context and implications over a longer period of time. In summary, our mission is simple.  We want to develop and deliver effective, competitive and practical business solutions – for small, medium, and large organizations specializing in Biotechnology, Medical Device and Pharmaceutical Industries – that  allow these organizations to optimize their operational efficiency and maximize Return on Investment in time and under budget.
                genuine objectivity in our client's long-term interest. In carrying out an engagement for a client, we participate fully in the client's corporate thinking, and take into account not just the immediate value and impact of the project, but its context and implications over a longer period of time.</p>
                <br />
                <p>In summary, our mission is simple.  We want to develop and deliver effective, competitive and practical business solutions – for small, medium, and large organizations specializing in Biotechnology, Medical Device and Pharmaceutical Industries – that  allow these organizations to optimize their operational efficiency and maximize Return on Investment in time and under budget.</p>
            </fieldset>
        </div>
    
    	<?php get_sidebar();;?>
	</div><!--CenterPanel-->

</div><!-- #main-content -->

<?php
//
get_footer();

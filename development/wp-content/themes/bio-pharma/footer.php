<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?>

		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div id="footerHouse"><img src="<?php echo get_template_directory_uri();?>/images/footer-house.jpg"></div>
			<div id="footer_main">
            <div class="footer_main">
            	<div id="footer_block">
                	<a href="#"><img src="<?php echo get_template_directory_uri();?>/images/contactus.jpg"></a>
                    <div class="siteInfo">
                    	<img src="<?php echo get_template_directory_uri();?>/images/icon-home.jpg">
                        10480 Little Patuxent, Parkway<br />
                        Columbia, MD 21044
                    </div>
                    <div class="siteInfo">
                    	<img src="<?php echo get_template_directory_uri();?>/images/icon-phone.jpg">
                        410 980 2823
                    </div>
                    <div class="siteInfo">
                    	<img src="<?php echo get_template_directory_uri();?>/images/icon-mail.jpg">
                        <a href="mailto:support@bio-pharma.com">support@bio-pharma.com</a>
                    </div>
                </div>
                
                <div id="footer_block" class="subscribe_to_us">
                	<a href="#"><img src="<?php echo get_template_directory_uri();?>/images/subscribe.jpg"></a>
                    <div class="siteInfo">
                    	Receive the most recent industry updates and<br />
						benchmarks by simply subscribing with us!
                    </div>
                    <div class="siteInfo">
                    	<input type="text" placeholder="Email" />&nbsp;<a href="javascript:alert('Try later');">Subscribe Now!</a>
                    </div>
                </div>
                
                <div class="copyright">
                	Bio-Pharma &copy; <?php echo date('Y');?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;Privacy Policy
                    
                    <ul>
                    	<li><a href="javascript:alert('Coming Soon!');">Talent Sourcing</a></li>
                    	<li><a href="javascript:alert('Coming Soon!');">Management Consulting</a></li>
                    	<li><a href="javascript:alert('Coming Soon!');">Talent Sourcing</a></li>
                    	<li><a href="javascript:alert('Coming Soon!');">Ask an Expert</a></li>
                    	<li><a href="javascript:alert('Coming Soon!');">Industrial Training</a></li>
                    	<li><a href="javascript:alert('Coming Soon!');">Jobs</a></li>
                    	<li><a href="javascript:alert('Coming Soon!');">Resumes</a></li>
					</ul>
                </div>
            </div><!--Footer main-->
            </div><!--Footer main-->
            
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
    <div id="scroll"><a href="#">
    <img src="<?php echo get_template_directory_uri();?>/images/scroll.jpg"></a></div>
</body>
</html>
<script type="text/javascript">
 var height = jQuery('#footer_main').height() ;
 var window_width = jQuery(window).width() + 17;
//alert(jQuery(window).width());

 if(window_width>850 && window_width<960){
 	height = height+1;
	jQuery('#footerHouse img').height(height+"px");
 }
 else if(window_width>960 && window_width<1250){
 	height = height+1;
	jQuery('#footerHouse img').height(height+"px");
 }
 else if(window_width>1249){
	jQuery('#footerHouse img').height(height+"px");
 }
 else if(window_width>1650){
 	height = height+3;
	jQuery('#footerHouse img').height(height+"px");
 }
</script>
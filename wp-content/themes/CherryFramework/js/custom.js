jQuery(document).ready(function(){

// prettyphoto init
jQuery("a[rel^='prettyPhoto']").prettyPhoto({
	animation_speed:'normal',
	slideshow:5000,
	autoplay_slideshow: false,
	overlay_gallery: true
});



// ---------------------------------------------------------
// Tooltip
// ---------------------------------------------------------
jQuery("[rel='tooltip']").tooltip();
	




	// ---------------------------------------------------------
	// Back to Top
	// ---------------------------------------------------------

	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 100) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').stop(false, false).animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});


// ---------------------------------------------------------
// Isotope Init
// ---------------------------------------------------------
jQuery(window).load(function(){
	jQuery("#portfolio-grid").css({"visibility" : "visible"});
})


// ---------------------------------------------------------
// Add accordion active class
// ---------------------------------------------------------
jQuery(function() {
    jQuery('.accordion').on('show', function (e) {
         jQuery(e.target).prev('.accordion-heading').find('.accordion-toggle').addClass('active');
    });
    jQuery('.accordion').on('hide', function (e) {
        jQuery(this).find('.accordion-toggle').not(jQuery(e.target)).removeClass('active');
    });
});
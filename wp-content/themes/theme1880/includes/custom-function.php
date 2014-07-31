<?php
	// WP Pointers
	add_action('admin_enqueue_scripts', 'myHelpPointers');
	function myHelpPointers() {
	//First we define our pointers 
	$pointers = array(
	   	array(
	       'id' => 'xyz1',   // unique id for this pointer
	       'screen' => 'options-permalink', // this is the page hook we want our pointer to show on
	       'target' => '#submit', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => 'Submit Permalink Structure',
	       'content' => 'This way of links configuration can be used by not only our blog followers but will help in SEO-optimisation as well. The effectiveness and main features of this link configuration method are revealed <a href="http://codex.wordpress.org/Using_Permalinks">here</a>',
	       'position' => array( 
	                          'edge' => 'top', //top, bottom, left, right
	                          'align' => 'left', //top, bottom, left, right, middle
	                          'offset' => '0 10'
	                          )
	       ),

	    array(
	       'id' => 'xyz2',   // unique id for this pointer
	       'screen' => 'themes', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => 'Import Sample Data',
	       'content' => 'If you want to install sample data from livedemo you need to go to <strong>Cherry Options</strong> > <strong>Import</strong> and follow the tips.',
	       'position' => array( 
	                          'edge' => 'bottom', //top, bottom, left, right
	                          'align' => 'right' //top, bottom, left, right, middle
	                          )
	       ),

	    array(
	       'id' => 'xyz3',   // unique id for this pointer
	       'screen' => 'toplevel_page_options-framework', // this is the page hook we want our pointer to show on
	       'target' => '#toplevel_page_options-framework', // the css selector for the pointer to be tied to, best to use ID's
	       'title' => 'Import Sample Data',
	       'content' => 'If you want to install sample data from livedemo you need to go to <strong>Import</strong> and follow the tips.',
	       'position' => array( 
	                          'edge' => 'left', //top, bottom, left, right
	                          'align' => 'right', //top, bottom, left, right, middle
	                          'offset' => '0 35'
	                          )
	       )
	    // more as needed
	    );
	//Now we instantiate the class and pass our pointer array to the constructor 
	$myPointers = new WP_Help_Pointer($pointers); 
} 

function royal_slider()
{
?>
<link href="<?php echo bloginfo('template_url') ?>/royal slider/royalslider.css" rel="stylesheet">
<script src="<?php echo bloginfo('template_url') ?>/royal slider/jquery.royalslider.min.js?v=9.3.5"></script>
<link href="<?php echo bloginfo('template_url') ?>/royal slider/rs-minimal-white.css?v=1.0.4" rel="stylesheet">
<style>
#full-width-slider {
width: 100%;
color: #000;
}
.coloredBlock {
padding: 12px;
background: rgba(255,0,0,0.6);
color: #FFF;
width: 200px;
left: 20%;
top: 5%;
}
.infoBlock {
position: absolute;
top: 30px;
right: 30px;
left: auto;
max-width: 25%;
padding-bottom: 0;
background: #FFF;
background: rgba(255, 255, 255, 0.8);
overflow: hidden;
padding: 20px;
}
.infoBlockLeftBlack {
color: #FFF;
background: #000;
background: rgba(0,0,0,0.75);
left: 30px;
right: auto;
}
.infoBlock h4 {
font-size: 20px;
line-height: 1.2;
margin: 0;
padding-bottom: 3px;
}
.infoBlock p {
font-size: 14px;
margin: 4px 0 0;
}
.infoBlock a {
color: #FFF;
text-decoration: underline;
}
.photosBy {
position: absolute;
line-height: 24px;
font-size: 12px;
background: #FFF;
color: #000;
padding: 0px 10px;
position: absolute;
left: 12px;
bottom: 12px;
top: auto;
border-radius: 2px;
z-index: 25; 
} 
.photosBy a {
color: #000;
}
.fullWidth {
max-width: 1400px;
margin: 0 auto 24px;
}

@media screen and (min-width:960px) and (min-height:660px) {
.heroSlider .rsOverflow,
.royalSlider.heroSlider {
height: 520px !important;
}
}

@media screen and (min-width:960px) and (min-height:1000px) {
.heroSlider .rsOverflow,
.royalSlider.heroSlider {
height: 660px !important;
}
}
@media screen and (min-width: 0px) and (max-width: 800px) {
.royalSlider.heroSlider,
.royalSlider.heroSlider .rsOverflow {
height: 300px !important;
}
.infoBlock {
padding: 10px;
height: auto;
max-height: 100%;
min-width: 40%;
left: 5px;
top: 5px;
right: auto;
font-size: 12px;
}
.infoBlock h3 {
font-size: 14px;
line-height: 17px;
}
}

</style>	
<div class="sliderContainer clearfix">
<div id="full-width-slider" class="royalSlider heroSlider rsMinW">
<!--<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/cleaning-program-development.png" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/clean-room-classification.png" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/illustration-4a.png" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/upstream-downstream-utility-system.png" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/water-system.png" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/illlustration-6_sec.png" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php //echo bloginfo('template_url') ?>/royal slider/iillustration-5_sec.png" alt="" /></div>-->
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-01_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-02_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-03_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-04_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-05_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-06_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-07_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-08_high.jpg" alt="" /></div>
<div class="rsContent"><img class="rsImg" src="<?php echo bloginfo('template_url') ?>/banner/banner-09_high.jpg" alt="" /></div>
</div>
</div>
<script>
jQuery(document).ready(function($) {
$('#full-width-slider').royalSlider({
arrowsNav: true,
loop: true,
keyboardNavEnabled: true,
controlsInside: false,
imageScaleMode: 'fill',
arrowsNavAutoHide: false,
autoScaleSliderWidth: 960,     
autoScaleSliderHeight: 350,
controlNavigation: 'bullets',
thumbsFitInViewport: true,
navigateByClick: true,
startSlideId: 0,
autoScaleSlider: true,
autoPlay: {
enabled: true,
pauseOnHover: true
},
transitionType:'move',
transitionSpeed:600,
globalCaption: true,
deeplinking: {
enabled: true,
change: false
}
});
});

</script>
	
	<?php
}
add_shortcode( 'royal_slider', 'royal_slider' );



function responsiveslider()
{
?>
<link rel="stylesheet" href="<?php echo bloginfo('template_url') ?>/responsive_slider/responsiveslides.css">
<script src="<?php echo bloginfo('template_url') ?>/responsive_slider/responsiveslides.min.js"></script>
<link rel="stylesheet" href="<?php echo bloginfo('template_url') ?>/responsive_slider/themes.css">
<script>
$(function () {
$(".rslides").responsiveSlides({
  auto: true,             // Boolean: Animate automatically, true or false
  speed: 500,            // Integer: Speed of the transition, in milliseconds
  timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
  pager: true,           // Boolean: Show pager, true or false
  nav: true,             // Boolean: Show navigation, true or false
  random: false,          // Boolean: Randomize the order of the slides, true or false
  pause: false,           // Boolean: Pause on hover, true or false
  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
  prevText: "Previous",   // String: Text for the "previous" button
  nextText: "Next",       // String: Text for the "next" button
  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
  manualControls: "",     // Selector: Declare custom pager navigation
  namespace: "centered-btns",   // String: Change the default namespace used
  before: function(){},   // Function: Before callback
  after: function(){}     // Function: After callback
});

});
</script>
<style>
body{
	margin:0px;
	padding:0px;
}
</style>
<ul class="rslides">
<li><img src="<?php echo bloginfo('template_url') ?>/responsive_slider/clean-room-classification.png" alt=""></li>
<li><img src="<?php echo bloginfo('template_url') ?>/responsive_slider/illlustration-6_sec.png" alt=""></li>
<li><img src="<?php echo bloginfo('template_url') ?>/responsive_slider/illustration-4a.png" alt=""></li>
<li><img src="<?php echo bloginfo('template_url') ?>/responsive_slider/upstream-downstream-utility-system.png" alt=""></li>
<li><img src="<?php echo bloginfo('template_url') ?>/responsive_slider/water-system.png" alt=""></li>
</ul>	
<?php
}
add_shortcode( 'responsiveslider', 'responsiveslider' );


?>
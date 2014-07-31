<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

if(!function_exists('optionsframework_option_name')) {
	function optionsframework_option_name() {
		// This gets the theme name from the stylesheet (lowercase and without spaces)
		$themename = 'cherry';
		
		$optionsframework_settings = get_option('optionsframework');
		$optionsframework_settings['id'] = $themename;
		update_option('optionsframework', $optionsframework_settings);		
	}
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

 
if(!function_exists('optionsframework_options')) {

	function optionsframework_options() {
	
		// Logo type
		$logo_type = array(
			"image_logo" => __("Image Logo", 'options_framework_theme'),
			"text_logo" => __("Text Logo", 'options_framework_theme')
		);
		
		// Search box in the header
		$g_search_box = array(
			"no" => "No",
			"yes" => "Yes"
		);

		// Breadcrumbs in the page
		$g_breadcrumbs = array(
			"no" => "No",
			"yes" => "Yes"
		);		
		
		// Background Defaults
		$background_defaults = array(
			'color' => '', 
			'image' => '', 
			'repeat' => 'repeat',
			'position' => 'top center',
			'attachment'=>'scroll'
		);
		
		// Superfish fade-in animation
		$sf_f_animation_array = array(
			"show" => "Enable fade-in animation",
			"false" => "Disable fade-in animation"
		);
		
		// Superfish slide-down animation
		$sf_sl_animation_array = array(
			"show" => "Enable slide-down animation",
			"false" => "Disable slide-down animation"
		);
		
		// Superfish animation speed
		$sf_speed_array = array(
			"slow" => "Slow","normal" => "Normal",
			"fast" => "Fast"
		);
		
		// Superfish arrows markup
		$sf_arrows_array = array(
			"true" => "Yes",
			"false" => "No"
		);		
		
		// Fonts
		$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
		asort($typography_mixed_fonts);
		
		
		// Slider effects
		$sl_effect_array = array("random" => "random", "simpleFade" => "simpleFade", "curtainTopLeft" => "curtainTopLeft", "curtainTopRight" => "curtainTopRight", "curtainBottomLeft" => "curtainBottomLeft", "curtainBottomRight" => "curtainBottomRight", "curtainSliceLeft" => "curtainSliceLeft", "curtainSliceRight" => "curtainSliceRight", "blindCurtainTopLeft" => "blindCurtainTopLeft", "blindCurtainTopRight" => "blindCurtainTopRight", "blindCurtainBottomLeft" => "blindCurtainBottomLeft", "blindCurtainBottomRight" => "blindCurtainBottomRight", "blindCurtainSliceBottom" => "blindCurtainSliceBottom", "blindCurtainSliceTop" => "blindCurtainSliceTop", "stampede" => "stampede", "mosaic" => "mosaic", "mosaicReverse" => "mosaicReverse", "mosaicRandom" => "mosaicRandom", "mosaicSpiral" => "mosaicSpiral", "mosaicSpiralReverse" => "mosaicSpiralReverse", "topLeftBottomRight" => "topLeftBottomRight", "bottomRightTopLeft" => "bottomRightTopLeft", "bottomLeftTopRight" => "bottomLeftTopRight", "bottomLeftTopRight" => "bottomLeftTopRight");
	 
		// Banner effects
		$sl_banner_array = array("moveFromLeft" => "moveFromLeft", "moveFromRight" => "moveFromRight", "moveFromTop" => "moveFromTop", "moveFromBottom" => "moveFromBottom", "fadeIn" => "fadeIn", "fadeFromLeft" => "fadeFromLeft", "fadeFromRight" => "fadeFromRight", "fadeFromTop" => "fadeFromTop", "fadeFromBottom" => "fadeFromBottom");
	 
		// Slider columns
		$sl_columns_array = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20");
	 
		// Slider rows
		$sl_rows_array = array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20");
	 
		// Slideshow
		$sl_slideshow_array = array("true" => "Yes","false" => "No");
	 
		// Thumbnails
		$sl_thumbnails_array = array("true" => "Yes","false" => "No");
	 
		// Slider control navigation
		$sl_control_nav_array = array("true" => "Yes","false" => "No");
	 
		// Slider direct navigation
		$sl_dir_nav_array = array("true" => "Yes","false" => "No");
	 
		// Slider direct navigation on hover
		$sl_dir_nav_hide_array = array("true" => "Yes","false" => "No");
	 
		// Slider play/pause button
		$sl_play_pause_button_array = array("true" => "Yes","false" => "No");

		// Slider loader
		$sl_loader_array = array("no" => "no", "pie" => "pie", "bar" => "bar");
		
		// Footer menu
		$footer_menu_array = array("true" => "Yes","false" => "No");
		
		// Featured image size on the blog.
		$post_image_size_array = array("normal" => "Normal size","large" => "Large size");
		
		// Featured image size on the single page.
		$single_image_size_array = array("normal" => "Normal size","large" => "Large size");
		
		// Meta for blog
		$post_meta_array = array("true" => "Yes","false" => "No");
		
		// Meta for blog
		$post_excerpt_array = array(
			"true" => "Yes",
			"false" => "No"
		);	
		
		
		// Pull all the categories into an array
		$options_categories = array();  
		$options_categories_obj = get_categories();
		foreach ($options_categories_obj as $category) {
				$options_categories[$category->cat_ID] = $category->cat_name;
		}
		
		// Pull all the pages into an array
		$options_pages = array();  
		$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
		$options_pages[''] = 'Select a page:';
		foreach ($options_pages_obj as $page) {
				$options_pages[$page->ID] = $page->post_title;
		}
			
		// If using image radio buttons, define a directory path
		$imagepath =  get_template_directory_uri() . '/includes/images/';
			
		$options = array();
		
		$options[] = array( "name" => "General",
							"type" => "heading");
		
		$options['body_background'] = array( 
							"name" =>  "Body styling",
							"desc" => "Change the background style.",
							"id" => "body_background",
							"std" => $background_defaults, 
							"type" => "background");
		
		$options['header_color'] = array( "name" => "Header background color",
							"desc" => "Change the header background color.",
							"id" => "header_color",
							"std" => "",
							"type" => "color");
		
		$options['links_color'] = array( "name" => "Buttons and links color",
							"desc" => "Change the color of buttons and links.",
							"id" => "links_color",
							"std" => "",
							"type" => "color");
							
							
		$options['google_mixed_3'] = array( 'name' => 'Body Text',
							'desc' => 'Choose your prefered font for body text. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'google_mixed_3',
							'std' => array( 'size' => '12px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h1_heading'] = array( 'name' => 'H1 Heading',
							'desc' => 'Choose your prefered font for H1 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h1_heading',
							'std' => array( 'size' => '30px', 'lineheight' => '30px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
		
		$options['h2_heading'] = array( 'name' => 'H2 Heading',
							'desc' => 'Choose your prefered font for H2 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h2_heading',
							'std' => array( 'size' => '22px', 'lineheight' => '22px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h3_heading'] = array( 'name' => 'H3 Heading',
							'desc' => 'Choose your prefered font for H3 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h3_heading',
							'std' => array( 'size' => '18px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
		
		$options['h4_heading'] = array( 'name' => 'H4 Heading',
							'desc' => 'Choose your prefered font for H4 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h4_heading',
							'std' => array( 'size' => '14px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h5_heading'] = array( 'name' => 'H5 Heading',
							'desc' => 'Choose your prefered font for H5 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h5_heading',
							'std' => array( 'size' => '12px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h6_heading'] = array( 'name' => 'H6 Heading',
							'desc' => 'Choose your prefered font for H6 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol will be loaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h6_heading',
							'std' => array( 'size' => '12px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
		
		
		$options['g_search_box_id'] = array( "name" => "Display search box?",
							"desc" => "Display search box in the header?",
							"id" => "g_search_box_id",
							"type" => "radio",
							"std" => "yes",
							"options" => $g_search_box);

		$options['g_breadcrumbs_id'] = array( "name" => "Display breadcrumbs?",
							"desc" => "Display breadcrumbs in the page?",
							"id" => "g_breadcrumbs_id",
							"type" => "radio",
							"std" => "yes",
							"options" => $g_breadcrumbs);
		
		$options[] = array( "name" => "Custom CSS",
							"desc" => "Want to add any custom CSS code? Put in here, and the rest is taken care of. This overrides any other stylesheets. eg: a.button{color:green}",
							"id" => "custom_css",
							"std" => "",
							"type" => "textarea");		
		
		
		$options[] = array( "name" => "Logo & Favicon",
							"type" => "heading");
		
		$options['logo_type'] = array( "name" => "What kind of logo?",
							"desc" => "Select whether you want your main logo to be an image or text. If you select 'image' you can put in the image url in the next option, and if you select 'text' your Site Title will be shown instead.",
							"id" => "logo_type",
							"std" => "image_logo",
							"type" => "radio",
							"options" => $logo_type);
		
		$options['logo_url'] = array( "name" => "Logo Image Path",
							"desc" => "Click Upload or Enter the direct path to your <strong>logo image</strong>. For example <em>http://your_website_url_here/wp-content/themes/themeXXXX/images/logo.png</em>",
							"id" => "logo_url",
							"std" => get_stylesheet_directory_uri() . "/images/logo.png",
							"type" => "upload");
							
		$options['favicon'] = array( "name" => "Favicon",
							"desc" => "Click Upload or Enter the direct path to your <strong>favicon</strong>. For example <em>http://your_website_url_here/wp-content/themes/themeXXXX/favicon.ico</em>",
							"id" => "favicon",
							"std" => get_stylesheet_directory_uri() . "/favicon.ico",
							"type" => "upload");
							
		
		
		$options[] = array( "name" => "Navigation",
							"type" => "heading");
		
		$options[] = array( "name" => "Delay",
							"desc" => "miliseconds delay on mouseout.",
							"id" => "sf_delay",
							"std" => "1000",
							"class" => "tiny",
							"type" => "text");
		
		$options[] = array( "name" => "Fade-in animation",
							"desc" => "Fade-in animation.",
							"id" => "sf_f_animation",
							"std" => "show",
							"type" => "radio",
							"options" => $sf_f_animation_array);
		
		$options[] = array( "name" => "Slide-down animation",
							"desc" => "Slide-down animation.",
							"id" => "sf_sl_animation",
							"std" => "show",
							"type" => "radio",
							"options" => $sf_sl_animation_array);
		
		$options[] = array( "name" => "Speed",
							"desc" => "Animation speed.",
							"id" => "sf_speed",
							"type" => "select",
							"std" => "normal",
							"class" => "tiny", //mini, tiny, small
							"options" => $sf_speed_array);
		
		$options[] = array( "name" => "Arrows markup",
							"desc" => "Do you want to generate arrow mark-up?",
							"id" => "sf_arrows",
							"std" => "false",
							"type" => "radio",
							"options" => $sf_arrows_array);		
		
		
		$options[] = array( "name" => "Slider Settings",
                            "type" => "heading");
 
        $options['sl_effect'] = array( "name" => "Sliding effect",
                            "desc" => "Select your animation type",
                            "id" => "sl_effect",
                            "std" => "random",
                            "type" => "select",
                            "class" => "tiny", //mini, tiny, small
                            "options" => $sl_effect_array);
 
        $options['sl_columns'] = array( "name" => "Number of columns",
                            "desc" => "Number of columns",
                            "id" => "sl_columns",
                            "std" => "12",
                            "type" => "select",
                            "class" => "small", //mini, tiny, small
                            "options" => $sl_columns_array);
 
        $options['sl_rows'] = array( "name" => "Number of rows",
                            "desc" => "Number of rows",
                            "id" => "sl_rows",
                            "std" => "8",
                            "type" => "select",
                            "class" => "small", //mini, tiny, small
                            "options" => $sl_rows_array);
 
        $options[] = array( "name" => "Banner effect",
                        "desc" => "Select your banner animation type",
                        "id" => "sl_banner",
                        "std" => "fadeFromBottom",
                        "type" => "select",
                        "class" => "tiny", //mini, tiny, small
                        "options" => $sl_banner_array);
 
        $options['sl_pausetime'] = array( "name" => "Pause time",
                            "desc" => "Pause time (ms).",
                            "id" => "sl_pausetime",
                            "std" => "7000",
                            "class" => "tiny",
                            "type" => "text");
 
        $options['sl_animation_speed'] = array( "name" => "Animation speed",
                            "desc" => "Animation speed (ms).",
                            "id" => "sl_animation_speed",
                            "std" => "1500",
                            "class" => "tiny",
                            "type" => "text");
 
        $options['sl_slideshow'] = array( "name" => "Slideshow",
                            "desc" => "Animate slider automatically?",
                            "id" => "sl_slideshow",
                            "std" => "true",
                            "type" => "radio",
                            "options" => $sl_slideshow_array);
 
        $options['sl_thumbnails'] = array( "name" => "Thumbnails",
                            "desc" => "Display thumbnails?",
                            "id" => "sl_thumbnails",
                            "std" => "true",
                            "type" => "radio",
                            "options" => $sl_thumbnails_array);
 
        $options['sl_control_nav'] = array( "name" => "Pagination",
                            "desc" => "Display pagination",
                            "id" => "sl_control_nav",
                            "std" => "true",
                            "type" => "radio",
                            "options" => $sl_control_nav_array);
 
        $options['sl_dir_nav'] = array( "name" => "Next & Prev navigation",
                            "desc" => "Display next & prev navigation?",
                            "id" => "sl_dir_nav",
                            "std" => "true",
                            "type" => "radio",
                            "options" => $sl_dir_nav_array);
 
        $options[] = array( "name" => "Display next & prev navigation only on hover?",
                            "desc" => "If true the navigation button (prev, next and play/stop buttons) will be visible on hover state only, if false they will be visible always",
                            "id" => "sl_dir_nav_hide",
                            "std" => "false",
                            "type" => "radio",
                            "options" => $sl_dir_nav_hide_array);
 
        $options['sl_play_pause_button'] = array( "name" => "Play/Pause button",
                            "desc" => "Display Play/Pause button?",
                            "id" => "sl_play_pause_button",
                            "std" => "true",
                            "type" => "radio",
                            "options" => $sl_play_pause_button_array);

        $options['sl_loader'] = array( "name" => "Loader",
                            "desc" => "Slider loader",
                            "id" => "sl_loader",
                            "std" => "no",
                            "type" => "select",
                            "class" => "small", //mini, tiny, small
                            "options" => $sl_loader_array);
		
		
		
		$options[] = array( "name" => "Blog",
							"type" => "heading");
		
		$options[] = array( "name" => "Blog Title",
							"desc" => "Enter Your Blog Title used on Blog page.",
							"id" => "blog_text",
							"std" => "Blog",
							"type" => "text");
		
		$options[] = array( "name" => "Related Posts Title",
							"desc" => "Enter Your Title used on Single Post page for related posts.",
							"id" => "blog_related",
							"std" => "Related Posts",
							"type" => "text");
		
		$options['blog_sidebar_pos'] = array( "name" => "Sidebar position",
							"desc" => "Choose sidebar position.",
							"id" => "blog_sidebar_pos",
							"std" => "right",
							"type" => "images",
							"options" => array(
								'left' => $imagepath . '2cl.png',
								'right' => $imagepath . '2cr.png',)
							);
		
		$options['post_image_size'] = array( "name" => "Blog image size",
							"desc" => "Featured image size on the blog.",
							"id" => "post_image_size",
							"type" => "select",
							"std" => "normal",
							"class" => "small", //mini, tiny, small
							"options" => $post_image_size_array);
		
		$options['single_image_size'] = array( "name" => "Single post image size",
							"desc" => "Featured image size on the single page.",
							"id" => "single_image_size",
							"type" => "select",
							"std" => "normal",
							"class" => "small", //mini, tiny, small
							"options" => $single_image_size_array);
		
		$options['post_meta'] = array( "name" => "Enable Meta for blog posts?",
							"desc" => "Enable or Disable meta information for blog posts.",
							"id" => "post_meta",
							"std" => "true",
							"type" => "radio",
							"options" => $post_meta_array);
		
		$options['post_excerpt'] = array( "name" => "Enable excerpt for blog posts?",
							"desc" => "Enable or Disable excerpt for blog posts.",
							"id" => "post_excerpt",
							"std" => "true",
							"type" => "radio",
							"options" => $post_excerpt_array);
		

		$options[] = array( "name" => "Portfolio",
							"type" => "heading");

		$options['folio_filter'] = array( "name" => "Show filter?",
							"desc" => "Enable or Disable portfolio filter.",
							"id" => "folio_filter",
							"std" => "yes",
							"type" => "radio",
							"options" => array(
											"yes" => "Yes",
											"no"	=> "No"));
		
		$options['folio_title'] = array( "name" => "Show title?",
							"desc" => "Enable or Disable title for portfolio posts.",
							"id" => "folio_title",
							"std" => "yes",
							"type" => "radio",
							"options" => array(
											"yes" => "Yes",
											"no"	=> "No"));

		$options['folio_excerpt'] = array( "name" => "Show excerpt?",
							"desc" => "Enable or Disable excerpt for portfolio posts.",
							"id" => "folio_excerpt",
							"std" => "yes",
							"type" => "radio",
							"options" => array(
											"yes" => "Yes",
											"no"	=> "No"));

		$options['folio_excerpt_count'] = array( "name" => "Excerpt words",
							"desc" => "Excerpt length (words).",
							"id" => "folio_excerpt_count",
							"std" => "20",
							"class" => "small",
							"type" => "text");

		$options['folio_btn'] = array( "name" => "Show button?",
							"desc" => "Enable or Disable button for portfolio posts.",
							"id" => "folio_btn",
							"std" => "yes",
							"type" => "radio",
							"options" => array(
											"yes" => "Yes",
											"no"	=> "No"));

		$options['layout_mode'] = array( "name" => "Layout",
							"desc" => "Portfolio has different layout modes. You can set and change the layout mode via this option.",
							"id" => "layout_mode",
							"type" => "select",
							"std" => "fitRows",
							"class" => "small", //mini, tiny, small
							"options" => array(
											"fitRows" => "fitRows",
											"masonry" => "masonry"));

		$options['items_count2'] = array( "name" => "Portfolio 2 columns items amount",
							"desc" => "Portfolio items amount for Portfolio 2 columns template.",
							"id" => "items_count2",
							"std" => "8",
							"class" => "small",
							"type" => "text");

		$options['items_count3'] = array( "name" => "Portfolio 3 columns items amount",
							"desc" => "Portfolio items amount for Portfolio 3 columns template.",
							"id" => "items_count3",
							"std" => "9",
							"class" => "small",
							"type" => "text");
		
		$options['items_count4'] = array( "name" => "Portfolio 4 columns items amount",
							"desc" => "Portfolio items amount for Portfolio 4 columns template.",
							"id" => "items_count4",
							"std" => "12",
							"class" => "small",
							"type" => "text");
		
		
		$options[] = array( "name" => "Footer",
							"type" => "heading");
		
		$options['footer_text'] = array( "name" => "Footer copyright text",
							"desc" => "Enter text used in the right side of the footer. HTML tags are allowed.",
							"id" => "footer_text",
							"std" => "",
							"type" => "textarea");
		
		$options[] = array( "name" => "Google Analytics Code",
							"desc" => "You can paste your Google Analytics or other tracking code in this box. This will be automatically added to the footer.",
							"id" => "ga_code",
							"std" => "",
							"type" => "textarea");
		
		$options['feed_url'] = array( "name" => "Feedburner URL",
							"desc" => "Feedburner is a Google service that takes care of your RSS feed. Paste your Feedburner URL here to let readers see it in your website.",
							"id" => "feed_url",
							"std" => "",
							"type" => "text");
		
		$options['footer_menu'] = array( "name" => "Display Footer menu?",
							"desc" => "Do you want to display footer menu?",
							"id" => "footer_menu",
							"std" => "true",
							"type" => "radio",
							"options" => $footer_menu_array);
		
		return $options;
	}
	
}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');


if(!function_exists('optionsframework_custom_scripts')) {

	function optionsframework_custom_scripts() { ?>

		<script type="text/javascript">
		jQuery(document).ready(function($) {

			$('#example_showhidden').click(function() {
					$('#section-example_text_hidden').fadeToggle(400);
			});
			
			if ($('#example_showhidden:checked').val() !== undefined) {
				$('#section-example_text_hidden').show();
			}
			
		});
		</script>

		<?php
		}

}



/**
* Front End Customizer
*
* WordPress 3.4 Required
*/
add_action( 'customize_register', 'cherry_register' );

if(!function_exists('cherry_register')) {

	function cherry_register($wp_customize) {
		/**
		 * This is optional, but if you want to reuse some of the defaults
		 * or values you already have built in the options panel, you
		 * can load them into $options for easy reference
		 */
		$options = optionsframework_options();
		
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	General
		/*-----------------------------------------------------------------------------------*/
		$wp_customize->add_section( 'cherry_header', array(
			'title' => __( 'General', 'cherry' ),
			'priority' => 200
		));
		
		/* Background Image*/
		$wp_customize->add_setting( 'cherry[body_background][image]', array(
			'default' => $options['body_background']['std']['image'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'body_background_image', array(
			'label'   => 'Background Image',
			'section' => 'cherry_header',
			'settings'   => 'cherry[body_background][image]'
		) ) );
		
		
		/* Background Color*/
		$wp_customize->add_setting( 'cherry[body_background][color]', array(
			'default' => $options['body_background']['std']['color'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_background', array(
			'label'   => 'Background Color',
			'section' => 'cherry_header',
			'settings'   => 'cherry[body_background][color]'
		) ) );
		
		/* Header Color */
		$wp_customize->add_setting( 'cherry[header_color]', array(
			'default' => $options['header_color']['std'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
			'label'   => $options['header_color']['name'],
			'section' => 'cherry_header',
			'settings'   => 'cherry[header_color]'
		) ) );
		
		
		/* Body Font Face */
		$wp_customize->add_setting( 'cherry[google_mixed_3][face]', array(
			'default' => $options['google_mixed_3']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_google_mixed_3', array(
				'label' => $options['google_mixed_3']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[google_mixed_3][face]',
				'type' => 'select',
				'choices' => $options['google_mixed_3']['options']['faces']
		) );
		
		
		/* Buttons and Links Color */
		$wp_customize->add_setting( 'cherry[links_color]', array(
			'default' => $options['links_color']['std'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'links_color', array(
			'label'   => $options['links_color']['name'],
			'section' => 'cherry_header',
			'settings'   => 'cherry[links_color]'
		) ) );
		
		/* H1 Heading font face */
		$wp_customize->add_setting( 'cherry[h1_heading][face]', array(
			'default' => $options['h1_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_h1_heading', array(
				'label' => $options['h1_heading']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[h1_heading][face]',
				'type' => 'select',
				'choices' => $options['h1_heading']['options']['faces']
		) );
		
		/* H2 Heading font face */
		$wp_customize->add_setting( 'cherry[h2_heading][face]', array(
			'default' => $options['h2_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_h2_heading', array(
				'label' => $options['h2_heading']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[h2_heading][face]',
				'type' => 'select',
				'choices' => $options['h2_heading']['options']['faces']
		) );

		/* H3 Heading font face */
		$wp_customize->add_setting( 'cherry[h3_heading][face]', array(
			'default' => $options['h3_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_h3_heading', array(
				'label' => $options['h3_heading']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[h3_heading][face]',
				'type' => 'select',
				'choices' => $options['h3_heading']['options']['faces']
		) );

		/* H4 Heading font face */
		$wp_customize->add_setting( 'cherry[h4_heading][face]', array(
			'default' => $options['h4_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_h4_heading', array(
				'label' => $options['h4_heading']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[h4_heading][face]',
				'type' => 'select',
				'choices' => $options['h4_heading']['options']['faces']
		) );

		/* H5 Heading font face */
		$wp_customize->add_setting( 'cherry[h5_heading][face]', array(
			'default' => $options['h5_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_h5_heading', array(
				'label' => $options['h5_heading']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[h5_heading][face]',
				'type' => 'select',
				'choices' => $options['h5_heading']['options']['faces']
		) );
		
		/* H6 Heading font face */
		$wp_customize->add_setting( 'cherry[h6_heading][face]', array(
			'default' => $options['h6_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'cherry_h6_heading', array(
				'label' => $options['h6_heading']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[h6_heading][face]',
				'type' => 'select',
				'choices' => $options['h6_heading']['options']['faces']
		) );
		
		
		/* Search Box*/
		$wp_customize->add_setting( 'cherry[g_search_box_id]', array(
				'default' => $options['g_search_box_id']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_g_search_box_id', array(
				'label' => $options['g_search_box_id']['name'],
				'section' => 'cherry_header',
				'settings' => 'cherry[g_search_box_id]',
				'type' => $options['g_search_box_id']['type'],
				'choices' => $options['g_search_box_id']['options']
		) );
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	Logo
		/*-----------------------------------------------------------------------------------*/
		
		$wp_customize->add_section( 'cherry_logo', array(
			'title' => __( 'Logo', 'cherry' ),
			'priority' => 201
		) );
		
		/* Logo Type */
		$wp_customize->add_setting( 'cherry[logo_type]', array(
				'default' => $options['logo_type']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_logo_type', array(
				'label' => $options['logo_type']['name'],
				'section' => 'cherry_logo',
				'settings' => 'cherry[logo_type]',
				'type' => $options['logo_type']['type'],
				'choices' => $options['logo_type']['options']
		) );
		
		/* Logo Path */
		$wp_customize->add_setting( 'cherry[logo_url]', array(
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_url', array(
			'label' => $options['logo_url']['name'],
			'section' => 'cherry_logo',
			'settings' => 'cherry[logo_url]'
		) ) );
		
		
		
		/*-----------------------------------------------------------------------------------*/
		/*  Slider
		/*-----------------------------------------------------------------------------------*/
		 
		$wp_customize->add_section( 'cherry_slider', array(
			'title' => __( 'Slider', 'cherry' ),
			'priority' => 202
		) );
		 
		/* Slider Effect */
		$wp_customize->add_setting( 'cherry[sl_effect]', array(
				'default' => $options['sl_effect']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_effect', array(
				'label' => $options['sl_effect']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_effect]',
				'type' => $options['sl_effect']['type'],
				'choices' => $options['sl_effect']['options']
		) );
		 
		/* Pause time */
		$wp_customize->add_setting( 'cherry[sl_pausetime]', array(
				'default' => $options['sl_pausetime']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_pausetime', array(
				'label' => $options['sl_pausetime']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_pausetime]',
				'type' => $options['sl_pausetime']['type']
		) );
		 
		/* Animation speed */
		$wp_customize->add_setting( 'cherry[sl_animation_speed]', array(
				'default' => $options['sl_animation_speed']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_animation_speed', array(
				'label' => $options['sl_animation_speed']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_animation_speed]',
				'type' => $options['sl_animation_speed']['type']
		) );
		 
		/* Auto slideshow */
		$wp_customize->add_setting( 'cherry[sl_slideshow]', array(
				'default' => $options['sl_slideshow']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_slideshow', array(
				'label' => $options['sl_slideshow']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_slideshow]',
				'type' => $options['sl_slideshow']['type'],
				'choices' => $options['sl_slideshow']['options']
		) );
		 
		/* Slide thumbnails */
		$wp_customize->add_setting( 'cherry[sl_thumbnails]', array(
				'default' => $options['sl_thumbnails']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_thumbnails', array(
				'label' => $options['sl_thumbnails']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_thumbnails]',
				'type' => $options['sl_thumbnails']['type'],
				'choices' => $options['sl_thumbnails']['options']
		) );
		 
		/* Show pagination? */
		$wp_customize->add_setting( 'cherry[sl_control_nav]', array(
				'default' => $options['sl_control_nav']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_control_nav', array(
				'label' => $options['sl_control_nav']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_control_nav]',
				'type' => $options['sl_control_nav']['type'],
				'choices' => $options['sl_control_nav']['options']
		) );   
		 
		/* Display next & prev navigation? */
		$wp_customize->add_setting( 'cherry[sl_dir_nav]', array(
				'default' => $options['sl_dir_nav']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_dir_nav', array(
				'label' => $options['sl_dir_nav']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_dir_nav]',
				'type' => $options['sl_dir_nav']['type'],
				'choices' => $options['sl_dir_nav']['options']
		) );
		 
		/* Play/Pause button */
		$wp_customize->add_setting( 'cherry[sl_play_pause_button]', array(
				'default' => $options['sl_play_pause_button']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_play_pause_button', array(
				'label' => $options['sl_play_pause_button']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_play_pause_button]',
				'type' => $options['sl_play_pause_button']['type'],
				'choices' => $options['sl_play_pause_button']['options']
		) );
		

		/* Loader */
		$wp_customize->add_setting( 'cherry[sl_loader]', array(
				'default' => $options['sl_loader']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_sl_loader', array(
				'label' => $options['sl_loader']['name'],
				'section' => 'cherry_slider',
				'settings' => 'cherry[sl_loader]',
				'type' => $options['sl_loader']['type'],
				'choices' => $options['sl_loader']['options']
		) );
		
		
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	Blog
		/*-----------------------------------------------------------------------------------*/
		
		
		$wp_customize->add_section( 'cherry_blog', array(
				'title' => __( 'Blog', 'cherry' ),
				'priority' => 203
		) );
		
		/* Blog image size */
		$wp_customize->add_setting( 'cherry[post_image_size]', array(
				'default' => $options['post_image_size']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_post_image_size', array(
				'label' => $options['post_image_size']['name'],
				'section' => 'cherry_blog',
				'settings' => 'cherry[post_image_size]',
				'type' => $options['post_image_size']['type'],
				'choices' => $options['post_image_size']['options']
		) );
		
		/* Single post image size */
		$wp_customize->add_setting( 'cherry[single_image_size]', array(
				'default' => $options['single_image_size']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_single_image_size', array(
				'label' => $options['single_image_size']['name'],
				'section' => 'cherry_blog',
				'settings' => 'cherry[single_image_size]',
				'type' => $options['single_image_size']['type'],
				'choices' => $options['single_image_size']['options']
		) );
		
		/* Post Meta */
		$wp_customize->add_setting( 'cherry[post_meta]', array(
				'default' => $options['post_meta']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_post_meta', array(
				'label' => $options['post_meta']['name'],
				'section' => 'cherry_blog',
				'settings' => 'cherry[post_meta]',
				'type' => $options['post_meta']['type'],
				'choices' => $options['post_meta']['options']
		) );
		
		/* Post Excerpt */
		$wp_customize->add_setting( 'cherry[post_excerpt]', array(
				'default' => $options['post_excerpt']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_post_excerpt', array(
				'label' => $options['post_excerpt']['name'],
				'section' => 'cherry_blog',
				'settings' => 'cherry[post_excerpt]',
				'type' => $options['post_excerpt']['type'],
				'choices' => $options['post_excerpt']['options']
		) );
		
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	Footer
		/*-----------------------------------------------------------------------------------*/
		
		$wp_customize->add_section( 'cherry_footer', array(
			'title' => __( 'Footer', 'cherry' ),
			'priority' => 204
		) );
			
		/* Footer Copyright Text */
		$wp_customize->add_setting( 'cherry[footer_text]', array(
				'default' => $options['footer_text']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_footer_text', array(
				'label' => $options['footer_text']['name'],
				'section' => 'cherry_footer',
				'settings' => 'cherry[footer_text]',
				'type' => 'text'
		) );
		
		
		/* Display Footer Menu */
		$wp_customize->add_setting( 'cherry[footer_menu]', array(
				'default' => $options['footer_menu']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'cherry_footer_menu', array(
				'label' => $options['footer_menu']['name'],
				'section' => 'cherry_footer',
				'settings' => 'cherry[footer_menu]',
				'type' => $options['footer_menu']['type'],
				'choices' => $options['footer_menu']['options']
		) );
		

		
	};

}
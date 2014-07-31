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
		$themename = 'my_framework';
		
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
		
		// Superfish shadows
		$sf_shadows_array = array(
			"true" => "Yes",
			"false" => "No"
		);
		
		
		// Fonts
		$typography_mixed_fonts = array_merge( options_typography_get_os_fonts() , options_typography_get_google_fonts() );
		asort($typography_mixed_fonts);
		
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
							'desc' => 'Choose your prefered font for body text. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'google_mixed_3',
							'std' => array( 'size' => '12px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h1_heading'] = array( 'name' => 'H1 Heading',
							'desc' => 'Choose your prefered font for H1 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h1_heading',
							'std' => array( 'size' => '30px', 'lineheight' => '30px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
		
		$options['h2_heading'] = array( 'name' => 'H2 Heading',
							'desc' => 'Choose your prefered font for H2 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h2_heading',
							'std' => array( 'size' => '22px', 'lineheight' => '22px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h3_heading'] = array( 'name' => 'H3 Heading',
							'desc' => 'Choose your prefered font for H3 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h3_heading',
							'std' => array( 'size' => '18px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
		
		$options['h4_heading'] = array( 'name' => 'H4 Heading',
							'desc' => 'Choose your prefered font for H4 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h4_heading',
							'std' => array( 'size' => '14px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h5_heading'] = array( 'name' => 'H5 Heading',
							'desc' => 'Choose your prefered font for H5 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
							'id' => 'h5_heading',
							'std' => array( 'size' => '12px', 'lineheight' => '18px', 'face' => 'Arial, Helvetica, sans-serif', 'color' => '#333333'),
							'type' => 'typography',
							'options' => array(
									'faces' => $typography_mixed_fonts )
							);
							
		$options['h6_heading'] = array( 'name' => 'H6 Heading',
							'desc' => 'Choose your prefered font for H6 heading and titles. <em>Note: fonts marked with <strong>*</strong> symbol are uploaded from the <a href="http://www.google.com/webfonts">Google Web Fonts</a> library.</em>',
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
							"desc" => "Select whether you want your main logo to be an image or text. If you select 'image' you can put in the image url in the next option, and if you select 'text' your Site Title will show instead.",
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
							"class" => "mini",
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
add_action( 'customize_register', 'my_framework_register' );

if(!function_exists('my_framework_register')) {

	function my_framework_register($wp_customize) {
		/**
		 * This is optional, but if you want to reuse some of the defaults
		 * or values you already have built in the options panel, you
		 * can load them into $options for easy reference
		 */
		$options = optionsframework_options();
		
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	General
		/*-----------------------------------------------------------------------------------*/
		$wp_customize->add_section( 'my_framework_header', array(
			'title' => __( 'General', 'my_framework' ),
			'priority' => 200
		));
		
		/* Background Image*/
		$wp_customize->add_setting( 'my_framework[body_background][image]', array(
			'default' => $options['body_background']['std']['image'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'body_background_image', array(
			'label'   => 'Background Image',
			'section' => 'my_framework_header',
			'settings'   => 'my_framework[body_background][image]'
		) ) );
		
		
		/* Background Color*/
		$wp_customize->add_setting( 'my_framework[body_background][color]', array(
			'default' => $options['body_background']['std']['color'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_background', array(
			'label'   => 'Background Color',
			'section' => 'my_framework_header',
			'settings'   => 'my_framework[body_background][color]'
		) ) );
		
		/* Header Color */
		$wp_customize->add_setting( 'my_framework[header_color]', array(
			'default' => $options['header_color']['std'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
			'label'   => $options['header_color']['name'],
			'section' => 'my_framework_header',
			'settings'   => 'my_framework[header_color]'
		) ) );
		
		
		/* Body Font Face */
		$wp_customize->add_setting( 'my_framework[google_mixed_3][face]', array(
			'default' => $options['google_mixed_3']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_google_mixed_3', array(
				'label' => $options['google_mixed_3']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[google_mixed_3][face]',
				'type' => 'select',
				'choices' => $options['google_mixed_3']['options']['faces']
		) );
		
		
		/* Buttons and Links Color */
		$wp_customize->add_setting( 'my_framework[links_color]', array(
			'default' => $options['links_color']['std'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'links_color', array(
			'label'   => $options['links_color']['name'],
			'section' => 'my_framework_header',
			'settings'   => 'my_framework[links_color]'
		) ) );
		
		/* H1 Heading font face */
		$wp_customize->add_setting( 'my_framework[h1_heading][face]', array(
			'default' => $options['h1_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_h1_heading', array(
				'label' => $options['h1_heading']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[h1_heading][face]',
				'type' => 'select',
				'choices' => $options['h1_heading']['options']['faces']
		) );
		
		/* H2 Heading font face */
		$wp_customize->add_setting( 'my_framework[h2_heading][face]', array(
			'default' => $options['h2_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_h2_heading', array(
				'label' => $options['h2_heading']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[h2_heading][face]',
				'type' => 'select',
				'choices' => $options['h2_heading']['options']['faces']
		) );

		/* H3 Heading font face */
		$wp_customize->add_setting( 'my_framework[h3_heading][face]', array(
			'default' => $options['h3_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_h3_heading', array(
				'label' => $options['h3_heading']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[h3_heading][face]',
				'type' => 'select',
				'choices' => $options['h3_heading']['options']['faces']
		) );

		/* H4 Heading font face */
		$wp_customize->add_setting( 'my_framework[h4_heading][face]', array(
			'default' => $options['h4_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_h4_heading', array(
				'label' => $options['h4_heading']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[h4_heading][face]',
				'type' => 'select',
				'choices' => $options['h4_heading']['options']['faces']
		) );

		/* H5 Heading font face */
		$wp_customize->add_setting( 'my_framework[h5_heading][face]', array(
			'default' => $options['h5_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_h5_heading', array(
				'label' => $options['h5_heading']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[h5_heading][face]',
				'type' => 'select',
				'choices' => $options['h5_heading']['options']['faces']
		) );
		
		/* H6 Heading font face */
		$wp_customize->add_setting( 'my_framework[h6_heading][face]', array(
			'default' => $options['h6_heading']['std']['face'],
			'type' => 'option'
		) );
		
		$wp_customize->add_control( 'my_framework_h6_heading', array(
				'label' => $options['h6_heading']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[h6_heading][face]',
				'type' => 'select',
				'choices' => $options['h6_heading']['options']['faces']
		) );
		
		
		/* Search Box*/
		$wp_customize->add_setting( 'my_framework[g_search_box_id]', array(
				'default' => $options['g_search_box_id']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_g_search_box_id', array(
				'label' => $options['g_search_box_id']['name'],
				'section' => 'my_framework_header',
				'settings' => 'my_framework[g_search_box_id]',
				'type' => $options['g_search_box_id']['type'],
				'choices' => $options['g_search_box_id']['options']
		) );
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	Logo
		/*-----------------------------------------------------------------------------------*/
		
		$wp_customize->add_section( 'my_framework_logo', array(
			'title' => __( 'Logo', 'my_framework' ),
			'priority' => 201
		) );
		
		/* Logo Type */
		$wp_customize->add_setting( 'my_framework[logo_type]', array(
				'default' => $options['logo_type']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_logo_type', array(
				'label' => $options['logo_type']['name'],
				'section' => 'my_framework_logo',
				'settings' => 'my_framework[logo_type]',
				'type' => $options['logo_type']['type'],
				'choices' => $options['logo_type']['options']
		) );
		
		/* Logo Path */
		$wp_customize->add_setting( 'my_framework[logo_url]', array(
			'type' => 'option'
		) );
		
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_url', array(
			'label' => $options['logo_url']['name'],
			'section' => 'my_framework_logo',
			'settings' => 'my_framework[logo_url]'
		) ) );
		

		
		
		/*-----------------------------------------------------------------------------------*/
		/*	Blog
		/*-----------------------------------------------------------------------------------*/
		
		
		$wp_customize->add_section( 'my_framework_blog', array(
				'title' => __( 'Blog', 'my_framework' ),
				'priority' => 203
		) );
		
		/* Blog image size */
		$wp_customize->add_setting( 'my_framework[post_image_size]', array(
				'default' => $options['post_image_size']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_post_image_size', array(
				'label' => $options['post_image_size']['name'],
				'section' => 'my_framework_blog',
				'settings' => 'my_framework[post_image_size]',
				'type' => $options['post_image_size']['type'],
				'choices' => $options['post_image_size']['options']
		) );
		
		/* Single post image size */
		$wp_customize->add_setting( 'my_framework[single_image_size]', array(
				'default' => $options['single_image_size']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_single_image_size', array(
				'label' => $options['single_image_size']['name'],
				'section' => 'my_framework_blog',
				'settings' => 'my_framework[single_image_size]',
				'type' => $options['single_image_size']['type'],
				'choices' => $options['single_image_size']['options']
		) );
		
		/* Post Meta */
		$wp_customize->add_setting( 'my_framework[post_meta]', array(
				'default' => $options['post_meta']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_post_meta', array(
				'label' => $options['post_meta']['name'],
				'section' => 'my_framework_blog',
				'settings' => 'my_framework[post_meta]',
				'type' => $options['post_meta']['type'],
				'choices' => $options['post_meta']['options']
		) );
		
		/* Post Excerpt */
		$wp_customize->add_setting( 'my_framework[post_excerpt]', array(
				'default' => $options['post_excerpt']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_post_excerpt', array(
				'label' => $options['post_excerpt']['name'],
				'section' => 'my_framework_blog',
				'settings' => 'my_framework[post_excerpt]',
				'type' => $options['post_excerpt']['type'],
				'choices' => $options['post_excerpt']['options']
		) );
		
		
		
		/*-----------------------------------------------------------------------------------*/
		/*	Footer
		/*-----------------------------------------------------------------------------------*/
		
		$wp_customize->add_section( 'my_framework_footer', array(
			'title' => __( 'Footer', 'my_framework' ),
			'priority' => 204
		) );
			
		/* Footer Copyright Text */
		$wp_customize->add_setting( 'my_framework[footer_text]', array(
				'default' => $options['footer_text']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_footer_text', array(
				'label' => $options['footer_text']['name'],
				'section' => 'my_framework_footer',
				'settings' => 'my_framework[footer_text]',
				'type' => 'text'
		) );
		
		
		/* Display Footer Menu */
		$wp_customize->add_setting( 'my_framework[footer_menu]', array(
				'default' => $options['footer_menu']['std'],
				'type' => 'option'
		) );
		$wp_customize->add_control( 'my_framework_footer_menu', array(
				'label' => $options['footer_menu']['name'],
				'section' => 'my_framework_footer',
				'settings' => 'my_framework[footer_menu]',
				'type' => $options['footer_menu']['type'],
				'choices' => $options['footer_menu']['options']
		) );
		

		
	};

}
=== Captain Slider ===
Contributors: captaintheme, bryceadams123, sunnyratilal
Donate link: http://captaintheme.com/
Tags: captain theme, captain slider, slider, jquery slider, responsive slider, slideshow, video slider, mobile slider, flexslider, custom post types, Image Rotator, image slider, image slider plugin, javascript rotator, javascript slider, jquery rotator, photo rotator, Photo Slider, picture slider, responsive, responsive image slider, responsive image slider plugin, responsive rotator, responsive slider plugin, responsive slideshow, responsive slideshow plugin, rotator, shortcode, slider plugin, slideshow plugin, slider shortcode
Requires at least: 3.3
Tested up to: 3.5
Stable tag: trunk
License: GPLv2 or later

Probably the Best Free jQuery Slider/Slideshow Plugin for Wordpress. Responsive, Settings & Multiple Sliders!

== Description ==

This is the Slider Plugin I always wished I had. Simply install the plugin, add some slides & use your slider! It's that easy.

**Premium Support is available. Just simply make a donation of $5 or more through the plugin's Settings page and then visit [Captain Theme Premium Support](http://captaintheme.com/support/). Please quote your transaction number or use the email you made the donation with. Thank you!**

**Features:**

* Plenty of Settings like animation, speed, etc.
* Multiple Sliders
* Slider Sorter: Order your slides using drag & drop AJAX.
* Responsive
* Video Slides
* Captions
* Slide Links
* Shortcode
* Free

**There are 2 ways to use your sliders:**

* PHP - `<?php echo ctslider_slider_template( $id ); ?>`
* Shortcode - `[slider id=""]`

**Credits:**

* Made by [Captain Theme](http://captaintheme.com/)
* Uses [Flexslider](http://woothemes.com/flexslider/)

**Documentation:**
[Captain Slider Documentation](http://cpthe.me/sliderdocs)

*This plugin is being actively developed and improved in it's [GitHub Repository](https://github.com/bryceadams/Captain-Slider/)*

== Installation ==

How to install this plugin?

1. Search for "Captain Slider" in the Add New Plugin section of your site or download it and upload it manually.
1. Install and activate the plugin.
1. Create Slides under the new **Captain Slider** Menu.
1. Use your Slider with either PHP or the Shortcode.
1. Magic!

== Frequently Asked Questions ==

= I’m getting the following error message when using PHP to display my slider (with all slides): Warning: Missing argument 1 for nextslider_slider_template(), called in etc. etc. = Some hosting set-ups may have this issue. Just give it an empty parameter like so:
`// All slides, with empty parameter set to stop warning from appearing
<?php echo nextslider_slider_template(''); ?>`

= My slider isn’t displaying the specific slider I want? = Make sure that you’re stating the ID correctly like the examples above. Remember that you can find the slider ID under Slides > Sliders.
= My slider’s just not displaying! = If you’ve done everything else right and it’s still not displaying, you’re probably having a jQuery conflict with another plugin/theme. Try reverting back to the default Twenty Eleven or Twenty Twelve theme and disabling each plugin one by one.
= Can I display multiple sliders on one page? = Why yes you can!
= Which slider does Captain Slider use? = Captain Slider proudly uses the lovely [Flex Slider](http://woothemes.com/flexslider/) by [WooThemes](http://woothemes.com/)
= How can I say thanks Captain Theme? =
How sweet of you. Anything from a small donation (made through the Captain Slider settings page) to a link to Captain Theme (http://captaintheme.com/) on your site helps!
== Screenshots ==

1. The Add New Slide Page - captions/links/video inputs etc.
2. The Settings Page
3. All Slides
4. The Slider Manager - add or remove your sliders
5. The Slider Sorter - configure the order of your slides


== Other Notes ==

**Want to help?** Translate the Plugin! It's really easy using something like [the Codestyling Localization plugin](http://www.code-styling.de/english/development/wordpress-plugin-codestyling-localization-en), or an app like [Poedit](http://www.poedit.net/). You know what's even better? You get to help thousands of people! And I link to you! How good is that? Just [contact me](mailto:bryce@captaintheme.com) to talk about it. I'll even give you a present ;)

This plugin is openly developed on GitHub - [View the Repo!](https://github.com/bryceadams/Captain-Slider) Found a bug? [Open an issue!](https://github.com/bryceadams/Captain-Slider/issues)


== Changelog ==

= 1.0.6 =

* Minor CSS Fix for Default Wordpress Themes
* Update CTSLIDER_VERSION constant

= 1.0.5 =

* General Improvements
* Better Code Formatting

= 1.0.0 =

* Initial Release.
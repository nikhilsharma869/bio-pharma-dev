=== Import/Display LinkedIn Company Profile ===
Contributors: neowang
Tags: import linkedin, company profile
Requires at least: 3.6
Tested up to: 3.8.1
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Import/Display LinkedIn Company Profile

== Description ==

Import and display linkedin company profile. 
It requires Contact Form 7 (http://wordpress.org/plugins/contact-form-7/). 

Here are the steps to import and display company profiles:
1. the import process is initiated by public user submitting Contact Form which must have a linkedin-url field;
2. this plugin then will create a new post with post type "Company Profile"
3. a WordPress administration click "import" link
4. this plugin take the admin to LinkedIn to login. The admin can login with any linkedin account because LinkedIn API requires a live user token which is only generated by a live user
5. if the login fails, the admin will be prompted the failure and suggested to click "import" link again
6. (TODO) if linkedin profile had been imported before, the profile won't be re-imported; and the admin will be prompted that the profile has been imported before. 
    In order to re-import, please delete the main content of the Company Profile and click on "import" link.
    Or the plugin confirm with the admin and re-import and overwrite previous import
7. the plugin pulls company profile from LinkedIn and overwrites the main content of the post
8. the admin publish the post

= Docs & Support =

http://wordpress.org/support/plugin/import-linkedin-company on WordPress.org. If you can't locate any topics that pertain to your particular issue, post a new topic for it.

== Installation ==

1. Upload the entire 'import-linkedin-company' folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

You will find 'Company Profiles' menu in your WordPress admin panel.

== Frequently Asked Questions ==

Do you have questions or issues with Contact Form 7? Use these support channels appropriately.

1. [Support Forum](http://wordpress.org/support/plugin/import-linkedin-company)

== Screenshots ==

1. screenshot.png

== Changelog ==

= 1.0 =

* Support import LinkedIn company profile
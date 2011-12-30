=== Gantry BuddyPress ===
Contributors: gantry
Author URI: http://gantry-framework.org
Tags: buddypress, gantry, social, framework, template, theme, widgets, flexible, extensible, configurable, 960px, grid, columns, powerful
Requires at least: 3.2.0
Tested up to: 3.3
Stable tag: 1.1

Gantry BuddyPress plugin adds the support for the BuddyPress 1.5 (or newer) to all Gantry powered themes.

== Description ==

Gantry BuddyPress plugin adds the support for the BuddyPress 1.5 (or newer) to all Gantry powered themes. The only thing that user needs to do is to download and activate the plugin. Depending on the theme some styling fixes might need to be applied.

== Installation ==

This section describes how to install the plugin and get it working.

Using WordPress plugin installer :

1. Go to the Admin Dashboard > Plugins > Add New
1. From the top list select 'Upload'
1. Point the Browse window to the plugin zip package
1. Activate the plugin in Admin Dashboard > Plugins 

Using FTP :

1. Extract the zip package with the plugin
1. Upload the plugin directory to the wp-content/plugins/
1. Activate the plugin in Admin Dashboard > Plugins

Please note that you need to have activated Gantry Framework plugin and Gantry powered theme in order to get this plugin working.

== Frequently Asked Questions ==

= What are the requirements of the plugin ? =

The recommended minimum requirements are :

* WordPress 3.2.1 or higher
* BuddyPress 1.5 or higher
* Gantry Framework plugin 1.21 or higher
* Gantry powered theme

= Where are the options of the plugin ? =

You can find the plugin options in the Admin Dashboard -> Plugins -> Gantry BuddyPress 

= Does it work with all Gantry powered themes or just any particular one ? =

It works with all Gantry powered themes (there can be some styling changes required)! :) If you own a Gantry powered theme - your theme is BuddyPress capable.

= Does it work with WordPress Multi Site installations ? =

Yes it does! In order to have it working in the Multi Site environment a Gantry Framework plugin version 1.21 is required.

= Can I customize the CSS style or the HTML structure of the BuddyPress files ? =

Yes you can!

In order to customize the CSS styling please follow these steps :
* Disable loading of the default style in the Gantry BuddyPress plugin settings
* Copy the CSS files from the plugin directory to your theme-directory/css/
* Edit the index.php file and add the CSS files to the head section

In order to change the structure of the BuddyPress files please follow these steps :
* Duplicate the 'html' directory from the plugin directory
* Rename the duplicated directory to 'buddypress' 
* Place it in your theme root directory - once plugin will detect these files in your theme directory, it will load them instead of the plugin ones.

== Changelog ==

= 1.1 =
* Fixed activation link in the activation emails

= 1.0 =
* Initial release
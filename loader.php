<?php
/**
 * @version   1.0 October 15, 2011
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
/*
Plugin Name: Gantry BuddyPress
Plugin URI: http://www.rockettheme.com
Description: Gantry BuddyPress is a plugin that adds support for the BuddyPress to the Gantry Framework plugin. This can be applied to all Gantry powered themes.
Author: RocketTheme, LLC
Version: 1.0
Author URI: http://www.rockettheme.com
License: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
Contains code from BuddyPress Template Pack Plugin by apeatling and boonebgorges
The BuddyPress Template Pack plugin can be found at http://wordpress.org/extend/plugins/bp-template-pack/
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

global $gantry_bp_path, $gantry_bp_url;
if(!is_multisite()) {
    $gantry_bp_path = dirname($plugin);
} else {
    $gantry_bp_path = dirname($network_plugin);
}
$gantry_bp_url = WP_PLUGIN_URL . '/' . basename($gantry_bp_path);

// Define Directory Separator
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

// Check if Gantry Framework Plugin is active
function is_gantry_active() {
    $active = false;
    $active_plugins = get_option('active_plugins');
    if (in_array('gantry/gantry.php', $active_plugins)) {
        $active = true;
    }
    if (!function_exists('is_plugin_active_for_network'))
        require_once(ABSPATH . '/wp-admin/includes/plugin.php');
    if (is_plugin_active_for_network('gantry/gantry.php')) {
        $active = true;
    }
    return $active;
}

// Check if active theme is a Gantry theme
function is_gantry_theme() {
    $active = false;
    $current_theme = get_option('template');
    if(file_exists(WP_CONTENT_DIR . '/themes/' . $current_theme . '/templateDetails.xml')) {
        $active = true;
    }
    return $active;
}

// If Gantry Theme is used - stop loading BuddyPress Template Pack plugin
if (is_gantry_theme()) {
    remove_action('bp_include', 'bp_tpack_loader');
}

// Load the plugin contents once BuddyPress is installed
function gantry_bp_loader() {
    global $gantry_bp_path;
    
    if(is_gantry_active() && is_gantry_theme())
	    include($gantry_bp_path . '/gantry_bp.php');
}

add_action('bp_include', 'gantry_bp_loader');

// Setup and register initial plugin options
function gantry_bp_setup_options() {
    add_option('gantry_bp_disable_js', 0);
    add_option('gantry_bp_disable_css', 0);
    add_option('gantry_bp_disable_buddybar', 0);
    
    register_setting('gantry_bp_options', 'gantry_bp_disable_js');
    register_setting('gantry_bp_options', 'gantry_bp_disable_css');
    register_setting('gantry_bp_options', 'gantry_bp_disable_buddybar');
}

add_action('admin_init', 'gantry_bp_setup_options');

// Add admin menu for the Gantry BuddyPress
function gantry_bp_add_admin_menu() {
    add_plugins_page('Gantry BuddyPress', 'Gantry BuddyPress', 'edit_theme_options', 'gantry-buddypress', 'gantry_bp_options_page');
}

add_action('admin_menu', 'gantry_bp_add_admin_menu');

// Contents of the plugin options page
function gantry_bp_options_page() {

    $disable_js = get_option('gantry_bp_disable_js');
    $disable_css = get_option('gantry_bp_disable_css');
    $disable_buddybar = get_option('gantry_bp_disable_buddybar');

    if(isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true') {
       echo '<div id="message" class="updated fade"><p>' . __('Plugin settings have been saved.', 'gantry_bp') . '</p></div>';
    }

    ?>

    <div class="wrap">
        <h2>Gantry BuddyPress <?php _e('Settings', 'gantry_bp'); ?></h2>
        <div id="gantry-buddypress-settings">
            <form method="post" action="options.php">
                <?php settings_fields('gantry_bp_options'); ?>
                <table class="form-table">
                    <tbody>
                        <tr valign="top">
                            <th scope="row">
                                <label for="disable_css"><?php _e('Disable default CSS', 'gantry_bp'); ?></label>
                            </th>
                            <td>
                                <input id="disable_css" name="gantry_bp_disable_css" type="checkbox" class="checkbox" value="1" <?php checked($disable_css, 1, true); ?> />
                                <span class="description"><?php _e('Disables loading the default CSS that comes with this plugin. This can be very useful if you want to create your own custom styling for BuddyPress elements.', 'gantry_bp'); ?></span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="disable_js"><?php _e('Disable JS', 'gantry_bp'); ?></label>
                            </th>
                            <td>
                                <input id="disable_js" name="gantry_bp_disable_js" type="checkbox" class="checkbox" value="1" <?php checked($disable_js, 1, true); ?> />
                                <span class="description"><?php _e('Disables the JavaScript for all BuddyPress elements.', 'gantry_bp'); ?></span>
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">
                                <label for="disable_buddybar"><?php _e('Disable BuddyBar', 'gantry_bp'); ?></label>
                            </th>
                            <td>
                                <input id="disable_buddybar" name="gantry_bp_disable_buddybar" type="checkbox" class="checkbox" value="1" <?php checked($disable_buddybar, 1, true); ?> />
                                <span class="description"><?php _e('Disables the BuddyBar (Admin Bar) on the front end.', 'gantry_bp'); ?></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p class="submit">
                    <input name="submit" id="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" type="submit" />
                </p>
            </form>
        </div>
    </div>
    
<?php
}

// Load CSS for the plugin settings page
function gantry_bp_settings_page_css() {
    global $gantry_bp_url, $pagenow;
    // Enqueue Style
    if($pagenow == 'plugins.php' && $_GET['page'] == 'gantry-buddypress') :
        wp_enqueue_style('gantry_bp_css', $gantry_bp_url.'/admin/admin.css');
    endif;
}

add_action('admin_print_styles', 'gantry_bp_settings_page_css');

// Adds an admin notice if WordPress version is older than 3.2
function gantry_bp_wp_version_notice() {
	global $wp_version;

	// if WP version is less than 3.2, show notice when on Gantry BuddyPress options page
	if ( isset( $_GET['page'] ) && 'gantry-buddypress' == $_GET['page'] ) {
		if (version_compare($wp_version, '3.2', '<')) {
		?>
			<div class="error">
				<p><?php _e("You're using an older version of WordPress.  Please upgrade to <strong>WordPress 3.2</strong> or newer, otherwise the javascript bundled with BuddyPress will cease to work with your WordPress theme.", 'gantry_bp'); ?></p>
			</div>
		<?php
		}

		return;
	}
}

add_action('admin_notices', 'gantry_bp_wp_version_notice');

// When Gantry BuddyPress is deactivated, remove a few options from the DB
function gantry_bp_deactivate() {
   delete_option('gantry_bp_disable_js');
   delete_option('gantry_bp_disable_css');
}

register_deactivation_hook(__FILE__, 'gantry_bp_deactivate');

// Adds a information nag that this plugin requires Gantry Framework plugin
// and a Gantry powered theme
function gantry_bp_admin_nag() {
    $msg = __('The Gantry BuddyPress plugin requires the Gantry Framework Plugin and Gantry powered theme to be installed and active', 'gantry_bp');
    echo "<div id='message' class='updated fade'><p>$msg</p></div>";
}

if (!is_gantry_active() || !is_gantry_theme()) {
    if(is_admin()) {
        add_action('admin_notices', 'gantry_bp_admin_nag');
    }
}

// Load translations for the plugin
function gantry_bp_load_languages() {
    global $gantry_bp_path;
    load_plugin_textdomain('gantry_bp', false, basename($gantry_bp_path).'/languages/');
}

add_action('plugins_loaded', 'gantry_bp_load_languages', 9);
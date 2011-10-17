<?php
/**
 * @version   1.0 October 15, 2011
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// Enable/Disable BuddyBar
function gantry_bp_disable_buddybar() {
    global $gantry;

    $disable_buddybar = get_option('gantry_bp_disable_buddybar');
    $css = 'body {padding-top: 0 !important;}';
    
    if($disable_buddybar && !is_admin()) {
        if(!defined('BP_DISABLE_ADMIN_BAR'))
            define('BP_DISABLE_ADMIN_BAR', true);
            $gantry->addInlineStyle($css);
    } else {
        if(defined('BP_DISABLE_ADMIN_BAR'))
            define('BP_DISABLE_ADMIN_BAR', false);
    }
}

add_action('init', 'gantry_bp_disable_buddybar');

// Remove BuddyPress "theme not compatible" nag
function gantry_bp_remove_buddypres_nag() {
    global $gantry;

    if (!defined('BP_SILENCE_THEME_NOTICE')) {
        define('BP_SILENCE_THEME_NOTICE', true);
    }
}

add_action('admin_init', 'gantry_bp_remove_buddypres_nag', 9);

// Filter the located template files
function gantry_bp_located_template_filter($returned, $templates) {
    global $gantry;

    foreach ($gantry->_contentTypePaths as $file_path) {
        $template_file = $file_path . DS . $templates[0];
        if(file_exists($template_file)) {
            $main_body_template = $template_file;
            break;
        }
    }

    $gantry->addTemp('buddypress', 'template_file', $main_body_template);

    return $main_body_template;
}

add_filter('bp_located_template', 'gantry_bp_located_template_filter', 10, 2);

function gantry_bp_finish_loading_templates($templates) {
    global $gantry;

    require_once( ABSPATH . WPINC . '/template-loader.php' );
    die;
}

add_filter('bp_load_template', 'gantry_bp_finish_loading_templates');

// Adds extra paths for Gantry to search for files
function gantry_bp_add_file_paths() {
    global $gantry, $gantry_bp_path;

    $overrides_plugin_path = $gantry_bp_path . '/html';
    $overrides_theme_path = $gantry->templatePath . '/buddypress';

    $gantry->addContentTypePath($overrides_plugin_path);
    $gantry->addContentTypePath($overrides_theme_path);
}

add_action('after_setup_theme', 'gantry_bp_add_file_paths');

// Search for override files in all given location, and include them when found
function gantry_bp_mainbody_include($main_body_template) {
    global $gantry;

    $bp_template_file = $gantry->retrieveTemp('buddypress', 'template_file');

    if($bp_template_file !== null) {
        $main_body_template = $bp_template_file;
    }
    return $main_body_template;
}

add_action('gantry_mainbody_include', 'gantry_bp_mainbody_include');

// Check for active BuddyPress component and skip Title gizmo if needed
function gantry_bp_check_component_title($title) {
    global $gantry, $bp;

    if(!empty($bp->current_component)) {
        return;
    } else {
        return $title;
    }
}

add_filter('gantry_title_gizmo', 'gantry_bp_check_component_title');

// Add the blog name to the BuddyPress modified page title
function gantry_bp_add_blog_name($title, $pagename, $sep) {
    global $gantry;

    $title = str_replace($sep, '|', $title);
    $title .= get_bloginfo('name');
    return $title;
}

add_filter('bp_modify_page_title', 'gantry_bp_add_blog_name', 10, 3);

// Add BuddyPress components types to the WP_Query
function gantry_bp_query_components() {
    global $wp_query, $bp;

    if ($bp->current_component != '') {
        $component = $bp->current_component;
        $component = 'is_bp_'.$component;
        $wp_query->$component = true;
    }
}

add_action('parse_query', 'gantry_bp_query_components');

// Add BuddyPress page types to the Assignements tab in the admin
function gantry_bp_add_page_type_to_admin($page_types) {
    $bp_page_types = array(
        'bp_profile' => __('BuddyPress Profile Component', 'gantry_bp'),
        'bp_activity' => __('BuddyPress Activity Component', 'gantry_bp'),
        'bp_blogs' => __('BuddyPress Blogs Component', 'gantry_bp'),
        'bp_messages' => __('BuddyPress Messages Component', 'gantry_bp'),
        'bp_friends' => __('BuddyPress Friends Component', 'gantry_bp'),
        'bp_groups' => __('BuddyPress Groups Component', 'gantry_bp'),
        'bp_settings' => __('BuddyPress Settings Component', 'gantry_bp')
    );
    $page_types = $page_types + $bp_page_types;
    return $page_types;
}

add_action('gantry_admin_page_types', 'gantry_bp_add_page_type_to_admin');

// Retrieve the name of the highest priority template file that exists
function gantry_bp_locate_type($template_names, $load = false, $require_once = true) {
    global $gantry;

    if (!is_array($template_names))
        return '';

    $located = '';
    foreach ($template_names as $template_name)
    {
        foreach ($gantry->getContentTypePaths() as $contentTypePath)
        {
            if (file_exists($contentTypePath . '/' . $template_name)) {
                $located = $contentTypePath . '/' . $template_name;
                break;
            }
        }
    }

    if ($load && '' != $located)
        gantry_bp_load_type($located, $require_once);

    return $located;
}

// Require the template file with WordPress environment.
function gantry_bp_load_type($_template_file, $require_once = true) {
    global $posts, $post, $wp_did_header, $wp_did_template_redirect, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    if (is_array($wp_query->query_vars))
        extract($wp_query->query_vars, EXTR_SKIP);

    if ($require_once)
        require_once($_template_file);
    else
        require($_template_file);
}

// Include the modified functions from the BuddyPress Template Pack plugin
include($gantry_bp_path . '/bpt-functions.php');
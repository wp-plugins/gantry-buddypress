<?php
/**
 * @version   1.0 October 15, 2011
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

// Sets up WordPress theme for BuddyPress support.
function gantry_bp_tpack_theme_setup() {
	global $bp, $gantry_bp_path;

	// Load the default BuddyPress AJAX functions if it isn't explicitly disabled
	require_once( $gantry_bp_path . '/_inc/ajax.php' );

	if ( !is_admin() ) {
		// Register buttons for the relevant component templates
		// Friends button
		if ( bp_is_active( 'friends' ) )
			add_action( 'bp_member_header_actions',    'bp_add_friend_button' );

		// Activity button
		if ( bp_is_active( 'activity' ) )
			add_action( 'bp_member_header_actions',    'bp_send_public_message_button' );

		// Messages button
		if ( bp_is_active( 'messages' ) )
			add_action( 'bp_member_header_actions',    'bp_send_private_message_button' );

		// Group buttons
		if ( bp_is_active( 'groups' ) ) {
			add_action( 'bp_group_header_actions',     'bp_group_join_button' );
			add_action( 'bp_group_header_actions',     'bp_group_new_topic_button' );
			add_action( 'bp_directory_groups_actions', 'bp_group_join_button' );
		}

		// Blog button
		if ( bp_is_active( 'blogs' ) )
			add_action( 'bp_directory_blogs_actions',  'bp_blogs_visit_blog_button' );
	}
}

add_action( 'after_setup_theme', 'gantry_bp_tpack_theme_setup', 11 );

// Enqueues BuddyPress JS and related AJAX functions
function gantry_bp_enqueue_scripts() {
	// Do not enqueue JS if it's disabled
	if (get_option('gantry_bp_disable_js'))
		return;

	// Add words that we need to use in JS to the end of the page so they can be translated and still used.
	$params = array(
		'my_favs'           => __( 'My Favorites', 'buddypress' ),
		'accepted'          => __( 'Accepted', 'buddypress' ),
		'rejected'          => __( 'Rejected', 'buddypress' ),
		'show_all_comments' => __( 'Show all comments for this thread', 'buddypress' ),
		'show_all'          => __( 'Show all', 'buddypress' ),
		'comments'          => __( 'comments', 'buddypress' ),
		'close'             => __( 'Close', 'buddypress' )
	);

	// BP 1.5+
	if ( version_compare( BP_VERSION, '1.3', '>' ) ) {
		// Bump this when changes are made to bust cache
		$version            = '20110818';

		$params['view']     = __( 'View', 'buddypress' );
	}

	// Enqueue the global JS - Ajax will not work without it
	wp_enqueue_script( 'dtheme-ajax-js', BP_PLUGIN_URL . '/bp-themes/bp-default/_inc/global.js', array( 'jquery' ), $version );

	// Localize the JS strings
	wp_localize_script( 'dtheme-ajax-js', 'BP_DTheme', $params );
}

add_action('wp_enqueue_scripts', 'gantry_bp_enqueue_scripts');

// Enqueues BuddyPress basic styles
function gantry_bp_enqueue_styles() {
    global $gantry_bp_url;

	// Do not enqueue CSS if it's disabled
	if (get_option( 'gantry_bp_disable_css' ))
		return;

	// BP 1.5+
	if ( version_compare( BP_VERSION, '1.3', '>' ) ) {
		$stylesheet = 'bp.css';

		// Bump this when changes are made to bust cache
		$version    = '20110918';
	}

	// Add the wireframe BP page styles
	wp_enqueue_style( 'bp', $gantry_bp_url . '/' . $stylesheet, array(), $version );

	// Enqueue RTL styles for BP 1.5+
	if ( version_compare( BP_VERSION, '1.3', '>' ) && is_rtl() )
		wp_enqueue_style( 'bp-rtl',  $gantry_bp_url . '/' . 'bp-rtl.css', array( 'bp' ), $version );
}

add_action('wp_print_styles', 'gantry_bp_enqueue_styles');

// Gantry BuddyPress plugin doesn't use bp-default's built-in sidebar login block,
// so during no access requests, we need to redirect them to wp-login for
// authentication.
if (!function_exists('gantry_bp_use_wplogin')) {
    function gantry_bp_use_wplogin() {
	    // returning 2 will automatically use wp-login
	    return 2;
    }

    add_filter('bp_no_access_mode', 'gantry_bp_use_wplogin' );
}

// Hooks into the 'bp_get_activity_action_pre_meta' action to add secondary activity avatar support
function gantry_bp_activity_secondary_avatars( $action, $activity ) {
	// sanity check - some older versions of BP do not utilize secondary activity avatars
	if ( function_exists( 'bp_get_activity_secondary_avatar' ) ) :
		switch ( $activity->component ) {
			case 'groups' :
			case 'friends' :
				// Only insert avatar if one exists
				if ( $secondary_avatar = bp_get_activity_secondary_avatar() ) {
					$reverse_content = strrev( $action );
					$position        = strpos( $reverse_content, 'a<' );
					$action          = substr_replace( $action, $secondary_avatar, -$position - 2, 0 );
				}
				break;
		}
	endif;

	return $action;
}

add_filter('bp_get_activity_action_pre_meta', 'gantry_bp_activity_secondary_avatars', 10, 2);
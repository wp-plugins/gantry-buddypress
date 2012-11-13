<?php
/**
 * @version   1.3 November 8, 2012
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 * BuddyPress - Users Profile
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php if ( bp_is_my_profile() ) : ?>

	<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
		<ul>

			<?php bp_get_options_nav(); ?>

		</ul>
	</div><!-- .item-list-tabs -->

<?php endif; ?>

<?php do_action( 'bp_before_profile_content' ); ?>

<div class="profile" role="main">

	<?php
		// Profile Edit
		if ( bp_is_current_action( 'edit' ) )
			gantry_bp_locate_type( array( 'members/single/profile/edit.php' ), true );

		// Change Avatar
		elseif ( bp_is_current_action( 'change-avatar' ) )
			gantry_bp_locate_type( array( 'members/single/profile/change-avatar.php' ), true );

		// Display XProfile
		elseif ( bp_is_active( 'xprofile' ) )
			gantry_bp_locate_type( array( 'members/single/profile/profile-loop.php' ), true );

		// Display WordPress profile (fallback)
		else
			gantry_bp_locate_type( array( 'members/single/profile/profile-wp.php' ), true );
	?>

</div><!-- .profile -->

<?php do_action( 'bp_after_profile_content' ); ?>
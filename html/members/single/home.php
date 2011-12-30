<?php
/**
 * @version   1.1 December 30, 2011
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2011 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
?>

<?php

/**
 * BuddyPress - Users Home
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_member_home_content' ); ?>

			<div id="item-header" role="complementary">

				<?php gantry_bp_locate_type( array( 'members/single/member-header.php' ), true ); ?>

			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
					<ul>

						<?php bp_get_displayed_user_nav(); ?>

						<?php do_action( 'bp_member_options_nav' ); ?>

					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">

				<?php do_action( 'bp_before_member_body' );

				if ( bp_is_user_activity() || !bp_current_component() ) :
					gantry_bp_locate_type( array( 'members/single/activity.php'  ), true );

				 elseif ( bp_is_user_blogs() ) :
					gantry_bp_locate_type( array( 'members/single/blogs.php'     ), true );

				elseif ( bp_is_user_friends() ) :
					gantry_bp_locate_type( array( 'members/single/friends.php'   ), true );

				elseif ( bp_is_user_groups() ) :
					gantry_bp_locate_type( array( 'members/single/groups.php'    ), true );

				elseif ( bp_is_user_messages() ) :
					gantry_bp_locate_type( array( 'members/single/messages.php'  ), true );

				elseif ( bp_is_user_profile() ) :
					gantry_bp_locate_type( array( 'members/single/profile.php'   ), true );

				elseif ( bp_is_user_forums() ) :
					gantry_bp_locate_type( array( 'members/single/forums.php'    ), true );

				elseif ( bp_is_user_settings() ) :
					gantry_bp_locate_type( array( 'members/single/settings.php'  ), true );

				// If nothing sticks, load a generic template
				else :
					gantry_bp_locate_type( array( 'members/single/plugins.php'   ), true );

				endif;

				do_action( 'bp_after_member_body' ); ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ); ?>

		</div><!-- .padder -->
	</div><!-- #content -->
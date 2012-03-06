<?php
/**
 * @version   1.2 January 12, 2012
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
?>

<?php

/**
 * BuddyPress - Users Messages
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>

		<?php bp_get_options_nav(); ?>

	</ul>
</div><!-- .item-list-tabs -->

<?php

	if ( bp_is_current_action( 'compose' ) ) :
		gantry_bp_locate_type( array( 'members/single/messages/compose.php' ), true );

	elseif ( bp_is_current_action( 'view' ) ) :
		gantry_bp_locate_type( array( 'members/single/messages/single.php' ), true );

	else :
		do_action( 'bp_before_member_messages_content' ); ?>

	<div class="messages" role="main">

		<?php
			if ( bp_is_current_action( 'notices' ) )
				gantry_bp_locate_type( array( 'members/single/messages/notices-loop.php' ), true );
			else
				gantry_bp_locate_type( array( 'members/single/messages/messages-loop.php' ), true );
		?>

	</div><!-- .messages -->

	<?php do_action( 'bp_after_member_messages_content' ); ?>

<?php endif; ?>

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
 * BuddyPress - Users Settings
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>
		<?php if ( bp_is_my_profile() ) : ?>
		
			<?php bp_get_options_nav(); ?>
		
		<?php endif; ?>
	</ul>
</div>

<?php

if ( bp_is_current_action( 'notifications' ) ) :
	 gantry_bp_locate_type( array( 'members/single/settings/notifications.php' ), true );

elseif ( bp_is_current_action( 'delete-account' ) ) :
	 gantry_bp_locate_type( array( 'members/single/settings/delete-account.php' ), true );

elseif ( bp_is_current_action( 'general' ) ) :
	gantry_bp_locate_type( array( 'members/single/settings/general.php' ), true );

else :
	gantry_bp_locate_type( array( 'members/single/plugins.php' ), true );

endif;

?>

<?php
/**
 * @version   1.3 November 8, 2012
 * @author    RocketTheme, LLC http://www.rockettheme.com
 * @copyright Copyright © 2007 - 2012 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */
?>

<?php get_header(); ?>

<?php do_action( 'template_notices' ); ?>

<div class="activity no-ajax" role="main">
	<?php if ( bp_has_activities( 'display_comments=threaded&show_hidden=true&include=' . bp_current_action() ) ) : ?>

		<ul id="activity-stream" class="activity-list item-list">
		<?php while ( bp_activities() ) : bp_the_activity(); ?>

			<?php gantry_bp_locate_type( array( 'activity/entry.php' ), true ); ?>

		<?php endwhile; ?>
		</ul>

	<?php endif; ?>
</div>

<?php get_footer(); ?>
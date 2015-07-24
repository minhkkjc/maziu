<?php
/**
 * @version    1.5
 * @package    Ferado
 * @author     WooRockets Team <support@woorockets.com>
 * @copyright  Copyright (C) 2014 WooRockets.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.woorockets.com
 */

if ( ! is_active_sidebar( 'bottom-1' ) && ! is_active_sidebar( 'bottom-2' ) && ! is_active_sidebar( 'bottom-3' ) && ! is_active_sidebar( 'bottom-4' ) ) {
	return;
}
?>

<div class="mid">
	<div class="container grid">
		<?php
		if ( is_active_sidebar( 'bottom-1' ) ) : ?>

			<div <?php wr_ferado_bottom_sidebar_class(); ?>>
				<?php dynamic_sidebar( 'bottom-1' ); ?>
			</div>

		<?php
		endif; 

		if ( is_active_sidebar( 'bottom-2' ) ) : ?>
			
			<div <?php wr_ferado_bottom_sidebar_class(); ?>>
				<?php dynamic_sidebar( 'bottom-2' ); ?>
			</div>

			<?php
		endif;

		if ( is_active_sidebar( 'bottom-3' ) ) : ?>

			<div <?php wr_ferado_bottom_sidebar_class(); ?>>
				<?php dynamic_sidebar( 'bottom-3' ); ?>
			</div>

			<?php
		endif;

		if ( is_active_sidebar( 'bottom-4' ) ) : ?>

			<div <?php wr_ferado_bottom_sidebar_class(); ?>>
				<?php dynamic_sidebar( 'bottom-4' ); ?>
			</div>

		<?php endif; ?>
	</div><!-- .container.grid -->
</div><!-- .mid -->

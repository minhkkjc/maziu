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

/**
 * Adds page layout classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
if ( ! is_post_type_archive( 'product' ) ) :
	function wr_ferado_page_layout_body_classes( $classes ) {

		global $post;

		if ( is_home() ) :
			$id = get_option( 'page_for_posts' );
		else :
			$id = get_the_ID();
		endif;

		$global_layout = wr_ferado_theme_option( 'wr_page_layout' );
		$page_layout   = ( function_exists( 'get_field' ) ) ? get_field( 'acf_page_layout', $id ) : '';

		switch ( $page_layout ) {
			case 'main':
				$classes[] = 'full-width';
				break;

			case 'left-main':
				$classes[] = 'left-content';
				break;

			case 'main-right':
				$classes[] = 'content-right';
				break;

			case 'left-main-right':
				$classes[] = 'left-content-right content3col';
				break;

			case 'left-right-main':
				$classes[] = 'left-right-content content3col';
				break;

			case 'main-left-right':
				$classes[] = 'content-left-right content3col';
				break;

			default:
				switch ( $global_layout ) {
					case 'main':
						$classes[] = 'full-width';
						break;

					case 'left-main':
						$classes[] = 'left-content';
						break;

					case 'main-right':
						$classes[] = 'content-right';
						break;

					case 'left-main-right':
						$classes[] = 'left-content-right content3col';
						break;

					case 'left-right-main':
						$classes[] = 'left-right-content content3col';
						break;

					case 'main-left-right':
						$classes[] = 'content-left-right content3col';
						break;

					default:
						$classes[] = 'full-width';
				}
		}

		return $classes;
	}
	add_filter( 'body_class', 'wr_ferado_page_layout_body_classes' );
endif;

/**
 * Output the primary sidebar if layout allows for it.
 *
 * @since 1.0
 */
function wr_ferado_get_sidebar_primary() {
	?>
	<div id="primary-sidebar" class="primary-sidebar" <?php wr_ferado_schema_metadata( array( 'context' => 'sidebar' ) ); ?>>
		<?php
		if ( is_active_sidebar( 'primary-sidebar' ) ) {
			dynamic_sidebar( 'primary-sidebar' );
		} else {
		?>
			<aside class="widget widget_text">
				<h3 class="widget-title"><?php _e( 'Primary Sidebar', 'ferado' ); ?></h3>
				<div class="textwidget">
					<?php
						printf(
							__( 'This is the Right Sidebar Area. You can add content to this area by visiting your %1$s and adding new widgets to this area.', 'ferado' ),
							'<a href="' . esc_url( admin_url( 'widgets.php', 'http' ) ) . '"><b>' . __( 'Widgets Panel', 'ferado' ) . '</b></a>'
						);
					?>
				</div>
			</aside>
		<?php } ?>
	</div>
<?php
}

/**
 * Output the secondary sidebar if layout allows for it.
 *
 * @since 1.0
 */
function wr_ferado_get_sidebar_secondary() {
	?>
	<div id="secondary-sidebar" class="secondary-sidebar" <?php wr_ferado_schema_metadata( array( 'context' => 'sidebar' ) ); ?>>
		<?php
		if ( is_active_sidebar( 'secondary-sidebar' ) ) {
			dynamic_sidebar( 'secondary-sidebar' );
		} else {
		?>
			<aside class="widget widget_text">
				<h3 class="widget-title"><?php _e( 'Secondary Sidebar', 'ferado' ); ?></h3>
				<div class="textwidget">
					<?php
						printf(
							__( 'This is the Left Sidebar Area. You can add content to this area by visiting your %1$s and adding new widgets to this area.', 'ferado' ),
							'<a href="' . esc_url( admin_url( 'widgets.php', 'http' ) ) . '"><b>' . __( 'Widgets Panel', 'ferado' ) . '</b></a>'
						);
					?>
				</div>
			</aside>
		<?php } ?>
	</div>
<?php
}
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

$logo_mgl = wr_ferado_theme_option( 'wr_logo_mgl' );
$logo_mgt = wr_ferado_theme_option( 'wr_logo_mgt' );
$style = array();
if ( ! empty( $logo_mgl ) ) {
	$style[] = 'margin-left: ' . trim( $logo_mgl ) . 'px';
}
if ( ! empty( $logo_mgt ) ) {
	$style[] = 'margin-top: ' . trim( $logo_mgt ) . 'px';
}
?>
<header id="masthead" class="site-header cl" <?php wr_ferado_schema_metadata( array( 'context' => 'header' ) ); ?>>

	<div class="header-top">
		<div class="container">
			<div class="top-info">
				<?php
					if ( is_user_logged_in() ) {
						echo sprintf( __( 'Welcome back, %s', 'ferado' ), wp_get_current_user()->display_name );
					} else {
						_e( 'Welcome, visitor!', 'ferado' );
					}
				?>
			</div><!-- .top-info -->
			<?php
				wp_nav_menu(
					array(
						'theme_location'  => 'top_menu',
						'container'       => 'nav',
						'container_class' => 'top-navigation',
						'menu_id'         => 'menu-top',
						'fallback_cb'     => '',
					)
				);
			?>
		</div><!-- .container -->
	</div><!-- .header-top -->
	
	<div class="header-bot">
		<div class="container">
			<div class="site-branding" style="<?php echo implode( ';', $style ); ?>">
				<?php wr_ferado_logo(); ?>
			</div><!-- .site-brading -->

			<div class="right-bot">
				<?php if ( wr_ferado_theme_option( 'wr_search_box' ) ) : ?>
					<div class="search-box">
						<i class="wr-icon-search"></i>
						<form class="search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input name="s" type="text" size="20" maxlength="20" placeholder="<?php echo esc_attr( wr_ferado_theme_option( 'wr_search_box_text' ) ); ?>" />
							<button type="submit" value=""><i class="wr-icon-search"></i></button>
						</form>
					</div><!-- .search-box -->
				<?php endif; ?>
				<?php
					if ( class_exists( 'Woocommerce' ) && wr_ferado_theme_option( 'wr_wcm_shop_cart' ) ) {
						wr_ferado_shoping_cart();
					}
				?>
			</div><!-- .right-bot -->

			<nav id="site-navigation" class="main-navigation" <?php wr_ferado_schema_metadata( array( 'context' => 'nav' ) ); ?>>
				<button class="menu-toggle"><i class="dashicons dashicons-menu"></i></button>
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'main_menu',
							'container'      => false,
							'menu_id'        => 'menu-main',
							'fallback_cb'    => '',
						)
					);
				?>
			</nav><!-- #site-navigation -->
		</div><!-- .container -->
	</div><!-- .header-bot -->

</header><!-- #masthead -->
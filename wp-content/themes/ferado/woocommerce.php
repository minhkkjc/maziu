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

get_header();
?>

	<section class="container <?php echo implode( '', wr_ferado_wcm_layout() ); ?>">
		<main id="main" class="shop-main" <?php wr_ferado_schema_metadata( array( 'context' => 'content' ) ); ?>>

			<?php woocommerce_content(); ?>

		</main><!-- #main -->

		<?php get_sidebar( 'wcm' ); ?>
		
	</section><!-- .container -->

<?php get_footer(); ?>

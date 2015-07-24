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
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" <?php wr_ferado_schema_metadata( array( 'context' => 'footer' ) ); ?>>

		<div class="top">
			<div class="container">
				<?php require_once get_template_directory() . '/inc/structure/breadcrumbs.php'; ?>
				<?php echo wr_ferado_social_channel(); ?>
			</div><!-- .container -->
		</div><!-- .top -->

		<?php get_sidebar( 'bottom' ); ?>

		<div class="bot">
			<div class="container">
				<div class="site-info">
					<?php echo sprintf( __( '%s', 'ferado' ), wr_ferado_theme_option( 'wr_copyright_text' ) ); ?>
				</div><!-- .site-info -->
				<div class="bot-right"><?php echo sprintf( __( '%s', 'ferado' ), wr_ferado_theme_option( 'wr_footer_right_text' ) ); ?></div>
			</div><!-- .container -->
		</div><!-- .bot -->

	</footer><!-- #colophon -->
</div><!-- #page -->
<a href="#" class="back-to-top"><i class="dashicons dashicons-arrow-up-alt2"></i></a>
<?php wp_footer(); ?>
</body>
</html>

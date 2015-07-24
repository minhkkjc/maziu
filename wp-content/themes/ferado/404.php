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

get_header(); ?>

	<section class="container">
		<main id="main" class="site-main" <?php wr_ferado_schema_metadata( array( 'context' => 'content' ) ); ?>>

			<section class="error-404">		
				<h2 class="error-title"><?php _e( 'Uh oh! Looks like something broke.', 'ferado' ); ?></h2>

				<div class="page-content">
					<h1><?php _e( '4<span></span>4', 'ferado' ); ?></h1>
					<h2 class="error-title"><?php _e( 'The page cannot be found', 'ferado' ); ?></h2>
					<p><?php _e( 'The page you are looking for might have been removed, had its name changed or is temporarily unavailable<br />Can\'t find what you need? Take a moment and do a search below!', 'ferado' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</section><!-- .container -->

<?php get_footer(); ?>

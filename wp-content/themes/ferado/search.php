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

	<header class="page-title">
		<div class="container">
			<h2><?php printf( __( 'Search Results for: %s', 'ferado' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
		</div><!-- .container -->
	</header><!-- .page-header -->

	<section class="container">
		<main id="main" class="site-main" <?php wr_ferado_schema_metadata( array( 'context' => 'content' ) ); ?>>

		<?php if ( have_posts() ) : ?>

			<?php
			/**
			 * Start the Loop
			 */
			while ( have_posts() ) : the_post();
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'content', 'search' );

			endwhile;

			wr_ferado_pagination();

		else :

			get_template_part( 'content', 'none' );

		endif;
		?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>

	</section><!-- .container -->

<?php get_footer(); ?>

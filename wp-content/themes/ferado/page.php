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
	<div class="page-title <?php echo wr_ferado_theme_option( 'wr_page_title_alignment' ); ?>">
		<div class="container">
			<h1 <?php wr_ferado_schema_metadata( array( 'context' => 'entry_title' ) ); ?>><?php echo get_the_title(); ?></h1>
		</div><!-- .container -->
	</div><!-- .page-title -->

	<section class="container">

		<main id="main" class="site-main" <?php wr_ferado_schema_metadata( array( 'context' => 'content' ) ); ?>>

			<?php
				/**
				 * Start the Loop
				 */
				while ( have_posts() ) : the_post();
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content-page.php and that will be used instead.
					 */
					get_template_part( 'content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template
					if ( wr_ferado_theme_option( 'wr_page_comments' ) ) {
						if ( comments_open() || '0' != get_comments_number() ) :
							comments_template();
						endif;
					}

				endwhile;
			?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>
		
	</section><!-- .container -->

<?php get_footer(); ?>

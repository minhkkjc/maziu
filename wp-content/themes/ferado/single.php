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

		<?php
			/**
			 * Start the Loop
			 */
			while ( have_posts() ) : the_post();
				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-single.php and that will be used instead.
				 */
				get_template_part( 'content', 'single' );

				?>

				<nav class="single-nav cl" role="navigation">
					<?php
						previous_post_link( '<div class="prev">%link</div>', _x( '<span class="meta-nav">&laquo;</span>&nbsp;%title', 'Previous post link', 'ferado' ) );
						next_post_link(     '<div class="next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&raquo;</span>', 'Next post link', 'ferado' ) );
					?>
				</nav><!-- .single-nav -->
				
				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			
			endwhile; // end of the loop. ?>

		</main><!-- #main -->

		<?php get_sidebar(); ?>

	</section><!-- .container -->

<?php get_footer(); ?>
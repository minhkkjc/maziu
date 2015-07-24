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

	<div class="page-title <?php echo wr_ferado_theme_option( 'wr_page_title_alignment' ); ?>">
		<div class="container">
			<h1>
				<?php
					if ( is_category() ) :
						single_cat_title();

					elseif ( is_tag() ) :
						single_tag_title();

					elseif ( is_author() ) :
						printf( __( 'Author: %s', 'ferado' ), '<span class="vcard">' . get_the_author() . '</span>' );

					elseif ( is_day() ) :
						printf( __( 'Day: %s', 'ferado' ), '<span>' . get_the_date() . '</span>' );

					elseif ( is_month() ) :
						printf( __( 'Month: %s', 'ferado' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'ferado' ) ) . '</span>' );

					elseif ( is_year() ) :
						printf( __( 'Year: %s', 'ferado' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'ferado' ) ) . '</span>' );

					elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) :
						_e( 'Galleries', 'ferado' );

					elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
						_e( 'Images', 'ferado' );

					elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
						_e( 'Videos', 'ferado' );

					elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
						_e( 'Quotes', 'ferado' );

					elseif ( is_tax( 'post_format', 'post-format-audio' ) ) :
						_e( 'Audios', 'ferado' );

					else :
						_e( 'Archives', 'ferado' );

					endif;
				?>
			</h1>
			<?php
				// Show an optional term description.
				$term_description = term_description();
				if ( ! empty( $term_description ) ) :
					printf( '<div class="taxonomy-description">%s</div>', $term_description );
				endif;
			?>
		</div><!-- .container -->
	</div><!-- .page-title -->

	<section class="container">
		<main id="main" class="site-main" <?php wr_ferado_schema_metadata( array( 'context' => 'content' ) ); ?>>

		<?php
			if ( have_posts() ) :

				/**
				 * Start the Loop
				 */
				while ( have_posts() ) : the_post();
					/**
					 * Run the loop for the search to output the results.
					 * If you want to overload this in a child theme then include a file
					 * called content.php and that will be used instead.
					 */
					get_template_part( 'content' );
				
				endwhile;

					wr_ferado_pagination();

			else :

				get_template_part( 'content', 'none' );

			endif;
		?>

		</main><!-- #main -->
		
		<div id="primary-sidebar" class="primary-sidebar" <?php wr_ferado_schema_metadata( array( 'context' => 'sidebar' ) ); ?>>
			<?php dynamic_sidebar( 'primary-sidebar' ); ?>
		</div>

	</section><!-- .container -->

<?php get_footer(); ?>

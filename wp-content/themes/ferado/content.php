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

$class = $layout = '';
if ( 'small_thumb' == wr_ferado_theme_option( 'wr_blog_layout' ) ) {
	$class = ' small-thumb';
}

// Get post layout for masonry layout
$post_layout = ( function_exists( 'get_field' ) ) ? get_field( 'acf_post_layout', $id ) : '';
if ( ! empty( $post_layout ) ) {
	$layout = ' large';
}

// Post format quote
$quote_author  = ( function_exists( 'get_field' ) ) ? get_field( 'quote_author', get_the_ID() ) : '';
$quote_link    = ( function_exists( 'get_field' ) ) ? get_field( 'author_quote_url', get_the_ID() ) : '';
$quote_content = ( function_exists( 'get_field' ) ) ? get_field( 'quote_content', get_the_ID() ) : '';

if ( ! empty( $quote_link ) ) {
	$url = $quote_link;
} else {
	$url = get_permalink();
}
?>

<article id="post-<?php the_ID(); ?>" class="<?php echo implode( ' ', get_post_class() ) . $class . $layout; ?>" <?php  wr_ferado_schema_metadata( array( 'context' => 'entry' ) ); ?>>

	<?php if ( has_post_format( 'quote') ) : ?>

		<div class="quote-content">
			<?php echo $quote_content; ?>
			<a class="more-link" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $quote_author ); ?></a>
		</div>

	<?php else :

		if ( 'small_thumb' == wr_ferado_theme_option( 'wr_blog_layout' ) ) :
	?>
		<?php get_template_part( 'post', 'format' ); ?>

		<div class="entry-content" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_content' ) ); ?>>
			<header class="entry-header">
				
				<h2 class="entry-title" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_title' ) ); ?>>
					<?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
				</h2>

				<div class="entry-meta">
					<?php wr_ferado_post_meta(); ?>
				</div><!-- .entry-meta -->

			</header><!-- .entry-header -->

			<?php
				// Output post content
				the_content( sprintf(
					__( 'Read More %s <span class="meta-nav">&raquo;</span>', 'ferado' ), 
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				// Post navigation
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'ferado' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php
		else : 
	?>

		<header class="entry-header">

			<?php get_template_part( 'post', 'format' ); ?>
			
			<h2 class="entry-title" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_title' ) ); ?>>
				<?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?>
			</h2>

			<div class="entry-meta">
				<?php wr_ferado_post_meta(); ?>
			</div><!-- .entry-meta -->

		</header><!-- .entry-header -->

		<div class="entry-content" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_content' ) ); ?>>
			<?php
				// Output post content
				the_content( sprintf(
					__( 'Read More %s <span class="meta-nav">&raquo;</span>', 'ferado' ), 
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );

				// Post navigation
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'ferado' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php
		endif;
	endif;
	?>
</article><!-- #post-## -->

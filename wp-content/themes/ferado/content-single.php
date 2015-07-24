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

<article id="post-<?php the_ID(); ?>" <?php post_class(); wr_ferado_schema_metadata( array( 'context' => 'entry' ) ); ?>>
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title" ' . wr_ferado_schema_metadata( array( 'context' => 'entry_title', 'echo' => false ) ) . '>', '</h2>' ); ?>

		<div class="entry-meta">
			<?php wr_ferado_post_meta(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content" <?php wr_ferado_schema_metadata( array( 'context' => 'entry_content' ) ); ?>>

		<?php
			// Get post formats
			get_template_part( 'post', 'format' );

			// Output post content
			the_content();
			
			// Post navigation
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'ferado' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php
			// Used between list items, there is a space after the comma
			$tags_list = get_the_tag_list( '', __( '', 'ferado' ) );

			if ( $tags_list ) :
		?>
			<span class="tags-links">
				<?php printf( __( '<i class="wr-icon-tags"></i>%1$s', 'ferado' ), $tags_list ); ?>
			</span>
		<?php endif; // End if $tags_list ?>

	</footer><!-- .entry-footer -->
</article><!-- #post -->

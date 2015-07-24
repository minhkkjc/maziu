<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

// Get related products by querying
$related = $product->get_related(12);

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => 12,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) :
	while ( $products->have_posts() ) : $products->the_post();
		global $post;
		$related_products[] = $post;
	endwhile;
endif;

?>

<div class="product-related">
	<h2><?php _e( 'Products Related', 'ferado' ); ?></h2>
		
		<ul class="products">
			<div class="related-item">
				<?php foreach ( $related_products as $post ) : setup_postdata( $post ); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endforeach; // end of the loop. ?>
			</div>
		</ul>

</div>
<?php
echo '<scr' . 'ipt>
		jQuery(document).ready(function (e) {
			var owl = e(".related-item");
			owl.owlCarousel({
				itemsCustom : [
					[0, 1],
					[540, 1],
					[600, 2],
					[768, 3],
					[1000, 3],
				],
				navigation : true,
				navigationText: [
					"<i class=\"dashicons dashicons-arrow-left-alt2\"></i>",
					"<i class=\"dashicons dashicons-arrow-right-alt2\"></i>"
				],
				pagination: false,
			});
		});
	</scr' . 'ipt>';
wp_reset_postdata();

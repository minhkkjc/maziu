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

/**
 * Change html output of archive product
 *
 * @since 1.0
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15 );

/**
 * Add social share bar to single products
 *
 * @see   wr_ferado_social_share()
 * @since 1.0
 */
add_action( 'woocommerce_single_product_summary', 'wr_ferado_social_share', 60 );

/**
 * Add shopcart menu to header
 *
 * @return  array
 */
if ( ! function_exists( 'wr_ferado_add_to_cart_fragment' ) ) {
	function wr_ferado_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start();
	?>
		<a class="cart-control" href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'ferado' ); ?>">
			<i class="dashicons dashicons-cart"></i>
			<span><?php echo esc_html( $woocommerce->cart->get_cart_contents_count() ); ?></span>
		</a>
	<?php
		$fragments['a.cart-control'] = ob_get_clean();
		return $fragments;
	}
	add_filter( 'add_to_cart_fragments', 'wr_ferado_add_to_cart_fragment' );
}

if ( ! function_exists( 'wr_ferado_shoping_cart' ) ) {
	function wr_ferado_shoping_cart() {
		global $woocommerce;

		$cart_total = apply_filters( 'add_to_cart_fragments' , array() );

		echo '<div class="shop-cart">';
		echo $cart_total['a.cart-control'];
		echo '<div class="shop-item">';
		echo '<div class="widget_shopping_cart_content"></div>';
		echo '</div>';
		echo '</div>';
	}
}

/**
 * Wishlist Button
 *
 * @return  array
 */
if ( ! function_exists( 'wr_ferado_wishlist_button' ) ) {
	function wr_ferado_wishlist_button() {

		global $product, $yith_wcwl;

		if ( class_exists( 'YITH_WCWL_UI' ) )  {
			$url          = $yith_wcwl->get_wishlist_url();
			$product_type = $product->product_type;
			$exists       = $yith_wcwl->is_product_in_wishlist( $product->id );
			$classes      = 'class="add_to_wishlist"';

			$html  = '<div class="yith-wcwl-add-to-wishlist">';
			    $html .= '<div class="yith-wcwl-add-button';  // the class attribute is closed in the next row
			    $html .= $exists ? ' hide" style="display:none;"' : ' show"';
			    $html .= '><a href="' . htmlspecialchars( $yith_wcwl->get_addtowishlist_url() ) . '" data-product-id="' . $product->id . '" data-product-type="' . $product_type . '" ' . $classes . ' ><i class="dashicons dashicons-heart"></i></a>';
			    $html .= '</div>';

			$html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a href="' . $url . '"><i class="dashicons dashicons-heart"></i></a></div>';
			$html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . $url . '"><i class="dashicons dashicons-heart"></i></a></div>';
			$html .= '<div style="clear:both"></div><div class="yith-wcwl-wishlistaddresponse"></div>';
			$html .= '</div>';

		return $html;
		}
	}
}

/**
 * Adds woocommerce layout classes to the woocommerce page.
 *
 * @param array $classes Classes for the woocommerce page.
 * @return array
 */
if ( ! function_exists( 'wr_ferado_wcm_layout' ) ) {
	function wr_ferado_wcm_layout() {
	
		$wcm_layout = wr_ferado_theme_option( 'wr_wcm_layout' );

		$classes = array();

		switch ( $wcm_layout ) {
			case 'main':
				$classes[] = 'wcm-full-width';
				break;

			case 'left-main':
				$classes[] = 'wcm-left-content';
				break;

			case 'main-right':
				$classes[] = 'wcm-content-right';
				break;
		}

		return $classes;
	}
}

/**
 * Register widget area for woocommerce.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 * @since Ferado 1.0
 */
if ( ! function_exists( 'wr_ferado_widgets_wcm_init' ) ) {
	function wr_ferado_widgets_wcm_init() {
		register_sidebar( array(
			'name'          => __( 'WooCommerce Sidebar', 'ferado' ),
			'id'            => 'wcm',
			'description'   => 'This is the woocommerce sidebar.',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
	add_action( 'widgets_init', 'wr_ferado_widgets_wcm_init' );
}

/**
 * Output the shop sidebar.
 *
 * @since 1.0
 */
if ( ! function_exists( 'wr_ferado_get_sidebar_woo' ) ) {
	function wr_ferado_get_sidebar_woo() {
		?>
		<div class="shop-sidebar" <?php wr_ferado_schema_metadata( array( 'context' => 'sidebar' ) ); ?>>
			<?php
			if ( is_active_sidebar( 'wcm' ) ) {
				dynamic_sidebar( 'wcm' );
			} ?>
		</div>
	<?php
	}
}

/**
 * Set WooCommerce image dimensions upon theme activation
 * @since 1.0
 */
if ( ! function_exists( 'wr_ferado_image_dimensions' ) ) {
	function wr_ferado_image_dimensions() {

		global $pagenow;
		if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
			return;
		}

		$catalog = array(
			'width'  => '270', // px
			'height' => '340', // px
			'crop'	 => 1
		);
		 
		$single = array(
			'width'  => '470', // px
			'height' => '520', // px
			'crop'	 => 1
		);
		$thumbnail = array(
			'width' 	=> '100', // px
			'height'	=> '100', // px
			'crop'		=> 1
		);
		 
		// Image sizes
		update_option( 'shop_catalog_image_size', $catalog ); // Product category thumbs
		update_option( 'shop_single_image_size', $single ); // Single product image
		update_option( 'shop_thumbnail_image_size', $thumbnail ); // Image gallery thumbs
	}
	add_action( 'after_switch_theme', 'wr_ferado_image_dimensions', 1 );
}
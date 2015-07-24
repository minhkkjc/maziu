<?php
/**
 * Single product short description
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;

?>
<div itemprop="description">
	<?php
	if ( ! apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ) {
		$content = $post->post_content;
		echo  wpautop( $content );
	} else {
		echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	}
	?>
</div>
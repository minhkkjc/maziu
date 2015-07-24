<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

$class = '';

if ( '0' == wr_ferado_theme_option( 'wr_wcm_list_product_layout' ) ) {
	$class = ' list-style';
}
?>
	<ul class="products <?php echo '' . $class; ?>">

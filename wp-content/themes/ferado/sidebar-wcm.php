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
 * Load the correct sidebar according to the woocommerce layout
 *
 * @since 1.0
 */
$wcm_layout = wr_ferado_theme_option( 'wr_wcm_layout' );

switch ( $wcm_layout ) {
	case 'main':
		$sidebars[] = '';
		break;

	case 'left-main':
		$sidebars[] = wr_ferado_get_sidebar_woo();
		break;

	case 'main-right':
		$sidebars[] = wr_ferado_get_sidebar_woo();
		break;

	default:
		$sidebars[] = '';

}

return $sidebars;
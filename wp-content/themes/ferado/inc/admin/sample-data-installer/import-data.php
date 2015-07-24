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

if ( empty( $data ) ) {
	return;
}

if ( isset( $data['skipped_plugins'] ) ) :
?>
<ul>
	<?php foreach ( $data['skipped_plugins'] as $plugin ) : ?>
	<li>
		<strong><?php echo esc_html( ( string ) $plugin['description'] ); ?></strong>
		-
		<?php echo esc_html( ( 'install' == ( string ) $plugin['state'] ) ? 'Plugin is not installed.' : 'Plugin is not updated.' ); ?>
		<a class="btn btn-mini" target="_blank" href="<?php echo esc_url( ( string ) $plugin['producturl'] ); ?>"><?php _e( 'Get it now', 'ferado' ); ?></a>
	</li>
	<?php endforeach; ?>
</ul>
<?php
endif;

if ( isset( $data['demo_assets'] ) ) :
	echo '<scr' . 'ipt type="text/javascript">window.wr_demo_assets = ' . json_encode( $data['demo_assets'] ) . ';</scr' . 'ipt>';
endif;

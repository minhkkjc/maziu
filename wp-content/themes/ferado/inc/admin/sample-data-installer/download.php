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

// Preset response
$response = array();

if ( ! empty( $data ) ) :

foreach ( $data as $type => $plugins ) :

if ( count( $plugins ) ) :

// Start output buffering
ob_start();
?>
<span class="wr-title">
<?php
if ( 'required' == $type ) {
	_e( 'Install required plugins.', 'ferado' );
} else {
	_e( 'For the best experience, it\'s strongly recommended for you to install following <strong>FREE</strong> plugins.', 'ferado' );
}
?>
</span>
<i class="wr-icon"></i>
<ul>
<?php
foreach ( $plugins as $plugin ) :

// Check plugin status
$show = ( string ) $plugin['state'] != 'installed';

if ( 'installed' == ( string ) $plugin['state'] && count( $plugin['dependencies'] ) ) {
	foreach ( $plugin['dependencies'] as $dependency ) {
		if ( 'installed' != ( string ) $dependency['state'] ) {
			$show = true;
		}
	}
}

if ( $show ) :

$class = 'label';

switch ( ( string ) $plugin['state'] ) {
	case 'install':
		$class .= ' label-success';
		$status = __( 'New Installation', 'ferado' );
	break;

	case 'update':
		$class .= ' label-warning';
		$status = __( 'Update', 'ferado' );
	break;

	case 'installed':
	default:
		$status = __( 'Installed', 'ferado' );
	break;
}
?>
	<li>
		<label class="wr-title">
<?php if ( 'required' == $type ) : ?>
			<input type="hidden" value="<?php echo esc_attr( ( string ) $plugin['name'] ); ?>" />
<?php else : ?>
			<input type="checkbox" value="<?php echo esc_attr( ( string ) $plugin['name'] ); ?>" checked="checked" <?php if ( 'install' != ( string ) $plugin['state'] ) echo 'disabled="disabled"'; ?> />
<?php
endif;

echo esc_html( ( string ) $plugin['description'] );
?>
		</label>
		<span class="<?php echo esc_attr( $class ); ?>"><?php echo esc_html( $status ); ?></span>
		<a href="javascript:void(0)" class="wr-plugin-details-toggle"><i class="wr-icon-plus"></i></a>
		<i class="wr-loading hide"></i>
		<p class="wr-plugin-details hide">
			<?php echo esc_html( ( string ) $plugin['productdesc'] ); ?>
			<a class="wr-read-more" target="_blank" href="<?php echo esc_url( ( string ) $plugin['producturl'] ); ?>"><?php _e( 'Read more...', 'ferado' ); ?></a>
		</p>
		<div class="wr-status alert alert-danger hide"></div>
<?php if ( count( $plugin['dependencies'] ) ) : ?>
		<ul class="wr-sample-data-plugin-dependencies">
<?php
foreach ( $plugin['dependencies'] as $dependency ) :

if ( 'installed' != ( string ) $dependency['state'] ) :
?>

			<li>
				<label class="checkbox wr-title">
					<input type="checkbox" value="<?php echo esc_attr( ( string ) $dependency['name'] ); ?>" checked="checked" disabled="disabled" />
					<?php echo esc_html( ( string ) $dependency['description'] ); ?>
				</label>
				<span class="label label-<?php if ( 'install' == ( string ) $dependency['state'] ) echo 'success'; else echo 'warning'; ?>">
					<?php ( 'install' == ( string ) $dependency['state'] ) ? _e( 'New Installation', 'ferado' ) :  _e( 'Update', 'ferado' ); ?>
				</span>
				<i class="wr-loading hide"></i>
				<div class="wr-status alert alert-danger hide"></div>
			</li>
<?php
endif;

endforeach;
?>
		</ul>
<?php endif; ?>
	</li>
<?php
endif;

endforeach;
?>
</ul>
<?php
$response[$type] = ob_get_clean();

endif;

endforeach;

endif;

// Check if we have plugins data
if ( count( $response ) ) {
	return $response;
}

return;

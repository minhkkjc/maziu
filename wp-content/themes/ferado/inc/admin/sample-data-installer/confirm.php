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
<div class="form-horizontal">
	<p>
		<?php
		printf(
			__( 'This installer will make your website looks the same as <a href="http://demo.woorockets.com/#%1$s" target="_blank">%2$s live demo website</a>.', 'ferado' ),
			str_replace( '-', '_', 'ferado' ),
			'<strong>' . $this->name . '</strong>'
		);
		?>
	</p>

	<div class="alert alert-warning">
		<span class="label label-danger"><?php _e( 'Important information', 'ferado' ); ?></span>
		<ul>
			<li><?php _e( 'Installing sample data will delete all data on this website.', 'ferado' ); ?></li>
			<li><?php _e( 'It is NOT recommended to install sample data on production website.', 'ferado' ); ?></li>
			<?php
			ob_start();

			TGM_Plugin_Activation::$instance->notices();

			if ( null != ob_get_clean() ) :
				printf(
					__( '<li class="message-tgma">WR Page Builder needs to be installed and activated. <b><a target="_blank" href="%1$s">Check now</a>!</b>.</li>', 'ferado' ),
					get_admin_url( '', 'themes.php?page=tgmpa-install-plugins', 'http' )
				);
			endif;
			?>
		</ul>
	</div>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-4 control-label"><?php _e( 'Install from', 'ferado' ); ?></label>
				<div class="col-sm-8">
					<label class="radio-inline">
						<input type="radio" name="install_from" value="woorockets_server" checked>
						<?php _e( 'WooRockets server', 'ferado' ); ?>
					</label>
					<label class="radio-inline">
						<input type="radio" name="install_from" value="downloaded_package">
						<?php _e( 'Downloaded package', 'ferado' ); ?>
					</label>
				</div>
			</div>
		</div>
	</div>

	<div class="checkbox">
		<label>
			<input name="agree" value="1" id="wr-confirm-agreement" type="checkbox" />
			<?php _e( 'I agree that installing sample data will delete all content on this website', 'ferado' ); ?>
		</label>
	</div>
</div>

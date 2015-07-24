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
<div id="wr-restore-original-data-confirmation" class="form-horizontal">
	<p>
		<?php _e( 'This process will restore the original data of your website.', 'ferado' ); ?>
	</p>
	<div class="alert alert-warning">
		<span class="label label-danger"><?php _e( 'Important information', 'ferado' ); ?></span>
		<ul>
			<li><?php _e( 'Restoring original data will delete all current data on this website.', 'ferado' ); ?></li>
			<li><?php _e( 'Plugins and demo assets installed by sample data installation will be removed.', 'ferado' ); ?></li>
		</ul>
	</div>

	<div class="checkbox">
		<label>
			<input name="agree" value="1" id="wr-confirm-agreement" type="checkbox" />
			<?php _e( 'I agree that restoring original data will delete all current content on this website', 'ferado' ); ?>
		</label>
	</div>
</div>

<div id="wr-restore-original-data-progress" class="hide">
	<p>
		<?php _e( 'There are several stages involved in the process. Please be patient.', 'ferado' ); ?>
	</p>
	<ul id="wr-restore-original-data-processes">
		<li id="wr-restore-original-data-import-data">
			<span class="wr-title"><?php _e( 'Restore original data.', 'ferado' ); ?></span>
			<i class="wr-loading"></i>
			<div class="wr-status alert alert-danger hide"></div>
		</li>
		<li id="wr-restore-original-data-demo-assets" class="hide">
			<span class="wr-title"><?php _e( 'Remove demo assets.', 'ferado' ); ?></span>
			<i class="wr-loading"></i>
			<div class="wr-status alert alert-danger hide"></div>
		</li>
		<?php if ( isset( $data ) && ! empty( $data ) ) : ?>
		<li id="wr-restore-original-data-installed-plugins" class="hide">
			<span class="wr-title"><?php _e( 'Delete installed plugins.', 'ferado' ); ?></span>
			<i class="wr-icon"></i>
			<ul>
				<?php foreach ( $data as $plugin ) : ?>
				<li class="hide">
					<label class="wr-title">
						<?php echo esc_html( $plugin['description'] ); ?>
					</label>
					<i class="wr-loading"></i>
					<div class="wr-status alert alert-danger hide"></div>
				</li>
				<?php endforeach; ?>
			</ul>
		</li>
		<?php endif; ?>
	</ul>
</div>

<div id="wr-install-sample-data-success-message" class="wr-success-message hide">
	<h3>
		<?php _e( 'Original data is successfully restored', 'ferado' ); ?>
	</h3>
	<p>
		<?php __( 'Congratulations, your website now looks the same as before.', 'ferado' ); ?>
	</p>
</div>

<div id="wr-install-sample-data-failure-message" class="wr-failure-message hide">
	<h3>
		<?php _e( 'Original data is not successfully restored', 'ferado' ); ?>
	</h3>

	<div class="wr-status alert alert-danger">
		<div class="wr-status-message"><?php _e( 'An unknown problem was occurred while restoring original data. Please try again later.', 'ferado' ); ?></div>
	</div>
</div>

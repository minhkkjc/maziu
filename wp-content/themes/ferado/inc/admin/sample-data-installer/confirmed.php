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

$upload_package = ( isset( $_GET['install_from'] ) && 'downloaded_package' == $_GET['install_from'] ) ? true : false;
?>
<p>
	<?php _e( 'There are several stages involved in the process. Please be patient.', 'ferado' ); ?>
</p>
<ul id="wr-install-sample-data-processes">
	<?php if ( ! $upload_package ) : ?>
	<li id="wr-install-sample-data-download-package">
		<span class="wr-title"><?php _e( 'Download sample data package.', 'ferado' ); ?></span>
		<i class="wr-loading"></i>
		<div class="wr-status alert alert-danger hide"></div>
	</li>
	<?php endif; ?>
	<li id="wr-install-sample-data-upload-package" class="hide">
		<span class="wr-title"><?php _e( 'Upload sample data SQL package.', 'ferado' ); ?></span>
		<i class="wr-loading"></i>
		<div class="wr-status alert alert-danger hide"></div>
	</li>
	<li id="wr-install-sample-data-required-plugins" class="hide"></li>
	<li id="wr-install-sample-data-optional-plugins" class="hide"></li>
	<li id="wr-install-sample-data-import-data" class="hide">
		<span class="wr-title"><?php _e( 'Install sample data.', 'ferado' ); ?></span>
	        <i class="wr-loading"></i>
	        <div class="wr-status alert alert-danger hide"></div>
	    </li>
	    <li id="wr-install-sample-data-upload-asset" class="hide">
	        <span class="wr-title"><?php _e('Upload sample data asset package.', 'ferado'); ?></span>
		<i class="wr-loading"></i>
		<div class="wr-status alert alert-danger hide"></div>
	</li>
	<li id="wr-install-sample-data-demo-assets" class="hide">
		<span class="wr-title"><?php _e( 'Download demo assets.', 'ferado' ); ?></span>
		<i class="wr-loading"></i>
		<span class="download-status"></span>
		<div class="progress">
			<div class="progress-bar" role="progressbar">
				<span class="percentage">0</span>%
			</div>
		</div>
	</li>
</ul>

<div id="wr-install-sample-data-manually" class="<?php if ( ! $upload_package ) echo 'hide'; ?>">
	<form action="<?php echo esc_url( admin_url( 'admin-ajax.php?action=wr-sample-data-installer&task=upload' ) ); ?>" enctype="multipart/form-data" method="post" target="wr-upload-sample-data">
		<ol>
			<li>
				<?php _e( 'Please download SQL package manually', 'ferado' ); ?>
				<a href="<?php echo esc_url( $data ); ?>" class="btn-download" target="_blank"><?php _e( 'Download File', 'ferado' ); ?></a>
			</li>
			<li>
				<?php _e( 'Select the downloaded SQL package to install', 'ferado' ); ?>
				<input name="package" type="file" value="" />
				<br />
				<span class="wr-status alert alert-danger hide"><?php _e( 'Please select the downloaded sample data package.', 'ferado' ); ?></span>
			</li>
		</ol>
	</form>
	<?php echo '<ifr' . 'ame src="about:blank" class="hide" id="wr-upload-sample-data" name="wr-upload-sample-data"></ifra' . 'me>'; ?>
</div>

<div id="wr-install-sample-data-manually-upload" class="hide">
    <form action="<?php echo esc_url( admin_url('admin-ajax.php?action=wr-sample-data-installer&task=upload-asset' ) ); ?>" enctype="multipart/form-data" method="post" target="wr-upload-sample-assets">
        <p>3. <?php _e( 'Please download sample assets manually', 'ferado' ); ?> <a href="http://www.woorockets.com/files/sampleasset/ferado_sample_assets.zip" class="btn-download" target="_blank"><?php _e( 'Download File', 'ferado' ); ?></a></p>
        <p>4. <?php _e('Select the downloaded sample assets package to install', 'ferado'); ?></p>
        <input name="package" type="file" value="" />
        <br />
        <span class="wr-status alert alert-danger hide"><?php _e( 'Please select the downloaded sample assets package.', 'ferado' ); ?></span>
    </form>
    <?php echo '<ifr' . 'ame src="about:blank" class="hide" id="wr-upload-sample-data-upload" name="wr-upload-sample-assets"></ifra' . 'me>'; ?>
</div>

<div id="wr-install-sample-data-success-message" class="wr-success-message hide">
	<h3>
		<?php _e( 'Sample data is successfully installed', 'ferado' ); ?>
	</h3>
	<p>
		<?php
		printf(
			__( 'Congratulations, your website now looks the same as <a href="http://demo.woorockets.com/#%1$s" target="_blank">%2$s live demo website</a>.', 'ferado' ),
			str_replace( '-', '_', 'ferado' ),
			'<strong>' . $this->name . '</strong>'
		);
		?>
	</p>

	<div class="wr-status alert alert-danger hide">
		<h4>
			<?php _e( 'Attention!', 'ferado' ); ?>
		</h4>
		<p>
			<?php _e( 'Sample data for following plugins could NOT be installed:', 'ferado' ); ?>
		</p>

		<div class="wr-status-message"></div>
	</div>
</div>

<div id="wr-install-sample-data-failure-message" class="wr-failure-message hide">
	<h3>
		<?php _e( 'Sample data is not successfully installed', 'ferado' ); ?>
	</h3>

	<div class="wr-status alert alert-danger">
		<div class="wr-status-message"><?php _e( 'An unknown problem was occurred while installing sample data. Please try again later.', 'ferado' ); ?></div>
	</div>
</div>

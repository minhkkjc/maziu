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

get_header();
?>
	<div class="page-offline">
		<header>
			<h3><?php echo wr_ferado_theme_option( 'wr_maintenance_mode_message' ); ?></h3>
			<img src="<?php echo get_template_directory_uri() . '/assets/img/icons/under.png' ?>" />
			<ul class="countdown"></ul>
		</header>
		<footer>
			<?php echo wr_ferado_social_channel(); ?>
		</footer>
	</div>
	<?php echo '<scr' . 'ipt>' ?>
	( function( $ ) {
		"use strict";
		$(document).ready(function() {
			var endDate = "<?php echo wr_ferado_theme_option( 'wr_maintenance_mode_timer' ); ?>";
			$( ".countdown" ).countdown({
				date: endDate,
				render: function(data) {
					$(this.el).html("<li>" + this.leadingZeros(data.years, 2) + " <span>years</span></li><li>" + this.leadingZeros(data.days, 3) + " <span>days</span></li><li>" + this.leadingZeros(data.hours, 2) + " <span>hours</span></li><li>" + this.leadingZeros(data.min, 2) + " <span>min</span></li><li>" + this.leadingZeros(data.sec, 2) + " <span>sec</span></li>");
				}
			});
		});
	})(jQuery);
	<?php echo '</scr' . 'ipt>' ?>
<?php get_footer(); ?>
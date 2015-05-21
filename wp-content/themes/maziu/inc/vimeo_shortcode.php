<?php 
	function vimeo_shortcode($atts, $content)
	{
		$a = shortcode_atts(array(
			'width' => 730,
			'height' => 410,
			'autoplay' => 0,
			'color' => '00adef',
			'portrait' => 0,
		), $atts);
		
		ob_start();
		?>
		
		<div class="vimeo-wrap">
			<iframe src="//player.vimeo.com/video/<?php echo $content; ?>?portrait=<?php echo $a['portrait']; ?>&color=<?php echo $a['color']; ?>" 
				width="<?php echo $a['width']; ?>" 
				height="<?php echo $a['height']; ?>" 
				frameborder="0" 
				webkitallowfullscreen mozallowfullscreen allowfullscreen>
			</iframe>
		</div>
		
		<?php
		return ob_get_clean();
	}
	add_shortcode('vimeo', 'vimeo_shortcode');
?>
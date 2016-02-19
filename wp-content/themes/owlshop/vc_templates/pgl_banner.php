<?php 
extract(shortcode_atts(array(
    'title' => '',
    'desc' => '',
    'css' => '',
), $atts));

?>

<div class="banner-element <?php echo vc_shortcode_custom_css_class($css, ' '); ?>">
	<h2><?php echo wp_kses_post($title); ?></h2>
	<p><?php echo wp_kses_post($desc); ?></p>
</div>
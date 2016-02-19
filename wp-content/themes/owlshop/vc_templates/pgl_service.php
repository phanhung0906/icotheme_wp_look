<?php 
extract(shortcode_atts(array(
    'title' => '',
    'desc' => '',
    'icon' => '',
), $atts));

?>
<div class="pgl-service">
    <div class="service-icon">
    	<i class="fa <?php echo esc_attr($icon); ?>"></i>
    </div>
    <div class="service-name"><?php echo wp_kses_post($title); ?></div>
    <div class="service-text"><?php echo wp_kses_post($desc); ?></div>
</div>
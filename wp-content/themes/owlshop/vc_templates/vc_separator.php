<?php
extract(shortcode_atts(array(
    'el_width' => '',
    'style' => '',
    'color' => '',
    'accent_color' => '',
    'el_class' => ''
), $atts));

?>

<div class="divider <?php echo esc_attr($el_class); ?>"></div>
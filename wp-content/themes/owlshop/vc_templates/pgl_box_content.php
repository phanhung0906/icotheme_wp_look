<?php
$output = $el_class = $css_animation = '';

extract(shortcode_atts(array(
    'el_class' => '',
    'bg_box' => '#000',
    'css' => '',
    'tex_color' => '#fff'
), $atts));

$el_class = $this->getExtraClass($el_class);
$content = wpb_js_remove_wpautop($content, true);

$style = ' style="background-color:'.$bg_box.';background-color:rgba('.owlshop_hex2rgb($bg_box).',0.9);color:'.$tex_color.';"';

?>
<div class="pgl-box-content<?php echo esc_attr($el_class); ?>"<?php echo esc_attr($style); ?>>
	<div class="pgl-box-content-inner">
		<?php echo wp_kses_post($content); ?>
	</div>
</div>
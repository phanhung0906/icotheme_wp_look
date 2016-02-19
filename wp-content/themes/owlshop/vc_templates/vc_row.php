<?php
$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'fullwidth'       => '',
    'parallax'        => '',
    'css'             => '',
    'rowsm'           => '',
    'footer_css'      => ''
), $atts));
wp_enqueue_script( 'wpb_composer_front_js' );

$footer_class='';
if($footer_css!=''){
    $footer_class = ' '.vc_shortcode_custom_css_class( $footer_css, ' ' );
    echo '<style>'.$footer_css.'</style>';
}
$row_sm = ($rowsm) ? ' row-sm' : '';

$is_parallax = ($parallax)?' data-stellar-background-ratio="0.6"':'';
$el_class = $this->getExtraClass($el_class).$footer_class;
$parallax = ($parallax) ? ' parallax' : '';
$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);

$output = '';

if($this->settings('base')==='vc_row'){
    $output.='<div class="section-element'.$el_class.$parallax.vc_shortcode_custom_css_class($css, ' ').'" '.$style.$is_parallax.'>';
        $output .= ($fullwidth) ? '<div class="row-full-inner">' : '<div class="container">';
            $output .= '<div class="row'.$row_sm.'">';
                $output .= wpb_js_remove_wpautop($content);
            $output .= '</div>'.$this->endBlockComment('row');
        $output .= ($fullwidth) ? '</div>' : '</div>';
    $output.='</div>';
}else{
    $output.='<div class="section-element'.$el_class.$parallax.vc_shortcode_custom_css_class($css, ' ').'" '.$style.$is_parallax.'>';
        $output .= '<div class="row'.$row_sm.'">';
            $output .= wpb_js_remove_wpautop($content);
        $output .= '</div>'.$this->endBlockComment('row');
    $output.='</div>';
}


echo $output;
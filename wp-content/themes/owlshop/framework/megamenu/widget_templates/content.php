<?php


$add_class = (esc_attr($atts['class'])=='')?'':' '.esc_attr( $atts['class'] );

?>

<div class="content <?php echo esc_attr( $add_class ); ?>">
    <?php echo do_shortcode(stripslashes($atts['content'])); ?>
</div>
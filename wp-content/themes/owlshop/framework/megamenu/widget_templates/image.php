<?php
    extract($atts);
    $link_start = $link_end = '';
    if($link!=''){
    	$link_start = '<a href="'.esc_url( $link ).'">';
    	$link_end = '</a>';
    }
?>

<div class="widget-image <?php echo esc_attr( $class ); ?>">
    <?php echo wp_kses_post($link_start.wp_get_attachment_image($image,'full').$link_end); ?>
</div>
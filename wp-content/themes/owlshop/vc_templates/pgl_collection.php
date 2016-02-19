<?php

extract(shortcode_atts(array(
    'title' => '',
    'image' => '',
    'link' => '#',
    'el_class' => '',
    'text_link' => 'Shop Now',
    'bg_text_link' => '#000',
), $atts));
$style = ' style="background-color:'.$bg_text_link.';background-color:'.$bg_text_link.';"';
$img_id = preg_replace('/[^\d]/', '', $image);
$img = wpb_getImageBySize(array( 'attach_id' => $img_id, 'thumb_size' => 'full', 'class' => 'img-responsive' ));
$el_class = $this->getExtraClass($el_class);
?>
<div class="collection-item<?php echo esc_attr($el_class); ?>">
    <a href="<?php echo esc_url($link); ?>">
        <?php echo wp_kses_post($img['thumbnail']); ?>
    </a>
    <div class="collection-description"<?php echo esc_attr($style) ; ?>>
        <?php if($title!=''){ ?>
        <h3><?php echo wp_kses_post($title); ?></h3>
        <?php } ?>
        <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html($text_link); ?></a>
    </div>
</div>
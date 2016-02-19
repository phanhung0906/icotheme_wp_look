<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = $position = '';
extract(shortcode_atts(array(
    'color' => 'btn-default',
    'size' => '',
    'icon' => '',
    'target' => '_self',
    'href' => '',
    'el_class' => '',
    'title' => __('Text on the button', 'owlshop'),
    'position' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

?>
<a target="<?php echo esc_attr($target); ?>"<?php echo ($href!='')?' href="'.esc_url($href).'"':''; ?> class="btn <?php echo esc_attr($color.$el_class); ?><?php echo ($size!='')?' '.$size:''; ?>">
    <?php if($icon!=''){ ?>
        <i class="<?php echo esc_attr($icon); ?>"></i>
    <?php } ?>
    <?php echo esc_html($title); ?>
</a>

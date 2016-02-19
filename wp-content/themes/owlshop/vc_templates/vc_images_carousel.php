<?php
$output = $title =  $onclick = $custom_links = $img_size = $custom_links_target = $images = $el_class = $partial_view = '';
$mode = $slides_per_view = $wrap = $autoplay = $hide_pagination_control = $hide_prev_next_buttons = $speed ='';
extract(shortcode_atts(array(
    'title' => '',
    'onclick' => 'link_image',
    'custom_links' => '',
    'custom_links_target' => '',
    'img_size' => 'thumbnail',
    'images' => '',
    'el_class' => '',
    'mode' => 'horizontal',
    'slides_per_view' => '1',
    'wrap' => '',
    'autoplay' => '',
    'hide_pagination_control' => false,
    'hide_prev_next_buttons' => false,
    'speed' => '5000',
    'partial_view' => ''
), $atts));
$el_class = $this->getExtraClass($el_class);
$_id = owlshop_make_id();
$images = explode(",", $images);
?>
<div id="pgl-carousel-<?php echo esc_attr($_id); ?>" class="carousel slide <?php echo esc_attr($el_class); ?>" data-ride="carousel">

    <div class="carousel-inner">
        <?php foreach ($images as $key => $value): ?>
            <?php $img = wp_get_attachment_image_src($value,'full'); ?>
        <div class="item <?php echo ($key==0)?"active":""; ?>">
            <img src="<?php echo esc_url($img[0]); ?>">
        </div>
        <?php endforeach ?>
    </div>
    <?php if(!$hide_pagination_control){ ?>
    <ol class="carousel-indicators">
        <?php for($i=0;$i<count($images);$i++){ ?>
        <li data-target="#pgl-carousel-<?php echo esc_attr($_id); ?>" data-slide-to="<?php echo esc_attr($i); ?>" class="<?php echo ($i==0)?"active":""; ?>"></li>
        <?php } ?>
    </ol>
    <?php } ?>
    
    <?php if(!$hide_prev_next_buttons){ ?>
    <a class="left carousel-control" href="#pgl-carousel-<?php echo esc_attr($_id); ?>" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#pgl-carousel-<?php echo esc_attr($_id); ?>" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
    <?php } ?>
</div>

<?php global $product; ?>
<?php 
    $class = '';
    if(isset($is_animate) && $is_animate){
        $class = ' wow fadeInUp';
    }
    if(!isset($delay)){
        $delay = 0;
    }
?>
<div class="item-product-widget clearfix<?php echo esc_attr($class); ?>" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($delay); ?>ms">
    <div class="images pull-left">
        <?php echo wp_kses_post($product->get_image()); ?>
    </div>
    <div class="product-meta">
        <div class="product-title separator">
            <a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
                <?php echo esc_html($product->get_title()); ?>
            </a>
        </div>
        <?php if($show_rating){ ?>
        <div class="separator">
            <?php if ( $rating_html = $product->get_rating_html() ) { ?>
            <?php echo wp_kses_post($rating_html); ?>
            <?php } else { ?>
                <div class="star-rating"></div>
            <?php } ?>
        </div>
        <?php }else{ ?>
        <div class="category separator">
            <?php echo wp_kses_post($product->get_categories( ', ')); ?>
        </div>
        <?php } ?>
        <div class="price separator">
            <?php echo wp_kses_post($product->get_price_html()); ?>
        </div>
        
    </div>
</div>
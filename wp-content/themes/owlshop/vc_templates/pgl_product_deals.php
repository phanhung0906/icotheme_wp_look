<?php

extract(shortcode_atts(array(
    'el_class' => ''
), $atts));

$el_class = $this->getExtraClass($el_class);

$loop = owlshop_woocommerce_query('deals',1);

$_id = owlshop_make_id();

   
?>

<div class="woocommerce<?php echo esc_attr($el_class); ?>">
    <div class="inner-content">  
            <?php
            if ( $loop->have_posts() ) : 
                while ( $loop->have_posts() ) : $loop->the_post(); 
                    wc_get_template_part( 'content', 'product-deals' );
                endwhile;
            endif;
        ?>
    </div>
</div>
<?php wp_reset_postdata(); ?>

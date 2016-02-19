
    <?php
    extract($atts);

    $deals = array();
    $loop = owlshop_woocommerce_query('deals',$number);
    
    $_id = owlshop_make_id();

   
    ?>

<div class="woocommerce">
    <div class="inner-content">   
        <?php if($title!=''){ ?>
            <h3 class="widget-title">
                <span><?php echo esc_html($title); ?></span>
            </h3>
        <?php } ?>
        <?php 
            if ( $loop->have_posts() ) : 
                while ( $loop->have_posts() ) : $loop->the_post(); global $product;
                    
                    $time_sale = get_post_meta( $product->id, '_sale_price_dates_to', true );

                    ?>
                        <div class="product-block product-grid product">
                            <div class="product-image">
                                <div class="image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php
                                            /**
                                             * woocommerce_before_shop_loop_item_title hook
                                             *
                                             * @hooked woocommerce_show_product_loop_sale_flash - 10
                                             * @hooked woocommerce_template_loop_product_thumbnail - 10
                                             */
                                            do_action( 'woocommerce_before_shop_loop_item_title' );

                                        ?>
                                    </a>
                                    <div class="button-groups">
                                        <div class="button-item clearfix">
                                            <?php do_action('woocommerce_after_shop_loop_item'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pull-right">
                                <?php woocommerce_template_loop_rating(); ?>
                            </div>
                            <h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            
                            <div class="product-meta">
                                <?php woocommerce_template_loop_price(); ?>
                                <div class="pgl-count-down">
                                    <script type="text/javascript">
                                        var count_down_<?php echo esc_attr($_id); ?> = new Countdown({
                                                            year    : <?php echo date('Y',$time_sale) ?>,
                                                            month   : <?php echo date('m',$time_sale) ?>, 
                                                            day     : <?php echo date('d',$time_sale) ?>,
                                                            width   : 300, 
                                                            height  : 50,
                                                            rangeHi: "day",
                                                            labelText   : {
                                                               second : "<?php _e('secs','owlshop'); ?>",
                                                               minute : "<?php _e('mins','owlshop'); ?>",
                                                               hour     : "<?php _e('hours','owlshop'); ?>",
                                                               day      : "<?php _e('days','owlshop'); ?>",
                                                            },  
                                                        });
                                    </script>
                                </div>
                            </div>
                        </div>                
                    <?php
                    continue;
                endwhile;
            endif;
        ?>
    </div>
</div>
<?php wp_reset_postdata(); ?>

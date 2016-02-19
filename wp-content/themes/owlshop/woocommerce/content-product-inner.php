<?php

global $product;
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
		</div>
        <div class="button-groups woocommerce-action">
            <div class="button-item clearfix">
                <?php do_action( 'pgl_woocommerce_button_action' ); ?>
            </div>
        </div>
	</div>
    
    <h4 class="name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
    
    <div class="product-meta">
        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook
         *
         * @hooked woocommerce_template_loop_rating - 5
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action('woocommerce_after_shop_loop_item_title');
        ?>
    </div>
    
    <?php do_action('woocommerce_after_shop_loop_item'); ?>
    
</div>
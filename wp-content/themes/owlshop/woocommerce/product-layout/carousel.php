<?php
	$_delay = 200;
?>
<div class="row">
	<div data-owl="slide" data-text-next="<?php _e('Next','owlshop') ?>" data-text-prev="<?php _e('Prev','owlshop') ?>" data-item-slide="<?php echo esc_attr($columns_count); ?>" data-ow-rtl="<?php echo is_rtl()?'true':'false'; ?>" class="owl-carousel owl-theme product-slide">
		<?php while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
			<div class="col-md-12 wow fadeInUp" data-wow-duration="1s" data-wow-delay="<?php echo esc_attr($_delay); ?>ms">
				<?php 
					if( isset($is_deals) && $is_deals ){
						wc_get_template_part( 'content', 'product-deals' );
					}else{
						wc_get_template_part( 'content', 'product-inner' );
					}
				?>
			</div>
			<?php $_delay+=300; ?>
		<?php endwhile; ?>
	</div>
</div>

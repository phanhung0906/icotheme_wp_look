<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product, $post;
$attribute_keys = array_keys( $attributes );
?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart form-horizontal" method="post" enctype='multipart/form-data' data-product_id="<?php echo esc_attr($post->ID); ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<div class="variations clearfix">
			<?php $loop = 0; foreach ( $attributes as $attribute_name => $options ) : $loop++; ?>
				<?php $_id = esc_attr( sanitize_title( $attribute_name ) ); ?>
				<div class="form-group">
					<label for="<?php echo esc_attr($_id); ?>" class="col-sm-2 control-label"><?php echo wc_attribute_label( $attribute_name ); ?></label>
					<div class="col-sm-10">
					  	<?php
								$selected = isset( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) ? wc_clean( $_REQUEST[ 'attribute_' . sanitize_title( $attribute_name ) ] ) : $product->get_variation_default_attribute( $attribute_name );
								wc_dropdown_variation_attribute_options( array( 'options' => $options, 'attribute' => $attribute_name,'class'=> 'form-control', 'product' => $product, 'selected' => $selected ) );
								
							?>
					</div>
				</div>
			<?php
				echo end( $attribute_keys ) === $attribute_name ? '<a class="reset_variations btn btn-default btn-sm pull-right" href="#">' . __( 'Clear selection', 'woocommerce' ) . '</a>' : '';
							
	       endforeach;?>
	    </div>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap clearfix" style="display:none;">
			<?php
				/**
				 * woocommerce_before_single_variation Hook
				 */
				do_action( 'woocommerce_before_single_variation' );

				/**
				 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
				 * @since 2.4.0
				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
				 */
				do_action( 'woocommerce_single_variation' );

				/**
				 * woocommerce_after_single_variation Hook
				 */
				do_action( 'woocommerce_after_single_variation' );
			?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

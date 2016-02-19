<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability = $product->get_availability();

	if ( $availability['availability'] )
		echo apply_filters( 'woocommerce_stock_html', '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>', $availability['availability'] );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>
		<div class="clearfix cart-inner">
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		 	<?php
		 		if ( ! $product->is_sold_individually() )
		 			woocommerce_quantity_input( array(
		 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
		 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
		 			) );
		 	?>

		 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />

		 	<button type="submit" class="button btn-cart add_to_cart single_add_to_cart_button"> <i class="fa fa-shopping-cart"></i>  <?php echo esc_html($product->single_add_to_cart_text()); ?></button>
			<?php if(class_exists('YITH_WCWL')){ ?>
			<a href="#" class="button btn-wishlist">
				<i class="fa fa-heart-o"></i>
			</a>
			<?php } ?>
			<?php if(class_exists( 'YITH_Woocompare' )){ ?>
			<a href="#" class="button btn-compare">
				<i class="fa fa-exchange"></i>
			</a>
			<?php } ?>
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</div>
	</form>
	<div class="clearfix"></div>
	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
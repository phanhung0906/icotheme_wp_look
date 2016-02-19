<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php

global $woocommerce, $yith_wcwl;

if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) {
wc_print_notices();
} else {
$woocommerce->show_messages();
}
?>
<div class="row">
	<div class="my-account-left col-sm-3">
	
		<div class="list-group my-account-group">
			<a href="#my-orders" class="active list-group-item" data-toggle="tab"><?php _e("My Orders", 'owlshop'); ?></a>
			<?php if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) { ?>
				<?php if ( $downloads = WC()->customer->get_downloadable_products() ) { ?>
					<a href="#my-downloads" class="list-group-item" data-toggle="tab"><?php _e("My Downloads", 'owlshop'); ?></a>
				<?php } ?>
			<?php } else { ?>
				<?php if ( $downloads = $woocommerce->customer->get_downloadable_products() ) { ?>
					<a href="#my-downloads" class="list-group-item" data-toggle="tab"><?php _e("My Downloads", 'owlshop'); ?></a>
				<?php } ?>
			<?php } ?>
			<?php if ( class_exists( 'YITH_WCWL_UI' ) ) { ?>
			<a href="<?php echo esc_url($yith_wcwl->get_wishlist_url()); ?>" class="list-group-item"><?php _e("My Wishlist", 'owlshop'); ?></a>
			<?php } ?>
			<a href="#address-book" class="list-group-item" data-toggle="tab"><?php _e("Address Book", 'owlshop'); ?></a>
			<?php if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) { ?>
			<a href="<?php echo esc_url(wc_customer_edit_account_url()); ?>" class="list-group-item"><?php _e("Change Password", 'owlshop'); ?></a>
			<?php } else { ?>
			<a href="#change-password" class="list-group-item" data-toggle="tab"><?php _e("Change Password", 'owlshop'); ?></a>
			<?php } ?>
			<a href="<?php echo esc_url(wp_logout_url()); ?>" class="list-group-item"><?php _e('Logout','owlshop') ?></a>
		</div>

	</div>

	<?php if ( version_compare( WOOCOMMERCE_VERSION, "2.1.0" ) >= 0 ) { ?>
	<div class="col-sm-9">
		<div class="my-account-right tab-content">
			
			<?php do_action( 'woocommerce_before_my_account' ); ?>
			
			<div class="tab-pane active" id="my-orders">
			
			<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
			
			</div>
			
			<?php if ( $downloads = $woocommerce->customer->get_downloadable_products() ) { ?>
			
			<div class="tab-pane" id="my-downloads">
			
			<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>
			
			</div>
			
			<?php } ?>
			
			<div class="tab-pane" id="address-book">
			
			<?php wc_get_template( 'myaccount/my-address.php' ); ?>
			
			</div>
			
			<?php do_action( 'woocommerce_after_my_account' ); ?>
			
		</div>
	</div>
	<?php } else { ?>
	<div class="col-sm-9">
		<div class="my-account-right tab-content">
			
			<?php do_action( 'woocommerce_before_my_account' ); ?>
			
			<div class="tab-pane active" id="my-orders">
			
			<?php 
				if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
					woocommerce_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) );
				} else {
					woocommerce_get_template('myaccount/my-orders.php', array( 'recent_orders' => $recent_orders ));
				}
			?>
			
			</div>
			
			<?php if ( $downloads = $woocommerce->customer->get_downloadable_products() ) { ?>
			
			<div class="tab-pane" id="my-downloads">
			
			<?php woocommerce_get_template( 'myaccount/my-downloads.php' ); ?>
			
			</div>
			
			<?php } ?>
			
			<div class="tab-pane" id="address-book">
			
			<?php woocommerce_get_template( 'myaccount/my-address.php' ); ?>
			
			</div>
			
			<div class="tab-pane" id="change-password">
			
			<?php woocommerce_get_template( 'myaccount/form-change-password.php' ); ?>
			
			</div>		
			
			<?php do_action( 'woocommerce_after_my_account' ); ?>
			
		</div>
	</div>
<?php } ?>
</div>
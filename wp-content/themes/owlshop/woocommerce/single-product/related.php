<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

switch ($columns) {
	case '5':
		$class_column='col-sm-20 col-xs-6';
		break;
	case '4':
		$class_column='col-sm-3 col-xs-6';
		break;
	case '3':
		$class_column='col-lg-4 col-md-4 col-sm-4 col-xs-6';
		break;
	case '2':
		$class_column='col-lg-6 col-md-6 col-sm-6 col-xs-6';
		break;
	default:
		$class_column='col-lg-12 col-md-12 col-sm-12 col-xs-6';
		break;
}

if ( $products->have_posts() ) : ?>

	<div class="related products">

		<h2 class="heading-title  text-center"><span><?php _e( 'Related Products', 'woocommerce' ); ?></span></h2>

		<?php $_total = $products->found_posts; ?>
	    <div class="woocommerce">
			<div class="inner-content">
				<?php wc_get_template( 'product-layout/carousel.php', array( 
							'loop'=>$products,
							'columns_count'=>$columns,
							'class_column' => $class_column,
							'_total'=>$_total,
							 ) ); ?>
			</div>
		</div>

	</div>

<?php endif;

wp_reset_postdata();

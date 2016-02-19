<?php

define( 'PGL_WOOCOMMERCE_PATH', PGL_FRAMEWORK_PATH.'woocommerce/' );
define( 'PGL_WOOCOMMERCE_URI', PGL_FRAMEWORK_URI.'woocommerce/' );


global $theme_option,$pagenow;

/*==========================================================================
Woocommerce support
==========================================================================*/
add_theme_support( 'woocommerce' );

add_filter( 'woocommerce_enqueue_styles', 'owlshop_dequeue_styles_woocommerce' );
function owlshop_dequeue_styles_woocommerce( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
	return $enqueue_styles;
}

/*==========================================================================
init woocommerce
==========================================================================*/
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb',20 );
if( isset($theme_option['woo-is-breadcrumb']) && $theme_option['woo-is-breadcrumb'] ){
	add_action( 'woocommerce_before_main_content', 'owlshop_current_page_title_bar', 5 );
}else{
	add_action( 'woocommerce_before_main_content', 'owlshop_current_page_title_bar_empty', 5 );
	function owlshop_current_page_title_bar_empty(){
		echo '<div class="page-title-container-empty"></div>';
	}
}

function owlshop_work_around_pagination_bug($link) {
	return str_replace('#038;', '&', $link);
}
add_filter('paginate_links', 'owlshop_work_around_pagination_bug');


/*==========================================================================
Shop Layout
==========================================================================*/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count' ,20);
add_action( 'woocommerce_before_shop_loop', 'pgl_woocommerce_switch_layout', 20 );

function pgl_woocommerce_switch_layout(){
	$action = 'grid';
	if( isset($_GET['layout']) ){
		$action = $_GET['layout'];
	}
?>
	<form method="get" class="form-switch-layout">
		<ul class="switch-layout pull-left list-unstyled">
	        <li>
	        	<a style="position:relative;" data-action="grid"<?php echo ($action=='grid') ? 'class="active"':''; ?> href="javascript:;">
	    			<i class="fa fa-th"></i>
	    		</a>
	    	</li>
	        <li>
	        	<a style="position:relative;" data-action="list"<?php echo ($action=='list') ? 'class="active"':''; ?> href="javascript:;">
	        		<i class="fa fa-th-list"></i>
	        	</a>
	        </li>
	    </ul>
	    <input type="hidden" name="layout" value="<?php echo esc_attr($action); ?>">
	    <?php
			// Keep query string vars intact
			foreach ( $_GET as $key => $val ) {
				if ( 'layout' === $key || 'submit' === $key ) {
					continue;
				}
				if ( is_array( $val ) ) {
					foreach( $val as $innerVal ) {
						echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $innerVal ) . '" />';
					}
				
				} else {
					echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $val ) . '" />';
				}
			}
		?>
    </form>
<?php
}

/*==========================================================================
Woocommerce Show Availability
==========================================================================*/
add_action( 'woocommerce_product_meta_start','owlshop_woocommerce_availability_html',26 );
function owlshop_woocommerce_availability_html(){
	global $product;
	$availability = $product->get_availability();
	if ( $availability['availability'] ){
		echo '<div class="pgl-stock">' . __('Availability','owlshop') . ': <span class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span></div>';
	}else{
		echo '<div class="pgl-stock">' . __('Availability','owlshop') . ': <span class="stock in-stock">' . __( 'In stock', 'woocommerce' ) . '</span></div>';
	}
}


/*==========================================================================
Woocommerce Social Like
==========================================================================*/
add_action('woocommerce_share','owlshop_woocommerce_social_like');
function owlshop_woocommerce_social_like(){
	echo'<div class="pgl-wooshare">';
		get_template_part( 'templates/sharebox' );
	echo '</div>';

}

/*==========================================================================
Woocommerce Category Image
==========================================================================*/
function owlshop_woocommerce_category_image(){
	if (is_product_category()) {
        global $wp_query;
        // get the query object
        $cat = $wp_query->get_queried_object();
        // get the thumbnail id user the term_id
        $thumbnail_id = get_woocommerce_term_meta($cat->term_id, 'thumbnail_id', true);
      
        if($thumbnail_id!=0){
        ?>
            <div class="category-image">
                <?php echo wp_get_attachment_link($thumbnail_id, 'full'); ?>
            </div>
        <?php 
    	}
    }
}
add_action( 'woocommerce_archive_description' , 'owlshop_woocommerce_category_image' , 5 );
                

/*==========================================================================
Related Products
==========================================================================*/
add_filter( 'woocommerce_output_related_products_args', 'owlshop_related_products_args' );
  function owlshop_related_products_args( $args ) {
  	global $theme_option;
	$args['posts_per_page'] = $theme_option['woo-related-number'];
	$args['columns'] = $theme_option['woo-related-column'];
	return $args;
}

/*==========================================================================
Upsells Products
==========================================================================*/
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_upsells', 15 );
 
if ( ! function_exists( 'woocommerce_output_upsells' ) ) {
	function woocommerce_output_upsells() {
		global $theme_option;
	    woocommerce_upsell_display( $theme_option['woo-upsells-number'], $theme_option['woo-upsells-column'] ); // Display 3 products in rows of 3
	}
}

/*==========================================================================
Cross Sells Products
==========================================================================*/
add_action( 'woocommerce_cross_sells_columns', 'owlshop_cross_sells_columns' );
function owlshop_cross_sells_columns(){
	global $theme_option;
	return $theme_option['woo-cross-sells-column'];
}
add_action( 'woocommerce_cross_sells_total', 'owlshop_cross_sells_total' );
function owlshop_cross_sells_total(){
	global $theme_option;
	return $theme_option['woo-cross-sells-number'];
}

/*==========================================================================
Custom js add to cart
==========================================================================*/
add_action('wp_enqueue_scripts','owlshop_woocoomerce_js',9);
function owlshop_woocoomerce_js() { 
	wp_enqueue_script('PGL_woocommerce_js', PGL_WOOCOMMERCE_URI.'js/woocommerce.js',array(),false,true);
	wp_enqueue_script( 'wc-add-to-cart', PGL_FRAMEWORK_URI . 'woocommerce/js/add-to-cart.js', array( 'jquery' ) );
    wp_enqueue_script( 'pgl-countdown', PGL_FRAMEWORK_URI . 'woocommerce/js/countdown.js', array( 'jquery' ),PGL_THEME_VERSION );
    wp_localize_script( 'pgl-countdown', 'pgl_countdown_l10n', array(
															    	'days' => __('Days','owlshop'),
															    	'months' => __('Months','owlshop'),
															    	'weeks' => __('Weeks','owlshop'),
															    	'years' => __('Years','owlshop'),
															    	'hours' => __('Hours','owlshop'),
															    	'minutes' => __('Minutes','owlshop'),
															    	'seconds' => __('Seconds','owlshop'),
															    	'day' => __('Day','owlshop'),
															    	'month' => __('Month','owlshop'),
															    	'week' => __('Week','owlshop'),
															    	'year' => __('Year','owlshop'),
															    	'hour' => __('Hour','owlshop'),
															    	'minute' => __('Minute','owlshop'),
															    	'second' => __('Second','owlshop'),
															    ) );
}	


/*==========================================================================
Cart Header
==========================================================================*/


function owlshop_woocommerce_mini_cart(){
?>
	<div class="cart_container uk-offcanvas-bar uk-offcanvas-bar-flip" data-text-emptycart="<?php _e( 'No products in the cart.', 'woocommerce' ); ?>">
		<div class="uk-panel">
			<h3 class="widget-title"><?php echo __('Cart','owlshop'); ?></h3>
			<ul class="cart_list product_list_widget">

				<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

					<?php
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

							if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								?>
								<li class="media">
									<a href="<?php echo get_permalink( $product_id ); ?>" class="cart-image pull-left">
										<?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>						
									</a>
									<div class="cart-main-content media-body">
										<div class="name">
											<a href="<?php echo get_permalink( $product_id ); ?>">
												<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );; ?>
											</a>								
										</div>
										<p class="cart-item">
											<?php echo WC()->cart->get_item_data( $cart_item ); ?>
											<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ) ) . '</span>', $cart_item, $cart_item_key ); ?>
										</p>
									</div>
									<a href="#" data-product-id="<?php echo esc_attr($product_id); ?>" data-product-key="<?php echo esc_attr($cart_item_key); ?>" class="pgl_product_remove">
										<i class="fa fa-close"></i>
									</a>
								</li>
								<?php
							}
						}
					?>

				<?php else : ?>

					<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

				<?php endif; ?>

			</ul><!-- end product list -->

			<?php if ( sizeof( WC()->cart->get_cart() ) > 0 ) : ?>

				<p class="total"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

				<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

				<p class="buttons">
					<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="btn btn-primary btn-viewcart"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
					<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="btn btn-primary btn-checkout"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
				</p>

			<?php endif; ?>
		</div>
	</div>
<?php
}

/*==========================================================================
Ajax Remove Cart
==========================================================================*/
add_action( 'wp_ajax_cart_remove_product', 'owlshop_woocommerce_cart_remove_product' );
add_action( 'wp_ajax_nopriv_cart_remove_product', 'owlshop_woocommerce_cart_remove_product' );
function owlshop_woocommerce_cart_remove_product() {
    $cart = WC()->instance()->cart;
	$id = $_POST['product_id'];
	$cart_id = $cart->generate_cart_id($id);
	$cart_item_id = $cart->find_product_in_cart($cart_id);

	if($cart_item_id){
	   $cart->set_quantity($cart_item_id,0);
	}
	$output = array();
	$output['subtotal'] = $cart->get_cart_subtotal();
	$output['count'] = $cart->cart_contents_count;
	print_r( json_encode( $output ) );
    exit();
}

/*==========================================================================
Layout Shop : sidebar
==========================================================================*/
function owlshop_woocommerce_layout_shop_sidebar($value){
	global $theme_option;
	return $theme_option['woo-shop-sidebar'];
}
add_filter( 'owlshop_woocommerce_shop_sidebar' ,'owlshop_woocommerce_layout_shop_sidebar' );

/*==========================================================================
Layout Single Product : sidebar 
==========================================================================*/
function pgl_woocommerce_layout_single_sidebar($value){
	global $theme_option;
	return $theme_option['woo-single-sidebar'];
}
add_filter( 'pgl_woocommerce_single_sidebar' ,'pgl_woocommerce_layout_single_sidebar' );

/*==========================================================================
Ajax Add To cart
==========================================================================*/
add_filter('add_to_cart_fragments', 'pgl_woocommerce_ajax_cart');
function pgl_woocommerce_ajax_cart( $fragments ) {
	global $woocommerce;
	ob_start();
	?>
    <a href="javascript:;" data-uk-offcanvas="{target:'#pgl_cart_canvas'}" class="shoppingcart">
        <i class="fa fa-shopping-cart"></i>
        <span class="text"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span>
    </a>
	<?php
	$fragments['.shoppingcart'] = ob_get_clean();
	ob_start();
	owlshop_woocommerce_mini_cart();
	$fragments['#pgl_cart_canvas .cart_container'] = ob_get_clean();
	return $fragments;
}

/*==========================================================================
Cart Off-canvas
==========================================================================*/
add_action('owlshop_before_wrapper', 'pgl_woocommerce_cart_offcanvas');
function pgl_woocommerce_cart_offcanvas() {
?>
	<div id="pgl_cart_canvas" class="uk-offcanvas">
        <?php owlshop_woocommerce_mini_cart(); ?>
    </div>
<?php
}

/*==========================================================================
Set Column class
==========================================================================*/
add_filter( 'pgl_woocommerce_column_class', 'pgl_set_column_class' );
function pgl_set_column_class($value){
	global $woocommerce_loop;
	switch ($woocommerce_loop['columns']) {
		case '2':
			$value[] = 'col-sm-6';
			break;
		case '3':
			$value[] = 'col-sm-4';
			break;
		case '4':
			$value[] = 'col-md-3 col-sm-6';
			break;
		case '5':
			$value[] = 'col-md-20 col-sm-4';
			break;
		case '6':
			$value[] = 'col-sm-4 col-md-2';
			break;
		default:
			$value[] = 'col-md-3 col-sm-6';
			break;
	}
	return $value;
}


/*==========================================================================
Wishlist & Compare
==========================================================================*/
add_filter( 'yith_wcwl_button_label',		   'pgl_woocomerce_icon_wishlist'  );
add_filter( 'yith-wcwl-browse-wishlist-label', 'pgl_woocomerce_icon_wishlist_add' );
function pgl_woocomerce_icon_wishlist( $value='' ){
	return '<i class="fa fa-heart-o" data-toggle="tooltip" title="'.__('Wishlist','owlshop').'"></i>';
}

function pgl_woocomerce_icon_wishlist_add(){
	return '<i class="fa fa-heart" data-toggle="tooltip" title="'.__('Wishlist','owlshop').'"></i>';
}

if(class_exists('YITH_WCWL')){
	add_action( 'pgl_woocommerce_button_action', 'pgl_button_wishlist' , 40 );
	function pgl_button_wishlist(){
	?>
		<?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
	<?php
	}
}

// Quick View
if(true){
	add_action( 'wp_ajax_pgl_quickview', 'pgl_woocoomerce_quickView' );
	add_action( 'wp_ajax_nopriv_pgl_quickview', 'pgl_woocoomerce_quickView' );
	function pgl_woocoomerce_quickView(){
		global $post, $product, $woocommerce;
	    $prod_id =  $_POST["product"];
	    $post = get_post($prod_id);
	    $product = get_product($prod_id);
	    ob_start();
	?>

	<?php woocommerce_get_template( 'woocommerce-lightbox.php'); ?>

	<?php
	    $output = ob_get_contents();
	    ob_end_clean();
	    echo $output;
	    die();
	}
	// setup Button Quickview
	add_action( 'pgl_woocommerce_button_action', 'pgl_button_quickview' , 60 );
	function pgl_button_quickview(){
		global $product;
	?>
		<a href="#" class="button btn-quickview quickview" data-toggle="tooltip" title="<?php _e('Quickview','owlshop'); ?>" data-proid="<?php echo esc_attr($product->id); ?>" >
			<i class="fa fa-search"></i>
		</a>
	<?php
	}

	// Set Popup Quickview
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_single_price', 10 );
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_single_excerpt', 20 );
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_single_meta', 15 );
	add_action( 'woocommerce_single_product_quickview_summary', 'woocommerce_template_loop_add_to_cart', 30 );
}

function woocommerce_single_variation_add_to_cart_button() {
	global $product;
	?>
	<div class="variations_button cart-inner">
		<?php woocommerce_quantity_input( array( 'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 ) ); ?>
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
		<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->id ); ?>" />
		<input type="hidden" name="product_id" value="<?php echo absint( $product->id ); ?>" />
		<input type="hidden" name="variation_id" class="variation_id" value="" />
	</div>
	<?php
}

if(class_exists( 'YITH_Woocompare' )){
	add_action( 'pgl_woocommerce_button_action', 'pgl_button_compare' , 50 );
	function pgl_button_compare(){
		global $product;
		$action_add = 'yith-woocompare-add-product';
        $url_args = array(
            'action' => $action_add,
            'id' => $product->id
        );
	?>
		<a href="#" data-toggle="tooltip" title="<?php _e('Compare','owlshop'); ?>" class="button btn-compare">
			<i class="fa fa-exchange"></i>
		</a>
		<a href="<?php echo wp_nonce_url( add_query_arg( $url_args ), $action_add ); ?>" style="display:none!important;" data-product_id="<?php echo esc_attr($product->id); ?>" class="compare">
		</a>
	<?php
	}
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'pgl_woocommerce_button_action', 'woocommerce_template_loop_add_to_cart', 10 );

/*==========================================================================
Override Widget Woocommerce
==========================================================================*/

add_action( 'widgets_init', 'pgl_woocoomerce_override_woocommerce_widgets' , 15 );
function pgl_woocoomerce_override_woocommerce_widgets() {
	$args = array(
		'WC_Widget_Cart',
		'WC_Widget_Layered_Nav',
		'WC_Widget_Layered_Nav_Filters',
		'WC_Widget_Price_Filter',
		'WC_Widget_Product_Categories',
		'WC_Widget_Products',
		'WC_Widget_Product_Search',
		'WC_Widget_Product_Tag_Cloud',
		'WC_Widget_Recently_Viewed',
		'WC_Widget_Recent_Reviews',
		'WC_Widget_Top_Rated_Products'
	);
	foreach ($args as $c) {
		if ( class_exists( $c ) ) {
			unregister_widget( $c );
			$file = PGL_THEME_DIR.'/woocommerce/widgets/'.str_replace('_', '-', str_replace( 'wc_' , '', strtolower($c) )).'.php';
			if(is_file($file)){
				include_once( $file );
			}
		}
	}
}


/*==========================================================================
Effect Hover Image Product
==========================================================================*/
if( $theme_option['woo-is-effect-thumbnail']){
	remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
	add_action('woocommerce_before_shop_loop_item_title', 'pgl_woocommerce_template_loop_product_thumbnail' ,10);
	function  pgl_woocommerce_template_loop_product_thumbnail(){
		global $post, $product, $woocommerce;
		$placeholder_width = get_option('shop_catalog_image_size');
		$placeholder_width = $placeholder_width['width'];
		
		$placeholder_height = get_option('shop_catalog_image_size');
		$placeholder_height = $placeholder_height['height'];
		
		$output='';
		if(has_post_thumbnail()){
			$attachment_ids = $product->get_gallery_attachment_ids();
			$output.=get_the_post_thumbnail( $post->ID,'shop_catalog',array('class'=> ($attachment_ids) ? 'image-hover' : 'image-effect-none' ) );
			if($attachment_ids) {
				$output.=wp_get_attachment_image($attachment_ids[0],'shop_catalog',false,array('class'=>"attachment-shop_catalog image-effect"));
			}
			
		}else{
			$output .= '<img src="'.esc_html(woocommerce_placeholder_img_src()).'" alt="'.__('Placeholder' , 'owlshop').'" class="'.esc_attr($class).'" width="'.esc_attr($placeholder_width).'" height="'.esc_attr($placeholder_height).'" />';
		}
		echo $output;
	}
	add_filter('body_class','pgl_woocommerce_effect_hover_skin_func');
	function pgl_woocommerce_effect_hover_skin_func($classes){
		global $theme_option;
		if( isset($theme_option['woo-effect-thumbnail-skin']) && $theme_option['woo-effect-thumbnail-skin']!='' ){
			$classes[] = $theme_option['woo-effect-thumbnail-skin'];
		}
		return $classes;
	}
}

/*==========================================================================
Change Config Woocommerce
==========================================================================*/
add_filter( 'loop_shop_columns', 'pgl_woocoomerce_wc_loop_shop_columns', 1 );
add_filter( 'loop_shop_per_page', 'pgl_woocoomerce_wc_product_per_page' , 20 );
function pgl_woocoomerce_wc_product_per_page($cols){
	global $theme_option;
	$number = $theme_option['woo-shop-number'];
	return $number;
}

function pgl_woocoomerce_wc_loop_shop_columns(){
	global $theme_option;
	$columns = $theme_option['woo-shop-column'];
	return $columns;
}



/*==========================================================================
 WooCommerce - Function get Query
==========================================================================*/
function owlshop_woocommerce_query($type,$post_per_page=-1,$cat=''){
    $args = owlshop_woocommerce_query_args($type,$post_per_page,$cat);
    return new WP_Query($args);
}

function owlshop_woocommerce_query_args($type,$post_per_page=-1,$cat=''){
	global $woocommerce;
    remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_popularity_post_clauses' ) );
	remove_filter( 'posts_clauses', array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $post_per_page,
        'post_status' => 'publish'
    );
    switch ($type) {
        case 'best_selling':
            $args['meta_key']='total_sales';
            $args['orderby']='meta_value_num';
            $args['ignore_sticky_posts']   = 1;
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;
        case 'featured_product':
            $args['ignore_sticky_posts']=1;
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = array(
                         'key' => '_featured',
                         'value' => 'yes'
                     );
            $query_args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;
        case 'top_rate':
            add_filter( 'posts_clauses',  array( $woocommerce->query, 'order_by_rating_post_clauses' ) );
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            break;
        case 'recent_product':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            break;
        case 'on_sale':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = wc_get_product_ids_on_sale();
            break;
        case 'recent_review':
            if($number == -1) $_limit = 4;
            else $_limit = $number;
            global $wpdb;
            $query = "SELECT c.comment_post_ID FROM {$wpdb->prefix}posts p, {$wpdb->prefix}comments c WHERE p.ID = c.comment_post_ID AND c.comment_approved > 0 AND p.post_type = 'product' AND p.post_status = 'publish' AND p.comment_count > 0 ORDER BY c.comment_date ASC LIMIT 0, ". $_limit;
            $results = $wpdb->get_results($query, OBJECT);
            $_pids = array();
            foreach ($results as $re) {
                $_pids[] = $re->comment_post_ID;
            }

            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['post__in'] = $_pids;
            break;
        case 'deals':
            $args['meta_query'] = array();
            $args['meta_query'][] = $woocommerce->query->stock_status_meta_query();
            $args['meta_query'][] = $woocommerce->query->visibility_meta_query();
            $args['meta_query'][] = array(
                                 'key' => '_sale_price_dates_to',
                                 'value' => '0',
                                 'compare' => '>');
            $args['post__in'] = wc_get_product_ids_on_sale();
            break;
    }

    if($cat!=''){
        $args['product_cat']= $cat;
    }
    return $args;
}

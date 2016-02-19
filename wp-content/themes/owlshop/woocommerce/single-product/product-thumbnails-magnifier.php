<?php
/**
 * Single Product Image
 *
 * @author 		YIThemes
 * @package 	YITH_Magnifier/Templates
 * @version     1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product, $woocommerce;
update_option('yith_wcmg_enableslider',false);

$attachment_ids = $product->get_gallery_attachment_ids();
if ( ! empty( $attachment_ids ) ) array_unshift( $attachment_ids, get_post_thumbnail_id() );

if ( $attachment_ids ) {
    $columns = apply_filters( 'woocommerce_product_thumbnails_columns', get_option( 'yith_wcmg_slider_items', 3 ) );
    if( !isset( $columns ) || $columns == null ) $columns = 3;
    ?>
    <div class="thumbnails">
        <ul class="yith_magnifier_gallery owl-carousel owl-theme" data-item="<?php echo esc_attr($columns); ?>">
        <?php
        foreach ( $attachment_ids as $attachment_id ) {
            $classes = array( 'yith_magnifier_thumbnail' );
            $image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
            $image_class = esc_attr( implode( ' ', $classes ) );
            $image_title = esc_attr( get_the_title( $attachment_id ) );
            list( $thumbnail_url, $thumbnail_width, $thumbnail_height ) = wp_get_attachment_image_src( $attachment_id, "shop_single" );
            list( $magnifier_url, $magnifier_width, $magnifier_height ) = wp_get_attachment_image_src( $attachment_id, "shop_magnifier" );
            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<li class="%s"><a href="%s" class="%s" title="%s" data-small="%s">%s</a></li>', $image_class, $magnifier_url, $image_class, $image_title, $thumbnail_url, $image ), $attachment_id, $post->ID, $image_class );  
        }
        ?>
        </ul>
    </div>
<?php
}
?>
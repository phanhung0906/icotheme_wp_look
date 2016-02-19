<?php
return;
global $theme_option;
//return;
if($theme_option['style_main_color']=='#97d8bd') return;
$main_color = $theme_option['style_main_color'];
if($main_color=='custom'){
  $main_color = $theme_option['style_main_custom'];
}

$color_hover = owlshop_adjustColorLightenDarken( $main_color,20 );

?>

.scroll-to-top,
.widget.widget_calendar caption,
.nav-tabs.tab-widget li.active a,
.post-thumb a.post-img-1:hover,
.blog-container.blog-visual .meta-date > span,
#pgl-mainbody .tparrows:hover,
.pgl-footer .footer-about span.icon,
.product-slide.owl-theme .owl-dots .owl-dot.active span,
.product-block .button-item .added_to_cart:hover,
.product-block .button-item a.button.btn-cart:hover,
#single-product .cart-inner .button.btn-cart,
.woocommerce-page #respond input#submit,
.woocommerce-page a.button.alt,
.woocommerce-page input.button.alt,
.woocommerce-page a.button,
.woocommerce-page button.button,
.product-quickview .woocommerce .btn-cart:hover,
.btn-primary
{
	background-color: <?php echo esc_attr($main_color); ?>;
}

a,
.language-filter select,
.shoppingcart p.total .amount,
.shoppingcart .name a:hover,
.widget.widget_rss a,
.widget.widget_rss a:hover,
.widget .comment-author-link a,
.paging .pagination > li > span:hover,
.paging .pagination > li > a:hover,
.paging .pagination > li > span.current,
#pgl-header .header-content .shoppingcart > a .count,
.header-style2 .pgl-megamenu .megamenu > li > a:hover,
.pgl_search:hover .fa,
.related-post-content a:hover,
.blog-title a:hover,
.blog-container.blog-visual .meta-heading .visual-meta a:hover,
.blog-container.blog-masonry .meta-date > span,
.blog-container.blog-masonry .meta-heading .masonry-meta a:hover,
.commentlists .the-comment .comment-box .comment-action a:hover,
.post-container .entry-title a:hover,
.pgl-footer .post-widget article a:hover,
.pgl-footer .comment-widget article a:hover,
.pgl-footer a:hover,
.pgl-footer address a:hover,
.pgl-footer .widget table th a,
.pgl-footer .widget table td a,
.pgl-footer .widget .tagcloud a:hover,
.pgl-sidebar ul.product-categories li.current-cat-parent > a,
.pgl-sidebar ul.product-categories li.current-cat > a ,
.pgl-sidebar ul li a:hover,
.footer-copyright a,
.pgl-megamenu .dropdown-menu a:hover,
.pgl-megamenu .megamenu > li.current-menu-item > a,
.pgl-megamenu .megamenu > li.current-menu-parent > a,
.pgl-megamenu .megamenu > li.current-menu-ancestor > a,
.pgl-megamenu .megamenu > li:hover > a,
.pgl-megamenu .megamenu > li .current-menu-item > a > span,
.pgl-megamenu .megamenu .woocommerce .product-meta .title a:hover,
.pgl-megamenu .mega-col-nav .mega-inner ul li a:focus,
.pgl-megamenu .mega-col-nav .mega-inner ul li a:hover,
.pgl-megamenu .mega-group > a span:hover,
.uk-nav-offcanvas > .uk-open > a,
html:not(.uk-touch) .uk-nav-offcanvas > li > a:hover,
html:not(.uk-touch) .uk-nav-offcanvas > li > a:focus,
html:not(.uk-touch) .uk-nav-offcanvas ul a:hover,
.uk-active > a,
.product-block.product-list .woocommerce-review-link:hover,
.product-block .name a:hover,
.woocommerce-tabs .nav-tabs li.active a,
.woocommerce-tabs .nav-tabs li:hover a,
.woocommerce table.shop_table td a:hover,
.woocommerce table.shop_table .order-total .amount,
#single-product .wishlist-compare a:hover,
#single-product .pgl-stock .in-stock,
#single-product div.summary .woocommerce-review-link:hover,
.product_list_widget .product-title a:hover,
.item-product-widget .product-meta .title a:hover,
.item-product-widget .product-meta .category a:hover
{
  color: <?php echo esc_attr( $main_color ); ?>;
}

.shoppingcart .media .pgl_product_remove:hover .fa,
.pgl-megamenu .mega-col-nav .mega-inner ul li.active a
{
	color: <?php echo esc_attr( $main_color ); ?>!important;
}

.nav-tabs.tab-widget li.active a:after
{
	border-top-color:<?php echo esc_attr( $main_color ); ?>;
}

.product-quickview .woocommerce .btn-cart:hover,
.btn-primary
{
	border-color:<?php echo esc_attr( $main_color ); ?>;
}

a:hover,
.btn-link:hover,
.btn-link:focus,
.widget .comment-author-link a:hover,
.blog-title a:hover,
.footer-copyright a:hover
{
	color:<?php echo esc_attr( $color_hover ); ?>;
}

.open > .dropdown-toggle.btn-primary,
.label-primary[href]:hover,
.label-primary[href]:focus,
.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active
{
	background-color: <?php echo esc_attr( $color_hover ); ?>;
}

.nav a:hover .caret{
	border-bottom-color:<?php echo esc_attr( $color_hover ); ?>;
	border-top-color:<?php echo esc_attr( $color_hover ); ?>;
}

.btn-primary:hover,
.btn-primary:focus,
.btn-primary:active,
.btn-primary.active,
.open > .dropdown-toggle.btn-primary
{
	border-color:<?php echo esc_attr( $color_hover ); ?>;
}
<?php 
    global $theme_option,$woocommerce;
    $login_url = wp_login_url();
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    if ( $myaccount_page_id ) {
        $login_url = get_permalink( $myaccount_page_id );
        if ( get_option( 'woocommerce_force_ssl_checkout' ) == 'yes' ) {
            $login_url = str_replace( 'http:', 'https:', $login_url );
        }
    }
?>
<header id="pgl-header" class="pgl-header">
    <div class="header-content">
        <?php if(PLG_WOOCOMMERCE_ACTIVED && isset($theme_option['header-is-cart'])&& $theme_option['header-is-cart']): ?>
        <div class="header-content-inner header-hr header-first">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-4">
                        <div class="menu-top menu-top1">
                            <ul>
                                <li><a href=""><i class="fa fa-lock"></i> <span><?php echo _('LOG IN/REGISTER') ?></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-8">
                        <div class="menu-top menu-top2">
                            <ul>
                                <li><a href="<?php echo get_permalink( get_page_by_path( 'checkout' ) ) ?>"><i class="fa fa-check-circle-o"></i> <span><?php echo _('CHECKOUT') ?></span></a></li>
                                <li><a href="<?php echo get_permalink( get_page_by_path( 'wishlist' ) ) ?>"><i class="fa fa-gift"></i> <span><?php echo _('MY WHISTLE') ?></span></a></li>
                                <li><a href="<?php echo get_permalink( get_page_by_path( 'my-account' ) ) ?>"><i class="fa fa-lock"></i> <span><?php echo _('MY ACCOUNT') ?></span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif ?>
        <div class="header-content-inner header-hr header-second">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div id="wp-search">
                            <div class="wrapper-inner">
                                <?php get_search_form(); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <?php do_action('owlshop_set_logo'); ?>
                    </div>
                    <div class="col-md-4">
                        <div id="wp-search">
                            <div class="wrapper-inner">
                                <?php /*echo esc_html($woocommerce->cart->cart_contents_count); */?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-content-inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 hidden-xs hidden-sm content-navigation text-center">
                        <?php pgl_megamenu(array(
                            'theme_location' => 'mainmenu',
                            'container_class' => 'collapse navbar-collapse navbar-ex1-collapse',
                            'menu_class' => 'nav navbar-nav megamenu',
                            'show_toggle' => false
                        )); ?>
                    </div>
                    <ul class="nav navbar-nav icon-action">
                        <li>
                            <a href="javascript:;" class="off-canvas-toggle icon-toggle" data-uk-offcanvas="{target:'#pgl-off-canvas'}">
                                <i class="fa fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                  <!--  <div class="col-md-2 col-sm-9 content-action">
                        <ul class="nav navbar-nav icon-action">
                            <?php /*if(PLG_WOOCOMMERCE_ACTIVED && isset($theme_option['header-is-cart'])&& $theme_option['header-is-cart']): */?>
                            <li class="dropdown">
                                <a href="javascript:;" data-uk-offcanvas="{target:'#pgl_cart_canvas'}" class="shoppingcart">
                                    <i class="fa fa-shopping-cart"></i>
                                    <span class="text"><?php /*echo esc_html($woocommerce->cart->cart_contents_count); */?></span>
                                </a>
                            </li>
                            <?php /*endif; */?>
                            <li>
                                <a href="#" class="search-action">
                                    <i class="fa fa-search"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" data-uk-offcanvas="{target:'#pgl_setting_canvas'}">
                                    <i class="fa fa-cog"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="off-canvas-toggle icon-toggle" data-uk-offcanvas="{target:'#pgl-off-canvas'}">
                                    <i class="fa fa-bars"></i>
                                </a>
                            </li>
                        </ul>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <?php do_action('pgl_after_header'); ?>
</header>
<!-- //HEADER -->
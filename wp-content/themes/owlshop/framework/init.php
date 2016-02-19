<?php

define( 'PGL_THEME_DIR', get_template_directory() );
define( 'PGL_THEME_URI', get_template_directory_uri() );

define( 'PGL_FRAMEWORK_PATH', PGL_THEME_DIR . '/framework/' );
define( 'PGL_FRAMEWORK_URI', PGL_THEME_URI . '/framework/' );

define( 'PLG_REDUX_FRAMEWORK_ACTIVED', in_array( 'redux-framework/redux-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );
define( 'PLG_WOOCOMMERCE_ACTIVED', in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );


if(!PLG_REDUX_FRAMEWORK_ACTIVED){
	require_once( PGL_THEME_DIR.'/framework/redux-framework/redux-framework.php' );
}

require_once get_template_directory().'/framework/metabox/meta-item.php';
require_once get_template_directory().'/framework/admin/options.php';
require_once get_template_directory().'/framework/admin/plugin-activation.php';
require_once get_template_directory().'/framework/framework.php';
require_once get_template_directory().'/framework/front/function.php';

require_once get_template_directory().'/framework/customize/init.php';

require_once get_template_directory().'/framework/megamenu/megamenu.php';

if(!get_option('owlshop_installed')){
	require_once( get_template_directory() .'/framework/samples/import.php' );
}




/*==========================================================================
Woocommerce
==========================================================================*/
if(PLG_WOOCOMMERCE_ACTIVED){
	require_once get_template_directory().'/framework/woocommerce/woocommerce.php';
}

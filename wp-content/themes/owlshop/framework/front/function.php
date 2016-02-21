<?php
/*==========================================================================
Setup Theme
==========================================================================*/
function owlshop_theme_setup(){
    load_theme_textdomain( 'owlshop', get_template_directory().'/languages' );
    register_nav_menus( array(
        'mainmenu'   => __( 'Main Menu', 'owlshop' ),
    ) );

    add_theme_support( 'automatic-feed-links' );

    add_theme_support( 'post-formats', array(
       'image', 'video', 'audio', 'gallery', 'status'
    ) );
    add_theme_support( "post-thumbnails" );
    add_image_size( 'blog-mini',400,400,true );
    add_image_size( 'blog-list',600,280,true );
    add_image_size( 'wg-list-lager',270,177,true );

    if ( ! isset( $content_width ) ) $content_width = 900;
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background' );
    add_theme_support( "title-tag" );
}
add_action( 'after_setup_theme', 'owlshop_theme_setup' );

/*==========================================================================
Require Plugins
==========================================================================*/
add_filter( 'owlshop_list_plugins_required' , 'owlshop_list_plugins_required' );
if(!function_exists('owlshop_list_plugins_required')){
    function owlshop_list_plugins_required($list){
        $path_link = 'http://aztheme.com/plugins/';
        $path = PGL_FRAMEWORK_PATH . 'plugins/';
        $list[] = array(
                    'name'                     => 'WooCommerce', // The plugin name
                    'slug'                     => 'woocommerce', // The plugin slug (typically the folder name)
                    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
                );
        $list[] = array(
                    'name'                     => 'Redux Framework', // The plugin name
                    'slug'                     => 'redux-framework', // The plugin slug (typically the folder name)
                    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
                );
        
        $list[] = array(
                    'name'                     => 'Contact Form 7', // The plugin name
                    'slug'                     => 'contact-form-7', // The plugin slug (typically the folder name)
                    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
                );
        $list[] = array(
                    'name'                     => 'WPBakery Visual Composer', // The plugin name
                    'slug'                     => 'js_composer', // The plugin slug (typically the folder name)
                    'required'                 => true,
                    'source'                   => $path_link . 'js_composer.zip', // The plugin source
                );
        $list[] = array(
                    'name'                     => 'Revolution Slider', // The plugin name
                    'slug'                     => 'revslider', // The plugin slug (typically the folder name)
                    'required'                 => true, // If false, the plugin is only 'recommended' instead of required
                    'source'                   => $path_link . 'revslider.zip', // The plugin source
                );
        $list[] = array(
                    'name'                     => 'YITH WooCommerce Zoom Magnifier', // The plugin name
                    'slug'                     => 'yith-woocommerce-zoom-magnifier', // The plugin slug (typically the folder name)
                    'required'                 =>  true
                );
        $list[] = array(
                'name'                     => 'YITH WooCommerce Wishlist', // The plugin name
                'slug'                     => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                'required'                 => true
            );

        $list[] = array(
                'name'                     => 'YITH Woocommerce Compare', // The plugin name
                'slug'                     => 'yith-woocommerce-compare', // The plugin slug (typically the folder name)
                'required'                 => true
            );
        $list[] = array(
                'name'                     => 'PGL Framework', // The plugin name
                'slug'                     => 'pgl_framework', // The plugin slug (typically the folder name)
                'required'                 => true,
                'source'                   => $path . 'pgl_framework.zip', // The plugin source
            );
        return $list;
    }
}


/*==========================================================================
Styles & Scripts
==========================================================================*/
function owlshop_init_styles_scripts(){
    global $theme_option;
	$protocol = is_ssl() ? 'https:' : 'http:';

    wp_enqueue_script("jquery");
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
  		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
    
    // Add Google Font
    $fonts_url = '';
    $font_families = array(
            'Montserrat:400,700',
            'Droid Serif:400,700'
        );
    $query_args = array(
        'family' => urlencode( implode( '|', $font_families ) ),
        'subset' => urlencode( 'latin-ext' ),
    );
 
    $fonts_url = esc_url_raw(add_query_arg( $query_args, '//fonts.googleapis.com/css' ));

    wp_enqueue_style('theme-owl-fonts',$fonts_url);

	
    // Css 
    if(is_rtl()){
        wp_enqueue_style('theme-bootstrap',PGL_THEME_URI.'/css/bootstrap-rtl.css',array(),PGL_THEME_VERSION);
    }else{
        wp_enqueue_style('theme-bootstrap',PGL_THEME_URI.'/css/bootstrap.css',array(),PGL_THEME_VERSION);
    }

    if( isset($theme_option['is-optimize-css']) && $theme_option['is-optimize-css']== true ){
        wp_enqueue_style('nast_css',PGL_THEME_URI.'/css/theme.min.css',array(),PGL_THEME_VERSION);
    }else{
        if(PLG_WOOCOMMERCE_ACTIVED){
            wp_enqueue_style('theme-woocommerce-css',PGL_THEME_URI.'/css/woocommerce.css',array(),PGL_THEME_VERSION);
        }
        wp_enqueue_style('theme-font-awesome',PGL_THEME_URI.'/css/font-awesome.min.css',array(),PGL_THEME_VERSION);
        wp_enqueue_style('theme-animate',PGL_THEME_URI.'/css/animate.css',array(),PGL_THEME_VERSION);
        wp_enqueue_style('theme-magnific',PGL_THEME_URI.'/css/magnific-popup.css',array(),PGL_THEME_VERSION);

        //Owl Carousel Assets
        wp_enqueue_style('owl-carousel-base',PGL_THEME_URI.'/owl-carousel/owl.carousel.css',array(),PGL_THEME_VERSION);
        wp_enqueue_style('owl-carousel-theme',PGL_THEME_URI.'/owl-carousel/owl.theme.css',array(),PGL_THEME_VERSION);
        wp_enqueue_style('owl-carousel-transitions',PGL_THEME_URI.'/owl-carousel/owl.transitions.css',array(),PGL_THEME_VERSION);

        // DEV ENVIRONMENT
        wp_enqueue_style('theme-style',PGL_THEME_URI.'/less/style.css',array(),PGL_THEME_VERSION);
//        wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
    } 


    // Scripts
    wp_register_script('theme-gmap-core', $protocol .'//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places',array(),PGL_THEME_VERSION,true );
    wp_register_script('theme-gmap-api',PGL_THEME_URI.'/js/gmaps.js',array(),PGL_THEME_VERSION,array(),PGL_THEME_VERSION,true);

    if( isset($theme_option['is-optimize-js']) && $theme_option['is-optimize-js']==true ){
        wp_enqueue_script('accessories_js',PGL_THEME_URI.'/js/theme.min.js',array(),PGL_THEME_VERSION,true);
    }else{
        wp_enqueue_script('theme-bootstrap',PGL_THEME_URI.'/js/bootstrap.min.js',array(),PGL_THEME_VERSION);
        wp_enqueue_script('theme-magnific-popup',PGL_THEME_URI.'/js/jquery.magnific-popup.js',array(),PGL_THEME_VERSION,true);
        wp_enqueue_script('owl-carousel_js',PGL_THEME_URI.'/owl-carousel/owl.carousel.js',array(),PGL_THEME_VERSION);
        wp_enqueue_script('theme-magnific_js',PGL_THEME_URI.'/js/jquery.parallax-1.1.3.js',array(),PGL_THEME_VERSION,true);
        wp_enqueue_script('theme-wow_js',PGL_THEME_URI.'/js/jquery.wow.min.js',array(),PGL_THEME_VERSION,true);
        wp_enqueue_script('theme-modernizr_js',PGL_THEME_URI.'/js/modernizr.custom.js',array(),PGL_THEME_VERSION,true);
        wp_enqueue_script('theme-uk_js',PGL_THEME_URI.'/js/uikit.min.js',array(),PGL_THEME_VERSION,true);
        wp_enqueue_script('theme-main_js',PGL_THEME_URI.'/js/main.js',array(),PGL_THEME_VERSION,true);
    }
	
}
add_action( 'wp_enqueue_scripts','owlshop_init_styles_scripts' );


/*==========================================================================
Single Post
==========================================================================*/
add_action('owlshop_post_before_content','owlshop_set_post_thumbnail',10);

add_action('owlshop_post_after_content','owlshop_single_sharebox',10);
add_action('owlshop_post_after_content','owlshop_single_related_post',15);
add_action('owlshop_post_after_content','owlshop_single_author_bio',20);

function owlshop_set_post_thumbnail(){
    global $post;
    $postid = $post->ID;
    $link_embed = get_post_meta($postid,'_owlshop_post_video',true);
    $gallery = get_post_meta( $postid,'_owlshop_post_gallery', true );
    $status = get_post_meta( $postid, '_owlshop_post_status' , true );
    $is_thumb = false;
    $content = $output = $start = $end = '';
    
    if( has_post_format( 'video' ) && $link_embed!='' ){
        $content ='<div class="video-responsive">'.wp_oembed_get($link_embed).'</div>';
        $is_thumb = true;
    }else if ( has_post_format( 'audio' ) ){
        $content ='<div class="audio-responsive">'.wp_oembed_get($link_embed).'</div>';
        $is_thumb = true;
    }else if ( has_post_format( 'gallery' ) && $gallery != '' ){
        $count = 0;
        $content =  '<div id="post-slide-'.$postid.'" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">';
        foreach ($gallery as $key => $id){
            $img_src = wp_get_attachment_image_src($key, apply_filters( 'pgl_gallery_image_size','full' ));
            $content.='<div class="item '.(($count==0)?'active':'').'">
                        <img src="'.$img_src[0].'">
                    </div>';
            $count++;
        }
        $content.='</div>
            <a class="left carousel-control" href="#post-slide-'.esc_attr($postid).'" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a class="right carousel-control" href="#post-slide-'.esc_attr($postid).'" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>';
        $is_thumb = true;
    }else if( has_post_format( 'status' ) && $status != '' ){
        $content ='<div class="status-responsive">'.$status.'</div>';
        $is_thumb = true;
    }else if( has_post_thumbnail() ){
        $content = get_the_post_thumbnail( $postid, apply_filters( 'pgl_single_image_size','full' ) );
        $is_thumb = true;
    }

    if( $is_thumb ){
        $start = '<div class="post-thumb">';
        $end = '</div>';
    }

    $output = $start.$content.$end;
    echo wp_kses_post($output);
}

function owlshop_single_sharebox(){
    ?>
    <div class="post-share">
        <div class="row">
            <div class="col-sm-4">
                <h4 class="heading"><?php echo __( 'Share this Post!','owlshop' ); ?></h4>
            </div>
            <div class="col-sm-8">
                <?php get_template_part( 'templates/sharebox' ); ?>
            </div>
        </div>
    </div>
    <?php
}
function owlshop_single_related_post(){
    get_template_part('templates/single/related');
}
function owlshop_single_author_bio(){
    ?>
    <div class="author-about">
        <?php get_template_part('templates/single/author-bio'); ?>
    </div>
    <?php
}

/*==========================================================================
Language Flags
==========================================================================*/

function owlshop_language_flags() {
    
    $language_output = '<select id="pgl-language-switch">';
    
    if (function_exists('icl_get_languages')) {
        $languages = icl_get_languages('skip_missing=0&orderby=code');
        if(!empty($languages)){
            foreach($languages as $l){
                if($l['country_flag_url']){
                    if(!$l['active']) {
                        $language_output .= '<option value="'.$l['url'].'" >'.$l['translated_name'].'</option>'."\n";
                    } else {
                        $language_output .= '<option value="'.$l['url'].'" selected="selected">'.$l['translated_name'].'</option>'."\n";
                    }
                }
            }
        }
    } else {
        $language_output .= '
            <option value="">English</option>
            <option value="">German</option>
            <option value="">Spanish</option>
            <option value="">French</option>
            <option value="">Demo</option>
        ';
    }
    $language_output .= '</select>';
    return $language_output;
}

add_action('owlshop_before_wrapper', 'pgl_settings_offcanvas');
function pgl_settings_offcanvas() {
?>
    <div id="pgl_setting_canvas" class="uk-offcanvas">
        <div class="cart_container uk-offcanvas-bar uk-offcanvas-bar-flip">
            <div class="uk-panel">
                <?php 
                    if(is_active_sidebar( 'setting-canvas-sidebar' )){
                        dynamic_sidebar( 'setting-canvas-sidebar' );
                    }
                ?>
            </div>
        </div>
    </div>
<?php
}

/*==========================================================================
Sidebar
==========================================================================*/
add_action( 'widgets_init' , 'owlshop_sidebar_setup' );
function owlshop_sidebar_setup(){
    register_sidebar(array(
        'name'          => __( 'Shop Sidebar','owlshop' ),
        'id'            => 'shop-sidebar',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Shop Single Sidebar','owlshop' ),
        'id'            => 'shop-single-sidebar',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Blog Sidebar','owlshop' ),
        'id'            => 'blog-sidebar',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Visual Composer Sidebar','owlshop' ),
        'id'            => 'visual-sidebar',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Setting Canvas Sidebar','owlshop' ),
        'id'            => 'setting-canvas-sidebar',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

    register_sidebar(array(
        'name'          => __( 'Footer 1','owlshop' ),
        'id'            => 'footer-1',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    
    register_sidebar(array(
        'name'          => __( 'Footer 2','owlshop' ),
        'id'            => 'footer-2',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => __( 'Footer 3','owlshop' ),
        'id'            => 'footer-3',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));
    register_sidebar(array(
        'name'          => __( 'Footer 4','owlshop' ),
        'id'            => 'footer-4',
        'description'   => __( 'Appears on posts and pages in the sidebar.','owlshop'),
        'before_widget' => '<aside id="%1$s" class="widget clearfix %2$s"><div class="widget-inner">',
        'after_widget'  => '</div></aside>',
        'before_title'  => '<h3 class="widget-title"><span>',
        'after_title'   => '</span></h3>'
    ));

}

/*==========================================================================
Header Config
==========================================================================*/

add_filter( 'owlshop_header_layout', 'owlshop_header_layout_func',100 );
function owlshop_header_layout_func(){
    global $wp_query;
    $template = owlshop_get_option('header',1);

    if(is_page()){
        $header = get_post_meta( $wp_query->get_queried_object_id(), '_owlshop_header_style',true );
        if($header!='global' && $header!=''){
            $template = $header;
        }
    }
    return $template;
}

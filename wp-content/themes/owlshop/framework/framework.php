<?php
global $theme_option;

/*==========================================================================
Required Plugins
==========================================================================*/
function owlshop_theme_activation($oldname, $oldtheme=false) {
    wp_redirect('admin.php?page=_options');
}
add_action("after_switch_theme", "owlshop_theme_activation", 10, 2);


if(!function_exists('owlshop_get_option')):
    function owlshop_get_option( $id,$default='' ){
        global $theme_option;
        if(isset($theme_option[$id])){
            return $theme_option[$id];
        }else{
            return $default;
        }
    }
endif;
/*==========================================================================
Breadcrumb
==========================================================================*/
if(!function_exists('owlshop_breadcrumb')):
function owlshop_breadcrumb() {
        global $post;
        $blog_title = 'Blog';

        echo '<ul class="breadcrumbs">';

        if ( !is_front_page() ) {
            echo '<li><a href="';
            echo esc_url(home_url('/'));
            echo '">'.__('Home', 'owlshop');
            echo "</a></li>";
        }

        $params['link_none'] = '';
        $separator = '';
        
        if (is_tax()) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            $link = get_term_link( $term );
            
            if ( is_wp_error( $link ) ) {
                echo sprintf('<li>%s</li>', $term->name );
            } else {
                echo sprintf('<li><a href="%s" title="%s">%s</a></li>', $link, $term->name, $term->name );
            }
        }

        if(is_home()) { echo '<li>'.$blog_title.'</li>'; }
        if(is_page() && !is_front_page()) {
            $parents = array();
            $parent_id = $post->post_parent;
            while ( $parent_id ) :
                $page = get_page( $parent_id );
                if ( $params["link_none"] )
                    $parents[]  = get_the_title( $page->ID );
                else
                    $parents[]  = '<li><a href="' . get_permalink( $page->ID ) . '" title="' . get_the_title( $page->ID ) . '">' . get_the_title( $page->ID ) . '</a></li>' . $separator;
                $parent_id  = $page->post_parent;
            endwhile;
            $parents = array_reverse( $parents );
            echo join( '', $parents );
            echo '<li>'.get_the_title().'</li>';
        }
        
        if(is_single()) {
            $categories_1 = get_the_category($post->ID);
            if($categories_1):
                foreach($categories_1 as $cat_1):
                    $cat_1_ids[] = $cat_1->term_id;
                endforeach;
                $cat_1_line = implode(',', $cat_1_ids);
            endif;
            if( isset( $cat_1_line ) && $cat_1_line ) {
                $categories = get_categories(array(
                    'include' => $cat_1_line,
                    'orderby' => 'id'
                ));
                if ( $categories ) :
                    foreach ( $categories as $cat ) :
                        $cats[] = '<li><a href="' . get_category_link( $cat->term_id ) . '" title="' . $cat->name . '">' . $cat->name . '</a></li>';
                    endforeach;
                    echo join( '', $cats );
                endif;
            }
            echo '<li>'.get_the_title().'</li>';
        }
        if( is_tag() ){ echo '<li>'."Tag: ".single_tag_title('',FALSE).'</li>'; }
        if( is_search() ){ echo '<li>'. __('Search results for: " ', 'owlshop') . get_search_query().' "</li>'; }
        if( is_year() ){ echo '<li>'.get_the_time('Y').'</li>'; }
        
        if( is_404() ) { 
            echo '<li>'.__("404 - Page not Found", 'owlshop').'</li>'; 
        }  
             
        if (is_category() && !is_singular('avada_portfolio')) {
            $category = get_the_category();
            $ID = $category[0]->cat_ID;
            echo is_wp_error( $cat_parents = get_category_parents($ID, TRUE, '', FALSE ) ) ? '' : '<li>'.$cat_parents.'</li>';
        }

        if( is_archive() && is_post_type_archive() ) {              
            $title = post_type_archive_title( '', false );
            echo '<li>'. $title .'</li>';
        }

        echo "</ul>";
}
endif;

if( ! function_exists( 'owlshop_page_title_bar' ) ) {
function owlshop_page_title_bar( $title, $subtitle, $secondary_content ) {
?>
    <div class="page-title-container" <?php echo apply_filters( 'owlshop_breadcrumb_bg','' ); ?>>
        <div class="page-title container">
            <div class="page-title-wrapper">
                <?php echo "\t" . $secondary_content; ?>
            </div>
        </div>
    </div>
<?php }
}

if( ! function_exists( 'owlshop_current_page_title_bar' ) ) {
    function owlshop_current_page_title_bar() {
        $blog_title = 'Blog';
        $blog_subtitle = '';
        global $wp_query;
        ob_start();
        if( ( class_exists( 'Woocommerce' ) && is_woocommerce() ) || ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) ) {
            woocommerce_breadcrumb(array(
                'wrap_before' => '<ul class="breadcrumbs">',
                'wrap_after' => '</ul>',
                'before' => '<li>',
                'after' => '</li>',
                'delimiter' => ''
            ));
        } else if( class_exists( 'bbPress' ) && is_bbpress() ) {
            bbp_breadcrumb( array ( 'before' => '<ul class="breadcrumbs">', 'after' => '</ul>', 'sep' => ' ', 'crumb_before' => '<li>', 'crumb_after' => '</li>', 'home_text' => __('Home', 'owlshop')) );
        } else {
            owlshop_breadcrumb();
        }
        $secondary_content = ob_get_contents();
        ob_get_clean();

        $title = '';
        $subtitle = '';

        if( ! $title ) {
            $title = get_the_title();

            if( is_home() ) {
                $title = $blog_title;
            }

            if( is_search() ) {
                $title = __('Search', 'owlshop');
            }

            if( is_404() ) {
                $title = __('Error 404 Page', 'owlshop');
            }
            
            if( is_archive() ) {
                if ( is_day() ) {
                    $title = __( 'Daily Archives:', 'owlshop' ) . '<span> ' . get_the_date() . '</span>';
                } else if ( is_month() ) {
                    $title = __( 'Monthly Archives:', 'owlshop' ) . '<span> ' . get_the_date( _x( 'F Y', 'monthly archives date format', 'owlshop' ) ) . '</span>';
                } elseif ( is_year() ) {
                    $title = __( 'Yearly Archives:', 'owlshop' ) . '<span> ' . get_the_date( _x( 'Y', 'yearly archives date format', 'owlshop' ) ) . '</span>';
                } elseif ( is_author() ) {
                    $curauth = get_user_by( 'id', get_query_var( 'author' ) );
                    $title = $curauth->nickname;
                } elseif( is_post_type_archive() ) {                
                    $title = post_type_archive_title( '', false );
                } else {
                    $title = single_cat_title( '', false );
                }
            }

            if( class_exists( 'Woocommerce' ) && is_woocommerce() && ! is_search() ) {
                if( ( is_product() || is_shop() ) && ! is_product() ) {
                    $title = woocommerce_page_title( false );
                }else if( is_product_category() || is_product_tag() ){
                    $current_term = $wp_query->get_queried_object();
                    $title = $current_term->name;
                }
            }
        }

        if ( ! $subtitle ) {
            if( is_home() ) {
                $subtitle = $blog_subtitle;
            }
        }


        owlshop_page_title_bar( $title, $subtitle, $secondary_content );
    }
}

/*==========================================================================
Breadcrumb Config
==========================================================================*/
add_filter( 'owlshop_breadcrumb_bg', 'owlshop_breadcrumb_bg_func' );
if(!function_exists('owlshop_breadcrumb_bg_func')){
    function owlshop_breadcrumb_bg_func(){
        $style = '';
        global $theme_option,$wp_query;
        if(is_page()){
            $bg = get_post_meta( $wp_query->get_queried_object_id(), '_owlshop_bg_breadcrumb',true );
            if( $bg!='' ){
                $style.='style="background-image: url('.esc_url( $bg ).');"';
            }
        }
        return $style;
    }
}

/*==========================================================================
Required Plugins
==========================================================================*/
function owlshop_required_plugins(){
    $config = array(
        'domain'               => 'owlshop',             // Text domain - likely want to be the same as your theme.
        'default_path'         => '',                             // Default absolute path to pre-packaged plugins
        'parent_menu_slug'     => 'themes.php',                 // Default parent menu slug
        'parent_url_slug'      => 'themes.php',                 // Default parent URL slug
        'menu'                 => 'install-required-plugins',     // Menu slug
        'has_notices'          => true,                           // Show admin notices or not
        'is_automatic'         => false,                           // Automatically activate plugins after installation or not
        'message'              => '',                            // Message to output right before the plugins table
        'strings'              => array(
            'page_title'                                    => __( 'Install Required Plugins','owlshop'),
            'menu_title'                                    => __( 'Install Plugins','owlshop'),
            'installing'                                    => __( 'Installing Plugin: %s','owlshop'), // %1$s = plugin name
            'oops'                                          => __( 'Something went wrong with the plugin API.','owlshop'),
            'notice_can_install_required'                   => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','owlshop' ), // %1$s = plugin name(s)
            'notice_can_install_recommended'                => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','owlshop' ), // %1$s = plugin name(s)
            'notice_cannot_install'                         => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','owlshop' ), // %1$s = plugin name(s)
            'notice_can_activate_required'                  => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','owlshop' ), // %1$s = plugin name(s)
            'notice_can_activate_recommended'               => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','owlshop' ), // %1$s = plugin name(s)
            'notice_cannot_activate'                        => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','owlshop' ), // %1$s = plugin name(s)
            'notice_ask_to_update'                          => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','owlshop' ), // %1$s = plugin name(s)
            'notice_cannot_update'                          => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','owlshop' ), // %1$s = plugin name(s)
            'install_link'                                  => _n_noop( 'Begin installing plugin', 'Begin installing plugins','owlshop' ),
            'activate_link'                                 => _n_noop( 'Activate installed plugin', 'Activate installed plugins','owlshop' ),
            'return'                                        => __( 'Return to Required Plugins Installer','owlshop'),
            'plugin_activated'                              => __( 'Plugin activated successfully.' ,'owlshop'),
            'complete'                                      => __( 'All plugins installed and activated successfully. %s' ,'owlshop'), // %1$s = dashboard link
            'nag_type'                                      => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
        )
    );
    $plugins = apply_filters( 'owlshop_list_plugins_required' , array() );
    tgmpa( $plugins , $config );
}
add_action( 'tgmpa_register','owlshop_required_plugins' );

add_action('owlshop_set_logo','owlshop_set_logo_func');
function owlshop_set_logo_func(){
    global $theme_option,$wp_query;
    $logo_link = get_post_meta( $wp_query->get_queried_object_id() , '_owlshop_logo_override' , true );
    if($logo_link==''){
        $logo_link = $theme_option['logo']['url'];
    }
?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <img src="<?php echo esc_url($logo_link); ?>" alt="<?php bloginfo( 'name' ); ?>">
    </a>
<?php
}
/*==========================================================================
Main Menu Off-canvas
==========================================================================*/
add_action( 'owlshop_before_wrapper' , 'owlshop_menu_offcanvas' );
function owlshop_menu_offcanvas(){

?>
    <div id="pgl-off-canvas" class="uk-offcanvas">
        <?php
            $args = array(  'theme_location' => 'mainmenu',
                'container_class' => 'uk-offcanvas-bar',
                'menu_class' => 'uk-nav uk-nav-offcanvas uk-nav-parent-icon',
                'fallback_cb' => '',
                'menu_id' => 'main-menu-offcanvas',
                'items_wrap' => '<ul id="%1$s" class="%2$s" data-uk-nav>%3$s</ul>',
                'walker' => new PGL_Megamenu_Offcanvas()
            );
            wp_nav_menu($args);
        ?>
    </div>
<?php
}

/*==========================================================================
Post View
==========================================================================*/
add_action('wp_head', 'owlshop_framework_setpostviews' );
function owlshop_framework_setpostviews() {
    global $post;
    if('post' == get_post_type() && is_single()) {
        $postID = $post->ID;
        if(!empty($postID)) {
            $count_key = 'pgl_post_views_count';
            $count = get_post_meta($postID, $count_key, true);
            if($count == '') {
                $count = 0;
                delete_post_meta($postID, $count_key);
                add_post_meta($postID, $count_key, '0');
            } else {
                $count++;
                update_post_meta($postID, $count_key, $count);
            }
        }
    }
}

/*==========================================================================
Register Header Meta
==========================================================================*/
function owlshop_wp_set_meta(){
?>
    <meta http-equiv="Content-Type" content="text/html;charset="/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<?php   
}


add_action('wp_enqueue_scripts', 'owlshop_Framework_Register_Meta' ,1);
function owlshop_Framework_Register_Meta(){
	global $wp_query,$theme_option;
?>
<link rel="pingback" href="<?php echo esc_html( get_bloginfo( 'pingback_url' ) ); ?>">
<?php 
    if ( ! function_exists( 'has_site_icon' ) ) {
        $link = $theme_option['favicon']['url'];
        if($link!=''){
           echo '<link rel="shortcut icon" href="'.esc_url($link).'" type="image/x-icon">';
        }
    }
?>
<?php if( isset($theme_option['apple_icon']['url']) && $theme_option['apple_icon']['url']!=''):?>
<link rel="apple-touch-icon" href="<?php echo esc_url($theme_option['apple_icon']['url']); ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_57']['url']) && $theme_option['apple_icon_57']['url']!=''):?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo esc_url($theme_option['apple_icon_57']['url']); ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_72']['url']) && $theme_option['apple_icon_72']['url']!=''):?>
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo esc_url($theme_option['apple_icon_72']['url']); ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_114']['url']) && $theme_option['apple_icon_114']['url']!=''):?>
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo esc_url($theme_option['apple_icon_114']['url']); ?>" />
<?php endif;?>

<?php if( isset($theme_option['apple_icon_144']['url']) && $theme_option['apple_icon_144']['url']!=''):?>
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo esc_url($theme_option['apple_icon_144']['url']); ?>" />
<?php endif;?>
<?php
}

/*==========================================================================
Render Sidebar
==========================================================================*/
function owlshop_layout_config_sidebar(){ ?>
    <?php if(apply_filters( 'owlshop_is_sidebar_left' , false )){ ?>
        <div class="pgl-sidebar sidebar-left <?php echo apply_filters( 'owlshop_sidebar_left_class', 'col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9' ); ?>">
            <?php $leftsidebar = apply_filters( 'owlshop_sidebar_left', '' ); ?>
            <?php if(is_active_sidebar($leftsidebar)): ?>
                <div class="sidebar-inner">
                    <?php dynamic_sidebar($leftsidebar); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php } ?>

    <?php if(apply_filters( 'owlshop_is_sidebar_right' , false )){ ?>
        <div class="pgl-sidebar sidebar-right <?php echo apply_filters( 'owlshop_sidebar_right_class', 'col-sm-4 col-md-3' ); ?>">
            <?php $rightsidebar = apply_filters( 'owlshop_sidebar_right' , '' ); ?>
            <?php if(is_active_sidebar($rightsidebar)): ?>
                <div class="sidebar-inner">
                    <?php dynamic_sidebar($rightsidebar); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php } 
}
add_action('owlshop_sidebar_render','owlshop_layout_config_sidebar');


/*==========================================================================
Layout Config
==========================================================================*/
function owlshop_layout_config(){
    global $theme_option,$wp_query;
    $layout = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $layout = $theme_option['woo-shop-layout'];
    }else if( function_exists('is_product') && is_product()){
        $layout = $theme_option['woo-single-layout'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $layout = get_post_meta( $page_id, '_owlshop_page_layout', true );
    }else{
        $layout = $theme_option['blog-layout'];
    }

    add_filter( 'owlshop_sidebar_right' , 'owlshop_set_sidebar_right' );
    add_filter( 'owlshop_sidebar_left' , 'owlshop_set_sidebar_left' );

    switch ($layout) {
        // Two Sidebar
        case '4':
            add_filter( 'owlshop_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'owlshop_sidebar_right_class' , create_function('', 'return "col-sm-6  col-md-3";') );
            add_filter( 'owlshop_main_class' , create_function('', 'return "col-md-6 col-md-push-3 pgl-main-two-sidebar";') );
            add_filter( 'owlshop_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'owlshop_is_sidebar_right', create_function('', 'return true;') );
            break;
        //One Sidebar Right
        case '3':
            add_filter( 'owlshop_sidebar_right_class' , create_function('', 'return "col-md-3";') );
            add_filter( 'owlshop_main_class' , create_function('', 'return "col-md-9 pgl-main-right-sidebar";') );
            add_filter( 'owlshop_is_sidebar_right', create_function('', 'return true;') );
            break;
        // One Sidebar Left
        case '2':
            add_filter( 'owlshop_sidebar_left_class' , create_function('', 'return "col-md-3 col-md-pull-9";') );
            add_filter( 'owlshop_main_class' , create_function('', 'return "col-md-9 col-md-push-3 pgl-main-left-sidebar";') );
            add_filter( 'owlshop_is_sidebar_left', create_function('', 'return true;') );
            break;

        case '6':
            add_filter( 'owlshop_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3";') );
            add_filter( 'owlshop_sidebar_right_class' , create_function('', 'return "col-sm-6 col-md-3";') );
            add_filter( 'owlshop_main_class' , create_function('', 'return " col-md-6";') );
            add_filter( 'owlshop_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'owlshop_is_sidebar_right', create_function('', 'return true;') );
            break;

        case '5':
            add_filter( 'owlshop_sidebar_left_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'owlshop_sidebar_right_class' , create_function('', 'return "col-sm-6 col-md-3 col-md-pull-6";') );
            add_filter( 'owlshop_main_class' , create_function('', 'return "col-md-6 col-md-push-6";') );
            add_filter( 'owlshop_is_sidebar_left', create_function('', 'return true;') );
            add_filter( 'owlshop_is_sidebar_right', create_function('', 'return true;') );
            break;

        // Fullwidth
        default:
            add_filter( 'owlshop_main_class' , create_function('', 'return "col-xs-12 pgl-main-no-sidebar";') );
            add_filter( 'owlshop_is_sidebar_left', create_function('', 'return false;') );
            add_filter( 'owlshop_is_sidebar_right', create_function('', 'return false;') );
            break;
    }
}
add_action('wp_head','owlshop_layout_config');

/*==========================================================================
Layout Sidebar
==========================================================================*/
function owlshop_set_sidebar_right(){
    global $theme_option,$wp_query;
    $sidebar = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $sidebar = $theme_option['woo-shop-sidebar'];
    }elseif(function_exists('is_product') && is_product()){
        $sidebar = $theme_option['woo-single-sidebar'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $sidebar = get_post_meta( $page_id, '_owlshop_page_right_sidebar', true );
    }else{
        $sidebar = $theme_option['blog-right-sidebar'];
    }
    return $sidebar;
}

function owlshop_set_sidebar_left(){
    global $theme_option,$wp_query;
    $sidebar = '';
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $sidebar = $theme_option['woo-shop-sidebar'];
    }elseif(function_exists('is_product') && is_product()){
        $sidebar = $theme_option['woo-single-sidebar'];
    }else if( is_page() ){
        $page_id = $wp_query->get_queried_object_id();
        $sidebar = get_post_meta( $page_id, '_owlshop_page_left_sidebar', true );
    }else{
        $sidebar = $theme_option['blog-left-sidebar'];
    }
    return $sidebar;
}


/*==========================================================================
Enable Effect Scroll
==========================================================================*/
if(isset($theme_option['is-effect-scroll']) && $theme_option['is-effect-scroll'] ){
    add_filter('body_class','owlshop_enable_effect_scroll');
    function owlshop_enable_effect_scroll($classes){
        $classes[] = 'pgl-animate-scroll';
        return $classes;
    }
}

/*==========================================================================
Back To Top
==========================================================================*/
if(isset($theme_option['is-back-to-top']) && $theme_option['is-back-to-top'] ){
    add_filter('owlshop_after_wrapper','owlshop_back_to_top_button');
    function owlshop_back_to_top_button(){
    ?>
        <a class="scroll-to-top visible" href="#" id="scrollToTop">
            <i class="fa fa-angle-up"></i>
        </a>
    <?php
    }
}

/*==========================================================================
Ajax Url
==========================================================================*/
add_action('wp_head','owlshop_framework_init_ajax_url',15);
function owlshop_framework_init_ajax_url() {
?>
	<script type="text/javascript">
		var ajaxurl = '<?php echo esc_url( admin_url('admin-ajax.php') ); ?>';
	</script>
	<?php
}

/*==========================================================================
Fix HTML5/Css3
==========================================================================*/
add_action('wp_head','owlshop_framework_check_HTML5',100);
function  owlshop_framework_check_HTML5(){
	?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.js"></script>
<![endif]-->
	<?php
}

/*==========================================================================
Fix Vimeo
==========================================================================*/
add_action('init','owlshop_framework_add_vimeo_oembed_correctly');
function owlshop_framework_add_vimeo_oembed_correctly() {
    wp_oembed_add_provider( '#http://(www\.)?vimeo\.com/.*#i', 'http://vimeo.com/api/oembed.{format}', true );
}

/*==========================================================================
Fix Embed
==========================================================================*/
add_filter( 'oembed_result', 'owlshop_framework_fix_oembeb' );
function owlshop_framework_fix_oembeb( $url ){
    $array = array (
        'webkitallowfullscreen'     => '',
        'mozallowfullscreen'        => '',
        'frameborder="0"'           => '',
        '</iframe>)'        => '</iframe>'
    );
    $url = strtr( $url, $array );

    if ( strpos( $url, "<embed src=" ) !== false ){
        return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $url);
    }
    elseif ( strpos ( $url, 'feature=oembed' ) !== false ){
        return str_replace( 'feature=oembed', esc_url('feature=oembed&wmode=opaque'), $url );
    }
    else{
        return $url;
    }
}
/*==========================================================================
Search Filter
==========================================================================*/
add_filter('pre_get_posts','owlshop_framework_search_filter');
function owlshop_framework_search_filter($query) {
    if (isset($_GET['s']) && empty($_GET['s']) && $query->is_main_query()){
        $query->is_search = true;
        $query->is_home = false;
    }
	return $query;
}

/*==========================================================================
Add Shortcode Widget Text
==========================================================================*/
add_filter('widget_text', 'do_shortcode');

/*==========================================================================
Remove Dimension Image
==========================================================================*/
add_filter( 'post_thumbnail_html', 'owlshop_framework_remove_thumbnail_dimensions' , 10, 3 );
function owlshop_framework_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
	$html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
	return $html;
}


/*==========================================================================
Set Custom CSS/JS
==========================================================================*/
function owlshop_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);
   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return implode(',', $rgb); // returns an array with the rgb values
}

function owlshop_rgb2hex($rgb) {
    $rgb = explode(',', $rgb);
    $hex = "#";
    $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
    $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

    return $hex; 
}

function owlshop_adjustColorLightenDarken($color_code,$percentage_adjuster = 0) {
    $percentage_adjuster = round($percentage_adjuster/100,2);
    if(is_array($color_code)) {
        $r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
        $g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
        $b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);

        return array("r"=> round(max(0,min(255,$r))),
            "g"=> round(max(0,min(255,$g))),
            "b"=> round(max(0,min(255,$b))));
    }
    else if(preg_match("/#/",$color_code)) {
        $hex = str_replace("#","",$color_code);
        $r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
        $g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
        $b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
        $r = round($r - ($r*$percentage_adjuster));
        $g = round($g - ($g*$percentage_adjuster));
        $b = round($b - ($b*$percentage_adjuster));

        return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
            .str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);

    }
}

add_action('wp_head','owlshop_framework_custom_style_css',98);
function owlshop_framework_custom_style_css(){
    echo '<style type="text/css" id="pgl-color-style">';
        get_template_part( 'css/color' );
    echo '</style>';
}

add_action('wp_head','owlshop_framework_init_custom_code',99);
function owlshop_framework_init_custom_code(){
	global $theme_option;
    $str = '';
	if($theme_option['custom-css']!=''){
		$str.='
		<style type="text/css">'.$theme_option['custom-css'].'</style>';
	}
	if($theme_option['custom-js']!=''){
		$str.='
		<script type="text/javascript">'.esc_js($theme_option['custom-js']).'</script>';
	}
	echo "\t" . $str;
}

/*==========================================================================
Add Scripts Admin
==========================================================================*/
add_filter( 'body_class','owlshop_framework_style_layout' );
function owlshop_framework_style_layout($classes){
    global $theme_option,$wp_query;
    if(isset($theme_option['style_layout']) && $theme_option['style_layout']=='boxed'){
        $classes[] = 'boxed';
    }
    return $classes;
}

/*==========================================================================
Footer Layout
==========================================================================*/
add_action( 'owlshop_footer_layout_style', 'owlshop_func_footer_layout_style' );
function owlshop_func_footer_layout_style(){
    global $theme_option,$wp_query;
    $pageid = $wp_query->get_queried_object_id();

    $footer_id = get_post_meta( $pageid , '_owlshop_footer_style' , true );
    if($footer_id=='' || $footer_id=='global'){
        if( $theme_option['is-footer-custom'] == true ){
            $footer_id = $theme_option['footer'];
        }else{
            get_template_part( 'templates/footer/default' );
            return;
        }
    }
    if($footer_id){
        echo  do_shortcode(str_replace('css=','footer_css=',get_post( $footer_id )->post_content )) ;
    }
}


/*==========================================================================
Add Scripts Admin
==========================================================================*/
add_action( 'admin_enqueue_scripts', 'owlshop_framework_init_script' ,10 );
function owlshop_framework_init_script(){
    wp_enqueue_script( 'owlshop_framework_js', PGL_FRAMEWORK_URI . 'admin/js/main.js' );
    wp_enqueue_style( 'owlshop_framework_js' , PGL_FRAMEWORK_URI . 'admin/css/main.css' );
}

/*==========================================================================
						Function Define
==========================================================================*/

function owlshop_getAgo($timestamp){
	// return $timestamp;
	$timestamp = strtotime($timestamp);
	$difference = time() - $timestamp;

    if ($difference < 60) {
        return $difference.__(" seconds ago",'owlshop');
    } else {
        $difference = round($difference / 60);
    }

    if ($difference < 60) {
        return $difference.__(" minutes ago",'owlshop');
    } else {
        $difference = round($difference / 60);
    }

    if ($difference < 24) {
        return $difference.__(" hours ago",'owlshop');
    }
    else {
        $difference = round($difference / 24);
    }

    if ($difference < 7) {
        return $difference.__(" days ago",'owlshop');
    } else {
        $difference = round($difference / 7);
        return $difference.__(" weeks ago",'owlshop');
    }
}

function owlshop_get_excerpt($limit,$afterlimit='[...]') {
	$excerpt = get_the_excerpt();
    if($excerpt != ''){
	   $excerpt = explode(' ', strip_tags($excerpt), $limit);
    }else{
        $excerpt = explode(' ', strip_tags(get_the_content( )), $limit);
    }
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).' '.$afterlimit;
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return strip_shortcodes( $excerpt );
}

function owlshop_list_comments($comment, $args, $depth){
    $path = PGL_THEME_DIR . '/templates/list_comments.php';
    if( is_file($path) ) require ($path);
}

function owlshop_make_id($length = 5){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function owlshop_comment_form($arg,$class='btn-primary',$id='submit'){
	ob_start();
	comment_form($arg);
	$form = ob_get_clean();
	echo str_replace('id="submit"','id="'.$id.'" class="btn '.$class.'"', $form);
}

function owlshop_get_post_views($postID){
    $count_key = 'pgl_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return 0;
    }
    return $count;
}

function owlshop_share_box( $layout='',$args=array() ){
	$default = array(
		'position' => 'top',
		'animation' => 'true'
		);
	$args = wp_parse_args( (array) $args, $default );
}

function owlshop_embed() {
    $link = get_post_meta(get_the_ID(),'_owlshop_post_video',true);
    echo  wp_oembed_get($link);
}

function owlshop_gallery($size='full'){
    $output = array();
    $galleries = get_post_gallery( get_the_ID(), false );
    if(isset($galleries['ids'])){
        $img_ids = explode(",",$galleries['ids']);
        foreach ($img_ids as $key => $id){
            $img_src = wp_get_attachment_image_src($id,$size);
            $output[] = $img_src[0];
        }
    }
    return $output;
}

//page navegation
function owlshop_pagination($prev = 'Prev', $next = 'Next', $pages='' ,$args=array('class'=>'')) {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
    if($pages==''){
        global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
    }
    $pagination = array(
        'base' => @add_query_arg('paged','%#%'),
        'format' => '',
        'total' => $pages,
        'current' => $current,
        'prev_text' => __('Prev','owlshop'),
        'next_text' => __('Next','owlshop'),
        'type' => 'array'
    );
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );

    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
    if(paginate_links( $pagination )!=''){
        $paginations = paginate_links( $pagination );
        echo '<div class="pgl-paging-footer clearfix"><nav class="paging">';
        echo '<ul class="pagination '.$args["class"].'">';
            foreach ($paginations as $key => $pg) {
                echo '<li>'.$pg.'</li>';
            }
        echo '</ul>';
        echo '</nav></div>';
    }
}


function owlshop_string_limit_words($string, $word_limit){
    $words = explode(' ', $string, ($word_limit + 1));

    if(count($words) > $word_limit) {
        array_pop($words);
    }

    return implode(' ', $words);
}
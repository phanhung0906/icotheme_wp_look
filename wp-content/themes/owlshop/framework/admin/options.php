<?php
if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            
        }

        
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'owlshop'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'owlshop'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'owlshop'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="Current theme preview" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="Current theme preview" />
                <?php endif; ?>

                <h4><?php echo esc_html($this->theme->display('Name')); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'owlshop'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'owlshop'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'owlshop') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo esc_html($this->theme->display('Description')); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.</p>', 'http://codex.wordpress.org/Child_Themes' , $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $imagepath = get_template_directory_uri().'/images/';

            $generate_settings = array(
                array(
                    'id'        => 'logo',
                    'type'      => 'media',
                    'url'       => true,
                    'title'     => __('Logo', 'owlshop'),
                    'compiler'  => 'true',
                    'default'   => array('url' => get_template_directory_uri() . '/images/logo.png')
                ),
                array(
                    'id' => 'apple_icon',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Apple Touch Icon', 'owlshop'),
                    'compiler' => 'true',
                    'desc' => __('Upload your Apple touch icon 57x57.', 'owlshop'),
                ),
                array(
                    'id' => 'apple_icon_57',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Apple Touch Icon 57x57', 'owlshop'),
                    'compiler' => 'true',
                    'desc' => __('Upload your Apple touch icon 57x57.', 'owlshop'),
                ),
                array(
                    'id' => 'apple_icon_72',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Apple Touch Icon 72x72', 'owlshop'),
                    'compiler' => 'true',
                    'desc' => __('Upload your Apple touch icon 72x72.', 'owlshop'),
                ),
                array(
                    'id' => 'apple_icon_114',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Apple Touch Icon 114x114', 'owlshop'),
                    'compiler' => 'true',
                    'desc' => __('Upload your Apple touch icon 114x114.', 'owlshop')                        ,
                ),
                array(
                    'id' => 'apple_icon_144',
                    'type' => 'media',
                    'url' => true,
                    'title' => __('Apple Touch Icon 144x144', 'owlshop'),
                    'compiler' => 'true',
                    'desc' => __('Upload your Apple touch icon 144x144.', 'owlshop')                        ,
                ),
                array(
                    'id'    => 'opt-divide',
                    'type'  => 'divide'
                ),
                array(
                    'id'        => '404_text',
                    'type'      => 'editor',
                    'title'     => __('404 Text', 'owlshop'),
                    'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'owlshop'),
                    'default'   => "This is Photoshop's version  of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum,",
                ),
                array(
                    'id'        => 'is-effect-scroll',
                    'type'      => 'switch',
                    'title'     => __('Enable Effect Scroll', 'owlshop'),
                    'default'   => true
                ),
                array(
                    'id'        => 'is-back-to-top',
                    'type'      => 'switch',
                    'title'     => __('Enable Back to Top button', 'owlshop'),
                    'default'   => true
                ),
            );
            if ( ! function_exists( 'has_site_icon' ) ) {
                $generate_settings[] = array(
                    'id'        => 'favicon',
                    'type'      => 'media',
                    'url'       => true,
                    'title'     => __('Favicon', 'owlshop'),
                    'compiler'  => 'true',
                    'default'   => array('url' => '')
                );
            }

            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('General Settings', 'owlshop'),
                'desc'      => '',
                'icon'      => 'el-icon-home',
                'fields'    => $generate_settings
            );

            $path_image = PGL_FRAMEWORK_URI . 'admin/images/';
            
            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Styling Options', 'owlshop'),
                'fields'    => array(
                    array(
                        'id'        => 'is-optimize-css',
                        'type'      => 'switch',
                        'title'     => __('Optimize CSS', 'accessories'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'is-optimize-js',
                        'type'      => 'switch',
                        'title'     => __('Optimize JS', 'accessories'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'style_layout',
                        'type'      => 'button_set',
                        'title'     => __('Layout Style', 'owlshop'),
                        'desc'      => __('Choose Your Layout Style.', 'owlshop'),
                        'options'   => array(
                            'wide' => 'Wide', 
                            'boxed' => 'Boxed', 
                        ),
                        'default'   => 'wide'
                    ),
                    array(
                        'id'        => 'custom-css',
                        'type'      => 'ace_editor',
                        'title'     => __('CSS Code', 'owlshop'),
                        'subtitle'  => __('Paste your CSS code here.', 'owlshop'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        'default'   => ""
                    ),
                    array(
                        'id'        => 'custom-js',
                        'type'      => 'ace_editor',
                        'title'     => __('JS Code', 'owlshop'),
                        'subtitle'  => __('Paste your JS code here.', 'owlshop'),
                        'mode'      => 'js',
                        'theme'     => 'monokai',
                        'desc'      => 'Possible modes can be found at <a href="http://ace.c9.io" target="_blank">http://ace.c9.io/</a>.',
                        'default'   => ""
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-qrcode',
                'title'     => __('Header Settings', 'owlshop'),
                'fields'    => array(
                    array(
                        'id'        => 'header',
                        'type'      => 'select',
                        'title'     => __('Header Layout', 'owlshop'),
                        'options'   => array(
                                '1' => 'Header Style 1',
                            ),
                        'default'   => '1'
                    ),
                    array(
                        'id'        => 'header-is-cart',
                        'type'      => 'switch',
                        'title'     => __('Enable Cart Header', 'owlshop'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header-is-search',
                        'type'      => 'switch',
                        'title'     => __('Enable Search Header', 'owlshop'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'header-is-settings',
                        'type'      => 'switch',
                        'title'     => __('Enable Setting Sidebar Canvas', 'owlshop'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog-left-sidebar',
                        'type'      => 'select',
                        'required'  => array('header-is-settings', '=', '1'),
                        'title'     => __('Sidebar Canvas', 'owlshop'),
                        'data'      => 'sidebars',
                        'default'   => 'setting-canvas-sidebar'
                    ),
                )
            );
            
            

            $footers_type = get_posts( array('posts_per_page'=>-1,'post_type'=>'footer') );
            $footers_option = array();
            foreach ($footers_type as $key => $value) {
                $footers_option[$value->ID] = $value->post_title;
            }
            
            $this->sections[] = array(
                'icon'      => 'el-icon-list-alt',
                'title'     => __('Footer Settings', 'owlshop'),
                'fields'    => array(
                    array(
                        'id'        => 'is-footer-custom',
                        'type'      => 'switch',
                        'title'     => __('Enable Footer Customize', 'owlshop'),
                        'default'   => false
                    ),
                    array(
                        'id'        => 'footer',
                        'type'      => 'select',
                        'required'  => array('is-footer-custom', '=', '1'),
                        'title'     => __('Footer Item', 'owlshop'),
                        'options'   => $footers_option,
                        'default'   => ''
                    ),
                    array(
                        'id'        => 'footer-copyright',
                        'type'      => 'editor',
                        'title'     => __('Footer Copyright', 'owlshop'),
                        'subtitle'  => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'owlshop'),
                        'default'   => ' ',
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-bold',
                'title'     => __('Blog Setting', 'owlshop'),
                'fields'    => array(
                    array(
                        'id'        => 'blog-layout',
                        'type'      => 'image_select',
                        'title'     => __('Images Option for Layout', 'owlshop'),
                        'subtitle'  => __('No validation can be done on this field type', 'owlshop'),
                        'desc'      => __('This uses some of the built in images, you can use them for layout options.', 'owlshop'),
                        //Must provide key => value(array:title|img) pairs for radio options
                        'options'   => array(
                            '1' => array('alt' => '1 Column',        'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            '4' => array('alt' => '3 Column Middle', 'img' => ReduxFramework::$_url . 'assets/img/3cm.png'),
                            '5' => array('alt' => '3 Column Left',   'img' => ReduxFramework::$_url . 'assets/img/3cl.png'),
                            '6' => array('alt' => '3 Column Right',  'img' => ReduxFramework::$_url . 'assets/img/3cr.png')
                        ), 
                        'default' => '1'
                    ),
                    array(
                        'id'        => 'blog-left-sidebar',
                        'type'      => 'select',
                        'title'     => __('Sidebar Left', 'owlshop'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-left'
                    ),
                    array(
                        'id'        => 'blog-right-sidebar',
                        'type'      => 'select',
                        'title'     => __('Sidebar Right', 'owlshop'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-right'
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-shopping-cart',
                'title'     => __('Woocommerce Settings', 'owlshop'),
                'fields'    => array(
                    array(
                        'id'        => 'woo-is-breadcrumb',
                        'type'      => 'switch',
                        'title'     => __('Enable Breadcrumb', 'owlshop'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-is-effect-thumbnail',
                        'type'      => 'switch',
                        'title'     => __('Enable Effect Image', 'owlshop'),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'woo-effect-thumbnail-skin',
                        'type'      => 'select',
                        'required'  => array('woo-is-effect-thumbnail', '=', '1'),
                        'title'     => __('Effect Skin', 'owlshop'),
                        'options'   => array(
                            'we-fade' => 'Fade',
                            'we-bottom-to-top' => 'Bottom to Top',
                            'we-flip-horizontal' => 'Flip Horizontal',
                            'we-flip-vertical' => 'Flip Vertical',
                        ),
                        'default'   => 'we-bottom-to-top'
                    ),
                ),
            );
            $this->sections[] = array(
                'title'     => __('Product Archives', 'owlshop'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'woo-shop-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Shop Layout', 'owlshop'),
                        'subtitle'  => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'owlshop'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                        ),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'woo-shop-sidebar',
                        'type'      => 'select',
                        'title'     => __('Shop Sidebar', 'owlshop'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-left'
                    ),
                    array(
                        'id'        => 'woo-shop-number',
                        'type'      => 'text',
                        'title'     => __('Shop show products', 'owlshop'),
                        'desc'      => __('To Change number of products displayed per page.', 'owlshop'),
                        'validate'  => 'numeric',
                        'default'   => '10',
                    ),
                    array(
                        'id'        => 'woo-shop-column',
                        'type'      => 'select',
                        'title'     => __('Shop Columns', 'owlshop'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                )
            );
            $this->sections[] = array(
                'title'     => __('Product Details', 'owlshop'),
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'woo-single-layout',
                        'type'      => 'image_select',
                        'compiler'  => true,
                        'title'     => __('Single Layout', 'owlshop'),
                        'subtitle'  => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'owlshop'),
                        'options'   => array(
                            '1' => array('alt' => '1 Column',       'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            '2' => array('alt' => '2 Column Left',  'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            '3' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                        ),
                        'default'   => '2'
                    ),
                    array(
                        'id'        => 'woo-single-sidebar',
                        'type'      => 'select',
                        'title'     => __('Single Sidebar', 'owlshop'),
                        'data'      => 'sidebars',
                        'default'   => 'sidebar-left'
                    ),
                    array(
                        'id'        => 'woo-related-number',
                        'type'      => 'text',
                        'title'     => __('Related show products', 'owlshop'),
                        'desc'      => __('To Change number of products displayed related.', 'owlshop'),
                        'validate'  => 'numeric',
                        'default'   => '4',
                    ),
                    array(
                        'id'        => 'woo-related-column',
                        'type'      => 'select',
                        'title'     => __('Related Columns', 'owlshop'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-upsells-number',
                        'type'      => 'text',
                        'title'     => __('Upsells show products', 'owlshop'),
                        'desc'      => __('To Change number of products displayed up-sell.', 'owlshop'),
                        'validate'  => 'numeric',
                        'default'   => '4',
                    ),
                    array(
                        'id'        => 'woo-upsells-column',
                        'type'      => 'select',
                        'title'     => __('Upsells Columns', 'owlshop'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                    array(
                        'id'        => 'woo-cross-sells-number',
                        'type'      => 'text',
                        'title'     => __('Cross Sells show products', 'owlshop'),
                        'desc'      => __('To Change number of products displayed cross sells.', 'owlshop'),
                        'validate'  => 'numeric',
                        'default'   => '4',
                    ),
                    array(
                        'id'        => 'woo-cross-sells-column',
                        'type'      => 'select',
                        'title'     => __('Cross Sells Columns', 'owlshop'),
                        'options'   => array(
                            '1' => '1 Column', 
                            '2' => '2 Columns', 
                            '3' => '3 Columns',
                            '4' => '4 Columns', 
                            '6' => '6 Columns',
                        ),
                        'default'   => '4'
                    ),
                )
            );
            $this->sections[] = array(
                'icon'      => 'el-icon-lines',
                'title'     => __('Megamenu Settings', 'owlshop'),
                'fields'    => array(
                    array(
                        'id'        => 'megamenu-animation',
                        'type'      => 'select',
                        'title'     => __('Animation', 'owlshop'),
                        'options'   => array(
                                'effect-none'   => 'None',
                                'bottom-to-top'         => 'Bottom to top',
                            ),
                        'desc'      => 'Select animation for Megamenu.',
                        'default' => 'effect-none',
                    ),
                    array(
                        'id'        => 'megamenu-duration',
                        'type'      => 'text',
                        'title'     => __('Duration', 'owlshop'),
                        'desc'      => __('Animation effect duration for dropdown of Megamenu (in miliseconds).', 'owlshop'),
                        'validate'  => 'numeric',
                        'default'   => '400',
                    ),
                ),
            );

            $this->sections[] = array(
                'type' => 'divide',
            );

             $this->sections[] = array(
                'title'     => __('Import / Export', 'owlshop'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'owlshop'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'owlshop'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'owlshop')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'owlshop'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'owlshop')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'owlshop');
        }

        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'theme_option',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Theme Options', 'owlshop'),
                'page_title'        => __('Theme Options', 'owlshop'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => false,                    // Enable basic customizer support
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,    
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'owlshop'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'owlshop');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'owlshop');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
    
}
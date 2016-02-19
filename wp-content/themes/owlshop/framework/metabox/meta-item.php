<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {
	global $theme_option;

	// Start with an underscore to hide fields from custom fields list
	$prefix = '_pgl_';
	$footers_type = get_posts( array('posts_per_page'=>-1,'post_type'=>'footer') );
    $footers_option = array();
    $footers_option['global'] = 'Use Global';
    foreach ($footers_type as $key => $value) {
        $footers_option[$value->ID] = $value->post_title;
    }

    $page_configs = array();
    $page_configs[] = array(
		'name' => __( 'Layout', 'owlshop' ),
		'desc' => __( 'Select Layout', 'owlshop' ),
		'id'   => $prefix . 'page_layout',
		'type' => 'layout',
		'default' => '1'
	);
    

    $page_configs[] = array(
				'name' => __( 'Left Sidebar', 'owlshop' ),
				'id'   => $prefix . 'page_left_sidebar',
				'type' => 'sidebar',
			);

    $page_configs[] = array(
				'name' => __( 'Right Sidebar', 'owlshop' ),
				'id'   => $prefix . 'page_right_sidebar',
				'type' => 'sidebar',
			);
    $page_configs[] = array(
				'name' => __( 'Show Breadcrumb', 'owlshop' ),
				'id'   => $prefix . 'show_breadcrumb',
				'type' => 'button_radio',
				'default'  => 'yes'
			);
    $page_configs[] = array(
				'name' => __( 'Show Title', 'owlshop' ),
				'id'   => $prefix . 'show_title',
				'type' => 'button_radio',
				'default'  => 'yes'
			);
    $page_configs[] = array(
				'name' => __( 'Blog pages show at most', 'owlshop' ),
				'id'   => $prefix . 'blog_count',
				'type' => 'text_number',
				'std'  => 6
			);
    $page_configs[] = array(
				'name'    => __( 'Blog Skin', 'owlshop' ),
				'id'      => $prefix . 'blog_skin',
				'type'    => 'select',
				'options' => array(
					'default' => 'Blog default',
					'mini' 	  => 'Blog mini sidebar',
					'masonry' 	  => 'Blog masonry',
				),
				'std' => 'global'
			);
    $page_configs[] = array(
				'name' => __( 'Blog Masonry column count', 'owlshop' ),
				'id'   => $prefix . 'blog_masonry_column_count',
				'type' => 'text_number',
				'std'  => 3
			);
    $page_configs[] = array(
				'name' => __( 'Override Theme Options', 'owlshop' ),
				'id'   => $prefix . 'override_options',
				'type' => 'title',
			);
   //  $page_configs[] = array(
			//     'name' => 'Override Logo',
			//     'desc' => 'Upload an image or enter an URL.',
			//     'id' => $prefix . 'logo_override',
			//     'type' => 'file',
			//     'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			// );
   //  $page_configs[] = array(
			// 	'name'    => __( 'Header Style', 'owlshop' ),
			// 	'id'      => $prefix . 'header_style',
			// 	'type'    => 'select',
			// 	'options' => array(
			// 		'global' => __( 'Use Global', 'owlshop' ),
			// 		'1'   => __( 'Style 1', 'owlshop' ),
			// 		'2'     => __( 'Style 2', 'owlshop' ),
			// 		// '3'     => __( 'Style 3', 'owlshop' ),
			// 		// '4'     => __( 'Style 4', 'owlshop' ),
			// 	),
			// 	'std' => 'global'
			// );
    $page_configs[] = array(
				'name'    => __( 'Footer Style', 'owlshop' ),
				'id'      => $prefix . 'footer_style',
				'type'    => 'select',
				'options' => $footers_option,
				'std' => 'global'
			);
	$meta_boxes['page_config'] = array(
		'id'         => 'page_config',
		'title'      => __( 'Page Config', 'owlshop' ),
		'pages'      => array( 'page' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => $page_configs
	);

	$meta_boxes['post_config'] = array(
		'id'         => 'post_config',
		'title'      => __( 'Post Config', 'owlshop' ),
		'pages'      => array( 'post' ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name' => __( 'Link Video or Audio', 'owlshop' ),
				'desc' => __( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'owlshop' ),
				'id'   => $prefix . 'post_video',
				'type' => 'oembed',
			),
			array(
			    'name' => 'Gallery Images',
			    'desc' => '',
			    'id' => $prefix . 'post_gallery',
			    'type' => 'file_list',
			    // 'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
			),
			array(
			    'name' => 'Status',
			    'desc' => '',
			    'id' => $prefix . 'post_status',
			    'type' => 'textarea',
			),
		)
	);

	// Add other metaboxes as needed

	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) ){
		get_template_part( 'framework/metabox/init' );
		get_template_part( 'framework/metabox/meta-custom' );
	}
}

<?php
function pgl_register_testimonial(){
	$labels = array(
		'name' => __( 'Testimonial', 'accessories' ),
		'singular_name' => __( 'Testimonial', 'accessories' ),
		'add_new' => __( 'Add New Testimonial', 'accessories' ),
		'add_new_item' => __( 'Add New Testimonial', 'accessories' ),
		'edit_item' => __( 'Edit Testimonial', 'accessories' ),
		'new_item' => __( 'New Testimonial', 'accessories' ),
		'view_item' => __( 'View Testimonial', 'accessories' ),
		'search_items' => __( 'Search Testimonials', 'accessories' ),
		'not_found' => __( 'No Testimonials found', 'accessories' ),
		'not_found_in_trash' => __( 'No Testimonials found in Trash', 'accessories' ),
		'parent_item_colon' => __( 'Parent Testimonial:', 'accessories' ),
		'menu_name' => __( 'Testimonials', 'accessories' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'description' => 'List Testimonial',
		'supports' => array( 'title', 'editor', 'thumbnail'),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'show_in_nav_menus' => false,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);
	register_post_type( 'testimonial', $args );
}
add_action( 'init','pgl_register_testimonial' );



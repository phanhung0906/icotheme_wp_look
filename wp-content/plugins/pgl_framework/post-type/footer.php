<?php
function pgl_register_footer(){
  $labels = array(
    'name' => __( 'Footer', 'accessories' ),
    'singular_name' => __( 'Footer', 'accessories' ),
    'add_new' => __( 'Add New Footer', 'accessories' ),
    'add_new_item' => __( 'Add New Footer', 'accessories' ),
    'edit_item' => __( 'Edit Footer', 'accessories' ),
    'new_item' => __( 'New Footer', 'accessories' ),
    'view_item' => __( 'View Footer', 'accessories' ),
    'search_items' => __( 'Search Footers', 'accessories' ),
    'not_found' => __( 'No Footers found', 'accessories' ),
    'not_found_in_trash' => __( 'No Footers found in Trash', 'accessories' ),
    'parent_item_colon' => __( 'Parent Footer:', 'accessories' ),
    'menu_name' => __( 'Footers', 'accessories' ),
  );

  $args = array(
      'labels' => $labels,
      'hierarchical' => true,
      'description' => 'List Footer',
      'supports' => array( 'title', 'editor' ),
      'public' => true,
      'show_ui' => true,
      'show_in_menu' => true,
      'menu_position' => 5,
      'show_in_nav_menus' => false,
      'publicly_queryable' => false,
      'exclude_from_search' => false,
      'has_archive' => false,
      'query_var' => true,
      'can_export' => true,
      'rewrite' => false
  );
  register_post_type( 'footer', $args );

  if($options = get_option('wpb_js_content_types')){
    $check = true;
    foreach ($options as $key => $value) {
      if($value=='footer') $check=false;
    }
    if($check)
      $options[] = 'footer';
  }else{
    $options = array('page','footer');
  }
  update_option( 'wpb_js_content_types',$options );

}

add_action('init','pgl_register_footer');
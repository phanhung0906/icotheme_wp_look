<?php

class PGL_Megamenu_Offcanvas extends Walker_Nav_Menu {
    /**
     * start_lvl function.
     *
     * @access public
     * @param mixed &$output
     * @param mixed $depth
     * @return void
     */
   public  function start_lvl(  &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat( "\t", $depth );
		
		$output	   .= "\n$indent<ul class=\"uk-nav-sub\">\n";
	}


	/**
	 * @see Walker::end_lvl()
	 * @since 3.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of page. Used for padding.
	 */
	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * start_el function.
	 *
	 * @access public
	 * @param mixed &$output
	 * @param mixed $item
	 * @param int $depth (default: 0)
	 * @param array $args (default: array())
	 * @param int $id (default: 0)
	 * @return void
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$hasChilds = $args->has_children;

		

		

		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$li_attributes = '';
		$class_names = $value = '';

		$classes = array();


		$classes[] = ($item->current || $item->current_item_ancestor) ? 'uk-active' : '';
		$classes[] = 'menu-item-' . $item->ID;
		
		//$classes[] = $item->additionclass;
		if(  $args->has_children){
			$classes[] = 'uk-parent';
		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

		
		$output .= $indent . '<li' . $id . $value . $class_names . $li_attributes . '>';

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * display_element function.
	 *
	 * @access public
	 * @param mixed $element
	 * @param mixed &$children_elements
	 * @param mixed $max_depth
	 * @param int $depth (default: 0)
	 * @param mixed $args
	 * @param mixed &$output
	 * @return void
	 */
	public function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
		else if ( is_object( $args[0] ) )
			$args[0]->has_children = ! empty( $children_elements[$element->$id_field] );

		$cb_args = array_merge( array(&$output, $element, $depth), $args);

		call_user_func_array(array(&$this, 'start_el'), $cb_args);


		$id = $element->$id_field;

		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {


			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					$cb_args = array_merge( array(&$output, $depth), $args);

					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}

				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
				unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			$cb_args = array_merge( array(&$output, $depth), $args);

			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
	
}

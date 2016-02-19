<?php

	class PGL_Shortcode_Sidebar extends PGL_Shortcode_Base{

		public function __construct( ){
			// add hook to convert shortcode to html.
			$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
			$this->key = 'pgl_'.$this->name;

			parent::__construct( );
		}


		/**
		 * $data format is object field of megamenu_widget record.
		 */
		public function getButton( $data=null ){
			$button = array(
				'icon'	 => 'sidebar',
				'title' => __( 'Sidebar Embeded','owlshop' ),
				'desc'  => __( 'Embeded widgets in a sidebar','owlshop' ),
				'name'  => $this->name
			);
			return $button;
		}

		public function getOptions( ){

		    $this->options[] = array(
		        'label' 	=> __('Sidebar', 'owlshop'),
		        'id' 		=> 'sidebar',
		        'type' 		=> 'sidebars',
		        'explain'	=> __( 'Display all widgets on selected sidebar', 'owlshop' )
	        );

	        $this->options[] = array(
		        'label' 	=> __('Addition Class', 'owlshop'),
		        'id' 		=> 'class',
		        'type' 		=> 'text',
		        'explain'	=> __( 'Using to make own style', 'owlshop' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
		}
	}
?>
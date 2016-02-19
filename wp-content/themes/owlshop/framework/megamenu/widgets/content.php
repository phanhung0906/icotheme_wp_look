<?php

	class PGL_Shortcode_Content extends PGL_Shortcode_Base{

		public function __construct( ){
			// add hook to convert shortcode to html.
			$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
			$this->key = 'pgl_'.$this->name;

			parent::__construct( );
		}
		
		public function getButton( $data=null ){
			$button = array(
				'icon'	 => 'content',
				'title' => __( 'Text Content','owlshop' ),
				'desc'  => __( 'A Block of HTML code','owlshop' ),
				'name'  => $this->name
			);
			return $button;
		}

		public function getOptions( ){
		    $this->options[] = array(
		        'label' 	=> __('Content', 'owlshop'),
		        'id' 		=> 'content',
		        'type' 		=> 'textarea',
		        'explain'	=> __( 'Put Content Here', 'owlshop' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );

	         $this->options[] = array(
		        'label' 	=> __('Addition Class', 'owlshop'),
		        'id' 		=> 'class',
		        'type' 		=> 'input',
		        'explain'	=> __( 'Using to make own style', 'owlshop' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
		}
	}
?>
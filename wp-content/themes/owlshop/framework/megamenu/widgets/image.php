<?php

	class PGL_Shortcode_Image extends PGL_Shortcode_Base{

		public function __construct( ){
			// add hook to convert shortcode to html.
			$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
			$this->key = 'pgl_'.$this->name;
			$this->excludedMegamenu = true;
			parent::__construct( );
		}
		
		public function getButton( $data=null ){
			$button = array(
				'icon'	 => 'image',
				'title' => __( 'Single Image','owlshop' ),
				'desc'  => __( 'Display Banner Image Or Ads Banner','owlshop' ),
				'name'  => $this->name
			);

			return $button;
		}

		public function getOptions( ){
		    $this->options[] = array(
		        'label' 	=> __('Image', 'owlshop'),
		        'id' 		=> 'image',
		        'type' 		=> 'image',
		        'default'	=> '',
		        'hint'		=> '',
		        );
		   $this->options[] = array(
		        'label' 	=> __('Link Image', 'owlshop'),
		        'id' 		=> 'link',
		        'type' 		=> 'text',
		        'default'	=> '',
	        );

		    $this->options[] = array(
		        'label' 	=> __('Addition Class', 'owlshop'),
		        'id' 		=> 'class',
		        'type' 		=> 'text',
		        'explain'	=> __( 'Using to make own style', 'owlshop' ),
		        'default'	=> '',
	        );
		}
	}
?>
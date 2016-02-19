<?php

if( PLG_WOOCOMMERCE_ACTIVED ){
	class PGL_Shortcode_Products extends PGL_Shortcode_Base{

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
				'icon'	 => 'image',
				'title' => __( 'Products', 'owlshop' ),
				'desc'  => __( 'Display Products', 'owlshop' ),
				'name'  => $this->name
			);

			return $button;
		}

		public function getOptions( ){
			$this->options[] = array(
				"type" => "text",
				"label" => __("Widget Title", 'owlshop'),
				"id" => "title",
				"default" => ''
			);
		    $this->options[] = array(
		        'label' 	=> __('Type','owlshop'),
		        'id' 		=> 'type',
		        'type' 		=> 'select',
		        'options'   => array(
		        		'top_rate' => 'Top Rate',
		        		'recent_product' => 'Recent Products',
		        		'featured_product' => 'Featured Products',
		        		'best_selling' => 'Best Selling'
		        	)
	        );
	        $this->options[] = array(
		        'label' 	=> __('Layout','owlshop'),
		        'id' 		=> 'layout',
		        'type' 		=> 'select',
		        'options'   => array('grid'=>'Grid','list'=>'List')
	        );

	        $this->options[] = array(
		        'label' 	=> __('Columns count','owlshop'),
		        'id' 		=> 'columns_count',
		        'type' 		=> 'select',
		        'options'   => array('4'=>4, '3'=>3, '2'=>2, '1'=>1)
	        );
	        $this->options[] = array(
				"type" => "text",
				"label" => __("Number of products to show", 'owlshop'),
				"id" => "number",
				"default" => '4'
			);
		}
	}
}
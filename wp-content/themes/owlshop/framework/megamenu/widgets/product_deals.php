<?php

if( PLG_WOOCOMMERCE_ACTIVED ){
	class PGL_Shortcode_Product_Deals extends PGL_Shortcode_Base{

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
				'title' => __( 'Product Deals','owlshop' ),
				'desc'  => __( 'Display Product  Deals','owlshop' ),
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
				"type" => "text",
				"label" => __("Number of products to show", 'owlshop'),
				"id" => "number",
				"default" => '4'
			);
		}
	}
}
<?php

	class PGL_Shortcode_Video extends PGL_Shortcode_Base{

		public function __construct( ){
			$this->name = str_replace( 'pgl_shortcode_','',strtolower( __CLASS__ ) );
			$this->key = 'pgl_'.$this->name;
			parent::__construct( );
		}

		/**
		 * $data format is object field of megamenu_widget record.
		 */
		public function getButton( $data=null ){
			$button = array(
				'icon'	 => 'video',
				'title' => 'Video' ,
				'desc'  => 'Embed Youtube/Vimeo Video',
				'name'  => $this->name
			);
			return $button;
		}

		public function getOptions( ){
		    $this->options[] = array(
		        'label' 	=> __('Video Link','owlshop'),
		        'id' 		=> 'link',
		        'type' 		=> 'embed',
		        'explain'	=> __( 'Enter Vimeo Link or Youtube Here','owlshop' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
	        $this->options[] = array(
		        'label' 	=> __('Addition Class', 'owlshop'),
		        'id' 		=> 'class',
		        'type' 		=> 'text',
		        'explain'	=> __( 'Using to make own style','owlshop' ),
		        'default'	=> '',
		        'hint'		=> '',
	        );
		}

		public function render( $atts ){
			$class = ($atts['class']!='')?" ".$atts['class']:"";
			$output='
				<div class="video-responsive'.$class.'">
					'.wp_oembed_get($atts["link"]).'
				</div>
			';
			return $output;
		}
	}
?>
<?php

class PGL_Shortcodes{

	protected $shortcodes = array();

	public static function getInstance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new PGL_Shortcodes();
		}
		return $_instance;
	}

	public function loadShortcodes(){
		$files = glob( PGL_MEGAMENU_WIDGET.'/*.php' );
		foreach( $files as $file ){
			require_once( $file );
			$tmp = str_replace( ".php", "", basename($file) );
			$class = 'PGL_Shortcode_'.ucfirst($tmp);

			if( class_exists($class) ){
				$this->shortcodes[$tmp] = new $class;
			}
		}
	}

	public function getButtons( $filter='menu' ){
		if( !$this->shortcodes ){
			$this->loadShortcodes();
		}
		$output = array();
		foreach( $this->shortcodes as $shortcode  ){
			$output[] = $shortcode->getButton();
		}
		return $output;
	}

	public function getShortcode( $type ){
		if(  isset($this->shortcodes[$type]) ){
			return $this->shortcodes[$type];
		}else {
			$file = ( PGL_MEGAMENU_WIDGET.'/'.$type.'.php' );
			if( file_exists($file) ){
				require_once( $file );
				$class = 'PGL_Shortcode_'.trim(ucfirst($type));
				$tmp = str_replace( ".php", "", basename($file) );
				if( class_exists($class) ){
					$this->shortcodes[$tmp] = new $class;
					return $this->shortcodes[$tmp];
				}
			}
		}
 		return null;
	}

	public function getButtonByType( $type, $data=array() ){

		if( $s=$this->getShortcode($type) ){

			$button =  ($s->getButton( $data ));

			return '
				<div class="pgl-shorcode-button btn btn-default">
					<div class="content">
						<h5 class="shortcode-title">'.$button['title'].'<br>(<span>'.$data->name.'</span>)</h5>
					</div>
				</div>
			';
		}
		return __( 'No button for this','owlshop' );
	}

	public function getLayout( $tpl ){

	}

	public function renderContent($type, $data ){
		if( $s=$this->getShortcode($type) ){
			return $s->render( $data );
		}
		return __( 'No data for this','owlshop' );
	}
}
?>
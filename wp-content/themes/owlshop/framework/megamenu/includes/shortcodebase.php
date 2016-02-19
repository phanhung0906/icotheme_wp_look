<?php

abstract class PGL_Shortcode_Base{

	protected $name;
	protected $options = array();
	protected $key;
	private $params;

	public function __construct( ){
		$this->params =  PGL_Params::getInstance();
	}

	public function getName(){
		return $this->name;
	}

	public function getButton( $data=null ){
		return array( 'title' => '' , 'desc'=>'' );
	}

	public function renderForm($type='',$id=0){
		$this->getOptions();
		$name = $this->setValueInput($id);
		$default = array(
			'default' => '',
			'hint'   => ''
		);
	?>
		<form id="pgl-shortcode-form" role="form">
			<div class="form-group">
				<label for="shortcode_name">Name:</label>
				<input value="<?php echo esc_attr( $name ); ?>" class="form-control" type="text" id="shortcode_name" name="shortcode_name">
			</div>
	<?php
		foreach($this->options as $option){

			$option = array_merge( $default, $option );
			
			if(is_array($option['default'])){
				var_dump($option['default']);
			}else{
				if( !trim($option['default']) ){
			 		$option['default'] = $option['hint'];
			 	}
			}
		 	
		 	$this->params->getParam($option);
		 }
	?>
			<span class="spinner spinner-button" style="float:left;"></span>
			<button type="button" class="btn btn-primary pgl-button-save"><?php echo __('Save','owlshop'); ?></button>
			<button type="button" class="btn btn-default pgl-button-back"><?php echo __('Back to list','owlshop'); ?></button>
			<input type="hidden" name="shortcodetype" value="<?php echo esc_attr( $type ); ?>">
			<input type="hidden" name="shortcodeid" value="<?php echo esc_attr( $id ); ?>">
		</form>
	<?php
	}

	private function setValueInput($id=0){
		$name ='';
		if($id==0){
			for($i=0;$i<count($this->options);$i++){
				if(!isset($this->options[$i]['default'])){
					$this->options[$i]['default']='';
				}
			}
		}else{
			$obj = PGL_Megamenu_Widget::getInstance();
			$values = $obj->getWidgetById($id);
			if( is_array($values->params) ){
				foreach ($values->params as $key => $value) {
					for($i=0;$i<count($this->options);$i++){
						if($this->options[$i]['id']==$key){
							if(is_array($value)){
								$value = implode(',',$value);
							}
							$this->options[$i]['default']=$value;
							break;
						}
					}
				}
			}
			$name=$values->name;
		}
		return $name;
	}

	/**
	 * this method check overriding layout path in current template
	 */
	public function render( $atts ){
		$tpl_default = PGL_MEGAMENU_TEMPLATE.'/'.$this->name.'.php';
		ob_start();
		if( is_file($tpl_default) )
			require $tpl_default;
		return ob_get_clean();
	}
}
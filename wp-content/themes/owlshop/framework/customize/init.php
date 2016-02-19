<?php 

define('PGL_CUSTOMIZE_PATH',get_template_directory() . '/framework/customize/');
define('PGL_CUSTOMIZE_URI',get_template_directory_uri() . '/framework/customize/');

require_once('controller.php');

class PGL_Customizer{
	private $sections;
	private $config;
	private $url;

	public static function getInstance(){
		static $_instance;
		if( !$_instance ){
			$_instance = new PGL_Customizer();
		}
		return $_instance;
	}

	public function __construct(){
		$this->url = PGL_CUSTOMIZE_URI . 'assets/';
		add_action( 'customize_register', array( $this, 'customize_register' ) );
		add_action( 'wp_head', array( $this, 'customize_css' ) );

		add_action('wp_enqueue_scripts',array($this,'makeGoogleWebfontLink'));

		$this->config = simplexml_load_file(PGL_CUSTOMIZE_PATH.'config.xml');
		add_action( 'admin_enqueue_scripts', array($this,'register_script') );
	}

	public function customize_register( $wp_customize ){
		$this->remove_default_section( $wp_customize );
		$this->customize_element( $wp_customize );
	}

	public function makeGoogleWebfontLink(){
		$protocol = ( ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 ) ? "https:" : "http:";
		foreach ( $this->config->section->setting as $setting ) {
			if( isset($setting->attributes()->typo) && $setting->attributes()->typo == 'true' ){
				$config = get_theme_mod( (string)$setting->id );
				if($config){
					$config = json_decode($config);
					wp_enqueue_style( 'customize_'.$setting->id , $protocol . '//fonts.googleapis.com/css?family='.$config->url );
					?>
						<style type="text/css">
							<?php echo esc_html($setting->selector); ?>{
								font-family: <?php echo esc_attr( $config->font ); ?>!important;
								font-weight: <?php echo esc_attr( $config->variants ); ?>;
							}
						</style>
					<?php
				}
			}
		}	
	}

	public function customize_css(){
		?>
		<style type="text/css">
			<?php
				foreach ($this->config->section as $section ) {
					foreach ( $section->setting as $setting ) {
						if( get_theme_mod( (string)$setting->id )!='' ){
							if( isset($setting->attributes()->css) && $setting->attributes()->css == 'true' && !isset($setting->attributes()->typo) && !isset($setting->attributes()->pattern) ){
								if( isset($setting->attributes()->important) && $setting->attributes()->important == 'true' ){
									echo "\t" . $setting->selector . '{' . $setting->property . ':' . get_theme_mod( (string)$setting->id ) .  '!important;}';
								}else{
									echo "\t" . $setting->selector . '{' . $setting->property . ':' . get_theme_mod( (string)$setting->id ) .';}';
								}
							}else if( isset($setting->attributes()->css) && isset($setting->attributes()->pattern) ){
								echo "\t" . $setting->selector . '{background-image:url(' . get_theme_mod( (string)$setting->id ) .')!important;background-repeat: repeat!important;}';
							}
						} 
					}
				}
			?>
		</style>
		<?php
	}

	private function customize_element( $wp_customize ){
		// wp_enqueue_style( 'customize-css' );
		wp_enqueue_style( 'customize-css' , $this->url . 'style.css' , array() );
		$priority = 200;
		foreach ($this->config->section as $section ) {
			// Add Sections
			$wp_customize->add_section( (string) $section->attributes()->id , array(
		   		'title'      => (string) $section->attributes()->title,
		   		'priority'   => $priority,
			) );

			

			if(isset($section->attributes()->color) && $section->attributes()->color=='true'){
				$this->add_main_color($wp_customize,$section);
			}

			foreach ( $section->setting as $setting ) {
				$wp_customize->add_setting(
					(string)$setting->id,
					array(
						'default'     => (string)$setting->default,
						'sanitize_callback' => 'owlshop_sanitize_custom',
					)
				);
				$class_control = $this->get_type($setting->type);
				$args_control = array(
									'label'      => (string)$setting->control->attributes()->label,
									'section'    => (string)$section->attributes()->id,
									'settings'   => (string)$setting->id
								);
				if( isset($setting->choices) ){
					$args_choice = array();
					foreach ($setting->choices->option as $choice) {
						$_id = (string)$choice->attributes()->value;
						$_label = (string)$choice;
						$args_choice[$_id] = $_label;
					}
					$args_control['choices'] = $args_choice;
					$args_control['type'] = (string) $setting->type;
				}
				$wp_customize->add_control(
					new $class_control(
						$wp_customize,
						(string)$setting->id.'_control',
						$args_control
					)
				);
			}
			$priority++;
		}
	}

	

	private function add_main_color($wp_customize,$section){

	}

	private function get_type( $type ){
		$class_control = 'WP_Customize_Control';
		switch ($type) {
			case 'color':
				$class_control = 'WP_Customize_Color_Control';
				break;
			case 'number':
				$class_control = 'Customize_Number_Control';
				break;
			case 'google-font':
				$class_control = 'Customize_Google_Font_Control';
				break;
			case 'pattern':
				$class_control = 'Customize_Pattern_Control';
				break;
			default:
				$class_control = 'WP_Customize_Control';
				break;
		}
		return $class_control;
	}

	public function register_script(){
		wp_register_script( 'customize-google-js' , $this->url . 'googlefont.js' , array('jquery') );
		wp_register_script( 'customize-pattern-js' , $this->url . 'pattern.js' , array('jquery') );
		
	}

	private function remove_default_section($wp_customize){
		$wp_customize->remove_section( 'title_tagline' );
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'widgets' );
		$wp_customize->remove_section( 'header_image' );
		$wp_customize->remove_section( 'background_image' );
		$wp_customize->remove_section( 'nav' );
		$wp_customize->remove_section( 'static_front_page');
	}
}

function owlshop_sanitize_custom( $value ) {
    return $value;
}

PGL_Customizer::getInstance();

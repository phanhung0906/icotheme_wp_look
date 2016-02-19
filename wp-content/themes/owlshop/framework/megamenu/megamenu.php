<?php

/*==========================================================================
Init Megamenu
==========================================================================*/
define( 'PGL_MEGAMENU_PATH', PGL_FRAMEWORK_PATH.'megamenu/' );

define( 'PGL_MEGAMENU_URL', PGL_FRAMEWORK_URI.'megamenu/' );

define( 'PGL_MEGAMENU_WIDGET', PGL_MEGAMENU_PATH .'widgets' );

define( 'PGL_MEGAMENU_TEMPLATE', PGL_MEGAMENU_PATH.'widget_templates' );

require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-base.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-base-front.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/params.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-offcanvas.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/megamenu-widget.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/shortcodebase.php' );
require_once ( PGL_MEGAMENU_PATH . 'includes/shortcodes.php' );


if(!class_exists('PGL_MegamenuEditor')){
	class PGL_MegamenuEditor{

		public static function getInstance(){
			static $_instance;
			if( !$_instance ){
				$_instance = new PGL_MegamenuEditor();
			}
			return $_instance;
		}

		public function __construct(){
			
			add_action('admin_menu', array( $this, 'adminLoadMenu') );
			add_action( 'admin_enqueue_scripts',array($this,'initScripts') );
			// add_action( 'wp_enqueue_scripts',array($this,'initFrontScripts') );
			add_action( 'admin_init', array( $this,'register_megamenu_setting') );

			$this->initAjaxMegamenu();
		}

		public function adminLoadMenu(){
			add_theme_page( 'owlshop', __("Megamenu Editor",'owlshop'), 'switch_themes', 'pgl_megamenu', array($this,'megaMenuPage') );
		}

		public function megaMenuPage(){
  			$wpos = PGL_Shortcodes::getInstance();
  			$widgets = PGL_Megamenu_Widget::getInstance()->getWidgets();

  			$menus = wp_get_nav_menus( array( 'orderby' => 'id' ) );
			$option_menu = array();
		    foreach ($menus as $menu_option) {
		    	$option_menu[$menu_option->term_id]=$menu_option->name;
		    }

			require PGL_MEGAMENU_PATH. 'template/editor.php';
		}

		public function ajax_load_list_widgets(){
			$widgets = PGL_Megamenu_Widget::getInstance()->getWidgets();
		?>
			<select class="toolcol-position toolbox-input toolbox-select" id="pgl-list-widgets" name="toolcol-position" data-name="position" data-placeholder="Select Module" >
                <option value=""></option>
                <?php foreach( $widgets as $w ) { ?>
                <option value="<?php echo esc_attr( $w->id ); ?>"><?php echo esc_html($w->name); ?></option>
                <?php } ?>
			</select>
		<?php
			exit();
		}

		public function initAjaxMegamenu(){
			add_action( 'wp_ajax_pgl_shortcode_button', array($this,'ajax_shortcode_button') );
			add_action( 'wp_ajax_pgl_shortcode_save', array($this,'ajax_shortcode_save') );
			add_action( 'wp_ajax_pgl_shortcode_delete', array($this,'ajax_shortcode_delete') );
			add_action( 'wp_ajax_pgl_list_shortcodes', array($this,'showListShortCodes') );
			add_action( 'wp_ajax_pgl_post_embed', array($this,'initAjaxPostEmbed') );

			add_action( 'wp_ajax_pgl_list_widgets', array($this,'ajax_load_list_widgets') );
			// Ajax Load Menu
			add_action( 'wp_ajax_pgl_megamenu_editor', array($this,'ajax_load_megamenu_admin') );
			// Save Config
			add_action( 'wp_ajax_pgl_save_megamenu_config', array($this,'ajax_save_megamenu_config') );
			// Remove Config
			add_action( 'wp_ajax_pgl_remove_megamenu_config', array($this,'ajax_remove_megamenu_config') );
			// Ajax Load Widget
			add_action( 'wp_ajax_pgl_load_widget', array($this,'ajax_load_widget_menu') );
			// Backup
			add_action( 'wp_ajax_pgl_megamenu_backup', array($this,'ajax_megamenu_backup') );
		}

		public function ajax_load_widget_menu(){
			if( isset($_POST['widget_id']) ){
				$widget =$_POST['widget_id'];
				$dwidgets = PGL_Megamenu_Widget::getInstance()->loadWidgets();
				$shortcode =   PGL_Shortcodes::getInstance();
				$output = '';
				$o = $dwidgets->getWidgetById( $widget );
				if( $o ){
					$output .= '<div class="pgl-module module" id="wid-'.$wid.'">';
					$output .= $shortcode->getButtonByType( $o->type, $o );
					$output .= '</div>';
				}
				echo '' . $output;
			}
			exit();
		}

		public function ajax_megamenu_backup(){
			global $wpdb;
            $backup_options = array();
           	$locations = get_nav_menu_locations();
           	

            $backup_options['menu'] = get_option( "PGL_MEGAMENU_DATA_".$locations['mainmenu'],'{}' );

            $sql = ' SELECT * FROM '.$wpdb->prefix.'megamenu_widgets ';
		 	$rows = $wpdb->get_results( $sql );
		 	$widgets = array();
		 	if( $rows ){
		 		foreach( $rows as $i => $row ){
		 			$widgets[] = $row;
		 		}
		 	}
		 	$backup_options['widgets'] = $widgets;

            $content = json_encode( $backup_options );
            
            header( 'Content-Description: File Transfer' );
            header( 'Content-type: application/txt' );
            header( 'Content-Disposition: attachment; filename="megamenu_options_backup_' . date( 'd-m-Y' ) . '.json"' );
            header( 'Content-Transfer-Encoding: binary' );
            header( 'Expires: 0' );
            header( 'Cache-Control: must-revalidate' );
            header( 'Pragma: public' );

            echo '' . $content;

            exit;
		}

		public function ajax_remove_megamenu_config(){
			$menuid = $_GET['menuid'];
			update_option( 'PGL_MEGAMENU_DATA_'.$menuid, '{}' );
			die();
		}

		public function ajax_load_megamenu_admin(){
			$menuid = isset($_GET['menuid'])?$_GET['menuid']:false;
		    $menu_build = new Megamenu_Buider($menuid);
			$menu_build_options = array('settings'=>json_decode( get_option( 'PGL_MEGAMENU_DATA_'.$menuid ),true),'params'=>array());
		    die($menu_build->output($menu_build_options));
		}

		public function ajax_save_megamenu_config(){
			$menuid = $_POST['menuid'];
			$config = stripslashes($_POST['config']);
			update_option( 'PGL_MEGAMENU_DATA_'.$menuid , $config );
			die();
		}

		public function initAjaxPostEmbed(){
			if ( !$_REQUEST['oembed_url'] )
				die();
			// sanitize our search string
			global $wp_embed;
			$oembed_string = sanitize_text_field( $_REQUEST['oembed_url'] );
			$oembed_url = esc_url( $oembed_string );
			$check_embed = wp_oembed_get(  $oembed_url  );
			if($check_embed==false){
				$check = false;
				$result ='not found';
			}else{
				$check = true;
				$result = $check_embed;
			}
			echo json_encode( array( 'check' => $check,'video'=>$result ) );
			die();
		}

		public function initScripts(){
			if( isset($_GET['page']) && $_GET['page']=='pgl_megamenu' ){
				wp_enqueue_style('megamenu_bootstrap_css',PGL_MEGAMENU_URL.'assets/css/bootstrap.min.css');
				wp_enqueue_style( 'pgl_chosen_css',PGL_MEGAMENU_URL.'assets/css/chosen.css');
				wp_enqueue_style( 'pgl_megamenu_css',PGL_MEGAMENU_URL.'assets/css/megamenu.css');
				wp_enqueue_style( 'pgl_megamenu_admin_css',PGL_MEGAMENU_URL.'assets/css/admin.css');
				wp_enqueue_style( 'pgl_awesome_css',PGL_MEGAMENU_URL.'assets/css/font-awesome.css');
				wp_enqueue_style( 'pgl_glyphicon_css',PGL_MEGAMENU_URL.'assets/css/glyphicon.css');
				
				wp_enqueue_script('base_bootstrap_js',PGL_MEGAMENU_URL.'assets/js/bootstrap.min.js');
				wp_enqueue_script('base_bootstrap_js',PGL_MEGAMENU_URL.'assets/js/bootstrap.min.js');
				wp_enqueue_script('pgl_json2_js',PGL_MEGAMENU_URL.'assets/js/json2.js');
				wp_enqueue_script('pgl_chosen_jquery_js',PGL_MEGAMENU_URL.'assets/js/chosen.jquery.min.js');
				wp_enqueue_script('pgl_megamenu_js',PGL_MEGAMENU_URL.'assets/js/megamenu.js',array());
				wp_enqueue_script('pgl_shortcode_js',PGL_MEGAMENU_URL.'assets/js/shortcode.js',array());
			}
		}

		public function register_megamenu_setting() {
			if( isset($_GET['page']) && $_GET['page'] == 'pgl_megamenu' && isset($_POST) ){
				remove_action( 'admin_enqueue_scripts', 'pgl_metabox_init_script' ,10 );
			}
		}


		public function ajax_shortcode_delete(){
			if(isset($_POST['id']) && $_POST['id']!=''){
				$obj = PGL_Megamenu_Widget::getInstance();
				$obj->delete($_POST['id']);
				echo esc_attr($_POST['id']);
			}else{
				echo false;
			}
			exit();
		}

		public function ajax_shortcode_button(){
			$obj = PGL_Shortcodes::getInstance();
			if(isset($_GET['id'])){
				$obj->getShortcode($_REQUEST['type'])->renderForm($_REQUEST['type'],$_GET['id']);
			}else{
				$obj->getShortcode($_REQUEST['type'])->renderForm($_REQUEST['type']);
			}
			exit();
		}

		public function ajax_shortcode_save(){
			$id = (int)$_POST['shortcodeid'];
			$obj = PGL_Shortcodes::getInstance();
			$type = $_POST['shortcodetype'];
			$name = $_POST['shortcode_name'];
			$inputs = serialize($_POST['pgl_input']);
			$response = array();
			if($id==0){
				$response['type']='insert';
				$response['id']= $this->insertMegaMenuTable($name,$type,$inputs);
				$response['title']=$name;
				$response['message'] = __('Widgets published','owlshop');
				$response['type_widget'] = $type;
			}else{
				$response['type']='update';
				$response['message'] = __('Widgets updated','owlshop');
				$response['title']=$name;
				$response['id']=$id;
				$this->updateMegaMenuTable($id,$name,$type,$inputs);
			}
			echo json_encode($response);
			exit();
		}

		public function updateMegaMenuTable($id,$name,$type,$shortcode){
			global $wpdb;
			$table_name = $wpdb->prefix . "megamenu_widgets";
			$wpdb->update(
				$table_name,
				array(
	                'name' => $name,
					'type' => $type,
					'params' => $shortcode,
				),
				array( 'id' => $id ),
				array(
					'%s',
					'%s',
					'%s'
				),
				array( '%d' )
			);
		}

		public function insertMegaMenuTable($name,$type,$shortcode){
			global $wpdb;
			$table_name = $wpdb->prefix . "megamenu_widgets";
			$wpdb->replace(
				$table_name,
				array(
	                'name' => $name,
					'type' => $type,
					'params' => $shortcode,
				),
				array(
			        '%s',
					'%s',
					'%s'
				)
			);
			return $wpdb->insert_id;
		}

		public function showListShortCodes(){
			$obj =   PGL_Shortcodes::getInstance();
			$shortcodes =$obj->getButtons();
			require PGL_MEGAMENU_PATH. 'template/shortcodes.php';
		 	exit();
		}

		public function initFrontScripts(){
			wp_enqueue_script('plg_megamenu',PGL_MEGAMENU_URL.'assets/js/megamenu-front.js',array(),PGL_THEME_VERSION,true);
		}
	}
	global $pgl_megamenu;
	$pgl_megamenu = new PGL_MegamenuEditor();
}

function pgl_megamenu( $config = array() ){
	global $theme_option;
	$config['animation'] = $theme_option['megamenu-animation'];
	$config['duration'] = $theme_option['megamenu-duration'];

	$menu_locations = get_nav_menu_locations();
	if( !isset( $menu_locations[$config['theme_location']] ) ){
		return;
	}else{
		$menu_id = $menu_locations[$config['theme_location']];
	}

    $menu_build = new Megamenu_Buider_Front( $menu_id );
	$menu_build_options = array('settings'=>json_decode( get_option( 'PGL_MEGAMENU_DATA_'.$menu_id ),true),'params'=>$config);
    echo '' . $menu_build->output($menu_build_options);
}





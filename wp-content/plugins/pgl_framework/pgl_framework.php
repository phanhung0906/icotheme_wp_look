<?php
/**
 * Plugin Name: PGL Framework
 * Plugin URI: http://wordpress.org/
 * Description: Framework
 * Version: 1.0
 * Author: Duc Pham Tien
 * Author URI: http://wordpress.org/
 * License: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: pgl_framework
 * Domain Path: /languages
 */


// include WXR file parsers
$path_plugin = dirname( __FILE__ );
$url_plugin = plugin_dir_url( __FILE__ );
define( 'PLG_VISUAL_COMPOSER_ACTIVED', in_array( 'js_composer/js_composer.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) );

define( 'PGL_PAGEBUILDER_URI', plugin_dir_url( __FILE__ ). 'pagebuilder/' );

require $path_plugin . '/widgets/widget-flickr.php';
require $path_plugin . '/widgets/widget-tabs.php';
require $path_plugin . '/widgets/widget-recent-post.php';
require $path_plugin . '/twitter/twitter.php';
require $path_plugin . '/post-type/footer.php';
require $path_plugin . '/post-type/testimonial.php';

// Page builder
if(PLG_VISUAL_COMPOSER_ACTIVED){
	require $path_plugin . '/pagebuilder/vc.php';
	$_path = $path_plugin.'/pagebuilder/class/';
	$files = glob($_path.'*.php');
	foreach ($files as $key => $file) {
		if(is_file($file)){
			require_once($file);
		}
	}
}


function pgl_framework_register_widgets() {
	register_widget( 'PGL_Flickr_Widget' );
	register_widget( 'PGL_Tweets_Widget' );
	register_widget( 'PGL_Tabs_Widget' );
	register_widget( 'PGL_Recent_Post_Widget' );
}

add_action( 'widgets_init', 'pgl_framework_register_widgets' );



/*==========================================================================
Social link
==========================================================================*/
add_shortcode( 'pgl_social', 'pgl_shortcode_social' );
function pgl_shortcode_social( $atts,$content=null ){
	global $theme_option;
	if(isset($theme_option['social_order']['enabled']['placebo'])) unset($theme_option['social_order']['enabled']['placebo']);
	ob_start();
?>
	<ul class="social-networks list-unstyled">
		<?php foreach ( $theme_option['social_order']['enabled'] as $key => $value): ?>
		<li>
			<a data-toggle="tooltip" data-original-title="<?php echo esc_attr($value); ?>" href="<?php echo esc_url( $theme_option[$key] ); ?>" target="_blank">
				<i class="fa <?php echo esc_attr($key); ?>"></i>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
<?php
	return ob_get_clean();
}

/*==========================================================================
Remove Shortcode gallery
==========================================================================*/
add_shortcode('gallery', '__return_false');
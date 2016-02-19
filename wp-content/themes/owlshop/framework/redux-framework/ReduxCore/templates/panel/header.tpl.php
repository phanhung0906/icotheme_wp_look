<?php
	/**
	 * The template for the panel header area.
	 *
	 * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
	 *
	 * @author 	Redux Framework
	 * @package 	ReduxFramework/Templates
	 * @version     3.4.4
	 */

$tip_title  = __('Developer Mode Enabled', 'owlshop');

if ($this->parent->dev_mode_forced) {
    $is_debug       = false;
    $is_localhost   = false;
    
    $debug_bit = '';
    if (Redux_Helpers::isWpDebug ()) {
        $is_debug = true;
        $debug_bit = __('WP_DEBUG is enabled', 'owlshop');
    }
    
    $localhost_bit = '';
    if (Redux_Helpers::isLocalHost ()) {
        $is_localhost = true;
        $localhost_bit = __('you are working in a localhost environment', 'owlshop');
    }
    
    $conjunction_bit = '';
    if ($is_localhost && $is_debug) {
        $conjunction_bit = ' ' . __('and', 'owlshop') . ' ';
    }
    
    $tip_msg    = __('Redux has enabled developer mode because', 'owlshop') . ' ' . $debug_bit . $conjunction_bit . $localhost_bit . '.';
} else {
    $tip_msg    = __('If you are not a developer, your theme/plugin author shipped with developer mode enabled. Contact them directly to fix it.', 'owlshop');
}

?>
<div id="redux-header">
	<?php if ( ! empty( $this->parent->args['display_name'] ) ) { ?>
		<div class="display_header">

			<?php if ( isset( $this->parent->args['dev_mode'] ) && $this->parent->args['dev_mode'] ) { ?>
                            <div class="redux-dev-mode-notice-container redux-dev-qtip" qtip-title="<?php echo esc_attr($tip_title); ?>" qtip-content="<?php echo esc_attr($tip_msg); ?>">
				<span class="redux-dev-mode-notice"><?php _e( 'Developer Mode Enabled', 'owlshop' ); ?></span>
                            </div>
                        <?php } ?>

			<h2><?php echo esc_html($this->parent->args['display_name']); ?></h2>

			<?php if ( ! empty( $this->parent->args['display_version'] ) ) { ?>
				<span><?php echo esc_html($this->parent->args['display_version']); ?></span>
                        <?php } ?>

		</div>
        <?php } ?>

	<div class="clear"></div>
</div>
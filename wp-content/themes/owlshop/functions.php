<?php
$my_theme = wp_get_theme();
define( 'PGL_THEME_VERSION', $my_theme->get( 'Version' ) );

require get_template_directory().'/framework/init.php';

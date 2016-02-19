
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<?php owlshop_wp_set_meta(); ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php global $theme_option; ?>
    <?php do_action('owlshop_before_wrapper'); ?>
    <!-- START Wrapper -->
	<div class="pgl-wrapper<?php echo apply_filters('pgl_style_layout',''); ?>">
        <div class="wrapper-inner">
    		<!-- HEADER -->
            <?php get_template_part( 'templates/header/header', apply_filters( 'owlshop_header_layout', 1 ) ); ?>
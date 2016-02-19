<?php
global $pgl_accordion_item;
$output = $title = '';

extract(shortcode_atts(array(
	'title' => __("Section", 'owlshop')
), $atts));
$pgl_accordion_item[]=array('title'=>$title,'content'=>wpb_js_remove_wpautop($content));


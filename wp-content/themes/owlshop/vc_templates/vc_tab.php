<?php
$output = $title = $tab_id = $tabicon = '';
extract(shortcode_atts($this->predefined_atts, $atts));
global $pgl_tab_item;
$pgl_tab_item[] = array('tab-id'=>$tab_id,'title'=>$title,'content'=>wpb_js_remove_wpautop($content));
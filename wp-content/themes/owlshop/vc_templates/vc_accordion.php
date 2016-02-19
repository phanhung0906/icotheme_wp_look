<?php
$output = $title = $interval = $el_class = $collapsible = $active_tab = '';
global $pgl_accordion_item;
$pgl_accordion_item = array();
//
extract(shortcode_atts(array(
    'title' => '',
    'interval' => 0,
    'el_class' => '',
    'collapsible' => 'no',
    'active_tab' => '1'
), $atts));
$id = owlshop_make_id();
wpb_js_remove_wpautop($content);
?>
<div class="panel-group" id="accordion-<?php echo esc_attr($id); ?>">
	<?php
	foreach($pgl_accordion_item as $key => $acc){
		$itemid = owlshop_make_id();
	?>
	<div class="panel panel-default">
		<div class="panel-heading" data-toggle="collapse" data-parent="#accordion-<?php echo esc_attr($id); ?>" href="#collapse-<?php echo esc_attr($itemid); ?>">
			<h4 class="panel-title">
				<?php echo esc_html($acc['title']); ?>
			</h4>
		</div>
		<div id="collapse-<?php echo esc_attr($itemid); ?>" class="panel-collapse collapse<?php echo ($key==0)?' in':'' ?>">
			<div class="panel-body">
				<?php echo wp_kses_post($acc['content']); ?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
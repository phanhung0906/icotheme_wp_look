<?php
global $pgl_tab_item;
$pgl_tab_item = array();
$output = $title = $interval = $el_class = '';
extract(shortcode_atts(array(
    'title' => '',
    'interval' => 0,
    'el_class' => ''
), $atts));
$_id = owlshop_make_id();
wpb_js_remove_wpautop($content);
$el_class = $this->getExtraClass($el_class);
$element = 'tabs-top';
if ( 'vc_tour' == $this->shortcode) $element = 'tabs-left';
?>

<div class="tabbable <?php echo esc_attr($element); ?><?php echo esc_attr($el_class); ?>">
	<ul class="nav nav-tabs">
		<?php foreach($pgl_tab_item as $key=>$tab){ ?>
			<li<?php echo ($key==0)?' class="active"':''; ?>>
				<a href="#tab-<?php echo esc_attr($tab['tab-id']); ?>" data-toggle="tab">
					<?php echo esc_html($tab['title']); ?>
				</a>
			</li>
		<?php } ?>
	</ul>

	<div class="tab-content">
		<?php foreach($pgl_tab_item as $key=>$tab){ ?>
			<div class="fade tab-pane<?php echo ($key==0)?' active in':''; ?>" id="tab-<?php echo esc_attr($tab['tab-id']); ?>">
				<?php echo $tab['content']; ?>
			</div>
		<?php } ?>
	</div>
</div>
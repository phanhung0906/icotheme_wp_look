<?php
$output = $title = $link = $size = $zoom = $type = $bubble = $el_class = '';
extract(shortcode_atts(array(
    'title' => '',
    'link' => '21.0173222,105.78405279999993',
    'size' => 300,
    'zoom' => 14,
    'type' => 'ROADMAP',
    'bubble' => '',
    'pancontrol'=>'',
    'zoomcontrol'=>'',
    'maptypecontrol'=>'',
    'streetscontrol'=>'',
    'el_class' => ''
), $atts));

wp_enqueue_script('theme-gmap-core');
wp_enqueue_script('theme-gmap-api');

$bubble = ($bubble!='' && $bubble!='0') ? 'false' : 'true';
$pancontrol = ($pancontrol!='' && $pancontrol!='0') ? 'false' : 'true';
$zoomcontrol = ($zoomcontrol!='' && $zoomcontrol!='0') ? 'false' : 'true';
$maptypecontrol = ($maptypecontrol!='' && $maptypecontrol!='0') ? 'false' : 'true';
$streetscontrol = ($streetscontrol!='' && $streetscontrol!='0') ? 'false' : 'true';
$_id = owlshop_make_id();
?>

<div id="map_canvas_<?php echo esc_attr($_id); ?>" class="map_canvas" style="width:100%;height:<?php echo esc_attr($size); ?>px;"></div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var stmapdefault = '<?php echo esc_js($link); ?>';
		var marker = {position:stmapdefault}
		jQuery('#map_canvas_<?php echo esc_js($_id); ?>').gmap({
			'scrollwheel':false,
			'zoom': <?php echo esc_js($zoom);  ?>  ,
			'center': stmapdefault,
			'mapTypeId':google.maps.MapTypeId.<?php echo esc_js($type); ?>,
			<?php if($bubble=='true'){ ?>
			'callback': function() {
				var self = this;
				self.addMarker(marker).click(function(){
				});
			},
			<?php } ?>
			panControl: <?php echo esc_js($pancontrol); ?>
		});
	});
	// jQuery(window).resize(function(){
	// 	var stct = new google.maps.LatLng('{$latitude}','{$longitude}');
	// 	jQuery('#map_canvas').gmap('option', 'center', stct);
	// });
</script>
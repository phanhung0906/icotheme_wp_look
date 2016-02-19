<?php
extract($atts);
$_id = owlshop_make_id();

?>

<div id="map_<?php echo esc_attr( $_id ); ?>" class="map_canvas" style="width:100%;height:<?php echo esc_attr($atts['height']); ?>px;"></div>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		var stmapdefault = '<?php echo esc_attr($atts['location']); ?>';
		var marker = {position:stmapdefault}
		jQuery('#map_<?php echo esc_attr($_id); ?>').gmap({
			'scrollwheel':false,
			'zoom': <?php echo esc_attr($zoom);  ?>  ,
			'center': stmapdefault,
			'mapTypeId':google.maps.MapTypeId.<?php echo esc_attr($type); ?>,
			'callback': function() {
				var self = this;
				self.addMarker(marker);
			},
		});
	});
</script>
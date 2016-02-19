
<div class="pgl-shortcodes">
	<ul class="wrapper clearfix">
		<?php foreach( $shortcodes as $key => $shortcode ){ ?>
		<li class="shortcode-col">
			<div class="pgl-shorcode-button btn btn-default" data-name="<?php echo esc_attr($shortcode['name']);?>">
				<div class="content">
					<div class="title"><?php echo esc_html($shortcode['title']); ?></div>
					<em><?php echo wp_kses_post($shortcode['desc']); ?></em>
				</div>
			</div>
		</li>
		<?php  } ?>
	</ul>
</div>
<script>
jQuery(".pgl-shortcodes").PGL_Shortcode();
</script>
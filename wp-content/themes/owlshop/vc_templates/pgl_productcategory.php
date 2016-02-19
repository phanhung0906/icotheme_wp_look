<?php

extract( shortcode_atts( array(
	'category' => '',
	'number'=>-1,
	'columns_count'=>'4',
	'icon' => '',
	'el_class' => '',
	'style'=>'grid'
), $atts ) );
$el_class = $this->getExtraClass($el_class);
switch ($columns_count) {
	case '5':
		$class_column='col-md-20 col-sm-4 col-xs-6';
		break;
	case '4':
		$class_column='col-sm-3 col-xs-6';
		break;
	case '3':
		$class_column='col-sm-4 col-xs-6';
		break;
	case '2':
		$class_column='col-sm-6 col-xs-6';
		break;
	default:
		$class_column='col-sm-12 col-xs-6';
		break;
}
$_id = owlshop_make_id();
if($category=='') return;
$_count = 1;

$loop = owlshop_woocommerce_query('',$number,$category);

if ( $loop->have_posts() ) : ?>
	<?php $_total = $loop->found_posts; ?>
	<div class="woocommerce<?php echo esc_attr($el_class); ?>">
		<div class="inner-content">
			<?php wc_get_template( 'product-layout/'.$style.'.php', array( 
						'show_rating' => true,
						'_id'=>$_id,
						'loop'=>$loop,
						'columns_count'=>$columns_count,
						'class_column' => $class_column,
						'_total'=>$_total,
						'number'=>$number
						 ) ); ?>
		</div>
	</div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>



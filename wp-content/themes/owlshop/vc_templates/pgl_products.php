<?php

extract( shortcode_atts( array(
	'number'=>-1,
	'columns_count'=>'4',
	'icon' => '',
	'el_class' => '',
	'type'=>'',
	'style'=>'grid'
), $atts ) );

switch ($columns_count) {
	case '5':
		$class_column='col-sm-20 col-xs-6';
		break;
	case '4':
		$class_column='col-sm-3 col-xs-6';
		break;
	case '3':
		$class_column='col-lg-4 col-md-4 col-sm-4 col-xs-6';
		break;
	case '2':
		$class_column='col-lg-6 col-md-6 col-sm-6 col-xs-6';
		break;
	default:
		$class_column='col-lg-12 col-md-12 col-sm-12 col-xs-6';
		break;
}

if($type=='') return;

global $woocommerce;

$_id = owlshop_make_id();
$_count = 1;
$show_rating = $is_deals = false;
if($type=='top_rate') $show_rating=true;
if($type=='deals') $is_deals=true;

$loop = owlshop_woocommerce_query($type,$number);

if ( $loop->have_posts() ) : ?>

	<?php $_total = $loop->found_posts; ?>
    <div class="woocommerce<?php echo (($el_class!='')?' '.$el_class:''); ?>">
		<div class="inner-content">
			<?php wc_get_template( 'product-layout/'.$style.'.php', array( 
						'show_rating' => $show_rating,
						'_id'=>$_id,
						'loop'=>$loop,
						'columns_count'=>$columns_count,
						'class_column' => $class_column,
						'_total'=>$_total,
						'number'=>$number,
						'is_deals' => $is_deals
						 ) ); ?>
		</div>
	</div>
<?php endif; ?>

<?php wp_reset_postdata(); ?>



<?php

extract( shortcode_atts( array(
	'title'=>'Testimonials',
	'el_class' => '',
	'skin'=>'skin-1'
), $atts ) );
$el_class = $this->getExtraClass($el_class);
$_id = owlshop_make_id();
$_count = 0;
$args = array(
	'post_type' => 'testimonial',
	'posts_per_page' => -1,
	'post_status' => 'publish'
);

$query = new WP_Query($args);
?>

<div class="box pgl-testimonial <?php echo esc_attr($el_class); ?>">
	<?php if($query->have_posts()){ ?>
		<div id="carousel-<?php echo esc_attr($_id); ?>" class="inner-content post-widget media-post-carousel carousel slide" data-ride="carousel">
			<div class="carousel-inner testimonial-carousel">
			<?php while($query->have_posts()):$query->the_post(); ?>
				<!-- Wrapper for slides -->
				<div class="item<?php echo (($_count==0)?" active":"") ?>">
					<blockquote>
						<?php the_content(); ?>
					</blockquote>
					<footer>
						<div class="image pull-left">
							<?php the_post_thumbnail( 'thumbnail' ); ?>
						</div>
						<h5 class="title"><?php the_title(); ?></h5>
						<span class="sub-title">Happy Client</span>
					</footer>
				</div>
				<?php $_count++; ?>
			<?php endwhile; ?>
			</div>
		</div>
	<?php } ?>
</div>
<?php wp_reset_postdata(); ?>
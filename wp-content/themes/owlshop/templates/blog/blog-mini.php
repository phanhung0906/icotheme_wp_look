
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container blog-mini'); ?>>
	<?php get_template_part( 'templates/single/meta' ); ?>
	<div class="blog-container-inner">
		<div class="row">
			<div class="col-sm-5"><?php do_action('owlshop_post_before_content'); ?></div>
			<div class="col-sm-7">
				<h2 class="blog-title">
					<a href="<?php the_permalink(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>

				<div class="blog-content">
					<?php echo owlshop_get_excerpt(60); ?>
				</div>
				<a href="<?php the_permalink(); ?>" class="btn btn-default"><?php echo __( 'Read More', 'owlshop' ); ?></a>
			</div>
		</div>
	</div>
</article>
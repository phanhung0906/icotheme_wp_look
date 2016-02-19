
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container blog-masonry col-sm-'.(12/apply_filters( 'pgl_blog_masonry_column', 3 )) ); ?>>
	<?php //get_template_part( 'templates/single/meta' ); ?>
	<div class="blog-container-inner">
		<?php do_action('owlshop_post_before_content'); ?>
		<div class="masonry-inner">
			<header>
				<div class="meta-heading">
					<h2 class="blog-title">
						<a href="<?php the_permalink(); ?>">
							<?php the_title(); ?>
						</a>
					</h2>
					<?php get_template_part( 'templates/single/meta' ); ?>
				</div>
			</header>
			<div class="blog-content">
				<?php echo owlshop_get_excerpt(25,'...'); ?>
			</div>
		</div>
	</div>
</article>
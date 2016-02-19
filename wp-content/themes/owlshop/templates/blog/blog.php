
<article id="post-<?php the_ID(); ?>" <?php (is_sticky()) ? post_class('blog-container stick_post') : post_class('blog-container'); ?>>
	
	<div class="blog-container-inner">
		<?php do_action('owlshop_post_before_content'); ?>
		<h2 class="blog-title">
			<?php if(is_sticky()){ ?>
				<span class="sticky pull-right"><?php _e('Sticky','owlshop'); ?></span>
			<?php } ?>
			<a href="<?php the_permalink(); ?>">
				<?php the_title(); ?>
			</a>
		</h2>
		<?php get_template_part( 'templates/single/meta' ); ?>
		<div class="blog-content">
			<?php the_excerpt(); ?>
		</div>
	</div>
</article>
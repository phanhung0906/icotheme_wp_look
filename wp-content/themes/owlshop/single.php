
<?php get_header( ); ?>
<?php owlshop_current_page_title_bar(); ?>
<div id="pgl-mainbody" class="container pgl-mainbody">
	<div class="row">
		<!-- MAIN CONTENT -->
		<div id="pgl-main-content" class="pgl-content clearfix <?php echo apply_filters( 'owlshop_main_class', '' ); ?>">
			<?php while ( have_posts() ) : the_post(); global $post; ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('single-container'); ?>>
					<div class="single-container-inner">
						<h1 class="blog-title"><span><?php the_title(); ?></span></h1>
						<?php get_template_part( 'templates/single/meta' ); ?>
						<?php do_action('pgl_post_before_content'); ?>
						<div class="post-content">
							<?php the_content(); ?>
							<?php wp_link_pages(); ?>
						</div>

						<div class="post-share text-center">
					        <?php get_template_part( 'templates/sharebox' ); ?>
					    </div>
					    
						<div class="author-about">
							<?php get_template_part( 'templates/single/author-bio' ); ?>
						</div>

						<?php get_template_part( 'templates/single/related' ); ?>

						<?php comments_template(); ?>
					</div>
				</article>
			<?php endwhile; ?>
		</div>
		<!-- //MAIN CONTENT -->
		<?php do_action('owlshop_sidebar_render'); ?>
	</div>
</div>

<?php get_footer(); ?>


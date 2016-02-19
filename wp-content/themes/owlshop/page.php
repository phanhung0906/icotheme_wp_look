<?php
	global $post;
	$post_id = $post->ID;
	$is_breadcrumb = get_post_meta( $post_id, '_pgl_show_breadcrumb', true ) ? get_post_meta( $post_id, '_pgl_show_breadcrumb', true ) : 'yes';
	$is_title = get_post_meta( $post_id, '_pgl_show_title', true ) ? get_post_meta( $post_id, '_pgl_show_title', true ) : 'yes';
?>

<?php get_header( ); ?>
<?php if($is_breadcrumb=='yes') owlshop_current_page_title_bar(); ?>
<div id="pgl-mainbody" class="container pgl-mainbody">
	<div class="row">
		<!-- MAIN CONTENT -->
		<div id="pgl-main-content" class="pgl-content <?php echo apply_filters( 'owlshop_main_class', '' ); ?>">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('pgl-content'); ?>>
					<?php 
						if($is_title)
							the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header>' ); 
					?>
					<?php the_content(); ?>
				</article><!-- #post -->
				<?php comments_template(); ?>
			<?php endwhile; ?>
		</div>
		
		<?php do_action('owlshop_sidebar_render'); ?>

	</div>
</div>
<?php get_footer(); ?>
<?php
/*
*Template Name: Visual Composer Template
*
*/
$post_id = $post->ID;
?>
<?php get_header(); ?>

<div id="pgl-mainbody" class="pgl-mainbody visual-composer">
	<?php /* The loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="pgl-content" <?php post_class( 'pgl-content visual-layout' ); ?>>
			<?php the_content(); ?>
		</div>
		<?php //comments_template(); ?>
	<?php endwhile; ?>
</div>
<?php get_footer(); ?>
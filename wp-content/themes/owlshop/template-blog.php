<?php
/*
*Template Name: Blog
*
*/

// Meta Configuration
$post_id = $post->ID;
$post_per_page = get_post_meta( $post_id, '_pgl_blog_count', true );

$is_breadcrumb = get_post_meta( $post_id, '_pgl_show_breadcrumb', true ) ? get_post_meta( $post_id, '_pgl_show_breadcrumb', true ) : 'yes';
$is_title = get_post_meta( $post_id, '_pgl_show_title', true ) ? get_post_meta( $post_id, '_pgl_show_title', true ) : 'yes';

$blog_skin = get_post_meta( $post_id, '_pgl_blog_skin', true );
$class_content_inner = $_js = '';
if($blog_skin=='mini'){
	add_filter( 'pgl_gallery_image_size' , create_function('', 'return "blog-mini";') );
	add_filter( 'pgl_single_image_size' , create_function('', 'return "blog-mini";') );
}else if( $blog_skin=='masonry' ){
	$masonry_column = get_post_meta( $post_id, '_pgl_blog_masonry_column_count', true );
	if($masonry_column>2){
		add_filter( 'pgl_gallery_image_size' , create_function('', 'return "blog-mini";') );
		add_filter( 'pgl_single_image_size' , create_function('', 'return "blog-mini";') );
	}
	add_filter( 'pgl_blog_masonry_column', create_function('', 'return '.$masonry_column.';') );
	$class_content_inner = ' masonry';
	// Load JS
	wp_enqueue_script( 'isotope' );
	ob_start();
	?>
<script>
	jQuery(window).load(function() {
		jQuery('.pgl-content-inner').isotope({
			// options
			itemSelector: '.blog-masonry',
			layoutMode: 'masonry'
		});
	});

</script>
	<?php
	$_js = ob_get_clean();
}

if(is_front_page()) {
	$paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$args = array(
	'post_type' => 'post',
	'paged' => $paged,
	'posts_per_page'=>$post_per_page
);
$blog = new WP_Query($args);

?>

<?php get_header( ); ?>
<?php if($is_breadcrumb) owlshop_current_page_title_bar(); ?>
<div id="pgl-mainbody" class="container pgl-mainbody">
	<div class="row">
		<!-- MAIN CONTENT -->
		<div id="pgl-main-content" class="pgl-content clearfix <?php echo apply_filters( 'owlshop_main_class', '' ); ?>">
			<?php 
					if($is_title)
						the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header>' ); 
				?>
			<div class="pgl-content-inner row clearfix<?php echo esc_attr($class_content_inner); ?>">
				
				<?php if ( $blog->have_posts() ) : ?>
					<?php /* The loop */ ?>
					<?php while ( $blog->have_posts() ) : $blog->the_post(); ?>
						<?php get_template_part( 'templates/blog/blog', $blog_skin); ?>
					<?php endwhile; ?>
				<?php else : ?>
					<?php get_template_part( 'templates/none' ); ?>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
				<?php echo "\t" . $_js; ?>
			</div>
			<?php owlshop_pagination($prev = '&laquo;', $next = '&raquo;', $pages=$blog->max_num_pages); ?>
		</div>
		<!-- //END MAINCONTENT -->
		
		<?php do_action('owlshop_sidebar_render'); ?>

	</div>
</div>

<?php get_footer(); ?>
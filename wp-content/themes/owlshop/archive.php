<?php get_header(); ?>

<?php owlshop_current_page_title_bar(); ?>
<div id="pgl-mainbody" class="container pgl-mainbody">
    <div class="row">
        <!-- MAIN CONTENT -->
        <div id="pgl-main-content" class="pgl-content clearfix <?php echo apply_filters( 'owlshop_main_class', '' ); ?>">
            <div class="pgl-content-inner clearfix">
            <?php  if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'templates/blog/blog'); ?>
                    <?php endwhile; ?>
            <?php else : ?>
                <?php get_template_part( 'templates/none' ); ?>
            <?php endif; ?>
            </div>
            <?php owlshop_pagination($prev = '&laquo;', $next = '&raquo;'); ?>
        </div>
        <!-- //END MAINCONTENT -->
        <?php do_action('owlshop_sidebar_render'); ?>
    </div>
</div>

<?php get_footer(); ?>
<?php get_header(); ?>

<div id="pgl-mainbody" class="container pgl-mainbody">
    <div class="row">
        <!-- MAIN CONTENT -->
        <div id="pgl-main-content" class="pgl-content clearfix <?php echo apply_filters( 'owlshop_main_class', '' ); ?>">
            <div class="pgl-content-inner clearfix">
            <?php  if ( have_posts() ) : ?>
                    <?php while ( have_posts() ) : the_post(); ?>
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
                                    <?php
                                        /* translators: %s: Name of current post */
                                        the_content( sprintf(
                                            __( 'Continue reading %s', 'owlshop' ),
                                            the_title( '<span class="screen-reader-text">', '</span>', false )
                                        ) );

                                        wp_link_pages( array(
                                            'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'owlshop' ) . '</span>',
                                            'after'       => '</div>',
                                            'link_before' => '<span>',
                                            'link_after'  => '</span>',
                                            'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'owlshop' ) . ' </span>%',
                                            'separator'   => '<span class="screen-reader-text">, </span>',
                                        ) );
                                    ?>
                                </div>
                            </div>

                        </article>
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
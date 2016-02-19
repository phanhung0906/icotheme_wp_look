<?php
    global $post,$_config;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container blog-visual blog-visual-2 row-full col-sm-'.$_config['column'] ); ?>>
    <?php //get_template_part( 'templates/single/meta' ); ?>
    <div class="blog-container-inner row">
        <div class="post-thumb col-sm-6">
            <?php the_post_thumbnail('blog-mini'); ?>
        </div>
        <div class="visual-inner col-sm-6">
            <header>
                <div class="meta-heading">
                    <h2 class="blog-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <ul class="visual-meta">
                        <li class="meta-author">
                            <?php _e('by','owlshop'); ?> <?php the_author_posts_link(); ?>
                        </li>
                        <li class="meta-category">
                            <?php _e('in','owlshop'); ?> <?php the_category( ', ' ); ?>
                        </li>
                        <li class="meta-comment">
                            <i class="fa fa-comment-o"></i>
                            <?php comments_popup_link(' 0', ' 1', ' %'); ?>
                        </li>
                    </ul>
                </div>
            </header>
            <div class="post-content">
                <?php echo owlshop_get_excerpt(20,'...'); ?>
            </div>
        </div>
    </div>
</article>
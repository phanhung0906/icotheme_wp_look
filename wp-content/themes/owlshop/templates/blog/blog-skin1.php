
<article id="post-<?php the_ID(); ?>" <?php post_class('blog-container blog-visual row-full col-xs-12' ); ?>>
    <?php //get_template_part( 'templates/single/meta' ); ?>
    <div class="blog-container-inner row">
        <div class="post-thumb col-sm-6">
            <?php the_post_thumbnail('blog-list'); ?>
        </div>
        <div class="visual-inner col-sm-6">
            <header>
                <div class="meta-date pull-left">
                    <span>
                        <span class="text-center">
                            <span class="d"><?php echo the_time( 'd' ); ?></span><br>
                            <span class="my"><?php the_time( 'M Y' ); ?></span>
                        </span>
                    </span>
                </div>
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
            <div class="blog-content">
                <?php echo owlshop_get_excerpt(60); ?>
            </div>
        </div>
    </div>
</article>
<?php //get_template_part( 'templates/single/meta' ); ?>
<div class="blog-container-inner">
    <div class="post-thumb">
        <?php the_post_thumbnail('blog-list'); ?>
    </div>
    <div class="visual-inner">
        <h2 class="blog-title">
            <a href="<?php the_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </h2>
        <div class="blog-content">
            <?php echo owlshop_get_excerpt(15,'...'); ?>
            <a href="<?php the_permalink(); ?>"><?php _e('Read more','owlshop'); ?></a>
        </div>
    </div>
</div>
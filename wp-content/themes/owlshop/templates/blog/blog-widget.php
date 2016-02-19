<article class="item-post clearfix">
    <?php
        if(has_post_thumbnail()){
    ?>
    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail( 'thumbnail' ); ?>
    </a>
    <?php } ?>
    <h6>
        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h6>
    <p class="post-date">
        <i class="fa fa-eye"></i>
        <?php echo owlshop_get_post_views(get_the_ID()).__(' View(s)', 'owlshop'); ?>
    </p>
</article>
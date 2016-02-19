<div class="blog-meta">
	<span class="author-link"><?php _e('By ','owlshop');the_author_posts_link(); ?></span>
	<span class="post-category">  <?php _e('in ','owlshop');the_category( ', ' ); ?></span>
	<span class="published"> 
		<i class="fa fa-clock-o"></i> 
		<?php the_time( 'M d, Y' ); ?>
	</span>
	<span class="comment-count">
		<i class="fa fa-comment-o"></i>
		<?php comments_popup_link(__(' 0 comment', 'owlshop'), __(' 1 comment', 'owlshop'), __(' % comments', 'owlshop')); ?>
	</span>
</div>
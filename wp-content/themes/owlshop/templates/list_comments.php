<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="the-comment">
		<div class="avatar">
			<?php echo get_avatar($comment, 54); ?>
		</div>

		<div class="comment-box">

			<div class="comment-author meta">
				<strong><?php echo get_comment_author_link() ?></strong>
				<br>
				<small>
					<?php echo human_time_diff( get_comment_date('U'), current_time('timestamp') ) . __(' ago', 'owlshop'); ?>
					<?php edit_comment_link(__('Edit', 'owlshop'),'  ','') ?>
					<?php comment_reply_link(array_merge( $args, array( 'reply_text' => __('Reply', 'owlshop'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</small>
			</div>

			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php echo __('Your comment is awaiting moderation.', 'owlshop') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
		</div>

	</div>
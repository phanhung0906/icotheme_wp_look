<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<div class="input-group">
		<input type="text" class="form-control" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php echo __( 'Search for products', 'woocommerce' ); ?>" />
		<span class="input-group-btn">
			<input type="submit" class="btn btn-primary" id="searchsubmit" value="<?php echo esc_attr__( 'Search', 'woocommerce' ); ?>" />
		</span>
		<input type="hidden" name="post_type" value="product" />
	</div>
</form>